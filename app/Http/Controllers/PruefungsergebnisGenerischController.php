<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePruefungsergebnisGenerischRequest;
use App\Http\Requests\UpdatePruefungsergebnisGenerischRequest;
use App\Models\Pruefung;
use App\Models\PruefungsergebnisGenerisch;
use App\Traits\SaveDokumente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PruefungsergebnisGenerischController extends Controller
{
    use SaveDokumente;

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
     *
     *  Satus 1	bestanden
     *  Satus 2	nicht bestanden
     *  Satus 3	zur Prüfung
     *  Satus 4	in Prüfung
     *  Satus 5	bestätigt
     *  Satus 6	nicht bestätigt
     *  Satus 7	abgelehnt
     */
    public function store(StorePruefungsergebnisGenerischRequest $request)
    {

        $ergebnisse = $request->all();

        $output_return = [];

        $freigabe_id = Auth::id();

        foreach ($ergebnisse as $e) {

            if ($e['name'] != '' && $e['hund_id']) {

                $classement_id = array_key_exists('classement', $e) ? $e['classement']['id'] : null;
                $wertung_id = array_key_exists('wertung', $e) ? $e['wertung']['id'] : null;
                $ausrichter_id = array_key_exists('ausrichter', $e) ? $e['ausrichter']['id'] : null;
                $zusatz_id = array_key_exists('zusatz', $e) ? $e['zusatz']['id'] : null;
                $bestanden = array_key_exists('bestanden', $e) ? $e['bestanden'] : null;
                $extern = array_key_exists('extern', $e) ? $e['extern'] : null;
                $dokumente = array_key_exists('dokumente', $e) ? $e['dokumente'] : [];
                $tags = array_key_exists('tags', $e) ? $e['tags'] : [];

                $status_id = array_key_exists('status', $e) ? $e['status']['id'] : null;

                // $type_id = PruefungenTyp::where('name' , $e['name'])->first()->pluck('id');

                $pruefung = new Pruefung();
                $pruefung->hund_id = $e['hund_id'];
                $pruefung->type_id = $e['type_id'];
                $pruefung->name = $e['name'];
                $pruefung->name_kurz = $e['name_kurz'];
                $pruefung->ort = $e['ort'];
                $pruefung->datum = $e['datum'];
                $pruefung->veranstaltung_id = 0;
                $pruefung->classement_id = $classement_id;
                $pruefung->wertung_id = $wertung_id;
                $pruefung->ausrichter_id = $ausrichter_id;
                $pruefung->zusatz_id = $zusatz_id;
                $pruefung->module_vue = 'Generisch_Formular';
                $pruefung->bestanden = $bestanden;
                $pruefung->extern = $extern;
                $pruefung->status_id = $status_id;
                $pruefung->created_id = $freigabe_id;
                $pruefung->freigabe_id = $freigabe_id;

                $ergebnis = new PruefungsergebnisGenerisch();
                $ergebnis->hund_id = $e['hund_id'];
                $ergebnis->praedikat = $e['praedikat'];
                $ergebnis->punkte = $e['punkte'];
                $ergebnis->platzierung = $e['platzierung'];
                $ergebnis->ort = $e['ort'];
                $ergebnis->datum = $e['datum'];
                $ergebnis->save();

                $pruefung->resultable_id = $ergebnis->id;
                $pruefung->resultable_type = 'App\Models\PruefungsergebnisGenerisch';
                $pruefung->save();

                $dokumente = $e['dokumente'];

                foreach ($dokumente as $dokument) {
                    $tags = $dokument['tags'];
                    unset($dokument['tags']);
                    $dokument = $pruefung->dokumente()->create($dokument);
                    $dokument->tags()->sync($tags);
                }

                $pruefung = $pruefung->fresh();
                // $pruefung->load('type');
                $pruefung->load('resultable');
                $pruefung->tags = $tags;

                $output_return[] = $pruefung;
            }
        }

        // return $output_return;

        return response()->json([
            'success' => 'Prüfungen gespeichert.',
            'pruefungen' => $output_return,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePruefungsergebnisGenerischRequest $request, Pruefung $pruefung)
    {
        $updates = $request->all();

        $freigabe_id = Auth::id();

        $ergebnis = PruefungsergebnisGenerisch::find($pruefung->resultable_id);

        $ergebnis->praedikat = $updates['praedikat'];
        $ergebnis->punkte = $updates['punkte'];
        $ergebnis->bestanden = $updates['bestanden'];
        $ergebnis->platzierung = $updates['platzierung'];
        $ergebnis->ort = $updates['ort'];
        $ergebnis->datum = $updates['datum'];
        $ergebnis->save();

        $pruefung->type_id = $updates['type_id'];
        $pruefung->name = $updates['name'];
        $pruefung->name_kurz = $updates['name_kurz'];
        $pruefung->ort = $updates['ort'];
        $pruefung->datum = $updates['datum'];
        $pruefung->classement_id = $updates['classement_id'];
        $pruefung->wertung_id = $updates['wertung_id'];
        $pruefung->ausrichter_id = $updates['ausrichter_id'];
        $pruefung->zusatz_id = $updates['zusatz_id'];
        $pruefung->bestanden = $updates['bestanden'];
        $pruefung->status_id = $updates['status_id'];
        $pruefung->extern = $updates['extern'];

        $pruefung->freigabe_id = ($updates['status_id'] != 1) ? $freigabe_id : 0;

        $dokumente = array_key_exists('dokumente', $updates) ? $updates['dokumente'] : [];

        $this->saveDokumente($pruefung, $dokumente);

        $pruefung->save();

        return [
            'pruefung' => $pruefung,
            'ergebnis' => $ergebnis,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pruefung $pruefung)
    {

        $user_id = Auth::id();

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
     *
     *  Satus 1	bestanden
     *  Satus 2	nicht bestanden
     *  Satus 3	zur Prüfung
     *  Satus 4	in Prüfung
     *  Satus 5	bestätigt
     *  Satus 6	nicht bestätigt
     *  Satus 7	abgelehnt
     */
    public function meldung_store(StorePruefungsergebnisGenerischRequest $request, Pruefung $pruefung)
    {

        $ergebnis = $request->all();

        $user_id = Auth::id();

        if ($request->name != '' && $request->hund_id) {

            $classement_id = array_key_exists('classement', $ergebnis) ? $ergebnis['classement']['id'] : null;
            $wertung_id = array_key_exists('wertung', $ergebnis) ? $ergebnis['wertung']['id'] : null;
            $ausrichter_id = array_key_exists('ausrichter', $ergebnis) ? $ergebnis['ausrichter']['id'] : null;
            $zusatz_id = array_key_exists('zusatz', $ergebnis) ? $ergebnis['zusatz']['id'] : null;
            $dokumente = array_key_exists('dokumente', $ergebnis) ? $ergebnis['dokumente'] : [];
            $bestanden = array_key_exists('bestanden', $ergebnis) ? $ergebnis['bestanden'] : null;
            $tags = array_key_exists('tags', $ergebnis) ? $ergebnis['tags'] : [];
            // $type_id = PruefungenTyp::where('name' , $ergebnis['name'])->first()->pluck('id');

            $pruefung = new Pruefung();
            $pruefung->hund_id = $request->hund_id;
            $pruefung->type_id = $request->type_id;
            $pruefung->name = $request->name;
            $pruefung->name_kurz = $request->name_kurz;
            $pruefung->ort = $request->ort;
            $pruefung->datum = $request->datum;
            $pruefung->veranstaltung_id = 0;
            $pruefung->classement_id = $classement_id;
            $pruefung->wertung_id = $wertung_id;
            $pruefung->ausrichter_id = $ausrichter_id;
            $pruefung->zusatz_id = $zusatz_id;
            $pruefung->module_vue = 'Generisch_Formular';
            $pruefung->bestanden = $bestanden;
            $pruefung->status_id = 1;
            $pruefung->created_id = $user_id;
            $pruefung->freigabe_id = 0;
            $pruefung->extern = true;

            $ergebnis = new PruefungsergebnisGenerisch();
            $ergebnis->hund_id = $request->hund_id;
            $ergebnis->praedikat = $request->praedikat;
            $ergebnis->punkte = $request->punkte;
            $ergebnis->platzierung = $request->platzierung;
            $ergebnis->ort = $request->ort;
            $ergebnis->datum = $request->datum;
            $ergebnis->save();

            $pruefung->resultable_id = $ergebnis->id;
            $pruefung->resultable_type = 'App\Models\PruefungsergebnisGenerisch';
            $pruefung->save();

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $pruefung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            $pruefung = $pruefung->fresh();
            // $pruefung->load('type');
            $pruefung->load('resultable');
            $pruefung->tags = $tags;

        }

        return [
            'pruefung' => $pruefung,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function meldung_update(UpdatePruefungsergebnisGenerischRequest $request, Pruefung $pruefung)
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
}
