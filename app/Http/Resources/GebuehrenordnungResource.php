<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GebuehrenordnungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gueltig_ab' => $this->gueltig_ab,
            'gueltig_bis' => $this->gueltig_bis,
            'stand' => $this->stand,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gebuehren' => $this->whenLoaded('gebuehren'),
            'grouped_gebuehren' => $this->when(isset($this->grouped_gebuehren), $this->grouped_gebuehren),
        ];
    }
}
