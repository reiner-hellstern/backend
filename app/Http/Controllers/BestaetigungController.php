<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBestaetigungRequest;
use App\Http\Requests\UpdateBestaetigungRequest;
use App\Models\Bestaetigung;
use Illuminate\Http\Request;

class BestaetigungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBestaetigungRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bestaetigung $bestaetigung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bestaetigung $bestaetigung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBestaetigungRequest $request, Bestaetigung $bestaetigung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirm(Request $request, Bestaetigung $bestaetigung)
    {
        $bestaetigung->update(['bestaetigt' => 1, 'abgelehnt' => 0]);

        //   $model = $bestaetigung->bestaetigungable_type;
        //   $id = $bestaetigung->bestaetigungable_id;

        //   $model::find($id);

        return 'Bestätigung gespeichert.';
    }

    /**
     * Update the specified resource in storage.
     */
    public function reject(Request $request, Bestaetigung $bestaetigung)
    {
        $bestaetigung->update(['bestaetigt' => 0, 'abgelehnt' => 1]);

        //   $model = $bestaetigung->bestaetigungable_type;
        //   $id = $bestaetigung->bestaetigungable_id;

        //   $model::find($id);

        return 'Ablehnung gespeichert.';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bestaetigung $bestaetigung)
    {
        //
    }
}
