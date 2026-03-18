<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KastrationSterilisationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $arzt = $this->arzt ? new ArztResource($this->arzt) : new ArztEmptyResource('null');

        return [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum' => $this->datum,
            'anmerkungen' => $this->anmerkungen,
            'status_id' => $this->status_id,
            'kastration' => $this->kastration,
            'sterilisation' => $this->sterilisation,
            'arzt' => $arzt,
        ];

        // return parent::toArray($request);
    }
}
