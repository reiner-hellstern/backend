<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AenderungsantrragMitgliedschaftstypController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.aenderungsantrag-mitgliedschaftstyp',
            [],
            // "Änderungsantrag
            // DRC-Mitgliedschaftstyp",
            '[{"text": "Änderungsantrag","smaller": false},{"text": "DRC-Mitgliedschaftstyp","smaller": false}]',
            null,
            '[{"text": "Änderungsantrag","smaller": false},{"text": "DRC-Mitgliedschaftstyp","smaller": false}]',
            null,
        );
    }
}
