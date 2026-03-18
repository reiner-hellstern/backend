<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EigentuemerwechselantragResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $eigentuemerwechselantrag = [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'antragsteller' => new AdresseResource($this->antragsteller),
            'typ' => new OptionNameResource($this->typ),
            'bearbeiter' => $this->bearbeiter,
            'bemerkungen_antragsteller' => $this->bemerkungen_antragsteller,
            'sent_at' => $this->sent_at,
            'dokumente' => $this->dokumente,
            'status' => $this->status,
            'kommentare' => $this->kommentare,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        return $eigentuemerwechselantrag;

    }
}
