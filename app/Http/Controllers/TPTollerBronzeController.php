<?php

namespace App\Http\Controllers;

use App\Models\TPTollerBronze_v1;
use App\Models\TPTollerBronze_v2;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class TPTollerBronzeController extends Controller
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
            $ergebnis = TPTollerBronze_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new TPTollerBronze_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\TPTollerBronze_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['anschleichen']) {
                $ergebnis->anschleichen_id = $results['anschleichen']['id'];
            }
            if ($results['tolling']) {
                $ergebnis->tolling_id = $results['tolling']['id'];
            }
            if ($results['wasserfreude']) {
                $ergebnis->wasserfreude_id = $results['wasserfreude']['id'];
            }
            if ($results['bringen_ente']) {
                $ergebnis->bringen_ente_id = $results['bringen_ente']['id'];
            }
            if ($results['zusammenarbeit']) {
                $ergebnis->zusammenarbeit_id = $results['zusammenarbeit']['id'];
            }
            if ($results['gesamt_1bis5']) {
                $ergebnis->gesamt_1bis5 = $results['gesamt_1bis5'];
            }
            if ($results['schussfestigkeit']) {
                $ergebnis->schussfestigkeit = $results['schussfestigkeit'];
            }
            if ($results['bemerkungen']) {
                $ergebnis->bemerkungen = $results['bemerkungen'];
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
            if ($results['andere_maengel']) {
                $ergebnis->andere_maengel = $results['andere_maengel'];
            }
            if ($results['aengstlich']) {
                $ergebnis->aengstlich = $results['aengstlich'];
            }
            if ($results['schreckhaft']) {
                $ergebnis->schreckhaft = $results['schreckhaft'];
            }
            if ($results['nervoes']) {
                $ergebnis->nervoes = $results['nervoes'];
            }
            if ($results['handscheu']) {
                $ergebnis->handscheu = $results['handscheu'];
            }
            if ($results['schaerfe']) {
                $ergebnis->schaerfe = $results['schaerfe'];
            }
            if ($results['scheu']) {
                $ergebnis->scheu = $results['scheu'];
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
            $ergebnis = TPTollerBronze_v2::find($meldung->resultable_id);
        } else {
            $ergebnis = new TPTollerBronze_v2();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\TPTollerBronze_v2';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            //if ( $results['test1_ausfuehrung'] )$ergebnis->test1_ausfuehrung_id = $results['test1_ausfuehrung']['id'];

            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TPTollerBronze  $tptollerbronze
     * @return \Illuminate\Http\Response
     */
    //  public function show(TPTollerBronze_v1 $tptollerbronze)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\TPTollerBronze  $tptollerbronze
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, TPTollerBronze_v1 $tptollerbronze)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\TPTollerBronze  $tptollerbronze
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(TPTollerBronze $tptollerbronze)
    //  {
    //      //
    //  }
}
