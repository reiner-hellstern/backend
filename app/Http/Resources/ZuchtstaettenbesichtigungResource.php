<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZuchtstaettenbesichtigungResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'grund' => $this->whenLoaded('grund', function () {
                return [
                    'id' => $this->grund->id,
                    'name' => $this->grund->name,
                ];
            }),
            'status' => $this->whenLoaded('status', function () {
                return [
                    'id' => $this->status->id,
                    'name' => $this->status->name,
                ];
            }),
            'termin_am' => $this->termin_am,
            'antragsteller' => $this->whenLoaded('antragsteller', function () {
                return [
                    'id' => $this->antragsteller->id,
                    'vorname' => $this->antragsteller->vorname,
                    'nachname' => $this->antragsteller->nachname,
                    'mitgliedsnummer' => $this->antragsteller->mitgliedsnummer,
                ];
            }),
            'zuchtwart' => $this->whenLoaded('zuchtwart', function () {
                return [
                    'id' => $this->zuchtwart->id,
                    'person' => $this->zuchtwart->relationLoaded('person') ? [
                        'id' => $this->zuchtwart->person->id,
                        'vorname' => $this->zuchtwart->person->vorname,
                        'nachname' => $this->zuchtwart->person->nachname,
                    ] : null,
                ];
            }),
            'zuchtstaette' => $this->whenLoaded('zuchtstaette', function () {
                return [
                    'id' => $this->zuchtstaette->id,
                    'strasse' => $this->zuchtstaette->strasse,
                    'adresszusatz' => $this->zuchtstaette->adresszusatz,
                    'postleitzahl' => $this->zuchtstaette->postleitzahl,
                    'ort' => $this->zuchtstaette->ort,
                    'land' => $this->zuchtstaette->land,
                    'laenderkuerzel' => $this->zuchtstaette->laenderkuerzel,
                ];
            }),
            'bestaetigung_angaben' => (bool) $this->bestaetigung_angaben,
            'anmerkungen_fuer_zw' => $this->anmerkungen_fuer_zw,
            'created_at' => optional($this->created_at)?->format('Y-m-d H:i:s'),
            'updated_at' => optional($this->updated_at)?->format('Y-m-d H:i:s'),
        ];
    }
}
