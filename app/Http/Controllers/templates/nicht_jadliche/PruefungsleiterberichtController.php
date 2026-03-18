<?php

namespace App\Http\Controllers\templates\nicht_jadliche;

use App\Http\Controllers\templates\TemplateBaseController;
use App\Models\Pruefung;
use Route;

class PruefungsleiterberichtController extends TemplateBaseController
{
    public function show(Pruefung $pruefung)
    {
        // RGP, BLP, RSwP, Toller, SRP, HP/R, PnS, Field Trail, JAS, *
        $pruefungstyp = Route::getCurrentRequest()->query('pruefungstyp');
        $richterbegleitung = Route::getCurrentRequest()->boolean('richterbegleitung');
        $totverbellerTotverweiser = Route::getCurrentRequest()->boolean('totverbellerverweiser');

        $nichtErschieneneHundeIds = [1903, 2045, 2830, 48747, 49619];
        $bestandeneHundeIds = [50278, 51483, 52587];
        $hundefuehrerOhneJagdscheinHundeIds = [53087, 53141];

        $richterIds = [26, 41];
        $notrichterPersonIds = [1615, 2170];
        $richteranwaerterPersonIds = [];

        return $this->renderPdf(
            'nicht-jagdliche.pruefungsleiterbericht',
            [
                'pruefungstyp' => $pruefungstyp,
                'richterbegleitung' => $richterbegleitung,
                'pruefung' => $pruefung,
                'nichtErschieneneHundeIds' => $nichtErschieneneHundeIds,
                'bestandeneHundeIds' => $bestandeneHundeIds,
                'hundefuehrerOhneJagdscheinHundeIds' => $hundefuehrerOhneJagdscheinHundeIds,
                'richterIds' => $richterIds,
                'notrichterPersonIds' => $notrichterPersonIds,
                'richteranwaerterPersonIds' => $richteranwaerterPersonIds,
                'totverbellerTotverweiser' => $totverbellerTotverweiser,
            ],
            '[{"text": "Prüfungsleiterbericht","smaller": false}]',
            "– $pruefungstyp, $pruefung->datum, {$pruefung->ausrichter->name} –",
            null,
        );
    }
}
