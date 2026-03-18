<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaborRequest;
use App\Http\Requests\UpdateLaborRequest;
use App\Models\Labor;
use Illuminate\Http\Request;

class LaborController extends Controller
{
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
    public function store(StoreLaborRequest $request)
    {

        $labor = Labor::where('name', $request->name)
            ->where('strasse', $request->strasse)
            ->where('postleitzahl', $request->plz)
            ->where('ort', $request->ort)
            ->first();

        if ($labor) {
            return response()->json(['message' => 'Labor bereits vorhanden'], 409);
        } else {
            $labor = Labor::create([
                'name' => $request->name,
                'strasse' => $request->strasse,
                'postleitzahl' => $request->plz,
                'ort' => $request->ort,
            ]);

            return response()->json($labor, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Labor $labor)
    {
        return $labor;
    }

    public function autocomplete(Request $request)
    {

        $name = trim($request->name);
        $strasse = trim($request->str);
        $plz = trim($request->plz);
        $ort = trim($request->ort);
        $complete = $request->c;
        $main = $request->m;

        $count = Labor::when($strasse != '', function ($query) use ($strasse) {
            return $query->where('strasse', 'LIKE', '%' . $strasse . '%');
        })->when($plz != '', function ($query) use ($plz) {
            return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
        })->when($ort != '', function ($query) use ($ort) {
            return $query->where('ort', 'LIKE', '%' . $ort . '%');
        })->when($name != '', function ($query) use ($name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        })
            ->count();

        if ($count <= 10) {
            $complete = true;
            $labore = Labor::select('name', 'strasse', 'postleitzahl', 'ort')
                ->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })->when($name != '', function ($query) use ($name) {
                    return $query->where('name', 'LIKE', '%' . $name . '%');
                })
                ->limit(10)->orderBy($main, 'asc')->get();
        } else {

            $count = Labor::when($strasse != '', function ($query) use ($strasse) {
                return $query->where('strasse', 'LIKE', '' . $strasse . '%');
            })->when($plz != '', function ($query) use ($plz) {
                return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
            })->when($ort != '', function ($query) use ($ort) {
                return $query->where('ort', 'LIKE', '%' . $ort . '%');
            })->when($name != '', function ($query) use ($name) {
                return $query->where('name', 'LIKE', '%' . $name . '%');
            })->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')
                ->count();

            if ($count < 200) {
                $complete = false;
                $labore = Labor::when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })->when($name != '', function ($query) use ($name) {
                    return $query->where('name', 'LIKE', '%' . $name . '%');
                })
                    ->limit(200)->orderBy($main, 'asc')->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')->pluck($main);
            } else {
                $labore = [];
                $complete = false;
            }
        }

        return [
            'complete' => $complete,
            'labore' => $count,
            'result' => $labore,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaborRequest $request, Labor $labor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Labor $labor)
    {
        //
    }
}
