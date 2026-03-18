<?php

namespace App\Utilities;

class PDFCalculation
{
    public static function calculateTextWidth($fontMetrics, $text, $size)
    {
        return $textWidth = $fontMetrics->getTextWidth($text, 'canada-type-gibson', $size);
    }
}
