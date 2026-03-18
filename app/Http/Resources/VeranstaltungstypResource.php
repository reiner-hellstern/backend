<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VeranstaltungstypResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tn_min' => $this->tn_min,
            'tn_max' => $this->tn_max,
            'hunde_min' => $this->hunde_min,
            'hunde_max' => $this->hunde_max,
            'aufgaben_min' => $this->aufgaben_min,
            'aufgaben_max' => $this->aufgaben_max,
            'aufgaben_anzahl' => $this->aufgaben_anzahl,
            'rph' => $this->rph,
            'rpa' => $this->rpa,
            'teamwettbewerb' => $this->teamwettbewerb,
        ];
    }
}
