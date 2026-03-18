<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AntragAufInternationalenZwingerschutzController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.antrag-auf-internationalen-zwingerschutz',
            [],
            '[{"text": "Antrag auf","smaller": false},{"text": "internationalen Zwingerschutz","smaller": false}]',
            null,
        );
    }
}
