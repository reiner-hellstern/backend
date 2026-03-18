<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;

class LandController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Land $land)
    {
        //
    }

    public function autocomplete(Request $request)
    {

        $land = trim($request->l);

        $laender = Land::select('laender.id', 'laender.code', 'laender.de')
            ->when($land != '', function ($query) use ($land) {
                return $query->where('laender.de', 'LIKE', '%' . $land . '%');
            })
            ->orderBy('laender.de', 'asc')->get();

        return $laender;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Land $land)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Land $land)
    {
        //
    }
}
