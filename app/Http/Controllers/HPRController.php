<?php

namespace App\Http\Controllers;

use App\Models\HPR_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class HPRController extends Controller
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
            $ergebnis = HPR_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new HPR_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\HPR_v1';
            $meldung->save();
        }

        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['gesamtergebnis']) {
                $ergebnis->gesamtergebnis_id = $results['gesamtergebnis']['id'];
            }
            if ($results['haarwildschleppe']) {
                $ergebnis->haarwildschleppe_id = $results['haarwildschleppe']['id'];
            }
            if ($results['marking_merken_land']) {
                $ergebnis->marking_merken_land_id = $results['marking_merken_land']['id'];
            }
            if ($results['einweisen_federwild']) {
                $ergebnis->einweisen_federwild_id = $results['einweisen_federwild']['id'];
            }
            if ($results['einweisen_gewaesser']) {
                $ergebnis->einweisen_gewaesser_id = $results['einweisen_gewaesser']['id'];
            }
            if ($results['verlorensuche']) {
                $ergebnis->verlorensuche_id = $results['verlorensuche']['id'];
            }
            if ($results['standtreiben']) {
                $ergebnis->standtreiben_id = $results['standtreiben']['id'];
            }
            if ($results['marking_merken_gewaesser']) {
                $ergebnis->marking_merken_gewaesser_id = $results['marking_merken_gewaesser']['id'];
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
     * @return \Illuminate\Http\Response
     */
    public function show_v1(HPR_v1 $hPR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_v1(Request $request, HPR_v1 $hPR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy_v1(HPR_v1 $hPR)
    {
        //
    }
}
