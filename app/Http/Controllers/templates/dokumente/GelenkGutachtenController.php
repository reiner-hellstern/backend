<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class GelenkGutachtenController extends TemplateBaseController
{
    public function show($gelenkGutachten)
    {
        $gelenkGutachten = json_decode($gelenkGutachten);

        $gelenkParts = [];

        if ($gelenkGutachten->hueftgelenkdysplasie !== null) {
            $gelenkParts[] = 'Hüfte';
        }

        if ($gelenkGutachten->ellenbogendysplasie !== null) {
            $gelenkParts[] = 'Ellenbogen';
        }

        if ($gelenkGutachten->ocd_schultern !== null) {
            $gelenkParts[] = 'Schultern';
        }

        if ($gelenkGutachten->ocd_sprunggelenke !== null) {
            $gelenkParts[] = 'Sprunggelenke';
        }

        $gelenkString = implode(', ', $gelenkParts);

        return $this->renderPdf(
            'dokumente.gelenk-gutachten',
            ['gelenkGutachten' => $gelenkGutachten],
            // "Gelenk-Gutachten\n (Hüfte, Ellenbogen, Schulter, Sprunggelenk)",
            '[{"text": "Gelenk-Gutachten","smaller": false},{"text": "(' . $gelenkString . ')","smaller": true}]',
            '– vom [dd.mm.yyyy] mit der DRC-Bearbeitungsnummer: [00000] –',
            // "Gelenk-Gutachten (Hüfte, Ellenbogen, Schulter, Sprunggelenk)",
            null,
            '– vom [dd.mm.yyyy] mit der DRC-Bearbeitungsnummer: [00000] –',
        );
    }
}
