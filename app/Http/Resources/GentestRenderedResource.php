<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GentestRenderedResource extends JsonResource
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
            'hund_id' => $this->hund_id,
            'bemerkungen' => $this->bemerkungen,
            'dna_profil' => $this->dna_profil,
            'pra_test' => $this->pra_test,
            'pra_prcd' => $this->pra_prcd,
            'cnm' => $this->cnm,
            'eic' => $this->eic,
            'dm' => $this->dm,
            'sd2' => $this->sd2,
            'narc' => $this->narc,
            'rd_osd' => $this->rd_osd,
            'cea_ch' => $this->cea_ch,
            'gr_pra1' => $this->gr_pra1,
            'gr_pra2' => $this->gr_pra2,
            'haarlaenge' => $this->haarlaenge,
            'gsdiiia' => $this->gsdiiia,
            'grmd' => $this->grmd,
            'ict_a' => $this->ict_a,
            'ed_sfs' => $this->ed_sfs,
            'hnpk' => $this->hnpk,
            'ncl5' => $this->ncl5,
            'ncl_f' => $this->ncl_f,
            'farbtest_gelb' => $this->farbtest_gelb,
            'farbtest_braun' => $this->farbtest_braun,
            'farbverduennung' => $this->farbverduennung,
            'den' => $this->den,
            'ict_2' => $this->ict_2,
            'jadd' => $this->jadd,
            'cp1' => $this->cp1,
            'cps' => $this->cps,
            'clps' => $this->clps,
            'cms' => $this->cms,
            'dil' => $this->dil,
            'mh' => $this->mh,
            'cddy' => $this->cddy,
            'ivdd' => $this->ivdd,
            'cdpa' => $this->cdpa,
            'huu' => $this->huu,
            'deb' => $this->deb,
            'buff' => $this->buff,
            'mdr1' => $this->mdr1,
            'md' => $this->md,
            'cord1_pra' => $this->cord1_pra,
            'glasknochen' => $this->glasknochen,
            'stgd' => $this->stgd,
            'oi' => $this->oi,
        ];
        //  return parent::toArray($request);
    }
}
