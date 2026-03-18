<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArztEmptyResource extends JsonResource
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
            'id' => 0,
            'praxisname' => '',
            'titel' => '',
            'vorname' => '',
            'nachname' => '',
            'strasse' => '',
            'adresszusatz' => '',
            'postleitzahl' => '',
            'ort' => '',
            'land' => '',
            'laenderkuerzel' => '',
            'telefon_1' => '',
            'telefon_2' => '',
            'email_1' => '',
            'email_2' => '',
            'website_1' => '',
            'website_2' => '',
        ];

    }
}
