<?php

namespace App\Http\Resources;

use App\Models\Hund;
use Illuminate\Http\Resources\Json\JsonResource;

class HundBasisdatenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $this->zuchthund == '1' ? $zuchthund = 'Ja' : $zuchthund = '';
        // $farbe = $this->farbe_id ? [
        //    "name" => $this->farbe_name,
        //    "id" => $this->farbe_id ]

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'drc' => $this->drc,
            'name' => $this->name,
            'rasse' => new OptionNameResource($this->rasse),
            'farbe' => new OptionNameResource($this->farbe),
            'geschlecht' => new OptionNameResource($this->geschlecht),
            'zuchtbuchnummer' => $this->zuchtbuchnummer,
            'zuchtbuchnummern' => ZuchtbuchnummerResource::collection($this->zuchtbuchnummern),
            'zuchtbuchnummern_check' => $this->zuchtbuchnummern,
            // 'wurfdatum' => ($this->wurfdatum != "0000-00-00 00:00:00" ? date( 'd.m.Y', strtotime($this->wurfdatum)): ''),
            'chipnummer' => $this->chipnummer,
            'chipnummern' => ChipnummerResource::collection($this->chipnummern),
            'taetowierung' => $this->taetowierung,

            'drc_gstb_nr' => $this->drc_gstb_nr,
            'gstb_nr' => $this->gstb_nr,

            'wurfdatum' => $this->wurfdatum,
            'zuchtart' => $this->zuchtart,
            'verstorben' => $this->verstorben,
            'sterbedatum' => $this->sterbedatum,
            'todesursache' => $this->todesursache,
            'todesursache_anmerkung' => $this->todesursache_anmerkung,
            'eingeschlaefert' => $this->eingeschlaefert,
            'eingeschlaefert_anmerkung' => $this->eingeschlaefert_anmerkung,

            'bemerkung' => $this->bemerkung,

            'vater_id' => $this->vater_id,
            'mutter_id' => $this->mutter_id,
            'vater_zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
            'mutter_zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
            'vater_name' => $this->vater_name,
            'mutter_name' => $this->mutter_name,

            'abstammungsnachweis' => $this->abstammungsnachweis ? $this->abstammungsnachweis->abstammungsnachweis : 0,

            'zwinger_id' => $this->zwinger_id,
            'zuchttauglichkeit_id' => $this->zuchttauglichkeit_id,

            'zuchthund' => $zuchthund,
            'zwinger_id' => $this->zwinger_id,
            'zwinger_nr' => $this->zwinger_nr,
            'zwinger_name' => $this->zwinger_name,
            'zwinger_strasse' => $this->zwinger_strasse,
            'zwinger_plz' => $this->zwinger_plz,
            'zwinger_ort' => $this->zwinger_ort,
            'zwinger_fci' => $this->zwinger_fci,
            'zwinger_telefon' => $this->zwinger_telefon,
            // 'zwinger_telefon2' => $this->zwinger_telefon2,

            'zuechter_id' => $this->bemerkung,
            'zuechter_vorname' => $this->zuechter_vorname,
            'zuechter_nachname' => $this->zuechter_nachname,

            'freigabe' => $this->freigabe,

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
            // 'zuechter_telefon1' => $this->zuechter_telefon1,
            // 'zuechter_telefon2' => $this->zuechter_telefon2,
            // 'zuechter_email1' => $this->zuechter_email1,
            // 'zuechter_email2' => $this->zuechter_email2,
            // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
            // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        ];
    }
}
