<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkkategorieRequest;
use App\Http\Requests\UpdateLinkkategorieRequest;
use App\Http\Resources\LinkkategorieResource;
use App\Models\Linkkategorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkkategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $kategorien = Linkkategorie::with(['links' => function ($query) {
            $query->where('aktiv', true)->ordered();
        }])
            ->where('aktiv', true)
            ->ordered()
            ->get();

        return response()->json([
            'success' => 'Linkkategorien erfolgreich geladen',
            'data' => LinkkategorieResource::collection($kategorien),
            'error' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkkategorieRequest $request): JsonResponse
    {
        $maxOrder = Linkkategorie::max('order') ?? 0;

        $kategorie = Linkkategorie::create([
            'name' => $request->name,
            'name_kurz' => $request->name_kurz,
            'aktiv' => true,
            'order' => $maxOrder + 1,
        ]);

        return response()->json([
            'success' => 'Linkkategorie erfolgreich erstellt',
            'data' => new LinkkategorieResource($kategorie),
            'error' => null,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Linkkategorie $linkkategorie): JsonResponse
    {
        $linkkategorie->load(['links' => function ($query) {
            $query->where('aktiv', true)->ordered();
        }]);

        return response()->json([
            'success' => 'Linkkategorie erfolgreich geladen',
            'data' => new LinkkategorieResource($linkkategorie),
            'error' => null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkkategorieRequest $request, Linkkategorie $linkkategorie): JsonResponse
    {

        $linkkategorie->update($request->validated());

        return response()->json([
            'success' => 'Linkkategorie erfolgreich aktualisiert',
            'data' => new LinkkategorieResource($linkkategorie),
            'error' => null,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Linkkategorie $linkkategorie): JsonResponse
    {
        // Soft delete durch Setzen von aktiv = false
        $linkkategorie->update(['aktiv' => false]);

        return response()->json([
            'success' => 'Linkkategorie erfolgreich deaktiviert',
            'data' => null,
            'error' => null,
        ]);
    }

    /**
     * Update the order of categories.
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'kategorien' => 'required|array',
            'kategorien.*.id' => 'required|exists:linkkategorien,id',
            'kategorien.*.order' => 'required|integer|min:1',
        ]);

        foreach ($request->kategorien as $kategorieData) {
            Linkkategorie::where('id', $kategorieData['id'])
                ->update(['order' => $kategorieData['order']]);
        }

        return response()->json([
            'success' => 'Reihenfolge erfolgreich aktualisiert',
            'data' => null,
            'error' => null,
        ]);
    }
}
