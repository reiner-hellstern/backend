<?php

namespace App\Http\Controllers;

use App\Models\SRP_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class SRPController extends Controller
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
            $ergebnis = SRP_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new SRP_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\SRP_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['gesamtpraedikat']) {
                $ergebnis->gesamtpraedikat_id = $results['gesamtpraedikat']['id'];
            }
            if ($results['gesamtpunkte']) {
                $ergebnis->gesamtpunkte = $results['gesamtpunkte'];
            }
            if ($results['aufgabe1']) {
                $ergebnis->aufgabe1_id = $results['aufgabe1']['id'];
            }
            if ($results['aufgabe2']) {
                $ergebnis->aufgabe2_id = $results['aufgabe2']['id'];
            }
            if ($results['aufgabe3']) {
                $ergebnis->aufgabe3_id = $results['aufgabe3']['id'];
            }
            if ($results['aufgabe4']) {
                $ergebnis->aufgabe4_id = $results['aufgabe4']['id'];
            }
            if ($results['aufgabe5']) {
                $ergebnis->aufgabe5_id = $results['aufgabe5']['id'];
            }
            if ($results['aufgabe6']) {
                $ergebnis->aufgabe6_id = $results['aufgabe6']['id'];
            }
            if ($results['aufgabe7']) {
                $ergebnis->aufgabe7_id = $results['aufgabe7']['id'];
            }
            if ($results['aufgabe8']) {
                $ergebnis->aufgabe8_id = $results['aufgabe8']['id'];
            }
            if ($results['aufgabe9']) {
                $ergebnis->aufgabe9_id = $results['aufgabe9']['id'];
            }
            if ($results['aufgabe10']) {
                $ergebnis->aufgabe10_id = $results['aufgabe10']['id'];
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
     * @param  \App\Models\SRP  $sRP
     * @return \Illuminate\Http\Response
     */
    public function show(SRP_v1 $sRP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\SRP  $sRP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SRP_v1 $sRP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SRP  $sRP
     * @return \Illuminate\Http\Response
     */
    public function destroy(SRP_v1 $sRP)
    {
        //
    }
}
