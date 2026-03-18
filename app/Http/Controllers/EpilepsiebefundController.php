<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEpilepsiebefundRequest;
use App\Http\Requests\UpdateEpilepsiebefundRequest;
use App\Models\Epilepsiebefund;
use App\Traits\SaveArzt;
use App\Traits\SaveLabor;

class EpilepsiebefundController extends Controller
{
    use SaveArzt;
    use SaveLabor;

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
    public function store(StoreEpilepsiebefundRequest $request)
    {
        $epilepsiebefund = new Epilepsiebefund();

        $epilepsiebefund->hund_id = $request->hund_id;
        $epilepsiebefund->datum = $request->datum;
        $epilepsiebefund->anmerkungen = $request->anmerkungen;

        $epilepsiebefund->arzt_id = $this->saveArzt($request->arzt);
        $epilepsiebefund->labor_id = $this->saveLabor($request->labor);

        $epilepsiebefund->save();

        return ['message' => 'success', 'epilepsiebefund' => $epilepsiebefund];
    }

    /**
     * Display the specified resource.
     */
    public function show(Epilepsiebefund $epilepsiebefund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpilepsiebefundRequest $request, Epilepsiebefund $epilepsiebefund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Epilepsiebefund $epilepsiebefund)
    {
        //
    }
}
