<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class BerichtUeberZuchtstaettenbesichtigungController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.bericht-ueber-zuchtstaettenbesichtigung',
            [],
            '[{"text": "Bericht über","smaller": false},{"text": "Zuchtstättenbesichtigung","smaller": false}]',
            '– vom [dd.mm.yyyy] durch [Vorname Zuchtwart] [Nachname Zuchtwart] –',
        );
    }
}
