<?php

namespace App\Http\Controllers\templates\nicht_jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class ArbeitspruefungMitDummiesController extends TemplateBaseController
{
    public function show($formDataAsJson)
    {
        $formData = json_decode($formDataAsJson);

        return $this->renderPdf(
            'nicht-jagdliche.arbeitspruefung-mit-dummies',
            [
                'arbeitspruefungMitDummies' => $formData,
            ],
            '[{"text": "Arbeitsprüfung mit Dummies (APD/R)","smaller": false}, {"text": "Anfängerklasse","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
            "Arbeitsprüfung mit Dummies (APD/R)\nAnfängerklasse",
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
