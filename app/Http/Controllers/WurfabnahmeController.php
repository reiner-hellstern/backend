<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\Wurfabnahme;
use Illuminate\Http\Request;

class WurfabnahmeController extends Controller
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

            $wurfabnahme = Wurfabnahme::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $wurfabnahme->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'Wurfabnahme gespeichert.',
                'id' => $wurfabnahme->id,
            ]);
        } else {
            $wurfabnahme = Wurfabnahme::find($request['id']);
            $data = $request->all();

            $wurfabnahme->update($data);

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

            $wurfabnahme->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'Wurfabnahme aktualisiert.',
            'id' => $wurfabnahme->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Wurfabnahme $wurfabnahme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wurfabnahme $wurfabnahme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wurfabnahme $wurfabnahme)
    {
        //
    }
}
