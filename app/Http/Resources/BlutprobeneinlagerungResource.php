<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlutprobeneinlagerungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $arzt = $this->arzt ? new ArztResource($this->arzt) : new ArztEmptyResource('null');
        // $labor = $this->labor ? new LaborResource($this->labor) : new LaborEmptyResource('null');

        return [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum' => $this->datum,
            'anmerkungen' => $this->anmerkungen,
            'generatio' => $this->generatio,
            'datum_einlagerung' => $this->datum_einlagerung,
            'datum_blutentnahme' => $this->datum_blutentnahme,
            'labornummer' => $this->labornummer,
            'arzt' => $arzt,
        ];

        //  return parent::toArray($request);
    }
}
