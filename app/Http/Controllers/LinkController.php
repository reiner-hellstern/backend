<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $links = Link::with('kategorie')
            ->where('aktiv', true)
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => 'Links erfolgreich geladen',
            'data' => LinkResource::collection($links),
            'error' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request): JsonResponse
    {
        // Bestimme die nächste Order-Nummer für diese Kategorie
        $maxOrder = Link::where('linkkategorie_id', $request->linkkategorie_id)->max('order') ?? 0;

        $linkData = $request->validated();
        $linkData['order'] = $maxOrder + 1;

        $link = Link::create($linkData);
        $link->load('kategorie');

        return response()->json([
            'success' => 'Link erfolgreich erstellt',
            'data' => new LinkResource($link),
            'error' => null,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link): JsonResponse
    {
        $link->load('kategorie');

        return response()->json([
            'success' => 'Link erfolgreich geladen',
            'data' => new LinkResource($link),
            'error' => null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link): JsonResponse
    {
        $link->update($request->validated());
        $link->load('kategorie');

        return response()->json([
            'success' => 'Link erfolgreich aktualisiert',
            'data' => new LinkResource($link),
            'error' => null,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link): JsonResponse
    {
        // Soft delete durch Setzen von aktiv = false
        $link->update(['aktiv' => false]);

        return response()->json([
            'success' => 'Link erfolgreich deaktiviert',
            'data' => null,
            'error' => null,
        ]);
    }

    /**
     * Update the order of links within a category.
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'links' => 'required|array',
            'links.*.id' => 'required|exists:links,id',
            'links.*.order' => 'required|integer|min:1',
        ]);

        foreach ($request->links as $linkData) {
            Link::where('id', $linkData['id'])
                ->update(['order' => $linkData['order']]);
        }

        return response()->json([
            'success' => 'Reihenfolge der Links erfolgreich aktualisiert',
            'data' => null,
            'error' => null,
        ]);
    }
}
