<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVerstorbeneRequest;
use App\Models\Hund;
use App\Models\Verstorbene;
use App\Traits\PrerenderHund;
use Illuminate\Support\Facades\DB;

class VerstorbeneController extends Controller
{
    use PrerenderHund;

    /**
     * Get existing Verstorbene entry for a specific hund
     *
     * @param  int  $hundId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($hundId)
    {
        try {
            $verstorbene = Verstorbene::with(['todesursache', 'dokumente', 'arzt'])
                ->where('hund_id', $hundId)
                ->first();

            if (! $verstorbene) {
                return response()->json([
                    'success' => null,
                    'error' => null,
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'success' => null,
                'error' => null,
                'data' => $verstorbene,
            ], 200);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Daten konnten nicht geladen werden.',
            ], 500);
        }
    }

    /**
     * Store a new Verstorbene entry
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreVerstorbeneRequest $request)
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
                    'error' => 'Sie sind nicht berechtigt, für diesen Hund das Sterbedatum einzutragen.',
                ], 403);
            }

            // Prüfen ob bereits ein Eintrag existiert
            $existingVerstorbene = Verstorbene::where('hund_id', $validated['hund_id'])->first();

            if ($existingVerstorbene) {
                return response()->json([
                    'success' => null,
                    'error' => 'Für diesen Hund wurde bereits ein Sterbedatum eingetragen.',
                ], 409);
            }

            $result = DB::transaction(function () use ($validated) {
                $verstorbene = Verstorbene::create([
                    'hund_id' => $validated['hund_id'],
                    'verstorben_am' => $validated['verstorben_am'],
                    'todesursache_id' => $validated['todesursache_id'] ?? null,
                    'todesursache' => $validated['todesursache_text'] ?? null,
                    'einschlaeferung' => $validated['einschlaeferung'] ?? false,
                    'arzt_id' => $validated['arzt_id'] ?? null,
                    'verstorben' => true,
                    'welpenalter' => false,
                ]);

                // Update Hund sterbedatum direkt
                $hund = Hund::find($validated['hund_id']);
                $hund->sterbedatum = $validated['verstorben_am'];
                $hund->save();
                $this->prerenderHund($hund->id);

                return [
                    'verstorbene_id' => $verstorbene->id,
                    'hund_id' => $verstorbene->hund_id,
                ];
            });

            return response()->json([
                'success' => 'Das Sterbedatum wurde erfolgreich eingetragen.',
                'error' => null,
                'data' => $result,
            ], 201);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Das Sterbedatum konnte nicht eingetragen werden.',
            ], 500);
        }
    }

    /**
     * Update an existing Verstorbene entry
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreVerstorbeneRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $verstorbene = Verstorbene::findOrFail($id);
            $hund = Hund::findOrFail($verstorbene->hund_id);

            // Prüfen ob der User berechtigt ist (muss aktueller Eigentümer sein)
            $user = $request->user();
            $isOwner = $hund->isCurrentOwner($verstorbene->hund_id, $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, diesen Eintrag zu bearbeiten.',
                ], 403);
            }

            DB::transaction(function () use ($verstorbene, $validated, $hund) {
                $verstorbene->update([
                    'verstorben_am' => $validated['verstorben_am'],
                    'todesursache_id' => $validated['todesursache_id'] ?? null,
                    'todesursache' => $validated['todesursache_text'] ?? null,
                    'einschlaeferung' => $validated['einschlaeferung'] ?? false,
                    'arzt_id' => $validated['arzt_id'] ?? null,
                ]);

                // Update Hund sterbedatum
                $hund->sterbedatum = $validated['verstorben_am'];
                $hund->save();
                $this->prerenderHund($hund->id);
            });

            return response()->json([
                'success' => 'Das Sterbedatum wurde erfolgreich aktualisiert.',
                'error' => null,
                'data' => [
                    'verstorbene_id' => $verstorbene->id,
                    'hund_id' => $verstorbene->hund_id,
                ],
            ], 200);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Das Sterbedatum konnte nicht aktualisiert werden.',
            ], 500);
        }
    }
}
