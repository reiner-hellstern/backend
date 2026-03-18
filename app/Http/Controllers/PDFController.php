<?php

namespace App\Http\Controllers;

use App\Http\Controllers\templates\dokumente\KuendigungMitgliedschaftController;
use App\Models\Person;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Log;

class PDFController extends Controller
{
    public function triggerPDFGeneration(Request $request)
    {

        // Get the form data from the request
        $formData = $request->getContent();

        Log::info($formData);

        // Render the Blade template as a PDF
        // $pdf = View::make('dokumente.kuendigung-drc-mitgliedschaft', $formData)->render();

        // $pdfController = new KuendigungMitgliedschaftController();
        // $pdf = $pdfController->show($formData);

        $routingController = new RoutingController();

        $decodedRequestContent = json_decode($request->getContent());

        // Store the ersteller in laravel's session store (accessed in TemplateBaseController)
        session(['ersteller' => $decodedRequestContent->ersteller]);

        $pdf = null;

        switch ($decodedRequestContent->templateType) {
            case 'pruefungen':
                $pdf = $routingController->pruefungen($decodedRequestContent->documentIdentifier, $formData);
                break;
            case 'oeffentliche':
                $pdf = $routingController->oeffentliche($decodedRequestContent->documentIdentifier, $formData);
                break;
            case 'dokumente':
                $pdf = $routingController->dokumente($decodedRequestContent->documentIdentifier, $formData);
                break;
            default:
                // code...
                break;
        }

        // Return the PDF as a response
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment',
            'Access-Control-Expose-Headers' => 'Content-Disposition',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {

        $data = [
            'titel' => 'Deckbescheinigung',
            'date' => date('m/d/Y'),
            'seiten' => '10',
            'pruefung' => [
                'label' => 'Prüfungslabel',
                'text' => 'Das ist der Text für die Prüfung...',
            ],
            'label' => 'Das ist eine Label',
            'text' => 'Das ist der Text der Textarea',

        ];

        $id = Auth::id();

        $person = User::find($id)->person;

        //   {"titel":"Deckbescheinigung","date":"07\/19\/2022","seiten":10,"label":"Das ist ine Label","text":"Das ist der Text der Textarea","pruefung":{"label":"Das ist ine Label","text":"Das ist der Text der Textarea"},"person":{"id":1034,"mitglied_id":1034,"zwinger_id":1144,"mitgliedsnummer":"3836","mitgliedsart":"0","anrede":"Frau","geschlecht":"W","adelstitel":"","akademischetitel":"","vorname":"Gabriele","nachname_praefix":"","nachname":"Orr\u00f9","geboren":"01.09.1989","post_anrede":"e Frau","post_name":"Gabriele Orr\u00f9","post_co":"","strasse":"Holnisser Weg 34","adresszusatz":"","postleitzahl":"24977","ort":"Grundhof","postfach_plz":"","postfach_nummer":"","standard":0,"land":"Deutschland","laenderkuerzel":"DE","telefon_1":"04636 1752","telefon_2":"","telefon_3":"","email_1":"gabi-duke@gmx.de","email_2":"","website_1":"www.toller.de","website_2":"","kommentar":"","zwingernummer":"2044","zwingername":"Toll Free...","eintrittsdatum":"1989-09-01 00:00:00","austrittsdatum":"0000-00-00 00:00:00","nachname_ohne_praefix":"Orr\u00f9","dsgvo":null,"zwingername_praefix":"Toll Free","zwingername_suffix":"","nachname_ehemals":null,"updated_at":null,"created_at":null}}

        $data = [
            'titel' => 'Deckbescheinigung',
            'date' => date('m/d/Y'),
            'seiten' => 10,
            'label' => 'Das ist ein Label',
            'text' => 'Das ist der Text der Textarea',
            'pruefung' => [
                'label' => 'Das ist ine Label',
                'text' => 'Das ist der Text der Textarea',
            ],
            'person' => $person,
        ];

        $pdf = PDF::loadView('pdf.users', $data);

        return $pdf->download('drc-test.pdf');
    }

    public function templatePDF()
    {
        $users = User::get();

        $data = [
            'titel' => 'Deckbescheinigung',
            'date' => date('m/d/Y'),
            'users' => $users,
            'seiten' => 10,
            'pruefung' => [
                'label' => 'Prüfungslabel',
                'text' => 'Das ist der Text für die Prüfung...',
            ],
            'label' => 'Das ist eine Label',
            'text' => 'Das ist der Text der Textarea',

        ];

        $pdf = PDF::loadView('pdf.template', $data);

        return $pdf->download('drc-template.pdf');
    }

    public function deckbescheinigung(Request $request)
    {
        $id = Auth::id();
        $person = User::find($id)->person;
        $zuechter = json_decode($request->input('zuechter'));
        $wurf = json_decode($request->input('wurf'));
        $zwinger = $person->zwinger; //  json_decode($request->input('zwinger'));
        $deckrueden = json_decode($request->input('deckrueden'));
        $zuchthuendin = json_decode($request->input('zuchthuendin'));

        $optionen = app(\App\Http\Controllers\OptionenController::class)->index();

        $data = [
            'titel' => 'Deckbescheinigung',
            'date' => date('m/d/Y'),
            'seiten' => '10',
            'pruefung' => [
                'label' => 'Prüfungslabel',
                'text' => 'Das ist der Text für die Prüfung...',
            ],
            'label' => 'Das ist eine Label',
            'text' => 'Das ist der Text der Textarea',
            'zuechter' => $zuechter,
            'zwinger' => $zwinger,
            'deckrueden' => $deckrueden,
            'zuchthuendin' => $zuchthuendin,
            'wurf' => $wurf,
            'person' => $person,
            'optionen' => $optionen,
        ];
        //  return  $data['deckrueden'];
        //  return $deckrueden[0]->pruefungen_extern->val;

        $pdf = PDF::loadView('pdf.deckbescheinigung', $data);

        return $pdf->download('drc-deckbescheinigung.pdf');
    }

    public function zustimmung_zuchtbuchuebernahme(Request $request)
    {
        $id = Auth::id();
        $person = json_decode($request->input('person'));
        $hund = json_decode($request->input('hund'));

        $data = [
            'titel' => 'Zustimmung Zuchtbuchübernahme',
            'date' => date('m/d/Y'),
            'seiten' => 1,
            'person' => $person,
            'hund' => $hund,
        ];
        // return  $data;
        //  return $deckrueden[0]->pruefungen_extern->val;

        $pdf = PDF::loadView('pdf.zustimmung.zuchtbuchuebernahme', $data);

        return $pdf->download('drc-zustimmung-zuchtbuchuebernahme.pdf');
    }

    public function zustimmung_ahnentafelzweitschrift(Request $request)
    {
        $id = Auth::id();
        $person = json_decode($request->input('person'));
        $hund = json_decode($request->input('hund'));

        $data = [
            'titel' => 'Zustimmung zur Ahnentafel Zweitschrift',
            'date' => date('m/d/Y'),
            'seiten' => 1,
            'person' => $person,
            'hund' => $hund,

        ];
        //  return  $data['deckrueden'];
        //  return $deckrueden[0]->pruefungen_extern->val;

        $pdf = PDF::loadView('pdf.zustimmung.zuchtbuchuebernahme', $data);

        return $pdf->download('drc-zustimmung-zuchtbuchuebernahme.pdf');
    }

    public function zustimmung_zuchtzulassung(Request $request)
    {
        $id = Auth::id();
        $person = json_decode($request->input('person'));
        $hund = json_decode($request->input('hund'));

        $data = [
            'titel' => 'Zustimmung zur Ahnentafel Zweitschrift',
            'date' => date('m/d/Y'),
            'seiten' => 1,
            'person' => $person,
            'hund' => $hund,

        ];
        //  return  $data['deckrueden'];
        //  return $deckrueden[0]->pruefungen_extern->val;

        $pdf = PDF::loadView('pdf.zustimmung.zuchtbuchuebernahme', $data);

        return $pdf->download('drc-zustimmung-zuchtbuchuebernahme.pdf');
    }
}
