<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class VereinspruefungNachSchussController extends TemplateBaseController
{
    public function show($formDataAsJson)
    {
        $formData = json_decode($formDataAsJson);

        return $this->renderPdf(
            'jagdliche.vereinspruefung-nach-schuss',
            [
                'pns' => $formData,
            ],
            '[{"text": "Vereinsprüfung nach dem Schuss (PnS)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –'
        );
    }
}
