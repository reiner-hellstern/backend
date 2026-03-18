<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePruefungTypRequest;
use App\Http\Requests\UpdatePruefungTypRequest;
use App\Http\Resources\PruefungTypResource;
use App\Models\PruefungTyp;
use Illuminate\Http\Request;

class PruefungTypController extends Controller
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
    public function store(StorePruefungTypRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PruefungTyp  $PruefungTyp
     * @return \Illuminate\Http\Response
     */
    public function show(PruefungTyp $pruefungstyp)
    {
        return new PruefungTypResource($pruefungstyp);
    }

    public function autocomplete(Request $request)
    {

        $name = trim($request->n);
        $name_kurz = '';
        $land = trim($request->l);
        $verband = trim($request->vv);

        //  $count = TitelTyp::when( $name !='', function($query) use ($name) {
        //     return $query->where('name', 'LIKE', '%'.$name.'%');
        //  })->when( $name_kurz !='', function($query) use ($name_kurz) {
        //     return $query->where('name_kurz', 'LIKE', ''.$name_kurz.'%');
        //  })->when( $land !='', function($query) use ($land) {
        //     return $query->where('land', 'LIKE', '%'.$land.'%');
        //  })->when( $verband !='', function($query) use ($verband) {
        //     return $query->where('verband_verein', 'LIKE', '%'.$verband.'%');
        //  })->count();

        $titeltypen = PruefungTyp::select('name', 'name_kurz', 'land', 'verband_verein', 'id')
            ->when($name != '', function ($query) use ($name) {
                return $query->where('name', 'LIKE', '%' . $name . '%')->orWhere('name_kurz', 'LIKE', '%' . $name . '%');
            })->when($land != '', function ($query) use ($land) {
                return $query->where('land', 'LIKE', '%' . $land . '%');
            })->when($verband != '', function ($query) use ($verband) {
                return $query->where('verband_verein', 'LIKE', '%' . $verband . '%');
            })->get();

        return [
            'result' => $titeltypen,
        ];

    }

    public function autocomplete_select(Request $request)
    {

        $name = trim($request->n);
        $name_kurz = '';
        $type = trim($request->t);

        //  $count = TitelTyp::when( $name !='', function($query) use ($name) {
        //     return $query->where('name', 'LIKE', '%'.$name.'%');
        //  })->when( $name_kurz !='', function($query) use ($name_kurz) {
        //     return $query->where('name_kurz', 'LIKE', ''.$name_kurz.'%');
        //  })->when( $land !='', function($query) use ($land) {
        //     return $query->where('land', 'LIKE', '%'.$land.'%');
        //  })->when( $verband !='', function($query) use ($verband) {
        //     return $query->where('verband_verein', 'LIKE', '%'.$verband.'%');
        //  })->count();

        $titeltypen = PruefungTyp::select('name', 'name_kurz', 'id', 'classement_label', 'ausrichter_label', 'wertung_label', 'zusatz_label', 'extern')
            ->when($name != '', function ($query) use ($name) {
                return $query->where(function ($q) use ($name) {
                    $q->where('name', 'LIKE', '%' . $name . '%')->orWhere('name_kurz', 'LIKE', '%' . $name . '%');
                });
            })->when($type == 'drc', function ($query) {
                return $query->where('extern', '=', 0);
            })->when($type == 'extern', function ($query) {
                return $query->where('extern', '=', 1);
            })->with('classements', 'wertungen', 'ausrichters', 'zusaetze', 'tags')->get();

        return [
            'result' => PruefungTypResource::collection($titeltypen),
            'type' => $type,
        ];

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePruefungTypRequest $request, PruefungTyp $PruefungTyp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PruefungTyp $PruefungTyp)
    {
        //
    }
}
