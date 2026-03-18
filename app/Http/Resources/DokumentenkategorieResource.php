<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DokumentenkategorieResource extends JsonResource
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
            'beschreibung' => $this->beschreibung,
            'reihenfolge' => $this->reihenfolge,
            'aktiv' => $this->aktiv,
            'dokumente_count' => $this->whenLoaded('dokumente', function () {
                return $this->dokumente->count();
            }, $this->dokumente_count ?? 0),
            'dokumente' => $this->whenLoaded('dokumente', function () {
                return $this->dokumente->map(function ($dokument) {
                    return [
                        'id' => $dokument->id,
                        'name' => $dokument->name,
                        'beschreibung' => $dokument->beschreibung,
                        'path' => $dokument->path,
                        'datum' => $dokument->datum,
                        'size' => $dokument->size,
                        'width' => $dokument->width,
                        'height' => $dokument->height,

                        'tags' => $dokument->tags->map(function ($tag) {
                            return [
                                'id' => $tag->id,
                                'name' => $tag->name,
                            ];
                        })->values(),
                        'thumb' => $dokument->thumb,
                        'order' => $dokument->order,
                    ];
                });
            }),
            'assigned_roles' => $this->whenLoaded('assignedRoles', function () {
                return $this->assignedRoles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'title' => $role->title,
                    ];
                });
            }),
            'created_at' => $this->created_at?->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at?->format('d.m.Y H:i'),
        ];
    }
}
