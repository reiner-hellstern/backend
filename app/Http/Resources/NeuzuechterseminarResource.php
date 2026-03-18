<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NeuzuechterseminarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'person_id' => $this->person_id,
            'person' => $this->whenLoaded('person'),
            'datum' => $this->datum,
            'ort' => $this->ort,
            'bemerkungen' => $this->bemerkungen,
            'event_id' => $this->event_id,
            'event' => $this->whenLoaded('event'),
            'aktiv' => $this->aktiv,
            'status' => $this->status,
            'bestaetigt_am' => $this->bestaetigt_am,
            'bestaetigt_von' => $this->bestaetigt_von,
            'bestaetiger' => $this->whenLoaded('bestaetigtVon'),
            'dokumente' => $this->whenLoaded('dokumente'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
