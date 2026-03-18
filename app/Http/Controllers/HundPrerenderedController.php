<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHundPrerenderedRequest;
use App\Http\Requests\UpdateHundPrerenderedRequest;
use App\Models\Hund;
use App\Models\HundPrerendered;
use App\Models\OptionAUErblich;
use App\Models\OptionAUErbZweifel;
use App\Models\OptionGentestFarbeBraun;
use App\Models\OptionGentestFarbeGelb;
use App\Models\OptionGentestFarbverduennung;
use App\Models\OptionGentestHaarlaenge;
use App\Models\OptionGentestStd;
use App\Models\OptionZSGebiss;
use App\Models\TitelTyp;
use Illuminate\Http\Request;

class HundPrerenderedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'INDEX';
    }

    public function prerender($id)
    {

        //  $hund= $hund::find($id);
        $hund = Hund::with([
            'formwert',
            'wesenstest',
            'zuchtbuchnummern',
            'chipnummern',
            'gentests_total',
            'goniountersuchung',
            'zwinger',
            'gentests',
            'personen',
            'verstorbene',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1')->first();
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1')->first();
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1')->first();
            },
            'pruefungen' => function ($query) {
                $query->with(['type' => function ($query) {
                    $query->select('id', 'name', 'name_kurz', 'template_type', 'name_template', 'ausrichter_template', 'classement_template', 'zusatz_template', 'wertung_template', 'jahr_template');
                }])->select('hund_id', 'id', 'type_id', 'classement_id', 'status_id', 'ausrichter_id', 'wertung_id', 'zusatz_id');
            },
            'titel' => function ($query) {
                $query->with(['type' => function ($query) {
                    $query->select('id', 'name', 'name_kurz', 'template_type', 'name_template');
                }])
                    ->select('hund_id', 'id', 'type_id', 'ausrichter_id', 'status_id', 'jahr')
                    ->orderBy('type_id')
                    ->orderBy('ausrichter_id')
                    ->orderBy('jahr');
            },
        ])->where('hunde.id', $id)
            ->first();

        // return $hund->pruefungen;

        // WURFZWINGER / ZUCHTSTÄTTE
        $a_wurfzwinger = [];

        if ($hund->zwinger_name) {
            $a_wurfzwinger[] = $hund->zwinger_name;
        }
        if ($hund->zuechter_nachname) {
            $a_wurfzwinger[] = trim($hund->zuechter_vorname . ' ' . $hund->zuechter_nachname);
        }
        if ($hund->zwinger_strasse) {
            $a_wurfzwinger[] = $hund->zwinger_strasse;
        }
        if ($hund->zwinger_ort) {
            $a_wurfzwinger[] = trim($hund->zwinger_plz . ' ' . $hund->zwinger_ort);
        }
        if ($hund->zwinger_tel) {
            $a_wurfzwinger[] = $hund->zwinger_tel;
        }
        if ($hund->zwinger_fci) {
            $a_wurfzwinger[] = 'FCI: ' . $hund->zwinger_fci;
        }

        $str_wurfzwinger = implode('<br />', $a_wurfzwinger);

        // ZUCHTBUCHNUMMERN
        $a_zuchtbuchnummern = [];
        foreach ($hund->zuchtbuchnummern as $element) {
            if ($element->zuchtbuchnummer) {
                $a_zuchtbuchnummern[] = $element->zuchtbuchnummer;
            }
        }
        $str_zuchtbuchnummern = implode(', ', $a_zuchtbuchnummern);
        $zuchtbuchnummer = count($a_zuchtbuchnummern) ? $a_zuchtbuchnummern[0] : '';

        // CHIPNUMMERN
        $a_chipnummern = [];
        foreach ($hund->chipnummern as $element) {
            if ($element->chipnummer) {
                $a_chipnummern[] = $element->chipnummer;
            }
        }
        $str_chipnummern = implode(', ', $a_chipnummern);
        $chipnummer = count($a_chipnummern) ? $a_chipnummern[0] : '';

        // ED/HD
        if (count($hund->hdeduntersuchungen)) {
            $hd = $hund->hdeduntersuchungen[0]->hd_score['id'] ? 'HD: ' . $hund->hdeduntersuchungen[0]->hd_score['name'] : '';
            $ed = $hund->hdeduntersuchungen[0]->ed_score['id'] ? 'ED: ' . $hund->hdeduntersuchungen[0]->ed_score['name'] : '';

            $hd_links = $hund->hdeduntersuchungen[0]->hd_l_score['id'] ? 'HD (links): ' . $hund->hdeduntersuchungen[0]->hd_l_score['name'] : '';
            $hd_rechts = $hund->hdeduntersuchungen[0]->hd_r_score['id'] ? 'HD (rechts): ' . $hund->hdeduntersuchungen[0]->hd_r_score['name'] : '';

            $ed_links = $hund->hdeduntersuchungen[0]->ed_l_score['id'] ? 'ED (links): ' . $hund->hdeduntersuchungen[0]->ed_l_score['name'] : '';
            $ed_rechts = $hund->hdeduntersuchungen[0]->ed_r_score['id'] ? 'ED (rechts): ' . $hund->hdeduntersuchungen[0]->ed_r_score['name'] : '';

            $ed_arthrose_links = $hund->hdeduntersuchungen[0]->ed_arthrose_l_score['id'] ? 'ED Arthose (links): ' . $hund->hdeduntersuchungen[0]->ed_arthrose_l_score['name'] : '';
            $ed_arthrose_rechts = $hund->hdeduntersuchungen[0]->ed_arthrose_r_score['id'] ? 'ED Arthose (rechts): ' . $hund->hdeduntersuchungen[0]->ed_arthrose_r_score['name'] : '';

            $hd_uwirbel = $hund->hdeduntersuchungen[0]->hd_uwirbel_score['id'] ? 'HD Uwirbel: ' . $hund->hdeduntersuchungen[0]->hd_uwirbel_score['name'] : '';

            $a_gelenke = [];
            if ($hd && (! $hd_links && ! $hd_rechts)) {
                $a_gelenke[] = $hd;
            }

            if ($hd_links) {
                $a_gelenke[] = $hd_links;
            }
            if ($hd_rechts) {
                $a_gelenke[] = $hd_rechts;
            }

            if ($ed && (! $ed_links && ! $ed_rechts)) {
                $a_gelenke[] = $ed;
            }
            if ($ed_links) {
                $a_gelenke[] = $ed_links;
            }
            if ($ed_rechts) {
                $a_gelenke[] = $ed_rechts;
            }
            if ($ed_arthrose_links) {
                $a_gelenke[] = $ed_arthrose_links;
            }
            if ($ed_arthrose_rechts) {
                $a_gelenke[] = $ed_arthrose_rechts;
            }
            if ($hd_uwirbel) {
                $a_gelenke[] = $hd_uwirbel;
            }
            $str_gelenke = implode(', ', $a_gelenke);
        } else {
            $str_gelenke = '';
        }

        // AUGENUNTERSUCHUNG
        if (count($hund->augenuntersuchungen)) {
            $optionen_au_erblich = OptionAUErblich::all();
            $optionen_au_zweifel = OptionAUErbZweifel::all();
            // $optionen_au_katerakt_form = OptionAUKateraktForm::all();
            // $optionen_au_rd_form = OptionAURDForm::all();
            // $optionen_au_lid = OptionAULid::all();

            $a_augenuntersuchung = [];

            $pra_rd_id = $hund->augenuntersuchungen[0]->pra_rd_id;
            $rd_id = $hund->augenuntersuchungen[0]->rd_id;
            $katarakt_nonkon_id = $hund->augenuntersuchungen[0]->katarakt_nonkon_id;

            if ($pra_rd_id) {
                $a_augenuntersuchung[] = 'PRA RD: ' . $optionen_au_zweifel[$pra_rd_id - 1]['name'];
            }
            if ($pra_rd_id > 1) {
            }

            $a_rd = [];
            if ($rd_id > 1) {
                $rd_multifokal = $hund->augenuntersuchungen[0]->rd_multifokal;
                $rd_geo = $hund->augenuntersuchungen[0]->rd_geo;
                $rd_total = $hund->augenuntersuchungen[0]->rd_total;
                if ($rd_multifokal) {
                    $a_rd[] = 'multifokal';
                }
                if ($rd_geo) {
                    $a_rd[] = 'geografisch';
                }
                if ($rd_total) {
                    $a_rd[] = 'total';
                }
                $str_rd = '(' . implode(', ', $a_rd) . ')';
            } else {
                $str_rd = '';
            }
            if ($rd_id) {
                $a_augenuntersuchung[] = trim('RD: ' . $optionen_au_zweifel[$rd_id - 1]['name'] . ' ' . $str_rd);
            }

            $a_katarakt = [];
            if ($katarakt_nonkon_id > 1) {
                $katatakt_cortikalis = $hund->augenuntersuchungen[0]->katatakt_cortikalis;
                $katatakt_polpost = $hund->augenuntersuchungen[0]->katatakt_polpost;
                $katatakt_sutura_ant = $hund->augenuntersuchungen[0]->katatakt_sutura_ant;
                $katatakt_punctata = $hund->augenuntersuchungen[0]->katatakt_punctata;
                $katatakt_nuklearis = $hund->augenuntersuchungen[0]->katatakt_nuklearis;

                if ($katatakt_cortikalis) {
                    $a_katarakt[] = 'cortikalis';
                }
                if ($katatakt_polpost) {
                    $a_katarakt[] = 'pol. post.';
                }
                if ($katatakt_sutura_ant) {
                    $a_katarakt[] = 'sutura ant.';
                }
                if ($katatakt_punctata) {
                    $a_katarakt[] = 'punctata';
                }
                if ($katatakt_nuklearis) {
                    $a_katarakt[] = 'nuklearis';
                }
                $str_katarakt = count($a_katarakt) ? $str_katarakt = '(' . implode(', ', $a_katarakt) . ')' : '';
            } else {
                $str_katarakt = '';
            }

            if ($katarakt_nonkon_id) {
                $a_augenuntersuchung[] = 'Katarakt: ' . $optionen_au_zweifel[$katarakt_nonkon_id - 1]['name'] . ' ' . $str_katarakt;
            }

            $str_augenuntersuchung = implode(', ', $a_augenuntersuchung);
            $str_augenuntersuchung .= $hund->augenuntersuchungen[0]->datum ? ' (AU ' . $hund->augenuntersuchungen[0]->datum . ')' : '';
        } else {
            $str_augenuntersuchung = '';
        }

        // GONIOUNTERSUCHUNG (bei AT nur Flat)
        if (count($hund->goniountersuchung)) {

            $a_gonio = [];
            $str_gonio = '';

            $dyslpectabnorm_id = $hund->goniountersuchung[0]->dyslpectabnorm_id;
            $dyslpectabnorm_gewebebruecken = $hund->goniountersuchung[0]->dyslpectabnorm_gewebebruecken;
            $dyslpectabnorm_kurztrabekel = $hund->goniountersuchung[0]->dyslpectabnorm_kurztrabekel;
            $dyslpectabnorm_totaldyspl = $hund->goniountersuchung[0]->dyslpectabnorm_totaldyspl;
            if ($dyslpectabnorm_gewebebruecken) {
                $a_gonio[] = 'Gewebebrücken';
            }
            if ($dyslpectabnorm_kurztrabekel) {
                $a_gonio[] = 'kurze Trabekel';
            }
            if ($dyslpectabnorm_totaldyspl) {
                $a_gonio[] = 'Totaldysplasie';
            }
            if (count($a_gonio)) {
                $str_gonio = ' Gonio: ' . implode(', ', $a_gonio);
            } else {
                $str_gonio = ' Gonio: frei';
            }
            // $str_goniountersuchung = ' Gonio: ' . $optionen_au_zweifel[$dyslpectabnorm_id - 1]['name'];
            $str_gonio .= $hund->goniountersuchung[0]->datum ? ' (GU ' . $hund->goniountersuchung[0]->datum . ', ' . $hund->goniountersuchung[0]->arzt_titel . ' ' . $hund->goniountersuchung[0]->arzt_nachname . ')' : '';
        } else {
            $str_gonio = '';
        }
        $str_augenuntersuchung .= $str_gonio;

        // ZAHNSTATUS
        $str_zahnstatus = '';
        $str_gebiss = '';
        if (count($hund->zahnstati)) {
            $a_zahnstatus = [];
            $str_zahnstatus = 'ohne Befund';
            $optionen_zs_gebiss = OptionZSGebiss::all();

            $gebiss_id = $hund->zahnstati[0]->gebiss_id;
            $str_gebiss = $optionen_zs_gebiss[$gebiss_id - 1]['name'];

            if ($hund->zahnstati[0]->textform) {
                $a_zahnstatus[] = $hund->zahnstati[0]->textform;
            }
            if ($hund->zahnstati[0]->anmerkungen) {
                $a_zahnstatus[] = $hund->zahnstati[0]->anmerkungen;
            }
            if (count($a_zahnstatus)) {
                $str_zahnstatus = implode(', ', $a_zahnstatus);
            } else {
                $str_zahnstatus = 'ohne Befund';
            }

            $a_zahnstatus_infos = [];
            if ($hund->zahnstati[0]->datum) {
                $a_zahnstatus_infos[] = $hund->zahnstati[0]->datum;
            }
            if ($hund->zahnstati[0]->gutachter_nachname) {
                $a_zahnstatus_infos[] = trim($hund->zahnstati[0]->gutachter_titel . ' ' . $hund->zahnstati[0]->gutachter_nachname);
            }
            if (count($a_zahnstatus_infos)) {
                $str_zahnstatus .= ' (' . implode(', ', $a_zahnstatus_infos) . ')';
            }
        }
        // GENTEST
        $a_gentests = [];

        $optionen_gentests_standard = OptionGentestStd::all();
        $optionen_gentests_farbverduennung = OptionGentestFarbverduennung::all();
        $optionen_gentests_haarlaenge = OptionGentestHaarlaenge::all();
        $optionen_gentests_farbe_gelb = OptionGentestFarbeGelb::all();
        $optionen_gentests_farbe_braun = OptionGentestFarbeBraun::all();

        if ($hund->gentests[0]['pra_test_id']) {
            $a_gentests[] = 'PRA TEST ' . $optionen_gentests_standard[$hund->gentests[0]['pra_test_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['pra_prcd_gentest_id']) {
            $a_gentests[] = 'PRA PRCD ' . $optionen_gentests_standard[$hund->gentests[0]['pra_prcd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cnm_gentest_id']) {
            $a_gentests[] = 'CNM ' . $optionen_gentests_standard[$hund->gentests[0]['cnm_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['eic_gentest_id']) {
            $a_gentests[] = 'EIC ' . $optionen_gentests_standard[$hund->gentests[0]['eic_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['dm_gentest_id']) {
            $a_gentests[] = 'DM ' . $optionen_gentests_standard[$hund->gentests[0]['dm_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['sd2_gentest_id']) {
            $a_gentests[] = 'SD2 ' . $optionen_gentests_standard[$hund->gentests[0]['sd2_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['narc_gentest_id']) {
            $a_gentests[] = 'NARC ' . $optionen_gentests_standard[$hund->gentests[0]['narc_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['rd_osd_gentest_id']) {
            $a_gentests[] = 'RD/OSD ' . $optionen_gentests_standard[$hund->gentests[0]['rd_osd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cea_ch_gentest_id']) {
            $a_gentests[] = 'CEA ' . $optionen_gentests_standard[$hund->gentests[0]['cea_ch_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['gr_pra1_gentest_id']) {
            $a_gentests[] = 'GR PRA1 ' . $optionen_gentests_standard[$hund->gentests[0]['gr_pra1_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['gr_pra2_gentest_id']) {
            $a_gentests[] = 'GR PRA2 ' . $optionen_gentests_standard[$hund->gentests[0]['gr_pra2_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['haarlaenge_id']) {
            $a_gentests[] = 'Haarlänge ' . $optionen_gentests_haarlaenge[$hund->gentests[0]['haarlaenge_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['gsdiiia_gentest_id']) {
            $a_gentests[] = 'GSDIIIa ' . $optionen_gentests_standard[$hund->gentests[0]['gsdiiia_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['grmd_gentest_id']) {
            $a_gentests[] = 'GRMD ' . $optionen_gentests_standard[$hund->gentests[0]['grmd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ict_a_gentest_id']) {
            $a_gentests[] = 'ICT/A ' . $optionen_gentests_standard[$hund->gentests[0]['ict_a_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ed_sfs_gentest_id']) {
            $a_gentests[] = 'ED/SFS ' . $optionen_gentests_standard[$hund->gentests[0]['ed_sfs_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['hnpk_gentest_id']) {
            $a_gentests[] = 'HNPK ' . $optionen_gentests_standard[$hund->gentests[0]['hnpk_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ncl5_gentest_id']) {
            $a_gentests[] = 'NCL5 ' . $optionen_gentests_standard[$hund->gentests[0]['ncl5_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ncl_f_gentest_id']) {
            $a_gentests[] = 'NCL/F ' . $optionen_gentests_standard[$hund->gentests[0]['ncl_f_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['farbtest_gelb_id']) {
            $a_gentests[] = 'Farbtest Gelb ' . $optionen_gentests_farbe_gelb[$hund->gentests[0]['farbtest_gelb_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['farbtest_braun_id']) {
            $a_gentests[] = 'Farbetest Braun ' . $optionen_gentests_farbe_braun[$hund->gentests[0]['farbtest_braun_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['farbverduennung_id']) {
            $a_gentests[] = 'Farbverdünnung ' . $optionen_gentests_farbverduennung[$hund->gentests[0]['farbverduennung_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['den_gentest_id']) {
            $a_gentests[] = 'DEN ' . $optionen_gentests_standard[$hund->gentests[0]['den_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ict_2_gentest_id']) {
            $a_gentests[] = 'ICT/2 ' . $optionen_gentests_standard[$hund->gentests[0]['ict_2_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['jadd_gentest_id']) {
            $a_gentests[] = 'JADD ' . $optionen_gentests_standard[$hund->gentests[0]['jadd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['ivdd_gentest_id']) {
            $a_gentests[] = 'IVDD ' . $optionen_gentests_standard[$hund->gentests[0]['ivdd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cp1_gentest_id']) {
            $a_gentests[] = 'CP1 ' . $optionen_gentests_standard[$hund->gentests[0]['cp1_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cps_gentest_id']) {
            $a_gentests[] = 'CPS ' . $optionen_gentests_standard[$hund->gentests[0]['cps_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['clps_gentest_id']) {
            $a_gentests[] = 'CLPS ' . $optionen_gentests_standard[$hund->gentests[0]['clps_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cms_gentest_id']) {
            $a_gentests[] = 'CMS ' . $optionen_gentests_standard[$hund->gentests[0]['cms_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['dann_farbtest_id']) {
            $a_gentests[] = 'DANN ' . $optionen_gentests_standard[$hund->gentests[0]['dann_farbtest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['mh_gentest_id']) {
            $a_gentests[] = 'MH ' . $optionen_gentests_standard[$hund->gentests[0]['mh_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cddy_gentest_id']) {
            $a_gentests[] = 'CDDY ' . $optionen_gentests_standard[$hund->gentests[0]['cddy_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cdpa_gentest_id']) {
            $a_gentests[] = 'CDPA ' . $optionen_gentests_standard[$hund->gentests[0]['cdpa_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['huu_gentest_id']) {
            $a_gentests[] = 'HUU ' . $optionen_gentests_standard[$hund->gentests[0]['huu_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['deb_gentest_id']) {
            $a_gentests[] = 'DEB ' . $optionen_gentests_standard[$hund->gentests[0]['deb_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['buff_gentest_id']) {
            $a_gentests[] = 'BUFF ' . $optionen_gentests_standard[$hund->gentests[0]['buff_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['dil_gentest_id']) {
            $a_gentests[] = 'DIL ' . $optionen_gentests_standard[$hund->gentests[0]['dil_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['md_gentest_id']) {
            $a_gentests[] = 'MD ' . $optionen_gentests_standard[$hund->gentests[0]['md_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['mdr1_gentest_id']) {
            $a_gentests[] = 'MDR1 ' . $optionen_gentests_standard[$hund->gentests[0]['mdr1_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['cord1_pra_gentest_id']) {
            $a_gentests[] = 'CORD1 ' . $optionen_gentests_standard[$hund->gentests[0]['cord1_pra_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['glasknochen_gentest_id']) {
            $a_gentests[] = 'Glasknochen ' . $optionen_gentests_standard[$hund->gentests[0]['glasknochen_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['stgd_gentest_id']) {
            $a_gentests[] = 'STGD ' . $optionen_gentests_standard[$hund->gentests[0]['stgd_gentest_id'] - 1]['name'];
        }
        if ($hund->gentests[0]['oi_gentest_id']) {
            $a_gentests[] = 'OI ' . $optionen_gentests_standard[$hund->gentests[0]['oi_gentest_id'] - 1]['name'];
        }

        //
        // FORMWERT
        //
        $a_auflagen = [];
        $a_formwert = [];

        if (count($hund->formwert)) {

            if ($hund->formwert[0]->resultable->formwert) {
                $a_formwert[] = $hund->formwert[0]->resultable->formwert;
            }
            if ($hund->formwert[0]->resultable->datum) {
                $a_formwert[] = $hund->formwert[0]->resultable->datum;
            }
            if ($hund->formwert[0]->resultable->ort) {
                $a_formwert[] = $hund->formwert[0]->resultable->ort;
            }
            if ($hund->formwert[0]->resultable->risthoehe) {
                $a_formwert[] = 'Risthöhe ' . $hund->formwert[0]->resultable->risthoehe . ' cm';
            }
            if ($hund->formwert[0]->resultable->richter) {
                $a_formwert[] = 'Richter ' . $hund->formwert[0]->resultable->richter;
            }
            if ($hund->formwert[0]->resultable->beurteilung) {
                $a_formwert[] = $hund->formwert[0]->resultable->beurteilung;
            }

            if ($hund->formwert[0]->resultable->auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->auflagen;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_gonio) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_gonio;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_hc) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_hc;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_rd) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_rd;
            }
            if ($hund->formwert[0]->resultable->ed_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->ed_auflagen;
            }
            if ($hund->formwert[0]->resultable->fw_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->fw_auflagen;
            }
            if ($hund->formwert[0]->resultable->gebiss_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gebiss_auflagen;
            }
            if ($hund->formwert[0]->resultable->gentest_auflagen_pra) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_pra;
            }
            if ($hund->formwert[0]->resultable->gentest_auflagen_sonst) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_sonst;
            }
            if ($hund->formwert[0]->resultable->hd_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->hd_auflagen;
            }
            if ($hund->formwert[0]->resultable->leistung_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->leistung_auflagen;
            }
            if ($hund->formwert[0]->resultable->sonst_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->sonst_auflagen;
            }

            // switch ($hund->formwert[0]->resultable_type) {
            //    case 'App\\Models\\Formwert_v0':
            //    case 'App\\Models\\Formwert_v1':
            //       break;
            // }

            $str_formwert = implode(', ', $a_formwert);
            $str_auflagen = implode(', ', $a_auflagen);
        } else {
            $str_formwert = '';
            $str_auflagen = '';
        }

        //
        // WESENSTEST
        //

        if (count($hund->wesenstest)) {

            $a_wesenstest = [];

            if ($hund->wesenstest[0]->resultable->datum) {
                $a_wesenstest[] = $hund->wesenstest[0]->resultable->datum;
            }
            if ($hund->wesenstest[0]->resultable->ort) {
                $a_wesenstest[] = $hund->wesenstest[0]->resultable->ort;
            }
            if ($hund->wesenstest[0]->resultable->alter) {
                $a_wesenstest[] = 'Alter ' . $hund->wesenstest[0]->resultable->alter . ' Monate';
            }
            if ($hund->wesenstest[0]->resultable->richter) {
                $a_wesenstest[] = 'Richter ' . $hund->wesenstest[0]->resultable->richter;
            }

            switch ($hund->wesenstest[0]->resultable_type) {
                case 'App\\Models\\Wesenstest_v0':
                    if ($hund->wesenstest[0]->resultable->beurteilung) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->beurteilung;
                    }
                    if ($hund->wesenstest[0]->resultable->auflage) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->auflage;
                    }
                    break;
                case 'App\\Models\\Wesenstest_v1':
                    if ($hund->wesenstest[0]->resultable->bemerkungen) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->bemerkungen;
                    }
                    break;
                case 'App\\Models\\Wesenstest_v2':
                    if ($hund->wesenstest[0]->resultable->zusammenfassende_beschreibung) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->zusammenfassende_beschreibung;
                    }
                    break;
            }

            $str_wesenstest = implode(', ', $a_wesenstest);
        } else {
            $str_wesenstest = '';
        }

        $str_gentests = implode(', ', $a_gentests);
        // return $str_gentests;

        // EIGENTÜMER
        $a_personen = [];
        $a_str_personen = [];
        foreach ($hund->personen as $index => $person) {
            $a_personen[$index] = [];
            $a_personen[$index][] = $person->vorname . ' ' . $person->nachname;
            if ($person->strasse) {
                $a_personen[$index][] = $person->strasse;
            }
            if ($person->ort) {
                $a_personen[$index][] = $person->plz . ' ' . $person->ort;
            }
            if ($person->land) {
                $a_personen[$index][] = $person->land;
            }
            if ($person->telefon) {
                $a_personen[$index][] = $person->telefon;
            }
            if ($person->email) {
                $a_personen[$index][] = $person->email;
            }

            $a_str_personen[] = implode('<br />', $a_personen[$index]);
        }

        $str_personen = implode('<br /><br />', $a_str_personen);

        // ZÜCHTER / ZUCHTSTÄTTE

        // ZUCHTZULASSUNG

        // ZUCHTAUSSCHLUSSFEHLER
        $a_zuchtausschlussfehler = [];
        $str_zuchtausschlussfehler = implode(', ', $a_zuchtausschlussfehler);

        // PRÜFUNGEN
        $pruefungen = [];

        foreach ($hund->pruefungen as $pruefung) {
            // PRÜFUNGSTYP vorhanden?

            if (array_key_exists($pruefung->type_id, $pruefungen)) {
                // JA -> update

                switch ($pruefung->type->template_type) {

                    //STANDARD
                    case 0:
                        if ($pruefung->jahr) {
                            $pruefungen[$pruefung->type_id]['jahre'][] = "'" . substr($pruefung->jahr, -2);
                        }

                        if ($pruefung->ausrichter_id) {
                            if (! in_array($pruefung->ausrichter->name_kurz, $pruefungen[$pruefung->type_id]['a_ausrichter'])) {
                                $pruefungen[$pruefung->type_id]['a_ausrichter'][] = $pruefung->ausrichter->name_kurz;
                            }
                        }
                        if ($pruefung->classement_id) {
                            if (! in_array($pruefung->classement->name_kurz, $pruefungen[$pruefung->type_id]['a_classements'])) {
                                $pruefungen[$pruefung->type_id]['a_classements'][] = $pruefung->classement->name_kurz;
                            }
                        }

                        if ($pruefung->wertung_id) {
                            if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_wertungen'])) {
                                $pruefungen[$pruefung->type_id]['a_wertungen'][] = $pruefung->wertung->name_kurz;
                            }
                        }
                        if ($pruefung->zusatz_id) {
                            if (! in_array($pruefung->zusatz->name_kurz, $pruefungen[$pruefung->type_id]['a_zusaetze'])) {
                                $pruefungen[$pruefung->type_id]['a_zusaetze'][] = $pruefung->zusatz->name_kurz;
                            }
                        }
                        break;

                        // FÄHRTENPRÜFUNGEN 20/40
                    case 1:
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte und 40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        break;

                        // KLASSE-PREISZIFFER
                    case 2:

                        break;
                }
            } else {

                // NEIN -> add
                switch ($pruefung->type->template_type) {

                    case 0:
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'classement_template' => $pruefung->type->classement_template,
                            'zusatz_template' => $pruefung->type->zusatz_template,
                            'jahr_template' => $pruefung->type->jahr_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'jahre' => '',
                            'ausrichter' => '',
                            'classements' => '',
                            'wertungen' => '',
                            'zusaetze' => '',
                            'a_ausrichter' => [],
                            'a_classements' => [],
                            'a_wertungen' => [],
                            'a_zusaetze' => [],
                            'a_jahre' => [],

                        ];

                        if ($pruefung->ausrichter_id) {
                            if (! in_array($pruefung->ausrichter->name_kurz, $pruefungen[$pruefung->type_id]['a_ausrichter'])) {
                                $pruefungen[$pruefung->type_id]['a_ausrichter'][] = $pruefung->ausrichter->name_kurz;
                            }
                        }
                        if ($pruefung->classement_id) {
                            if (! in_array($pruefung->classement->name_kurz, $pruefungen[$pruefung->type_id]['a_classements'])) {
                                $pruefungen[$pruefung->type_id]['a_classements'][] = $pruefung->classement->name_kurz;
                            }
                        }

                        if ($pruefung->wertung_id) {
                            if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_wertungen'])) {
                                $pruefungen[$pruefung->type_id]['a_wertungen'][] = $pruefung->wertung->name_kurz;
                            }
                        }
                        if ($pruefung->zusatz_id) {
                            if (! in_array($pruefung->zusatz->name_kurz, $pruefungen[$pruefung->type_id]['a_zusaetze'])) {
                                $pruefungen[$pruefung->type_id]['a_zusaetze'][] = $pruefung->zusatz->name_kurz;
                            }
                        }
                        if ($pruefung->jahr) {
                            $pruefungen[$pruefung->type_id]['jahre'][] = "'" . substr($pruefung->jahr, -2);
                        }

                        break;

                    case 1:   // FÄHRTENPRÜFUNG
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            '20er' => '',
                            '40er' => '',
                            '2040er' => '',
                            'a_20er' => [],
                            'a_40er' => [],
                            'a_2040er' => [],
                        ];

                        // if ($pruefung->classement_id == 8) {
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte und 40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_2040er'])) {
                                    $pruefungen[$pruefung->type_id]['a_2040er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        break;

                    case 2:   // VERSCHACHTELTE KLASSE-PREISZIFFER
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'classement_wertung' => '',
                            'a_classement_wertung' => [],
                        ];

                        $a_klasse_wertung = [];
                        if ($pruefung->classement_id) {
                            $a_klasse_wertung[] = $pruefung->classement->name_kurz;
                        }
                        if ($pruefung->wertung_id) {
                            $a_klasse_wertung[] = $pruefung->wertung->name_kurz . '.pr.';
                        }

                        $str_klasse_wertung = '(' . implode('-', $a_klasse_wertung) . ')';

                        if ($str_klasse_wertung) {
                            if (! in_array($str_klasse_wertung, $pruefungen[$pruefung->type_id]['a_classement_wertung'])) {
                                $pruefungen[$pruefung->type_id]['a_classement_wertung'][] = $str_klasse_wertung;
                            }
                        }
                        break;

                    case 3:   // VERSCHACHTELTE KLASSE-PREISZIFFER
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'classement_wertung' => '',
                            'a_classement_wertung' => [],
                        ];

                        $a_klasse_wertung = [];
                        if ($pruefung->classement_id) {
                            $a_klasse_wertung[] = $pruefung->classement->name_kurz . 'm';
                        }
                        if ($pruefung->wertung_id) {
                            $a_klasse_wertung[] = $pruefung->wertung->name_kurz . '.pr.';
                        }

                        $str_klasse_wertung = '(' . implode('-', $a_klasse_wertung) . ')';

                        if ($str_klasse_wertung) {
                            if (! in_array($str_klasse_wertung, $pruefungen[$pruefung->type_id]['a_classement_wertung'])) {
                                $pruefungen[$pruefung->type_id]['a_classement_wertung'][] = $str_klasse_wertung;
                            }
                        }
                        break;
                }
            }
        }

        $a_pruefungen_output = [];

        foreach ($pruefungen as &$pruefung) {

            switch ($pruefung['template_type']) {

                case 0:
                    $pruefung['ausrichter'] = implode('/', $pruefung['a_ausrichter']);
                    $pruefung['classements'] = implode('/', $pruefung['a_classements']);
                    $pruefung['wertungen'] = implode('/', $pruefung['a_wertungen']);
                    $pruefung['zusaetze'] = implode('/', $pruefung['a_zusaetze']);
                    $pruefung['jahre'] = implode('', $pruefung['a_jahre']);

                    $d_ausrichter = $pruefung['ausrichter'] ? str_replace('[DATA]', $pruefung['ausrichter'], $pruefung['ausrichter_template']) : '';
                    $d_wertung = $pruefung['wertungen'] ? str_replace('[DATA]', $pruefung['wertungen'], $pruefung['wertung_template']) : '';
                    $d_classement = $pruefung['classements'] ? str_replace('[DATA]', $pruefung['classements'], $pruefung['classement_template']) : '';
                    $d_zusatz = $pruefung['zusaetze'] ? str_replace('[DATA]', $pruefung['zusaetze'], $pruefung['zusatz_template']) : '';
                    $d_jahre = str_replace('[DATA]', $pruefung['jahre'], $pruefung['jahr_template']);

                    $output = str_replace(
                        ['{AUSRICHTER}', '{WERTUNG}', '{CLASSEMENT}', '{ZUSATZ}', '{JAHRE}'],
                        [$d_ausrichter, $d_wertung, $d_classement, $d_zusatz, $d_jahre],
                        $pruefung['template']
                    );
                    $a_pruefungen_output[] = $output;
                    break;

                    // FÄHRTENPRÜFUNG
                case 1:
                    if ($pruefung['20er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', '/' . implode('+', $pruefung['a_20er']), $pruefung['template']);
                    }
                    if ($pruefung['40er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', implode('+', $pruefung['a_40er']) . '/', $pruefung['template']);
                    }
                    if ($pruefung['2040er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', '/' . implode('+', $pruefung['a_2040er']) . '/', $pruefung['template']);
                    }
                    $a_pruefungen_output[] = implode(' ', $a_outputs);

                    break;

                case 2:
                    $a_pruefungen_output[] = str_replace('{KLASSE-PREISZIFFER}', implode('/', $pruefung['a_classement_wertung']), $pruefung['template']);
                    break;

                case 3:
                    $a_pruefungen_output[] = str_replace('{LAENGE-PREISZIFFER}', implode('/', $pruefung['a_classement_wertung']), $pruefung['template']);
                    break;

            }
        }
        $str_pruefungen = implode(' ', $a_pruefungen_output);

        // TITEL
        $titels = [];
        // TODO: SORTIERUNG AUSRICHTER / JAHRE
        $sort_ausrichter = true;

        foreach ($hund->titel as $titel) {

            $titel->type_id = $titel->type_id ? $titel->type_id : 0;
            $titeltyp = TitelTyp::find($titel->type_id);
            $sort_ausrichter = $titeltyp->sort_by_ausrichter;

            // TITELTYP vorhanden?
            if (array_key_exists($titel->type_id, $titels)) {
                // JA -> update
                if ($sort_ausrichter) {
                    // SORTIERE NACH AUSRICHTER
                    $ausrichters = $titels[$titel->type_id]['ausrichter'];
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    // KOMMT DER AUSRICHTER SCHON MAL VOR
                    if (array_key_exists($titel->ausrichter_id, $ausrichters)) {
                        $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['ausrichter'][$titel->ausrichter_id]['jahre'] .= $str_jahr;
                    } else {
                        $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['ausrichter'][$titel->ausrichter_id] = [
                            'name' => $ausrichter_name,
                            'jahre' => $str_jahr,
                        ];
                    }
                } else {
                    // SORTIERE NACH JAHREN
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    $jahr = $titel->jahr > 0 ? substr($titel->jahr, -2) : '';
                    $jahre = $titels[$titel->type_id]['jahre'];

                    if (array_key_exists($jahr, $jahre) && $jahr != '') {
                        //$str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        if (! in_array($ausrichter_name, $titels[$titel->type_id]['jahre'][$jahr])) {
                            $titels[$titel->type_id]['jahre'][$jahr][] = $ausrichter_name;
                        }
                    } elseif ($jahr != '') {
                        // $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['jahre'][$jahr] = [$ausrichter_name];
                    } else {

                        if (! in_array($ausrichter_name, $titels[$titel->type_id]['ausrichter'])) {
                            $titels[$titel->type_id]['ausrichter'][] = $ausrichter_name;
                        }
                    }
                }
            } else {
                // NEIN -> add
                if ($sort_ausrichter) {
                    // SORTIERE NACH AUSRICHTER
                    $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                    $ausrichter = [];
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    $ausrichter[$titel->ausrichter_id] = [
                        'name' => $ausrichter_name,
                        'jahre' => $str_jahr,
                    ];
                    $titels[$titel->type_id] = [
                        'anzahl' => 1,
                        'template' => $titel->type->name_template,
                        'template_type' => $titel->type->template_type,
                        'typ_id' => $titel->type_id,
                        'typ' => $titel->titel_name,
                        'ausrichter' => $ausrichter,
                        'sort_by_ausrichter' => 1,
                    ];
                } else {
                    // SORTIERE NACH JAHREN
                    $jahre = [];
                    $jahr = $titel->jahr > 0 ? substr($titel->jahr, -2) : '';
                    $ausrichter_name = $titel->ausrichter->exists() ? $titel->ausrichter->name_kurz : '';

                    if ($jahr != '') {
                        $jahre[$jahr] = [$ausrichter_name];
                        $ausrichter = [];
                    } else {
                        $ausrichter = [$ausrichter_name];
                        $jahre = [];
                    }
                    $titels[$titel->type_id] = [
                        'anzahl' => 1,
                        'template' => $titel->type->name_template,
                        'template_type' => $titel->type->template_type,
                        'typ_id' => $titel->type_id,
                        'typ' => $titel->titel_name,
                        'jahre' => $jahre,
                        'ausrichter' => $ausrichter,
                        'sort_by_ausrichter' => 0,
                    ];
                }
            }
        }

        $str_titels = '';
        $a_ausrichter = [];

        // SORTIERE NACH AUSRICHTER

        foreach ($titels as $titel) {

            if ($titel['sort_by_ausrichter']) {

                $a_ausrichter = [];

                foreach ($titel['ausrichter'] as $key => $value) {
                    $a_ausrichter[] = $value['name'] . $value['jahre'];
                }

                $data = count($a_ausrichter) ? implode('/', $a_ausrichter) : '';

                switch ($titel['template_type']) {
                    case 0:
                        $str_titels .= $titel['template'] . ' ';
                        break;
                    case 1:
                        $str_titels .= str_replace('[DATA]', $data, $titel['template']) . ' ';
                        break;
                    case 2:
                        $str_titels .= str_replace('[DATA-]', $data . '-', $titel['template']) . ' ';
                        break;
                    case 3:
                        $str_titels .= str_replace('[-DATA]', '-' . $data, $titel['template']) . ' ';
                        break;
                }
            } else {
                $a_jahre = [];

                foreach ($titel['jahre'] as $key => $value) {
                    // return [ "titel" => $titel, "key" => $key, "value" => $value ];

                    $a_jahre[] = implode('/', $value) . "'" . $key;
                }
                $data = implode('/', $a_jahre);

                switch ($titel['template_type']) {
                    case 0:
                        $str_titels .= $titel['template'] . ' ';
                        break;
                    case 1:
                        $str_titels .= str_replace('[DATA]', $data, $titel['template']) . ' ';
                        break;
                    case 2:
                        $str_titels .= str_replace('[DATA-]', $data . '-', $titel['template']) . ' ';
                        break;
                    case 3:
                        $str_titels .= str_replace('[-DATA]', '-' . $data, $titel['template']) . ' ';
                        break;
                }
            }
        }

        $hund_prerendered = HundPrerendered::find($id);

        if (! $hund_prerendered) {
            $hund_prerendered = new HundPrerendered();
            $hund_prerendered->id = $hund->id;
            $hund_prerendered->hund_id = $hund->id;
        }

        $hund_prerendered->hund_id = $hund->id;
        $hund_prerendered['name'] = $hund['name'];
        $hund_prerendered->farbe = $hund->farbe['name'];
        $hund_prerendered->rasse = $hund->rasse['name'];
        $hund_prerendered->geschlecht = $hund->geschlecht['name'];
        $hund_prerendered->gstb_nr = $hund->gstb_nr;
        $hund_prerendered->drc_gstb_nr = $hund->drc_gstb_nr;
        $hund_prerendered->wurfdatum = $hund->wurfdatum;
        $hund_prerendered->zuchtart = $hund->zuchtart_id ? $hund->zuchtart->name : '';

        $hund_prerendered->wurfzwinger = $str_wurfzwinger;
        $hund_prerendered->zuechter_nachname = $hund->zuechter_nachname;
        $hund_prerendered->zuechter_vorname = $hund->zuechter_vorname;
        $hund_prerendered->zwinger_name = $hund->zwinger_name;
        $hund_prerendered->zwinger_strasse = $hund->zwinger_strasse;
        $hund_prerendered->zwinger_plz = $hund->zwinger_plz;
        $hund_prerendered->zwinger_ort = $hund->zwinger_ort;
        $hund_prerendered->zwinger_telefon = $hund->zwinger_tel;
        $hund_prerendered->zwinger_fci = $hund->zwinger_fci;

        $hund_prerendered->vater_name = $hund->vater_name;
        $hund_prerendered->vater_zuchtbuchnummer = $hund->vater_zuchtbuchnummer;
        $hund_prerendered->mutter_name = $hund->mutter_name;
        $hund_prerendered->mutter_zuchtbuchnummer = $hund->mutter_zuchtbuchnummer;
        $hund_prerendered->abstammungsnachweis = $hund->abstammungsnachweis ? 'Abstammungsnachweis liegt vor.' : '';
        $hund_prerendered->zuchtbuchnummern = $str_zuchtbuchnummern;
        $hund_prerendered->chipnummern = $str_chipnummern;
        $hund_prerendered->zuchtbuchnummer = $zuchtbuchnummer;
        $hund_prerendered->chipnummer = $chipnummer;
        $hund_prerendered->taetowierung = $hund->taetowierung;
        $hund_prerendered->verstorben = $hund->verstorben ? $hund->verstorben->verstorben_am : ($hund->sterbedatum ? $hund->sterbedatum : '');

        $hund_prerendered->knickrute = $hund->knickrute ? 'Knickrute' : '';
        $hund_prerendered->formwert = $str_formwert;
        $hund_prerendered->formwert_auflagen = $str_auflagen;
        $hund_prerendered->wesenstest = $str_wesenstest;

        $hund_prerendered->kastration = $hund->kastration ? ($hund->geschlecht_id == 1 ? 'sterilisiert' : 'kastriert') : '';

        $hund_prerendered->gelenke = $str_gelenke;
        $hund_prerendered->augenuntersuchung = $str_augenuntersuchung;
        $hund_prerendered->gebiss = $str_gebiss;
        $hund_prerendered->zahnstatus = $str_zahnstatus;
        $hund_prerendered->pruefungen = $str_pruefungen;
        $hund_prerendered->titel = $str_titels;
        $hund_prerendered->gentests = $str_gentests;

        $hund_prerendered->save();

        // return $hund;
        return $hund_prerendered;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHundPrerenderedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HundPrerendered $hundPrerendered)
    {
        $hunde = [];

        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);
        $hunde[] = $hundPrerendered::find(37326);

        return $hunde;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHundPrerenderedRequest $request, HundPrerendered $hundPrerendered)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HundPrerendered $hundPrerendered)
    {
        //
    }

    public function test(Request $request)
    {

        $id = $request->id;
        //  $hund= $hund::find($id);
        $hund = Hund::with([
            'formwert',
            'wesenstest',
            'zuchtbuchnummern',
            'chipnummern',
            'gentests_total',
            'goniountersuchung',
            'zwinger',
            'gentests',
            'personen',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1')->first();
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1')->first();
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1')->first();
            },
            'pruefungen' => function ($query) {
                $query->with(['type' => function ($query) {
                    $query->select('id', 'name', 'name_kurz', 'template_type', 'name_template', 'ausrichter_template', 'classement_template', 'zusatz_template', 'wertung_template', 'jahr_template');
                }])->select('hund_id', 'id', 'type_id', 'classement_id', 'status_id', 'ausrichter_id', 'wertung_id', 'zusatz_id');
            },
            'titel' => function ($query) {
                $query->with(['type' => function ($query) {
                    $query->select('id', 'name', 'name_kurz', 'template_type', 'name_template');
                }])
                    ->select('hund_id', 'id', 'type_id', 'ausrichter_id', 'status_id', 'jahr')
                    ->orderBy('type_id')
                    ->orderBy('ausrichter_id')
                    ->orderBy('jahr');
            },
        ])->where('hunde.id', $id)
            ->first();

        return $hund;
        // WURFZWINGER / ZUCHTSTÄTTE
        $a_wurfzwinger = [];

        if ($hund->zwinger_name) {
            $a_wurfzwinger[] = $hund->zwinger_name;
        }
        if ($hund->zuechter_nachname) {
            $a_wurfzwinger[] = trim($hund->zuechter_vorname . ' ' . $hund->zuechter_nachname);
        }
        if ($hund->zwinger_strasse) {
            $a_wurfzwinger[] = $hund->zwinger_strasse;
        }
        if ($hund->zwinger_ort) {
            $a_wurfzwinger[] = trim($hund->zwinger_plz . ' ' . $hund->zwinger_ort);
        }
        if ($hund->zwinger_tel) {
            $a_wurfzwinger[] = $hund->zwinger_tel;
        }
        if ($hund->zwinger_fci) {
            $a_wurfzwinger[] = 'FCI: ' . $hund->zwinger_fci;
        }

        $str_wurfzwinger = implode('<br />', $a_wurfzwinger);

        // ZUCHTBUCHNUMMERN
        $a_zuchtbuchnummern = [];
        foreach ($hund->zuchtbuchnummern as $element) {
            if ($element->zuchtbuchnummer) {
                $a_zuchtbuchnummern[] = $element->zuchtbuchnummer;
            }
        }
        $str_zuchtbuchnummern = implode(', ', $a_zuchtbuchnummern);
        $zuchtbuchnummer = count($a_zuchtbuchnummern) ? $a_zuchtbuchnummern[0] : '';

        // CHIPNUMMERN
        $a_chipnummern = [];
        foreach ($hund->chipnummern as $element) {
            if ($element->chipnummer) {
                $a_chipnummern[] = $element->chipnummer;
            }
        }
        $str_chipnummern = implode(', ', $a_chipnummern);
        $chipnummer = count($a_chipnummern) ? $a_chipnummern[0] : '';

        // ED/HD
        if (count($hund->hdeduntersuchungen)) {
            $hd = $hund->hdeduntersuchungen[0]->hd_score['id'] ? 'HD: ' . $hund->hdeduntersuchungen[0]->hd_score['name'] : '';
            $ed = $hund->hdeduntersuchungen[0]->ed_score['id'] ? 'ED: ' . $hund->hdeduntersuchungen[0]->ed_score['name'] : '';

            $hd_links = $hund->hdeduntersuchungen[0]->hd_l_score['id'] ? 'HD (links): ' . $hund->hdeduntersuchungen[0]->hd_l_score['name'] : '';
            $hd_rechts = $hund->hdeduntersuchungen[0]->hd_r_score['id'] ? 'HD (rechts): ' . $hund->hdeduntersuchungen[0]->hd_r_score['name'] : '';

            $ed_links = $hund->hdeduntersuchungen[0]->ed_l_score['id'] ? 'ED (links): ' . $hund->hdeduntersuchungen[0]->ed_l_score['name'] : '';
            $ed_rechts = $hund->hdeduntersuchungen[0]->ed_r_score['id'] ? 'ED (rechts): ' . $hund->hdeduntersuchungen[0]->ed_r_score['name'] : '';

            $ed_arthrose_links = $hund->hdeduntersuchungen[0]->ed_arthrose_l_score['id'] ? 'ED Arthose (links): ' . $hund->hdeduntersuchungen[0]->ed_arthrose_l_score['name'] : '';
            $ed_arthrose_rechts = $hund->hdeduntersuchungen[0]->ed_arthrose_r_score['id'] ? 'ED Arthose (rechts): ' . $hund->hdeduntersuchungen[0]->ed_arthrose_r_score['name'] : '';

            $hd_uwirbel = $hund->hdeduntersuchungen[0]->hd_uwirbel_score['id'] ? 'HD Uwirbel: ' . $hund->hdeduntersuchungen[0]->hd_uwirbel_score['name'] : '';

            $a_gelenke = [];
            if ($hd && (! $hd_links && ! $hd_rechts)) {
                $a_gelenke[] = $hd;
            }

            if ($hd_links) {
                $a_gelenke[] = $hd_links;
            }
            if ($hd_rechts) {
                $a_gelenke[] = $hd_rechts;
            }

            if ($ed && (! $ed_links && ! $ed_rechts)) {
                $a_gelenke[] = $ed;
            }
            if ($ed_links) {
                $a_gelenke[] = $ed_links;
            }
            if ($ed_rechts) {
                $a_gelenke[] = $ed_rechts;
            }
            if ($ed_arthrose_links) {
                $a_gelenke[] = $ed_arthrose_links;
            }
            if ($ed_arthrose_rechts) {
                $a_gelenke[] = $ed_arthrose_rechts;
            }
            if ($hd_uwirbel) {
                $a_gelenke[] = $hd_uwirbel;
            }
            $str_gelenke = implode(', ', $a_gelenke);
        } else {
            $str_gelenke = '';
        }

        // AUGENUNTERSUCHUNG
        if (count($hund->augenuntersuchungen)) {
            $optionen_au_erblich = OptionAUErblich::all();
            $optionen_au_zweifel = OptionAUErbZweifel::all();
            // $optionen_au_katerakt_form = OptionAUKateraktForm::all();
            // $optionen_au_rd_form = OptionAURDForm::all();
            // $optionen_au_lid = OptionAULid::all();

            $a_augenuntersuchung = [];

            $pra_rd_id = $hund->augenuntersuchungen[0]->pra_rd_id;
            $rd_id = $hund->augenuntersuchungen[0]->rd_id;
            $katarakt_nonkon_id = $hund->augenuntersuchungen[0]->katarakt_nonkon_id;

            if ($pra_rd_id) {
                $a_augenuntersuchung[] = 'PRA RD: ' . $optionen_au_zweifel[$pra_rd_id - 1]['name'];
            }
            if ($pra_rd_id > 1) {
            }

            $a_rd = [];
            if ($rd_id > 1) {
                $rd_multifokal = $hund->augenuntersuchungen[0]->rd_multifokal;
                $rd_geo = $hund->augenuntersuchungen[0]->rd_geo;
                $rd_total = $hund->augenuntersuchungen[0]->rd_total;
                if ($rd_multifokal) {
                    $a_rd[] = 'multifokal';
                }
                if ($rd_geo) {
                    $a_rd[] = 'geografisch';
                }
                if ($rd_total) {
                    $a_rd[] = 'total';
                }
                $str_rd = '(' . implode(', ', $a_rd) . ')';
            } else {
                $str_rd = '';
            }
            if ($rd_id) {
                $a_augenuntersuchung[] = trim('RD: ' . $optionen_au_zweifel[$rd_id - 1]['name'] . ' ' . $str_rd);
            }

            $a_katarakt = [];
            if ($katarakt_nonkon_id > 1) {
                $katatakt_cortikalis = $hund->augenuntersuchungen[0]->katatakt_cortikalis;
                $katatakt_polpost = $hund->augenuntersuchungen[0]->katatakt_polpost;
                $katatakt_sutura_ant = $hund->augenuntersuchungen[0]->katatakt_sutura_ant;
                $katatakt_punctata = $hund->augenuntersuchungen[0]->katatakt_punctata;
                $katatakt_nuklearis = $hund->augenuntersuchungen[0]->katatakt_nuklearis;

                if ($katatakt_cortikalis) {
                    $a_katarakt[] = 'cortikalis';
                }
                if ($katatakt_polpost) {
                    $a_katarakt[] = 'pol. post.';
                }
                if ($katatakt_sutura_ant) {
                    $a_katarakt[] = 'sutura ant.';
                }
                if ($katatakt_punctata) {
                    $a_katarakt[] = 'punctata';
                }
                if ($katatakt_nuklearis) {
                    $a_katarakt[] = 'nuklearis';
                }
                $str_katarakt = count($a_katarakt) ? $str_katarakt = '(' . implode(', ', $a_katarakt) . ')' : '';
            } else {
                $str_katarakt = '';
            }

            if ($katarakt_nonkon_id) {
                $a_augenuntersuchung[] = 'Katarakt: ' . $optionen_au_zweifel[$katarakt_nonkon_id - 1]['name'] . ' ' . $str_katarakt;
            }

            $str_augenuntersuchung = implode(', ', $a_augenuntersuchung);
            $str_augenuntersuchung .= $hund->augenuntersuchungen[0]->datum ? ' (AU ' . $hund->augenuntersuchungen[0]->datum . ')' : '';
        } else {
            $str_augenuntersuchung = '';
        }

        // GONIOUNTERSUCHUNG (bei AT nur Flat)
        if (count($hund->goniountersuchung)) {

            $a_gonio = [];
            $str_gonio = '';

            $dyslpectabnorm_id = $hund->goniountersuchung[0]->dyslpectabnorm_id;
            $dyslpectabnorm_gewebebruecken = $hund->goniountersuchung[0]->dyslpectabnorm_gewebebruecken;
            $dyslpectabnorm_kurztrabekel = $hund->goniountersuchung[0]->dyslpectabnorm_kurztrabekel;
            $dyslpectabnorm_totaldyspl = $hund->goniountersuchung[0]->dyslpectabnorm_totaldyspl;
            if ($dyslpectabnorm_gewebebruecken) {
                $a_gonio[] = 'Gewebebrücken';
            }
            if ($dyslpectabnorm_kurztrabekel) {
                $a_gonio[] = 'kurze Trabekel';
            }
            if ($dyslpectabnorm_totaldyspl) {
                $a_gonio[] = 'Totaldysplasie';
            }
            if (count($a_gonio)) {
                $str_gonio = ' Gonio: ' . implode(', ', $a_gonio);
            } else {
                $str_gonio = ' Gonio: frei';
            }
            // $str_goniountersuchung = ' Gonio: ' . $optionen_au_zweifel[$dyslpectabnorm_id - 1]['name'];
            $str_gonio .= $hund->goniountersuchung[0]->datum ? ' (GU ' . $hund->goniountersuchung[0]->datum . ', ' . $hund->goniountersuchung[0]->arzt_titel . ' ' . $hund->goniountersuchung[0]->arzt_nachname . ')' : '';
        } else {
            $str_gonio = '';
        }
        $str_augenuntersuchung .= $str_gonio;

        // ZAHNSTATUS
        $str_zahnstatus = '';
        $str_gebiss = '';
        if (count($hund->zahnstati)) {
            $a_zahnstatus = [];
            $str_zahnstatus = 'ohne Befund';
            $optionen_zs_gebiss = OptionZSGebiss::all();

            $gebiss_id = $hund->zahnstati[0]->gebiss_id;
            $str_gebiss = $optionen_zs_gebiss[$gebiss_id - 1]['name'];

            if ($hund->zahnstati[0]->textform) {
                $a_zahnstatus[] = $hund->zahnstati[0]->textform;
            }
            if ($hund->zahnstati[0]->anmerkungen) {
                $a_zahnstatus[] = $hund->zahnstati[0]->anmerkungen;
            }
            if (count($a_zahnstatus)) {
                $str_zahnstatus = implode(', ', $a_zahnstatus);
            } else {
                $str_zahnstatus = 'ohne Befund';
            }

            $a_zahnstatus_infos = [];
            if ($hund->zahnstati[0]->datum) {
                $a_zahnstatus_infos[] = $hund->zahnstati[0]->datum;
            }
            if ($hund->zahnstati[0]->gutachter_nachname) {
                $a_zahnstatus_infos[] = trim($hund->zahnstati[0]->gutachter_titel . ' ' . $hund->zahnstati[0]->gutachter_nachname);
            }
            if (count($a_zahnstatus_infos)) {
                $str_zahnstatus .= ' (' . implode(', ', $a_zahnstatus_infos) . ')';
            }
        }
        // GENTEST
        $a_gentests = [];

        if (count($hund->gentests)) {
            $optionen_gentests_standard = OptionGentestStd::all();
            $optionen_gentests_farbverduennung = OptionGentestFarbverduennung::all();
            $optionen_gentests_haarlaenge = OptionGentestHaarlaenge::all();
            $optionen_gentests_farbe_gelb = OptionGentestFarbeGelb::all();
            $optionen_gentests_farbe_braun = OptionGentestFarbeBraun::all();

            if ($hund->gentests[0]['pra_test_id']) {
                $a_gentests[] = 'PRA TEST ' . $optionen_gentests_standard[$hund->gentests[0]['pra_test_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['pra_prcd_gentest_id']) {
                $a_gentests[] = 'PRA PRCD ' . $optionen_gentests_standard[$hund->gentests[0]['pra_prcd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cnm_gentest_id']) {
                $a_gentests[] = 'CNM ' . $optionen_gentests_standard[$hund->gentests[0]['cnm_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['eic_gentest_id']) {
                $a_gentests[] = 'EIC ' . $optionen_gentests_standard[$hund->gentests[0]['eic_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['dm_gentest_id']) {
                $a_gentests[] = 'DM ' . $optionen_gentests_standard[$hund->gentests[0]['dm_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['sd2_gentest_id']) {
                $a_gentests[] = 'SD2 ' . $optionen_gentests_standard[$hund->gentests[0]['sd2_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['narc_gentest_id']) {
                $a_gentests[] = 'NARC ' . $optionen_gentests_standard[$hund->gentests[0]['narc_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['rd_osd_gentest_id']) {
                $a_gentests[] = 'RD/OSD ' . $optionen_gentests_standard[$hund->gentests[0]['rd_osd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cea_ch_gentest_id']) {
                $a_gentests[] = 'CEA ' . $optionen_gentests_standard[$hund->gentests[0]['cea_ch_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['gr_pra1_gentest_id']) {
                $a_gentests[] = 'GR PRA1 ' . $optionen_gentests_standard[$hund->gentests[0]['gr_pra1_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['gr_pra2_gentest_id']) {
                $a_gentests[] = 'GR PRA2 ' . $optionen_gentests_standard[$hund->gentests[0]['gr_pra2_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['haarlaenge_id']) {
                $a_gentests[] = 'Haarlänge ' . $optionen_gentests_haarlaenge[$hund->gentests[0]['haarlaenge_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['gsdiiia_gentest_id']) {
                $a_gentests[] = 'GSDIIIa ' . $optionen_gentests_standard[$hund->gentests[0]['gsdiiia_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['grmd_gentest_id']) {
                $a_gentests[] = 'GRMD ' . $optionen_gentests_standard[$hund->gentests[0]['grmd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ict_a_gentest_id']) {
                $a_gentests[] = 'ICT/A ' . $optionen_gentests_standard[$hund->gentests[0]['ict_a_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ed_sfs_gentest_id']) {
                $a_gentests[] = 'ED/SFS ' . $optionen_gentests_standard[$hund->gentests[0]['ed_sfs_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['hnpk_gentest_id']) {
                $a_gentests[] = 'HNPK ' . $optionen_gentests_standard[$hund->gentests[0]['hnpk_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ncl5_gentest_id']) {
                $a_gentests[] = 'NCL5 ' . $optionen_gentests_standard[$hund->gentests[0]['ncl5_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ncl_f_gentest_id']) {
                $a_gentests[] = 'NCL/F ' . $optionen_gentests_standard[$hund->gentests[0]['ncl_f_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['farbtest_gelb_id']) {
                $a_gentests[] = 'Farbtest Gelb ' . $optionen_gentests_farbe_gelb[$hund->gentests[0]['farbtest_gelb_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['farbtest_braun_id']) {
                $a_gentests[] = 'Farbetest Braun ' . $optionen_gentests_farbe_braun[$hund->gentests[0]['farbtest_braun_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['farbverduennung_id']) {
                $a_gentests[] = 'Farbverdünnung ' . $optionen_gentests_farbverduennung[$hund->gentests[0]['farbverduennung_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['den_gentest_id']) {
                $a_gentests[] = 'DEN ' . $optionen_gentests_standard[$hund->gentests[0]['den_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ict_2_gentest_id']) {
                $a_gentests[] = 'ICT/2 ' . $optionen_gentests_standard[$hund->gentests[0]['ict_2_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['jadd_gentest_id']) {
                $a_gentests[] = 'JADD ' . $optionen_gentests_standard[$hund->gentests[0]['jadd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['ivdd_gentest_id']) {
                $a_gentests[] = 'IVDD ' . $optionen_gentests_standard[$hund->gentests[0]['ivdd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cp1_gentest_id']) {
                $a_gentests[] = 'CP1 ' . $optionen_gentests_standard[$hund->gentests[0]['cp1_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cps_gentest_id']) {
                $a_gentests[] = 'CPS ' . $optionen_gentests_standard[$hund->gentests[0]['cps_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['clps_gentest_id']) {
                $a_gentests[] = 'CLPS ' . $optionen_gentests_standard[$hund->gentests[0]['clps_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cms_gentest_id']) {
                $a_gentests[] = 'CMS ' . $optionen_gentests_standard[$hund->gentests[0]['cms_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['dann_farbtest_id']) {
                $a_gentests[] = 'DANN ' . $optionen_gentests_standard[$hund->gentests[0]['dann_farbtest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['mh_gentest_id']) {
                $a_gentests[] = 'MH ' . $optionen_gentests_standard[$hund->gentests[0]['mh_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cddy_gentest_id']) {
                $a_gentests[] = 'CDDY ' . $optionen_gentests_standard[$hund->gentests[0]['cddy_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cdpa_gentest_id']) {
                $a_gentests[] = 'CDPA ' . $optionen_gentests_standard[$hund->gentests[0]['cdpa_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['huu_gentest_id']) {
                $a_gentests[] = 'HUU ' . $optionen_gentests_standard[$hund->gentests[0]['huu_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['deb_gentest_id']) {
                $a_gentests[] = 'DEB ' . $optionen_gentests_standard[$hund->gentests[0]['deb_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['buff_gentest_id']) {
                $a_gentests[] = 'BUFF ' . $optionen_gentests_standard[$hund->gentests[0]['buff_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['dil_gentest_id']) {
                $a_gentests[] = 'DIL ' . $optionen_gentests_standard[$hund->gentests[0]['dil_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['md_gentest_id']) {
                $a_gentests[] = 'MD ' . $optionen_gentests_standard[$hund->gentests[0]['md_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['mdr1_gentest_id']) {
                $a_gentests[] = 'MDR1 ' . $optionen_gentests_standard[$hund->gentests[0]['mdr1_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['cord1_pra_gentest_id']) {
                $a_gentests[] = 'CORD1 ' . $optionen_gentests_standard[$hund->gentests[0]['cord1_pra_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['glasknochen_gentest_id']) {
                $a_gentests[] = 'Glasknochen ' . $optionen_gentests_standard[$hund->gentests[0]['glasknochen_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['stgd_gentest_id']) {
                $a_gentests[] = 'STGD ' . $optionen_gentests_standard[$hund->gentests[0]['stgd_gentest_id'] - 1]['name'];
            }
            if ($hund->gentests[0]['oi_gentest_id']) {
                $a_gentests[] = 'OI ' . $optionen_gentests_standard[$hund->gentests[0]['oi_gentest_id'] - 1]['name'];
            }
        }

        //
        // FORMWERT
        //
        $a_auflagen = [];
        $a_formwert = [];

        if (count($hund->formwert)) {

            if ($hund->formwert[0]->resultable->formwert) {
                $a_formwert[] = $hund->formwert[0]->resultable->formwert;
            }
            if ($hund->formwert[0]->resultable->datum) {
                $a_formwert[] = $hund->formwert[0]->resultable->datum;
            }
            if ($hund->formwert[0]->resultable->ort) {
                $a_formwert[] = $hund->formwert[0]->resultable->ort;
            }
            if ($hund->formwert[0]->resultable->risthoehe) {
                $a_formwert[] = 'Risthöhe ' . $hund->formwert[0]->resultable->risthoehe . ' cm';
            }
            if ($hund->formwert[0]->resultable->richter) {
                $a_formwert[] = 'Richter ' . $hund->formwert[0]->resultable->richter;
            }
            if ($hund->formwert[0]->resultable->beurteilung) {
                $a_formwert[] = $hund->formwert[0]->resultable->beurteilung;
            }

            if ($hund->formwert[0]->resultable->auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->auflagen;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_gonio) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_gonio;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_hc) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_hc;
            }
            if ($hund->formwert[0]->resultable->augen_auflagen_rd) {
                $a_auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_rd;
            }
            if ($hund->formwert[0]->resultable->ed_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->ed_auflagen;
            }
            if ($hund->formwert[0]->resultable->fw_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->fw_auflagen;
            }
            if ($hund->formwert[0]->resultable->gebiss_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gebiss_auflagen;
            }
            if ($hund->formwert[0]->resultable->gentest_auflagen_pra) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_pra;
            }
            if ($hund->formwert[0]->resultable->gentest_auflagen_sonst) {
                $a_auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_sonst;
            }
            if ($hund->formwert[0]->resultable->hd_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->hd_auflagen;
            }
            if ($hund->formwert[0]->resultable->leistung_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->leistung_auflagen;
            }
            if ($hund->formwert[0]->resultable->sonst_auflagen) {
                $a_auflagen[] = $hund->formwert[0]->resultable->sonst_auflagen;
            }

            // switch ($hund->formwert[0]->resultable_type) {
            //    case 'App\\Models\\Formwert_v0':
            //    case 'App\\Models\\Formwert_v1':
            //       break;
            // }

            $str_formwert = implode(', ', $a_formwert);
            $str_auflagen = implode(', ', $a_auflagen);
        } else {
            $str_formwert = '';
            $str_auflagen = '';
        }

        //
        // WESENSTEST
        //

        if (count($hund->wesenstest)) {

            $a_wesenstest = [];

            if ($hund->wesenstest[0]->resultable->datum) {
                $a_wesenstest[] = $hund->wesenstest[0]->resultable->datum;
            }
            if ($hund->wesenstest[0]->resultable->ort) {
                $a_wesenstest[] = $hund->wesenstest[0]->resultable->ort;
            }
            if ($hund->wesenstest[0]->resultable->alter) {
                $a_wesenstest[] = 'Alter ' . $hund->wesenstest[0]->resultable->alter . ' Monate';
            }
            if ($hund->wesenstest[0]->resultable->richter) {
                $a_wesenstest[] = 'Richter ' . $hund->wesenstest[0]->resultable->richter;
            }

            switch ($hund->wesenstest[0]->resultable_type) {
                case 'App\\Models\\Wesenstest_v0':
                    if ($hund->wesenstest[0]->resultable->beurteilung) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->beurteilung;
                    }
                    if ($hund->wesenstest[0]->resultable->auflage) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->auflage;
                    }
                    break;
                case 'App\\Models\\Wesenstest_v1':
                    if ($hund->wesenstest[0]->resultable->bemerkungen) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->bemerkungen;
                    }
                    break;
                case 'App\\Models\\Wesenstest_v2':
                    if ($hund->wesenstest[0]->resultable->zusammenfassende_beschreibung) {
                        $a_wesenstest[] = $hund->wesenstest[0]->resultable->zusammenfassende_beschreibung;
                    }
                    break;
            }

            $str_wesenstest = implode(', ', $a_wesenstest);
        } else {
            $str_wesenstest = '';
        }

        $str_gentests = implode(', ', $a_gentests);
        // return $str_gentests;

        // EIGENTÜMER
        $a_personen = [];
        $a_str_personen = [];
        foreach ($hund->personen as $index => $person) {
            $a_personen[$index] = [];
            $a_personen[$index][] = $person->vorname . ' ' . $person->nachname;
            if ($person->strasse) {
                $a_personen[$index][] = $person->strasse;
            }
            if ($person->ort) {
                $a_personen[$index][] = $person->plz . ' ' . $person->ort;
            }
            if ($person->land) {
                $a_personen[$index][] = $person->land;
            }
            if ($person->telefon) {
                $a_personen[$index][] = $person->telefon;
            }
            if ($person->email) {
                $a_personen[$index][] = $person->email;
            }

            $a_str_personen[] = implode('<br />', $a_personen[$index]);
        }

        $str_personen = implode('<br /><br />', $a_str_personen);

        // ZÜCHTER / ZUCHTSTÄTTE

        // ZUCHTZULASSUNG

        // ZUCHTAUSSCHLUSSFEHLER
        $a_zuchtausschlussfehler = [];
        $str_zuchtausschlussfehler = implode(', ', $a_zuchtausschlussfehler);

        // PRÜFUNGEN
        $pruefungen = [];

        foreach ($hund->pruefungen as $pruefung) {
            // PRÜFUNGSTYP vorhanden?

            if (array_key_exists($pruefung->type_id, $pruefungen)) {
                // JA -> update

                switch ($pruefung->type->template_type) {

                    //STANDARD
                    case 0:
                        if ($pruefung->jahr) {
                            $pruefungen[$pruefung->type_id]['jahre'][] = "'" . substr($pruefung->jahr, -2);
                        }

                        if ($pruefung->ausrichter_id) {
                            if (! in_array($pruefung->ausrichter->name_kurz, $pruefungen[$pruefung->type_id]['a_ausrichter'])) {
                                $pruefungen[$pruefung->type_id]['a_ausrichter'][] = $pruefung->ausrichter->name_kurz;
                            }
                        }
                        if ($pruefung->classement_id) {
                            if (! in_array($pruefung->classement->name_kurz, $pruefungen[$pruefung->type_id]['a_classements'])) {
                                $pruefungen[$pruefung->type_id]['a_classements'][] = $pruefung->classement->name_kurz;
                            }
                        }

                        if ($pruefung->wertung_id) {
                            if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_wertungen'])) {
                                $pruefungen[$pruefung->type_id]['a_wertungen'][] = $pruefung->wertung->name_kurz;
                            }
                        }
                        if ($pruefung->zusatz_id) {
                            if (! in_array($pruefung->zusatz->name_kurz, $pruefungen[$pruefung->type_id]['a_zusaetze'])) {
                                $pruefungen[$pruefung->type_id]['a_zusaetze'][] = $pruefung->zusatz->name_kurz;
                            }
                        }
                        break;

                        // FÄHRTENPRÜFUNGEN 20/40
                    case 1:
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte und 40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        break;

                        // KLASSE-PREISZIFFER
                    case 2:

                        break;
                }
            } else {

                // NEIN -> add
                switch ($pruefung->type->template_type) {

                    case 0:
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'classement_template' => $pruefung->type->classement_template,
                            'zusatz_template' => $pruefung->type->zusatz_template,
                            'jahr_template' => $pruefung->type->jahr_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'jahre' => '',
                            'ausrichter' => '',
                            'classements' => '',
                            'wertungen' => '',
                            'zusaetze' => '',
                            'a_ausrichter' => [],
                            'a_classements' => [],
                            'a_wertungen' => [],
                            'a_zusaetze' => [],
                            'a_jahre' => [],

                        ];

                        if ($pruefung->ausrichter_id) {
                            if (! in_array($pruefung->ausrichter->name_kurz, $pruefungen[$pruefung->type_id]['a_ausrichter'])) {
                                $pruefungen[$pruefung->type_id]['a_ausrichter'][] = $pruefung->ausrichter->name_kurz;
                            }
                        }
                        if ($pruefung->classement_id) {
                            if (! in_array($pruefung->classement->name_kurz, $pruefungen[$pruefung->type_id]['a_classements'])) {
                                $pruefungen[$pruefung->type_id]['a_classements'][] = $pruefung->classement->name_kurz;
                            }
                        }

                        if ($pruefung->wertung_id) {
                            if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_wertungen'])) {
                                $pruefungen[$pruefung->type_id]['a_wertungen'][] = $pruefung->wertung->name_kurz;
                            }
                        }
                        if ($pruefung->zusatz_id) {
                            if (! in_array($pruefung->zusatz->name_kurz, $pruefungen[$pruefung->type_id]['a_zusaetze'])) {
                                $pruefungen[$pruefung->type_id]['a_zusaetze'][] = $pruefung->zusatz->name_kurz;
                            }
                        }
                        if ($pruefung->jahr) {
                            $pruefungen[$pruefung->type_id]['jahre'][] = "'" . substr($pruefung->jahr, -2);
                        }

                        break;

                    case 1:   // FÄHRTENPRÜFUNG
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            '20er' => '',
                            '40er' => '',
                            '2040er' => '',
                            'a_20er' => [],
                            'a_40er' => [],
                            'a_2040er' => [],
                        ];

                        // if ($pruefung->classement_id == 8) {
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_20er'])) {
                                    $pruefungen[$pruefung->type_id]['a_20er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_40er'])) {
                                    $pruefungen[$pruefung->type_id]['a_40er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        if ($pruefung->classement->name_kurz == '20 Std.-Fährte und 40 Std.-Fährte') {
                            if ($pruefung->wertung_id) {
                                if (! in_array($pruefung->wertung->name_kurz, $pruefungen[$pruefung->type_id]['a_2040er'])) {
                                    $pruefungen[$pruefung->type_id]['a_2040er'][] = $pruefung->wertung->name_kurz;
                                }
                            }
                        }
                        break;

                    case 2:   // VERSCHACHTELTE KLASSE-PREISZIFFER
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'classement_wertung' => '',
                            'a_classement_wertung' => [],
                        ];

                        $a_klasse_wertung = [];
                        if ($pruefung->classement_id) {
                            $a_klasse_wertung[] = $pruefung->classement->name_kurz;
                        }
                        if ($pruefung->wertung_id) {
                            $a_klasse_wertung[] = $pruefung->wertung->name_kurz . '.pr.';
                        }

                        $str_klasse_wertung = '(' . implode('-', $a_klasse_wertung) . ')';

                        if ($str_klasse_wertung) {
                            if (! in_array($str_klasse_wertung, $pruefungen[$pruefung->type_id]['a_classement_wertung'])) {
                                $pruefungen[$pruefung->type_id]['a_classement_wertung'][] = $str_klasse_wertung;
                            }
                        }
                        break;

                    case 3:   // VERSCHACHTELTE KLASSE-PREISZIFFER
                        $pruefungen[$pruefung->type_id] = [
                            'template' => $pruefung->type->name_template,
                            'template_type' => $pruefung->type->template_type,
                            'ausrichter_template' => $pruefung->type->ausrichter_template,
                            'wertung_template' => $pruefung->type->wertung_template,
                            'typ_id' => $pruefung->type_id,
                            'typ' => $pruefung->pruefung_name,
                            'output' => '',
                            'classement_wertung' => '',
                            'a_classement_wertung' => [],
                        ];

                        $a_klasse_wertung = [];
                        if ($pruefung->classement_id) {
                            $a_klasse_wertung[] = $pruefung->classement->name_kurz . 'm';
                        }
                        if ($pruefung->wertung_id) {
                            $a_klasse_wertung[] = $pruefung->wertung->name_kurz . '.pr.';
                        }

                        $str_klasse_wertung = '(' . implode('-', $a_klasse_wertung) . ')';

                        if ($str_klasse_wertung) {
                            if (! in_array($str_klasse_wertung, $pruefungen[$pruefung->type_id]['a_classement_wertung'])) {
                                $pruefungen[$pruefung->type_id]['a_classement_wertung'][] = $str_klasse_wertung;
                            }
                        }
                        break;
                }
            }
        }

        $a_pruefungen_output = [];

        foreach ($pruefungen as &$pruefung) {

            switch ($pruefung['template_type']) {

                case 0:
                    $pruefung['ausrichter'] = implode('/', $pruefung['a_ausrichter']);
                    $pruefung['classements'] = implode('/', $pruefung['a_classements']);
                    $pruefung['wertungen'] = implode('/', $pruefung['a_wertungen']);
                    $pruefung['zusaetze'] = implode('/', $pruefung['a_zusaetze']);
                    $pruefung['jahre'] = implode('', $pruefung['a_jahre']);

                    $d_ausrichter = $pruefung['ausrichter'] ? str_replace('[DATA]', $pruefung['ausrichter'], $pruefung['ausrichter_template']) : '';
                    $d_wertung = $pruefung['wertungen'] ? str_replace('[DATA]', $pruefung['wertungen'], $pruefung['wertung_template']) : '';
                    $d_classement = $pruefung['classements'] ? str_replace('[DATA]', $pruefung['classements'], $pruefung['classement_template']) : '';
                    $d_zusatz = $pruefung['zusaetze'] ? str_replace('[DATA]', $pruefung['zusaetze'], $pruefung['zusatz_template']) : '';
                    $d_jahre = str_replace('[DATA]', $pruefung['jahre'], $pruefung['jahr_template']);

                    $output = str_replace(
                        ['{AUSRICHTER}', '{WERTUNG}', '{CLASSEMENT}', '{ZUSATZ}', '{JAHRE}'],
                        [$d_ausrichter, $d_wertung, $d_classement, $d_zusatz, $d_jahre],
                        $pruefung['template']
                    );
                    $a_pruefungen_output[] = $output;
                    break;

                    // FÄHRTENPRÜFUNG
                case 1:
                    if ($pruefung['20er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', '/' . implode('+', $pruefung['a_20er']), $pruefung['template']);
                    }
                    if ($pruefung['40er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', implode('+', $pruefung['a_40er']) . '/', $pruefung['template']);
                    }
                    if ($pruefung['2040er']) {
                        $a_outputs[] = str_replace('{FAEHRTE-PREISZIFFER}', '/' . implode('+', $pruefung['a_2040er']) . '/', $pruefung['template']);
                    }
                    $a_pruefungen_output[] = implode(' ', $a_outputs);

                    break;

                case 2:
                    $a_pruefungen_output[] = str_replace('{KLASSE-PREISZIFFER}', implode('/', $pruefung['a_classement_wertung']), $pruefung['template']);
                    break;

                case 3:
                    $a_pruefungen_output[] = str_replace('{LAENGE-PREISZIFFER}', implode('/', $pruefung['a_classement_wertung']), $pruefung['template']);
                    break;

            }
        }
        $str_pruefungen = implode(' ', $a_pruefungen_output);

        // TITEL
        $titels = [];
        // TODO: SORTIERUNG AUSRICHTER / JAHRE
        $sort_ausrichter = true;

        foreach ($hund->titel as $titel) {

            $titel->type_id = $titel->type_id ? $titel->type_id : 0;
            $titeltyp = TitelTyp::find($titel->type_id);
            $sort_ausrichter = $titeltyp->sort_by_ausrichter;

            // TITELTYP vorhanden?
            if (array_key_exists($titel->type_id, $titels)) {
                // JA -> update
                if ($sort_ausrichter) {
                    // SORTIERE NACH AUSRICHTER
                    $ausrichters = $titels[$titel->type_id]['ausrichter'];
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    // KOMMT DER AUSRICHTER SCHON MAL VOR
                    if (array_key_exists($titel->ausrichter_id, $ausrichters)) {
                        $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['ausrichter'][$titel->ausrichter_id]['jahre'] .= $str_jahr;
                    } else {
                        $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['ausrichter'][$titel->ausrichter_id] = [
                            'name' => $ausrichter_name,
                            'jahre' => $str_jahr,
                        ];
                    }
                } else {
                    // SORTIERE NACH JAHREN
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    $jahr = $titel->jahr > 0 ? substr($titel->jahr, -2) : '';
                    $jahre = $titels[$titel->type_id]['jahre'];

                    if (array_key_exists($jahr, $jahre) && $jahr != '') {
                        //$str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        if (! in_array($ausrichter_name, $titels[$titel->type_id]['jahre'][$jahr])) {
                            $titels[$titel->type_id]['jahre'][$jahr][] = $ausrichter_name;
                        }
                    } elseif ($jahr != '') {
                        // $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                        $titels[$titel->type_id]['jahre'][$jahr] = [$ausrichter_name];
                    } else {

                        if (! in_array($ausrichter_name, $titels[$titel->type_id]['ausrichter'])) {
                            $titels[$titel->type_id]['ausrichter'][] = $ausrichter_name;
                        }
                    }
                }
            } else {
                // NEIN -> add
                if ($sort_ausrichter) {
                    // SORTIERE NACH AUSRICHTER
                    $str_jahr = $titel->jahr > 0 ? "'" . substr($titel->jahr, -2) : '';
                    $ausrichter = [];
                    $ausrichter_name = $titel->ausrichter_id ? $titel->ausrichter->name_kurz : '';
                    $ausrichter[$titel->ausrichter_id] = [
                        'name' => $ausrichter_name,
                        'jahre' => $str_jahr,
                    ];
                    $titels[$titel->type_id] = [
                        'anzahl' => 1,
                        'template' => $titel->type->name_template,
                        'template_type' => $titel->type->template_type,
                        'typ_id' => $titel->type_id,
                        'typ' => $titel->titel_name,
                        'ausrichter' => $ausrichter,
                        'sort_by_ausrichter' => 1,
                    ];
                } else {
                    // SORTIERE NACH JAHREN
                    $jahre = [];
                    $jahr = $titel->jahr > 0 ? substr($titel->jahr, -2) : '';
                    $ausrichter_name = $titel->ausrichter->exists() ? $titel->ausrichter->name_kurz : '';

                    if ($jahr != '') {
                        $jahre[$jahr] = [$ausrichter_name];
                        $ausrichter = [];
                    } else {
                        $ausrichter = [$ausrichter_name];
                        $jahre = [];
                    }
                    $titels[$titel->type_id] = [
                        'anzahl' => 1,
                        'template' => $titel->type->name_template,
                        'template_type' => $titel->type->template_type,
                        'typ_id' => $titel->type_id,
                        'typ' => $titel->titel_name,
                        'jahre' => $jahre,
                        'ausrichter' => $ausrichter,
                        'sort_by_ausrichter' => 0,
                    ];
                }
            }
        }

        $str_titels = '';
        $a_ausrichter = [];

        // SORTIERE NACH AUSRICHTER
        foreach ($titels as $titel) {

            if ($titel['sort_by_ausrichter']) {

                $a_ausrichter = [];

                foreach ($titel['ausrichter'] as $key => $value) {
                    $a_ausrichter[] = $value['name'] . $value['jahre'];
                }

                $data = count($a_ausrichter) ? implode('/', $a_ausrichter) : '';

                switch ($titel['template_type']) {
                    case 0:
                        $str_titels .= $titel['template'] . ' ';
                        break;
                    case 1:
                        $str_titels .= str_replace('[DATA]', $data, $titel['template']) . ' ';
                        break;
                    case 2:
                        $str_titels .= str_replace('[DATA-]', $data . '-', $titel['template']) . ' ';
                        break;
                    case 3:
                        $str_titels .= str_replace('[-DATA]', '-' . $data, $titel['template']) . ' ';
                        break;
                }
            } else {
                $a_jahre = [];

                foreach ($titel['jahre'] as $key => $value) {
                    // return [ "titel" => $titel, "key" => $key, "value" => $value ];

                    $a_jahre[] = implode('/', $value) . "'" . $key;
                }
                $data = implode('/', $a_jahre);

                switch ($titel['template_type']) {
                    case 0:
                        $str_titels .= $titel['template'] . ' ';
                        break;
                    case 1:
                        $str_titels .= str_replace('[DATA]', $data, $titel['template']) . ' ';
                        break;
                    case 2:
                        $str_titels .= str_replace('[DATA-]', $data . '-', $titel['template']) . ' ';
                        break;
                    case 3:
                        $str_titels .= str_replace('[-DATA]', '-' . $data, $titel['template']) . ' ';
                        break;
                }
            }
        }

        $hund_prerendered = HundPrerendered::find($id);

        if (! $hund_prerendered) {
            $hund_prerendered = new HundPrerendered();
            $hund_prerendered->id = $hund->id;
            $hund_prerendered->hund_id = $hund->id;
        }

        $hund_prerendered->hund_id = $hund->id;
        $hund_prerendered['name'] = $hund['name'];
        $hund_prerendered->farbe = $hund->farbe['name'];
        $hund_prerendered->rasse = $hund->rasse['name'];
        $hund_prerendered->geschlecht = $hund->geschlecht['name'];
        $hund_prerendered->gstb_nr = $hund->gstb_nr;
        $hund_prerendered->drc_gstb_nr = $hund->drc_gstb_nr;
        $hund_prerendered->wurfdatum = $hund->wurfdatum;
        $hund_prerendered->zuchtart = $hund->zuchtart_id ? $hund->zuchtart->name : '';

        $hund_prerendered->personen = $str_personen;
        $hund_prerendered->zuchtzulassung = $hund->zuchtzulassung ? 'Zuchtzulassung am ' : 'Keine Zuchtzulassung';

        $hund_prerendered->wurfzwinger = $str_wurfzwinger;
        $hund_prerendered->zuechter_nachname = $hund->zuechter_nachname;
        $hund_prerendered->zuechter_vorname = $hund->zuechter_vorname;
        $hund_prerendered->zwinger_name = $hund->zwinger_name;
        $hund_prerendered->zwinger_strasse = $hund->zwinger_strasse;
        $hund_prerendered->zwinger_plz = $hund->zwinger_plz;
        $hund_prerendered->zwinger_ort = $hund->zwinger_ort;
        $hund_prerendered->zwinger_telefon = $hund->zwinger_tel;
        $hund_prerendered->zwinger_fci = $hund->zwinger_fci;

        $hund_prerendered->vater_name = $hund->vater_name;
        $hund_prerendered->vater_zuchtbuchnummer = $hund->vater_zuchtbuchnummer;
        $hund_prerendered->vater_id = $hund->vater_id;
        $hund_prerendered->mutter_name = $hund->mutter_name;
        $hund_prerendered->mutter_zuchtbuchnummer = $hund->mutter_zuchtbuchnummer;
        $hund_prerendered->mutter_id = $hund->mutter_id;
        $hund_prerendered->abstammungsnachweis = $hund->abstammung_nachgewiesen ? 'Abstammungsnachweis liegt vor.' : '';
        $hund_prerendered->zuchtbuchnummern = $str_zuchtbuchnummern;
        $hund_prerendered->chipnummern = $str_chipnummern;
        $hund_prerendered->zuchtbuchnummer = $zuchtbuchnummer;
        $hund_prerendered->chipnummer = $chipnummer;
        $hund_prerendered->taetowierung = $hund->taetowierung;
        $hund_prerendered->verstorben = $hund->sterbedatum ? $hund->sterbedatum : ($hund->verstorben ? 'verstorben, Datum unbekannt' : '');

        $hund_prerendered->knickrute = $hund->knickrute ? 'Knickrute' : '';
        $hund_prerendered->formwert = $str_formwert;
        $hund_prerendered->formwert_auflagen = $str_auflagen;
        $hund_prerendered->wesenstest = $str_wesenstest;

        $hund_prerendered->kastration = $hund->kastration ? ($hund->geschlecht_id == 1 ? 'sterilisiert' : 'kastriert') : '';

        $hund_prerendered->gelenke = $str_gelenke;
        $hund_prerendered->augenuntersuchung = $str_augenuntersuchung;
        $hund_prerendered->gebiss = $str_gebiss;
        $hund_prerendered->zahnstatus = $str_zahnstatus;
        $hund_prerendered->pruefungen = $str_pruefungen;
        $hund_prerendered->titel = $str_titels;
        $hund_prerendered->gentests = $str_gentests;

        $hund_prerendered->save();

        return $hund;

    }
}
