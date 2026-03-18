<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdresseKurzResource extends JsonResource
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
        if (1) {
            return [
                'id' => $this->id,
                'anrede' => $this->anrede,
                'geschlecht' => $this->geschlecht,
                'adelstitel' => $this->adelstitel,
                'akademischetitel' => $this->akademischetitel,
                'vorname' => $this->vorname,
                'nachname_praefix' => $this->nachname_praefix,
                'strasse' => $this->strasse,
                'nachname' => $this->nachname,
                'postleitzahl' => $this->postleitzahl,
                'ort' => $this->ort,
                'land' => $this->land,
                'telefon_1' => $this->telefon_1,
                'telefon_2' => $this->telefon_2,
                'email_1' => $this->email_1,
                'email_2' => $this->email_2,
                'website_1' => $this->website_1,
                'website_2' => $this->website_2,
                'mitgliedsnummer' => $this->mitgliedsnummer ?? '',
            ];
        } else {
            return [
                'anrede' => '',
                'geschlecht' => '',
                'adelstitel' => '',
                'akademischetitel' => '',
                'vorname' => 'Keine',
                'strasse' => '',
                'nachname_praefix' => '',
                'nachname' => 'Freigabe',
                'postleitzahl' => '',
                'ort' => '',
                'land' => '',
                'telefon_1' => '',
                'telefon_2' => '',
                'email_1' => '',
                'email_2' => '',
                'website_1' => '',
                'website_2' => '',
            ];
        }
    }
}
