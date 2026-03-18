<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GelenkuntersuchungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //  return parent::toArray($request);
        return [
            $this->mergeWhen($this->gelenkuntersuchungable_type == 'App\\Models\\GelenkuntersuchungGutachten', [
                'gutachten' => 'ja',
                'obergutachten' => 'nein',
                'edverifizierung' => 'nein',
            ]),
            $this->mergeWhen($this->gelenkuntersuchungable_type == 'App\\Models\\GelenkuntersuchungObergutachten', [
                'gutachten' => 'nein',
                'obergutachten' => 'ja',
                'edverifizierung' => 'nein',
            ]),
            $this->mergeWhen($this->gelenkuntersuchungable_type == 'App\\Models\\GelenkuntersuchungEDVerifizierung', [
                'gutachten' => 'nein',
                'obergutachten' => 'nein',
                'edverifizierung' => 'ja',
            ]),
            'open' => false,
            'aktiv' => $this->aktiv,
            'dokumente' => $this->gelenkuntersuchungable->dokumente,
            'id' => $this->id,
            'module_vue' => $this->module_vue,
            'hund_id' => $this->hund_id,
            'typ' => $this->gelenkuntersuchungable->typ,
            'typ_id' => $this->gelenkuntersuchungable->typ_id,
            'datum' => $this->datum,
            'ed_bearbeitungscode' => $this->gelenkuntersuchungable->ed_bearbeitungscode,
            'hd_bearbeitungscode' => $this->gelenkuntersuchungable->hd_bearbeitungscode,
            'formularcode' => $this->gelenkuntersuchungable->formularcode,
            'roentgen_datum' => $this->gelenkuntersuchungable->roentgen_datum,
            'roentgen_art_id' => $this->gelenkuntersuchungable->roentgen_art_id,
            'arzt_id' => $this->gelenkuntersuchungable->roentgen_arzt_id,
            'roentgenarzt' => [
                'id' => $this->gelenkuntersuchungable->roentgen_arzt_id,
                'titel' => $this->gelenkuntersuchungable->roentgen_arzt_titel,
                'vorname' => $this->gelenkuntersuchungable->roentgen_arzt_vorname,
                'nachname' => $this->gelenkuntersuchungable->roentgen_arzt_nachname,
                'praxis_id' => $this->gelenkuntersuchungable->roentgen_praxis_id,
                'praxis_name' => $this->gelenkuntersuchungable->roentgen_praxis_name,
                'praxis_strasse' => $this->gelenkuntersuchungable->roentgen_praxis_strasse,
                'praxis_plz' => $this->gelenkuntersuchungable->roentgen_praxis_plz,
                'praxis_ort' => $this->gelenkuntersuchungable->roentgen_praxis_ort,
                'praxis_land' => $this->gelenkuntersuchungable->roentgen_praxis_land,
                'praxis_land_kuerzel' => $this->gelenkuntersuchungable->roentgen_praxis_land_kuerzel,
                'praxis_email' => $this->gelenkuntersuchungable->roentgen_praxis_email,
                'praxis_website' => $this->gelenkuntersuchungable->roentgen_praxis_website,
                'praxis_telefon_1' => $this->gelenkuntersuchungable->roentgen_praxis_telefon_1,
                'praxis_telefon_2' => $this->gelenkuntersuchungable->roentgen_praxis_telefon_2,

            ],
            'roentgen_anmerkungen' => $this->gelenkuntersuchungable->roentgen_anmerkungen,
            'sedierung_praeparat' => $this->gelenkuntersuchungable->sedierung_praeparat,
            'sedierung_menge' => $this->gelenkuntersuchungable->sedierung_menge,
            'hd_lagerung_mangelhaft' => $this->gelenkuntersuchungable->hd_lagerung_mangelhaft,
            'hd_qualitaet_mangelhaft' => $this->gelenkuntersuchungable->hd_qualitaet_mangelhaft,
            'ed_lagerung_mangelhaft' => $this->gelenkuntersuchungable->ed_lagerung_mangelhaft,
            'ed_qualitaet_mangelhaft' => $this->gelenkuntersuchungable->ed_qualitaet_mangelhaft,
            'hd' => $this->gelenkuntersuchungable->hd,
            'hd_score' => $this->gelenkuntersuchungable->hd_score,
            'hd_score_id' => $this->gelenkuntersuchungable->hd_score_id,
            'hd_status_id' => $this->gelenkuntersuchungable->hd_status_id,
            'hd_ablehnung_id' => $this->gelenkuntersuchungable->hd_ablehnung_id,
            'hd_r_score' => $this->gelenkuntersuchungable->hd_r_score,
            'hd_r_score_id' => $this->gelenkuntersuchungable->hd_r_score_id,
            'hd_r_status_id' => $this->gelenkuntersuchungable->hd_r_status_id,
            'hd_l_score' => $this->gelenkuntersuchungable->hd_l_score,
            'hd_l_score_id' => $this->gelenkuntersuchungable->hd_l_score_id,
            'hd_l_status_id' => $this->gelenkuntersuchungable->hd_l_status_id,
            'hd_scoretyp_id' => $this->gelenkuntersuchungable->hd_scoretyp_id,
            'hd_uwirbel' => $this->gelenkuntersuchungable->hd_uwirbel,
            'hd_uwirbel_score' => $this->gelenkuntersuchungable->hd_uwirbel_score,
            'hd_uwirbel_score_id' => $this->gelenkuntersuchungable->hd_uwirbel_score_id,
            'ed' => $this->gelenkuntersuchungable->ed,
            'ed_score' => $this->gelenkuntersuchungable->ed_score,
            'ed_score_id' => $this->gelenkuntersuchungable->ed_score_id,
            'ed_status_id' => $this->gelenkuntersuchungable->ed_status_id,
            'ed_ablehnung_id' => $this->gelenkuntersuchungable->ed_ablehnung_id,
            'ed_r_score' => $this->gelenkuntersuchungable->ed_r_score,
            'ed_r_score_id' => $this->gelenkuntersuchungable->ed_r_score_id,
            'ed_r_status_id' => $this->gelenkuntersuchungable->ed_r_status_id,
            'ed_l_score' => $this->gelenkuntersuchungable->ed_l_score,
            'ed_l_score_id' => $this->gelenkuntersuchungable->ed_l_score_id,
            'ed_l_status_id' => $this->gelenkuntersuchungable->ed_l_status_id,
            'ed_r_arthrose_score_id' => $this->gelenkuntersuchungable->ed_r_arthrose_score_id,
            'ed_arthrose_r_score' => $this->gelenkuntersuchungable->ed_arthrose_r_score,
            'ed_l_arthrose_score_id' => $this->gelenkuntersuchungable->ed_l_arthrose_score_id,
            'ed_arthrose_l_score' => $this->gelenkuntersuchungable->ed_arthrose_l_score,
            'ed_scoretyp_id' => $this->gelenkuntersuchungable->ed_scoretyp_id,
            'ed_scoretyp_id' => $this->gelenkuntersuchungable->ed_scoretyp_id,
            'ct_datum' => $this->gelenkuntersuchungable->ct_datum,
            'ct_grund_id' => $this->gelenkuntersuchungable->ct_grund_id,
            'ipa' => $this->gelenkuntersuchungable->ipa,
            'fcp' => $this->gelenkuntersuchungable->fcp,
            'ocd' => $this->gelenkuntersuchungable->ocd,
            'coronoid' => $this->gelenkuntersuchungable->coronid,
            'anmerkungen' => $this->gelenkuntersuchungable->anmerkungen,
            'dokument_id' => $this->gelenkuntersuchungable->dokument_id,
            'dokumentable_id' => $this->gelenkuntersuchungable->dokumentable_id,
            'dokumentable_type' => $this->gelenkuntersuchungable->dokumentable_type,
            'gutachter_id' => $this->gelenkuntersuchungable->gutachter_id,
            'gutachter_titel' => $this->gelenkuntersuchungable->gutachter_titel,
            'gutachter_vorname' => $this->gelenkuntersuchungable->gutachter_vorname,
            'gutachter_nachname' => $this->gelenkuntersuchungable->gutachter_nachname,
            'gutachter_strasse' => $this->gelenkuntersuchungable->gutachter_strasse,
            'gutachter_plz' => $this->gelenkuntersuchungable->gutachter_plz,
            'gutachter_ort' => $this->gelenkuntersuchungable->gutachter_ort,
            'gutachter_land' => $this->gelenkuntersuchungable->gutachter_land,
            'gutachter_land_kuerzel' => $this->gelenkuntersuchungable->gutachter_land_kuerzel,
            'gutachter_email' => $this->gelenkuntersuchungable->gutachter_email,
            'gutachter_website' => $this->gelenkuntersuchungable->gutachter_website,
            'gutachter_telefon_1' => $this->gelenkuntersuchungable->gutachter_telefon_1,
            'gutachter_telefon_2' => $this->gelenkuntersuchungable->gutachter_telefon_2,
        ];

        //  return parent::toArray($request);
    }
}
