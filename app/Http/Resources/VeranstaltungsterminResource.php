<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VeranstaltungsterminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $termin = date('d.m.Y', strtotime($this->date));
        $beginn = ($this->beginn ? $this->beginn['hours'] . ':' . $this->beginn['minutes'] : '');
        $ende = ($this->ende ? $this->ende['hours'] . ':' . $this->ende['minutes'] : '');

        if ($beginn != '' && $ende != '') {
            $termin .= ' (' . $beginn . ' - ' . $ende . ' Uhr)';
        } elseif ($beginn != '') {
            $termin .= ' (ab ' . $beginn . ' Uhr)';
        } elseif ($ende != '') {
            $termin .= ' (bis ' . $ende . ' Uhr)';
        }

        return [
            'veranstaltung_id' => $this->veranstaltung_id,
            'termin' => date('d.m.Y', strtotime($this->date)),
            // 'datum' => date( 'd.m.Y', strtotime($this->date)),
            // 'beginn' => ($this->beginn ? $this->beginn['hours'].":".$this->beginn['minutes'] : ''),
            // 'ende' => ($this->ende ? $this->ende['hours'].":".$this->ende['minutes'] : ''),
            'beschreibung' => $this->beschreibung,
        ];
    }
}
