<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AenderungsmeldungBankverbindungController extends TemplateBaseController
{
    public function show($aenderungsmeldungBankverbindung)
    {
        $aenderungsmeldungBankverbindung = json_decode($aenderungsmeldungBankverbindung);

        $changedConnections = [];
        if ($aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung !== null) {
            $changedConnections[] = 'Mitgliedsbeitrag';
        }
        if ($aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung !== null) {
            $changedConnections[] = 'Vereinsleistungen';
        }
        $changedConnectionsString = implode(', ', $changedConnections);

        return $this->renderPdf(
            'dokumente.aenderungsmeldung-bankverbindung',
            [
                'aenderungsmeldungBankverbindung' => $aenderungsmeldungBankverbindung,
            ],
            '[{"text": "Änderungsmeldung","smaller": false},{"text": "Bankverbindung","smaller": false}]',
            "– $changedConnectionsString –",
            '[{"text": "Änderungsmeldung","smaller": false},{"text": "Bankverbindung","smaller": false}]',
            "– $changedConnectionsString –",
        );
    }
}
