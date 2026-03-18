<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\Gentest;
use Illuminate\Http\Request;

class GentestController extends Controller
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

            $gentest = Gentest::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $gentest->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'Gentest gespeichert.',
                'id' => $gentest->id,
            ]);
        } else {
            $gentest = Gentest::find($request['id']);
            $data = $request->all();

            $gentest->update($data);

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

            $gentest->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'Gentest aktualisiert.',
            'id' => $gentest->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Gentest $gentest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gentest $gentest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gentest  $gentest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $untersuchung = Gentest::find($request['id']);

        if ($untersuchung) {
            Gentest::destroy($request['id']);

            return response()->json([
                'success' => 'Gentestauswertung gelöscht.',
            ]);
        }

    }
}
