<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OCDUntersuchungRenderedResource extends JsonResource
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
            'aktiv' => $this->aktiv,
            'operiert' => $this->operiert,
            'operiert_datum' => $this->operiert_datum,
            'datum' => $this->datum,
            'ocd' => $this->ocd_score_rendered,
            'ocd_schulter' => $this->ocd_schulter_score_rendered,
            'ocd_ellenbogen' => $this->ocd_ellenbogen_score_rendered,
            'ocd_sprunggelenk' => $this->ocd_sprunggelenk_score_rendered,
            'coronid_l' => $this->coronid_l_score_rendered,
            'coronid_r' => $this->coronid_r_score_rendered,
            'anmerkungen' => $this->anmerkungen,
        ];

        //  return parent::toArray($request);
    }
}
