<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class CTEllenbogenController extends TemplateBaseController
{
    public function show($ctEllenbogen)
    {
        $ctEllenbogen = json_decode($ctEllenbogen);

        return $this->renderPdf(
            'dokumente.ct-ellenbogen',
            [
                'ctEllenbogen' => $ctEllenbogen,
            ],
            '[{"text": "CT-Ellenbogen","smaller": false},{"text": "Tierarzt-Formular","smaller": true}]',
            '– Basis für ED-Verifizierung bzw. Ausschlussdiagnostik OCD und Coronoid-Erkrankung –',
            null,
            '– Basis für ED-Verifizierung bzw. Ausschlussdiagnostik OCD und Coronoid-Erkrankung –',
        );
    }
}
