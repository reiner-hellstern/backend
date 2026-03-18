<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UreterResource extends JsonResource
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
            'verdacht' => $this->verdacht,
            'tieraerztlicher_befund' => $this->tieraerztlicher_befund,
            'operation' => $this->operation,
            'score_links_id' => $this->score_links_id,
            'score_rechts_id' => $this->score_rechts_id,
            'arzt' => $arzt,
        ];

        //  return parent::toArray($request);
    }
}
