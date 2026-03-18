<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class JagdlicheAnlagensichtungController extends TemplateBaseController
{
    public function show($formDataAsJson)
    {
        $formData = json_decode($formDataAsJson);

        return $this->renderPdf(
            'jagdliche.jagdliche-anlagensichtung',
            [
                'jas' => $formData,
            ],
            '[{"text": "Jagdliche Anlagensichtung der Retriever (JAS/R)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
