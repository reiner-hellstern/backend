<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// use App\Http\Resources\VeranstaltungsterminResource;

class VeranstaltungAnmeldungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $hund = [
            'id' => $this->id,
            'name' => $this->name,
            'untertitel' => $this->untertitel,
            'beschreibung' => $this->beschreibung,
            'veranstalter_bund' => $this->veranstalter_bund,
            'ausrichter_bund' => $this->ausrichter_bund,
            'sonderleiter1' => new AdresseKurzResource($this->sonderleiter1),
            'sonderleiter2' => new AdresseKurzResource($this->sonderleiter2),
            'pruefungsleiter' => new AdresseKurzResource($this->pruefungsleiter),
            // 'richter' => ($this->richter ? new AdresseKurzResource($this->richter[0]->person) : ''),
            'typ' => $this->veranstaltungstyp_id,
            'kategorie_id' => $this->veranstaltungskategorie_id,
            'kategorie' => ($this->veranstaltungskategorie_id ? $this->veranstaltungskategorie->name : ''),
            'typ_id' => $this->veranstaltungstyp_id,
            'typ' => ($this->veranstaltungstyp_id ? $this->veranstaltungstyp->name : ''),
            'typ_kurz' => ($this->veranstaltungstyp_id ? $this->veranstaltungstyp->name_kurz : ''),
            'zeitablauf' => $this->zeitablauf,
            'tierarzt_vorschriften' => $this->tierarzt_vorschriften,
            'voraussetzungen' => $this->voraussetzungen,
            'vaort_name' => $this->vaort_name,
            'vaort_strasse' => $this->vaort_strasse,
            'vaort_postleitzahl' => $this->vaort_postleitzahl,
            'vaort_ort' => $this->vaort_ort,
            'vaort_adresszusatz' => $this->vaort_adresszusatz,
            'vaort_land' => $this->vaort_land,
            'vaort_laengengrad' => $this->vaort_laengengrad,
            'vaort_breitengrad' => $this->vaort_breitengrad,
            'vaort_beschreibung' => $this->vaort_beschreibung,
            'valokal_name' => $this->valokal_name,
            'valokal_strasse' => $this->valokal_strasse,
            'valokal_postleitzahl' => $this->valokal_postleitzahl,
            'valokal_ort' => $this->valokal_ort,
            'valokal_adresszusatz' => $this->valokal_adresszusatz,
            'valokal_land' => $this->valokal_land,
            'valokal_laengengrad' => $this->valokal_laengengrad,
            'valokal_breitengrad' => $this->valokal_breitengrad,
            'valokal_beschreibung' => $this->valokal_beschreibung,
            'meldung_start' => $this->meldung_start,
            'meldung_schluss' => $this->meldung_schluss,
            'meldung_schluss_ausstellung_1' => $this->meldung_schluss_ausstellung_1,
            'meldung_schluss_ausstellung_2' => $this->meldung_schluss_ausstellung_2,
            'meldung_schluss_ausstellung_3' => $this->meldung_schluss_ausstellung_3,
            'meldung_meldegeld_mitglieder' => $this->meldung_meldegeld_mitglieder,
            'meldung_meldegeld_nichtmitglieder' => $this->meldung_meldegeld_nichtmitglieder,
            'meldung_meldegeld_zahlungsfrist' => $this->meldung_meldegeld_zahlungsfrist,
            'meldung_unterlagen_jagdlich' => $this->meldung_unterlagen_jagdlich,
            'meldung_unterlagen_nichtjagdlich' => $this->meldung_unterlagen_nichtjagdlich,
            'meldeadresse_vorname' => $this->meldeadresse_vorname,
            'meldeadresse_nachname' => $this->meldeadresse_nachname,
            'meldeadresse_strasse' => $this->meldeadresse_strasse,
            'meldeadresse_postleitzahl' => $this->meldeadresse_postleitzahl,
            'meldeadresse_ort' => $this->meldeadresse_ort,
            'meldeadresse_adresszusatz' => $this->meldeadresse_adresszusatz,
            'meldeadresse_land' => $this->meldeadresse_land,
            'meldeadresse_telefon' => $this->meldeadresse_telefon,
            'meldeadresse_email' => $this->meldeadresse_email,
            'zahlung_art_id' => $this->zahlung_art_id,
            'zahlung_bic' => $this->zahlung_bic,
            'zahlung_iban' => $this->zahlung_iban,
            'zahlung_bankname' => $this->zahlung_bankname,
            'teamwettbewerb' => $this->teamwettbewerb,
            'aufgaben_id' => $this->aufgaben_id,
            'aufgaben_anzahl' => $this->aufgaben_anzahl,
            'meldungen_max' => (max([$this->teilnehmer_max, $this->hunde_max]) ? max([$this->teilnehmer_max, $this->hunde_max]) : '---'),
            'teilnehmerfeld_komplett' => $this->teilnehmerfeld_komplett,
            // 'erstertermin' => (($this->erstertermin !== '0000-00-00' && $this->erstertermin !== '' && !is_null($this->erstertermin)) ? date( 'd.m.Y', strtotime($this->erstertermin)): ''),$this->erstertermin,
            // 'letztertermin' => (($this->letztertermin !== '0000-00-00' && $this->letztertermin !== '' && !is_null($this->letztertermin)) ? date( 'd.m.Y', strtotime($this->letztertermin)): ''),$this->letztertermin,
            // 'termine_anzahl' => $this->termine_anzahl,
            'veranstalter_landesgruppe' => ($this->veranstalter_landesgruppe ? $this->veranstalter_landesgruppe->landesgruppe : ''),
            'veranstalter_bezirksgruppe' => ($this->veranstalter_bezirksgruppe ? $this->veranstalter_bezirksgruppe->bezirksgruppe : ''),
            'ausrichter_landesgruppe' => ($this->ausrichter_landesgruppe ? $this->ausrichter_landesgruppe->landesgruppe : ''),
            'ausrichter_bezirksgruppe' => ($this->ausrichter_bezirksgruppe ? $this->ausrichter_bezirksgruppe->bezirksgruppe : ''),
            'termine' => VeranstaltungsterminResource::collection($this->termine),
            'richter' => $this->richter,
            'meldeunterlagen' => ($this->veranstaltungskategorie_id == 2 ? MeldeunterlagenResource::collection($this->unterlagen_jagdlich) : MeldeunterlagenResource::collection($this->unterlagen_nichtjagdlich)),

        ];

        return $hund;
    }
}
