<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KontaktdatenaenderungResource extends JsonResource
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

            // Namensdaten
            'vorname' => $this->vorname,
            'nachname' => $this->nachname,
            'nachname_ehemals' => $this->nachname_ehemals,
            'geboren' => $this->geboren,

            // Kontaktdaten
            'telefon_1' => $this->telefon_1,
            'telefon_2' => $this->telefon_2,
            'telefon_3' => $this->telefon_3,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'website_1' => $this->website_1,
            'website_2' => $this->website_2,

            // Adressdaten
            'strasse' => $this->strasse,
            'adresszusatz' => $this->adresszusatz,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'land' => $this->land,
            'laenderkuerzel' => $this->laenderkuerzel,
            'postfach_plz' => $this->postfach_plz,
            'postfach_nummer' => $this->postfach_nummer,

            // Status und Bemerkungen
            'bemerkungen' => $this->bemerkungen,
            'aktiv' => $this->aktiv,
            'bestaetigt_am' => $this->bestaetigt_am ? $this->bestaetigt_am->format('d.m.Y H:i') : '',
            'bestaetigt_von' => $this->bestaetigt_von,

            // Timestamps
            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at->format('d.m.Y H:i'),

            // Relationships
            'person' => $this->whenLoaded('person'),
            'bestaetigtVon' => $this->whenLoaded('bestaetigtVon'),
            'dokumente' => $this->whenLoaded('dokumente'),
        ];
    }
}
