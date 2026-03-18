<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatellaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $arzt = $this->arzt ? new ArztResource($this->arzt) : new ArztEmptyResource('null');

        return [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum_operation' => $this->datum_operation,
            'datum' => $this->datum,
            'anmerkungen' => $this->anmerkungen,
            'verdacht' => $this->verdacht,
            'befund' => $this->befund,
            'operation' => $this->operation,
            'grund_operation_id' => $this->grund_operation_id,
            'grund_operation' => $this->grund_operation,
            'lokation_links' => $this->lokation_links,
            'lokation_rechts' => $this->lokation_rechts,
            'score_links_id' => $this->score_links_id,
            'score_rechts_id' => $this->score_rechts_id,
            'score_gesamt_id' => $this->score_gesamt_id,
            'patellaluxation' => $this->patellaluxation,
            'arzt' => $arzt,
        ];
    }
}
