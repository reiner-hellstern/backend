<?php

namespace App\Http\Controllers;

use App\Models\Gebuehr;
use App\Models\Gebuehrenkatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GebuehrenkatalogController extends Controller
{
    /**
     * Liste aller Katalog-Einträge
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gebuehrenkatalog::with(['gebuehrengruppe', 'gebuehren'])
            ->withCount('gebuehren as verwendung_count');

        // Filter nach Gruppe
        if ($request->has('gebuehrengruppe_id')) {
            $query->where('gebuehrengruppe_id', $request->gebuehrengruppe_id);
        }

        $katalog = $query->nachName()->get();

        return response()->json([
            'data' => $katalog,
            'success' => true,
        ]);
    }

    /**
     * Einen spezifischen Katalog-Eintrag anzeigen
     */
    public function show(Gebuehrenkatalog $gebuehrenkatalog): JsonResponse
    {
        $gebuehrenkatalog->load(['gebuehrengruppe', 'gebuehren']);

        return response()->json([
            'data' => $gebuehrenkatalog,
            'success' => true,
        ]);
    }

    /**
     * Neuen Katalog-Eintrag erstellen
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschreibung' => 'nullable|string',
            'gebuehrengruppe_id' => 'required|exists:gebuehrengruppen,id',
            'mkonto' => 'nullable|boolean',
        ]);

        $katalogEintrag = Gebuehrenkatalog::create($validated);
        $katalogEintrag->load('gebuehrengruppe');

        return response()->json([
            'data' => $katalogEintrag,
            'success' => true,
            'message' => 'Katalog-Eintrag erfolgreich erstellt.',
        ], 201);
    }

    /**
     * Katalog-Eintrag aktualisieren
     */
    public function update(Request $request, Gebuehrenkatalog $gebuehrenkatalog): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschreibung' => 'nullable|string',
            'gebuehrengruppe_id' => 'required|exists:gebuehrengruppen,id',
            'mkonto' => 'nullable|boolean',
        ]);

        $gebuehrenkatalog->update($validated);
        $gebuehrenkatalog->load('gebuehrengruppe');

        return response()->json([
            'data' => $gebuehrenkatalog,
            'success' => true,
            'message' => 'Katalog-Eintrag erfolgreich aktualisiert.',
        ]);
    }

    /**
     * Katalog-Eintrag löschen
     */
    public function destroy(Gebuehrenkatalog $gebuehrenkatalog): JsonResponse
    {
        // Prüfen ob noch Gebühren vorhanden sind
        if ($gebuehrenkatalog->gebuehren()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Katalog-Eintrag kann nicht gelöscht werden, da noch Gebühren vorhanden sind.',
            ], 422);
        }

        $gebuehrenkatalog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Katalog-Eintrag erfolgreich gelöscht.',
        ]);
    }

    /**
     * Gebühr für Katalog-Eintrag setzen/aktualisieren
     */
    public function setGebuehr(Request $request, Gebuehrenkatalog $gebuehrenkatalog): JsonResponse
    {
        $validated = $request->validate([
            'gebuehrenordnung_id' => 'required|exists:gebuehrenordnung,id',
            'kosten_mitglied' => 'required|numeric|min:0',
            'kosten_nichtmitglied' => 'required|numeric|min:0',
            'gueltig_ab' => 'nullable|date',
            'gueltig_bis' => 'nullable|date|after:gueltig_ab',
            'aktiv' => 'boolean',
        ]);

        // Standard-Werte setzen
        $validated['aktiv'] = $validated['aktiv'] ?? true;
        if (! isset($validated['gueltig_ab'])) {
            $gebuehrenordnung = \App\Models\Gebuehrenordnung::find($validated['gebuehrenordnung_id']);
            $validated['gueltig_ab'] = $gebuehrenordnung->gueltig_ab;
            $validated['gueltig_bis'] = $gebuehrenordnung->gueltig_bis;
        }

        $gebuehr = Gebuehr::updateOrCreate(
            [
                'gebuehrenkatalog_id' => $gebuehrenkatalog->id,
                'gebuehrenordnung_id' => $validated['gebuehrenordnung_id'],
            ],
            [
                'kosten_mitglied' => $validated['kosten_mitglied'],
                'kosten_nichtmitglied' => $validated['kosten_nichtmitglied'],
                'gueltig_ab' => $validated['gueltig_ab'],
                'gueltig_bis' => $validated['gueltig_bis'],
                'aktiv' => $validated['aktiv'],
            ]
        );

        $gebuehr->load(['gebuehrenkatalog', 'gebuehrenordnung']);

        return response()->json([
            'data' => $gebuehr,
            'success' => true,
            'message' => 'Gebühr erfolgreich gesetzt.',
        ]);
    }
}
