<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaborEmptyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => 0,
            'name' => '',
            'strasse' => '',
            'adresszusatz' => '',
            'postleitzahl' => '',
            // 'postfach_nummer' => '',
            // 'postfach_plz' => '',
            'ort' => '',
            'land' => '',
            'laenderkuerzel' => '',
            'telefon_1' => '',
            'telefon_2' => '',
            'email_1' => '',
            'email_2' => '',
            'website' => '',
        ];

    }
}
