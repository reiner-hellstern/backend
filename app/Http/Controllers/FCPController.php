<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFCPRequest;
use App\Http\Requests\UpdateFCPRequest;
use App\Models\FCP;
use App\Traits\SaveArzt;

class FCPController extends Controller
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
    public function store(StoreFCPRequest $request)
    {

        $fcp = new FCP();
        $fcp->anmerkungen = $request->anmerkungen;
        $fcp->datum = $request->datum;
        $fcp->operation = $request->operation;
        $fcp->grund_operation = $request->grund_operation;
        $fcp->grund_operation_id = $request->grund_operation_id;
        $fcp->hund_id = $request->hund_id;

        $fcp->arzt_id = $this->saveArzt($request->arzt);

        $fcp->save();

        return ['message' => 'success', 'fcp' => $fcp];
    }

    /**
     * Display the specified resource.
     */
    public function show(FCP $fcp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFCPRequest $request, FCP $fcp)
    {

        $fcp->anmerkungen = $request->anmerkungen;
        $fcp->datum = $request->datum;
        $fcp->operation = $request->operation;
        $fcp->grund_operation = $request->grund_operation;
        $fcp->grund_operation_id = $request->grund_operation_id;

        $fcp->arzt_id = $this->saveArzt($request->arzt);

        $fcp->save();

        return response()->json(['message' => 'success', 'fcp' => $fcp], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FCP $fcp)
    {
        //
    }
}
