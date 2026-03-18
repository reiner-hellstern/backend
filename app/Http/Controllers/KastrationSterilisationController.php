<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKastrationSterilisationRequest;
use App\Http\Requests\UpdateKastrationSterilisationRequest;
use App\Models\KastrationSterilisation;
use App\Traits\SaveArzt;

class KastrationSterilisationController extends Controller
{
    use SaveArzt;

    /**
     * Prüfe ob bereits eine Kastration/Sterilisation für diesen Hund existiert
     */
    public function checkExisting(int $hund_id)
    {
        $existing = KastrationSterilisation::with(['arzt', 'grund'])
            ->where('hund_id', $hund_id)
            ->first();

        if (! $existing) {
            return response()->json([
                'success' => null,
                'error' => null,
                'data' => [
                    'exists' => false,
                ],
            ]);
        }

        // Arzt-Daten aufbereiten
        $arztData = null;
        if ($existing->arzt) {
            $arztData = [
                'id' => $existing->arzt->id,
                'vorname' => $existing->arzt->vorname,
                'nachname' => $existing->arzt->nachname,
                'praxisname' => $existing->arzt->praxisname,
                'postleitzahl' => $existing->arzt->postleitzahl,
                'ort' => $existing->arzt->ort,
            ];
        }

        // Grund-IDs als Array parsen

        return response()->json([
            'success' => null,
            'error' => null,
            'data' => [
                'exists' => true,
                'kastration_sterilisation' => [
                    'id' => $existing->id,
                    'hund_id' => $existing->hund_id,
                    'eingriff_am' => $existing->eingriff_am,
                    'kastration' => $existing->kastration,
                    'sterilisation' => $existing->sterilisation,
                    'grund_id' => $existing->grund_id,
                    'grund' => $existing->grund ? [
                        'id' => $existing->grund->id,
                        'name' => $existing->grund->name,
                    ] : null,
                    'grund_text' => $existing->grund_text,
                    'created_at' => $existing->created_at->format('d.m.Y'),
                    'arzt' => $arztData,
                ],
            ],
        ]);
    }

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
    public function store(StoreKastrationSterilisationRequest $request)
    {
        $validated = $request->validated();

        // Prüfe ob bereits eine Kastration/Sterilisation für diesen Hund existiert
        $existingEntry = KastrationSterilisation::where('hund_id', $validated['hund_id'])->first();

        if ($existingEntry) {
            return response()->json([
                'success' => null,
                'error' => 'Für diesen Hund existiert bereits eine Kastration/Sterilisation-Meldung.',
                'data' => null,
            ], 409);
        }

        // Speichere Arzt (falls vorhanden)
        $arzt_id = isset($validated['arzt']) ? $this->saveArzt($validated['arzt']) : null;

        // Bestimme ob Kastration oder Sterilisation
        $kastration = $validated['eingriff'] === 'kastration' ? 1 : 0;
        $sterilisation = $validated['eingriff'] === 'sterilisation' ? 1 : 0;

        // Erstelle Kastration/Sterilisation-Eintrag
        $kastrationSterilisation = KastrationSterilisation::create([
            'hund_id' => $validated['hund_id'],
            'eingriff_am' => $validated['eingriff_am'],
            'kastration' => $kastration,
            'sterilisation' => $sterilisation,
            'grund_id' => $validated['grund_id'],
            'grund_text' => $validated['grund_text'] ?? null,
            'arzt_id' => $arzt_id ?? 1, // Default: 1 falls kein Arzt
        ]);

        return response()->json([
            'success' => 'Die Kastration/Sterilisation wurde erfolgreich gespeichert.',
            'error' => null,
            'data' => [
                'id' => $kastrationSterilisation->id,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KastrationSterilisation $kastrationSterilisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKastrationSterilisationRequest $request, KastrationSterilisation $kastrationsterilisation)
    {
        $kastrationsterilisation->hund_id = $request->hund_id;
        $kastrationsterilisation->datum = $request->datum;
        $kastrationsterilisation->anmerkungen = $request->anmerkungen;
        $kastrationsterilisation->status_id = $request->status_id;

        $kastrationsterilisation->arzt_id = $this->saveArzt($request->arzt);

        $kastrationsterilisation->save();

        return ['message' => 'success', 'kastrationsterilisation' => $kastrationsterilisation];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KastrationSterilisation $kastrationSterilisation)
    {
        //
    }
}
