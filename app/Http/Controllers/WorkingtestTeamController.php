<?php

namespace App\Http\Controllers;

use App\Models\Veranstaltung;
use App\Models\VeranstaltungMeldung;
use App\Models\VeranstaltungTeam;
use App\Models\WorkingtestTeam_v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkingtestTeamController extends Controller
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

        foreach ($input['teilnehmer'] as $tn) {

            if ($tn['meldung_id']) {
                $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($tn['meldung_id']);
            } else {
                return 'ERROR: ID-Meldung fehlt';
            }

            if (! $meldung) {
                return 'ERROR: Keine passende Meldung gefunden';
            }

            if ($meldung->resultable_id) {
                $ergebnis = WorkingtestTeam_v1::find($meldung->resultable_id);
            }
            if (! $ergebnis) {
                $ergebnis = new WorkingtestTeam_v1();

                $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
                // $ergebnis->hund_id = $meldung->hund->id;
                $ergebnis->hund_id = $meldung->hund_id;
                $ergebnis->team_id = $meldung->team_id;
                $ergebnis->save();
                $meldung->resultable_id = $ergebnis->id;
                $meldung->resultable_type = 'App\Models\WorkingtestTeam_v1';
                $meldung->save();
            }

            if ($tn['ergebnis']) {

                $results = $tn['ergebnis']['aufgaben'];
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
                $ergebnis->team_id = $meldung->team_id;
                $ergebnis->save();
            } else {
                return 'ERROR: Keine Ergebnisse angegeben!';
            }
        }

        foreach ($input['teams'] as $team) {

            $ergebnis = WorkingtestTeam_v1::where('team_id', $team['id'])->where('hund_id', 0)->first();

            if (! $ergebnis) {
                $ergebnis = new WorkingtestTeam_v1();
                $ergebnis->veranstaltung_id = $team['veranstaltung_id'];
                $ergebnis->team_id = $team['id'];
                $ergebnis->hund_id = 0;
                $ergebnis->save();
            }

            if ($team['ergebnisse']) {
                $results = $team['ergebnisse']['aufgaben'];
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

                $dbteam = VeranstaltungTeam::find($team['id']);
                $dbteam->resultable_id = $ergebnis->id;
                $dbteam->resultable_type = 'App\Models\WorkingtestTeam_v1';
                $dbteam->save();

                $teammeldungen = VeranstaltungMeldung::where('team_id', $team['id'])->get();
                foreach ($teammeldungen as $teammeldung) {
                    $ergebnis = WorkingtestTeam_v1::find($teammeldung->resultable_id);
                    if (isset($results[0]) && $isAllowed) {
                        if ($ergebnis->ta1 != $results[0]['punkte']) {
                            $ergebnis->ta1 = $results[0]['punkte'];
                        }
                    }
                    if (isset($results[1]) && $isAllowed) {
                        if ($ergebnis->ta2 != $results[1]['punkte']) {
                            $ergebnis->ta2 = $results[1]['punkte'];
                        }
                    }
                    if (isset($results[2]) && $isAllowed) {
                        if ($ergebnis->ta3 != $results[2]['punkte']) {
                            $ergebnis->ta3 = $results[2]['punkte'];
                        }
                    }
                    if (isset($results[3]) && $isAllowed) {
                        if ($ergebnis->ta4 != $results[3]['punkte']) {
                            $ergebnis->ta4 = $results[3]['punkte'];
                        }
                    }
                    if (isset($results[4]) && $isAllowed) {
                        if ($ergebnis->ta5 != $results[4]['punkte']) {
                            $ergebnis->ta5 = $results[4]['punkte'];
                        }
                    }
                    if (isset($results[5]) && $isAllowed) {
                        if ($ergebnis->ta6 != $results[5]['punkte']) {
                            $ergebnis->ta6 = $results[5]['punkte'];
                        }
                    }
                    if (isset($results[6]) && $isAllowed) {
                        if ($ergebnis->ta7 != $results[6]['punkte']) {
                            $ergebnis->ta7 = $results[6]['punkte'];
                        }
                    }
                    if (isset($results[7]) && $isAllowed) {
                        if ($ergebnis->ta8 != $results[7]['punkte']) {
                            $ergebnis->ta8 = $results[7]['punkte'];
                        }
                    }
                    if (isset($results[8]) && $isAllowed) {
                        if ($ergebnis->ta9 != $results[8]['punkte']) {
                            $ergebnis->ta9 = $results[8]['punkte'];
                        }
                    }
                    if (isset($results[9]) && $isAllowed) {
                        if ($ergebnis->ta10 != $results[9]['punkte']) {
                            $ergebnis->ta10 = $results[9]['punkte'];
                        }
                    }
                    if (isset($results[10]) && $isAllowed) {
                        if ($ergebnis->ta11 != $results[10]['punkte']) {
                            $ergebnis->ta11 = $results[10]['punkte'];
                        }
                    }
                    if (isset($results[11]) && $isAllowed) {
                        if ($ergebnis->ta12 != $results[11]['punkte']) {
                            $ergebnis->ta12 = $results[11]['punkte'];
                        }
                    }
                    $ergebnis->save();
                }

            } else {
                return 'ERROR: Keine Ergebnisse angegeben!';
            }
        }

        // Lösche Ergebnisse von Meldungen ohne Team, falls vorhanden
        foreach ($input['ohneteam'] as $ohne_team) {
            $meldung_ohne_team = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($ohne_team);
            if ($meldung_ohne_team) {
                if ($meldung_ohne_team->resultable_id) {
                    WorkingtestTeam_v1::destroy($meldung_ohne_team->resultable_id);
                }
            }
        }

        // CLEANUP
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

        foreach ($input['teilnehmer'] as $m) {

            if ($m['meldung_id']) {
                $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($m['meldung_id']);
            } else {
                return 'ERROR: ID-Meldung fehlt';
            }

            if (! $meldung) {
                return 'ERROR: Keine passende Meldung gefunden';
            }

            if ($meldung->resultable_id) {
                $ergebnis = WorkingtestTeam_v1::find($meldung->resultable_id);
            } else {
                $ergebnis = new WorkingtestTeam_v1();
                $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
                // $ergebnis->hund_id = $meldung->hund->id;
                $ergebnis->hund_id = $meldung->hund_id;
                $ergebnis->save();
                $meldung->resultable_id = $ergebnis->id;
                $meldung->resultable_type = 'App\Models\WorkingtestTeam_v1';
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
            $ergebnis = WorkingtestTeam_v1::find($meldung->resultable_id);
        } else {
            $ergebnis = new WorkingtestTeam_v1();
            $ergebnis->veranstaltung_id = $meldung->veranstaltung_id;
            // $ergebnis->hund_id = $meldung->hund->id;
            $ergebnis->hund_id = $meldung->hund_id;
            $ergebnis->save();
            $meldung->resultable_id = $ergebnis->id;
            $meldung->resultable_type = 'App\Models\WorkingtestTEam_v1';
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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_teams_v1(Request $request)
    {

        $user_id = Auth::id();
        $isAllowed = true;

        $input = $request->all();

        $new_ids = [];
        foreach ($input['teams'] as $team) {
            $new_ids[] = $team['id'];
        }

        foreach ($input['ohneteam'] as $meldung_ohne_team) {

            $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($meldung_ohne_team['id']);
            $m->team_id = 0;
            $m->save();
        }

        $old_teams = Veranstaltung::find($request->va)->teams;

        // LÖSCHE GELÖSCHTE TEAMS
        foreach ($old_teams as $old_team) {

            if (! in_array($old_team->id, $new_ids)) {

                //  KANN U.U. WEG, WEIL OBEN SCHON ERLEDIGT.
                $mitglieder = VeranstaltungTeam::find($old_team->id)->mitglieder;
                foreach ($mitglieder as $mitglied) {
                    $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mitglied->id);
                    $m->team_id = 0;
                    $m->save();
                }
                // ENDE

                VeranstaltungTeam::destroy($old_team->id);
            }
        }

        $startpos_team = 1;
        foreach ($input['teams'] as $team) {

            $new_team = VeranstaltungTeam::find($team['id']);
            if (! $new_team) {

                $new_team = new VeranstaltungTeam();
                $new_team->name = $team['name'];
                $new_team->startpos = $startpos_team++;
                $new_team->veranstaltung_id = $input['va'];
                $new_team->save();
                $team_id = $new_team->id;

                foreach ($team['mitglieder'] as $mitglied) {
                    $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mitglied['id']);
                    $m->team_id = $team_id;
                    $m->save();
                }
            } else {
                $new_team->name = $team['name'];
                $new_team->startpos = $startpos_team++;
                $new_team->save();

                $startpos_mitglied = 1;
                if (isset($team['mitglieder'])) {
                    foreach ($team['mitglieder'] as $mitglied) {
                        $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mitglied['id']);
                        $m->team_id = $new_team->id;
                        $m->startpos = $startpos_mitglied++;
                        $m->save();
                    }
                }

            }
        }

        return Veranstaltung::find($request->va)->teams;

        return 'FERTIG!';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function show(WorkingtestTeam_v1 $workingtest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkingtestTeam_v1 $workingtest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workingtest  $workingtest
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingtestTeam_v1 $workingtest)
    {
        //
    }
}
