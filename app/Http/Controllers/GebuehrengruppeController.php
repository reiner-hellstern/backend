<?php

namespace App\Http\Controllers;

use App\Models\Gebuehrengruppe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GebuehrengruppeController extends Controller
{
    /**
     * Liste aller Gebührengruppen
     */
    public function index(): JsonResponse
    {
        $gruppen = Gebuehrengruppe::with('gebuehrenkatalog.gebuehren')
            ->withCount('gebuehrenkatalog as katalog_count')
            ->geordnet()
            ->get();

        return response()->json([
            'data' => $gruppen,
            'success' => true,
        ]);
    }

    /**
     * Eine spezifische Gebührengruppe anzeigen
     */
    public function show(Gebuehrengruppe $gebuehrengruppe): JsonResponse
    {
        $gebuehrengruppe->load('gebuehrenkatalog.gebuehren');

        return response()->json([
            'data' => $gebuehrengruppe,
            'success' => true,
        ]);
    }

    /**
     * Neue Gebührengruppe erstellen
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschreibung' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        // Auto-Sortierung wenn nicht angegeben
        if (! isset($validated['order'])) {
            $maxOrder = Gebuehrengruppe::max('order') ?? 0;
            $validated['order'] = $maxOrder + 10;
        }

        $gruppe = Gebuehrengruppe::create($validated);

        return response()->json([
            'data' => $gruppe,
            'success' => true,
            'message' => 'Gebührengruppe erfolgreich erstellt.',
        ], 201);
    }

    /**
     * Gebührengruppe aktualisieren
     */
    public function update(Request $request, Gebuehrengruppe $gebuehrengruppe): JsonResponse
    {
        // Nur die tatsächlich gesendeten Felder validieren
        $rules = [];

        if ($request->has('name')) {
            $rules['name'] = 'required|string|max:255';
        }

        if ($request->has('beschreibung')) {
            $rules['beschreibung'] = 'nullable|string|max:255';
        }

        if ($request->has('order')) {
            $rules['order'] = 'nullable|integer';
        }

        $validated = $request->validate($rules);

        $gebuehrengruppe->update($validated);

        return response()->json([
            'data' => $gebuehrengruppe,
            'success' => true,
            'message' => 'Gebührengruppe erfolgreich aktualisiert.',
        ]);
    }

    /**
     * Gebührengruppe löschen
     */
    public function destroy(Gebuehrengruppe $gebuehrengruppe): JsonResponse
    {
        // Prüfen ob noch Katalog-Einträge vorhanden sind
        if ($gebuehrengruppe->gebuehrenkatalog()->exists()) {
            return response()->json([
                'success' => false,
                'error' => 'Gruppe kann nicht gelöscht werden, da noch Katalog-Einträge vorhanden sind.',
            ], 422);
        }

        try {
            // Löschung durchführen und Ergebnis prüfen
            $deleted = $gebuehrengruppe->delete();

            if (! $deleted) {
                return response()->json([
                    'success' => false,
                    'error' => 'Gebührengruppe konnte nicht gelöscht werden.',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gebührengruppe erfolgreich gelöscht.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Löschen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reihenfolge mehrerer Gebührengruppen auf einmal aktualisieren
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'groups' => 'required|array',
            'groups.*.id' => 'required|integer|exists:gebuehrengruppen,id',
            'groups.*.order' => 'required|integer',
        ]);

        try {
            foreach ($validated['groups'] as $groupData) {
                Gebuehrengruppe::where('id', $groupData['id'])
                    ->update(['order' => $groupData['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reihenfolge erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fehler beim Aktualisieren der Reihenfolge: ' . $e->getMessage(),
            ], 500);
        }
    }
}
