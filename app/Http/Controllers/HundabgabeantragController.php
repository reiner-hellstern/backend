<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHundabgabeantragRequest;
use App\Models\Hund;
use App\Models\Hundabgabeantrag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HundabgabeantragController extends Controller
{
    /**
     * Get existing Hundabgabeantrag for a specific hund
     *
     * @param  int  $hundId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($hundId)
    {
        try {
            $antrag = Hundabgabeantrag::with(['status', 'dokumente'])
                ->where('hund_id', $hundId)
                ->where('antragsteller_id', auth()->user()->person->id)
                ->latest()
                ->first();

            if (! $antrag) {
                return response()->json([
                    'success' => null,
                    'error' => null,
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'success' => null,
                'error' => null,
                'data' => $antrag,
            ], 200);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Der Antrag konnte nicht geladen werden.',
            ], 500);
        }
    }

    /**
     * Store a new Hundabgabeantrag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreHundabgabeantragRequest $request)
    {
        $validated = $request->validated();

        try {
            $hund = Hund::findOrFail($validated['hund_id']);

            // Prüfen ob der User berechtigt ist (muss aktueller Eigentümer sein)
            $user = $request->user();
            $isOwner = $hund->isCurrentOwner($validated['hund_id'], $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, für diesen Hund eine Abgabe zu melden.',
                ], 403);
            }

            // Prüfen ob bereits ein offener Antrag existiert
            $existingAntrag = Hundabgabeantrag::where('hund_id', $validated['hund_id'])
                ->where('antragsteller_id', $user->person->id)
                ->whereIn('status_id', [1, 2, 3]) // Offen, In Bearbeitung, Warten
                ->first();

            if ($existingAntrag) {
                return response()->json([
                    'success' => null,
                    'error' => 'Es existiert bereits ein offener Antrag für diesen Hund.',
                ], 409);
            }

            $result = DB::transaction(function () use ($validated, $user) {
                // Konvertiere deutsches Datum zu MySQL-Format
                //   $abgabedatum = Carbon::createFromFormat('d.m.Y', $validated['abgabedatum'])->format('Y-m-d');

                $antrag = Hundabgabeantrag::create([
                    'abgabedatum' => $validated['abgabedatum'],
                    'hund_id' => $validated['hund_id'],
                    'status_id' => 2, // Status "Gesendet" oder "In Bearbeitung"
                    'antragsteller_id' => $user->person->id,
                    'bemerkungen_antragsteller' => $validated['bemerkungen_antragsteller'] ?? null,
                    'sent_at' => now(),
                    'aktiv' => true,
                    'show_in_profile' => true,
                    'bestaetigt' => false,
                ]);

                return [
                    'antrag_id' => $antrag->id,
                    'hund_id' => $antrag->hund_id,
                ];
            });

            return response()->json([
                'success' => 'Die Hundeabgabe wurde erfolgreich gemeldet.',
                'error' => null,
                'data' => $result,
            ], 201);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Hundeabgabe konnte nicht gemeldet werden.',
            ], 500);
        }
    }
}
