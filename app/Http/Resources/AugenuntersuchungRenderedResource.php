<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AugenuntersuchungRenderedResource extends JsonResource
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
            // 'gesamtergebnis' =>  $this->gesamtergebnis->label,
            'anmerkungen' => $this->anmerkungen,
            //'typ' => $this->typ->label,
            'datum' => $this->datum,
            'mpp' => $this->mpp,
            'mpp_iris' => $this->mpp_iris,
            'mpp_linse' => $this->mpp_linse,
            'mpp_komea' => $this->mpp_komea,
            'mpp_vorderkammer' => $this->mpp_vorderkammer,
            'phtvlphpv' => $this->phtvlphpv,
            'phtvlphpv_nfrei' => $this->phtvlphpv_nfrei,
            'katarakt_kon' => $this->katarakt_kon,
            'rd' => $this->rd,
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
            'katarakt_nonkon' => $this->katarakt_nonkon,
            'hypoplasie_mikropapille' => $this->hypoplasie_mikropapille,
            'cea' => $this->cea,
            'dyslpectabnorm' => $this->dyslpectabnorm,
            'entropium' => $this->entropium,
            'ektropium' => $this->ektropium,
            'primaerglaukom' => $this->primaerglaukom,
            'icaa' => $this->icaa,
            'icaa_nfrei' => $this->icaa_nfrei,
            'distichiasis' => $this->distichiasis,
            'korneadystrophie' => $this->korneadystrophie,
            'linsenluxation' => $this->linsenluxation,
            'mikrophthalamie' => $this->mikrophthalamie,
            'pra_rd' => $this->pra_rd,
            'pla' => $this->pla,
            'ica_weite' => $this->ica_weite,
            'methode' => $this->methode,
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
