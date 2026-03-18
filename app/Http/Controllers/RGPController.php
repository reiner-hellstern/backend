<?php

namespace App\Http\Controllers;

use App\Models\RGP_v1;
use App\Models\RGP_v2;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class RGPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_v1(Request $request)
    {

        if ($request->meldung_id) {
            $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($request->meldung_id);
        } else {
            return 'ERROR: ID-Meldung fehlt';
        }

        if (! $meldung) {
            return 'ERROR: Keine passende Meldung gefunden';
        }

        if ($meldung->resultable_id) {
            $ergebnis = RGP_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new RGP_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\RGP_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['waldarbeit_riemenarbeit']) {
                $ergebnis->waldarbeit_riemenarbeit_id = $results['waldarbeit_riemenarbeit']['id'];
            }
            if ($results['waldarbeit_totverbellen']) {
                $ergebnis->waldarbeit_totverbellen_id = $results['waldarbeit_totverbellen']['id'];
            }
            if ($results['waldarbeit_totverweisen']) {
                $ergebnis->waldarbeit_totverweisen_id = $results['waldarbeit_totverweisen']['id'];
            }
            if ($results['waldarbeit_schleppe_hasekanin']) {
                $ergebnis->waldarbeit_schleppe_hasekanin_id = $results['waldarbeit_schleppe_hasekanin']['id'];
            }
            if ($results['waldarbeit_suche_bringen_nutzwild']) {
                $ergebnis->waldarbeit_suche_bringen_nutzwild_id = $results['waldarbeit_suche_bringen_nutzwild']['id'];
            }
            if ($results['waldarbeit_bringen']) {
                $ergebnis->waldarbeit_bringen_id = $results['waldarbeit_bringen']['id'];
            }
            if ($results['waldarbeit_buschieren']) {
                $ergebnis->waldarbeit_buschieren_id = $results['waldarbeit_buschieren']['id'];
            }
            if ($results['waldarbeit_fuchsschleppe']) {
                $ergebnis->waldarbeit_fuchsschleppe_id = $results['waldarbeit_fuchsschleppe']['id'];
            }
            if ($results['waldarbeit_bringen_fuchsschleppe']) {
                $ergebnis->waldarbeit_bringen_fuchsschleppe_id = $results['waldarbeit_bringen_fuchsschleppe']['id'];
            }
            if ($results['waldarbeit_ergebnis']) {
                $ergebnis->waldarbeit_ergebnis = $results['waldarbeit_ergebnis'];
            }
            if ($results['wasserarbeit_stoebern_ohne_ente']) {
                $ergebnis->wasserarbeit_stoebern_ohne_ente_id = $results['wasserarbeit_stoebern_ohne_ente']['id'];
            }
            if ($results['wasserarbeit_verlorensuche']) {
                $ergebnis->wasserarbeit_verlorensuche_id = $results['wasserarbeit_verlorensuche']['id'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_id = $results['wasserarbeit_stoebern_mit_ente']['id'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_upload']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_upload = $results['wasserarbeit_stoebern_mit_ente_zeugnis_upload'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_kommentar']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_kommentar = $results['wasserarbeit_stoebern_mit_ente_zeugnis_kommentar'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis = $results['wasserarbeit_stoebern_mit_ente_zeugnis'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_bewertung']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_id = $results['wasserarbeit_stoebern_mit_ente_zeugnis_bewertung']['id'];
            }
            if ($results['wasserarbeit_markieren']) {
                $ergebnis->wasserarbeit_markieren_id = $results['wasserarbeit_markieren']['id'];
            }
            if ($results['wasserarbeit_bringen_ente']) {
                $ergebnis->wasserarbeit_bringen_ente_id = $results['wasserarbeit_bringen_ente']['id'];
            }
            if ($results['wasserarbeit_ergebnis']) {
                $ergebnis->wasserarbeit_ergebnis = $results['wasserarbeit_ergebnis'];
            }
            if ($results['feldarbeit_federwildschleppe']) {
                $ergebnis->feldarbeit_federwildschleppe_id = $results['feldarbeit_federwildschleppe']['id'];
            }
            if ($results['feldarbeit_einweisen']) {
                $ergebnis->feldarbeit_einweisen_id = $results['feldarbeit_einweisen']['id'];
            }
            if ($results['feldarbeit_merken']) {
                $ergebnis->feldarbeit_merken_id = $results['feldarbeit_merken']['id'];
            }
            if ($results['feldarbeit_standruhe']) {
                $ergebnis->feldarbeit_standruhe_id = $results['feldarbeit_standruhe']['id'];
            }
            if ($results['feldarbeit_bringen_federwild']) {
                $ergebnis->feldarbeit_bringen_federwild_id = $results['feldarbeit_bringen_federwild']['id'];
            }
            if ($results['feldarbeit_ergebnis']) {
                $ergebnis->feldarbeit_ergebnis = $results['feldarbeit_ergebnis'];
            }
            if ($results['gehorsam_allgemein']) {
                $ergebnis->gehorsam_allgemein_id = $results['gehorsam_allgemein']['id'];
            }
            if ($results['gehorsam_stand']) {
                $ergebnis->gehorsam_stand_id = $results['gehorsam_stand']['id'];
            }
            if ($results['gehorsam_leinenfuehrigkeit']) {
                $ergebnis->gehorsam_leinenfuehrigkeit_id = $results['gehorsam_leinenfuehrigkeit']['id'];
            }
            if ($results['gehorsam_folgen']) {
                $ergebnis->gehorsam_folgen_id = $results['gehorsam_folgen']['id'];
            }
            if ($results['gehorsam_ablegen']) {
                $ergebnis->gehorsam_ablegen_id = $results['gehorsam_ablegen']['id'];
            }
            if ($results['gehorsam_ergebnis']) {
                $ergebnis->gehorsam_ergebnis = $results['gehorsam_ergebnis'];
            }
            if ($results['arbeitsfreude']) {
                $ergebnis->arbeitsfreude_id = $results['arbeitsfreude']['id'];
            }
            if ($results['arbeitsfreude_ergebnis']) {
                $ergebnis->arbeitsfreude_ergebnis = $results['arbeitsfreude_ergebnis'];
            }
            if ($results['gesamtpunktzahl']) {
                $ergebnis->gesamtpunktzahl = $results['gesamtpunktzahl'];
            }
            if ($results['teilnahmslos_phlegmatisch']) {
                $ergebnis->teilnahmslos_phlegmatisch = $results['teilnahmslos_phlegmatisch'];
            }
            if ($results['ruhig_ausgeglichen']) {
                $ergebnis->ruhig_ausgeglichen = $results['ruhig_ausgeglichen'];
            }
            if ($results['schussscheu']) {
                $ergebnis->schussscheu = $results['schussscheu'];
            }
            if ($results['unruhig']) {
                $ergebnis->unruhig = $results['unruhig'];
            }
            if ($results['selbstsicher']) {
                $ergebnis->selbstsicher = $results['selbstsicher'];
            }
            if ($results['schreckhaft_unsicher']) {
                $ergebnis->schreckhaft_unsicher = $results['schreckhaft_unsicher'];
            }
            if ($results['aengstlich']) {
                $ergebnis->aengstlich = $results['aengstlich'];
            }
            if ($results['sozialvertraeglich']) {
                $ergebnis->sozialvertraeglich = $results['sozialvertraeglich'];
            }
            if ($results['aggressiv_menschen']) {
                $ergebnis->aggressiv_menschen = $results['aggressiv_menschen'];
            }
            if ($results['aggressiv_artgenossen']) {
                $ergebnis->aggressiv_artgenossen = $results['aggressiv_artgenossen'];
            }
            if ($results['schussfestigkeit_land']) {
                $ergebnis->schussfestigkeit_land_id = $results['schussfestigkeit_land']['id'];
            }
            if ($results['schussfestigkeit_wasser']) {
                $ergebnis->schussfestigkeit_wasser_id = $results['schussfestigkeit_wasser']['id'];
            }
            if ($results['sonstige_wesenverhalten']) {
                $ergebnis->sonstige_wesenverhalten = $results['sonstige_wesenverhalten'];
            }
            if ($results['begruendung_hervorragend']) {
                $ergebnis->begruendung_hervorragend = $results['begruendung_hervorragend'];
            }
            if ($results['gebissfehler']) {
                $ergebnis->gebissfehler = $results['gebissfehler'];
            }
            if ($results['hodenfehler']) {
                $ergebnis->hodenfehler = $results['hodenfehler'];
            }
            if ($results['augenfehler']) {
                $ergebnis->augenfehler = $results['augenfehler'];
            }
            if ($results['preis']) {
                $ergebnis->preis_id = $results['preis']['id'];
            }
            if ($results['bemerkung']) {
                $ergebnis->bemerkung = $results['bemerkung'];
            }
            if ($results['bestanden']) {
                $ergebnis->bestanden = $results['bestanden'];
            }
            if ($results['mit_fuchs']) {
                $ergebnis->mit_fuchs = $results['mit_fuchs'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund = $results['ausschlussgrund'];
            }
            // if ( $results['pruefungsleiter'] ) $ergebnis->pruefungsleiter_id = $results['pruefungsleiter']['id'];
            // if ( $results['richterobmann'] ) $ergebnis->richterobmann_id = $results['richterobmann']['id'];
            // if ( $results['richter1'] ) $ergebnis->richter1_id = $results['richter1']['id'];
            // if ( $results['richter2'] ) $ergebnis->richter2_id = $results['richter2']['id'];
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_v2(Request $request)
    {

        if ($request->meldung_id) {
            $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($request->meldung_id);
        } else {
            return 'ERROR: ID-Meldung fehlt';
        }

        if (! $meldung) {
            return 'ERROR: Keine passende Meldung gefunden';
        }

        if ($meldung->resultable_id) {
            $ergebnis = RGP_v2::find($meldung->resultable_id);
        } else {
            $ergebnis = new RGP_v2();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\RGP_v2';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['waldarbeit_riemenarbeit']) {
                $ergebnis->waldarbeit_riemenarbeit_id = $results['waldarbeit_riemenarbeit']['id'];
            }
            if ($results['waldarbeit_totverbellen']) {
                $ergebnis->waldarbeit_totverbellen_id = $results['waldarbeit_totverbellen']['id'];
            }
            if ($results['waldarbeit_totverweisen']) {
                $ergebnis->waldarbeit_totverweisen_id = $results['waldarbeit_totverweisen']['id'];
            }
            if ($results['waldarbeit_schleppe_hasekanin']) {
                $ergebnis->waldarbeit_schleppe_hasekanin_id = $results['waldarbeit_schleppe_hasekanin']['id'];
            }
            if ($results['waldarbeit_suche_bringen_nutzwild']) {
                $ergebnis->waldarbeit_suche_bringen_nutzwild_id = $results['waldarbeit_suche_bringen_nutzwild']['id'];
            }
            if ($results['waldarbeit_bringen']) {
                $ergebnis->waldarbeit_bringen_id = $results['waldarbeit_bringen']['id'];
            }
            if ($results['waldarbeit_buschieren']) {
                $ergebnis->waldarbeit_buschieren_id = $results['waldarbeit_buschieren']['id'];
            }
            if ($results['waldarbeit_fuchsschleppe']) {
                $ergebnis->waldarbeit_fuchsschleppe_id = $results['waldarbeit_fuchsschleppe']['id'];
            }
            if ($results['waldarbeit_bringen_fuchsschleppe']) {
                $ergebnis->waldarbeit_bringen_fuchsschleppe_id = $results['waldarbeit_bringen_fuchsschleppe']['id'];
            }
            if ($results['waldarbeit_ergebnis']) {
                $ergebnis->waldarbeit_ergebnis = $results['waldarbeit_ergebnis'];
            }
            if ($results['wasserarbeit_stoebern_ohne_ente']) {
                $ergebnis->wasserarbeit_stoebern_ohne_ente_id = $results['wasserarbeit_stoebern_ohne_ente']['id'];
            }
            if ($results['wasserarbeit_verlorensuche']) {
                $ergebnis->wasserarbeit_verlorensuche_id = $results['wasserarbeit_verlorensuche']['id'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_id = $results['wasserarbeit_stoebern_mit_ente']['id'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_upload']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_upload = $results['wasserarbeit_stoebern_mit_ente_zeugnis_upload'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_kommentar']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_kommentar = $results['wasserarbeit_stoebern_mit_ente_zeugnis_kommentar'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis = $results['wasserarbeit_stoebern_mit_ente_zeugnis'];
            }
            if ($results['wasserarbeit_stoebern_mit_ente_zeugnis_bewertung']) {
                $ergebnis->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_id = $results['wasserarbeit_stoebern_mit_ente_zeugnis_bewertung']['id'];
            }
            if ($results['wasserarbeit_einweisen']) {
                $ergebnis->wasserarbeit_einweisen_id = $results['wasserarbeit_einweisen']['id'];
            }
            if ($results['wasserarbeit_bringen_ente']) {
                $ergebnis->wasserarbeit_bringen_ente_id = $results['wasserarbeit_bringen_ente']['id'];
            }
            if ($results['wasserarbeit_ergebnis']) {
                $ergebnis->wasserarbeit_ergebnis = $results['wasserarbeit_ergebnis'];
            }
            if ($results['feldarbeit_federwildschleppe']) {
                $ergebnis->feldarbeit_federwildschleppe_id = $results['feldarbeit_federwildschleppe']['id'];
            }
            if ($results['feldarbeit_einweisen']) {
                $ergebnis->feldarbeit_einweisen_id = $results['feldarbeit_einweisen']['id'];
            }
            if ($results['feldarbeit_merken']) {
                $ergebnis->feldarbeit_merken_id = $results['feldarbeit_merken']['id'];
            }
            if ($results['feldarbeit_standruhe']) {
                $ergebnis->feldarbeit_standruhe_id = $results['feldarbeit_standruhe']['id'];
            }
            if ($results['feldarbeit_bringen_federwild']) {
                $ergebnis->feldarbeit_bringen_federwild_id = $results['feldarbeit_bringen_federwild']['id'];
            }
            if ($results['feldarbeit_ergebnis']) {
                $ergebnis->feldarbeit_ergebnis = $results['feldarbeit_ergebnis'];
            }
            if ($results['gehorsam_allgemein']) {
                $ergebnis->gehorsam_allgemein_id = $results['gehorsam_allgemein']['id'];
            }
            if ($results['gehorsam_stand']) {
                $ergebnis->gehorsam_stand_id = $results['gehorsam_stand']['id'];
            }
            if ($results['gehorsam_leinenfuehrigkeit']) {
                $ergebnis->gehorsam_leinenfuehrigkeit_id = $results['gehorsam_leinenfuehrigkeit']['id'];
            }
            if ($results['gehorsam_folgen']) {
                $ergebnis->gehorsam_folgen_id = $results['gehorsam_folgen']['id'];
            }
            if ($results['gehorsam_ablegen']) {
                $ergebnis->gehorsam_ablegen_id = $results['gehorsam_ablegen']['id'];
            }
            if ($results['gehorsam_ergebnis']) {
                $ergebnis->gehorsam_ergebnis_id = $results['gehorsam_ergebnis']['id'];
            }
            if ($results['arbeitsfreude']) {
                $ergebnis->arbeitsfreude_id = $results['arbeitsfreude']['id'];
            }
            if ($results['arbeitsfreude_ergebnis']) {
                $ergebnis->arbeitsfreude_ergebnis = $results['arbeitsfreude_ergebnis'];
            }
            if ($results['gesamtpunktzahl']) {
                $ergebnis->gesamtpunktzahl = $results['gesamtpunktzahl'];
            }
            if ($results['teilnahmslos_phlegmatisch']) {
                $ergebnis->teilnahmslos_phlegmatisch = $results['teilnahmslos_phlegmatisch'];
            }
            if ($results['ruhig_ausgeglichen']) {
                $ergebnis->ruhig_ausgeglichen = $results['ruhig_ausgeglichen'];
            }
            if ($results['schussscheu']) {
                $ergebnis->schussscheu = $results['schussscheu'];
            }
            if ($results['unruhig']) {
                $ergebnis->unruhig = $results['unruhig'];
            }
            if ($results['selbstsicher']) {
                $ergebnis->selbstsicher = $results['selbstsicher'];
            }
            if ($results['schreckhaft_unsicher']) {
                $ergebnis->schreckhaft_unsicher = $results['schreckhaft_unsicher'];
            }
            if ($results['aengstlich']) {
                $ergebnis->aengstlich = $results['aengstlich'];
            }
            if ($results['sozialvertraeglich']) {
                $ergebnis->sozialvertraeglich = $results['sozialvertraeglich'];
            }
            if ($results['aggressiv_menschen']) {
                $ergebnis->aggressiv_menschen = $results['aggressiv_menschen'];
            }
            if ($results['aggressiv_artgenossen']) {
                $ergebnis->aggressiv_artgenossen = $results['aggressiv_artgenossen'];
            }
            if ($results['schussfestigkeit_land']) {
                $ergebnis->schussfestigkeit_land_id = $results['schussfestigkeit_land']['id'];
            }
            if ($results['schussfestigkeit_wasser']) {
                $ergebnis->schussfestigkeit_wasser_id = $results['schussfestigkeit_wasser']['id'];
            }
            if ($results['sonstige_wesenverhalten']) {
                $ergebnis->sonstige_wesenverhalten = $results['sonstige_wesenverhalten'];
            }
            if ($results['begruendung_hervorragend']) {
                $ergebnis->begruendung_hervorragend = $results['begruendung_hervorragend'];
            }
            if ($results['gebissfehler']) {
                $ergebnis->gebissfehler = $results['gebissfehler'];
            }
            if ($results['hodenfehler']) {
                $ergebnis->hodenfehler = $results['hodenfehler'];
            }
            if ($results['augenfehler']) {
                $ergebnis->augenfehler = $results['augenfehler'];
            }
            if ($results['preis']) {
                $ergebnis->preis_id = $results['preis']['id'];
            }
            if ($results['bemerkung']) {
                $ergebnis->bemerkung = $results['bemerkung'];
            }
            if ($results['bestanden']) {
                $ergebnis->bestanden = $results['bestanden'];
            }
            if ($results['mit_fuchs']) {
                $ergebnis->mit_fuchs = $results['mit_fuchs'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund = $results['ausschlussgrund'];
            }
            // if ( $results['pruefungsleiter'] ) $ergebnis->pruefungsleiter_id = $results['pruefungsleiter']['id'];
            // if ( $results['richterobmann'] ) $ergebnis->richterobmann_id = $results['richterobmann']['id'];
            // if ( $results['richter1'] ) $ergebnis->richter1_id = $results['richter1']['id'];
            // if ( $results['richter2'] ) $ergebnis->richter2_id = $results['richter2']['id'];
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(RGP_v1 $rGP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RGP_v1 $rGP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(RGP_v1 $rGP)
    {
        //
    }
}
