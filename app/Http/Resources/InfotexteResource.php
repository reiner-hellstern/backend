<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfotexteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'section' => $this->section ? [
                'id' => $this->section->id,
                'name' => $this->section->name,
                'name_kurz' => $this->section->name_kurz,
            ] : null,
            'thema' => $this->thema,
            'position' => $this->position,
            'vue_component' => $this->vue_component,
            'slug' => $this->slug,
            'titel' => $this->titel,
            'text' => $this->text,
            'aktiv' => $this->aktiv,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles_count' => $this->when(isset($this->roles_count), $this->roles_count),
            'assignables_summary' => $this->when(isset($this->assignables_summary), $this->assignables_summary),
            'assignables' => $this->whenLoaded('assignables', function () {
                return $this->assignables->map(function ($assignable) {
                    return [
                        'id' => $assignable->assignable->id,
                        'name' => method_exists($assignable->assignable, 'getDisplayName') ? $assignable->assignable->getDisplayName() : ($assignable->assignable->name ?? ''),
                        'type' => class_basename($assignable->assignable_type),
                    ];
                });
            }),
        ];
    }
}
