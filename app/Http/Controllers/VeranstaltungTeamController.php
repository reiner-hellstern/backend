<?php

namespace App\Http\Controllers;

use App\Models\Veranstaltung;
use App\Models\VeranstaltungMeldung;
use App\Models\VeranstaltungTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VeranstaltungTeamController extends Controller
{
    //

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_teams(Request $request)
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

        //  $startpos_team = 1;
        $ids = [];

        foreach ($input['teams'] as $teamindex => $team) {

            $new_team = VeranstaltungTeam::find($team['id']);
            if (! $new_team) {

                $new_team = new VeranstaltungTeam();
                $new_team->name = $team['name'];
                $new_team->startpos = $teamindex + 1;
                $new_team->veranstaltung_id = $input['va'];
                $new_team->save();
                $team_id = $new_team->id;

                foreach ($team['mitglieder'] as $mindex => $mitglied) {
                    $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mitglied['id']);
                    $m->team_id = $team_id;
                    $m->startpos = $mindex + 1;
                    $m->save();
                }
            } else {
                $new_team->name = $team['name'];
                $new_team->startpos = $teamindex + 1;
                $new_team->save();

                //  $startpos_mitglied = 1;
                if (isset($team['mitglieder'])) {
                    foreach ($team['mitglieder'] as $mindex => $mitglied) {
                        $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mitglied['id']);
                        $m->team_id = $new_team->id;
                        $m->startpos = $mindex + 1;
                        $m->save();
                    }
                }

            }
            array_push($ids, $new_team->id);
        }

        return ['ids' => $ids];

    }

    public function add_team(Request $request)
    {

        $input = $request->all();

        $new_team = new VeranstaltungTeam();
        $new_team->name = $input['team']['name'];
        $new_team->startpos = $input['startpos'];
        $new_team->veranstaltung_id = $input['va'];
        $new_team->save();

        return ['id' => $new_team->id];
    }

    public function remove_team(Request $request)
    {

        $input = $request->all();

        $team = VeranstaltungTeam::find($input['id']);
        $result = $team->resultable;
        if ($result) {
            $result->delete();
        }

        VeranstaltungTeam::destroy($input['id']);

        foreach ($input['mitglieder'] as $mid) {
            $meldung = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($mid);
            $meldung->team_id = 0;
            $meldung->save();

            $result = $meldung->resultable;
            $result->delete();
        }

    }
}
