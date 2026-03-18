<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VeranstaltungResource extends JsonResource
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

        $output['select_unterlagen_jagdlich'] = $this->getSelectUnterlagenJagdlich();
        $output['select_unterlagen_nichtjagdlich'] = $this->getSelectUnterlagenNichtJagdlich();
        $output['veranstaltungskategorie'] = $this->getOptionVeranstaltungskategorie();
        $output['veranstaltungstyp'] = $this->getOptionVeranstaltungstyp();
        $output['veranstalter_landesgruppe'] = $this->getOptionVeranstalterLandesgruppe();
        $output['veranstalter_bezirksgruppe'] = $this->getOptionVeranstalterBezirksgruppe();
        $output['ausrichter_landesgruppe'] = $this->getOptionAusrichterLandesgruppe();
        $output['ausrichter_bezirksgruppe'] = $this->getOptionAusrichterBezirksgruppe();
        $output['zahlung_optionen'] = $this->getOptionZahlung();
        $output['meldung_notwendig'] = $this->getOptionMeldungNotwendig();
        $output['meldung_adresse_opt'] = $this->getOptionMeldungAdresseOpt();
        $output['meldung_unterlagen_jagdlich'] = $this->getMeldungUnterlagenJagdlich();
        $output['meldung_unterlagen_nichtjagdlich'] = $this->getMeldungUnterlagenNichtJagdlich();

        return $output;
    }
}
