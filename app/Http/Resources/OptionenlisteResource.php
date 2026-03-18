<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionenlisteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'beschreibung' => $this->beschreibung,
            'model' => $this->model,
            'section_id' => $this->section_id,
            'sortierung' => $this->sortierung,
            'fields' => $this->fields,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Section nur wenn sie existiert
        if ($this->section !== null) {
            $data['section'] = [
                'id' => $this->section->id,
                'name' => $this->section->name,
                'name_kurz' => $this->section->name_kurz,
            ];
        }

        return $data;
    }
}
