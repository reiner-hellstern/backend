<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdresseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'mitgliedsnummer' => $this->mitgliedsnummer,
            // 'mitgliedsart' => $this->mitgliedsart,
            'anrede' => $this->anrede,
            'geschlecht' => $this->geschlecht,
            'adelstitel' => $this->adelstitel,
            'akademischetitel' => $this->akademischetitel,
            'vorname' => $this->vorname,
            'nachname_praefix' => $this->nachname_praefix,
            'nachname' => $this->nachname,
            'strasse' => $this->strasse,
            'adresszusatz' => $this->adresszusatz,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'land' => $this->land,
            'laenderkuerzel' => $this->laenderkuerzel,
            'telefon_1' => $this->telefon_1,
            'telefon_2' => $this->telefon_2,
            'telefon_3' => $this->telefon_3,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'website_1' => $this->website_1,
            'website_2' => $this->website_2,
        ];
    }
}
