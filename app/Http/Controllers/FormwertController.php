<?php

namespace App\Http\Controllers;

use App\Models\Formwert_v1;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class FormwertController extends Controller
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
            $ergebnis = Formwert_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new Formwert_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\Formwert_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['schulterhoehe']) {
                $ergebnis->schulterhoehe = $results['schulterhoehe'];
            }
            if ($results['zahnstatus_komplett']) {
                $ergebnis->zahnstatus_komplett = $results['zahnstatus_komplett'];
            }
            if ($results['zahnstatus_doppelt']) {
                $ergebnis->zahnstatus_doppelt = $results['zahnstatus_doppelt'];
            }
            if ($results['zahnstatus_doppelt_angaben']) {
                $ergebnis->zahnstatus_doppelt_angaben = $results['zahnstatus_doppelt_angaben'];
            }
            if ($results['zahnstatus_fehlt']) {
                $ergebnis->zahnstatus_fehlt = $results['zahnstatus_fehlt'];
            }
            if ($results['zahnstatus_fehlt_angaben']) {
                $ergebnis->zahnstatus_fehlt_angaben = $results['zahnstatus_fehlt_angaben'];
            }
            if ($results['zahnstatus_gebiss']) {
                $ergebnis->zahnstatus_gebiss_id = $results['zahnstatus_gebiss'];
            }
            //  if ( $results['zahnstatus_gebiss_r'] ) $ergebnis->zahnstatus_gebiss_r = $results['zahnstatus_gebiss_r'];
            if ($results['kopf']) {
                $ergebnis->kopf_id = $results['kopf'];
            }
            if ($results['oberkopf']) {
                $ergebnis->oberkopf_id = $results['oberkopf'];
            }
            if ($results['fang']) {
                $ergebnis->fang_id = $results['fang'];
            }
            if ($results['fang_kommentar']) {
                $ergebnis->fang_kommentar_id = $results['fang_kommentar'];
            }
            if ($results['stop']) {
                $ergebnis->stop_id = $results['stop'];
            }
            if ($results['pigment']) {
                $ergebnis->pigment_id = $results['pigment'];
            }
            if ($results['augen_form']) {
                $ergebnis->augen_form_id = $results['augen_form'];
            }
            if ($results['augen_farbe']) {
                $ergebnis->augen_farbe_id = $results['augen_farbe'];
            }
            if ($results['ausdruck']) {
                $ergebnis->ausdruck_id = $results['ausdruck'];
            }
            if ($results['oberlefzen']) {
                $ergebnis->oberlefzen_id = $results['oberlefzen'];
            }
            if ($results['unterlefzen']) {
                $ergebnis->unterlefzen_id = $results['unterlefzen'];
            }
            if ($results['behaenge']) {
                $ergebnis->behaenge_id = $results['behaenge'];
            }
            if ($results['hals']) {
                $ergebnis->hals_id = $results['hals'];
            }
            if ($results['brust']) {
                $ergebnis->brust_id = $results['brust'];
            }
            if ($results['brust_tiefe']) {
                $ergebnis->brust_tiefe_id = $results['brust_tiefe'];
            }
            if ($results['vorbrust']) {
                $ergebnis->vorbrust_id = $results['vorbrust'];
            }
            if ($results['lenden']) {
                $ergebnis->lenden_id = $results['lenden'];
            }
            if ($results['ruecken']) {
                $ergebnis->ruecken_id = $results['ruecken'];
            }
            if ($results['kruppe']) {
                $ergebnis->kruppe_id = $results['kruppe'];
            }
            if ($results['rute']) {
                $ergebnis->rute_id = $results['rute'];
            }
            if ($results['knochenstaerke']) {
                $ergebnis->knochenstaerke_id = $results['knochenstaerke'];
            }
            if ($results['vorderhand_laeufe']) {
                $ergebnis->vorderhand_laeufe_id = $results['vorderhand_laeufe'];
            }
            if ($results['vorderhand_laeufe_zusatzangaben']) {
                $ergebnis->vorderhand_laeufe_zusatzangaben = $results['vorderhand_laeufe_zusatzangaben'];
            }
            if ($results['vorderhand_schulter']) {
                $ergebnis->vorderhand_schulter_id = $results['vorderhand_schulter'];
            }
            if ($results['vorderhand_oberarm']) {
                $ergebnis->vorderhand_oberarm_id = $results['vorderhand_oberarm'];
            }
            if ($results['vorderhand_ellenbogen']) {
                $ergebnis->vorderhand_ellenbogen_id = $results['vorderhand_ellenbogen'];
            }
            if ($results['hinterhand_laeufe']) {
                $ergebnis->hinterhand_laeufe_id = $results['hinterhand_laeufe'];
            }
            if ($results['hinterhand_laeufe_zusatzangaben']) {
                $ergebnis->hinterhand_laeufe_zusatzangaben = $results['hinterhand_laeufe_zusatzangaben'];
            }
            if ($results['hinterhand_winkelung']) {
                $ergebnis->hinterhand_winkelung_id = $results['hinterhand_winkelung'];
            }
            if ($results['pfoten']) {
                $ergebnis->pfoten_id = $results['pfoten'];
            }
            if ($results['gangwerk_vorderhand_korrekt']) {
                $ergebnis->gangwerk_vorderhand_korrekt = $results['gangwerk_vorderhand_korrekt'];
            }
            if ($results['gangwerk_vorderhand_zusatzangaben']) {
                $ergebnis->gangwerk_vorderhand_zusatzangaben = $results['gangwerk_vorderhand_zusatzangaben'];
            }
            if ($results['gangwerk_hinterhand_korrekt']) {
                $ergebnis->gangwerk_hinterhand_korrekt = $results['gangwerk_hinterhand_korrekt'];
            }
            if ($results['gangwerk_hinterhand_kuhhessig']) {
                $ergebnis->gangwerk_hinterhand_kuhhessig = $results['gangwerk_hinterhand_kuhhessig'];
            }
            if ($results['gangwerk_hinterhand_zusatzangaben']) {
                $ergebnis->gangwerk_hinterhand_zusatzangaben = $results['gangwerk_hinterhand_zusatzangaben'];
            }
            if ($results['behaarung_deckhaar']) {
                $ergebnis->behaarung_deckhaar = $results['behaarung_deckhaar'];
            }
            if ($results['behaarung_unterwolle']) {
                $ergebnis->behaarung_unterwolle = $results['behaarung_unterwolle'];
            }
            if ($results['sonstige_beurteilung']) {
                $ergebnis->sonstige_beurteilung = $results['sonstige_beurteilung'];
            }
            if ($results['geschlaechterpraege']) {
                $ergebnis->geschlaechterpraege_id = $results['geschlaechterpraege'];
            }
            if ($results['hoden']) {
                $ergebnis->hoden_id = $results['hoden'];
            }
            if ($results['kondition']) {
                $ergebnis->kondition_id = $results['kondition'];
            }
            if ($results['kondition_zusatzangaben']) {
                $ergebnis->kondition_zusatzangaben = $results['kondition_zusatzangaben'];
            }
            if ($results['verhalten_aufdringlich']) {
                $ergebnis->verhalten_aufdringlich = $results['verhalten_aufdringlich'];
            }
            if ($results['verhalten_zutraulich']) {
                $ergebnis->verhalten_zutraulich = $results['verhalten_zutraulich'];
            }
            if ($results['verhalten_spielfreudig']) {
                $ergebnis->verhalten_spielfreudig = $results['verhalten_spielfreudig'];
            }
            if ($results['verhalten_neutral']) {
                $ergebnis->verhalten_neutral = $results['verhalten_neutral'];
            }
            if ($results['verhalten_gelassen']) {
                $ergebnis->verhalten_gelassen = $results['verhalten_gelassen'];
            }
            if ($results['verhalten_zurueckhaltend']) {
                $ergebnis->verhalten_zurueckhaltend = $results['verhalten_zurueckhaltend'];
            }
            if ($results['verhalten_ausweichend']) {
                $ergebnis->verhalten_ausweichend = $results['verhalten_ausweichend'];
            }
            if ($results['verhalten_unterwuerfig']) {
                $ergebnis->verhalten_unterwuerfig = $results['verhalten_unterwuerfig'];
            }
            if ($results['verhalten_aengstlich']) {
                $ergebnis->verhalten_aengstlich = $results['verhalten_aengstlich'];
            }
            if ($results['verhalten_scheu']) {
                $ergebnis->verhalten_scheu = $results['verhalten_scheu'];
            }
            if ($results['verhalten_unsicher']) {
                $ergebnis->verhalten_unsicher = $results['verhalten_unsicher'];
            }
            if ($results['verhalten_aggressiv']) {
                $ergebnis->verhalten_aggressiv = $results['verhalten_aggressiv'];
            }
            if ($results['verhalten_zusatzangaben']) {
                $ergebnis->verhalten_zusatzangaben = $results['verhalten_zusatzangaben'];
            }
            if ($results['gesamterscheinung']) {
                $ergebnis->gesamterscheinung_id = $results['gesamterscheinung'];
            }
            if ($results['zuchtzulassung']) {
                $ergebnis->zuchtzulassung = $results['zuchtzulassung'];
            }
            if ($results['ausschlussgrund']) {
                $ergebnis->ausschlussgrund = $results['ausschlussgrund'];
            }
            if ($results['ort']) {
                $ergebnis->ort = $results['ort'];
            }
            if ($results['datum']) {
                $ergebnis->datum = $results['datum'];
            }
            // if ( $results['zuchtrichter'] ) $ergebnis->zuchtrichter_id = $results['zuchtrichter'];
            // if ( $results['nummer'] ) $ergebnis->nummer = $results['nummer'];
            $ergebnis->save();

            return $ergebnis;
        } else {
            return 'ERROR: Keine Ergebnisse angegeben!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formwert  $formwert
     * @return \Illuminate\Http\Response
     */
    public function show(Formwert_v1 $formwert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Formwert  $formwert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formwert_v1 $formwert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formwert  $formwert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formwert_v1 $formwert)
    {
        //
    }
}
