<?php

namespace App\Http\Controllers;

use App\Models\Gebuehr;
use Illuminate\Http\Request;

class GebuehrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gebuehr::all();
    }

    /**
     * Hole alle Gebühren der aktuell gültigen Gebührenordnung
     * inklusive mkonto-Information aus dem Katalog
     *
     * @return \Illuminate\Http\Response
     */
    public function getAktuelleGebuehren()
    {
        try {
            // Finde die aktuell gültige Gebührenordnung
            $heute = now()->format('Y-m-d');
            $aktuelleGebuehrenordnung = \App\Models\Gebuehrenordnung::where('gueltig_ab', '<=', $heute)
                ->where(function ($query) use ($heute) {
                    $query->whereNull('gueltig_bis')
                        ->orWhere('gueltig_bis', '>=', $heute);
                })
                ->orderBy('gueltig_ab', 'desc')
                ->first();

            if (! $aktuelleGebuehrenordnung) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine gültige Gebührenordnung gefunden',
                    'data' => [],
                ], 404);
            }

            // Hole alle Gebühren der aktuellen Gebührenordnung mit Katalog-Daten
            $gebuehren = Gebuehr::with([
                'katalog:id,name,beschreibung,mkonto,gebuehrengruppe_id',
                'katalog.gebuehrengruppe:id,name,name_kurz',
            ])
                ->where('gebuehrenordnung_id', $aktuelleGebuehrenordnung->id)
                ->where('aktiv', true)
                ->orderBy('order')
                ->get()
                ->map(function ($gebuehr) {
                    return [
                        'id' => $gebuehr->id,
                        'name' => $gebuehr->katalog->name,
                        'beschreibung' => $gebuehr->katalog->beschreibung,
                        'kosten_mitglied' => $gebuehr->kosten_mitglied,
                        'kosten_nichtmitglied' => $gebuehr->kosten_nichtmitglied,
                        'mkonto' => (bool) $gebuehr->katalog->mkonto,
                        'gebuehrengruppe' => [
                            'id' => $gebuehr->katalog->gebuehrengruppe->id,
                            'name' => $gebuehr->katalog->gebuehrengruppe->name,
                            'name_kurz' => $gebuehr->katalog->gebuehrengruppe->name_kurz,
                        ],
                        'order' => $gebuehr->order,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $gebuehren,
                'meta' => [
                    'gebuehrenordnung' => [
                        'id' => $aktuelleGebuehrenordnung->id,
                        'name' => $aktuelleGebuehrenordnung->name,
                        'gueltig_ab' => $aktuelleGebuehrenordnung->gueltig_ab,
                        'gueltig_bis' => $aktuelleGebuehrenordnung->gueltig_bis,
                        'stand' => $aktuelleGebuehrenordnung->stand,
                    ],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Gebühren: ' . $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gebuehrenkatalog_id' => 'required|integer|exists:gebuehrenkatalog,id',
            'gebuehrenordnung_id' => 'required|integer|exists:gebuehrenordnung,id',
            'kosten_mitglied' => 'required|numeric|min:0',
            'kosten_nichtmitglied' => 'required|numeric|min:0',
            'gueltig_ab' => 'nullable|date',
            'gueltig_bis' => 'nullable|date',
            'aktiv' => 'sometimes|boolean',
        ]);

        // Setze Default-Werte basierend auf der Gebührenordnung
        if (! isset($validated['gueltig_ab'])) {
            $gebuehrenordnung = \App\Models\Gebuehrenordnung::find($validated['gebuehrenordnung_id']);
            $validated['gueltig_ab'] = $gebuehrenordnung->gueltig_ab;
            $validated['gueltig_bis'] = $gebuehrenordnung->gueltig_bis;
        }

        $validated['aktiv'] = $validated['aktiv'] ?? true;

        // Ermittele die nächste order Nummer
        $maxOrder = \App\Models\Gebuehr::where('gebuehrenordnung_id', $validated['gebuehrenordnung_id'])->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        $gebuehr = Gebuehr::create($validated);

        return response()->json([
            'message' => 'Gebühr erfolgreich erstellt',
            'data' => $gebuehr->load('katalog.gebuehrengruppe'),
            'success' => true,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Gebuehr $gebuehr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gebuehr $gebuehr)
    {
        $validated = $request->validate([
            'kosten_mitglied' => 'required|numeric|min:0',
            'kosten_nichtmitglied' => 'required|numeric|min:0',
            'order' => 'sometimes|integer|min:0',
        ]);

        $gebuehr->update($validated);

        return response()->json([
            'success' => 'Gebühr erfolgreich aktualisiert',
            'data' => $gebuehr->load('katalog.gebuehrengruppe'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gebuehr $gebuehr)
    {
        $gebuehr->delete();

        return response()->json([
            'message' => 'Gebühr erfolgreich gelöscht',
        ]);
    }
}
