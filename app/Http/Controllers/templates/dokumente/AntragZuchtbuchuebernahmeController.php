<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AntragZuchtbuchuebernahmeController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.antrag-zuchtbuchuebernahme',
            [],
            '[{"text": "Antrag auf Zuchtbuch-Übernahme","smaller": false}]',
            null,
            '[{"text": "Antrag auf Zuchtbuch-Übernahme","smaller": false}]',
            null,
        );
    }
}
