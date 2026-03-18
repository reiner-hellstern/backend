<?php

namespace App\Http\Controllers;

use App\Models\MockTrail_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class MockTrailController extends Controller
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
            $ergebnis = MockTrail_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new MockTrail_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\MockTrail_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            // if ( $results['test1_ausfuehrung'] )$ergebnis->test1_ausfuehrung_id = $results['test1_ausfuehrung']['id'];

            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MockTrail_v1  $mocktrail
     * @return \Illuminate\Http\Response
     */
    //  public function show(MockTrail_v1 $mocktrail)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\MockTrail_v1  $mocktrail
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, MockTrail_v1 $mocktrail)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\MockTrail_v1  $mocktrail
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(MockTrail_v1 $mocktrail)
    //  {
    //      //
    //  }
}
