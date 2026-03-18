<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZahnstatusResource extends JsonResource
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
            'dokumente' => $this->dokumente,
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
            'gutachter_id' => $this->gutachter_id,
            'gutachter_titel' => $this->gutachter_titel,
            'gutachter_vorname' => $this->gutachter_vorname,
            'gutachter_nachname' => $this->gutachter_nachname,
            'gutachter_praxis' => $this->gutachter_praxis,
            'gutachter_strasse' => $this->gutachter_strasse,
            'gutachter_plz' => $this->gutachter_plz,
            'gutachter_ort' => $this->gutachter_ort,
            'gutachter_land' => $this->gutachter_land,
            'gutachter_land_kuerzel' => $this->gutachter_land_kuerzel,
            'gutachter_email' => $this->gutachter_email,
            'gutachter_website' => $this->gutachter_website,
            'gutachter_telefon_1' => $this->gutachter_telefon_1,
            'gutachter_telefon_2' => $this->gutachter_telefon_2,
            'textform' => $this->textform,
            'anmerkung' => $this->anmerkung,
            'm2or' => $this->m2or,
            'm1or' => $this->m1or,
            'p4or' => $this->p4or,
            'p3or' => $this->p3or,
            'p2or' => $this->p2or,
            'p1or' => $this->p1or,
            'cor' => $this->cor,
            'i3or' => $this->i3or,
            'i2or' => $this->i2or,
            'i1or' => $this->i1or,
            'i1ol' => $this->i1ol,
            'i2ol' => $this->i2ol,
            'i3ol' => $this->i3ol,
            'col' => $this->col,
            'p1ol' => $this->p1ol,
            'p2ol' => $this->p2ol,
            'p3ol' => $this->p3ol,
            'p4ol' => $this->p4ol,
            'm1ol' => $this->m1ol,
            'm2ol' => $this->m2ol,
            'm3ur' => $this->m3ur,
            'm2ur' => $this->m2ur,
            'm1ur' => $this->m1ur,
            'p4ur' => $this->p4ur,
            'p3ur' => $this->p3ur,
            'p2ur' => $this->p2ur,
            'p1ur' => $this->p1ur,
            'cur' => $this->cur,
            'i3ur' => $this->i3ur,
            'i2ur' => $this->i2ur,
            'i1ur' => $this->i1ur,
            'i1ul' => $this->i1ul,
            'i2ul' => $this->i2ul,
            'i3ul' => $this->i3ul,
            'cul' => $this->cul,
            'p1ul' => $this->p1ul,
            'p2ul' => $this->p2ul,
            'p3ul' => $this->p3ul,
            'p4ul' => $this->p4ul,
            'm1ul' => $this->m1ul,
            'm2ul' => $this->m2ul,
            'm3ul' => $this->m3ul,
        ];

        //  return parent::toArray($request);
    }
}
