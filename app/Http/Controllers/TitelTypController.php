<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTitelTypRequest;
use App\Http\Requests\UpdateTitelTypRequest;
use App\Http\Resources\TitelTypResource;
use App\Models\TitelTyp;
use Illuminate\Http\Request;

class TitelTypController extends Controller
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
    public function store(StoreTitelTypRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TitelTyp  $titelTypen
     * @return \Illuminate\Http\Response
     */
    public function show(TitelTyp $titeltyp)
    {
        return new TitelTypResource($titeltyp);
    }

    public function autocomplete(Request $request)
    {

        $name = trim($request->n);
        $name_kurz = '';
        $extern = trim($request->e);
        $drc = trim($request->d);
        $land = trim($request->l);

        //  $count = TitelTyp::when( $name !='', function($query) use ($name) {
        //     return $query->where('name', 'LIKE', '%'.$name.'%');
        //  })->when( $name_kurz !='', function($query) use ($name_kurz) {
        //     return $query->where('name_kurz', 'LIKE', ''.$name_kurz.'%');
        //  })->when( $land !='', function($query) use ($land) {
        //     return $query->where('land', 'LIKE', '%'.$land.'%');
        //  })->when( $verband !='', function($query) use ($verband) {
        //     return $query->where('verband_verein', 'LIKE', '%'.$verband.'%');
        //  })->count();

        $titeltypen = TitelTyp::select('parent', 'extern', 'name', 'name_kurz', 'land', 'kategorie', 'feldbezeichner', 'id')
            ->when($extern == true, function ($query) {
                return $query->where('extern', 1);
            })
            ->when($drc == true, function ($query) {
                return $query->where('drc', 1);
            })
            ->when($name != '', function ($query) use ($name) {
                return $query->where('name', 'LIKE', '%' . $name . '%');
            })
            ->where('parent', '>', 0)
            ->get();

        return [
            'result' => $titeltypen,
        ];

    }

    public function autocomplete_select(Request $request)
    {

        $name = trim($request->n);
        $name_kurz = '';

        //  $count = TitelTyp::when( $name !='', function($query) use ($name) {
        //     return $query->where('name', 'LIKE', '%'.$name.'%');
        //  })->when( $name_kurz !='', function($query) use ($name_kurz) {
        //     return $query->where('name_kurz', 'LIKE', ''.$name_kurz.'%');
        //  })->when( $land !='', function($query) use ($land) {
        //     return $query->where('land', 'LIKE', '%'.$land.'%');
        //  })->when( $verband !='', function($query) use ($verband) {
        //     return $query->where('verband_verein', 'LIKE', '%'.$verband.'%');
        //  })->count();

        $titeltypen = TitelTyp::select('parent', 'extern', 'name', 'name_kurz', 'land', 'kategorie', 'feldbezeichner', 'id', 'ausrichter_label')
            ->when($name != '', function ($query) use ($name) {
                return $query->where('name', 'LIKE', '%' . $name . '%')->orWhere('name_kurz', 'LIKE', '%' . $name . '%');
            })->with('ausrichters', 'tags')->get();

        return [
            //  'result' => $titeltypen[0],
            'result' => TitelTypResource::collection($titeltypen),
        ];

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTitelTypRequest $request, TitelTyp $titelTypen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TitelTyp $titelTypen)
    {
        //
    }
}
