<?php

namespace App\Http\Controllers\templates\nicht_jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class WesenstestController extends TemplateBaseController
{
    public function show($formDataAsJson = '')
    {
        $formData = json_decode($formDataAsJson);

        return $this->renderPdf(
            'nicht-jagdliche.wesenstest',
            [
                'wesenstest' => $formData,
            ],
            '[{"text": "Wesenstest (WT)","smaller": false}]',
            '– Protokoll der Verhaltensbeurteilung –',
            null,
            '– Protokoll der Verhaltensbeurteilung –',
            true
        );
    }
}
