<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class TollingSilberController extends TemplateBaseController
{
    public function show($tollerSilber)
    {
        $tollerSilber = json_decode($tollerSilber);

        return $this->renderPdf(
            'jagdliche.toller-silber',
            ['tollerSilber' => $tollerSilber],
            '[{"text": "Tolling-Prüfung für Nova-Scotia-Duck-Tolling-Retriever (TP/Toller) als silbernes Leistungszeichen","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
