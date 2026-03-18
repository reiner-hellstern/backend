<?php

namespace App\Http\Resources;

use App\Models\Hund;
use Illuminate\Http\Resources\Json\JsonResource;

class HundesucheResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

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
            'chipnummer' => $this->chipnummer,
            'vater_zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
            'mutter_zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
            'mutter_name' => $this->mutter_name,
            'vater_name' => $this->vater_name,
            'zuechter_vorname' => $this->zuechter_vorname,
            'zuechter_nachname' => $this->zuechter_nachname,
            'zuechter_id' => $this->zuechter_id,
            'herkunftszuchtstaette_name' => $this->zwinger_name,
            'herkunftszuchtstaette_strasse' => $this->zwinger_strasse,
            'herkunftszuchtstaette_plz' => $this->zwinger_plz,
            'herkunftszuchtstaette_ort' => $this->zwinger_ort,
            'herkunftszuchtstaette_fci' => $this->zwinger_fci,
            'herkunftszuchtstaette_telefon' => $this->zwinger_tel,
            'herkunftszuchtstaette_id' => $this->zwinger_id,
            'sterbedatum' => $this->sterbedatum,
            'abstammungsnachweis' => $this->abstammungsnachweis ? $this->abstammungsnachweis->abstammungsnachweis : 0,
            'zuchthund' => $this->zuchthund,
            'zuchtart_id' => $this->zuchtart_id,
            'zuchtzulassung' => $this->zuchtzulassung,
            'zuchtzulassung_id' => $this->zuchtzulassung_id,
            'freigabe' => $this->freigabe,
            'aktiv' => $this->aktiv,
            'status_id' => $this->status_id,
            'zuchttauglichkeit_id' => $this->zuchttauglichkeit_id,

            // 'kastration' => $this->kastration,
            'zzl' => $this->zzl,
            'zzl_datum' => $this->zzl_datum,
            'zzl_typ' => $this->zuchttauglichkeit,
            // 'eingeschlaefert' => $this->eingeschlaefert,
            // 'eingeschlaefert_grund' => $this->eingeschlaefert_grund,
            // 'todesursache' => $this->todesursache
        ];

        $hund['herkunftszuchtstaette'] = [
            'id' => $this->zwinger_id,
            'zwingername' => $this->zwinger_name,
            'zuechter' => $this->zuechter_vorname . ' ' . $this->zuechter_nachname, // $this->zuechter_vorname . ' ' . $this->zuechter_nachname,
            'vorname' => $this->zuechter_vorname,
            'nachname' => $this->zuechter_nachname,
            'zuechter_id' => $this->zuechter_id,
            'strasse' => $this->zwinger_strasse,
            'postleitzahl' => $this->zwinger_plz,
            'ort' => $this->zwinger_ort,
            'fcinummer' => $this->zwinger_fci,
            'land' => $this->zwinger_land,
            'telefon' => $this->zwinger_tel,
        ];

        $hund['zuchtbuchnummern'] = ZuchtbuchnummerResource::collection($this->zuchtbuchnummern);

        if (count($this->hdeduntersuchungen)) {
            $hund['hdeduntersuchung'] = true;
            $hund['hded_datum'] = $this->hdeduntersuchungen[0]->datum;
            $hund['hd_score'] = ($this->hdeduntersuchungen[0]->hd_score['id'] ? $this->hdeduntersuchungen[0]->hd_score['name'] : '');
            $hund['hd_l_score'] = ($this->hdeduntersuchungen[0]->hd_l_score['id'] ? $this->hdeduntersuchungen[0]->hd_l_score['name'] : '');
            $hund['hd_r_score'] = ($this->hdeduntersuchungen[0]->hd_r_score['id'] ? $this->hdeduntersuchungen[0]->hd_r_score['name'] : '');
            $hund['ed_score'] = ($this->hdeduntersuchungen[0]->ed_score['id'] ? $this->hdeduntersuchungen[0]->ed_score['name'] : '');
            $hund['ed_l_score'] = ($this->hdeduntersuchungen[0]->ed_l_score['id'] ? $this->hdeduntersuchungen[0]->ed_l_score['name'] : '');
            $hund['ed_r_score'] = ($this->hdeduntersuchungen[0]->ed_r_score['id'] ? $this->hdeduntersuchungen[0]->ed_r_score['name'] : '');
            $hund['hded_fcp'] = ($this->hdeduntersuchungen[0]->fcp ? 'FCP' : '');
            $hund['hded_ipa'] = ($this->hdeduntersuchungen[0]->ipa ? 'IPA' : '');
            $hund['hded_ocd'] = ($this->hdeduntersuchungen[0]->ocd ? 'OCD' : '');
            $hund['hded_coronoid'] = ($this->hdeduntersuchungen[0]->coronoid ? 'Coronoid' : '');
            $hund['ed_arthrose_l_score'] = ($this->hdeduntersuchungen[0]->ed_arthrose_l_score['id'] ? $this->hdeduntersuchungen[0]->ed_arthrose_l_score['name'] : '');
            $hund['ed_arthrose_r_score'] = ($this->hdeduntersuchungen[0]->ed_arthrose_r_score['id'] ? $this->hdeduntersuchungen[0]->ed_arthrose_r_score['name'] : '');
        } else {
            $hund['hdeduntersuchung'] = false;
        }

        if (count($this->augenuntersuchungen)) {
            $hund['augenuntersuchung'] = true;

            $hund['au_rd'] = $this->augenuntersuchungen[0]->rd;
            $hund['au_pra_rd'] = $this->augenuntersuchungen[0]->pra_rd;
            $hund['au_katarakt_kon'] = $this->augenuntersuchungen[0]->katarakt_kon;
            $hund['au_katarakt_nonkon'] = $this->augenuntersuchungen[0]->katarakt_nonkon;
            if ($this->augenuntersuchungen[0]->katarakt_nonkon_id > 1) {
                $a_temp = [];
                if ($this->augenuntersuchungen[0]->katarakt_cortikalis) {
                    $a_temp[] = 'lortikalis';
                }
                if ($this->augenuntersuchungen[0]->katarakt_polpost) {
                    $a_temp[] = 'pol. post.';
                }
                if ($this->augenuntersuchungen[0]->katarakt_sutura_ant) {
                    $a_temp[] = 'sutura ant.';
                }
                if ($this->augenuntersuchungen[0]->katarakt_punctata) {
                    $a_temp[] = 'punctata';
                }
                if ($this->augenuntersuchungen[0]->katarakt_nuklearis) {
                    $a_temp[] = 'nuklearis';
                }
                if ($this->augenuntersuchungen[0]->katarakt_sonstige_angaben) {
                    $a_temp[] = $this->augenuntersuchungen[0]->katarakt_sonstige_angaben;
                }
                $hund['au_katarakt_nonkon_details'] = implode(', ', $a_temp);
            } else {
                $hund['au_katarakt_nonkon_details'] = '';
            }

            $hund['au_datum'] = $this->augenuntersuchungen[0]->datum;

            // $hund['au_rd_multifokal'] = $this->augenuntersuchungen[0]->rd_multifokal;
            // $hund['au_rd_geo'] = $this->augenuntersuchungen[0]->rd_geo;
            // $hund['au_rd_total'] = $this->augenuntersuchungen[0]->rd_total;
            // $hund['au_katarakt_cortikalis'] = $this->augenuntersuchungen[0]->katarakt_cortikalis;
            // $hund['au_katarakt_polpost'] = $this->augenuntersuchungen[0]->katarakt_polpost;
            // $hund['au_katarakt_sutura_ant'] = $this->augenuntersuchungen[0]->katarakt_sutura_ant;
            // $hund['au_katarakt_punctata'] = $this->augenuntersuchungen[0]->katarakt_punctata;
            // $hund['au_katarakt_nuklearis'] = $this->augenuntersuchungen[0]->katarakt_nuklearis;
            // $hund['au_katarakt_sonstige'] = $this->augenuntersuchungen[0]->katarakt_sonstige;
            // $hund['au_katarakt_sonstige_angaben'] = $this->augenuntersuchungen[0]->katarakt_sonstige_angaben;

            // $hund['au_arzt_titel'] = $this->augenuntersuchungen[0]->arzt_titel;
            // $hund['au_arzt_vorname'] = $this->augenuntersuchungen[0]->arzt_vorname;
            // $hund['au_arzt_nachname'] = $this->augenuntersuchungen[0]->arzt_nachname;
            // $hund['au_typ'] = $this->augenuntersuchungen[0]->typ;
            // $hund['au_mpp'] = $this->augenuntersuchungen[0]->mpp;
            // $hund['au_mpp_nfrei'] = $this->augenuntersuchungen[0]->mpp_nfrei;
            // $hund['au_phtvlphpv'] = $this->augenuntersuchungen[0]->phtvlphpv;
            // $hund['au_phtvlphpv_nfrei'] = $this->augenuntersuchungen[0]->phtvlphpv_nfrei;
            // $hund['au_katarakt_kon'] = $this->augenuntersuchungen[0]->katarakt_kon;
            // $hund['au_rd'] = $this->augenuntersuchungen[0]->rd;
            // $hund['au_rd_nfrei'] = $this->augenuntersuchungen[0]->rd_nfrei;
            // $hund['au_katarakt_nonkon'] = $this->augenuntersuchungen[0]->katarakt_nonkon;
            // $hund['au_hypoplasie_mikropapille'] = $this->augenuntersuchungen[0]->hypoplasie_mikropapille;
            // $hund['au_cea'] = $this->augenuntersuchungen[0]->cea;
            // $hund['au_cea_nfrei'] = $this->augenuntersuchungen[0]->cea_nfrei;
            // $hund['au_dyslpectabnorm'] = $this->augenuntersuchungen[0]->dyslpectabnorm;
            // $hund['au_dyslpectabnorm_nfrei'] = $this->augenuntersuchungen[0]->dyslpectabnorm_nfrei;
            // $hund['au_entropium'] = $this->augenuntersuchungen[0]->entropium;
            // $hund['au_ektropium'] = $this->augenuntersuchungen[0]->ektropium;
            // $hund['au_icaa'] = $this->augenuntersuchungen[0]->icaa;
            // $hund['au_distichiasis'] = $this->augenuntersuchungen[0]->distichiasis;
            // $hund['au_korneadystrophie'] = $this->augenuntersuchungen[0]->korneadystrophie;
            // $hund['au_linsenluxation'] = $this->augenuntersuchungen[0]->linsenluxation;
            // $hund['au_pra_rd'] = $this->augenuntersuchungen[0]->pra_rd;
            // $hund['au_pla'] = $this->augenuntersuchungen[0]->pla;
            // $hund['au_primaerglaukom'] = $this->augenuntersuchungen[0]->primaerglaukom;
            // $hund['au_pla_nfrei'] = $this->augenuntersuchungen[0]->pla_nfrei;
            // $hund['au_ica_weite'] = $this->augenuntersuchungen[0]->ica_weite;
            // $hund['au_mydriatikum'] = $this->augenuntersuchungen[0]->mydriatikum;
            // $hund['au_mpp_iris'] = $this->augenuntersuchungen[0]->mpp_iris;
            // $hund['au_mpp_linse'] = $this->augenuntersuchungen[0]->mpp_linse;
            // $hund['au_mpp_komea'] = $this->augenuntersuchungen[0]->mpp_komea;
            // $hund['au_mpp_vorderkammer'] = $this->augenuntersuchungen[0]->mpp_vorderkammer;
            // $hund['au_rd_multifokal'] = $this->augenuntersuchungen[0]->rd_multifokal;
            // $hund['au_rd_geo'] = $this->augenuntersuchungen[0]->rd_geo;
            // $hund['au_rd_total'] = $this->augenuntersuchungen[0]->rd_total;
            // $hund['au_katarakt_cortikalis'] = $this->augenuntersuchungen[0]->katarakt_cortikalis;
            // $hund['au_katarakt_polpost'] = $this->augenuntersuchungen[0]->katarakt_polpost;
            // $hund['au_katarakt_sutura_ant'] = $this->augenuntersuchungen[0]->katarakt_sutura_ant;
            // $hund['au_katarakt_punctata'] = $this->augenuntersuchungen[0]->katarakt_punctata;
            // $hund['au_katarakt_nuklearis'] = $this->augenuntersuchungen[0]->katarakt_nuklearis;
            // $hund['au_katarakt_sonstige'] = $this->augenuntersuchungen[0]->katarakt_sonstige;
            // $hund['au_katarakt_sonstige_angaben'] = $this->augenuntersuchungen[0]->katarakt_sonstige_angaben;
            // $hund['au_cea_choroidhypo'] = $this->augenuntersuchungen[0]->cea_choroidhypo;
            // $hund['au_cea_kolobom'] = $this->augenuntersuchungen[0]->cea_kolobom;
            // $hund['au_cea_sonstige'] = $this->augenuntersuchungen[0]->cea_sonstige;
            // $hund['au_cea_sonstige_angaben'] = $this->augenuntersuchungen[0]->cea_sonstige_angaben;
            // $hund['au_dyslpectabnorm_kurztrabekel'] = $this->augenuntersuchungen[0]->dyslpectabnorm_kurztrabekel;
            // $hund['au_dyslpectabnorm_gewebebruecken'] = $this->augenuntersuchungen[0]->dyslpectabnorm_gewebebruecken;
            // $hund['au_dyslpectabnorm_totaldyspl'] = $this->augenuntersuchungen[0]->dyslpectabnorm_totaldyspl;
        } else {
            $hund['augenuntersuchung'] = false;
        }

        if (count($this->goniountersuchung)) {
            $hund['goniountersuchung'] = true;
            $hund['gu_datum'] = $this->goniountersuchung[0]->datum;
            $hund['gu_arzt_titel'] = $this->goniountersuchung[0]->arzt_titel;
            $hund['gu_arzt_vorname'] = $this->goniountersuchung[0]->arzt_vorname;
            $hund['gu_arzt_nachname'] = $this->goniountersuchung[0]->arzt_nachname;
            $hund['gu_dyslpectabnorm'] = $this->goniountersuchung[0]->dyslpectabnorm;
            $hund['gu_dyslpectabnorm_nfrei'] = $this->goniountersuchung[0]->dyslpectabnorm_nfrei;
            // $hund['gu_entropium'] = $this->goniountersuchung[0]->entropium;
            // $hund['gu_ektropium'] = $this->goniountersuchung[0]->ektropium;

            if ($this->goniountersuchung[0]->dyslpectabnorm_id > 1) {

                if ($this->goniountersuchung[0]->dyslpectabnorm_nfrei_id > 0) {
                    $hund['gu_gonio'] = $this->goniountersuchung[0]->dyslpectabnorm_nfrei;
                } else {
                    $a_temp = [];
                    if ($this->goniountersuchung[0]->dyslpectabnorm_kurztrabekel) {
                        $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_kurztrabekel;
                    }
                    if ($this->goniountersuchung[0]->dyslpectabnorm_gewebebruecken) {
                        $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_gewebebruecken;
                    }
                    if ($this->goniountersuchung[0]->dyslpectabnorm_totaldyspl) {
                        $a_temp[] = $this->goniountersuchung[0]->dyslpectabnorm_totaldyspl;
                    }
                    $hund['gu_gonio'] = implode(', ', $a_temp);
                }
            }
        } else {
            $hund['goniountersuchung'] = false;
        }

        //
        // ZAHNSTAUTS
        //
        if (count($this->zahnstati)) {
            $hund['zahnstatus'] = true;
            $hund['zahnstatus_gebiss'] = $this->zahnstati[0]->gebiss['name'];
            $hund['zahnstatus_befund_schema'] = $this->zahnstati[0]->textform;
            $hund['zahnstatus_befund_anmerkungen'] = $this->zahnstati[0]->anmerkung;
        } else {
            $hund['zahnstatus'] = false;
        }

        //
        // FORMWERT
        //
        $hund['auflagen'] = [];

        if (count($this->formwert)) {
            $hund['formwert'] = true;

            if ($this->formwert[0]->resultable_type == 'App\\Models\\Formwert_v0' || $this->formwert[0]->resultable_type == 'App\\Models\\Formwert_v1') {
                $hund['formwert_datum'] = $this->formwert[0]->resultable->datum;
                $hund['formwert_beurteilung'] = $this->formwert[0]->resultable->beurteilung;
                $hund['formwert_formwert'] = $this->formwert[0]->resultable->formwert;
                $hund['formwert_risthoehe'] = $this->formwert[0]->resultable->risthoehe;
                $hund['formwert_richter'] = $this->formwert[0]->resultable->richter;
                // $hund['formwert_auflagen'] = $this->formwert[0]->resultable->auflagen;
                // $hund['formwert_augen_auflagen_gonio'] = $this->formwert[0]->resultable->augen_auflagen_gonio;
                // $hund['formwert_augen_auflagen_hc'] = $this->formwert[0]->resultable->augen_auflagen_hc;
                // $hund['formwert_augen_auflagen_rd'] = $this->formwert[0]->resultable->augen_auflagen_rd;
                // $hund['formwert_ed_auflagen'] = $this->formwert[0]->resultable->ed_auflagen;
                // $hund['formwert_fw_auflagen'] = $this->formwert[0]->resultable->fw_auflagen;
                // $hund['formwert_gebiss_auflagen'] = $this->formwert[0]->resultable->gebiss_auflagen;
                // $hund['formwert_gentest_auflagen_pra'] = $this->formwert[0]->resultable->gentest_auflagen_pra;
                // $hund['formwert_gentest_auflagen_sonst'] = $this->formwert[0]->resultable->gentest_auflagen_sonst;
                // $hund['formwert_hd_auflagen'] = $this->formwert[0]->resultable->hd_auflagen;
                // $hund['formwert_leistung_auflagen'] = $this->formwert[0]->resultable->leistung_auflagen;
                // $hund['formwert_sonst_auflagen'] = $this->formwert[0]->resultable->sonst_auflagen;

                if ($this->formwert[0]->resultable->auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->auflagen;
                }
                if ($this->formwert[0]->resultable->augen_auflagen_gonio) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->augen_auflagen_gonio;
                }
                if ($this->formwert[0]->resultable->augen_auflagen_hc) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->augen_auflagen_hc;
                }
                if ($this->formwert[0]->resultable->augen_auflagen_rd) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->augen_auflagen_rd;
                }
                if ($this->formwert[0]->resultable->ed_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->ed_auflagen;
                }
                if ($this->formwert[0]->resultable->fw_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->fw_auflagen;
                }
                if ($this->formwert[0]->resultable->gebiss_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->gebiss_auflagen;
                }
                if ($this->formwert[0]->resultable->gentest_auflagen_pra) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->gentest_auflagen_pra;
                }
                if ($this->formwert[0]->resultable->gentest_auflagen_sonst) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->gentest_auflagen_sonst;
                }
                if ($this->formwert[0]->resultable->hd_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->hd_auflagen;
                }
                if ($this->formwert[0]->resultable->leistung_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->leistung_auflagen;
                }
                if ($this->formwert[0]->resultable->sonst_auflagen) {
                    $hund['auflagen'][] = $this->formwert[0]->resultable->sonst_auflagen;
                }

            }
        } else {
            $hund['formwert'] = false;
        }

        //
        // WESENSTEST
        //
        if (count($this->wesenstest)) {
            $hund['wesenstest'] = true;

            if ($this->wesenstest[0]->resultable_type == 'App\\Models\\Wesenstest_v0' || $this->wesenstest[0]->resultable_type == 'App\\Models\\Wesenstest_v1') {
                $hund['wesenstest_datum'] = $this->wesenstest[0]->resultable->datum;
            }

            $hund['wesenstest_datum'] = $this->wesenstest[0]->resultable->datum;
            $hund['wesenstest_alter'] = $this->wesenstest[0]->resultable->alter;
            $hund['wesenstest_richter'] = $this->wesenstest[0]->resultable->richter;
            $hund['wesenstest_ort'] = $this->wesenstest[0]->resultable->ort;
            $hund['wesenstest_beurteilung'] = $this->wesenstest[0]->resultable->beurteilung;

            $hund['wesenstest_zusammenfassung'] = [
                [
                    'titel' => 'Temperament, Bewegungs-, Spielverhalten',
                    'text' => $this->wesenstest[0]->resultable->t_b_s,
                ],
                [
                    'titel' => 'Ausdauer, Unerschrockenheit, Aufmerksamkeit',
                    'text' => $this->wesenstest[0]->resultable->a_u_h_a,
                ],
                [
                    'titel' => 'Beuteverhalten, Tragen, Zutragen, Spürverhalten',
                    'text' => $this->wesenstest[0]->resultable->b_b_s_s,
                ],
                [
                    'titel' => 'Unterordnungsbereitschaft, Bindung',
                    'text' => $this->wesenstest[0]->resultable->u_b,
                ],
                [
                    'titel' => 'Sicherheit gegenüber Menschen, Kreisprobe, Seitenlage',
                    'text' => $this->wesenstest[0]->resultable->s_m_k_r,
                ],
                [
                    'titel' => 'Sicherheit gegenüber optischen und akustischen Reizen',
                    'text' => $this->wesenstest[0]->resultable->s_r,
                ],
                [
                    'titel' => 'Schussfestigkeit',
                    'text' => $this->wesenstest[0]->resultable->schuss,
                ],
                [
                    'titel' => 'Kampftrieb, Misstrauen',
                    'text' => $this->wesenstest[0]->resultable->k_m,
                ],
                [
                    'titel' => 'Unerwünschte Eigenschaften',
                    'text' => $this->wesenstest[0]->resultable->unerw_eigenschaften,
                ],
                [
                    'titel' => 'Bemerkungen',
                    'text' => $this->wesenstest[0]->resultable->bemerkung,
                ],
                [
                    'titel' => 'Auflagen',
                    'text' => $this->wesenstest[0]->resultable->auflage,
                ],
            ];

            if ($this->wesenstest[0]->resultable->auflage) {
                $hund['auflagen'][] = $this->wesenstest[0]->resultable->auflage;
            }

            // $hund['wesenstest_t_b_s'] = $this->wesenstest[0]->resultable->t_b_s;
            // $hund['wesenstest_a_u_h_a'] = $this->wesenstest[0]->resultable->a_u_h_a;
            // $hund['wesenstest_b_b_s_s'] = $this->wesenstest[0]->resultable->b_b_s_s;
            // $hund['wesenstest_u_b'] = $this->wesenstest[0]->resultable->u_b;
            // $hund['wesenstest_s_m_k_r'] = $this->wesenstest[0]->resultable->s_m_k_r;
            // $hund['wesenstest_s_r'] = $this->wesenstest[0]->resultable->s_r;
            // $hund['wesenstest_schuss'] = $this->wesenstest[0]->resultable->schuss;
            // $hund['wesenstest_k_m'] = $this->wesenstest[0]->resultable->k_m;
            // $hund['wesenstest_unerw_eigenschaften'] = $this->wesenstest[0]->resultable->unerw_eigenschaften;
            // $hund['wesenstest_bemerkung'] = $this->wesenstest[0]->resultable->bemerkung;
            // $hund['wesenstest_auflage'] = $this->wesenstest[0]->resultable->auflage;

        } else {
            $hund['wesenstest'] = false;
        }

        // PRUEFUNGEN
        $hund['pruefungstitel'] = PruefungenTitelResource::collection($this->pruefungentitel);
        $hund['pruefungenselect'] = OptionNameResource::collection($this->pruefungentitel);

        // BESITZER
        $hund['eigentuemer'] = AdresseKurzResource::collection($this->personen);

        // OCD

        // GENTEST
        if (count($this->gentests_total)) {

            $a_temp = [];
            if ($this->gentests_total[0]->pra_test_id) {
                $a_temp[] = 'PRA-Test: ' . $this->gentests_total[0]->pra_test;
            }
            if ($this->gentests_total[0]->pra_prcd_gentest_id) {
                $a_temp[] = 'prcd-PRA: ' . $this->gentests_total[0]->pra_prcd;
            }
            if ($this->gentests_total[0]->cnm_gentest_id) {
                $a_temp[] = 'CMN: ' . $this->gentests_total[0]->cnm;
            }
            if ($this->gentests_total[0]->eic_gentest_id) {
                $a_temp[] = 'EIC: ' . $this->gentests_total[0]->eic;
            }
            if ($this->gentests_total[0]->dm_gentest_id) {
                $a_temp[] = 'DM: ' . $this->gentests_total[0]->dm;
            }
            if ($this->gentests_total[0]->sd2_gentest_id) {
                $a_temp[] = 'SD2: ' . $this->gentests_total[0]->sd2;
            }
            if ($this->gentests_total[0]->narc_gentest_id) {
                $a_temp[] = 'Narc: ' . $this->gentests_total[0]->narc;
            }
            if ($this->gentests_total[0]->rd_osd_gentest_id) {
                $a_temp[] = 'RD/OSD: ' . $this->gentests_total[0]->rd_osd;
            }
            if ($this->gentests_total[0]->cea_ch_gentest_id) {
                $a_temp[] = 'CEA/CH: ' . $this->gentests_total[0]->cea_ch;
            }
            if ($this->gentests_total[0]->gr_pra1_gentest_id) {
                $a_temp[] = 'GR-PRA1: ' . $this->gentests_total[0]->gr_pra1;
            }
            if ($this->gentests_total[0]->gr_pra2_gentest_id) {
                $a_temp[] = 'GR-PRA2: ' . $this->gentests_total[0]->gr_pra2;
            }
            if ($this->gentests_total[0]->haarlaenge_id) {
                $a_temp[] = 'Haarlänge: ' . $this->gentests_total[0]->haarlaenge;
            }
            if ($this->gentests_total[0]->gsdiiia_gentest_id) {
                $a_temp[] = 'GSDIIIa: ' . $this->gentests_total[0]->gsdiiia;
            }
            if ($this->gentests_total[0]->grmd_gentest_id) {
                $a_temp[] = 'GRMD: ' . $this->gentests_total[0]->grmd;
            }
            if ($this->gentests_total[0]->ict_a_gentest_id) {
                $a_temp[] = 'ICT_A: ' . $this->gentests_total[0]->ict_a;
            }
            if ($this->gentests_total[0]->ed_sfs_gentest_id) {
                $a_temp[] = 'ED/SFS: ' . $this->gentests_total[0]->ed_sfs;
            }
            if ($this->gentests_total[0]->hnpk_gentest_id) {
                $a_temp[] = 'HNPK: ' . $this->gentests_total[0]->hnpk;
            }
            if ($this->gentests_total[0]->ncl5_gentest_id) {
                $a_temp[] = 'NCL5: ' . $this->gentests_total[0]->ncl5;
            }
            if ($this->gentests_total[0]->ncl_f_gentest_id) {
                $a_temp[] = 'NCL5: ' . $this->gentests_total[0]->ncl_f;
            }
            if ($this->gentests_total[0]->farbtest_gelb_id) {
                $a_temp[] = 'DNA-Farbtest Gelb: ' . $this->gentests_total[0]->farbtest_gelb;
            }
            if ($this->gentests_total[0]->farbtest_braun_id) {
                $a_temp[] = 'DNA-Farbtest Brau: ' . $this->gentests_total[0]->farbtest_braun;
            }
            if ($this->gentests_total[0]->farbverduennung_id) {
                $a_temp[] = 'Farbverdünnung: ' . $this->gentests_total[0]->farbverduennung;
            }
            if ($this->gentests_total[0]->den_gentest_id) {
                $a_temp[] = 'DEN: ' . $this->gentests_total[0]->den;
            }
            if ($this->gentests_total[0]->ict_2_gentest_id) {
                $a_temp[] = 'ICT_2: ' . $this->gentests_total[0]->ict_2;
            }
            if ($this->gentests_total[0]->jadd_gentest_id) {
                $a_temp[] = 'JADD: ' . $this->gentests_total[0]->jadd;
            }
            if ($this->gentests_total[0]->ivdd_gentest_id) {
                $a_temp[] = 'IVDD-Typ1: ' . $this->gentests_total[0]->ivdd;
            }
            if ($this->gentests_total[0]->cp1_gentest_id) {
                $a_temp[] = 'CP1: ' . $this->gentests_total[0]->cp1;
            }
            if ($this->gentests_total[0]->cps_gentest_id) {
                $a_temp[] = 'CPS: ' . $this->gentests_total[0]->cps;
            }
            if ($this->gentests_total[0]->clps_gentest_id) {
                $a_temp[] = 'CLPS: ' . $this->gentests_total[0]->clps;
            }
            if ($this->gentests_total[0]->cms_gentest_id) {
                $a_temp[] = 'CMS: ' . $this->gentests_total[0]->cms;
            }
            // if ( $this->gentests_total[0]->dann_farbtest_id ) $a_temp[] = 'DANN Farbtest: '.$this->gentests_total[0]->dann_farbtest;
            if ($this->gentests_total[0]->mh_gentest_id) {
                $a_temp[] = 'MH: ' . $this->gentests_total[0]->mh;
            }
            if ($this->gentests_total[0]->cddy_gentest_id) {
                $a_temp[] = 'CDDY: ' . $this->gentests_total[0]->cddy;
            }
            if ($this->gentests_total[0]->cdpa_gentest_id) {
                $a_temp[] = 'CDPA: ' . $this->gentests_total[0]->cdpa;
            }
            if ($this->gentests_total[0]->huu_gentest_id) {
                $a_temp[] = 'HUU: ' . $this->gentests_total[0]->huu;
            }
            if ($this->gentests_total[0]->deb_gentest_id) {
                $a_temp[] = 'DEB: ' . $this->gentests_total[0]->deb;
            }
            if ($this->gentests_total[0]->buff_gentest_id) {
                $a_temp[] = 'BUFF: ' . $this->gentests_total[0]->buff;
            }
            if ($this->gentests_total[0]->dil_gentest_id) {
                $a_temp[] = 'DIL: ' . $this->gentests_total[0]->dil;
            }
            if ($this->gentests_total[0]->md_gentest_id) {
                $a_temp[] = 'MD: ' . $this->gentests_total[0]->md;
            }
            if ($this->gentests_total[0]->mdr1_gentest_id) {
                $a_temp[] = 'MDR1: ' . $this->gentests_total[0]->mdr1;
            }
            if ($this->gentests_total[0]->cord1_pra_gentest_id) {
                $a_temp[] = 'CORD1_PRA: ' . $this->gentests_total[0]->cord1_pra;
            }
            if ($this->gentests_total[0]->glasknochen_gentest_id) {
                $a_temp[] = 'Glasknochen: ' . $this->gentests_total[0]->glasknochen;
            }
            if ($this->gentests_total[0]->stgd_gentest_id) {
                $a_temp[] = 'STGD: ' . $this->gentests_total[0]->stgd;
            }
            if ($this->gentests_total[0]->oi_gentest_id) {
                $a_temp[] = 'OI: ' . $this->gentests_total[0]->oi;
            }

            $hund['gentests'] = implode(', ', $a_temp);
            $hund['gentests_array'] = $a_temp;
            $hund['gentests_total'] = count($a_temp);
            // dna_profil, pra_test, pra_prcd, cnm, eic, dm, sd2, narc, rd_osd, cea_ch, gr_pra1, gr_pra2, haarlaenge, gsdiiia, grmd, ict_a, ed_sfs, hnpk    , ncl5, ncl_f, farbtest_gelb, farbtest_braun, farbverduennung, den, ict_2, jadd, ivdd, cp1, cps, clps, cms, dann_farbtest, mh, cddy, cdpa, huu, deb, buff, dil, md, mdr1, cord1_pra, glasknochen, stgd, oi, }
        }
        // IMAGES
        $hund['images'] = $this->images;

        // GESUNDHEIT

        // TITEL
        //$hund['titeltitel'] = TitelTitelResource::collection($this->titeltitel);

        $hund['titeltitel'] = [];
        // ZWINGER

        // ZUCHT

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
