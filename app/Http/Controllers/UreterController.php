<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUreterRequest;
use App\Http\Requests\UpdateUreterRequest;
use App\Models\Ureter;
use App\Traits\SaveArzt;

class UreterController extends Controller
{
    use SaveArzt;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUreterRequest $request)
    {
        $ureter = new Ureter();

        $ureter->hund_id = $request->hund_id;
        $ureter->datum = $request->datum;
        $ureter->anmerkungen = $request->anmerkungen;
        $ureter->verdacht = $request->verdacht;
        $ureter->tieraerztlicher_befund = $request->tieraerztlicher_befund;
        $ureter->operation = $request->operation;
        $ureter->score_links_id = $request->score_links_id;
        $ureter->score_rechts_id = $request->score_rechts_id;
        $ureter->arzt_id = $this->saveArzt($request->arzt);

        $ureter->save();

        return ['message' => 'success', 'ureter' => $ureter];
    }

    /**
     * Display the specified resource.
     */
    public function show(Ureter $ureter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUreterRequest $request, Ureter $ureter)
    {
        $ureter->hund_id = $request->hund_id;
        $ureter->datum = $request->datum;
        $ureter->anmerkungen = $request->anmerkungen;
        $ureter->verdacht = $request->verdacht;
        $ureter->tieraerztlicher_befund = $request->tieraerztlicher_befund;
        $ureter->operation = $request->operation;
        $ureter->score_links_id = $request->score_links_id;
        $ureter->score_rechts_id = $request->score_rechts_id;
        $ureter->arzt_id = $this->saveArzt($request->arzt);

        $ureter->save();

        return ['message' => 'success', 'ureter' => $ureter];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ureter $ureter)
    {
        //
    }
}
