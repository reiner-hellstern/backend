<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HodenResource extends JsonResource
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
            'quelle' => $this->quelle,
            'tastbarkeit_id' => $this->tastbarkeit_id,
            'senkung_id' => $this->senkung_id,
            'operation' => $this->operation,
            'grund_operation_id' => $this->grund_operation_id,
            'grund_operation' => $this->grund_operation,
            'arzt' => $arzt,
        ];

        // return parent::toArray($request);
    }
}
