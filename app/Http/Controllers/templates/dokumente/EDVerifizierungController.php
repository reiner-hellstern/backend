<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;
use App\Http\Controllers\Utils\DateFormatter;

class EDVerifizierungController extends TemplateBaseController
{
    public function show($edVerifizierung)
    {
        $edVerifizierung = json_decode($edVerifizierung);

        return $this->renderPdf(
            'dokumente.ed-verifizierung',
            [
                'edVerifizierung' => $edVerifizierung,
            ],
            '[{"text": "ED-Verifizierung","smaller": false}]',
            '– vom ' . DateFormatter::formatDMY($edVerifizierung->gutachten_datum) . ' mit der DRC-Bearbeitungsnummer: [00000] –',
            null,
        );
    }
}
