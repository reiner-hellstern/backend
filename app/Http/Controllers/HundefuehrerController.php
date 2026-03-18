<?php

namespace App\Http\Controllers;

use App\Models\Hundefuehrer;
use Illuminate\Http\Request;

class HundefuehrerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $sortField = $request->input('sort_field', 'mitglied_nr');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function anmeldungen(Hundefuehrer $hundefuehrer)
    {

        return $hundefuehrer->anmeldungen;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function meldungen(Hundefuehrer $hundefuehrer)
    {

        return $hundefuehrer->meldungen;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hundefuehrer $hundefuehrer)
    {
        return $hundefuehrer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hundefuehrer $hundefuehrer)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hundefuehrer $hundefuehrer)
    {
        return $hundefuehrer;
    }
}
