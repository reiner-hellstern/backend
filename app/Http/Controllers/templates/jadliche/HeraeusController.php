<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class HeraeusController extends TemplateBaseController
{
    public function show($formDataAsJson)
    {
        $formData = json_decode($formDataAsJson);

        return $this->renderPdf(
            'jagdliche.heraeus',
            [
                'heraeus' => $formData,
            ],
            '[{"text": "Dr. Heraeus-Gedächtnis-Prüfung für Retriever (HP/R)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
