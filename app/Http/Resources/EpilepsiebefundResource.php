<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpilepsiebefundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $arzt = $this->arzt ? new ArztResource($this->arzt) : new ArztEmptyResource('null');

        $labor = $this->labor ? new LaborResource($this->labor) : new LaborEmptyResource('null');

        return [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum' => $this->datum,
            'anmerkungen' => $this->anmerkungen,
            'bestaetigt' => $this->bestaetigt,
            'labornummer' => $this->labornummer,
            'labor' => $labor,
            'arzt' => $arzt,

        ];

        // return parent::toArray($request);
    }
}
