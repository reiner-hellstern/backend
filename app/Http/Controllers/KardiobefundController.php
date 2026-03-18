<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKardiobefundRequest;
use App\Http\Requests\UpdateKardiobefundRequest;
use App\Models\Kardiobefund;
use App\Traits\SaveArzt;

class KardiobefundController extends Controller
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
    public function store(StoreKardiobefundRequest $request)
    {
        $kardiobefund = new Kardiobefund();

        $kardiobefund->hund_id = $request->hund_id;
        $kardiobefund->datum = $request->datum;
        $kardiobefund->anmerkungen = $request->anmerkungen;

        $kardiobefund->arzt_id = $this->saveArzt($request->arzt);

        $kardiobefund->save();

        return ['message' => 'success', 'kardiobefund' => $kardiobefund];
    }

    /**
     * Display the specified resource.
     */
    public function show(Kardiobefund $kardiobefund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKardiobefundRequest $request, Kardiobefund $kardiobefund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kardiobefund $kardiobefund)
    {
        //
    }
}
