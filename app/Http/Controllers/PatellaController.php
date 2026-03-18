<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatellaRequest;
use App\Http\Requests\UpdatePatellaRequest;
use App\Models\Patella;
use App\Traits\SaveArzt;

class PatellaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use SaveArzt;

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatellaRequest $request)
    {
        $patella = new Patella();
        $patella->hund_id = $request->hund_id;
        $patella->datum_operation = $request->datum_operation;
        $patella->datum = $request->datum;
        $patella->anmerkungen = $request->anmerkungen;
        $patella->verdacht = $request->verdacht;
        $patella->befund = $request->befund;
        $patella->operation = $request->operation;
        $patella->grund_operation_id = $request->grund_operation_id;
        $patella->grund_operation = $request->grund_operation;
        $patella->lokation_links = $request->lokation_links;
        $patella->lokation_rechts = $request->lokation_rechts;
        $patella->score_links_id = $request->score_links_id;
        $patella->score_rechts_id = $request->score_rechts_id;
        $patella->score_gesamt_id = $request->score_gesamt_id;
        $patella->patellaluxation = $request->patellaluxation;

        $patella->arzt_id = $this->saveArzt($request->arzt);

        $patella->save();

        return ['message' => 'success', 'patella' => $patella];

    }

    /**
     * Display the specified resource.
     */
    public function show(Patella $patella)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatellaRequest $request, Patella $patella)
    {

        $patella->datum_operation = $request->datum_operation;
        $patella->datum = $request->datum;
        $patella->anmerkungen = $request->anmerkungen;
        $patella->verdacht = $request->verdacht;
        $patella->befund = $request->befund;
        $patella->operation = $request->operation;
        $patella->grund_operation_id = $request->grund_operation_id;
        $patella->grund_operation = $request->grund_operation;
        $patella->lokation_links = $request->lokation_links;
        $patella->lokation_rechts = $request->lokation_rechts;
        $patella->score_links_id = $request->score_links_id;
        $patella->score_rechts_id = $request->score_rechts_id;
        $patella->score_gesamt_id = $request->score_gesamt_id;
        $patella->patellaluxation = $request->patellaluxation;

        $patella->arzt_id = $this->saveArzt($request->arzt);

        $patella->save();

        return ['message' => 'success', 'patella' => $patella];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patella $patella)
    {
        //
    }
}
