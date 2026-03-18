<?php

namespace App\Http\Controllers;

use App\Models\RSwPoRb_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class RSwPoRbController extends Controller
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
            $ergebnis = RSwPoRb_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new RSwPoRb_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\RSwPoRb_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['nummer']) {
                $ergebnis->nummer = $results['nummer'];
            }
            // if ( $results['wildschweiss'] ) $ergebnis->wildschweiss = $results['wildschweiss'];
            if ($results['verweiser']) {
                $ergebnis->verweiser = $results['verweiser'];
            }
            if ($results['totverbeller']) {
                $ergebnis->totverbeller = $results['totverbeller'];
            }
            if ($results['verweiser_totverbeller']) {
                $ergebnis->verweiser_totverbeller = $results['verweiser_totverbeller'];
            }
            if ($results['nachsuche_datum']) {
                $ergebnis->nachsuche_datum = $results['nachsuche_datum'];
            }
            if ($results['nachsuche_zeit']) {
                $ergebnis->nachsuche_zeit = $results['nachsuche_zeit'];
            }
            if ($results['stehzeit']) {
                $ergebnis->stehzeit = $results['stehzeit'];
            }
            if ($results['todesursache']) {
                $ergebnis->todesursache = $results['todesursache'];
            }
            if ($results['todesdatum']) {
                $ergebnis->todesdatum = $results['todesdatum'];
            }
            if ($results['todeszeit']) {
                $ergebnis->todeszeit = $results['todeszeit'];
            }
            if ($results['boden_gelaende']) {
                $ergebnis->boden_gelaende = $results['boden_gelaende'];
            }
            if ($results['wetter']) {
                $ergebnis->wetter = $results['wetter'];
            }
            if ($results['fehlsuche']) {
                $ergebnis->fehlsuche = $results['fehlsuche'];
            }
            if ($results['fehlsuchen_rasse']) {
                $ergebnis->fehlsuchen_rasse = $results['fehlsuchen_rasse'];
            }
            if ($results['laenge_riemenarbeit']) {
                $ergebnis->laenge_riemenarbeit = $results['laenge_riemenarbeit'];
            }
            if ($results['laenge_hetze']) {
                $ergebnis->laenge_hetze = $results['laenge_hetze'];
            }
            if ($results['wildart']) {
                $ergebnis->wildart = $results['wildart'];
            }
            if ($results['wildbretgewicht']) {
                $ergebnis->wildbretgewicht = $results['wildbretgewicht'];
            }
            if ($results['verkaufspreis']) {
                $ergebnis->verkaufspreis = $results['verkaufspreis'];
            }
            if ($results['nachsuche_beschreibung']) {
                $ergebnis->nachsuche_beschreibung = $results['nachsuche_beschreibung'];
            }
            if ($results['nachsuche_zeugen']) {
                $ergebnis->nachsuche_zeugen = $results['nachsuche_zeugen'];
            }
            if ($results['bericht_ort']) {
                $ergebnis->bericht_ort = $results['bericht_ort'];
            }
            if ($results['bericht_datum']) {
                $ergebnis->bericht_datum = $results['bericht_datum'];
            }
            if ($results['praedikat']) {
                $ergebnis->praedikat_id = $results['praedikat']['id'];
            }
            if ($results['bemerkungen']) {
                $ergebnis->bemerkungen = $results['bemerkungen'];
            }
            if ($results['bestanden']) {
                $ergebnis->bestanden = $results['bestanden'];
            }
            if ($results['preis']) {
                $ergebnis->preis_id = $results['preis']['id'];
            }
            // if ( $results['pruefungsleiter'] ) $ergebnis->pruefungsleiter_id = $results['pruefungsleiter']['id'];
            // if ( $results['richterobmann'] ) $ergebnis->richterobmann_id = $results['richterobmann']['id'];
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RSwPoRB_v1  $rswporb
     * @return \Illuminate\Http\Response
     */
    //  public function show(RSwPoRB_v1 $rswporb)
    //  {
    //      //
    //  }

    //  /**
    //   * Update the specified resource in storage.
    //   *
    //   * @param  \Illuminate\Http\Request  $request
    //   * @param  \App\Models\RSwPoRB_v1  $rswporb
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function update(Request $request, RSwPoRB_v1 $rswporb)
    //  {
    //      //
    //  }

    //  /**
    //   * Remove the specified resource from storage.
    //   *
    //   * @param  \App\Models\RSwPoRB_v1  $rswporb
    //   * @return \Illuminate\Http\Response
    //   */
    //  public function destroy(RSwPoRB_v1 $rswporb)
    //  {
    //      //
    //  }
}
