<?php

namespace App\Http\Controllers;

use App\Models\Schusstest_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class SchusstestController extends Controller
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
            $ergebnis = Schusstest_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new Schusstest_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\Schusstest_v1';
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
            //  pruefungen:  { val label: 'Bitte auswählen', wert: 0 },'] ) $ergebnis-> = $results['//  pruefungen:  { val label: 'Bitte auswählen', wert: 0 },'];
            if ($results['pruefungen_weitere']) {
                $ergebnis->pruefungen_weitere = $results['pruefungen_weitere'];
            }
            if ($results['schussfestigkeit']) {
                $ergebnis->schussfestigkeit_id = $results['schussfestigkeit']['id'];
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
     * @param  \App\Models\Schusstest  $schusstest
     * @return \Illuminate\Http\Response
     */
    public function show_v1(Schusstest_v1 $schusstest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Schusstest  $schusstest
     * @return \Illuminate\Http\Response
     */
    public function update_v1(Request $request, Schusstest_v1 $schusstest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schusstest  $schusstest
     * @return \Illuminate\Http\Response
     */
    public function destroy_v1(Schusstest_v1 $schusstest)
    {
        //
    }
}
