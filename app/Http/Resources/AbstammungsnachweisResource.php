<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbstammungsnachweisResource extends JsonResource
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
            'abstammungsnachweis' => $this->abstammungsnachweis,
            'bestaetigt' => $this->bestaetigt,
            'datum_feststellung' => $this->datum_feststellung,
            'datum_blutentnahme' => $this->datum_blutentnahme,
            'labornummer' => $this->labornummer,
            'arzt' => $arzt,
            'labor' => $labor,
        ];

        // return parent::toArray($request);
    }
}
