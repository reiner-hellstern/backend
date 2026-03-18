<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHodenRequest;
use App\Http\Requests\UpdateHodenRequest;
use App\Models\Hoden;
use App\Traits\SaveArzt;

class HodenController extends Controller
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
    public function store(StoreHodenRequest $request)
    {
        $hoden = new Hoden();

        $hoden->hund_id = $request->hund_id;
        $hoden->datum = $request->datum;
        $hoden->anmerkungen = $request->anmerkungen;
        $hoden->quelle_id = $request->quelle['id'];
        $hoden->tastbarkeit_id = $request->tastbarkeit_id;
        $hoden->senkung_id = $request->senkung_id;
        $hoden->operation = $request->operation;
        $hoden->grund_operation_id = $request->grund_operation_id;
        $hoden->grund_operation = $request->grund_operation;

        $hoden->arzt_id = $this->saveArzt($request->arzt);

        $hoden->save();

        $dokumente = $request['dokumente'];

        foreach ($dokumente as $dokument) {
            $tags = $dokument['tags'];
            unset($dokument['tags']);
            $dokument = $hoden->dokumente()->create($dokument);
            $dokument->tags()->sync($tags);
        }

        return ['message' => 'success', 'hoden' => $hoden];
    }

    /**
     * Display the specified resource.
     */
    public function show(Hoden $hoden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHodenRequest $request, Hoden $hoden)
    {
        $hoden->hund_id = $request->hund_id;
        $hoden->datum = $request->datum;
        $hoden->anmerkungen = $request->anmerkungen;
        $hoden->quelle_id = $request->quelle['id'];
        $hoden->tastbarkeit_id = $request->tastbarkeit_id;
        $hoden->senkung_id = $request->senkung_id;
        $hoden->operation = $request->operation;
        $hoden->grund_operation_id = $request->grund_operation_id;
        $hoden->grund_operation = $request->grund_operation;
        $hoden->arzt_id = $this->saveArzt($request->arzt);
        $hoden->save();

        $dokumente = $request['dokumente'];

        foreach ($dokumente as $dokument) {
            $tags = $dokument['tags'];
            unset($dokument['tags']);
            $dokument = $hoden->dokumente()->create($dokument);
            $dokument->tags()->sync($tags);
        }

        return ['message' => 'success', 'hoden' => $hoden];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hoden $hoden)
    {
        //
    }
}
