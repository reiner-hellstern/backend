<?php

namespace App\Http\Resources;

use App\Models\Hund;
use Illuminate\Http\Resources\Json\JsonResource;

class HundTableResource extends JsonResource
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

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rasse_name' => $this->rasse->name,
            'farbe_name' => $this->farbe->name,
            'geschlecht_name' => $this->geschlecht->name,
            'rasse' => new OptionNameResource($this->rasse),
            'farbe' => new OptionNameResource($this->farbe),
            'geschlecht' => new OptionNameResource($this->geschlecht),
            'zuchtbuchnummer' => $this->zuchtbuchnummer,
            // 'wurfdatum' => ($this->wurfdatum != "0000-00-00 00:00:00" ? date( 'd.m.Y', strtotime($this->wurfdatum)): ''),
            'wurfdatum' => $this->wurfdatum,
            'chipnummer' => $this->chipnummer,
            'vater_zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
            'mutter_zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
            'zuchthund' => $zuchthund,
            'zwinger_nr' => $this->zwinger_nr,
            'mutter_name' => $this->mutter_name,
            'vater_name' => $this->vater_name,
            'zwinger_name' => $this->zwinger_name,
            'zwinger_strasse' => $this->zwinger_strasse,
            'zwinger_plz' => $this->zwinger_plz,
            'zwinger_ort' => $this->zwinger_ort,
            'zwinger_fci' => $this->zwinger_fci,
            'zwinger_nr' => $this->zwinger_nr,
            'bemerkung' => $this->bemerkung,
            // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
            // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        ];
    }
}
