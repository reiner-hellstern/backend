<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class StJohnController extends TemplateBaseController
{
    public function show($srp)
    {
        $srp = json_decode($srp);

        return $this->renderPdf(
            'jagdliche.st-john',
            ['srp' => $srp],
            '[{"text": "St. John’s Retrieverprüfung (SRP)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
