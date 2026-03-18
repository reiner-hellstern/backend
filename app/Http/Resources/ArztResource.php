<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArztResource extends JsonResource
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
            'praxisname' => $this->praxisname,
            'titel' => $this->titel,
            'vorname' => $this->vorname,
            'nachname' => $this->nachname,
            'strasse' => $this->strasse,
            'adresszusatz' => $this->adresszusatz,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'land' => $this->land,
            'land_kuerzel' => $this->land_kuerzel,
            'telefon_1' => $this->telefon_1,
            'telefon_2' => $this->telefon_2,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'website_1' => $this->website_1,
            'website_2' => $this->website_2,
            'anmerkungen' => $this->anmerkungen,
            'aktiv' => $this->aktiv,
            'autocomplete' => $this->autocomplete,
            'full_name' => $this->full_name,
            'full_address' => $this->full_address,
            'fachgebiete' => $this->whenLoaded('fachgebiete'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
