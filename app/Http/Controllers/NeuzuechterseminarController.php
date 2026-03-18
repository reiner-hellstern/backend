<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNeuzuechterseminarRequest;
use App\Http\Requests\UpdateNeuzuechterseminarRequest;
use App\Http\Resources\NeuzuechterseminarResource;
use App\Models\Neuzuechterseminar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NeuzuechterseminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $neuzuechterseminare = Neuzuechterseminar::with(['person', 'bestaetigtVon', 'event', 'dokumente'])
            ->when($request->person_id, function ($query, $personId) {
                return $query->where('person_id', $personId);
            })
            ->orderBy('datum', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => NeuzuechterseminarResource::collection($neuzuechterseminare),
            'message' => 'Neuzüchterseminare erfolgreich geladen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNeuzuechterseminarRequest $request): JsonResponse
    {
        try {
            $neuzuechterseminar = Neuzuechterseminar::create($request->validated());

            $neuzuechterseminar->load(['person', 'bestaetigtVon', 'event']);

            return response()->json([
                'success' => true,
                'data' => new NeuzuechterseminarResource($neuzuechterseminar),
                'message' => 'Neuzüchterseminar erfolgreich gespeichert',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Speichern des Neuzüchterseminars: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Neuzuechterseminar $neuzuechterseminar)
    {
        $neuzuechterseminar->load(['person', 'bestaetigtVon', 'event', 'dokumente']);

        return response()->json([
            'success' => 'Neuzüchterseminar erfolgreich geladen',
            'data' => new NeuzuechterseminarResource($neuzuechterseminar),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNeuzuechterseminarRequest $request, Neuzuechterseminar $neuzuechterseminar): JsonResponse
    {
        try {
            $neuzuechterseminar->update($request->validated());

            $neuzuechterseminar->load(['person', 'bestaetigtVon', 'event']);

            return response()->json([
                'success' => true,
                'data' => new NeuzuechterseminarResource($neuzuechterseminar),
                'message' => 'Neuzüchterseminar erfolgreich aktualisiert',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren des Neuzüchterseminars: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Neuzuechterseminar $neuzuechterseminar): JsonResponse
    {
        try {
            $neuzuechterseminar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Neuzüchterseminar erfolgreich gelöscht',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Löschen des Neuzüchterseminars: ' . $e->getMessage(),
            ], 500);
        }
    }
}
