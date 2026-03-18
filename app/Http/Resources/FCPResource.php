<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FCPResource extends JsonResource
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
            'operation' => $this->operation,
            'grund_operation' => $this->grund_operation,
            'anmerkungen' => $this->anmerkungen,
            'formularcode' => $this->formularcode,
            'operationsgrund' => $this->operationsgrund,
            'grund_operation_id' => $this->grund_operation_id,
            'arzt' => $arzt,
        ];

        // return parent::toArray($request);
    }
}
