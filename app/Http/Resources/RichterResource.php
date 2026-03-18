<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RichterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'person_id' => $this->person_id,
            'person' => [
                'id' => $this->person->id ?? null,
                'vorname' => $this->person->vorname ?? null,
                'nachname' => $this->person->nachname ?? null,
                'email_1' => $this->person->email_1 ?? null,
                'email_2' => $this->person->email_2 ?? null,
                'telefon_1' => $this->person->telefon_1 ?? null,
                'telefon_2' => $this->person->telefon_2 ?? null,
                'website_1' => $this->person->website_1 ?? null,
                'website_2' => $this->person->website_2 ?? null,
                'strasse' => $this->person->strasse ?? null,
                'postleitzahl' => $this->person->postleitzahl ?? null,
                'ort' => $this->person->ort ?? null,
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
            'richtertypen' => RichtertypResource::collection($this->whenLoaded('richtertypen')),
            'status' => [
                'id' => $this->status->id ?? null,
                'name' => $this->status->name ?? null,
                'name_kurz' => $this->status->name_kurz ?? null,
            ],
            'beginn' => $this->beginn,
            'ende' => $this->ende,
            'drc' => $this->drc,
            'fcinummer' => $this->fcinummer,
            'verein' => $this->verein,
            'anmerkungen' => $this->anmerkungen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
