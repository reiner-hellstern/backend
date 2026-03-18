<?php

namespace App\Http\Controllers;

use App\Models\Zuchtverbot;
use Illuminate\Http\Request;

class ZuchtverbotController extends Controller
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
        if ($request['id'] == 0) {

            $data = $request->all();

            $zuchtverbot = Zuchtverbot::create($data);

            return response()->json([
                'success' => 'Zuchtverbot gespeichert.',
                'id' => $zuchtverbot->id,
                'aktiv' => $zuchtverbot->aktiv,
            ]);
        } else {
            $zuchtverbot = Zuchtverbot::find($request['id']);

            $zuchtverbot->update($request->all());

            return response()->json([
                'success' => 'Zuchtverbot updated.',
                'id' => $zuchtverbot->id,
                'aktiv' => $zuchtverbot->aktiv,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtverbot $zuchtverbot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtverbot $zuchtverbot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtverbot $zuchtverbot)
    {
        //
    }
}
