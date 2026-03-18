<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkkategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_kurz' => $this->name_kurz,
            'beschreibung' => $this->beschreibung,
            'aktiv' => $this->aktiv,
            'order' => $this->order,
            'links_count' => $this->links_count,
            'links' => LinkResource::collection($this->whenLoaded('links')),
            'created_at' => $this->created_at?->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at?->format('d.m.Y H:i'),
        ];
    }
}
