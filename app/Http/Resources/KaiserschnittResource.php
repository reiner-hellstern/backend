<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KaiserschnittResource extends JsonResource
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
            'quelle_id' => $this->quelle_id,
            'anmerkungen' => $this->anmerkungen,
            'quelle' => $this->quelle,
            'arzt' => $arzt,
        ];

        // return parent::toArray($request);
    }
}
