<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AntragZuchtzulassungController extends TemplateBaseController
{
    // Reference
    public function show()
    {
        return $this->renderPdf(
            'dokumente.antrag-zuchtzulassung',
            [],
            '[{"text": "Antrag auf Zuchtzulassung","smaller": false}]',
            null,
            '[{"text": "Antrag auf Zuchtzulassung","smaller": false}]',
        );
    }
}
