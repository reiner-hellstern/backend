<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HDEDUntersuchungRenderedResource extends JsonResource
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
            'aktiv' => $this->aktiv,
            'hd' => $this->hd,
            'hd_score' => $this->hd_score_rendered,
            'hd_r_score' => $this->hd_r_score_rendered,
            'hd_l_score' => $this->hd_l_score_rendered,
            'hd_uwirbel_score' => $this->hd_uwirbel_score_rendered,
            'ed' => $this->ed,
            'ed_score' => $this->ed_score_rendered,
            'ed_r_score' => $this->ed_r_score_rendered,
            'ed_l_score' => $this->ed_l_score_rendered,
            'ed_arthrose_r_score' => $this->ed_arthrose_r_score_rendered,
            'ed_arthrose_l_score' => $this->ed_arthrose_l_score_rendered,
            'ed_scoretyp_id' => $this->ed_scoretyp_id,
            'ipa' => $this->ipa,
            'fcp' => $this->fcp,
            'ocd' => $this->ocd,
            'coronoid' => $this->coronid,
            'anmerkungen' => $this->anmerkungen,
        ];

        //  return parent::toArray($request);
    }
}
