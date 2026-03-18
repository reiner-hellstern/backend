<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AufnahmeantragDRCVereinsmitgliedschaftController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.aufnahmeantrag-drc-vereinsmitgliedschaft',
            [],
            '[{"text": "Aufnahmeantrag","smaller": false},{"text": "DRC-Vereinsmitgliedschaft","smaller": false}]',
            null,
            '[{"text": "Aufnahmeantrag","smaller": false},{"text": "DRC-Vereinsmitgliedschaft","smaller": false}]',
        );
    }
}
