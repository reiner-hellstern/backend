<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class KuendigungMitgliedschaftController extends TemplateBaseController
{
    public function show($person)
    {
        $person = json_decode($person);

        return $this->renderPdf(
            'dokumente.kuendigung-drc-mitgliedschaft',
            [
                'person' => $person,
            ],
            '[{"text": "Kündigung","smaller": false}, {"text": "Vereinsmitgliedschaft", "smaller": false}]',
            null,
            'Headline wächst von unten nah oben Seite 2 – Gibson Medium 18/20',
            '– Secondary Subheadline Text –'
        );
    }
}
