<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OCDUntersuchungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        // $arzt = $this->arzt ? new ArztResource($this->arzt) : new ArztEmptyResource('null');

        return [
            'open' => false,
            'aktiv' => $this->aktiv,
            'dokumente' => $this->dokumente,
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'typ_id' => $this->typ_id,
            'operiert' => $this->operiert,
            'operiert_datum' => $this->operiert_datum,
            'datum' => $this->datum,
            'ocd_l_id' => $this->ocd_l_id,
            'ocd_r_id' => $this->ocd_r_id,
            'ocd_ellenbogen_l_id' => $this->ocd_ellenbogen_l_id,
            'ocd_ellenbogen_r_id' => $this->ocd_ellenbogen_r_id,
            'ocd_schulter_l_id' => $this->ocd_schulter_l_id,
            'ocd_schulter_r_id' => $this->ocd_schulter_r_id,
            'ocd_schulter_id' => $this->ocd_schulter_id,
            'ocd_ellenbogen_id' => $this->ocd_ellenbogen_id,
            'ocd_id' => $this->ocd_id,
            'ocd_sprunggelenk_id' => $this->ocd_sprunggelenk_id,
            'ocd_sprunggelenk_l_id' => $this->ocd_sprunggelenk_l_id,
            'ocd_sprunggelenk_r_id' => $this->ocd_sprunggelenk_r_id,
            'coronid_l_id' => $this->coronid_l_id,
            'coronid_r_id' => $this->coronid_r_id,
            'status_id' => $this->status_id,
            'bearbeitungscode' => $this->bearbeitungscode,
            'formularcode' => $this->formularcode,
            'arzt_id' => $this->arzt_id,
            'arzt_titel' => $this->arzt_titel,
            'arzt_vorname' => $this->arzt_vorname,
            'arzt_nachname' => $this->arzt_nachname,
            'arzt_praxis' => $this->arzt_praxis,
            'arzt_strasse' => $this->arzt_strasse,
            'arzt_plz' => $this->arzt_plz,
            'arzt_ort' => $this->arzt_ort,
            'arzt_land' => $this->arzt_land,
            'arzt_land_kuerzel' => $this->arzt_land_kuerzel,
            'arzt_email' => $this->arzt_email,
            'arzt_website' => $this->arzt_website,
            'arzt_telefon_1' => $this->arzt_telefon_1,
            'arzt_telefon_2' => $this->arzt_telefon_2,
            'ct_datum' => $this->ct_datum,
            'ct_art_id' => $this->ct_art_id,
            'ct_vetsxl_nr' => $this->ct_vetsxl_nr,
            'ct_grund_id' => $this->ct_grund_id,
            'ct_arzt_id' => $this->ct_arzt_id,
            'ct_arzt_titel' => $this->ct_arzt_titel,
            'ct_arzt_vorname' => $this->ct_arzt_vorname,
            'ct_arzt_nachname' => $this->ct_arzt_nachname,
            'ct_praxis_id' => $this->ct_praxis_id,
            'ct_praxis_name' => $this->ct_praxis_name,
            'ct_praxis_strasse' => $this->ct_praxis_strasse,
            'ct_praxis_plz' => $this->ct_praxis_plz,
            'ct_praxis_ort' => $this->ct_praxis_ort,
            'ct_praxis_land' => $this->ct_praxis_land,
            'ct_praxis_land_kuerzel' => $this->ct_praxis_land_kuerzel,
            'ct_praxis_email' => $this->ct_praxis_email,
            'ct_praxis_website' => $this->ct_praxis_website,
            'ct_praxis_telefon_1' => $this->ct_praxis_telefon_1,
            'ct_praxis_telefon_2' => $this->ct_praxis_telefon_2,
            'ct_anmerkungen' => $this->ct_anmerkungen,
            'sedierung_praeparat' => $this->sedierung_praeparat,
            'sedierung_menge' => $this->sedierung_menge,
            'anmerkungen' => $this->anmerkungen,
            'dokument_id' => $this->dokument_id,
            'dokumentable_id' => $this->dokumentable_id,
            'dokumentable_type' => $this->dokumentable_type,
        ];

        //  return parent::toArray($request);
    }
}
