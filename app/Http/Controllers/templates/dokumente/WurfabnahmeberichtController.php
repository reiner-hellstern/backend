<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;
use App\Models\OptionZuchtart;
use App\Models\Rasse;
use App\Models\Zuchtstaettenmangel;
use App\Models\Zuchtwart;
use stdClass;

class WurfabnahmeberichtController extends TemplateBaseController
{
    public function show($formData)
    {
        return [
            $this->showDRCVersion($formData),
            $this->showKaeuferVersion($formData),
        ];
    }

    public function pieceTogetherZuchtstaettenMaengel($maengelIds = [])
    {
        $maengel = [];
        foreach ($maengelIds as $mangelId) {
            $mangel = Zuchtstaettenmangel::find($mangelId);
            // if mangel != behoben
            // $festgestelltDatum = $mangel->meldung_am
            // $zuchtwartName = $mangel->zuchtwart()->name
            // $zuBehebenBis = $mangel->frist

            $festgestelltDatum = $mangel->meldung_am;

            $zuchtwart = Zuchtwart::where('person_id', $mangel->melder_id)->first()->person()->get(['vorname', 'nachname'])->first();
            $zuchtwartName = $zuchtwart->vorname . ' ' . $zuchtwart->nachname;

            $zuBehebenBis = $mangel->frist;
            $begruendung = $mangel->begruendung;

            // nur relevant für behobene Mängel.
            $freigabeAm = $mangel->freigabe_am;

            $obj = new stdClass();
            $obj->festgestellt_am = $festgestelltDatum;
            $obj->zuchtwart = $zuchtwartName ?? 'lala';
            $obj->zu_beheben_bis = $zuBehebenBis;
            $obj->begruendung = $begruendung;
            $obj->freigabe_am = $freigabeAm;

            array_push($maengel, $obj);
        }

        return $maengel;
    }

    public function showDRCVersion($formData)
    {
        $wurfabnahmebericht = json_decode($formData);
        $wurfabnahmebericht->wurf->rasse = Rasse::find($wurfabnahmebericht->wurf->rasse)->name;
        $wurfabnahmebericht->elterntiere->art_der_zucht = OptionZuchtart::find($wurfabnahmebericht->elterntiere->art_der_zucht)->name;

        $wurfabnahmebericht->vorzunehmende_veraenderungen->neue_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->neue_maengel);
        $wurfabnahmebericht->vorzunehmende_veraenderungen->offene_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->offene_maengel);
        $wurfabnahmebericht->vorzunehmende_veraenderungen->behobene_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->behobene_maengel);

        return $this->renderPdf(
            'dokumente.wurfabnahmebericht',
            [
                'kaeuferVersion' => false,
                'wurfabnahmebericht' => $wurfabnahmebericht,
            ],
            '[{"text": "Wurfabnahmebericht (DRC Version)","smaller": false}]',
            "– {$wurfabnahmebericht->wurf->buchstabe}-Wurf, {$wurfabnahmebericht->wurf->rasse}, {$wurfabnahmebericht->zuchtstaette->zwingername} –",
            null,
            "– {$wurfabnahmebericht->wurf->buchstabe}-Wurf, {$wurfabnahmebericht->wurf->rasse}, {$wurfabnahmebericht->zuchtstaette->zwingername} –",
        );
    }

    public function showKaeuferVersion($formData)
    {
        $wurfabnahmebericht = json_decode($formData);
        $wurfabnahmebericht->wurf->rasse = Rasse::find($wurfabnahmebericht->wurf->rasse)->name;
        $wurfabnahmebericht->elterntiere->art_der_zucht = OptionZuchtart::find($wurfabnahmebericht->elterntiere->art_der_zucht)->name;

        $wurfabnahmebericht->vorzunehmende_veraenderungen->neue_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->neue_maengel);
        $wurfabnahmebericht->vorzunehmende_veraenderungen->offene_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->offene_maengel);
        $wurfabnahmebericht->vorzunehmende_veraenderungen->behobene_maengel = $this->pieceTogetherZuchtstaettenMaengel($wurfabnahmebericht->vorzunehmende_veraenderungen->behobene_maengel);

        return $this->renderPdf(
            'dokumente.wurfabnahmebericht',
            [
                'kaeuferVersion' => true,
                'wurfabnahmebericht' => $wurfabnahmebericht,
            ],
            '[{"text": "Wurfabnahmebericht","smaller": false}]',
            "– {$wurfabnahmebericht->wurf->buchstabe}-Wurf, {$wurfabnahmebericht->wurf->rasse}, {$wurfabnahmebericht->zuchtstaette->zwingername} –",
            null,
            "– {$wurfabnahmebericht->wurf->buchstabe}-Wurf, {$wurfabnahmebericht->wurf->rasse}, {$wurfabnahmebericht->zuchtstaette->zwingername} –",
        );
    }
}
