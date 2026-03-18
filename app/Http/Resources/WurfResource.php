<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WurfResource extends JsonResource
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
            'zwinger_id' => $this->zwinger_id,
            'wurfbuchstabe' => $this->wurfbuchstabe,

            // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
            // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        ];

        return parent::toArray($request);
    }
}
