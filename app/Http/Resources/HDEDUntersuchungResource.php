<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HDEDUntersuchungResource extends JsonResource
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
            'open' => false,
            'aktiv' => $this->aktiv,
            'dokumente' => $this->dokumente,
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'typ' => $this->typ,
            'typ_id' => $this->typ_id,
            'datum' => $this->datum,
            'ed_bearbeitungscode' => $this->ed_bearbeitungscode,
            'hd_bearbeitungscode' => $this->hd_bearbeitungscode,
            'formularcode' => $this->formularcode,
            'roentgen_datum' => $this->roentgen_datum,
            'roentgen_art_id' => $this->roentgen_art_id,
            'roentgen_arzt_id' => $this->roentgen_arzt_id,
            'roentgen_arzt_titel' => $this->roentgen_arzt_titel,
            'roentgen_arzt_vorname' => $this->roentgen_arzt_vorname,
            'roentgen_arzt_nachname' => $this->roentgen_arzt_nachname,
            'roentgen_praxis_id' => $this->roentgen_praxis_id,
            'roentgen_praxis_name' => $this->roentgen_praxis_name,
            'roentgen_praxis_strasse' => $this->roentgen_praxis_strasse,
            'roentgen_praxis_plz' => $this->roentgen_praxis_plz,
            'roentgen_praxis_ort' => $this->roentgen_praxis_ort,
            'roentgen_praxis_land' => $this->roentgen_praxis_land,
            'roentgen_praxis_land_kuerzel' => $this->roentgen_praxis_land_kuerzel,
            'roentgen_praxis_email' => $this->roentgen_praxis_email,
            'roentgen_praxis_website' => $this->roentgen_praxis_website,
            'roentgen_praxis_telefon_1' => $this->roentgen_praxis_telefon_1,
            'roentgen_praxis_telefon_2' => $this->roentgen_praxis_telefon_2,
            'roentgen_vetsxl_nr' => $this->roentgen_vetsxl_nr,
            'roentgen_anmerkungen' => $this->roentgen_anmerkungen,
            'sedierung_praeparat' => $this->sedierung_praeparat,
            'sedierung_menge' => $this->sedierung_menge,
            'hd_lagerung_mangelhaft' => $this->hd_lagerung_mangelhaft,
            'hd_qualitaet_mangelhaft' => $this->hd_qualitaet_mangelhaft,
            'ed_lagerung_mangelhaft' => $this->ed_lagerung_mangelhaft,
            'ed_qualitaet_mangelhaft' => $this->ed_qualitaet_mangelhaft,
            'hd' => $this->hd,
            'hd_score' => $this->hd_score,
            'hd_score_id' => $this->hd_score_id,
            'hd_status_id' => $this->hd_status_id,
            'hd_ablehnung_id' => $this->hd_ablehnung_id,
            'hd_r_score' => $this->hd_r_score,
            'hd_r_score_id' => $this->hd_r_score_id,
            'hd_r_status_id' => $this->hd_r_status_id,
            'hd_l_score' => $this->hd_l_score,
            'hd_l_score_id' => $this->hd_l_score_id,
            'hd_l_status_id' => $this->hd_l_status_id,
            'hd_scoretyp_id' => $this->hd_scoretyp_id,
            'hd_uwirbel' => $this->hd_uwirbel,
            'hd_uwirbel_score' => $this->hd_uwirbel_score,
            'hd_uwirbel_score_id' => $this->hd_uwirbel_score_id,
            'ed' => $this->ed,
            'ed_score' => $this->ed_score,
            'ed_score_id' => $this->ed_score_id,
            'ed_status_id' => $this->ed_status_id,
            'ed_ablehnung_id' => $this->ed_ablehnung_id,
            'ed_r_score' => $this->ed_r_score,
            'ed_r_score_id' => $this->ed_r_score_id,
            'ed_r_status_id' => $this->ed_r_status_id,
            'ed_l_score' => $this->ed_l_score,
            'ed_l_score_id' => $this->ed_l_score_id,
            'ed_l_status_id' => $this->ed_l_status_id,
            'ed_r_arthrose_score_id' => $this->ed_r_arthrose_score_id,
            'ed_arthrose_r_score' => $this->ed_arthrose_r_score,
            'ed_l_arthrose_score_id' => $this->ed_l_arthrose_score_id,
            'ed_arthrose_l_score' => $this->ed_arthrose_l_score,
            'ed_scoretyp_id' => $this->ed_scoretyp_id,
            'ed_scoretyp_id' => $this->ed_scoretyp_id,
            'ct_datum' => $this->ct_datum,
            'ct_grund_id' => $this->ct_grund_id,
            'ipa' => $this->ipa,
            'fcp' => $this->fcp,
            'ocd' => $this->ocd,
            'coronoid' => $this->coronid,
            'anmerkungen' => $this->anmerkungen,
            'dokument_id' => $this->dokument_id,
            'dokumentable_id' => $this->dokumentable_id,
            'dokumentable_type' => $this->dokumentable_type,
            'gutachter_id' => $this->gutachter_id,
            'gutachter_titel' => $this->gutachter_titel,
            'gutachter_vorname' => $this->gutachter_vorname,
            'gutachter_nachname' => $this->gutachter_nachname,
            'gutachter_strasse' => $this->gutachter_strasse,
            'gutachter_plz' => $this->gutachter_plz,
            'gutachter_ort' => $this->gutachter_ort,
            'gutachter_land' => $this->gutachter_land,
            'gutachter_land_kuerzel' => $this->gutachter_land_kuerzel,
            'gutachter_email' => $this->gutachter_email,
            'gutachter_website' => $this->gutachter_website,
            'gutachter_telefon_1' => $this->gutachter_telefon_1,
            'gutachter_telefon_2' => $this->gutachter_telefon_2,
        ];

        //  return parent::toArray($request);
    }
}
