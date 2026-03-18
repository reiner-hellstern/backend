<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeihstellungRequest;
use App\Models\Hund;
use App\Models\HundZwinger;
use App\Models\Leihstellung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeihstellungController extends Controller
{
    /**
     * Check if there is an active Leihstellung for a dog
     * Unterscheidet zwischen:
     * - Keine Leihstellung
     * - Leihstellung gemeldet, Freigabe ausstehend (freigabe=0)
     * - Aktive freigegebene Leihstellung (freigabe=1)
     */
    public function checkActive($hundId)
    {
        $heute = now()->format('Y-m-d');

        // Prüfe zuerst auf nicht freigegebene Leihstellungen (Freigabe ausstehend)
        $pendingLeihstellung = Leihstellung::where('hund_id', $hundId)
            ->where('freigabe', 0)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($pendingLeihstellung) {
            // Formatiere Daten für Frontend
            $von = ($pendingLeihstellung->von && $pendingLeihstellung->von !== '0000-00-00')
                ? $pendingLeihstellung->von
                : null;
            $bis = ($pendingLeihstellung->bis && $pendingLeihstellung->bis !== '0000-00-00')
                ? $pendingLeihstellung->bis
                : null;

            return response()->json([
                'success' => null,
                'error' => null,
                'data' => [
                    'status' => 'pending',
                    'has_pending_leihstellung' => true,
                    'has_active_leihstellung' => false,
                    'leihstellung' => [
                        'id' => $pendingLeihstellung->id,
                        'von' => $von,
                        'bis' => $bis,
                        'zwinger_id' => $pendingLeihstellung->zwinger_id,
                        'created_at' => $pendingLeihstellung->created_at->format('d.m.Y H:i'),
                        'freigabe' => 0,
                    ],
                ],
            ], 200);
        }

        // Prüfe auf aktive UND freigegebene Leihstellung
        $activeLeihstellung = Leihstellung::where('hund_id', $hundId)
            ->where('freigabe', 1) // Nur freigegebene Leihstellungen
            ->where(function ($query) use ($heute) {
                // Fall 1: Kein Zeitraum angegeben (von und bis sind NULL oder 0000-00-00)
                $query->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->whereNull('von')
                            ->orWhere('von', '0000-00-00');
                    })
                        ->where(function ($q2) {
                            $q2->whereNull('bis')
                                ->orWhere('bis', '0000-00-00');
                        });
                })
                // Fall 2: Nur von ist gesetzt, bis ist NULL (läuft unbegrenzt)
                    ->orWhere(function ($q) use ($heute) {
                        $q->whereNotNull('von')
                            ->where('von', '!=', '0000-00-00')
                            ->where(function ($q2) {
                                $q2->whereNull('bis')
                                    ->orWhere('bis', '0000-00-00');
                            })
                            ->where('von', '<=', $heute);
                    })
                // Fall 3: Beide Daten sind gesetzt, heute liegt im Zeitraum
                    ->orWhere(function ($q) use ($heute) {
                        $q->whereNotNull('von')
                            ->where('von', '!=', '0000-00-00')
                            ->whereNotNull('bis')
                            ->where('bis', '!=', '0000-00-00')
                            ->where('von', '<=', $heute)
                            ->where('bis', '>=', $heute);
                    });
            })
            ->first();

        if ($activeLeihstellung) {
            // Formatiere Daten für Frontend
            $von = ($activeLeihstellung->von && $activeLeihstellung->von !== '0000-00-00')
                ? $activeLeihstellung->von
                : null;
            $bis = ($activeLeihstellung->bis && $activeLeihstellung->bis !== '0000-00-00')
                ? $activeLeihstellung->bis
                : null;

            return response()->json([
                'success' => null,
                'error' => null,
                'data' => [
                    'status' => 'active',
                    'has_pending_leihstellung' => false,
                    'has_active_leihstellung' => true,
                    'leihstellung' => [
                        'id' => $activeLeihstellung->id,
                        'von' => $von,
                        'bis' => $bis,
                        'zwinger_id' => $activeLeihstellung->zwinger_id,
                        'created_at' => $activeLeihstellung->created_at->format('d.m.Y H:i'),
                        'freigabe' => 1,
                    ],
                ],
            ], 200);
        }

        // Keine Leihstellung gefunden
        return response()->json([
            'success' => null,
            'error' => null,
            'data' => [
                'status' => 'none',
                'has_pending_leihstellung' => false,
                'has_active_leihstellung' => false,
                'leihstellung' => null,
            ],
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeihstellungRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Erstelle Leihstellung (ohne hund_zwinger - erfolgt erst nach Freigabe)
            $leihstellung = Leihstellung::create([
                'hund_id' => $validated['hund_id'],
                'zwinger_id' => $validated['zwinger_id'],
                'leihsteller_id' => $validated['leihsteller_id'], // Person-ID des meldenden Eigentümers
                'von' => $validated['von'] ?? null,
                'bis' => $validated['bis'] ?? null,
                'freigabe' => 0, // Standard: nicht freigegeben, wartet auf Sachbearbeiter
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Die Leihstellung wurde erfolgreich gemeldet und wartet auf Freigabe durch die Geschäftsstelle.',
                'error' => null,
                'data' => [
                    'leihstellung_id' => $leihstellung->id,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Die Leihstellung konnte nicht gespeichert werden: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Approve a Leihstellung (Freigabe durch Sachbearbeiter)
     * Erstellt die hund_zwinger Relation
     */
    public function approve(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $leihstellung = Leihstellung::findOrFail($id);

            // Prüfe ob bereits freigegeben
            if ($leihstellung->freigabe == 1) {
                return response()->json([
                    'success' => null,
                    'error' => 'Diese Leihstellung wurde bereits freigegeben.',
                    'data' => null,
                ], 400);
            }

            // Setze Freigabe auf 1
            $leihstellung->freigabe = 1;
            $leihstellung->save();

            // Erstelle/Aktualisiere hund_zwinger Eintrag
            $hundZwinger = HundZwinger::updateOrCreate(
                [
                    'hund_id' => $leihstellung->hund_id,
                    'zwinger_id' => $leihstellung->zwinger_id,
                ],
                [
                    'von' => $leihstellung->von ?? null,
                    'bis' => $leihstellung->bis ?? null,
                    'typ' => 'leihstellung',
                    'leihstellung' => 1,
                    'leihstellung_id' => $leihstellung->id,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => 'Die Leihstellung wurde erfolgreich freigegeben und die Hund-Zwinger-Relation wurde erstellt.',
                'error' => null,
                'data' => [
                    'leihstellung_id' => $leihstellung->id,
                    'hund_zwinger_id' => $hundZwinger->id,
                    'freigabe' => $leihstellung->freigabe,
                ],
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Leihstellung nicht gefunden.',
                'data' => null,
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Die Freigabe konnte nicht durchgeführt werden: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Wird verwendet um eine Leihstellung zu beenden (bis-Datum setzen)
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $leihstellung = Leihstellung::findOrFail($id);

            // Prüfe ob Leihstellung bereits beendet ist
            if ($leihstellung->bis && $leihstellung->bis !== '0000-00-00' && $leihstellung->bis < now()->format('Y-m-d')) {
                return response()->json([
                    'success' => null,
                    'error' => 'Diese Leihstellung ist bereits beendet.',
                    'data' => null,
                ], 400);
            }

            // Validierung mit dem vorhandenen von-Datum
            $validated = $request->validate([
                'bis' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($leihstellung) {
                        if ($leihstellung->von && $leihstellung->von !== '0000-00-00') {
                            $vonDate = \Carbon\Carbon::parse($leihstellung->von);
                            $bisDate = \Carbon\Carbon::parse($value);

                            if ($bisDate->lt($vonDate)) {
                                $fail('Das Enddatum muss nach oder gleich dem Startdatum (' . $vonDate->format('d.m.Y') . ') liegen.');
                            }
                        }
                    },
                ],
            ], [
                'bis.required' => 'Das Enddatum der Leihstellung muss angegeben werden.',
                'bis.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            ]);

            // Setze das bis-Datum
            $leihstellung->bis = $validated['bis'];
            $leihstellung->save();

            // Aktualisiere auch den hund_zwinger Eintrag wenn vorhanden
            $hundZwinger = HundZwinger::where('leihstellung_id', $leihstellung->id)->first();
            if ($hundZwinger) {
                $hundZwinger->bis = $validated['bis'];
                $hundZwinger->save();
            }

            DB::commit();

            return response()->json([
                'success' => 'Die Leihstellung wurde erfolgreich beendet.',
                'error' => null,
                'data' => [
                    'leihstellung_id' => $leihstellung->id,
                    'bis' => $leihstellung->bis,
                ],
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Leihstellung nicht gefunden.',
                'data' => null,
            ], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => $e->validator->errors()->first(),
                'data' => null,
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Die Leihstellung konnte nicht beendet werden: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
