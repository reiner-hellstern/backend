<?php

namespace App\Http\Controllers;

use App\Models\Anwartschaft;
// use App\Http\Requests\StoreAnwartschaftenTypenRequest;
// use App\Http\Requests\UpdateAnwartschaftenTypenRequest;
use App\Models\Hund;
use Illuminate\Http\Request;

class AnwartschaftController extends Controller
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
     * @param  \App\Http\Requests\StoreAnwartschaftenTypenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $r = $request->all();
        $hund = Hund::find($request->hund);

        $anwartschaft = new Anwartschaft();

        $anwartschaft->hund_id = $request->hund;
        $anwartschaft->anwartschafttyp_id = $request->anwartschaft['anwartschafttyp']['id'];
        $anwartschaft->datum = $request->anwartschaft['datum'];
        $anwartschaft->ort = $request->anwartschaft['ort'];
        $anwartschaft->postleitzahl = $request->anwartschaft['postleitzahl'];
        $anwartschaft->name = $request->anwartschaft['name'];
        // $anwartschaft->richter = $request->anwartschaft->richter;
        $anwartschaft->save();

        return $anwartschaft;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnwartschaftenTypen  $anwartschaftenTypen
     * @return \Illuminate\Http\Response
     */
    public function show(Anwartschaft $anwartschaft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnwartschaftenTypenRequest  $request
     * @param  \App\Models\AnwartschaftenTypen  $anwartschaftenTypen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anwartschaft $anwartschaft)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnwartschaftenTypen  $anwartschaftenTypen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anwartschaft $anwartschaft)
    {
        //
    }
}
