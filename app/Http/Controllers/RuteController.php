<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRuteRequest;
use App\Http\Requests\UpdateRuteRequest;
use App\Models\Rute;
use App\Traits\SaveArzt;

class RuteController extends Controller
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
    public function store(StoreRuteRequest $request)
    {
        $rute = new Rute();

        $rute->hund_id = $request->hund_id;
        $rute->datum = $request->datum;
        $rute->anmerkungen = $request->anmerkungen;
        $rute->befund = $request->befund;
        $rute->fehlbildung = $request->fehlbildung;
        $rute->art_id = $request->art['id'];

        $rute->arzt_id = $this->saveArzt($request->arzt);

        $rute->save();

        return ['message' => 'success', 'rute' => $rute];
    }

    /**
     * Display the specified resource.
     */
    public function show(Rute $rute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuteRequest $request, Rute $rute)
    {

        $rute->hund_id = $request->hund_id;
        $rute->datum = $request->datum;
        $rute->anmerkungen = $request->anmerkungen;
        $rute->befund = $request->befund;
        $rute->fehlbildung = $request->fehlbildung;
        $rute->art_id = $request->art['id'];

        $rute->arzt_id = $this->saveArzt($request->arzt);

        $rute->save();

        return ['message' => 'success', 'rute' => $rute];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rute $rute)
    {
        //
    }
}
