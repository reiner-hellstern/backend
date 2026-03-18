<?php

namespace App\Http\Controllers\templates\jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class VereinspruefungController extends TemplateBaseController
{
    public function show(bool $richterbegleitung)
    {
        $dynamicHeaderText = $richterbegleitung == true ? 'Vereins-Schweißprüfung mit Richterbegleitung (R/SwP m. Rb)' : 'Vereins-Schweißprüfung ohne Richterbegleitung (R/SwP o. Rb)';

        return $this->renderPdf(
            'jagdliche.vereinspruefung',
            [
                'richterbegleitung' => $richterbegleitung,
            ],
            json_encode([['text' => $dynamicHeaderText, 'smaller' => false]]),
            '– Bescheinigung und Zensurenblatt –',
            null,
        );
    }
}
