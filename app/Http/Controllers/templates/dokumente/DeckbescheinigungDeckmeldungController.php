<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class DeckbescheinigungDeckmeldungController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.deckbescheinigung-deckmeldung',
            [],
            '[{"text": "Deckbescheinigung/-meldung","smaller": false}]',
            '– [Rasse], [Name der Hündin] –',
            null,
            '– [Rasse], [Name der Hündin] –',
            lessMarginTop: true,
        );
    }
}
