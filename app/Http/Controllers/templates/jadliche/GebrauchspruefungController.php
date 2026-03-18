<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class GebrauchspruefungController extends TemplateBaseController
{
    public function show($rgp)
    {
        $rgp = json_decode($rgp);

        return $this->renderPdf(
            'jagdliche.gebrauchspruefung',
            ['rgp' => $rgp],
            '[{"text": "Retriever-Gebrauchsprüfung (RGP)","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
