<?php

namespace App\Http\Controllers\templates\nicht_jadliche;

use App\Http\Controllers\templates\TemplateBaseController;

class FormwertbeurteilungController extends TemplateBaseController
{
    public function show($formwertbeurteilung)
    {
        $formwertbeurteilung = json_decode($formwertbeurteilung);

        return $this->renderPdf(
            'nicht-jagdliche.formwertbeurteilung',
            [
                'formwertbeurteilung' => $formwertbeurteilung,
                'breedingAllowed' => false, // decides over module at the bottom
            ],
            '[{"text": "Formwertbeurteilung (FW)","smaller": false}]',
            '– Richterbericht –',
            null,
            '– Richterbericht –',
        );
    }
}
