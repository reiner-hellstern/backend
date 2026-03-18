<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SonderleiterResource extends JsonResource
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
            'person_id' => $this->person_id,
            'person' => [
                'id' => $this->person->id,
                'vorname' => $this->person->vorname,
                'nachname' => $this->person->nachname,
                'strasse' => $this->person->strasse,
                'postleitzahl' => $this->person->postleitzahl,
                'ort' => $this->person->ort,
                'telefon_1' => $this->person->telefon_1,
                'email_1' => $this->person->email_1,
            ],
            'beginn' => $this->beginn,
            'beginn_formatted' => $this->beginn_formatted,
            'ende' => $this->ende,
            'ende_formatted' => $this->ende_formatted,
            'status_id' => $this->status_id,
            'status' => $this->when($this->status, [
                'id' => $this->status?->id,
                'name' => $this->status?->name,
                'name_kurz' => $this->status?->name_kurz,
            ]),
            'aktiv' => $this->aktiv,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
