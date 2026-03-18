<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;
use App\Models\Hund;
use App\Models\Person;
use App\Models\Wurf;
use App\Models\Zuchtwart;

class ChipnummernListeBarcodeListeController extends TemplateBaseController
{
    public function show()
    {
        $wurfId = 15694; // For debugging use: 15694

        $wurf = Wurf::find(id: $wurfId);
        $hunde = Hund::where('wurf_id', $wurfId)->get();
        $person_zuchtwart = Person::find((Zuchtwart::find(id: $wurf->zuchtwart_id)->person_id));

        return $this->renderPdf(
            'dokumente.chipnummern-liste-barcode-liste',
            [
                'wurf' => $wurf,
                'person_zuchtwart' => $person_zuchtwart,
                'hunde' => $hunde,
            ],
            '[{"text": "Chipnummern-/Barcodestreifen-Liste","smaller": false}]',
            "– Anlage zur Wurfabnahme, $wurf->wurfbuchstabe-Wurf, vom $wurf->wurfdatum –",
            null,
            "– Anlage zur Wurfabnahme, $wurf->wurfbuchstabe-Wurf, vom $wurf->wurfdatum –"
        );
    }
}
