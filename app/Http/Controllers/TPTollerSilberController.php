<?php

namespace App\Http\Controllers;

use App\Models\TPTollerSilber_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class TPTollerSilberController extends Controller
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
            $ergebnis = TPTollerSilber_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new TPTollerSilber_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\TPTollerSilber_v1';
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
            if ($results['passivitaet']) {
                $ergebnis->passivitaet_id = $results['passivitaet']['id'];
            }
            if ($results['gesamt_fachgruppe1']) {
                $ergebnis->gesamt_fachgruppe1 = $results['gesamt_fachgruppe1'];
            }
            if ($results['merken']) {
                $ergebnis->merken_id = $results['merken']['id'];
            }
            if ($results['einweisen_wasserflaeche']) {
                $ergebnis->einweisen_wasserflaeche_id = $results['einweisen_wasserflaeche']['id'];
            }
            if ($results['bringen_ente']) {
                $ergebnis->bringen_ente_id = $results['bringen_ente']['id'];
            }
            if ($results['gesamt_fachgruppe2']) {
                $ergebnis->gesamt_fachgruppe2 = $results['gesamt_fachgruppe2'];
            }
            if ($results['suche_nutzwild']) {
                $ergebnis->suche_nutzwild_id = $results['suche_nutzwild']['id'];
            }
            if ($results['einweisen_federnutzwild']) {
                $ergebnis->einweisen_federnutzwild_id = $results['einweisen_federnutzwild']['id'];
            }
            if ($results['bringen_federwild']) {
                $ergebnis->bringen_federwild_id = $results['bringen_federwild']['id'];
            }
            if ($results['bringen_haarwild']) {
                $ergebnis->bringen_haarwild_id = $results['bringen_haarwild']['id'];
            }
            if ($results['gesamt_fachgruppe3']) {
                $ergebnis->gesamt_fachgruppe3 = $results['gesamt_fachgruppe3'];
            }
            if ($results['gehorsam']) {
                $ergebnis->gehorsam_id = $results['gehorsam']['id'];
            }
            if ($results['arbeitsfreude']) {
                $ergebnis->arbeitsfreude_id = $results['arbeitsfreude']['id'];
            }
            if ($results['fuehrigkeit']) {
                $ergebnis->fuehrigkeit_id = $results['fuehrigkeit']['id'];
            }
            if ($results['nasengebrauch']) {
                $ergebnis->nasengebrauch_id = $results['nasengebrauch']['id'];
            }
            if ($results['gesamt_fachgruppe4']) {
                $ergebnis->gesamt_fachgruppe4 = $results['gesamt_fachgruppe4'];
            }
            if ($results['gesamtpunktzahl']) {
                $ergebnis->gesamtpunktzahl = $results['gesamtpunktzahl'];
            }
            if ($results['gesamturteil']) {
                $ergebnis->gesamturteil_id = $results['gesamturteil']['id'];
            }
            if ($results['schussfestigkeit_land']) {
                $ergebnis->schussfestigkeit_land_id = $results['schussfestigkeit_land']['id'];
            }
            if ($results['schussfestigkeit_wasserarbeit']) {
                $ergebnis->schussfestigkeit_wasserarbeit_id = $results['schussfestigkeit_wasserarbeit']['id'];
            }
            if ($results['temperament']) {
                $ergebnis->temperament_id = $results['temperament']['id'];
            }
            if ($results['selbstsicherheit']) {
                $ergebnis->selbstsicherheit_id = $results['selbstsicherheit']['id'];
            }
            if ($results['vertraeglichkeit']) {
                $ergebnis->vertraeglichkeit_id = $results['vertraeglichkeit']['id'];
            }
            if ($results['sonstige_wesenverhalten']) {
                $ergebnis->sonstige_wesenverhalten_id = $results['sonstige_wesenverhalten']['id'];
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
     * @param  \App\Models\TPTollerSilber  $tptollersilber
     * @return \Illuminate\Http\Response
     */
    //  public function show(TPTollerSilber_v1 $tptollersilber)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\TPTollerSilber  $tptollersilber
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, TPTollerSilber_v1 $tptollersilber)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\TPTollerSilber  $tptollersilber
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(TPTollerSilber $tptollersilber)
    //  {
    //      //
    //  }
}
