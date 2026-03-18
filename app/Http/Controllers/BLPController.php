<?php

namespace App\Http\Controllers;

use App\Models\BLP_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class BLPController extends Controller
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
            $ergebnis = BLP_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new BLP_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\BLP_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;

            if ($results['arbeitsfreude']) {
                $ergebnis->arbeitsfreude_id = $results['arbeitsfreude']['id'];
            }
            if ($results['nasengebrauch']) {
                $ergebnis->nasengebrauch_id = $results['nasengebrauch']['id'];
            }
            if ($results['fuehrigkeit']) {
                $ergebnis->fuehrigkeit_id = $results['fuehrigkeit']['id'];
            }
            if ($results['wasserfreude']) {
                $ergebnis->wasserfreude_id = $results['wasserfreude']['id'];
            }
            if ($results['koerperliche_haerte']) {
                $ergebnis->koerperliche_haerte_id = $results['koerperliche_haerte']['id'];
            }
            if ($results['freie_verlorensuche']) {
                $ergebnis->freie_verlorensuche_id = $results['freie_verlorensuche']['id'];
            }
            if ($results['standruhe']) {
                $ergebnis->standruhe_id = $results['standruhe']['id'];
            }
            if ($results['merken']) {
                $ergebnis->merken_id = $results['merken']['id'];
            }
            if ($results['wasserarbeit_a1']) {
                $ergebnis->wasserarbeit_a1_id = $results['wasserarbeit_a1']['id'];
            }
            if ($results['wasserarbeit_b1']) {
                $ergebnis->wasserarbeit_b1_id = $results['wasserarbeit_b1']['id'];
            }
            if ($results['wasserarbeit_b2']) {
                $ergebnis->wasserarbeit_b2_id = $results['wasserarbeit_b2']['id'];
            }
            if ($results['wasserarbeit_b2_upload']) {
                $ergebnis->wasserarbeit_b2_upload = $results['wasserarbeit_b2_upload'];
            }
            if ($results['wasserarbeit_b2_zeugnis']) {
                $ergebnis->wasserarbeit_b2_zeugnis = $results['wasserarbeit_b2_zeugnis'];
            }
            if ($results['fachwertfaktor_ente_mit_zeugnis']) {
                $ergebnis->fachwertfaktor_ente_mit_zeugnis = $results['fachwertfaktor_ente_mit_zeugnis'];
            }
            if ($results['gesamtpunkte1bis9']) {
                $ergebnis->gesamtpunkte1bis9 = $results['gesamtpunkte1bis9'];
            }
            if ($results['einweisen_federwild']) {
                $ergebnis->einweisen_federwild_id = $results['einweisen_federwild']['id'];
            }
            if ($results['wildschleppe']) {
                $ergebnis->wildschleppe_id = $results['wildschleppe']['id'];
            }
            if ($results['wildschleppe_meter']) {
                $ergebnis->wildschleppe_meter = $results['wildschleppe_meter'];
            }
            if ($results['bringen_hase_kanin']) {
                $ergebnis->bringen_hase_kanin_id = $results['bringen_hase_kanin']['id'];
            }
            if ($results['bringen_ente']) {
                $ergebnis->bringen_ente_id = $results['bringen_ente']['id'];
            }
            if ($results['bringen_federwild']) {
                $ergebnis->bringen_federwild_id = $results['bringen_federwild']['id'];
            }
            if ($results['gehorsam']) {
                $ergebnis->gehorsam_id = $results['gehorsam']['id'];
            }
            if ($results['wildschleppe']) {
                $ergebnis->wildschleppe_id = $results['wildschleppe']['id'];
            }
            if ($results['verhalten_stand']) {
                $ergebnis->verhalten_stand = $results['verhalten_stand'];
            }
            if ($results['leinenfuehrigkeit']) {
                $ergebnis->leinenfuehrigkeit = $results['leinenfuehrigkeit'];
            }
            if ($results['folgen_frei_bei_fuss']) {
                $ergebnis->folgen_frei_bei_fuss = $results['folgen_frei_bei_fuss'];
            }
            if ($results['ablegen']) {
                $ergebnis->ablegen = $results['ablegen'];
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
            if ($results['sonstiges_wesenverhalten']) {
                $ergebnis->sonstiges_wesenverhalten_id = $results['sonstiges_wesenverhalten']['id'];
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

            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BLP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function show_v1(BLP_v1 $BLP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\BLP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function update_v1(Request $request, BLP_v1 $BLP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BLP  $bHP
     * @return \Illuminate\Http\Response
     */
    public function destroy_v1(BLP_v1 $BLP)
    {
        //
    }
}
