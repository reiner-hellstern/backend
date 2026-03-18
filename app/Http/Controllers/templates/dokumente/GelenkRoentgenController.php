<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class GelenkRoentgenController extends TemplateBaseController
{
    public function show($gelenkRoentgen)
    {
        $gelenkRoentgen = json_decode($gelenkRoentgen);

        $dynamicSubtitle = [];
        if ($gelenkRoentgen->roentgenaufnahmen->fuer->hd !== false) {
            $dynamicSubtitle[] = 'HD';
        }
        if ($gelenkRoentgen->roentgenaufnahmen->fuer->ed !== false) {
            $dynamicSubtitle[] = 'ED';
        }
        if ($gelenkRoentgen->roentgenaufnahmen->fuer->schultern !== false || $gelenkRoentgen->roentgenaufnahmen->fuer->sprunggelenke !== false) {
            $dynamicSubtitle[] = 'OCD';
        }
        $dynamicSubtitleString = implode(', ', $dynamicSubtitle);

        return $this->renderPdf(
            'dokumente.gelenk-roentgen',
            [
                'gelenkRoentgen' => $gelenkRoentgen,
            ],
            '[{"text": "Gelenk-Röntgen","smaller": false},{"text": "Tierarzt-Formular","smaller": true}]',
            "– Basis für DRC Gutachten auf $dynamicSubtitleString –",
            null,
            "– Basis für DRC Gutachten auf $dynamicSubtitleString –",
        );
    }
}
