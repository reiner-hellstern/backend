<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZweitwohnsitznachweisRequest;
use App\Http\Requests\UpdateZweitwohnsitznachweisRequest;
use App\Http\Resources\ZweitwohnsitznachweisResource;
use App\Models\Zweiwohnsitznachweis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ZweitwohnsitznachweisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $zweitwohnsitznachweise = Zweiwohnsitznachweis::with(['person', 'zuchtstaette', 'bestaetigtVon', 'dokumente'])
            ->when($request->person_id, function ($query, $personId) {
                return $query->where('person_id', $personId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => ZweitwohnsitznachweisResource::collection($zweitwohnsitznachweise),
            'success' => 'Zweitwohnsitznachweise erfolgreich geladen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZweitwohnsitznachweisRequest $request): JsonResponse
    {
        try {
            $zweiwohnsitznachweis = Zweiwohnsitznachweis::create($request->validated());

            return response()->json([
                'success' => 'Zweitwohnsitznachweis erfolgreich gespeichert',
                'data' => new ZweitwohnsitznachweisResource($zweiwohnsitznachweis),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Speichern des Zweitwohnsitznachweises: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Zweiwohnsitznachweis $zweiwohnsitznachweis): JsonResponse
    {
        $zweiwohnsitznachweis->load(['person', 'zuchtstaette', 'bestaetigtVon', 'dokumente']);

        return response()->json([
            'data' => new ZweitwohnsitznachweisResource($zweiwohnsitznachweis),
            'success' => 'Zweitwohnsitznachweis erfolgreich geladen',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZweitwohnsitznachweisRequest $request, Zweiwohnsitznachweis $zweiwohnsitznachweis): JsonResponse
    {
        try {
            $zweiwohnsitznachweis->update($request->validated());

            $zweiwohnsitznachweis->load(['person', 'zuchtstaette', 'bestaetigtVon']);

            return response()->json([
                'data' => new ZweitwohnsitznachweisResource($zweiwohnsitznachweis),
                'success' => 'Zweitwohnsitznachweis erfolgreich aktualisiert',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Zweitwohnsitznachweises: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zweiwohnsitznachweis $zweiwohnsitznachweis): JsonResponse
    {
        try {
            $zweiwohnsitznachweis->delete();

            return response()->json([
                'success' => true,
                'message' => 'Zweitwohnsitznachweis erfolgreich gelöscht',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Löschen des Zweitwohnsitznachweises: ' . $e->getMessage(),
            ], 500);
        }
    }
}
