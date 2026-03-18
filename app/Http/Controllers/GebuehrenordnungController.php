<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGebuehrenordnungRequest;
use App\Models\Gebuehr;
use App\Models\Gebuehrengruppe;
use App\Models\Gebuehrenkatalog;
use App\Models\Gebuehrenordnung;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GebuehrenordnungController extends Controller
{
    /**
     * Liste aller Gebührenordnungen mit ihren gruppierten Gebühren
     */
    public function index(): JsonResponse
    {
        $gebuehrenordnungen = Gebuehrenordnung::with([
            'gebuehren.katalog.gebuehrengruppe',
        ])->orderBy('gueltig_ab', 'desc')->get();

        // Bestimme die aktuelle Gebührenordnung basierend auf dem heutigen Datum
        $today = now()->format('Y-m-d');
        $currentFound = false;

        $gebuehrenordnungen = $gebuehrenordnungen->map(function ($go) use ($today, &$currentFound) {
            $isInRange = $go->gueltig_ab <= $today &&
                        ($go->gueltig_bis === null || $go->gueltig_bis >= $today);

            // Nur die erste gefundene als current markieren (neueste zuerst wegen ORDER BY)
            if ($isInRange && ! $currentFound) {
                $go->is_current = true;
                $currentFound = true;
            } else {
                $go->is_current = false;
            }

            // Gruppiere die Gebühren nach Gruppen
            $gebuehrenByGroup = $go->gebuehren->groupBy(function ($gebuehr) {
                return $gebuehr->katalog->gebuehrengruppe->id ?? 'ungrouped';
            });

            $groupedGebuehren = [];

            // Hole alle Gruppen sortiert nach order
            $gruppen = Gebuehrengruppe::orderBy('order')->get();

            foreach ($gruppen as $gruppe) {
                if ($gebuehrenByGroup->has($gruppe->id)) {
                    $groupedGebuehren[] = [
                        'id' => $gruppe->id,
                        'name' => $gruppe->name,
                        'order' => $gruppe->order,
                        'gebuehren' => $gebuehrenByGroup[$gruppe->id]->sortBy('order')->values(),
                    ];
                }
            }

            // Ungruppierte Gebühren am Ende hinzufügen
            if ($gebuehrenByGroup->has('ungrouped')) {
                $groupedGebuehren[] = [
                    'id' => 'ungrouped',
                    'name' => 'Sonstige',
                    'order' => 999,
                    'gebuehren' => $gebuehrenByGroup['ungrouped']->sortBy('order')->values(),
                ];
            }

            $go->grouped_gebuehren = $groupedGebuehren;

            return $go;
        });

        return response()->json([
            'data' => $gebuehrenordnungen,
            'success' => true,
        ]);
    }

    /**
     * Eine spezifische Gebührenordnung anzeigen
     */
    public function show(Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        $gebuehrenordnung->load([
            'gebuehren.katalog.gruppe',
        ]);

        return response()->json([
            'data' => $gebuehrenordnung,
            'success' => true,
        ]);
    }

    /**
     * Neue Gebührenordnung erstellen
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gueltig_ab' => 'required|date',
            'gueltig_bis' => 'nullable|date|after:gueltig_ab',
            'stand' => 'nullable|date',
            'copy_from_id' => 'nullable|integer|exists:gebuehrenordnung,id',
        ]);

        $gebuehrenordnung = Gebuehrenordnung::create([
            'name' => $validated['name'],
            'gueltig_ab' => $validated['gueltig_ab'],
            'gueltig_bis' => $validated['gueltig_bis'] ?? null,
            'stand' => $validated['stand'] ?? $validated['gueltig_ab'],
        ]);

        // Gebühren aus anderer Ordnung kopieren, falls gewünscht
        if (isset($validated['copy_from_id'])) {
            $sourceGebuehren = Gebuehr::where('gebuehrenordnung_id', $validated['copy_from_id'])->get();

            foreach ($sourceGebuehren as $sourceGebuehr) {
                Gebuehr::create([
                    'gebuehrenkatalog_id' => $sourceGebuehr->gebuehrenkatalog_id,
                    'gebuehrenordnung_id' => $gebuehrenordnung->id,
                    'kosten_mitglied' => $sourceGebuehr->kosten_mitglied,
                    'kosten_nichtmitglied' => $sourceGebuehr->kosten_nichtmitglied,
                    'gueltig_ab' => $gebuehrenordnung->gueltig_ab,
                    'gueltig_bis' => $gebuehrenordnung->gueltig_bis,
                    'aktiv' => $sourceGebuehr->aktiv,
                    'order' => $sourceGebuehr->order,
                ]);
            }
        }

        // Lade die komplette Gebührenordnung mit gruppierten Gebühren für Antwort
        $gebuehrenordnung->load([
            'gebuehren.katalog.gebuehrengruppe',
        ]);

        // Gruppiere die Gebühren wie in der index-Methode
        $gebuehrenByGroup = $gebuehrenordnung->gebuehren->groupBy(function ($gebuehr) {
            return $gebuehr->katalog->gebuehrengruppe->id ?? 'ungrouped';
        });

        $groupedGebuehren = [];
        $gruppen = \App\Models\Gebuehrengruppe::orderBy('order')->get();

        foreach ($gruppen as $gruppe) {
            if ($gebuehrenByGroup->has($gruppe->id)) {
                $groupedGebuehren[] = [
                    'id' => $gruppe->id,
                    'name' => $gruppe->name,
                    'order' => $gruppe->order,
                    'gebuehren' => $gebuehrenByGroup[$gruppe->id]->sortBy('order')->values(),
                ];
            }
        }

        if ($gebuehrenByGroup->has('ungrouped')) {
            $groupedGebuehren[] = [
                'id' => 'ungrouped',
                'name' => 'Sonstige',
                'order' => 999,
                'gebuehren' => $gebuehrenByGroup['ungrouped']->sortBy('order')->values(),
            ];
        }

        $gebuehrenordnung->grouped_gebuehren = $groupedGebuehren;

        return response()->json([
            'data' => $gebuehrenordnung,
            'success' => true,
        ], 201);
    }

    /**
     * Gebührenordnung aktualisieren
     */
    public function update(UpdateGebuehrenordnungRequest $request, $id): JsonResponse
    {
        $gebuehrenordnung = Gebuehrenordnung::findOrFail($id);
        $validated = $request->validated();

        $gebuehrenordnung->update($validated);

        return response()->json([
            'data' => null,
            'success' => 'Gebührenordnung erfolgreich aktualisiert',
            'error' => null,
        ]);
    }

    /**
     * Gebührenordnung löschen (zusammen mit allen zugewiesenen Gebühren)
     */
    public function destroy(Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        // Debug: Log den Löschversuch
        \Log::info('DELETE Gebührenordnung called', [
            'id' => $gebuehrenordnung->id,
            'name' => $gebuehrenordnung->name,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
        ]);

        // Zähle die zugewiesenen Gebühren für die Bestätigung
        $anzahlGebuehren = $gebuehrenordnung->gebuehren()->count();
        $name = $gebuehrenordnung->name;

        try {
            // Lösche zuerst alle zugewiesenen Gebühren
            $deletedGebuehren = $gebuehrenordnung->gebuehren()->delete();
            \Log::info('Deleted Gebühren', ['count' => $deletedGebuehren]);

            // Lösche dann die Gebührenordnung selbst
            $deleted = $gebuehrenordnung->delete();
            \Log::info('Deleted Gebührenordnung', ['success' => $deleted]);

            if (! $deleted) {
                \Log::error('Failed to delete Gebührenordnung', ['id' => $gebuehrenordnung->id]);

                return response()->json([
                    'success' => false,
                    'data' => null,
                    'error' => 'Gebührenordnung konnte nicht gelöscht werden',
                ], 500);
            }

            return response()->json([
                'success' => "Gebührenordnung '{$name}' wurde erfolgreich gelöscht" .
                            ($anzahlGebuehren > 0 ? " (einschließlich {$anzahlGebuehren} Gebühren)" : ''),
                'data' => null,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Exception during delete', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'Fehler beim Löschen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Gebührengruppen einer Gebührenordnung mit Katalog-Einträgen
     */
    public function gruppen(Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        $gruppen = Gebuehrengruppe::with([
            'gebuehrenkatalog' => function ($query) use ($gebuehrenordnung) {
                $query->where('gebuehrenordnung_id', $gebuehrenordnung->id)
                    ->with('gebuehren');
            },
        ])->orderBy('order')->get();

        return response()->json([
            'data' => $gruppen,
            'success' => true,
        ]);
    }

    /**
     * Alle Gebühren einer Gebührenordnung (mit Katalog und Gruppeninformationen)
     */
    public function gebuehren(Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        $gebuehren = Gebuehr::with([
            'gebuehrenkatalog.gruppe',
            'gebuehrenordnung',
        ])
            ->where('gebuehrenordnung_id', $gebuehrenordnung->id)
            ->orderBy('order', 'asc')
            ->orderBy('aktiv', 'desc')
            ->get()
            ->map(function ($gebuehr) {
                return [
                    'id' => $gebuehr->id,
                    'kosten_mitglied' => $gebuehr->kosten_mitglied,
                    'kosten_nichtmitglied' => $gebuehr->kosten_nichtmitglied,
                    'gueltig_ab' => $gebuehr->gueltig_ab,
                    'gueltig_bis' => $gebuehr->gueltig_bis,
                    'aktiv' => $gebuehr->aktiv,
                    'order' => $gebuehr->order,
                    'created_at' => $gebuehr->created_at,
                    'updated_at' => $gebuehr->updated_at,
                    'katalog' => $gebuehr->gebuehrenkatalog ? [
                        'id' => $gebuehr->gebuehrenkatalog->id,
                        'name' => $gebuehr->gebuehrenkatalog->name,
                        'beschreibung' => $gebuehr->gebuehrenkatalog->beschreibung,
                        'gebuehrengruppe' => $gebuehr->gebuehrenkatalog->gruppe ? [
                            'id' => $gebuehr->gebuehrenkatalog->gruppe->id,
                            'name' => $gebuehr->gebuehrenkatalog->gruppe->name,
                            'order' => $gebuehr->gebuehrenkatalog->gruppe->order,
                        ] : null,
                    ] : null,
                ];
            });

        return response()->json([
            'data' => $gebuehren,
            'success' => true,
        ]);
    }

    /**
     * Reihenfolge der Gebühren einer Gebührenordnung speichern
     */
    public function updateGebuehrenOrder(Request $request, Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        $validated = $request->validate([
            'gebuehren_ids' => 'required|array',
            'gebuehren_ids.*' => 'required|integer|exists:gebuehren,id',
        ]);

        try {
            foreach ($validated['gebuehren_ids'] as $index => $gebuehrId) {
                Gebuehr::where('id', $gebuehrId)
                    ->where('gebuehrenordnung_id', $gebuehrenordnung->id)
                    ->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reihenfolge erfolgreich gespeichert.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fehler beim Speichern der Reihenfolge: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Aktuell gültige Gebührenordnung
     */
    public function aktuell(): JsonResponse
    {
        $aktuelleGebuehrenordnung = Gebuehrenordnung::where('gueltig_ab', '<=', now())
            ->where(function ($query) {
                $query->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', now());
            })
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        if (! $aktuelleGebuehrenordnung) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => 'Keine gültige Gebührenordnung gefunden.',
            ], 404);
        }

        $aktuelleGebuehrenordnung->load([
            'gebuehrenkatalog.gruppe',
            'gebuehrenkatalog.gebuehren',
        ]);

        return response()->json([
            'data' => $aktuelleGebuehrenordnung,
            'success' => true,
        ]);
    }

    /**
     * Verfuegbare Katalog-Eintraege fuer eine Gebuehrenordnung (noch nicht hinzugefuegte)
     */
    public function verfuegbareKatalogEintraege(Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        // Hole alle Katalog-Einträge, die noch nicht in dieser Gebührenordnung sind
        $bereits_verwendete_ids = $gebuehrenordnung->gebuehren()->pluck('gebuehrenkatalog_id');

        $verfuegbareEintraege = Gebuehrenkatalog::with(['gruppe'])
            ->whereNotIn('id', $bereits_verwendete_ids)
            ->get()
            ->groupBy(function ($katalog) {
                return $katalog->gruppe ? $katalog->gruppe->name : 'Sonstige';
            })
            ->map(function ($gruppenKatalog, $gruppenName) {
                return [
                    'gruppe' => $gruppenName,
                    'eintraege' => $gruppenKatalog->sortBy('name')->values(),
                ];
            })
            ->values();

        return response()->json([
            'data' => $verfuegbareEintraege,
            'success' => true,
        ]);
    }

    /**
     * Neue Gebühr zu einer Gebührenordnung hinzufügen
     */
    public function storeGebuehr(Request $request, Gebuehrenordnung $gebuehrenordnung): JsonResponse
    {
        $validated = $request->validate([
            'katalog_id' => 'required|integer|exists:gebuehrenkatalog,id',
            'kosten_mitglied' => 'required|numeric|min:0',
            'kosten_nichtmitglied' => 'required|numeric|min:0',
            'aufschlag' => 'nullable|numeric|min:0',
            'gueltig_ab' => 'nullable|date',
            'gueltig_bis' => 'nullable|date|after:gueltig_ab',
            'aktiv' => 'boolean',
        ]);

        // Prüfen, ob der Katalog-Eintrag bereits in dieser Gebührenordnung existiert
        $existierend = Gebuehr::where('gebuehrenordnung_id', $gebuehrenordnung->id)
            ->where('gebuehrenkatalog_id', $validated['katalog_id'])
            ->first();

        if ($existierend) {
            return response()->json([
                'error' => 'Dieser Katalog-Eintrag ist bereits in der Gebührenordnung vorhanden',
                'success' => false,
            ], 422);
        }

        $gebuehr = Gebuehr::create([
            'gebuehrenkatalog_id' => $validated['katalog_id'],
            'gebuehrenordnung_id' => $gebuehrenordnung->id,
            'kosten_mitglied' => $validated['kosten_mitglied'],
            'kosten_nichtmitglied' => $validated['kosten_nichtmitglied'],
            'gueltig_ab' => $validated['gueltig_ab'] ?? $gebuehrenordnung->gueltig_ab,
            'gueltig_bis' => $validated['gueltig_bis'] ?? $gebuehrenordnung->gueltig_bis,
            'aktiv' => $validated['aktiv'] ?? true,
        ]);

        // Lade die Beziehungen für die Antwort
        $gebuehr->load(['katalog.gruppe']);

        return response()->json([
            'data' => $gebuehr,
            'success' => true,
            'message' => 'Gebühr erfolgreich hinzugefügt',
        ], 201);
    }
}
