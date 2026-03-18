<?php

namespace App\Http\Controllers;

use App\Models\APDR_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class APDRController extends Controller
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
            $ergebnis = APDR_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new APDR_v1();
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
            if ($results['test1_ausfuehrung']) {
                $ergebnis->test1_ausfuehrung_id = $results['test1_ausfuehrung']['id'];
            }
            if ($results['test1_punkte']) {
                $ergebnis->test1_punkte = $results['test1_punkte'];
            }
            if ($results['test2_ausfuehrung']) {
                $ergebnis->test2_ausfuehrung_id = $results['test2_ausfuehrung']['id'];
            }
            if ($results['test2_punkte']) {
                $ergebnis->test2_punkte = $results['test2_punkte'];
            }
            if ($results['test3_ausfuehrung']) {
                $ergebnis->test3_ausfuehrung_id = $results['test3_ausfuehrung']['id'];
            }
            if ($results['test3_punkte']) {
                $ergebnis->test3_punkte = $results['test3_punkte'];
            }
            if ($results['test4_ausfuehrung']) {
                $ergebnis->test4_ausfuehrung_id = $results['test4_ausfuehrung']['id'];
            }
            if ($results['test4_punkte']) {
                $ergebnis->test4_punkte = $results['test4_punkte'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund_id = $results['ausschlussgrund']['id'];
            }
            $ergebnis->bemerkung = $results['bemerkung'];
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\APDR  $APDR
     * @return \Illuminate\Http\Response
     */
    //  public function show(APDR_v1 $APDR)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\APDR  $APDR
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, APDR_v1 $APDR)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\APDR  $APDR
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(APDR $APDR)
    //  {
    //      //
    //  }
}
