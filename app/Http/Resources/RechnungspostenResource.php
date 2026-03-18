<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RechnungspostenResource extends JsonResource
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
            'rechnung_id' => $this->rechnung_id,
            'gebuehr_id' => $this->gebuehr_id,
            'gebuehr' => new GebuehrResource($this->whenLoaded('gebuehr')),
            'beschreibung' => $this->beschreibung,
            'menge' => $this->menge,
            'einzelpreis' => $this->einzelpreis,
            'notizen' => $this->notizen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
