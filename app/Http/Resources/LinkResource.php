<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
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
            'linkkategorie_id' => $this->linkkategorie_id,
            'name' => $this->name,
            'url' => $this->url,
            'beschreibung' => $this->beschreibung,
            'aktiv' => $this->aktiv,
            'order' => $this->order,
            'fix' => $this->fix,
            'kategorie' => [
                'id' => $this->kategorie?->id,
                'name' => $this->kategorie?->name,
                'name_kurz' => $this->kategorie?->name_kurz,
            ],
            'created_at' => $this->created_at?->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at?->format('d.m.Y H:i'),
        ];
    }
}
