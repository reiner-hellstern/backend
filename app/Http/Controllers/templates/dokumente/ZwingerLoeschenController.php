<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class ZwingerLoeschenController extends TemplateBaseController
{
    public function show()
    {
        $transferToGermanClub = true;

        return $this->renderPdf(
            'dokumente.zwinger-loeschen',
            [
                'isZwingergemeinschaft' => true,
            ],
            '[{"text": "Antrag auf FCI-Zwinger-Löschung","smaller": false}]',
            ''
        );
    }
}
