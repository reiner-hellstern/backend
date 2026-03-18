<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;
use App\Models\Zwinger;

class ZwingerKontaktdatenAendernController extends TemplateBaseController
{
    public function show()
    {
        $zwingerNeu = new Zwinger();
        $zwingerNeu->email_1 = 'meine-neue@email.de';
        $zwingerNeu->telefon_1 = '012345 6712399';
        $zwingerNeu->website_1 = 'www.neue-website.de';

        return $this->renderPdf(
            'dokumente.zwinger-kontaktdaten-aendern',
            [
                'zwingerNeu' => $zwingerNeu,
            ],
            '[{"text": "Änderungsmeldung","smaller": false}, {"text": "Zwinger-Kontaktdaten", "smaller": false}]',
            '– Meldung neue ' . collect([$zwingerNeu->email_1, $zwingerNeu->telefon_1, $zwingerNeu->website_1])
                ->filter()
                ->map(function ($value, $key) {
                    return match ($key) {
                        0 => 'E-Mail',
                        1 => 'Telefonnummer',
                        2 => 'Website',
                    };
                })
                ->implode(', ')
            . ' vom [dd.mm.yyyy] –',
            null,
            '– Meldung neue Telefonnummer, E-Mail, Website vom [dd.mm.yyyy] –',
        );
    }
}
