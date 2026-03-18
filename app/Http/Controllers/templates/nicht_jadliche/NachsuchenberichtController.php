<?php

namespace App\Http\Controllers\templates\nicht_jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class NachsuchenberichtController extends TemplateBaseController
{
    public function show(bool $richterbegleitung)
    {
        return $this->renderPdf(
            'nicht-jagdliche.nachsuchenbericht',
            [
                'richterbegleitung' => $richterbegleitung,
            ],
            '[{"text": "Nachsuchenbericht","smaller": false}]',
            '– Vereins-Schweißprüfung mit Richterbegleitung' . ($richterbegleitung == true ? ' (R/SwP m. Rb)' : ' (R/SwP o. Rb)') . ' –',
            null,
        );
    }
}
