<?php

namespace App\Http\Controllers;

use App\Models\PnS_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class PnSController extends Controller
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
            $ergebnis = PnS_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new PnS_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\PnS_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['schweissarbeit']) {
                $ergebnis->schweissarbeit_id = $results['schweissarbeit']['id'];
            }
            if ($results['allgemeines_verhalten_gehorsam']) {
                $ergebnis->allgemeines_verhalten_gehorsam_id = $results['allgemeines_verhalten_gehorsam']['id'];
            }
            if ($results['haarwildschleppe']) {
                $ergebnis->haarwildschleppe_id = $results['haarwildschleppe']['id'];
            }
            if ($results['verlorensuche_wasser']) {
                $ergebnis->verlorensuche_wasser_id = $results['verlorensuche_wasser']['id'];
            }
            if ($results['verlorensuche_wald']) {
                $ergebnis->verlorensuche_wald_id = $results['verlorensuche_wald']['id'];
            }
            if ($results['einweisen_feld_markieren_standruhe']) {
                $ergebnis->einweisen_feld_markieren_standruhe_id = $results['einweisen_feld_markieren_standruhe']['id'];
            }
            if ($results['einweisen_schleppspur_apport']) {
                $ergebnis->einweisen_schleppspur_apport_id = $results['einweisen_schleppspur_apport']['id'];
            }
            if ($results['gesamtpunktzahl']) {
                $ergebnis->gesamtpunktzahl_id = $results['gesamtpunktzahl']['id'];
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
     * @param  \App\Models\PnS_v1  $pns
     * @return \Illuminate\Http\Response
     */
    //  public function show(PnS_v1 $pns)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\PnS_v1  $pns
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, PnS_v1 $pns)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\PnS_v1  $pns
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(PnS_v1 $pns)
    //  {
    //      //
    //  }
}
