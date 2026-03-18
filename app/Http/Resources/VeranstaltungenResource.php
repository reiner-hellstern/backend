<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VeranstaltungenResource extends JsonResource
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
        $output['erstertermin'] = ($output['erstertermin'] !== '0000-00-00 00:00:00' && $output['erstertermin'] !== '0000-00-00' && $output['erstertermin'] !== '' && ! is_null($output['erstertermin'])) ? Carbon::createFromFormat('Y-m-d', $output['erstertermin'])->format('d.m.Y') : '';
        $output['letztertermin'] = ($output['letztertermin'] !== '0000-00-00 00:00:00' && $output['letztertermin'] !== '0000-00-00' && $output['letztertermin'] !== '' && ! is_null($output['letztertermin'])) ? Carbon::createFromFormat('Y-m-d', $output['letztertermin'])->format('d.m.Y') : '';

        $output['letztertermin_test'] = $this->letztertermin;
        $output['erstertermin_test'] = $this->erstertermin;
        $output['meldungen_test'] = $this->OptionVeranstaltungskategorie;
        $output['meldungen_angenommen_test'] = $this->meldungen_angenommen;

        return $output;
    }
}
