<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaborResource extends JsonResource
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
            'strasse' => $this->strasse,
            'adresszusatz' => $this->adresszusatz,
            'postleitzahl' => $this->postleitzahl,
            // 'postfach_nummer' => $this->postfach_nummer,
            // 'postfach_plz' => $this->postfach_plz,
            'ort' => $this->ort,
            'land' => $this->land,
            'laenderkuerzel' => $this->laenderkuerzel,
            'telefon_1' => $this->telefon_1,
            'telefon_2' => $this->telefon_2,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'website' => $this->website,
        ];

        // return parent::toArray($request);
    }
}
