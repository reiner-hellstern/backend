<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class BringleistungspruefungController extends TemplateBaseController
{
    public function show($formData)
    {
        $formData = json_decode($formData);

        return $this->renderPdf(
            'jagdliche.bringleistungspruefung',
            [
                'bringleistungspruefung' => $formData,
            ],
            '[{"text": "Bringleistungsprüfung (BLP/R)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
