<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return parent::toArray($request);

        return [
            'id' => $this->id,
            //   'dokumente' => $this->dokumente,
            'mitglied_id' => $this->mitglied_id,
            'zwinger_id' => $this->zwinger_id,
            'mitgliedsnummer' => $this->mitgliedsnummer,
            'mitgliedsart' => $this->mitgliedsart,
            'anrede' => $this->anrede,
            'geschlecht' => $this->geschlecht,
            'adelstitel' => $this->adelstitel,
            'akademischetitel' => $this->akademischetitel,
            'vorname' => $this->vorname,
            'nachname_praefix' => $this->nachname_praefix,
            'nachname' => $this->nachname,
            // 'geboren' =>  ($this->geboren !== "0000-00-00" || $this->geboren !== "" ? date( 'd.m.Y', strtotime($this->geboren)): ''),
            'geboren' => '0000-00-00',
            'post_anrede' => $this->post_anrede,
            'post_name' => $this->post_name,
            'post_co' => $this->post_co,
            'strasse' => $this->strasse,
            'adresszusatz' => $this->adresszusatz,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'postfach_plz' => $this->postfach_plz,
            'postfach_nummer' => $this->postfach_nummer,
            'standard' => $this->standard,
            'land' => $this->land,
            'laenderkuerzel' => $this->aenderkuerzel,
            'telefon_1' => $this->telefon_1,
            'telefon_2' => $this->telefon_2,
            'telefon_3' => $this->telefon_3,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'website_1' => $this->website_1,
            'website_2' => $this->website_2,
            'kommentar' => $this->kommentar,
            'zwingernummer' => $this->zwingernummer,
            'zwingername' => $this->zwingername,
            'eintrittsdatum' => $this->eintrittsdatum,
            'austrittsdatum' => $this->austrittsdatum,
            'nachname_ohne_praefix' => $this->nachname_ohne_praefix,
            'dsgvo' => $this->dsgvo,
            'zwingername_praefix' => $this->zwingername_praefix,
            'zwingername_suffix' => $this->zwingername_suffix,
            'nachname_ehemals' => $this->nachname_ehemals,
            // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
            // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        ];
    }
}
