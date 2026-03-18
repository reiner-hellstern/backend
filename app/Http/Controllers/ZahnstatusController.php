<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\Zahnstatus;
use App\Models\Zahnstatus_v1;
use Illuminate\Http\Request;

class ZahnstatusController extends Controller
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

    // $zahnstatus = new Zahnstatus();
    // if ( $request['hund_id'] ) $zahnstatus->hund_id = $request['hund_id'];
    // if ( $request['datum'] ) $zahnstatus->datum = $request['datum'];
    // if ( $request['bewertung'] ) $zahnstatus->bewertung = $request['bewertung'];
    // if ( $request['quelle_id'] ) $zahnstatus->quelle_id = $request['quelle_id'];
    // if ( $request['gebiss_id'] ) $zahnstatus->gebiss_id = $request['gebiss_id'];
    // if ( $request['pruefung_id'] ) $zahnstatus->pruefung_id = $request['pruefung_id'];
    // if ( $request['veranstaltung_id'] ) $zahnstatus->veranstaltung_id = $request['veranstaltung_id'];
    // if ( $request['gutachter_id'] ) $zahnstatus->gutachter_id = $request['gutachter_id'];
    // if ( $request['gutachter_titel'] ) $zahnstatus->gutachter_titel = $request['gutachter_titel'];
    // if ( $request['gutachter_vorname'] ) $zahnstatus->gutachter_vorname = $request['gutachter_vorname'];
    // if ( $request['gutachter_nachname'] ) $zahnstatus->gutachter_nachname = $request['gutachter_nachname'];
    // if ( $request['gutachter_praxis'] ) $zahnstatus->gutachter_praxis = $request['gutachter_praxis'];
    // if ( $request['gutachter_strasse'] ) $zahnstatus->gutachter_strasse = $request['gutachter_strasse'];
    // if ( $request['gutachter_plz'] ) $zahnstatus->gutachter_plz = $request['gutachter_plz'];
    // if ( $request['gutachter_ort'] ) $zahnstatus->gutachter_ort = $request['gutachter_ort'];
    // if ( $request['gutachter_land'] ) $zahnstatus->gutachter_land = $request['gutachter_land'];
    // if ( $request['gutachter_land_kuerzel'] ) $zahnstatus->gutachter_land_kuerzel = $request['gutachter_land_kuerzel'];
    // if ( $request['gutachter_email'] ) $zahnstatus->gutachter_email = $request['gutachter_email'];
    // if ( $request['gutachter_website'] ) $zahnstatus->gutachter_website = $request['gutachter_website'];
    // if ( $request['gutachter_telefon_1'] ) $zahnstatus->gutachter_telefon_1 = $request['gutachter_telefon_1'];
    // if ( $request['gutachter_telefon_2'] ) $zahnstatus->gutachter_telefon_2 = $request['gutachter_telefon_2'];
    // if ( $request['textform'] ) $zahnstatus->textform = $request['textform'];
    // if ( $request['anmerkung'] ) $zahnstatus->anmerkung = $request['anmerkung'];
    // if ( $request['aktiv'] ) $zahnstatus->aktiv = $request['aktiv'];
    // if ( $request['m2or'] ) $zahnstatus->m2or = $request['m2or'];
    // if ( $request['m1or'] ) $zahnstatus->m1or = $request['m1or'];
    // if ( $request['p4or'] ) $zahnstatus->p4or = $request['p4or'];
    // if ( $request['p3or'] ) $zahnstatus->p3or = $request['p3or'];
    // if ( $request['p2or'] ) $zahnstatus->p2or = $request['p2or'];
    // if ( $request['p1or'] ) $zahnstatus->p1or = $request['p1or'];
    // if ( $request['cor'] ) $zahnstatus->cor = $request['cor'];
    // if ( $request['i3or'] ) $zahnstatus->i3or = $request['i3or'];
    // if ( $request['i2or'] ) $zahnstatus->i2or = $request['i2or'];
    // if ( $request['i1or'] ) $zahnstatus->i1or = $request['i1or'];
    // if ( $request['i1ol'] ) $zahnstatus->i1ol = $request['i1ol'];
    // if ( $request['i2ol'] ) $zahnstatus->i2ol = $request['i2ol'];
    // if ( $request['i3ol'] ) $zahnstatus->i3ol = $request['i3ol'];
    // if ( $request['col'] ) $zahnstatus->col = $request['col'];
    // if ( $request['p1ol'] ) $zahnstatus->p1ol = $request['p1ol'];
    // if ( $request['p2ol'] ) $zahnstatus->p2ol = $request['p2ol'];
    // if ( $request['p3ol'] ) $zahnstatus->p3ol = $request['p3ol'];
    // if ( $request['p4ol'] ) $zahnstatus->p4ol = $request['p4ol'];
    // if ( $request['m1ol'] ) $zahnstatus->m1ol = $request['m1ol'];
    // if ( $request['m2ol'] ) $zahnstatus->m2ol = $request['m2ol'];
    // if ( $request['m3ur'] ) $zahnstatus->m3ur = $request['m3ur'];
    // if ( $request['m2ur'] ) $zahnstatus->m2ur = $request['m2ur'];
    // if ( $request['m1ur'] ) $zahnstatus->m1ur = $request['m1ur'];
    // if ( $request['p4ur'] ) $zahnstatus->p4ur = $request['p4ur'];
    // if ( $request['p3ur'] ) $zahnstatus->p3ur = $request['p3ur'];
    // if ( $request['p2ur'] ) $zahnstatus->p2ur = $request['p2ur'];
    // if ( $request['p1ur'] ) $zahnstatus->p1ur = $request['p1ur'];
    // if ( $request['cur'] ) $zahnstatus->cur = $request['cur'];
    // if ( $request['i3ur'] ) $zahnstatus->i3ur = $request['i3ur'];
    // if ( $request['i2ur'] ) $zahnstatus->i2ur = $request['i2ur'];
    // if ( $request['i1ur'] ) $zahnstatus->i1ur = $request['i1ur'];
    // if ( $request['i1ul'] ) $zahnstatus->i1ul = $request['i1ul'];
    // if ( $request['i2ul'] ) $zahnstatus->i2ul = $request['i2ul'];
    // if ( $request['i3ul'] ) $zahnstatus->i3ul = $request['i3ul'];
    // if ( $request['cul'] ) $zahnstatus->cul = $request['cul'];
    // if ( $request['p1ul'] ) $zahnstatus->p1ul = $request['p1ul'];
    // if ( $request['p2ul'] ) $zahnstatus->p2ul = $request['p2ul'];
    // if ( $request['p3ul'] ) $zahnstatus->p3ul = $request['p3ul'];
    // if ( $request['p4ul'] ) $zahnstatus->p4ul = $request['p4ul'];
    // if ( $request['m1ul'] ) $zahnstatus->m1ul = $request['m1ul'];
    // if ( $request['m2ul'] ) $zahnstatus->m2ul = $request['m2ul'];
    // if ( $request['m3ul'] ) $zahnstatus->m3ul = $request['m3ul'];

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $zahnstatus = Zahnstatus::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $zahnstatus->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'Zahnstatus gespeichert.',
                'id' => $zahnstatus->id,
            ]);
        } else {
            $zahnstatus = Zahnstatus::find($request['id']);
            $data = $request->all();

            $zahnstatus->update($data);

            $dokumente = $data['dokumente'];

            $db_dokuments = [];
            $dok_ids = [];

            foreach ($dokumente as $dokument) {
                $db_dokument = Dokument::find($dokument['id']);
                $db_dokuments[] = $db_dokument;
                $dok_ids[] = $db_dokument->id;
                $db_dokument->update($dokument);

                $tags = $dokument['tags'];
                $tag_ids = array_map(function ($tag) {
                    return $tag['id'];
                }, $tags);
                $db_dokument->tags()->sync($tag_ids);
            }

            $zahnstatus->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'Zahnstatus aktualisiert.',
            'id' => $zahnstatus->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_v1(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $zahnstatus = Zahnstatus_v1::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $zahnstatus->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'Zahnstatus gespeichert.',
                'id' => $zahnstatus->id,
            ]);
        } else {
            $zahnstatus = Zahnstatus_v1::find($request['id']);
            $data = $request->all();

            $zahnstatus->update($data);

            $dokumente = $data['dokumente'];

            $db_dokuments = [];
            $dok_ids = [];

            foreach ($dokumente as $dokument) {
                $db_dokument = Dokument::find($dokument['id']);
                $db_dokuments[] = $db_dokument;
                $dok_ids[] = $db_dokument->id;
                $db_dokument->update($dokument);

                $tags = $dokument['tags'];
                $tag_ids = array_map(function ($tag) {
                    return $tag['id'];
                }, $tags);
                $db_dokument->tags()->sync($tag_ids);
            }

            $zahnstatus->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'Zahnstatus aktualisiert.',
            'id' => $zahnstatus->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Zahnstatus $zahnstatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zahnstatus $zahnstatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zahnstatus  $zahnstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $zahnstatus = Zahnstatus::find($request['id']);

        if ($zahnstatus) {
            Zahnstatus::destroy($request['id']);

            return response()->json([
                'success' => 'Zahnstatus gelöscht.',
            ]);
        }

    }
}
