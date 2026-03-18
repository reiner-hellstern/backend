<?php

namespace App\Http\Controllers\templates;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Route;

class TemplateBaseController extends Controller
{
    public function index()
    {
        $route = Route::currentRouteName();
        $pdf = Pdf::loadView('templates.' . $route);

        return $pdf->stream($route . '.pdf');
    }

    protected function renderPdf($view, $data, $primaryHeaderText, $primarySubheadlineText, ?string $secondaryHeaderText = null, $secondarySubheadlineText = '', ?bool $lessMarginTop = false)
    {
        $data['include'] = $view;
        $data['headline'] = $primaryHeaderText;
        $data['subheadline'] = $primarySubheadlineText;
        $data['lessMarginTop'] = $lessMarginTop;

        if ($secondaryHeaderText == null) {
            $secondaryHeaderText = $primaryHeaderText;
        }

        $pdf = Pdf::loadView('pdf.components.page', $data);
        $pdf->render();

        $canvas = $pdf->getCanvas();
        $this->addPageNumbersToCanvas($canvas);
        $this->addSecondaryHeadersToCanvas($canvas, $primaryHeaderText, $secondaryHeaderText, $secondarySubheadlineText);

        return $pdf->stream();
    }

    protected function addPageNumbersToCanvas($canvas)
    {
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            // Access ersteller from laravel's session store
            $ersteller = session('ersteller');

            // Get Canvas height
            $h = $canvas->get_height();
            // Define reusable text
            $text = "Seite $pageNumber/$pageCount";
            // text size
            $size = 9;
            // get font
            $font = $fontMetrics->getFont('canada-type-gibson');
            // calc height of given text in given font
            $textHeight = $fontMetrics->getFontHeight($font, $size);
            // calc width of text
            $textWidth = $fontMetrics->getTextWidth($text, $font, $size);

            // calc y position and add a margin (8pt) to bottom
            $y = $h - $textHeight - 8;

            // calc x for right text with right margin (26.5pt)
            $rightX = 595.28 - $textWidth - 26.5;

            $canvas->text(
                $rightX,
                $y,
                "Seite $pageNumber/$pageCount",
                'canada-type-gibson',
                $size,
                [0, 0, 0]
            );

            $dateToday = date('d.m.Y');
            $canvas->text(
                62.5,
                $y,
                "Erstellt am $dateToday von $ersteller",
                'canada-type-gibson',
                $size,
                [0, 0, 0]
            );
        });
    }

    protected function addSecondaryHeadersToCanvas($canvas, $primaryHeaderText, $secondaryHeaderText, $secondarySubheadlineText)
    {
        if ($secondaryHeaderText === null) {
            $secondaryHeaderText = $primaryHeaderText;
        }

        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($secondaryHeaderText, $secondarySubheadlineText) {
            if ($pageNumber > 1) {
                $gibsonRegular = $fontMetrics->getFont('canada-type-gibson');
                $canvas->text(
                    62.5, // x
                    62.66 + 7.8, // y
                    $secondarySubheadlineText,
                    $gibsonRegular,
                    12,
                    [0, 0, 0]
                );

                $gibsonMedium = $fontMetrics->getFont('canada-type-gibson', '500');

                $lines = [];
                $text = json_decode($secondaryHeaderText);

                foreach ($text as $idx => $line) {
                    array_push($lines, $text[$idx]);
                }

                // Limit to 2 lines max
                $lines = array_slice($lines, 0, 2);
                // Calculate starting Y position to grow text from the bottom
                $y = 22.66 + (2 - count($lines)) * 20;

                foreach ($lines as $idx => $line) {
                    $txt = $lines[$idx]->text;
                    $size = $lines[$idx]->smaller ? 16 : 18;

                    $canvas->text(
                        62.5, // x
                        $y, // y
                        $txt,
                        $gibsonMedium,
                        $size,
                        [0, 0, 0]
                    );
                    $y += $size + 2;
                }

                // $imgWidth = 193;
                $imgWidth = 100;
                // $imgHeight = 142;
                $imgHeight = 41.75;
                $imgX = 595.28 - $imgWidth - 26.5;
                $imgY = 50.0;
                $canvas->image(
                    public_path('assets/DRC_Logo_Folgeseiten.jpg'),
                    $imgX, // x
                    22.66, // y
                    $imgWidth, // w
                    $imgHeight // h
                );
            }
        });
    }
}
