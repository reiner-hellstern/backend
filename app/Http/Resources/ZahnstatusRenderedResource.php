<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZahnstatusRenderedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //   return parent::toArray($request);
        return [
            'open' => false,
            'aktiv' => $this->aktiv,
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'datum' => $this->datum,
            'bewertung' => $this->bewertung,
            'quelle_id' => $this->quelle_id,
            'quelle' => $this->quelle,
            'gebiss_id' => $this->gebiss_id,
            'gebiss' => $this->gebiss,
            'pruefung_id' => $this->pruefung_id,
            'veranstaltung_id' => $this->veranstaltung_id,
            'textform' => $this->textform,
            'anmerkung' => $this->anmerkung,
        ];

        //  return parent::toArray($request);
    }
}
