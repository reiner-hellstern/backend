<?php

namespace App\Http\Controllers;

use App\Models\VeranstaltungMeldung;
use App\Models\Wesenstest_v1;
use App\Models\Wesenstest_v2;
use Illuminate\Http\Request;

class WesenstestController extends Controller
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
            $ergebnis = Wesenstest_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new Wesenstest_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\Wesenstest_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['bezugsperson']) {
                $ergebnis->bezugsperson = $results['bezugsperson'];
            }
            if ($results['eigentuemerwechsel']) {
                $ergebnis->eigentuemerwechsel = $results['eigentuemerwechsel'];
            }
            if ($results['haltung_zwinger']) {
                $ergebnis->haltung_zwinger = $results['haltung_zwinger'];
            }
            if ($results['haltung_haus']) {
                $ergebnis->haltung_haus = $results['haltung_haus'];
            }
            if ($results['verfassung_chronische_erkrankungen']) {
                $ergebnis->verfassung_chronische_erkrankungen = $results['verfassung_chronische_erkrankungen'];
            }
            if ($results['verfassung_chronische_erkrankungen_angaben']) {
                $ergebnis->verfassung_chronische_erkrankungen_angaben = $results['verfassung_chronische_erkrankungen_angaben'];
            }
            if ($results['verfassung_unfaelle']) {
                $ergebnis->verfassung_unfaelle = $results['verfassung_unfaelle'];
            }
            if ($results['verfassung_medikamente']) {
                $ergebnis->verfassung_medikamente = $results['verfassung_medikamente'];
            }
            if ($results['verfassung_medikamente_angaben']) {
                $ergebnis->verfassung_medikamente_angaben = $results['verfassung_medikamente_angaben'];
            }
            if ($results['verfassung_kastration_chemisch']) {
                $ergebnis->verfassung_kastration_chemisch = $results['verfassung_kastration_chemisch'];
            }
            if ($results['verfassung_kastration_chirurgisch']) {
                $ergebnis->verfassung_kastration_chirurgisch = $results['verfassung_kastration_chirurgisch'];
            }
            if ($results['verfassung_futtermittelallergie']) {
                $ergebnis->verfassung_futtermittelallergie = $results['verfassung_futtermittelallergie'];
            }
            if ($results['ausbildung_des_hundes']) {
                $ergebnis->ausbildung_des_hundes = $results['ausbildung_des_hundes'];
            }
            if ($results['welpengruppe']) {
                $ergebnis->welpengruppe = $results['welpengruppe'];
            }
            // pruefungen
            if ($results['pruefungen_weitere']) {
                $ergebnis->pruefungen_weitere = $results['pruefungen_weitere'];
            }
            if ($results['einsatz_arbeit_sport']) {
                $ergebnis->einsatz_arbeit_sport = $results['einsatz_arbeit_sport'];
            }
            if ($results['einsatz_breitensport']) {
                $ergebnis->einsatz_breitensport = $results['einsatz_breitensport'];
            }
            if ($results['einsatz_dummyarbeit']) {
                $ergebnis->einsatz_dummyarbeit = $results['einsatz_dummyarbeit'];
            }
            if ($results['einsatz_jagd']) {
                $ergebnis->einsatz_jagd = $results['einsatz_jagd'];
            }
            if ($results['einsatz_rettungshund']) {
                $ergebnis->einsatz_rettungshund = $results['einsatz_rettungshund'];
            }
            if ($results['einsatz_andere']) {
                $ergebnis->einsatz_andere = $results['einsatz_andere'];
            }
            if ($results['umwelterfahrungen']) {
                $ergebnis->umwelterfahrungen = $results['umwelterfahrungen'];
            }
            if ($results['tiefgreifende_erlebnisse']) {
                $ergebnis->tiefgreifende_erlebnisse = $results['tiefgreifende_erlebnisse'];
            }
            if ($results['rufname']) {
                $ergebnis->rufname = $results['rufname'];
            }
            if ($results['befragung_kontakt_sozialverhalten']) {
                $ergebnis->befragung_kontakt_sozialverhalten = $results['befragung_kontakt_sozialverhalten'];
            }
            if ($results['befragung_kontakt_beschwichtigungsverhalten']) {
                $ergebnis->befragung_kontakt_beschwichtigungsverhalten = $results['befragung_kontakt_beschwichtigungsverhalten'];
            }
            if ($results['befragung_kontakt_aggressionsverhalten']) {
                $ergebnis->befragung_kontakt_aggressionsverhalten = $results['befragung_kontakt_aggressionsverhalten'];
            }
            if ($results['befragung_kontakt_aggressionsverhalten_identifizierung']) {
                $ergebnis->befragung_kontakt_aggressionsverhalten_identifizierung = $results['befragung_kontakt_aggressionsverhalten_identifizierung'];
            }
            if ($results['spaziergang_hundefuehrer_aktivitaet']) {
                $ergebnis->spaziergang_hundefuehrer_aktivitaet = $results['spaziergang_hundefuehrer_aktivitaet'];
            }
            if ($results['spaziergang_menschengruppe_sozialverhalten']) {
                $ergebnis->spaziergang_menschengruppe_sozialverhalten = $results['spaziergang_menschengruppe_sozialverhalten'];
            }
            if ($results['spaziergang_menschengruppe_beschwichtigungsverhalten']) {
                $ergebnis->spaziergang_menschengruppe_beschwichtigungsverhalten = $results['spaziergang_menschengruppe_beschwichtigungsverhalten'];
            }
            if ($results['spaziergang_menschengruppe_aggressionsverhalten']) {
                $ergebnis->spaziergang_menschengruppe_aggressionsverhalten = $results['spaziergang_menschengruppe_aggressionsverhalten'];
            }
            if ($results['beruehrung_sozialverhalten_1']) {
                $ergebnis->beruehrung_sozialverhalten_1 = $results['beruehrung_sozialverhalten_1'];
            }
            if ($results['beruehrung_sozialverhalten_1_bewertung']) {
                $ergebnis->beruehrung_sozialverhalten_1_bewertung = $results['beruehrung_sozialverhalten_1_bewertung'];
            }
            if ($results['beruehrung_sozialverhalten_2']) {
                $ergebnis->beruehrung_sozialverhalten_2 = $results['beruehrung_sozialverhalten_2'];
            }
            if ($results['beruehrung_sozialverhalten_2_bewertung']) {
                $ergebnis->beruehrung_sozialverhalten_2_bewertung = $results['beruehrung_sozialverhalten_2_bewertung'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_1']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_1 = $results['beruehrung_beschwichtigungsverhalten_1'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_1_bewertung']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_1_bewertung = $results['beruehrung_beschwichtigungsverhalten_1_bewertung'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_2']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_2 = $results['beruehrung_beschwichtigungsverhalten_2'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_2_bewertung']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_2_bewertung = $results['beruehrung_beschwichtigungsverhalten_2_bewertung'];
            }
            if ($results['beruehrung_aggressionsverhalten_1']) {
                $ergebnis->beruehrung_aggressionsverhalten_1 = $results['beruehrung_aggressionsverhalten_1'];
            }
            if ($results['beruehrung_aggressionsverhalten_1_bewertung']) {
                $ergebnis->beruehrung_aggressionsverhalten_1_bewertung = $results['beruehrung_aggressionsverhalten_1_bewertung'];
            }
            if ($results['beruehrung_aggressionsverhalten_2']) {
                $ergebnis->beruehrung_aggressionsverhalten_2 = $results['beruehrung_aggressionsverhalten_2'];
            }
            if ($results['beruehrung_aggressionsverhalten_2_bewertung']) {
                $ergebnis->beruehrung_aggressionsverhalten_2_bewertung = $results['beruehrung_aggressionsverhalten_2_bewertung'];
            }
            if ($results['spiel_spielverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_spielverhalten_ohne_gegenstand = $results['spiel_spielverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_spielverhalten_mit_gegenstand']) {
                $ergebnis->spiel_spielverhalten_mit_gegenstand = $results['spiel_spielverhalten_mit_gegenstand'];
            }
            if ($results['spiel_beuteverhalten_mit_gegenstand']) {
                $ergebnis->spiel_beuteverhalten_mit_gegenstand = $results['spiel_beuteverhalten_mit_gegenstand'];
            }
            if ($results['spiel_beuteverhalten_werfen_des_gegenstandes_1']) {
                $ergebnis->spiel_beuteverhalten_werfen_des_gegenstandes_1 = $results['spiel_beuteverhalten_werfen_des_gegenstandes_1'];
            }
            if ($results['spiel_beuteverhalten_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_beuteverhalten_werfen_des_gegenstandes_2 = $results['spiel_beuteverhalten_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_tragenzutragen_werfen_des_gegenstandes_1']) {
                $ergebnis->spiel_tragenzutragen_werfen_des_gegenstandes_1 = $results['spiel_tragenzutragen_werfen_des_gegenstandes_1'];
            }
            if ($results['spiel_tragenzutragen_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_tragenzutragen_werfen_des_gegenstandes_2 = $results['spiel_tragenzutragen_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_suchverhalten_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_suchverhalten_werfen_des_gegenstandes_2 = $results['spiel_suchverhalten_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_beschwichtigungsverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_beschwichtigungsverhalten_ohne_gegenstand = $results['spiel_beschwichtigungsverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_aggressionsverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_aggressionsverhalten_ohne_gegenstand = $results['spiel_aggressionsverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_aggressionsverhalten_mit_gegenstand']) {
                $ergebnis->spiel_aggressionsverhalten_mit_gegenstand = $results['spiel_aggressionsverhalten_mit_gegenstand'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_1 = $results['parcours_schreckhaftigkeit_haptisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_1 = $results['parcours_schreckhaftigkeit_akustisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_1 = $results['parcours_schreckhaftigkeit_optisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_2 = $results['parcours_schreckhaftigkeit_haptisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_2 = $results['parcours_schreckhaftigkeit_akustisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_2 = $results['parcours_schreckhaftigkeit_optisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_3 = $results['parcours_schreckhaftigkeit_haptisch_3'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_3 = $results['parcours_schreckhaftigkeit_akustisch_3'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_3 = $results['parcours_schreckhaftigkeit_optisch_3'];
            }
            if ($results['parcours_beschwichtigung_haptisch_1']) {
                $ergebnis->parcours_beschwichtigung_haptisch_1 = $results['parcours_beschwichtigung_haptisch_1'];
            }
            if ($results['parcours_beschwichtigung_akustisch_1']) {
                $ergebnis->parcours_beschwichtigung_akustisch_1 = $results['parcours_beschwichtigung_akustisch_1'];
            }
            if ($results['parcours_beschwichtigung_optisch_1']) {
                $ergebnis->parcours_beschwichtigung_optisch_1 = $results['parcours_beschwichtigung_optisch_1'];
            }
            if ($results['parcours_beschwichtigung_haptisch_2']) {
                $ergebnis->parcours_beschwichtigung_haptisch_2 = $results['parcours_beschwichtigung_haptisch_2'];
            }
            if ($results['parcours_beschwichtigung_akustisch_2']) {
                $ergebnis->parcours_beschwichtigung_akustisch_2 = $results['parcours_beschwichtigung_akustisch_2'];
            }
            if ($results['parcours_beschwichtigung_optisch_2']) {
                $ergebnis->parcours_beschwichtigung_optisch_2 = $results['parcours_beschwichtigung_optisch_2'];
            }
            if ($results['parcours_beschwichtigung_haptisch_3']) {
                $ergebnis->parcours_beschwichtigung_haptisch_3 = $results['parcours_beschwichtigung_haptisch_3'];
            }
            if ($results['parcours_beschwichtigung_akustisch_3']) {
                $ergebnis->parcours_beschwichtigung_akustisch_3 = $results['parcours_beschwichtigung_akustisch_3'];
            }
            if ($results['parcours_beschwichtigung_optisch_3']) {
                $ergebnis->parcours_beschwichtigung_optisch_3 = $results['parcours_beschwichtigung_optisch_3'];
            }
            if ($results['parcours_neugierverhalten_haptisch_1']) {
                $ergebnis->parcours_neugierverhalten_haptisch_1 = $results['parcours_neugierverhalten_haptisch_1'];
            }
            if ($results['parcours_neugierverhalten_akustisch_1']) {
                $ergebnis->parcours_neugierverhalten_akustisch_1 = $results['parcours_neugierverhalten_akustisch_1'];
            }
            if ($results['parcours_neugierverhalten_optisch_1']) {
                $ergebnis->parcours_neugierverhalten_optisch_1 = $results['parcours_neugierverhalten_optisch_1'];
            }
            if ($results['parcours_neugierverhalten_haptisch_2']) {
                $ergebnis->parcours_neugierverhalten_haptisch_2 = $results['parcours_neugierverhalten_haptisch_2'];
            }
            if ($results['parcours_neugierverhalten_akustisch_2']) {
                $ergebnis->parcours_neugierverhalten_akustisch_2 = $results['parcours_neugierverhalten_akustisch_2'];
            }
            if ($results['parcours_neugierverhalten_optisch_2']) {
                $ergebnis->parcours_neugierverhalten_optisch_2 = $results['parcours_neugierverhalten_optisch_2'];
            }
            if ($results['parcours_neugierverhalten_haptisch_3']) {
                $ergebnis->parcours_neugierverhalten_haptisch_3 = $results['parcours_neugierverhalten_haptisch_3'];
            }
            if ($results['parcours_neugierverhalten_akustisch_3']) {
                $ergebnis->parcours_neugierverhalten_akustisch_3 = $results['parcours_neugierverhalten_akustisch_3'];
            }
            if ($results['parcours_neugierverhalten_optisch_3']) {
                $ergebnis->parcours_neugierverhalten_optisch_3 = $results['parcours_neugierverhalten_optisch_3'];
            }
            if ($results['parcours_aktivitaet']) {
                $ergebnis->parcours_aktivitaet = $results['parcours_aktivitaet'];
            }
            if ($results['schuss_schreckhaftigkeit_100m']) {
                $ergebnis->schuss_schreckhaftigkeit_100m = $results['schuss_schreckhaftigkeit_100m'];
            }
            if ($results['schuss_schreckhaftigkeit_50m']) {
                $ergebnis->schuss_schreckhaftigkeit_50m = $results['schuss_schreckhaftigkeit_50m'];
            }
            if ($results['schuss_schreckhaftigkeit_20m']) {
                $ergebnis->schuss_schreckhaftigkeit_20m = $results['schuss_schreckhaftigkeit_20m'];
            }
            if ($results['schuss_beschwichtigung_100m']) {
                $ergebnis->schuss_beschwichtigung_100m = $results['schuss_beschwichtigung_100m'];
            }
            if ($results['schuss_beschwichtigung_50m']) {
                $ergebnis->schuss_beschwichtigung_50m = $results['schuss_beschwichtigung_50m'];
            }
            if ($results['schuss_beschwichtigung_20m']) {
                $ergebnis->schuss_beschwichtigung_20m = $results['schuss_beschwichtigung_20m'];
            }
            if ($results['bemerkungen']) {
                $ergebnis->bemerkungen = $results['bemerkungen'];
            }
            if ($results['bestanden']) {
                $ergebnis->bestanden = $results['bestanden'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund = $results['ausschlussgrund'];
            }
            if ($results['zurueckgestellt']) {
                $ergebnis->zurueckgestellt = $results['zurueckgestellt'];
            }
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
            $ergebnis = Wesenstest_v2::find($meldung->resultable_id);
        } else {
            $ergebnis = new Wesenstest_v2();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\Wesenstest_v2';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['bezugsperson']) {
                $ergebnis->bezugsperson = $results['bezugsperson'];
            }
            if ($results['eigentuemerwechsel']) {
                $ergebnis->eigentuemerwechsel = $results['eigentuemerwechsel'];
            }
            if ($results['haltung_zwinger']) {
                $ergebnis->haltung_zwinger = $results['haltung_zwinger'];
            }
            if ($results['haltung_haus']) {
                $ergebnis->haltung_haus = $results['haltung_haus'];
            }
            if ($results['verfassung_chronische_erkrankungen']) {
                $ergebnis->verfassung_chronische_erkrankungen = $results['verfassung_chronische_erkrankungen'];
            }
            if ($results['verfassung_chronische_erkrankungen_angaben']) {
                $ergebnis->verfassung_chronische_erkrankungen_angaben = $results['verfassung_chronische_erkrankungen_angaben'];
            }
            if ($results['verfassung_unfaelle']) {
                $ergebnis->verfassung_unfaelle = $results['verfassung_unfaelle'];
            }
            if ($results['verfassung_medikamente']) {
                $ergebnis->verfassung_medikamente = $results['verfassung_medikamente'];
            }
            if ($results['verfassung_medikamente_angaben']) {
                $ergebnis->verfassung_medikamente_angaben = $results['verfassung_medikamente_angaben'];
            }
            if ($results['verfassung_kastration_chemisch']) {
                $ergebnis->verfassung_kastration_chemisch = $results['verfassung_kastration_chemisch'];
            }
            if ($results['verfassung_kastration_chirurgisch']) {
                $ergebnis->verfassung_kastration_chirurgisch = $results['verfassung_kastration_chirurgisch'];
            }
            if ($results['verfassung_futtermittelallergie']) {
                $ergebnis->verfassung_futtermittelallergie = $results['verfassung_futtermittelallergie'];
            }
            if ($results['ausbildung_des_hundes']) {
                $ergebnis->ausbildung_des_hundes = $results['ausbildung_des_hundes'];
            }
            if ($results['welpengruppe']) {
                $ergebnis->welpengruppe = $results['welpengruppe'];
            }
            // pruefungen
            if ($results['pruefungen_weitere']) {
                $ergebnis->pruefungen_weitere = $results['pruefungen_weitere'];
            }
            if ($results['einsatz_arbeit_sport']) {
                $ergebnis->einsatz_arbeit_sport = $results['einsatz_arbeit_sport'];
            }
            if ($results['einsatz_breitensport']) {
                $ergebnis->einsatz_breitensport = $results['einsatz_breitensport'];
            }
            if ($results['einsatz_dummyarbeit']) {
                $ergebnis->einsatz_dummyarbeit = $results['einsatz_dummyarbeit'];
            }
            if ($results['einsatz_jagd']) {
                $ergebnis->einsatz_jagd = $results['einsatz_jagd'];
            }
            if ($results['einsatz_rettungshund']) {
                $ergebnis->einsatz_rettungshund = $results['einsatz_rettungshund'];
            }
            if ($results['einsatz_andere']) {
                $ergebnis->einsatz_andere = $results['einsatz_andere'];
            }
            if ($results['umwelterfahrungen']) {
                $ergebnis->umwelterfahrungen = $results['umwelterfahrungen'];
            }
            if ($results['tiefgreifende_erlebnisse']) {
                $ergebnis->tiefgreifende_erlebnisse = $results['tiefgreifende_erlebnisse'];
            }
            if ($results['rufname']) {
                $ergebnis->rufname = $results['rufname'];
            }
            if ($results['befragung_kontakt_sozialverhalten']) {
                $ergebnis->befragung_kontakt_sozialverhalten_id = $results['befragung_kontakt_sozialverhalten'];
            }
            if ($results['befragung_kontakt_beschwichtigungsverhalten']) {
                $ergebnis->befragung_kontakt_beschwichtigungsverhalten = $results['befragung_kontakt_beschwichtigungsverhalten'];
            }
            if ($results['befragung_kontakt_aggressionsverhalten']) {
                $ergebnis->befragung_kontakt_aggressionsverhalten = $results['befragung_kontakt_aggressionsverhalten'];
            }
            if ($results['befragung_kontakt_aggressionsverhalten_identifizierung']) {
                $ergebnis->befragung_kontakt_aggressionsverhalten_identifizierung = $results['befragung_kontakt_aggressionsverhalten_identifizierung'];
            }
            if ($results['spaziergang_hundefuehrer_aktivitaet']) {
                $ergebnis->spaziergang_hundefuehrer_aktivitaet = $results['spaziergang_hundefuehrer_aktivitaet'];
            }
            if ($results['menschengruppe_sozialverhalten']) {
                $ergebnis->menschengruppe_sozialverhalten = $results['menschengruppe_sozialverhalten'];
            }
            if ($results['menschengruppe_beschwichtigungsverhalten']) {
                $ergebnis->menschengruppe_beschwichtigungsverhalten = $results['menschengruppe_beschwichtigungsverhalten'];
            }
            if ($results['menschengruppe_aggressionsverhalten']) {
                $ergebnis->menschengruppe_aggressionsverhalten = $results['menschengruppe_aggressionsverhalten'];
            }
            if ($results['beruehrung_sozialverhalten_1']) {
                $ergebnis->beruehrung_sozialverhalten_1 = $results['beruehrung_sozialverhalten_1'];
            }
            if ($results['beruehrung_sozialverhalten_1_bewertung']) {
                $ergebnis->beruehrung_sozialverhalten_1_bewertung = $results['beruehrung_sozialverhalten_1_bewertung'];
            }
            if ($results['beruehrung_sozialverhalten_2']) {
                $ergebnis->beruehrung_sozialverhalten_2 = $results['beruehrung_sozialverhalten_2'];
            }
            if ($results['beruehrung_sozialverhalten_2_bewertung']) {
                $ergebnis->beruehrung_sozialverhalten_2_bewertung = $results['beruehrung_sozialverhalten_2_bewertung'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_1']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_1 = $results['beruehrung_beschwichtigungsverhalten_1'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_1_bewertung']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_1_bewertung = $results['beruehrung_beschwichtigungsverhalten_1_bewertung'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_2']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_2 = $results['beruehrung_beschwichtigungsverhalten_2'];
            }
            if ($results['beruehrung_beschwichtigungsverhalten_2_bewertung']) {
                $ergebnis->beruehrung_beschwichtigungsverhalten_2_bewertung = $results['beruehrung_beschwichtigungsverhalten_2_bewertung'];
            }
            if ($results['beruehrung_aggressionsverhalten_1']) {
                $ergebnis->beruehrung_aggressionsverhalten_1 = $results['beruehrung_aggressionsverhalten_1'];
            }
            if ($results['beruehrung_aggressionsverhalten_1_bewertung']) {
                $ergebnis->beruehrung_aggressionsverhalten_1_bewertung = $results['beruehrung_aggressionsverhalten_1_bewertung'];
            }
            if ($results['beruehrung_aggressionsverhalten_2']) {
                $ergebnis->beruehrung_aggressionsverhalten_2 = $results['beruehrung_aggressionsverhalten_2'];
            }
            if ($results['beruehrung_aggressionsverhalten_2_bewertung']) {
                $ergebnis->beruehrung_aggressionsverhalten_2_bewertung = $results['beruehrung_aggressionsverhalten_2_bewertung'];
            }
            if ($results['spiel_spielverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_spielverhalten_ohne_gegenstand = $results['spiel_spielverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_spielverhalten_mit_gegenstand']) {
                $ergebnis->spiel_spielverhalten_mit_gegenstand = $results['spiel_spielverhalten_mit_gegenstand'];
            }
            if ($results['spiel_beuteverhalten_mit_gegenstand']) {
                $ergebnis->spiel_beuteverhalten_mit_gegenstand = $results['spiel_beuteverhalten_mit_gegenstand'];
            }
            if ($results['spiel_beuteverhalten_werfen_des_gegenstandes_1']) {
                $ergebnis->spiel_beuteverhalten_werfen_des_gegenstandes_1 = $results['spiel_beuteverhalten_werfen_des_gegenstandes_1'];
            }
            if ($results['spiel_beuteverhalten_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_beuteverhalten_werfen_des_gegenstandes_2 = $results['spiel_beuteverhalten_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_tragenzutragen_werfen_des_gegenstandes_1']) {
                $ergebnis->spiel_tragenzutragen_werfen_des_gegenstandes_1 = $results['spiel_tragenzutragen_werfen_des_gegenstandes_1'];
            }
            if ($results['spiel_tragenzutragen_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_tragenzutragen_werfen_des_gegenstandes_2 = $results['spiel_tragenzutragen_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_suchverhalten_werfen_des_gegenstandes_2']) {
                $ergebnis->spiel_suchverhalten_werfen_des_gegenstandes_2 = $results['spiel_suchverhalten_werfen_des_gegenstandes_2'];
            }
            if ($results['spiel_beschwichtigungsverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_beschwichtigungsverhalten_ohne_gegenstand = $results['spiel_beschwichtigungsverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_aggressionsverhalten_ohne_gegenstand']) {
                $ergebnis->spiel_aggressionsverhalten_ohne_gegenstand = $results['spiel_aggressionsverhalten_ohne_gegenstand'];
            }
            if ($results['spiel_aggressionsverhalten_mit_gegenstand']) {
                $ergebnis->spiel_aggressionsverhalten_mit_gegenstand = $results['spiel_aggressionsverhalten_mit_gegenstand'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_1 = $results['parcours_schreckhaftigkeit_haptisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_1 = $results['parcours_schreckhaftigkeit_akustisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_1']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_1 = $results['parcours_schreckhaftigkeit_optisch_1'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_2 = $results['parcours_schreckhaftigkeit_haptisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_2 = $results['parcours_schreckhaftigkeit_akustisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_2']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_2 = $results['parcours_schreckhaftigkeit_optisch_2'];
            }
            if ($results['parcours_schreckhaftigkeit_haptisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_haptisch_3 = $results['parcours_schreckhaftigkeit_haptisch_3'];
            }
            if ($results['parcours_schreckhaftigkeit_akustisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_akustisch_3 = $results['parcours_schreckhaftigkeit_akustisch_3'];
            }
            if ($results['parcours_schreckhaftigkeit_optisch_3']) {
                $ergebnis->parcours_schreckhaftigkeit_optisch_3 = $results['parcours_schreckhaftigkeit_optisch_3'];
            }
            if ($results['parcours_beschwichtigung_haptisch_1']) {
                $ergebnis->parcours_beschwichtigung_haptisch_1 = $results['parcours_beschwichtigung_haptisch_1'];
            }
            if ($results['parcours_beschwichtigung_akustisch_1']) {
                $ergebnis->parcours_beschwichtigung_akustisch_1 = $results['parcours_beschwichtigung_akustisch_1'];
            }
            if ($results['parcours_beschwichtigung_optisch_1']) {
                $ergebnis->parcours_beschwichtigung_optisch_1 = $results['parcours_beschwichtigung_optisch_1'];
            }
            if ($results['parcours_beschwichtigung_haptisch_2']) {
                $ergebnis->parcours_beschwichtigung_haptisch_2 = $results['parcours_beschwichtigung_haptisch_2'];
            }
            if ($results['parcours_beschwichtigung_akustisch_2']) {
                $ergebnis->parcours_beschwichtigung_akustisch_2 = $results['parcours_beschwichtigung_akustisch_2'];
            }
            if ($results['parcours_beschwichtigung_optisch_2']) {
                $ergebnis->parcours_beschwichtigung_optisch_2 = $results['parcours_beschwichtigung_optisch_2'];
            }
            if ($results['parcours_beschwichtigung_haptisch_3']) {
                $ergebnis->parcours_beschwichtigung_haptisch_3 = $results['parcours_beschwichtigung_haptisch_3'];
            }
            if ($results['parcours_beschwichtigung_akustisch_3']) {
                $ergebnis->parcours_beschwichtigung_akustisch_3 = $results['parcours_beschwichtigung_akustisch_3'];
            }
            if ($results['parcours_beschwichtigung_optisch_3']) {
                $ergebnis->parcours_beschwichtigung_optisch_3 = $results['parcours_beschwichtigung_optisch_3'];
            }
            if ($results['parcours_neugierverhalten_haptisch_1']) {
                $ergebnis->parcours_neugierverhalten_haptisch_1 = $results['parcours_neugierverhalten_haptisch_1'];
            }
            if ($results['parcours_neugierverhalten_akustisch_1']) {
                $ergebnis->parcours_neugierverhalten_akustisch_1 = $results['parcours_neugierverhalten_akustisch_1'];
            }
            if ($results['parcours_neugierverhalten_optisch_1']) {
                $ergebnis->parcours_neugierverhalten_optisch_1 = $results['parcours_neugierverhalten_optisch_1'];
            }
            if ($results['parcours_neugierverhalten_haptisch_2']) {
                $ergebnis->parcours_neugierverhalten_haptisch_2 = $results['parcours_neugierverhalten_haptisch_2'];
            }
            if ($results['parcours_neugierverhalten_akustisch_2']) {
                $ergebnis->parcours_neugierverhalten_akustisch_2 = $results['parcours_neugierverhalten_akustisch_2'];
            }
            if ($results['parcours_neugierverhalten_optisch_2']) {
                $ergebnis->parcours_neugierverhalten_optisch_2 = $results['parcours_neugierverhalten_optisch_2'];
            }
            if ($results['parcours_neugierverhalten_haptisch_3']) {
                $ergebnis->parcours_neugierverhalten_haptisch_3 = $results['parcours_neugierverhalten_haptisch_3'];
            }
            if ($results['parcours_neugierverhalten_akustisch_3']) {
                $ergebnis->parcours_neugierverhalten_akustisch_3 = $results['parcours_neugierverhalten_akustisch_3'];
            }
            if ($results['parcours_neugierverhalten_optisch_3']) {
                $ergebnis->parcours_neugierverhalten_optisch_3 = $results['parcours_neugierverhalten_optisch_3'];
            }
            if ($results['parcours_aktivitaet']) {
                $ergebnis->parcours_aktivitaet = $results['parcours_aktivitaet'];
            }
            if ($results['schuss_schreckhaftigkeit_100m']) {
                $ergebnis->schuss_schreckhaftigkeit_100m = $results['schuss_schreckhaftigkeit_100m'];
            }
            if ($results['schuss_schreckhaftigkeit_50m']) {
                $ergebnis->schuss_schreckhaftigkeit_50m = $results['schuss_schreckhaftigkeit_50m'];
            }
            if ($results['schuss_schreckhaftigkeit_20m']) {
                $ergebnis->schuss_schreckhaftigkeit_20m = $results['schuss_schreckhaftigkeit_20m'];
            }
            if ($results['schuss_beschwichtigung_100m']) {
                $ergebnis->schuss_beschwichtigung_100m = $results['schuss_beschwichtigung_100m'];
            }
            if ($results['schuss_beschwichtigung_50m']) {
                $ergebnis->schuss_beschwichtigung_50m = $results['schuss_beschwichtigung_50m'];
            }
            if ($results['schuss_beschwichtigung_20m']) {
                $ergebnis->schuss_beschwichtigung_20m = $results['schuss_beschwichtigung_20m'];
            }
            if ($results['bemerkungen']) {
                $ergebnis->bemerkungen = $results['bemerkungen'];
            }
            if ($results['zusammenfassende_beschreibung']) {
                $ergebnis->zusammenfassende_beschreibung = $results['zusammenfassende_beschreibung'];
            }
            if ($results['bestanden']) {
                $ergebnis->bestanden = $results['bestanden'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund = $results['ausschlussgrund'];
            }
            if ($results['zurueckgestellt']) {
                $ergebnis->zurueckgestellt = $results['zurueckgestellt'];
            }
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wesenstest  $wesenstest
     * @return \Illuminate\Http\Response
     */
    public function show(Wesenstest_v1 $wesenstest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Wesenstest  $wesenstest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wesenstest_v1 $wesenstest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wesenstest  $wesenstest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wesenstest_v1 $wesenstest)
    {
        //
    }
}
