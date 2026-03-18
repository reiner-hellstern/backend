<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\OCDUntersuchung;
use App\Models\OCDUntersuchung_v1;
use Illuminate\Http\Request;

class OCDUntersuchungController extends Controller
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
    public function store(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $ocduntersuchung = OCDUntersuchung::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $ocduntersuchung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'OCDUntersuchung gespeichert.',
                'id' => $ocduntersuchung->id,
            ]);
        } else {
            $ocduntersuchung = OCDUntersuchung::find($request['id']);
            $data = $request->all();

            $ocduntersuchung->update($data);

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

            $ocduntersuchung->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'OCDUntersuchung aktualisiert.',
            'id' => $ocduntersuchung->id,
        ]);
    }

    public function store_v1(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $ocduntersuchung = OCDUntersuchung_v1::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $ocduntersuchung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'OCDUntersuchung gespeichert.',
                'id' => $ocduntersuchung->id,
            ]);
        } else {
            $ocduntersuchung = OCDUntersuchung_v1::find($request['id']);
            $data = $request->all();

            $ocduntersuchung->update($data);

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

            $ocduntersuchung->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'OCDUntersuchung aktualisiert.',
            'id' => $ocduntersuchung->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(OCDUntersuchung $ocduntersuchung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OCDUntersuchung $ocduntersuchung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OCDUntersuchung  $ocduntersuchung
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $untersuchung = OCDUntersuchung::find($request['id']);

        if ($untersuchung) {
            OCDUntersuchung::destroy($request['id']);

            return response()->json([
                'success' => 'OCDUntersuchung gelöscht.',
            ]);
        }

    }
}
