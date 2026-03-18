<?php

namespace App\Http\Controllers;

use App\Models\Zuchtzulassung;
use App\Traits\ApiResponses;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;

class ZuchtzulassungController extends Controller
{
    use ApiResponses;
    use SaveDokumente;

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
        if ($request['id'] == 0) {

            $data = $request->all();

            $zuchtzulassung = Zuchtzulassung::create($data);

            return response()->json([
                'success' => 'Zuchtzulassung gespeichert.',
                'id' => $zuchtzulassung->id,
                'aktiv' => $zuchtzulassung->aktiv,
            ]);
        } else {
            $zuchtzulassung = Zuchtzulassung::find($request['id']);

            $zuchtzulassung->update($request->all());

            return response()->json([
                'success' => 'Zuchtzulassung updated.',
                'id' => $zuchtzulassung->id,
                'aktiv' => $zuchtzulassung->aktiv,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtzulassung $zuchtzulassung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtzulassung $zuchtzulassung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtzulassung $zuchtzulassung)
    {
        //
    }
}
