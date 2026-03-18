<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AugenuntersuchungResource extends JsonResource
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
        return [
            'open' => false,
            'aktive_au' => $this->aktive_au,
            'aktive_gonio' => $this->aktive_gonio,
            'dokumente' => $this->dokumente,
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'gesamtergebnis' => $this->gesamtergebnis,
            'anmerkungen' => $this->anmerkungen,
            'typ' => $this->typ,
            'datum' => $this->datum,
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
            'mpp_id' => $this->mpp_id,
            'mpp_iris' => $this->mpp_iris,
            'mpp_linse' => $this->mpp_linse,
            'mpp_komea' => $this->mpp_komea,
            'mpp_vorderkammer' => $this->mpp_vorderkammer,
            'phtvlphpv_id' => $this->phtvlphpv_id,
            'phtvlphpv_nfrei_id' => $this->phtvlphpv_nfrei_id,
            'katarakt_kon_id' => $this->katarakt_kon_id,
            'rd_id' => $this->rd_id,
            'rd_multifokal' => $this->rd_multifokal,
            'rd_geo' => $this->rd_geo,
            'rd_total' => $this->rd_total,
            'katarakt_cortikalis' => $this->katarakt_cortikalis,
            'katarakt_polpost' => $this->katarakt_polpost,
            'katarakt_sutura_ant' => $this->katarakt_sutura_ant,
            'katarakt_punctata' => $this->katarakt_punctata,
            'katarakt_nuklearis' => $this->katarakt_nuklearis,
            'katarakt_sonstige' => $this->katarakt_sonstige,
            'katarakt_sonstige_angaben' => $this->katarakt_sonstige_angaben,
            'cea_choroidhypo' => $this->cea_choroidhypo,
            'cea_kolobom' => $this->cea_kolobom,
            'cea_sonstige' => $this->cea_sonstige,
            'cea_sonstige_angaben' => $this->cea_sonstige_angaben,
            'dyslpectabnorm_kurztrabekel' => $this->dyslpectabnorm_kurztrabekel,
            'dyslpectabnorm_gewebebruecken' => $this->dyslpectabnorm_gewebebruecken,
            'dyslpectabnorm_totaldyspl' => $this->dyslpectabnorm_totaldyspl,
            'katarakt_nonkon_id' => $this->katarakt_nonkon_id,
            'hypoplasie_mikropapille_id' => $this->hypoplasie_mikropapille_id,
            'cea_id' => $this->cea_id,
            'dyslpectabnorm_id' => $this->dyslpectabnorm_id,
            'entropium_id' => $this->entropium_id,
            'ektropium_id' => $this->ektropium_id,
            'primaerglaukom_id' => $this->primaerglaukom_id,
            'icaa_id' => $this->icaa_id,
            'icaa_grad_id' => $this->icaa_grad_id,
            'distichiasis_id' => $this->distichiasis_id,
            'korneadystrophie_id' => $this->korneadystrophie_id,
            'linsenluxation_id' => $this->linsenluxation_id,
            'mikrophthalamie_id' => $this->mikrophthalamie_id,
            'pra_rd_id' => $this->pra_rd_id,
            'pla_id' => $this->pla_id,
            'ica_weite_id' => $this->ica_weite_id,
            'methode_id' => $this->methode_id,
            'ophtalmoskopie_d' => $this->ophtalmoskopie_d,
            'ophtalmoskopie_ind' => $this->ophtalmoskopie_ind,
            'gonioskopie' => $this->gonioskopie,
            'tonometrie' => $this->tonometrie,
            'mydriatikum' => $this->mydriatikum,
            'spaltlampe' => $this->spaltlampe,
            'foto' => $this->foto,
            'weitere_methode' => $this->weitere_methode,
            'weitere_methode_b' => $this->weitere_methode_b,
        ];
        //  return parent::toArray($request);
    }
}
