<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlutprobeneinlagerungRequest;
use App\Http\Requests\UpdateBlutprobeneinlagerungRequest;
use App\Models\Blutprobeneinlagerung;
use App\Traits\SaveArzt;

class BlutprobeneinlagerungController extends Controller
{
    use SaveArzt;

    /**
     * Check if a Blutprobeneinlagerung already exists for a specific Hund
     * Returns full data to populate the form
     */
    public function checkExisting(int $hund_id)
    {
        $existing = Blutprobeneinlagerung::with([
            'arzt',
            'verwandteHunde.geschlecht',
            'verwandteHunde.rasse',
        ])->where('hund_id', $hund_id)->first();

        if (! $existing) {
            return response()->json([
                'success' => null,
                'error' => null,
                'data' => [
                    'exists' => false,
                    'blutprobeneinlagerung' => null,
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

        // Verwandte Hunde aufbereiten
        $verwandteHunde = [];
        foreach ($existing->verwandteHunde as $verwandter) {
            $verwandterArzt = \App\Models\Arzt::find($verwandter->pivot->arzt_id);

            $verwandteHunde[] = [
                'hund' => [
                    'id' => $verwandter->id,
                    'name' => $verwandter->name,
                    'zuchtbuchnummer' => $verwandter->zuchtbuchnummer,
                    'geschlecht' => $verwandter->geschlecht ? $verwandter->geschlecht->name : null,
                    'rasse' => $verwandter->rasse ? $verwandter->rasse->name : null,
                ],
                'ausschlussdiagnostik_am' => $verwandter->pivot->ausschlussdiagnostik_am ?
                   \Carbon\Carbon::parse($verwandter->pivot->ausschlussdiagnostik_am)->format('d.m.Y') : null,
                'arzt' => $verwandterArzt ? [
                    'id' => $verwandterArzt->id,
                    'vorname' => $verwandterArzt->vorname,
                    'nachname' => $verwandterArzt->nachname,
                    'praxisname' => $verwandterArzt->praxisname,
                    'postleitzahl' => $verwandterArzt->postleitzahl,
                    'ort' => $verwandterArzt->ort,
                ] : null,
            ];
        }

        return response()->json([
            'success' => null,
            'error' => null,
            'data' => [
                'exists' => true,
                'blutprobeneinlagerung' => [
                    'id' => $existing->id,
                    'hund_id' => $existing->hund_id,
                    'datum_blutentnahme' => $existing->datum_blutentnahme,
                    'datum_einlagerung' => $existing->datum_einlagerung,
                    'labornummer' => $existing->labornummer,
                    'erster_anfall' => $existing->erster_anfall,
                    'anzahl_anfaelle' => $existing->anzahl_anfaelle,
                    'ausschlussdiagnostik_am' => $existing->ausschlussdiagnostik_am,
                    'anmerkungen' => $existing->anmerkungen,
                    'created_at' => $existing->created_at->format('d.m.Y'),
                    'arzt' => $arztData,
                    'verwandte_hunde' => $verwandteHunde,
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
    public function store(StoreBlutprobeneinlagerungRequest $request)
    {
        $validated = $request->validated();

        // Prüfe ob bereits eine Blutprobeneinlagerung für diesen Hund existiert
        $existingEinlagerung = Blutprobeneinlagerung::where('hund_id', $validated['hund_id'])->first();

        if ($existingEinlagerung) {
            return response()->json([
                'success' => null,
                'error' => 'Für diesen Hund existiert bereits eine Blutprobeneinlagerung. Es kann nur eine Einlagerung pro Hund angelegt werden.',
                'data' => null,
            ], 409);
        }

        // Speichere Arzt (falls vorhanden)
        $arzt_id = isset($validated['arzt']) ? $this->saveArzt($validated['arzt']) : null;

        // Erstelle Blutprobeneinlagerung
        $blutprobeneinlagerung = Blutprobeneinlagerung::create([
            'hund_id' => $validated['hund_id'],
            'arzt_id' => $arzt_id,
            'datum_blutentnahme' => $validated['datum_blutentnahme'] ?? null,
            'datum_einlagerung' => $validated['datum_einlagerung'] ?? null,
            'labornummer' => $validated['labornummer'] ?? null,
            'erster_anfall' => $validated['erster_anfall'] ?? null,
            'anzahl_anfaelle' => $validated['anzahl_anfaelle'] ?? null,
            'ausschlussdiagnostik_am' => $validated['ausschlussdiagnostik_am'] ?? null,
            'anmerkungen' => $validated['anmerkungen'] ?? null,
        ]);

        // Verknüpfe verwandte Hunde mit Epilepsie (falls vorhanden)
        if (isset($validated['verwandte_hunde']) && is_array($validated['verwandte_hunde'])) {
            foreach ($validated['verwandte_hunde'] as $verwandter) {
                $verwandter_arzt_id = isset($verwandter['arzt']) ? $this->saveArzt($verwandter['arzt']) : null;

                $blutprobeneinlagerung->verwandteHunde()->attach($verwandter['hund_id'], [
                    'arzt_id' => $verwandter_arzt_id,
                    'ausschlussdiagnostik_am' => $verwandter['ausschlussdiagnostik_am'] ?? null,
                ]);
            }
        }

        return response()->json([
            'success' => 'Blutprobeneinlagerung wurde erfolgreich gespeichert.',
            'error' => null,
            'data' => [
                'id' => $blutprobeneinlagerung->id,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blutprobeneinlagerung $blutprobeneinlagerung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlutprobeneinlagerungRequest $request, Blutprobeneinlagerung $blutprobeneinlagerung)
    {
        $blutprobeneinlagerung->hund_id = $request->hund_id;
        $blutprobeneinlagerung->anmerkungen = $request->anmerkungen;
        $blutprobeneinlagerung->generatio = $request->generatio;
        $blutprobeneinlagerung->datum_einlagerung = $request->datum_einlagerung;
        $blutprobeneinlagerung->datum_blutentnahme = $request->datum_blutentnahme;
        $blutprobeneinlagerung->labornummer = $request->labornummer;

        $blutprobeneinlagerung->arzt_id = $this->saveArzt($request->arzt);
        //  $blutprobeneinlagerung->labor_id = $this->saveArzt($request->labor);

        $blutprobeneinlagerung->save();

        return ['message' => 'success', 'blutprobeneinlagerung' => $blutprobeneinlagerung];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blutprobeneinlagerung $blutprobeneinlagerung)
    {
        //
    }
}
