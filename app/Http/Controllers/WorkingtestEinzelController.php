<?php

namespace App\Http\Controllers;

use App\Models\VeranstaltungMeldung;
use App\Models\WorkingtestEinzel_v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkingtestEinzelController extends Controller
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

        $input = $request->all();

        $user_id = Auth::id();
        $isAllowed = true;

        foreach ($input as $m) {

            if ($m['meldung_id']) {
                $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($m['meldung_id']);
            } else {
                return 'ERROR: ID-Meldung fehlt';
            }

            if (! $meldung) {
                return 'ERROR: Keine passende Meldung gefunden';
            }

            if ($meldung->resultable_id) {
                $ergebnis = WorkingtestEinzel_v1::find($meldung->resultable_id);
            } else {
                $ergebnis = new WorkingtestEinzel_v1();
                $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
                // $ergebnis->hund_id = $meldung->hund->id;
                $ergebnis->hund_id = $meldung->hund_id;
                $ergebnis->save();
                $meldung->resultable_id = $ergebnis->id;
                $meldung->resultable_type = 'App\Models\WorkingtestEinzel_v1';
                $meldung->save();
            }
            if ($m['ergebnis']) {
                $results = $m['ergebnis']['aufgaben'];
                if (isset($results[0]) && $isAllowed) {
                    if ($ergebnis->a1 != $results[0]['punkte']) {
                        $ergebnis->a1 = $results[0]['punkte'];
                        $ergebnis->r1_id = $user_id;
                    }
                }
                if (isset($results[1]) && $isAllowed) {
                    if ($ergebnis->a2 != $results[1]['punkte']) {
                        $ergebnis->a2 = $results[1]['punkte'];
                        $ergebnis->r2_id = $user_id;
                    }
                }
                if (isset($results[2]) && $isAllowed) {
                    if ($ergebnis->a3 != $results[2]['punkte']) {
                        $ergebnis->a3 = $results[2]['punkte'];
                        $ergebnis->r3_id = $user_id;
                    }
                }
                if (isset($results[3]) && $isAllowed) {
                    if ($ergebnis->a4 != $results[3]['punkte']) {
                        $ergebnis->a4 = $results[3]['punkte'];
                        $ergebnis->r4_id = $user_id;
                    }
                }
                if (isset($results[4]) && $isAllowed) {
                    if ($ergebnis->a5 != $results[4]['punkte']) {
                        $ergebnis->a5 = $results[4]['punkte'];
                        $ergebnis->r5_id = $user_id;
                    }
                }
                if (isset($results[5]) && $isAllowed) {
                    if ($ergebnis->a6 != $results[5]['punkte']) {
                        $ergebnis->a6 = $results[5]['punkte'];
                        $ergebnis->r6_id = $user_id;
                    }
                }
                if (isset($results[6]) && $isAllowed) {
                    if ($ergebnis->a7 != $results[6]['punkte']) {
                        $ergebnis->a7 = $results[6]['punkte'];
                        $ergebnis->r7_id = $user_id;
                    }
                }
                if (isset($results[7]) && $isAllowed) {
                    if ($ergebnis->a8 != $results[7]['punkte']) {
                        $ergebnis->a8 = $results[7]['punkte'];
                        $ergebnis->r8_id = $user_id;
                    }
                }
                if (isset($results[8]) && $isAllowed) {
                    if ($ergebnis->a9 != $results[8]['punkte']) {
                        $ergebnis->a9 = $results[8]['punkte'];
                        $ergebnis->r9_id = $user_id;
                    }
                }
                if (isset($results[9]) && $isAllowed) {
                    if ($ergebnis->a10 != $results[9]['punkte']) {
                        $ergebnis->a10 = $results[9]['punkte'];
                        $ergebnis->r10_id = $user_id;
                    }
                }
                if (isset($results[10]) && $isAllowed) {
                    if ($ergebnis->a11 != $results[10]['punkte']) {
                        $ergebnis->a11 = $results[10]['punkte'];
                        $ergebnis->r11_id = $user_id;
                    }
                }
                if (isset($results[11]) && $isAllowed) {
                    if ($ergebnis->a12 != $results[11]['punkte']) {
                        $ergebnis->a12 = $results[11]['punkte'];
                        $ergebnis->r12_id = $user_id;
                    }
                }
                $ergebnis->save();
            } else {
                return 'ERROR: Keine Ergebnisse angegeben!';
            }
        }

        return 'FERTIG!';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_aufgabe_v1(Request $request)
    {

        $input = $request->all();

        $user_id = Auth::id();
        $isAllowed = true;

        $aufgabe = $input['a'];

        foreach ($input['meldungen'] as $m) {

            if ($m['meldung_id']) {
                $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($m['meldung_id']);
            } else {
                return 'ERROR: ID-Meldung fehlt';
            }

            if (! $meldung) {
                return 'ERROR: Keine passende Meldung gefunden';
            }

            if ($meldung->resultable_id) {
                $ergebnis = WorkingtestEinzel_v1::find($meldung->resultable_id);
            } else {
                $ergebnis = new WorkingtestEinzel_v1();
                $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
                // $ergebnis->hund_id = $meldung->hund->id;
                $ergebnis->hund_id = $meldung->hund_id;
                $ergebnis->save();
                $meldung->resultable_id = $ergebnis->id;
                $meldung->resultable_type = 'App\Models\WorkingtestEinzel_v1';
                $meldung->save();
            }

            if (isset($m['punkte']) && $isAllowed) {
                if ($ergebnis->{'a' . $aufgabe} != $m['punkte']) {
                    $ergebnis->{'a' . $aufgabe} = $m['punkte'];
                    $ergebnis->{'r' . $aufgabe . '_id'} = $user_id;
                }
            }

            $ergebnis->save();

        }

        return 'FERTIG!';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_cell_v1(Request $request)
    {

        $user_id = Auth::id();
        $isAllowed = true;

        $aufgabe = $request->a;
        $punkte = $request->punkte;

        if ($request->meldung_id) {
            $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($request->meldung_id);
        } else {
            return 'ERROR: ID-Meldung fehlt';
        }

        if (! $meldung) {
            return 'ERROR: Keine passende Meldung gefunden';
        }

        if ($meldung->resultable_id) {
            $ergebnis = WorkingtestEinzel_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new WorkingtestEinzel_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\WorkingtestEinzel_v1';
            $meldung->save();
        }

        if ($isAllowed) {
            if ($ergebnis->{'a' . $aufgabe} != $punkte) {
                $ergebnis->{'a' . $aufgabe} = $punkte;
                $ergebnis->{'r' . $aufgabe . '_id'} = $user_id;
            }
        }

        $ergebnis->save();

        return 'FERTIG!';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function show(WorkingtestEinzel_v1 $workingtest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkingtestEinzel_v1 $workingtest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingtestEinzel_v1 $workingtest)
    {
        //
    }
}
