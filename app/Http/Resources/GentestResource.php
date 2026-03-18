<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GentestResource extends JsonResource
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

        // $labor = $this->labor ? new LaborResource($this->labor) : new LaborEmptyResource('null');

        return [
            'open' => false,
            'aktiv' => $this->aktiv,
            'status' => $this->status,
            'dokumente' => $this->dokumente,
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum' => $this->datum,
            'datum_blutentnahme' => $this->datum_blutentnahme,
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
            'bemerkungen' => $this->bemerkungen,
            'dokument_id' => $this->dokument_id,
            'dokumentable_id' => $this->dokumentable_id,
            'dokumentable_type' => $this->dokumentable_type,
            'dna_profil' => $this->dna_profil,
            'dna_labor_id' => $this->dna_labor_id,
            'dna_labor_name' => $this->dna_labor_name,
            'pra_test_id' => $this->pra_test_id,
            'pra_prcd_gentest_id' => $this->pra_prcd_gentest_id,
            'cnm_gentest_id' => $this->cnm_gentest_id,
            'eic_gentest_id' => $this->eic_gentest_id,
            'dm_gentest_id' => $this->dm_gentest_id,
            'sd2_gentest_id' => $this->sd2_gentest_id,
            'narc_gentest_id' => $this->narc_gentest_id,
            'rd_osd_gentest_id' => $this->rd_osd_gentest_id,
            'cea_ch_gentest_id' => $this->cea_ch_gentest_id,
            'gr_pra1_gentest_id' => $this->gr_pra1_gentest_id,
            'gr_pra2_gentest_id' => $this->gr_pra2_gentest_id,
            'haarlaenge_id' => $this->haarlaenge_id,
            'gsdiiia_gentest_id' => $this->gsdiiia_gentest_id,
            'grmd_gentest_id' => $this->grmd_gentest_id,
            'ict_a_gentest_id' => $this->ict_a_gentest_id,
            'ed_sfs_gentest_id' => $this->ed_sfs_gentest_id,
            'hnpk_gentest_id' => $this->hnpk_gentest_id,
            'ncl5_gentest_id' => $this->ncl5_gentest_id,
            'ncl_f_gentest_id' => $this->ncl_f_gentest_id,
            'farbtest_gelb_id' => $this->farbtest_gelb_id,
            'farbtest_braun_id' => $this->farbtest_braun_id,
            'farbverduennung_id' => $this->farbverduennung_id,
            'den_gentest_id' => $this->den_gentest_id,
            'ict_2_gentest_id' => $this->ict_2_gentest_id,
            'jadd_gentest_id' => $this->jadd_gentest_id,
            'cp1_gentest_id' => $this->cp1_gentest_id,
            'cps_gentest_id' => $this->cps_gentest_id,
            'clps_gentest_id' => $this->clps_gentest_id,
            'cms_gentest_id' => $this->cms_gentest_id,
            'dann_farbtest_id' => $this->dann_farbtest_id,
            'dil_gentest_id' => $this->dil_gentest_id,
            'mh_gentest_id' => $this->mh_gentest_id,
            'cddy_gentest_id' => $this->cddy_gentest_id,
            'ivdd_gentest_id' => $this->ivdd_gentest_id,
            'cdpa_gentest_id' => $this->cdpa_gentest_id,
            'huu_gentest_id' => $this->huu_gentest_id,
            'deb_gentest_id' => $this->deb_gentest_id,
            'buff_gentest_id' => $this->buff_gentest_id,
            'mdr1_gentest_id' => $this->mdr1_gentest_id,
            'md_gentest_id' => $this->md_gentest_id,
            'cord1_pra_gentest_id' => $this->cord1_pra_gentest_id,
            'glasknochen_gentest_id' => $this->glasknochen_gentest_id,
            'stgd_gentest_id' => $this->stgd_gentest_id,
            'oi_gentest_id' => $this->oi_gentest_id,
        ];
        //  return parent::toArray($request);
    }
}
