<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AusbilderResource extends JsonResource
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
                'mitglied' => [
                    'id' => $this->person->mitglied->id ?? null,
                    'mitgliedsnummer' => $this->person->mitglied->mitgliedsnummer ?? null,
                    'landesgruppe' => [
                        'id' => $this->person->mitglied->landesgruppe->id ?? null,
                        'landesgruppe' => $this->person->mitglied->landesgruppe->landesgruppe ?? null,
                    ],
                    'bezirksgruppe' => [
                        'id' => $this->person->mitglied->bezirksgruppe->id ?? null,
                        'bezirksgruppe' => $this->person->mitglied->bezirksgruppe->bezirksgruppe ?? null,
                    ],
                ],
            ],
            'beginn' => $this->beginn,
            'ende' => $this->ende,
            'status_id' => $this->status_id,
            'status' => $this->when($this->status, [
                'id' => $this->status?->id,
                'name' => $this->status?->name,
                'name_kurz' => $this->status?->name_kurz,
            ]),
            'ausweisnummer' => $this->ausweisnummer,
            'ausweis_status_id' => $this->ausweis_status_id,
            'ausweis_status' => $this->when($this->ausweisStatus, [
                'id' => $this->ausweisStatus?->id,
                'name' => $this->ausweisStatus?->name,
                'name_kurz' => $this->ausweisStatus?->name_kurz,
            ]),
            'ausbildertypen' => AusbildertypResource::collection($this->whenLoaded('ausbildertypen')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
