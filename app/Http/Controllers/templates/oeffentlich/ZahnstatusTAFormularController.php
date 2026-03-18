<?php

namespace App\Http\Controllers\templates\oeffentlich;

use App\Http\Controllers\templates\TemplateBaseController;

class ZahnstatusTAFormularController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'oeffentlich.zahnstatus-ta-formular',
            [],
            '[{"text": "Zahnstatus","smaller": false}, {"text": "Tierarzt-Formular","smaller": true}]',
            '– Basis für Feststellung der Gebissverhältnisse –',
            '[{"text": "Zahnstatus","smaller": false}, {"text": "Tierarzt-Formular","smaller": true}]',
            '– Basis für Feststellung der Gebissverhältnisse –',
        );
    }
}
