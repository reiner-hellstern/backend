<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class TollingBronzeController extends TemplateBaseController
{
    public function show($tollerBronze)
    {
        $tollerBronze = json_decode($tollerBronze);

        return $this->renderPdf(
            'jagdliche.toller-bronze',
            ['tollerBronze' => $tollerBronze],
            '[{"text": "Tolling-Prüfung für Nova-Scotia-Duck-Tolling-Retriever (TP/Toller) als bronzenes Leistungszeichen","smaller": false}]',
            '– Bescheinigung und Zensurenblatt –',
        );
    }
}
