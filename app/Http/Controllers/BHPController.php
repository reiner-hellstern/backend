<?php

namespace App\Http\Controllers;

use App\Models\BHP_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class BHPController extends Controller
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
            $ergebnis = BHP_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new BHP_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\APDR_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;

            if ($results['test1_punkte']) {
                $ergebnis->test1_punkte = $results['test1_punkte'];
            }
            if ($results['test1_bemerkung']) {
                $ergebnis->test1_bemerkung = $results['test1_bemerkung'];
            }
            if ($results['test2_punkte']) {
                $ergebnis->test2_punkte = $results['test2_punkte'];
            }
            if ($results['test2_bemerkung']) {
                $ergebnis->test2_bemerkung = $results['test2_bemerkung'];
            }
            if ($results['test3_punkte']) {
                $ergebnis->test3_punkte = $results['test3_punkte'];
            }
            if ($results['test3_bemerkung']) {
                $ergebnis->test3_bemerkung = $results['test3_bemerkung'];
            }
            if ($results['test4_punkte']) {
                $ergebnis->test4_punkte = $results['test4_punkte'];
            }
            if ($results['test4_bemerkung']) {
                $ergebnis->test4_bemerkung = $results['test4_bemerkung'];
            }
            if ($results['test5_punkte']) {
                $ergebnis->test5_punkte = $results['test5_punkte'];
            }
            if ($results['test5_bemerkung']) {
                $ergebnis->test5_bemerkung = $results['test5_bemerkung'];
            }
            if ($results['test_gesamtpunktzahl']) {
                $ergebnis->test2_gesamtpunktzahl = $results[''];
            }
            if ($results['test_begegnung_mit_personengruppen']) {
                $ergebnis->test_begegnung_mit_personengruppen = $results['test_begegnung_mit_personengruppen'];
            }
            if ($results['test_begegnung_mit_radfahrern']) {
                $ergebnis->test_begegnung_mit_radfahrern = $results['test_begegnung_mit_radfahrern'];
            }
            if ($results['test_begegnung_mit_autos']) {
                $ergebnis->test_begegnung_mit_autos = $results['test_begegnung_mit_autos'];
            }
            if ($results['test_begegnung_mit_joggern']) {
                $ergebnis->test_begegnung_mit_joggern = $results['test_begegnung_mit_joggern'];
            }
            if ($results['test_begegnung_mit_hunden']) {
                $ergebnis->test_begegnung_mit_hunden = $results['test_begegnung_mit_hunden'];
            }
            if ($results['test_verhalten_allein_angeleint']) {
                $ergebnis->test_verhalten_allein_angeleint = $results['test_verhalten_allein_angeleint'];
            }
            if ($results['test_verhalten_akzeptabel']) {
                $ergebnis->test_verhalten_akzeptabel = $results['test_verhalten_akzeptabel'];
            }
            // if ( $results['test_verhalten_unbefangenheit'] ) $ergebnis->test_verhalten_unbefangenheit_id = $results['test_verhalten_unbefangenheit']['id'];
            // if ( $results['test_geamtbeurteilung'] ) $ergebnis->test_geamtbeurteilung_id = $results['test_geamtbeurteilung']['id'];
            if ($results['test_verhalten_unbefangenheit']) {
                $ergebnis->test_verhalten_unbefangenheit = $results['test_verhalten_unbefangenheit'];
            }
            if ($results['test_gesamtbeurteilung']) {
                $ergebnis->test_gesamtbeurteilung = $results['test_gesamtbeurteilung'];
            }
            if ($results['test_ausschlussgrund']) {
                $ergebnis->test_ausschlussgrund = $results['test_ausschlussgrund'];
            }

            // if ( $results['test1_ausfuehrung'] ) $ergebnis->test1_ausfuehrung_id = $results['test1_ausfuehrung']['id'];
            // if ( $results['test1_punkte'] ) $ergebnis->test1_punkte = $results['test1_punkte'];
            // if ( $results['test2_ausfuehrung'] ) $ergebnis->test2_ausfuehrung_id = $results['test2_ausfuehrung']['id'];
            // if ( $results['test2_punkte'] ) $ergebnis->test2_punkte = $results['test2_punkte'];
            // if ( $results['test3_ausfuehrung'] ) $ergebnis->test3_ausfuehrung_id = $results['test3_ausfuehrung']['id'];
            // if ( $results['test3_punkte'] ) $ergebnis->test3_punkte = $results['test3_punkte'];
            // if ( $results['test4_ausfuehrung'] ) $ergebnis->test4_ausfuehrung_id = $results['test4_ausfuehrung']['id'];
            // if ( $results['test4_punkte'] ) $ergebnis->test4_punkte = $results['test4_punkte'];
            // if ( $results['ausschlussgrund'] ) $ergebnis->ausschlussgrund_id = $results['ausschlussgrund']['id'];
            // $ergebnis->bemerkung = $results['bemerkung'];

            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BHP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function show_v1(BHP_v1 $BHP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\BHP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function update_v1(Request $request, BHP_v1 $BHP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BHP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function destroy_v1(BHP_v1 $BHP)
    {
        //
    }
}
