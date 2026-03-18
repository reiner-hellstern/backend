<?php

namespace App\Http\Resources;

use App\Models\Hund;
use Illuminate\Http\Resources\Json\JsonResource;

class HundInitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // return parent::toArray($request);
        //$this->zuchthund == '1' ? $zuchthund = 'Ja' : $zuchthund = '';
        $hund = [
            'id' => $this->id,
            'drc' => $this->drc,
            'name' => $this->name,
            'rasse' => new OptionNameResource($this->rasse),
            'farbe' => new OptionNameResource($this->farbe),
            'geschlecht' => new OptionNameResource($this->geschlecht),
            'zuchtbuchnummer' => $this->zuchtbuchnummer,
            'wurfdatum' => $this->wurfdatum,
            'chipnummer' => '',
            'vater_id' => $this->vater_id,
            'mutter_id' => $this->mutter_id,
            'vater_zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
            'mutter_zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
            'vater_name' => $this->vater_name,
            'mutter_name' => $this->mutter_name,
            'vater' => $this->vater,
            'mutter' => $this->mutter,
            'zuechter_vorname' => $this->zuechter_vorname,
            'zuechter_nachname' => $this->zuechter_nachname,
            'zuechter_id' => $this->zuechter_id,
            'herkunftszuchtstaette_zwingername' => $this->zwinger_name,
            'herkunftszuchtstaette_strasse' => $this->zwinger_strasse,
            'herkunftszuchtstaette_plz' => $this->zwinger_plz,
            'herkunftszuchtstaette_ort' => $this->zwinger_ort,
            'herkunftszuchtstaette_fci' => $this->zwinger_fci,
            'herkunftszuchtstaette_land' => $this->zwinger_land,
            'herkunftszuchtstaette_telefon' => $this->zwinger_tel,
            'herkunftszuchtstaette_id' => $this->zwinger_id,
            'sterbedatum' => $this->sterbedatum,
            'abstammungsnachweis' => $this->abstammungsnachweis,
            'zuchthund' => $this->zuchthund,
            'zuchtart' => $this->zuchtart,
            'freigabe' => $this->freigabe,

            'zwinger_name' => $this->zwinger_name,
            'zwinger_strasse' => $this->zwinger_strasse,
            'zwinger_plz' => $this->zwinger_plz,
            'zwinger_ort' => $this->zwinger_ort,
            'zwinger_fci' => $this->zwinger_fci,
            'zwinger_nr' => $this->zwinger_nr,
            'bemerkung' => $this->bemerkung,

        ];

        $hund['hundanlageantrag'] = $this->hundanlageantrag;

        $hund['herkunftszuchtstaette'] = [
            'name' => $this->zwinger_name,
            'zuechter' => $this->zuechter_vorname . ' ' . $this->zuechter_nachname, // $this->zuechter_vorname . ' ' . $this->zuechter_nachname,
            'strasse' => $this->zwinger_strasse,
            'postleitzahl' => $this->zwinger_plz,
            'ort' => $this->zwinger_ort,
            'fcinummer' => $this->zwinger_fci,
            'land' => $this->zwinger_land,
            'telefon' => $this->zwinger_tel,
        ];

        $hund['vater'] = [
            'id' => $this->vater_id,
            'name' => $this->vater_name,
            'zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
            'rasse' => new OptionNameResource($this->vater_rasse),
            'farbe' => new OptionNameResource($this->vater_farbe),
        ];

        $hund['mutter'] = [
            'id' => $this->mutter_id,
            'name' => $this->mutter_name,
            'zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
            'rasse' => new OptionNameResource($this->mutter_rasse),
            'farbe' => new OptionNameResource($this->mutter_farbe),
        ];

        // ZUCHTBUCHNUMMERN

        $hund['zuchtbuchnummern'] = ZuchtbuchnummerResource::collection($this->zuchtbuchnummern);
        $hund['chipnummern'] = ChipnummerResource::collection($this->chipnummern);
        $hund['chipnummer'] = $this->chipnummern ? ChipnummerResource::collection($this->chipnummern)[0]['chipnummer'] : '';
        $hund['zuchtbuchnummer'] = $this->zuchtbuchnummern ? ZuchtbuchnummerResource::collection($this->zuchtbuchnummern)[0]['zuchtbuchnummer'] : '';

        // BESITZER
        $hund['eigentuemer'] = AdresseKurzResource::collection($this->personen);

        // IMAGES
        $hund['images'] = $this->images;
        $hund['dokumente'] = $this->dokumente;

        return $hund;

        // 'zwinger_name' => $this->zwinger_name,
        // 'zwinger_strasse' => $this->zwinger_strasse,
        // 'zwinger_plz' => $this->zwinger_plz,
        // 'zwinger_ort' => $this->zwinger_ort,
        // 'zwinger_fci' => $this->zwinger_fci,
        // 'zwinger_nr' => $this->zwinger_nr,
        // 'bemerkung' => $this->bemerkung,
        // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
        // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        //       'wurfdatum' => ($this->wurfdatum != "0000-00-00 00:00:00" ? date( 'd.m.Y', strtotime($this->wurfdatum)): ''),

        //   ];

    }
}
