<?php

namespace App\Http\Resources;

use App\Models\Hund;
use App\Models\HundPrerendered;
use App\Traits\GetPrerenderedHund;
use Illuminate\Http\Resources\Json\JsonResource;

class AhnenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    use GetPrerenderedHund;

    private $generation;

    private $max;

    public function __construct($resource, $generation = 0, $max = 4)
    {
        // Ensure we call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->max = $max; // $apple param passed
        $this->generation = $generation;
    }

    public function toArray($request)
    {

        $dummy = '';

        if ($this->mutter_id != null) {
            // $mutter = Hund::find($this->mutter_id);
            $mutter = $this->getPrerenderedHund($this->mutter_id);
        } else {
            $mutter = new HundPrerendered();
            $mutter->id = 0;
        }
        $mutter->geschlecht_id = 1;

        if ($this->vater_id != null) {
            // $vater = Hund::find($this->vater_id);
            $vater = $this->getPrerenderedHund($this->vater_id);
        } else {
            $vater = new HundPrerendered();
            $vater->hund_id = 0;
        }
        $vater->geschlecht_id = 2;

        switch ($this->generation) {
            case '1':
                $gen = 'I.';
                break;
            case '2':
                $gen = 'II.';
                break;
            case '3':
                $gen = 'III.';
                break;
            case '4':
                $gen = 'IV.';
                break;
            case '5':
                $gen = 'V.';
                break;
            default:
                $gen = '0';
        }

        if ($this->generation++ < $this->max) {
            $hund = [
                'gen' => $gen,
                'generation' => $this->generation - 1,
                'id' => $this->id,
                'name' => $this->name,
                'rasse' => $this->rasse,
                'farbe' => $this->farbe,
                'geschlecht' => $this->geschlecht,
                'geschlecht_id' => $this->geschlecht_id,
                'zuchtbuchnummer' => $this->zuchtbuchnummer,
                'chipnummer' => $this->chipnummer,
                'mutter' => new AhnenResource($mutter, $this->generation, $this->max),
                'vater' => new AhnenResource($vater, $this->generation, $this->max),

            ];

            // $hund['zuchtbuchnummern'] = ZuchtbuchnummerResource::collection($this->zuchtbuchnummern);
            // $hund['chipnummern'] = ChipnummerResource::collection($this->chipnummern);
            // $hund['chipnummer'] = $this->chipnummern ? ChipnummerResource::collection($this->chipnummern)[0]['chipnummer'] : '';
            // $hund['zuchtbuchnummer'] = $this->zuchtbuchnummern ? ZuchtbuchnummerResource::collection($this->zuchtbuchnummern)[0]['zuchtbuchnummer'] : '';

            // if (count($this->hdeduntersuchungen)) {
            //    $hund['hdeduntersuchung'] = true;
            //    $hund['hded_datum'] = $this->hdeduntersuchungen[0]->datum;
            //    $hund['hd_score'] = ($this->hdeduntersuchungen[0]->hd_score['id'] ? $this->hdeduntersuchungen[0]->hd_score['name'] : '');
            //    $hund['hd_l_score'] = ($this->hdeduntersuchungen[0]->hd_l_score['id'] ? $this->hdeduntersuchungen[0]->hd_l_score['name'] : '');
            //    $hund['hd_r_score'] = ($this->hdeduntersuchungen[0]->hd_r_score['id'] ? $this->hdeduntersuchungen[0]->hd_r_score['name'] : '');
            //    $hund['ed_score'] = ($this->hdeduntersuchungen[0]->ed_score['id'] ? $this->hdeduntersuchungen[0]->ed_score['name'] : '');
            //    $hund['ed_l_score'] = ($this->hdeduntersuchungen[0]->ed_l_score['id'] ? $this->hdeduntersuchungen[0]->ed_l_score['name'] : '');
            //    $hund['ed_r_score'] = ($this->hdeduntersuchungen[0]->ed_r_score['id'] ? $this->hdeduntersuchungen[0]->ed_r_score['name'] : '');
            //    $hund['hded_fcp'] = ($this->hdeduntersuchungen[0]->fcp ? 'FCP' : '');
            //    $hund['hded_ipa'] = ($this->hdeduntersuchungen[0]->ipa ? 'IPA' : '');
            //    $hund['hded_ocd'] = ($this->hdeduntersuchungen[0]->ocd ? 'OCD' : '');
            //    $hund['hded_coronoid'] = ($this->hdeduntersuchungen[0]->coronoid ? 'Coronoid' : '');
            //    $hund['ed_arthrose_l_score'] = ($this->hdeduntersuchungen[0]->ed_arthrose_l_score['id'] ? $this->hdeduntersuchungen[0]->ed_arthrose_l_score['name'] : '');
            //    $hund['ed_arthrose_r_score'] = ($this->hdeduntersuchungen[0]->ed_arthrose_r_score['id'] ? $this->hdeduntersuchungen[0]->ed_arthrose_r_score['name'] : '');
            // } else
            //    $hund['hdeduntersuchung'] = false;

            $hund['hdeduntersuchung'] = $this->gelenke;

            // if (count($this->augenuntersuchungen)) {
            //    $hund['augenuntersuchung'] = true;

            //    $hund['au_rd'] =  $this->augenuntersuchungen[0]->rd;
            //    $hund['au_pra_rd'] = $this->augenuntersuchungen[0]->pra_rd;
            //    $hund['au_katarakt_kon'] = $this->augenuntersuchungen[0]->katarakt_kon;
            //    $hund['au_katarakt_nonkon'] = $this->augenuntersuchungen[0]->katarakt_nonkon;
            //    if ($this->augenuntersuchungen[0]->katarakt_nonkon_id > 1) {
            //       $a_temp = [];
            //       if ($this->augenuntersuchungen[0]->katarakt_cortikalis) $a_temp[] = 'lortikalis';
            //       if ($this->augenuntersuchungen[0]->katarakt_polpost) $a_temp[] = 'pol. post.';
            //       if ($this->augenuntersuchungen[0]->katarakt_sutura_ant) $a_temp[] = 'sutura ant.';
            //       if ($this->augenuntersuchungen[0]->katarakt_punctata) $a_temp[] = 'punctata';
            //       if ($this->augenuntersuchungen[0]->katarakt_nuklearis) $a_temp[] = 'nuklearis';
            //       if ($this->augenuntersuchungen[0]->katarakt_sonstige_angaben) $a_temp[] = $this->augenuntersuchungen[0]->katarakt_sonstige_angaben;
            //       $hund['au_katarakt_nonkon_details'] = implode(', ', $a_temp);
            //    } else $hund['au_katarakt_nonkon_details'] = '';

            //    $hund['au_datum'] = $this->augenuntersuchungen[0]->datum;

            // } else
            //    $hund['augenuntersuchung'] = false;

            // if (count($this->goniountersuchung)) {
            //    $hund['goniountersuchung'] = true;
            //    $hund['gu_datum'] = $this->goniountersuchung[0]->datum;
            //    $hund['gu_arzt_titel'] = $this->goniountersuchung[0]->arzt_titel;
            //    $hund['gu_arzt_vorname'] = $this->goniountersuchung[0]->arzt_vorname;
            //    $hund['gu_arzt_nachname'] = $this->goniountersuchung[0]->arzt_nachname;
            //    $hund['gu_dyslpectabnorm'] = $this->goniountersuchung[0]->dyslpectabnorm;
            //    $hund['gu_dyslpectabnorm_nfrei'] = $this->goniountersuchung[0]->dyslpectabnorm_nfrei;

            //    if ($this->goniountersuchung[0]->dyslpectabnorm_id > 1) {

            //       if ($this->goniountersuchung[0]->dyslpectabnorm_nfrei_id > 0) {
            //          $hund['gu_gonio'] = $this->goniountersuchung[0]->dyslpectabnorm_nfrei;
            //       } else {
            //          $a_temp = [];
            //          if ($this->goniountersuchung[0]->dyslpectabnorm_kurztrabekel) $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_kurztrabekel;
            //          if ($this->goniountersuchung[0]->dyslpectabnorm_gewebebruecken) $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_gewebebruecken;
            //          if ($this->goniountersuchung[0]->dyslpectabnorm_totaldyspl) $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_totaldyspl;
            //          $hund['gu_gonio'] = implode(', ', $a_temp);
            //       }
            //    }
            // } else
            //    $hund['goniountersuchung'] = false;

            //
            // ZAHNSTATUS
            //
            // if (count($this->zahnstati)) {
            //    $hund['zahnstatus'] = true;
            //    $hund['zahnstatus_gebiss'] = $this->zahnstati[0]->gebiss['name'];
            //    $hund['zahnstatus_befund'] = trim($this->zahnstati[0]->textform." ".$this->zahnstati[0]->anmerkung);
            //    $hund['zahnstatus_befund_schema'] = $this->zahnstati[0]->textform;
            //    $hund['zahnstatus_befund_anmerkungen'] = $this->zahnstati[0]->anmerkung;
            // } else
            //    $hund['zahnstatus'] = false;

            // PRUEFUNGEN
            $hund['pruefungen'] = $this->pruefungen; //

            // TITEL

            $hund['titel'] = $this->titel;

            // OCD

            // GENTEST

            $hund['gentests'] = $this->gentests;

            $hund['formwert'] = $this->formwert;
            $hund['wesenstest'] = $this->wesenstest;
            $hund['zahnstatus'] = $this->zahnstatus;
            $hund['augenuntersuchung'] = $this->augenuntersuchung;
            $hund['goniountersuchung'] = $this->goniountersuchung;
            $hund['gebiss'] = $this->gebiss;
            $hund['eigentuemer'] = $this->resource->eigentuemer();
            $hund['zuechter'] = $this->zuechter;
            $hund['wurfzwinger'] = $this->wurfzwinger;
            $hund['wurfdatum'] = $this->wurfdatum;

            // if (count($this->gentests_total)) {

            //    $a_temp = [];
            //    if ($this->gentests_total[0]->pra_test_id) $a_temp[] = 'PRA-Test: ' . $this->gentests_total[0]->pra_test;
            //    if ($this->gentests_total[0]->pra_prcd_gentest_id) $a_temp[] = 'prcd-PRA: ' . $this->gentests_total[0]->pra_prcd;
            //    if ($this->gentests_total[0]->cnm_gentest_id) $a_temp[] = 'CMN: ' . $this->gentests_total[0]->cnm;
            //    if ($this->gentests_total[0]->eic_gentest_id) $a_temp[] = 'EIC: ' . $this->gentests_total[0]->eic;
            //    if ($this->gentests_total[0]->dm_gentest_id) $a_temp[] = 'DM: ' . $this->gentests_total[0]->dm;
            //    if ($this->gentests_total[0]->sd2_gentest_id) $a_temp[] = 'SD2: ' . $this->gentests_total[0]->sd2;
            //    if ($this->gentests_total[0]->narc_gentest_id) $a_temp[] = 'Narc: ' . $this->gentests_total[0]->narc;
            //    if ($this->gentests_total[0]->rd_osd_gentest_id) $a_temp[] = 'RD/OSD: ' . $this->gentests_total[0]->rd_osd;
            //    if ($this->gentests_total[0]->cea_ch_gentest_id) $a_temp[] = 'CEA/CH: ' . $this->gentests_total[0]->cea_ch;
            //    if ($this->gentests_total[0]->gr_pra1_gentest_id) $a_temp[] = 'GR-PRA1: ' . $this->gentests_total[0]->gr_pra1;
            //    if ($this->gentests_total[0]->gr_pra2_gentest_id) $a_temp[] = 'GR-PRA2: ' . $this->gentests_total[0]->gr_pra2;
            //    if ($this->gentests_total[0]->haarlaenge_id) $a_temp[] = 'Haarlänge: ' . $this->gentests_total[0]->haarlaenge;
            //    if ($this->gentests_total[0]->gsdiiia_gentest_id) $a_temp[] = 'GSDIIIa: ' . $this->gentests_total[0]->gsdiiia;
            //    if ($this->gentests_total[0]->grmd_gentest_id) $a_temp[] = 'GRMD: ' . $this->gentests_total[0]->grmd;
            //    if ($this->gentests_total[0]->ict_a_gentest_id) $a_temp[] = 'ICT_A: ' . $this->gentests_total[0]->ict_a;
            //    if ($this->gentests_total[0]->ed_sfs_gentest_id) $a_temp[] = 'ED/SFS: ' . $this->gentests_total[0]->ed_sfs;
            //    if ($this->gentests_total[0]->hnpk_gentest_id) $a_temp[] = 'HNPK: ' . $this->gentests_total[0]->hnpk;
            //    if ($this->gentests_total[0]->ncl5_gentest_id) $a_temp[] = 'NCL5: ' . $this->gentests_total[0]->ncl5;
            //    if ($this->gentests_total[0]->ncl_f_gentest_id) $a_temp[] = 'NCL5: ' . $this->gentests_total[0]->ncl_f;
            //    if ($this->gentests_total[0]->farbtest_gelb_id) $a_temp[] = 'DNA-Farbtest Gelb: ' . $this->gentests_total[0]->farbtest_gelb;
            //    if ($this->gentests_total[0]->farbtest_braun_id) $a_temp[] = 'DNA-Farbtest Brau: ' . $this->gentests_total[0]->farbtest_braun;
            //    if ($this->gentests_total[0]->farbverduennung_id) $a_temp[] = 'Farbverdünnung: ' . $this->gentests_total[0]->farbverduennung;
            //    if ($this->gentests_total[0]->den_gentest_id) $a_temp[] = 'DEN: ' . $this->gentests_total[0]->den;
            //    if ($this->gentests_total[0]->ict_2_gentest_id) $a_temp[] = 'ICT_2: ' . $this->gentests_total[0]->ict_2;
            //    if ($this->gentests_total[0]->jadd_gentest_id) $a_temp[] = 'JADD: ' . $this->gentests_total[0]->jadd;
            //    if ($this->gentests_total[0]->ivdd_gentest_id) $a_temp[] = 'IVDD-Typ1: ' . $this->gentests_total[0]->ivdd;
            //    if ($this->gentests_total[0]->cp1_gentest_id) $a_temp[] = 'CP1: ' . $this->gentests_total[0]->cp1;
            //    if ($this->gentests_total[0]->cps_gentest_id) $a_temp[] = 'CPS: ' . $this->gentests_total[0]->cps;
            //    if ($this->gentests_total[0]->clps_gentest_id) $a_temp[] = 'CLPS: ' . $this->gentests_total[0]->clps;
            //    if ($this->gentests_total[0]->cms_gentest_id) $a_temp[] = 'CMS: ' . $this->gentests_total[0]->cms;
            //    // if ( $this->gentests_total[0]->dann_farbtest_id ) $a_temp[] = 'DANN Farbtest: '.$this->gentests_total[0]->dann_farbtest;
            //    if ($this->gentests_total[0]->mh_gentest_id) $a_temp[] = 'MH: ' . $this->gentests_total[0]->mh;
            //    if ($this->gentests_total[0]->cddy_gentest_id) $a_temp[] = 'CDDY: ' . $this->gentests_total[0]->cddy;
            //    if ($this->gentests_total[0]->cdpa_gentest_id) $a_temp[] = 'CDPA: ' . $this->gentests_total[0]->cdpa;
            //    if ($this->gentests_total[0]->huu_gentest_id) $a_temp[] = 'HUU: ' . $this->gentests_total[0]->huu;
            //    if ($this->gentests_total[0]->deb_gentest_id) $a_temp[] = 'DEB: ' . $this->gentests_total[0]->deb;
            //    if ($this->gentests_total[0]->buff_gentest_id) $a_temp[] = 'BUFF: ' . $this->gentests_total[0]->buff;
            //    if ($this->gentests_total[0]->dil_gentest_id) $a_temp[] = 'DIL: ' . $this->gentests_total[0]->dil;
            //    if ($this->gentests_total[0]->md_gentest_id) $a_temp[] = 'MD: ' . $this->gentests_total[0]->md;
            //    if ($this->gentests_total[0]->mdr1_gentest_id) $a_temp[] = 'MDR1: ' . $this->gentests_total[0]->mdr1;
            //    if ($this->gentests_total[0]->cord1_pra_gentest_id) $a_temp[] = 'CORD1_PRA: ' . $this->gentests_total[0]->cord1_pra;
            //    if ($this->gentests_total[0]->glasknochen_gentest_id) $a_temp[] = 'Glasknochen: ' . $this->gentests_total[0]->glasknochen;
            //    if ($this->gentests_total[0]->stgd_gentest_id) $a_temp[] = 'STGD: ' . $this->gentests_total[0]->stgd;
            //    if ($this->gentests_total[0]->oi_gentest_id) $a_temp[] = 'OI: ' . $this->gentests_total[0]->oi;

            //    $hund['gentests'] =  implode(', ', $a_temp);
            //    $hund['gentests_array'] =  $a_temp;
            //    $hund['gentests_total'] = count($a_temp);
            // dna_profil, pra_test, pra_prcd, cnm, eic, dm, sd2, narc, rd_osd, cea_ch, gr_pra1, gr_pra2, haarlaenge, gsdiiia, grmd, ict_a, ed_sfs, hnpk    , ncl5, ncl_f, farbtest_gelb, farbtest_braun, farbverduennung, den, ict_2, jadd, ivdd, cp1, cps, clps, cms, dann_farbtest, mh, cddy, cdpa, huu, deb, buff, dil, md, mdr1, cord1_pra, glasknochen, stgd, oi, }
            // }
            return $hund;
        }
    }
}
