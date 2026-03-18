<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RasseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_lang' => $this->name_lang,
        ];

        return parent::toArray($request);
    }
}
