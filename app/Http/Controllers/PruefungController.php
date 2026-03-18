<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePruefungRequest;
use App\Http\Requests\UpdatePruefungRequest;
use App\Models\Hund;
use App\Models\Pruefung;
use App\Models\PruefungsergebnisGenerisch;
use App\Models\PruefungTyp;
use Illuminate\Http\Request;

class PruefungController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Models\Pruefung  $pruefung
     * @return \Illuminate\Http\Response
     */
    public function hund(Hund $hund)
    {
        $pruefungen = Pruefung::with(['resultable', 'pruefungtyp'])->where('hund_id', $hund->id)->orderBy('datum', 'DESC')->get();

        return $pruefungen;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Pruefung $pruefung)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePruefungRequest $request, Pruefung $pruefung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePruefungRequest $request, Pruefung $pruefung)
    {

        $db_pruefung = Pruefung::find($request->id);
        $db_ergebnis = PruefungsergebnisGenerisch::find($db_pruefung->resultable_id);

        $db_ergebnis->praedikat = $request['resultable']['praedikat'];
        $db_ergebnis->punkte = $request['resultable']['punkte'];
        $db_ergebnis->datum = $request['resultable']['datum'];
        $db_ergebnis->ort = $request['resultable']['ort'];
        $db_ergebnis->platzierung = $request['resultable']['platzierung'];

        $db_ergebnis->save();
        $db_pruefung->wertung_id = $request['wertung']['id'];
        $db_pruefung->classement_id = $request['classement']['id'];
        $db_pruefung->ausrichter_id = $request['ausrichter']['id'];
        $db_pruefung->zusatz_id = $request['zusatz']['id'];
        $db_pruefung->type_id = $request->type_id;
        $db_pruefung->name = $request->name;
        $db_pruefung->name_kurz = $request->name_kurz;
        $db_pruefung->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pruefung $pruefung)
    {
        $pruefung->delete();

        return response()->json([
            'success' => 'Prüfung gelöscht.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function meldung_store(StorePruefungRequest $request, Pruefung $pruefung)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function meldung_show(Pruefung $pruefung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function meldung_destroy(Pruefung $pruefung)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_string(Request $request)
    {

        // Prfg.m.leb.Ente(HZP) WD WDX Markpr.B(beg.kl.-1.pr.) Markpr.B(aben.kl.-1.pr.) Workingtest(E)(ÖRC) Workingtest(aben)(DK) div.Workingtests(F) LN SwP/o.Rb.Bronzenes-Siegel LSP R/SwP 1. Preis Langschl.(800m) WDX WDQ NCT'15 GC'22 div.Workingtests(O) B-Diplom(KNJV) C-Diplom(CBRN) B-Diplom(CBRN) WD WDX OB-beg./1/2 div.Workingtests(B2)(NL)
        $content = $request->pruefungenstring;

        $hund_id = 0;
        $pruefungstypen = PruefungTyp::with('ausrichters', 'zusaetze', 'classements', 'wertungen')->where('regex', '!=', '')->get();
        $erkannte_pruefungen = [];

        $pruefungen = [];
        $erkannte_pruefungen = [];
        $content_rest = '';

        foreach ($pruefungstypen as $pruefungstyp) {

            // SECTION STANDARD PRÜFUNGSTYPEN MIT EINFACHEN, NICHT VERSCHACHTELTEN WIEDERHOLUNGEN
            //   text{A1/A2/A3...AX}text{B1/B2/B3...BX}text...
            if ($pruefungstyp['regex'] && ! $pruefungstyp['regex_type']) {
                for ($i = 0; $i < 5 && (trim($content) != ''); $i++) {
                    // echo "_________________________________________________\n";
                    // echo "CONTENT: ".$content . "\n";
                    // echo "REGEX: " . $pruefungstyp['regex'] . "\n";

                    $pruefung_id = 0;
                    $pruefung_name = 'NICHT GEFUNDEN';

                    preg_match('/' . $pruefungstyp['regex'] . '/', $content, $matches);

                    $wertungen = [];
                    $klassen = [];
                    $jahre = [];
                    $zusaetze = [];
                    $ausrichters = [];
                    $wertungen_ids = [];
                    $klassen_ids = [];
                    $jahre = [];
                    $zusaetze_ids = [];
                    $ausrichters_ids = [];

                    if ($matches) {
                        //  return $matches;

                        $content_pre = $content;

                        //  $content = str_replace($matches[0], ' ', $content);

                        $pattern = trim(preg_quote($matches[0], '/'));

                        $content = preg_replace("/(^|[\s])" . $pattern . "($|[\s])/", ' ', $content);

                        $content = trim(str_replace('  ', ' ', $content));

                        $pruefung_id = $pruefungstyp['id'];
                        $pruefung_name = $pruefungstyp['name'];
                        $pruefung_name_kurz = '';

                        // if ( $pruefungstyp['klasse_matchindex'] && $pruefungstyp['bewertung_matchindex'] ) {
                        if ($pruefungstyp['classement_matchindex']) {

                            if (array_key_exists($pruefungstyp['classement_matchindex'], $matches) && $matches[$pruefungstyp['classement_matchindex']]) {

                                if ($pruefungstyp['classement_separator']) {
                                    // MEHRERE MÖGLICHE KLASSEN
                                    $klassen = explode($pruefungstyp['classement_separator'], $matches[$pruefungstyp['classement_matchindex']]);
                                } else {
                                    // EINE MÖGLICHE KLASSE
                                    $klassen[] = $matches[$pruefungstyp['classement_matchindex']];
                                }

                                foreach ($klassen as $klasse) {
                                    if ($klasse == '') {
                                        $klassen_ids[] = 1;
                                    } elseif (count($pruefungstyp['classements'])) {

                                        foreach ($pruefungstyp['classements'] as $pt_klasse) {

                                            if ($klasse == $pt_klasse['name_kurz']) {
                                                $klassen_ids[] = $pt_klasse['id'];
                                            }
                                        }
                                    }
                                }
                            } else {
                                // KEINE KLASSEN
                                $klassen = [];
                                $klassen_ids = [0];
                            }
                        }

                        if ($pruefungstyp['ausrichter_matchindex']) {

                            if (array_key_exists($pruefungstyp['ausrichter_matchindex'], $matches) && ($matches[$pruefungstyp['ausrichter_matchindex']])) {

                                if ($pruefungstyp['ausrichter_separator']) {
                                    $ausrichters = explode($pruefungstyp['ausrichter_separator'], $matches[$pruefungstyp['ausrichter_matchindex']]);
                                } else {
                                    $ausrichters[] = $matches[$pruefungstyp['ausrichter_matchindex']];
                                }

                                foreach ($ausrichters as $ausrichter) {
                                    if (count($pruefungstyp['ausrichters'])) {

                                        foreach ($pruefungstyp['ausrichters'] as $pt_ausrichter) {

                                            if ($ausrichter == $pt_ausrichter['name_kurz']) {
                                                $ausrichters_ids[] = $pt_ausrichter['id'];
                                            }
                                        }
                                    }
                                }
                            } else {
                                $ausrichters_ids = [0];
                                $ausrichters = [];
                            }
                        }

                        if ($pruefungstyp['wertung_matchindex']) {

                            if (array_key_exists($pruefungstyp['wertung_matchindex'], $matches) && $matches[$pruefungstyp['wertung_matchindex']]) {

                                if ($pruefungstyp['wertung_separator']) {
                                    $wertungen = explode($pruefungstyp['wertung_separator'], $matches[$pruefungstyp['wertung_matchindex']]);
                                } else {
                                    $wertungen[] = $matches[$pruefungstyp['wertung_matchindex']];
                                }

                                foreach ($wertungen as $wertung) {

                                    if (count($pruefungstyp['wertungen'])) {

                                        foreach ($pruefungstyp['wertungen'] as $pt_wertung) {

                                            if ($wertung == $pt_wertung['name_kurz']) {
                                                $wertungen_ids[] = $pt_wertung['id'];
                                            }
                                        }
                                    }
                                }
                            } else {
                                $wertungen = [];
                                $wertungen_ids = [0];
                            }
                        }

                        if ($pruefungstyp['zusatz_matchindex']) {

                            if ($matches[$pruefungstyp['zusatz_matchindex']]) {

                                if ($pruefungstyp['zusatz_separator']) {
                                    $zusaetze = explode($pruefungstyp['zusatz_separator'], $matches[$pruefungstyp['zusatz_matchindex']]);
                                } else {
                                    $zusaetze[] = $matches[$pruefungstyp['zusatz_matchindex']];
                                }

                                foreach ($zusaetze as $zusatz) {
                                    if (count($pruefungstyp['zusaetze'])) {
                                        foreach ($pruefungstyp['zusaetze'] as $pt_zusatz) {
                                            if ($zusatz == $pt_zusatz['name_kurz']) {
                                                $zusaetze_ids[] = $pt_zusatz['id'];
                                            }
                                        }
                                    }
                                }
                            } else {
                                $zusaetze = [];
                                $zusaetze_ids = [0];
                            }
                        }

                        if ($pruefungstyp['jahr_matchindex']) {

                            if ($matches[$pruefungstyp['jahr_matchindex']]) {

                                if ($pruefungstyp['jahr_separator']) {
                                    $jahre = explode($pruefungstyp['jahr_separator'], $matches[$pruefungstyp['jahr_matchindex']]);
                                } else {
                                    $jahre[] = $matches[$pruefungstyp['jahr_matchindex']];
                                }
                            } else {
                                $jahre = [];
                            }
                        }

                        if (count($wertungen) || count($ausrichters) || count($zusaetze) || count($klassen)) {

                            $matchmatrix = [];

                            $matchmatrix['id'] = [$pruefung_id];
                            $matchmatrix['name'] = [$pruefung_name];
                            $matchmatrix['classement'] = count($klassen) ? $klassen_ids : ['0'];
                            $matchmatrix['ausrichter'] = count($ausrichters) ? $ausrichters_ids : ['0'];
                            $matchmatrix['wertung'] = count($wertungen) ? $wertungen_ids : ['0'];
                            $matchmatrix['zusatz'] = count($zusaetze) ? $zusaetze_ids : ['0'];
                            $matchmatrix['jahr'] = ['0'];

                            $erkannte_pruefungen = array_merge($erkannte_pruefungen, $this->cartesian($matchmatrix));
                        } else {

                            if (count($jahre)) {
                                foreach ($jahre as $jahr) {
                                    $erkannte_pruefungen[] = [
                                        'id' => $pruefung_id,
                                        'name' => $pruefung_name,
                                        'classement' => 0,
                                        'ausrichter' => 0,
                                        'wertung' => 0,
                                        'zusatz' => 0,
                                        'jahr' => $jahr,

                                    ];
                                }
                            } else {
                                $erkannte_pruefungen[] = [
                                    'id' => $pruefung_id,
                                    'name' => $pruefung_name,
                                    'classement' => 0,
                                    'ausrichter' => 0,
                                    'wertung' => 0,
                                    'zusatz' => 0,
                                    'jahr' => 0,
                                ];
                            }
                        }
                        // $pruefungen[] = $pruefung_id . " - " . $pruefung_name;

                    } else {
                        $i = 10;
                        // echo "nicht gfunden\n";
                    }
                }
            }
            //!SECTION ENDE STANDARD REGEX-TYPEN

            // SECTION NICHT STANDARD-TYPEN, DIE
            // - Informationen in der Position führen: VFsP{/}{PREISZIFFER}{/}
            // - verschachtelte Varianten haben: z.B.  B-Prov\.{(KLASSE-PREISZIFFER.pr.)/(KLASSE-PREISZIFFER.pr.)*}\(NO\)
            // if ($pruefungstyp['regex'] && $pruefungstyp['regex_type'] >= 2 && $content != '') {

            //    for ($i = 0; $i < 15 && trim($content); $i++) {

            //       $pruefung_id = 0;
            //       $pruefung_name = 'NICHT GEFUNDEN';

            //       preg_match("/" . $pruefungstyp['regex'] . "/",  $content, $matches1);

            //       if ($matches1) {

            //          $content_pre = $content;
            //          $content = str_replace($matches1[0], ' ', $content);
            //          $content = trim(str_replace('  ', ' ', $content));

            //          $pruefung_id = $pruefungstyp['id'];
            //          $pruefung_name = $pruefungstyp['name'];
            //          $pruefung_name_kurz = '';

            //          $klasse = 0;
            //          $wertung = 0;

            //          // TYP:  Fährtensuche/Schweißprüfung
            //          if ($pruefungstyp['regex_type'] == 1) {
            //          }

            //          // TYP:
            //          // z.B. TJP(nkl./ökl.-3.pr./ekl.)(SE)
            //          if ($pruefungstyp['regex_type'] == 2) {

            //             $pruefungen = explode('/', $matches1[3]);

            //             if (!(count($pruefungen) == 1 && $pruefungen[0] == '')) {

            //                foreach ($pruefungen as $pruefung) {

            //                   $klasse = '';
            //                   $wertung = '';
            //                   $classement_id = 'NULL';
            //                   $wertung_id = 'NULL';

            //                   preg_match("/([ÄÖÜäöü\w\. ]*){0,1}(\-([\d])\.pr\.){0,1}/",  $pruefung, $matches2);
            //                   if (array_key_exists(1, $matches2)) $klasse = $matches2[1];
            //                   if (array_key_exists(3, $matches2)) $wertung = $matches2[3];

            //                   if ($wertung == '') {
            //                      // KEINE ANGABE ?
            //                      $wertung_id = 1;
            //                   } else if (array_key_exists($pruefung_id, $wertungenmatrix)) {

            //                      if (!array_key_exists($wertung, $wertungenmatrix[$pruefung_id])) {
            //                         // print_r($wertungenmatrix);
            //                         $errors[] = [

            //                            'Hund-ID' => $hund['hund_id'],
            //                            'Name' => $hund['NAME'],
            //                            'Bemerkung' => $hund['BEMERKUNG'],
            //                            'Content Pre' => $content_pre,
            //                            'Content Post' => $content,
            //                            'regex' => $pruefungstyp['regex'],
            //                            'matchindex' => $pruefungstyp['wertung_matchindex'],
            //                            'separator' => $pruefungstyp['wertung_separator'],
            //                            'Wertungen' => $pruefungstyp['wertung_optionen'],
            //                            'Wertung' => $wertung,
            //                            'P-ID' => $pruefung_id,
            //                            'P-Name' => $pruefung_name,
            //                            'Matches' => $matches
            //                         ];
            //                      } else {
            //                         $wertung_id = $wertungenmatrix[$pruefung_id][$wertung]['id'];
            //                      }
            //                   }

            //                   if ($klasse == '') {
            //                      // KEINE ANGABE
            //                      $classement_id = 1;
            //                   } else if (array_key_exists($pruefung_id, $klassenmatrix)) {
            //                      if (!array_key_exists($klasse, $klassenmatrix[$pruefung_id])) {
            //                         $errors[] = [

            //                            'Hund-ID' => $hund['hund_id'],
            //                            'Name' => $hund['NAME'],
            //                            'Bemerkung' => $hund['BEMERKUNG'],
            //                            'Content Pre' => $content_pre,
            //                            'Content Post' => $content,
            //                            'regex' => $pruefungstyp['regex'],
            //                            'matchindex' => $pruefungstyp['classement_matchindex'],
            //                            'separator' => $pruefungstyp['classement_separator'],
            //                            'Classements' => $pruefungstyp['classement_optionen'],
            //                            'Classement' => $klasse,
            //                            'P-ID' => $pruefung_id,
            //                            'P-Name' => $pruefung_name,
            //                            'Matches' => $matches
            //                         ];
            //                      } else {
            //                         $classement_id = $klassenmatrix[$pruefung_id][$klasse]['id'];
            //                      }
            //                   }

            //                   $erkannte_pruefungen[] = [
            //                      'id' => $pruefung_id,
            //                      'name' => $pruefung_name,
            //                      'name_kurz' => $pruefung_name_kurz,
            //                      'classement' => $classement_id,
            //                      'ausrichter' => 0,
            //                      'wertung' => $wertung_id,
            //                      'zusatz' => 0,
            //                      'jahr' => 0
            //                   ];
            //                }
            //             } else {
            //                $erkannte_pruefungen[] = [
            //                   'id' => $pruefung_id,
            //                   'name' => $pruefung_name,
            //                   'name_kurz' => $pruefung_name_kurz,
            //                   'classement' => 0,
            //                   'ausrichter' => 0,
            //                   'wertung' => 0,
            //                   'zusatz' => 0,
            //                   'jahr' => 0
            //                ];
            //             }
            //          }

            //          // TYP:  {(KLASSE-PREISZIFFER.pr.)*}
            //          // z.B. (^|[\s])B\-Prov\.(\((([\w\d\.\-]*\)\([\w\d\.\-]*)*)\)){0,1}\(NO\)($|[\s])";

            //          if ($pruefungstyp['regex_type'] == 3) {

            //             $pruefungen = explode(')(', $matches1[3]);

            //             if (!(count($pruefungen) == 1 && $pruefungen[0] == '')) {

            //                foreach ($pruefungen as $pruefung) {

            //                   $klasse = '';
            //                   $wertung = '';
            //                   $classement_id = 'NULL';
            //                   $wertung_id = 'NULL';

            //                   preg_match("/([ÄÖÜäöü\w\. ]*){0,1}(\-([\d])\.pr\.){0,1}/",  $pruefung, $matches2);
            //                   if (array_key_exists(1, $matches2)) $klasse = $matches2[1];
            //                   if (array_key_exists(3, $matches2)) $wertung = $matches2[3];

            //                   if ($wertung == '') {
            //                      // KEINE ANGABE ?
            //                      $wertung_id = 1;
            //                   } else if (array_key_exists($pruefung_id, $wertungenmatrix)) {

            //                      if (!array_key_exists($wertung, $wertungenmatrix[$pruefung_id])) {
            //                         // print_r($wertungenmatrix);
            //                         $errors[] = [

            //                            'Hund-ID' => $hund['hund_id'],
            //                            'Name' => $hund['NAME'],
            //                            'Bemerkung' => $hund['BEMERKUNG'],
            //                            'Content Pre' => $content_pre,
            //                            'Content Post' => $content,
            //                            'regex' => $pruefungstyp['regex'],
            //                            'matchindex' => $pruefungstyp['wertung_matchindex'],
            //                            'separator' => $pruefungstyp['wertung_separator'],
            //                            'Wertungen' => $pruefungstyp['wertung_optionen'],
            //                            'Wertung' => $wertung,
            //                            'P-ID' => $pruefung_id,
            //                            'P-Name' => $pruefung_name,
            //                            'Matches' => $matches
            //                         ];
            //                      } else {
            //                         $wertung_id = $wertungenmatrix[$pruefung_id][$wertung]['id'];
            //                      }
            //                   }

            //                   if ($klasse == '') {
            //                      // KEINE ANGABE
            //                      $classement_id = 1;
            //                   } else if (array_key_exists($pruefung_id, $klassenmatrix)) {
            //                      if (!array_key_exists($klasse, $klassenmatrix[$pruefung_id])) {
            //                         $errors[] = [

            //                            'Hund-ID' => $hund['hund_id'],
            //                            'Name' => $hund['NAME'],
            //                            'Bemerkung' => $hund['BEMERKUNG'],
            //                            'Content Pre' => $content_pre,
            //                            'Content Post' => $content,
            //                            'regex' => $pruefungstyp['regex'],
            //                            'matchindex' => $pruefungstyp['classement_matchindex'],
            //                            'separator' => $pruefungstyp['classement_separator'],
            //                            'Classements' => $pruefungstyp['classement_optionen'],
            //                            'Classement' => $klasse,
            //                            'P-ID' => $pruefung_id,
            //                            'P-Name' => $pruefung_name,
            //                            'Matches' => $matches
            //                         ];
            //                      } else {
            //                         $classement_id = $klassenmatrix[$pruefung_id][$klasse]['id'];
            //                      }
            //                   }

            //                   $erkannte_pruefungen[] = [
            //                      'id' => $pruefung_id,
            //                      'name' => $pruefung_name,
            //                      'name_kurz' => $pruefung_name_kurz,
            //                      'classement' => $classement_id,
            //                      'ausrichter' => 0,
            //                      'wertung' => $wertung_id,
            //                      'zusatz' => 0,
            //                      'jahr' => 0
            //                   ];
            //                }
            //             } else {
            //                $erkannte_pruefungen[] = [
            //                   'id' => $pruefung_id,
            //                   'name' => $pruefung_name,
            //                   'name_kurz' => $pruefung_name_kurz,
            //                   'classement' => 0,
            //                   'ausrichter' => 0,
            //                   'wertung' => 0,
            //                   'zusatz' => 0,
            //                   'jahr' => 0
            //                ];
            //             }
            //          }
            //       } else {
            //          $i = 100;
            //          // echo "nicht gfunden\n";
            //       }
            //    }
            // }
            //!SECTION NICHT STANDARD-TYPEN,

            // echo "------------------------------------------------\n";
            // echo $hund['BEMERKUNG'] . "\n";
        }

        $content_rest = $content_rest . ' ' . $content;

        return [
            'pruefungen' => $erkannte_pruefungen,
            'unerkannt' => $content,
            // 'typen' => $pruefungstypen
        ];
    }

    public function cartesian(array $input)
    {
        $result = [[]];
        foreach ($input as $key => $values) {
            $append = [];
            foreach ($values as $value) {
                foreach ($result as $data) {
                    $append[] = $data + [$key => $value];
                }
            }
            $result = $append;
        }

        return $result;
    }
}
