<?php

namespace App\Http\Controllers\templates\oeffentlich;

use App\Http\Controllers\templates\TemplateBaseController;

class AuftragZurEinlagerungVonBlutController extends TemplateBaseController
{
    public function show($auftragZurEinlagerungVonBlut)
    {
        $auftragZurEinlagerungVonBlut = json_decode($auftragZurEinlagerungVonBlut);

        return $this->renderPdf(
            'oeffentlich.auftrag-zur-einlagerung-von-blut',
            [
                'auftragZurEinlagerungVonBlut' => $auftragZurEinlagerungVonBlut,
                // 'dogHadSeizureItself' => true,
                // 'affectedRelativesIds' => [12, 17],
            ],
            // "Änderungsantrag
            // DRC-Mitgliedschaftstyp",
            // '[{"text": "Probeneinlagerung Epilepise","smaller": false}, {"text": "Tierarzt-Formular","smaller": false}, {"text": "EDTA-Blut (1 ml) bzw. Backenabstrich","smaller": true}]',
            '[{"text": "Probeneinlagerung Epilepise","smaller": false}, {"text": "Tierarzt-Formular","smaller": true}]',
            '– Basis für Zuschuss zur Ausschlussdiagnostik für Epilepsie –',
            '[{"text": "Probeneinlagerung Epilepise","smaller": false}, {"text": "Hinweise zum Vorgehen","smaller": true}]',
        );
    }
}
