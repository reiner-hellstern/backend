<?php

namespace App\Http\Controllers;

use App\Models\JAS_v1;
use App\Models\JAS_v2;
use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class JASController extends Controller
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
            $ergebnis = JAS_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new JAS_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\JAS_v1';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['verlorensuche_wald_arbeitseifer']) {
                $ergebnis->verlorensuche_wald_arbeitseifer_id = $results['verlorensuche_wald_arbeitseifer']['id'];
            }
            if ($results['verlorensuche_wald_arbeitseifer_kommentar']) {
                $ergebnis->verlorensuche_wald_arbeitseifer_kommentar = $results['verlorensuche_wald_arbeitseifer_kommentar'];
            }
            if ($results['verlorensuche_wald_finderwille']) {
                $ergebnis->verlorensuche_wald_finderwille_id = $results['verlorensuche_wald_finderwille']['id'];
            }
            if ($results['verlorensuche_wald_finderwille_kommentar']) {
                $ergebnis->verlorensuche_wald_finderwille_kommentar = $results['verlorensuche_wald_finderwille_kommentar'];
            }
            if ($results['verlorensuche_wald_selbststaendigkeit']) {
                $ergebnis->verlorensuche_wald_selbststaendigkeit_id = $results['verlorensuche_wald_selbststaendigkeit']['id'];
            }
            if ($results['verlorensuche_wald_selbststaendigkeit_kommentar']) {
                $ergebnis->verlorensuche_wald_selbststaendigkeit_kommentar = $results['verlorensuche_wald_selbststaendigkeit_kommentar'];
            }
            if ($results['verlorensuche_wald_nasengebrauch']) {
                $ergebnis->verlorensuche_wald_nasengebrauch_id = $results['verlorensuche_wald_nasengebrauch']['id'];
            }
            if ($results['verlorensuche_wald_nasengebrauch_kommentar']) {
                $ergebnis->verlorensuche_wald_nasengebrauch_kommentar = $results['verlorensuche_wald_nasengebrauch_kommentar'];
            }
            if ($results['verlorensuche_wald_koerperliche_haerte']) {
                $ergebnis->verlorensuche_wald_koerperliche_haerte_id = $results['verlorensuche_wald_koerperliche_haerte']['id'];
            }
            if ($results['verlorensuche_wald_koerperliche_haerte_kommentar']) {
                $ergebnis->verlorensuche_wald_koerperliche_haerte_kommentar = $results['verlorensuche_wald_koerperliche_haerte_kommentar'];
            }
            if ($results['verlorensuche_wald_kommentar']) {
                $ergebnis->verlorensuche_wald_kommentar = $results['verlorensuche_wald_kommentar'];
            }
            if ($results['verlorensuche_feld_arbeitseifer']) {
                $ergebnis->verlorensuche_feld_arbeitseifer_id = $results['verlorensuche_feld_arbeitseifer']['id'];
            }
            if ($results['verlorensuche_feld_arbeitseifer_kommentar']) {
                $ergebnis->verlorensuche_feld_arbeitseifer_kommentar = $results['verlorensuche_feld_arbeitseifer_kommentar'];
            }
            if ($results['verlorensuche_feld_finderwille']) {
                $ergebnis->verlorensuche_feld_finderwille_id = $results['verlorensuche_feld_finderwille']['id'];
            }
            if ($results['verlorensuche_feld_finderwille_kommentar']) {
                $ergebnis->verlorensuche_feld_finderwille_kommentar = $results['verlorensuche_feld_finderwille_kommentar'];
            }
            if ($results['verlorensuche_feld_selbststaendigkeit']) {
                $ergebnis->verlorensuche_feld_selbststaendigkeit_id = $results['verlorensuche_feld_selbststaendigkeit']['id'];
            }
            if ($results['verlorensuche_feld_selbststaendigkeit_kommentar']) {
                $ergebnis->verlorensuche_feld_selbststaendigkeit_kommentar = $results['verlorensuche_feld_selbststaendigkeit_kommentar'];
            }
            if ($results['verlorensuche_feld_nasengebrauch']) {
                $ergebnis->verlorensuche_feld_nasengebrauch_id = $results['verlorensuche_feld_nasengebrauch']['id'];
            }
            if ($results['verlorensuche_feld_nasengebrauch_kommentar']) {
                $ergebnis->verlorensuche_feld_nasengebrauch_kommentar = $results['verlorensuche_feld_nasengebrauch_kommentar'];
            }
            if ($results['verlorensuche_feld_fuehrigkeit']) {
                $ergebnis->verlorensuche_feld_fuehrigkeit_id = $results['verlorensuche_feld_fuehrigkeit']['id'];
            }
            if ($results['verlorensuche_feld_fuehrigkeit_kommentar']) {
                $ergebnis->verlorensuche_feld_fuehrigkeit_kommentar = $results['verlorensuche_feld_fuehrigkeit_kommentar'];
            }
            if ($results['verlorensuche_feld_koerperliche_haerte']) {
                $ergebnis->verlorensuche_feld_koerperliche_haerte_id = $results['verlorensuche_feld_koerperliche_haerte']['id'];
            }
            if ($results['verlorensuche_feld_koerperliche_haerte_kommentar']) {
                $ergebnis->verlorensuche_feld_koerperliche_haerte_kommentar = $results['verlorensuche_feld_koerperliche_haerte_kommentar'];
            }
            if ($results['verlorensuche_feld_kommentar']) {
                $ergebnis->verlorensuche_feld_kommentar = $results['verlorensuche_feld_kommentar'];
            }
            if ($results['schleppspur_arbeitseifer']) {
                $ergebnis->schleppspur_arbeitseifer_id = $results['schleppspur_arbeitseifer']['id'];
            }
            if ($results['schleppspur_arbeitseifer_kommentar']) {
                $ergebnis->schleppspur_arbeitseifer_kommentar = $results['schleppspur_arbeitseifer_kommentar'];
            }
            if ($results['schleppspur_kommentar']) {
                $ergebnis->schleppspur_kommentar = $results['schleppspur_kommentar'];
            }
            if ($results['schleppspur_finderwille']) {
                $ergebnis->schleppspur_finderwille_id = $results['schleppspur_finderwille']['id'];
            }
            if ($results['schleppspur_finderwille_kommentar']) {
                $ergebnis->schleppspur_finderwille_kommentar = $results['schleppspur_finderwille_kommentar'];
            }
            if ($results['schleppspur_selbststaendigkeit']) {
                $ergebnis->schleppspur_selbststaendigkeit_id = $results['schleppspur_selbststaendigkeit']['id'];
            }
            if ($results['schleppspur_selbststaendigkeit_kommentar']) {
                $ergebnis->schleppspur_selbststaendigkeit_kommentar = $results['schleppspur_selbststaendigkeit_kommentar'];
            }
            if ($results['schleppspur_nasengebrauch']) {
                $ergebnis->schleppspur_nasengebrauch_id = $results['schleppspur_nasengebrauch']['id'];
            }
            if ($results['schleppspur_nasengebrauch_kommentar']) {
                $ergebnis->schleppspur_nasengebrauch_kommentar = $results['schleppspur_nasengebrauch_kommentar'];
            }
            // if ( $results['schleppspur_fuehrigkeit'] ) $ergebnis->schleppspur_fuehrigkeit_id = $results['schleppspur_fuehrigkeit']['id'];
            // if ( $results['schleppspur_fuehrigkeit_kommentar'] ) $ergebnis->schleppspur_fuehrigkeit_kommentar = $results['schleppspur_fuehrigkeit_kommentar'];
            if ($results['schleppspur_koerperliche_haerte']) {
                $ergebnis->schleppspur_koerperliche_haerte_id = $results['schleppspur_koerperliche_haerte']['id'];
            }
            if ($results['schleppspur_koerperliche_haerte_kommentar']) {
                $ergebnis->schleppspur_koerperliche_haerte_kommentar = $results['schleppspur_koerperliche_haerte_kommentar'];
            }
            if ($results['schleppspur_spurwille']) {
                $ergebnis->schleppspur_spurwille_id = $results['schleppspur_spurwille']['id'];
            }
            if ($results['schleppspur_spurwille_kommentar']) {
                $ergebnis->schleppspur_spurwille_kommentar = $results['schleppspur_spurwille_kommentar'];
            }
            if ($results['schleppspur_kommentar']) {
                $ergebnis->schleppspur_kommentar = $results['schleppspur_kommentar'];
            }
            if ($results['wasser_arbeitseifer']) {
                $ergebnis->wasser_arbeitseifer_id = $results['wasser_arbeitseifer']['id'];
            }
            if ($results['wasser_arbeitseifer_kommentar']) {
                $ergebnis->wasser_arbeitseifer_kommentar = $results['wasser_arbeitseifer_kommentar'];
            }
            if ($results['wasser_finderwille']) {
                $ergebnis->wasser_finderwille_id = $results['wasser_finderwille']['id'];
            }
            if ($results['wasser_finderwille_kommentar']) {
                $ergebnis->wasser_finderwille_kommentar = $results['wasser_finderwille_kommentar'];
            }
            if ($results['wasser_selbststaendigkeit']) {
                $ergebnis->wasser_selbststaendigkeit_id = $results['wasser_selbststaendigkeit']['id'];
            }
            if ($results['wasser_selbststaendigkeit_kommentar']) {
                $ergebnis->wasser_selbststaendigkeit_kommentar = $results['wasser_selbststaendigkeit_kommentar'];
            }
            if ($results['wasser_nasengebrauch']) {
                $ergebnis->wasser_nasengebrauch_id = $results['wasser_nasengebrauch']['id'];
            }
            if ($results['wasser_nasengebrauch_kommentar']) {
                $ergebnis->wasser_nasengebrauch_kommentar = $results['wasser_nasengebrauch_kommentar'];
            }
            if ($results['wasser_arbeitsruhe']) {
                $ergebnis->wasser_arbeitsruhe_id = $results['wasser_arbeitsruhe']['id'];
            }
            if ($results['wasser_arbeitsruhe_kommentar']) {
                $ergebnis->wasser_arbeitsruhe_kommentar = $results['wasser_arbeitsruhe_kommentar'];
            }
            if ($results['wasser_fuehrigkeit']) {
                $ergebnis->wasser_fuehrigkeit_id = $results['wasser_fuehrigkeit']['id'];
            }
            if ($results['wasser_fuehrigkeit_kommentar']) {
                $ergebnis->wasser_fuehrigkeit_kommentar = $results['wasser_fuehrigkeit_kommentar'];
            }
            if ($results['wasser_koerperliche_haerte']) {
                $ergebnis->wasser_koerperliche_haerte_id = $results['wasser_koerperliche_haerte']['id'];
            }
            if ($results['wasser_koerperliche_haerte_kommentar']) {
                $ergebnis->wasser_koerperliche_haerte_kommentar = $results['wasser_koerperliche_haerte_kommentar'];
            }
            if ($results['wasser_wasserfreude']) {
                $ergebnis->wasser_wasserfreude_id = $results['wasser_wasserfreude']['id'];
            }
            if ($results['wasser_wasserfreude_kommentar']) {
                $ergebnis->wasser_wasserfreude_kommentar = $results['wasser_wasserfreude_kommentar'];
            }
            if ($results['wasser_kommentar']) {
                $ergebnis->wasser_kommentar = $results['wasser_kommentar'];
            }
            if ($results['markierung_finderwille']) {
                $ergebnis->markierung_finderwille_id = $results['markierung_finderwille']['id'];
            }
            if ($results['markierung_finderwille_kommentar']) {
                $ergebnis->markierung_finderwille_kommentar = $results['markierung_finderwille_kommentar'];
            }
            if ($results['markierung_nasengebrauch']) {
                $ergebnis->markierung_nasengebrauch_id = $results['markierung_nasengebrauch']['id'];
            }
            if ($results['markierung_nasengebrauch_kommentar']) {
                $ergebnis->markierung_nasengebrauch_kommentar = $results['markierung_nasengebrauch_kommentar'];
            }
            if ($results['markierung_arbeitsruhe']) {
                $ergebnis->markierung_arbeitsruhe_id = $results['markierung_arbeitsruhe']['id'];
            }
            if ($results['markierung_arbeitsruhe_kommentar']) {
                $ergebnis->markierung_arbeitsruhe_kommentar = $results['markierung_arbeitsruhe_kommentar'];
            }
            if ($results['markierung_koerperliche_haerte']) {
                $ergebnis->markierung_koerperliche_haerte_id = $results['markierung_koerperliche_haerte']['id'];
            }
            if ($results['markierung_koerperliche_haerte_kommentar']) {
                $ergebnis->markierung_koerperliche_haerte_kommentar = $results['markierung_koerperliche_haerte_kommentar'];
            }
            if ($results['markierung_konzentration']) {
                $ergebnis->markierung_konzentration_id = $results['markierung_konzentration']['id'];
            }
            if ($results['markierung_konzentration_kommentar']) {
                $ergebnis->markierung_konzentration_kommentar = $results['markierung_konzentration_kommentar'];
            }
            if ($results['markierung_einschaetzung_entfernung']) {
                $ergebnis->markierung_einschaetzung_entfernung_id = $results['markierung_einschaetzung_entfernung']['id'];
            }
            if ($results['markierung_einschaetzung_entfernung_kommentar']) {
                $ergebnis->markierung_einschaetzung_entfernung_kommentar = $results['markierung_einschaetzung_entfernung_kommentar'];
            }
            if ($results['markierung_kommentar']) {
                $ergebnis->markierung_kommentar = $results['markierung_kommentar'];
            }
            if ($results['kommentar']) {
                $ergebnis->kommentar = $results['kommentar'];
            }
            if ($results['schussfestigkeit']) {
                $ergebnis->schussfestigkeit_id = $results['schussfestigkeit']['id'];
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
            if ($results['empfehlung_wesenstest']) {
                $ergebnis->empfehlung_wesenstest = $results['empfehlung_wesenstest'];
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
            $ergebnis = JAS_v2::find($meldung->resultable_id);
        } else {
            $ergebnis = new JAS_v2();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\JAS_v2';
            $meldung->save();
        }
        if ($request->ergebnis) {
            $results = $request->ergebnis;
            if ($results['ausbildungsstand']) {
                $ergebnis->ausbildungsstand = $results['ausbildungsstand'];
            }
            if ($results['art_des_zutragens']) {
                $ergebnis->art_des_zutragens = $results['art_des_zutragens'];
            }
            if ($results['standruhe']) {
                $ergebnis->standruhe = $results['standruhe'];
            }
            if ($results['aufnahme_haarnutzwild']) {
                $ergebnis->aufnahme_haarnutzwild = $results['aufnahme_haarnutzwild'];
            }
            if ($results['aufnahme_federwild']) {
                $ergebnis->aufnahme_federwild = $results['aufnahme_federwild'];
            }
            if ($results['aufnahme_sonstiges_wild']) {
                $ergebnis->aufnahme_sonstiges_wild = $results['aufnahme_sonstiges_wild'];
            }
            if ($results['aufnahme_sonstiges_wild_angaben']) {
                $ergebnis->aufnahme_sonstiges_wild_angaben = $results['aufnahme_sonstiges_wild_angaben'];
            }
            if ($results['arbeitseifer']) {
                $ergebnis->arbeitseifer_id = $results['arbeitseifer']['id'];
            }
            if ($results['arbeitseifer_kommentar']) {
                $ergebnis->arbeitseifer_kommentar = $results['arbeitseifer_kommentar'];
            }
            if ($results['finderwille']) {
                $ergebnis->finderwille_id = $results['finderwille']['id'];
            }
            if ($results['finderwille_kommentar']) {
                $ergebnis->finderwille_kommentar = $results['finderwille_kommentar'];
            }
            if ($results['selbststaendigkeit']) {
                $ergebnis->selbststaendigkeit_id = $results['selbststaendigkeit']['id'];
            }
            if ($results['selbststaendigkeit_kommentar']) {
                $ergebnis->selbststaendigkeit_kommentar = $results['selbststaendigkeit_kommentar'];
            }
            if ($results['nasengebrauch']) {
                $ergebnis->nasengebrauch_id = $results['nasengebrauch']['id'];
            }
            if ($results['nasengebrauch_kommentar']) {
                $ergebnis->nasengebrauch_kommentar = $results['nasengebrauch_kommentar'];
            }
            if ($results['koerperliche_haerte']) {
                $ergebnis->koerperliche_haerte_id = $results['koerperliche_haerte']['id'];
            }
            if ($results['koerperliche_haerte_kommentar']) {
                $ergebnis->koerperliche_haerte_kommentar = $results['koerperliche_haerte_kommentar'];
            }
            if ($results['arbeitsruhe']) {
                $ergebnis->arbeitsruhe_id = $results['arbeitsruhe']['id'];
            }
            if ($results['arbeitsruhe_kommentar']) {
                $ergebnis->arbeitsruhe_kommentar_id = $results['arbeitsruhe_kommentar'];
            }
            if ($results['spurwille']) {
                $ergebnis->spurwille_id = $results['spurwille']['id'];
            }
            if ($results['spurwille_kommentar']) {
                $ergebnis->spurwille_kommentar = $results['spurwille_kommentar'];
            }
            if ($results['wasserfreude']) {
                $ergebnis->wasserfreude_id = $results['wasserfreude']['id'];
            }
            if ($results['wasserfreude_kommentar']) {
                $ergebnis->wasserfreude_kommentar = $results['wasserfreude_kommentar'];
            }
            if ($results['fuehrigkeit']) {
                $ergebnis->fuehrigkeit_id = $results['fuehrigkeit']['id'];
            }
            if ($results['fuehrigkeit_kommentar']) {
                $ergebnis->fuehrigkeit_kommentar = $results['fuehrigkeit_kommentar'];
            }
            if ($results['konzentration']) {
                $ergebnis->konzentration_id = $results['konzentration']['id'];
            }
            if ($results['konzentration_kommentar']) {
                $ergebnis->konzentration_kommentar = $results['konzentration_kommentar'];
            }
            if ($results['einschaetzung_entfernung']) {
                $ergebnis->einschaetzung_entfernung_id = $results['einschaetzung_entfernung']['id'];
            }
            if ($results['einschaetzung_entfernung_kommentar']) {
                $ergebnis->einschaetzung_entfernung_kommentar = $results['einschaetzung_entfernung_kommentar'];
            }
            if ($results['schussfestigkeit']) {
                $ergebnis->schussfestigkeit_id = $results['schussfestigkeit']['id'];
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
                $ergebnis->sonstige_wesenverhalten = $results['sonstige_wesenverhalten'];
            }
            if ($results['sonstige_wesenverhalten_handscheu']) {
                $ergebnis->sonstige_wesenverhalten_handscheu = $results['sonstige_wesenverhalten_handscheu'];
            }
            if ($results['sonstige_wesenverhalten_wildscheu']) {
                $ergebnis->sonstige_wesenverhalten_wildscheu = $results['sonstige_wesenverhalten_wildscheu'];
            }
            if ($results['empfehlung_wesenstest']) {
                $ergebnis->empfehlung_wesenstest = $results['empfehlung_wesenstest'];
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
            if ($results['praedikat']) {
                $ergebnis->praedikat_id = $results['praedikat']['id'];
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
     * @return \Illuminate\Http\Response
     */
    public function show(JAS_v1 $jAS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JAS_v1 $jAS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(JAS_v1 $jAS)
    {
        //
    }
}
