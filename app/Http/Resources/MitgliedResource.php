<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MitgliedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $output = parent::toArray($request);

        $output['geboren'] = ($output['geboren'] !== '0000-00-00 00:00:00' && $output['geboren'] !== '0000-00-00' && $output['geboren'] !== '' && ! is_null($output['geboren'])) ? Carbon::createFromFormat('Y-m-d', $output['geboren'])->format('d.m.Y') : '';

        $output['landesgruppe'] = $this->getOptionLandesgruppe();
        $output['bezirksgruppe'] = $this->getOptionBezirksgruppe();
        $output['status'] = $this->status ? [
            'id' => $this->status->id,
            'name' => $this->status->name,
            'beschreibung' => $this->status->beschreibung,
        ] : null;

        return $output;

        return [
            'id' => $this->id,
            'mitglied_nr' => $this->mitglied_nr,
            'landesgruppe' => [
                'name' => $this->landesgruppe,
                'id' => $this->landesgruppe_id,
            ],
            'bezirksgruppe' => [
                'name' => $this->bezirksgruppe,
                'id' => $this->bezirksgruppe_id,
            ],
        ];

    }
}
