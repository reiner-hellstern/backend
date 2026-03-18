<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKaiserschnittRequest;
use App\Http\Requests\UpdateKaiserschnittRequest;
use App\Models\Kaiserschnitt;
use App\Traits\SaveArzt;

class KaiserschnittController extends Controller
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
    public function store(StoreKaiserschnittRequest $request)
    {
        $kaiserschnitt = new Kaiserschnitt();

        $kaiserschnitt->hund_id = $request->hund_id;
        $kaiserschnitt->datum = $request->datum;
        $kaiserschnitt->anmerkungen = $request->anmerkungen;
        $kaiserschnitt->quelle_id = $request->quelle['id'];
        $kaiserschnitt->arzt_id = $this->saveArzt($request->arzt);
        $kaiserschnitt->save();

        $dokumente = $request['dokumente'];

        foreach ($dokumente as $dokument) {
            $tags = $dokument['tags'];
            unset($dokument['tags']);
            $dokument = $kaiserschnitt->dokumente()->create($dokument);
            $dokument->tags()->sync($tags);
        }

        return ['message' => 'success', 'kaiserschnitt' => $kaiserschnitt];
    }

    /**
     * Display the specified resource.
     */
    public function show(Kaiserschnitt $kaiserschnitt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaiserschnittRequest $request, Kaiserschnitt $kaiserschnitt)
    {
        $kaiserschnitt->hund_id = $request->hund_id;
        $kaiserschnitt->datum = $request->datum;
        $kaiserschnitt->anmerkungen = $request->anmerkungen;
        $kaiserschnitt->quelle_id = $request->quelle['id'];
        $kaiserschnitt->arzt_id = $this->saveArzt($request->arzt);

        $kaiserschnitt->save();

        $dokumente = $request['dokumente'];

        foreach ($dokumente as $dokument) {
            $tags = $dokument['tags'];
            unset($dokument['tags']);
            $dokument = $kaiserschnitt->dokumente()->create($dokument);
            $dokument->tags()->sync($tags);
        }

        return ['message' => 'success', 'kaiserschnitt' => $kaiserschnitt];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kaiserschnitt $kaiserschnitt)
    {
        //
    }
}
