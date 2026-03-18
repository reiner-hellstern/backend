<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZuchtstaettenbesichtigungRequest;
use App\Http\Resources\ZuchtstaettenbesichtigungResource;
use App\Models\Person;
use App\Models\Zuchtstaette;
use App\Models\Zuchtstaettenbesichtigung;
use App\Models\Zuchtwart;
use App\Models\Zwinger;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class ZuchtstaettenbesichtigungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZuchtstaettenbesichtigungRequest $request)
    {
        $validated = $request->validated();

        try {
            $originalGrundId = (int) $request->input('grund_id_original', $validated['grund_id']);

            $zuchtstaettenbesichtigung = DB::transaction(function () use ($validated, $originalGrundId) {
                $antragsteller = Person::findOrFail($validated['antragsteller_id']);
                $zuchtwart = Zuchtwart::findOrFail($validated['zuchtwart_id']);

                $zwingerId = $validated['zwinger_id'] ?? optional($antragsteller->zwinger()->first())->id;

                $requiresZwinger = $originalGrundId !== 0;

                if ($requiresZwinger && ! $zwingerId) {
                    throw ValidationException::withMessages([
                        'zwinger_id' => 'Für den Antrag konnte kein Zwinger ermittelt werden.',
                    ]);
                }

                $zuchtstaette = isset($validated['zuchtstaette_id']) && $validated['zuchtstaette_id']
                   ? Zuchtstaette::findOrFail($validated['zuchtstaette_id'])
                   : $this->createZuchtstaette($validated, $antragsteller->id, $zwingerId, $originalGrundId === 0);

                $this->syncRassen($validated['rassen'] ?? null, $zwingerId, $zuchtstaette);

                return Zuchtstaettenbesichtigung::create([
                    'status_id' => $validated['status_id'] ?? 1,
                    'grund_id' => $validated['grund_id'],
                    'antragsteller_id' => $antragsteller->id,
                    'zuchtwart_id' => $zuchtwart->id,
                    'zuchtstaette_id' => $zuchtstaette->id,
                    'termin_am' => $validated['termin_am'],
                    'bestaetigung_angaben' => $validated['bestaetigung_angaben'],
                    'anmerkungen_fuer_zw' => $validated['anmerkung'] ?? null,
                    'zw_anwaerter' => $validated['grund_id'] === 1,
                    'zw_anwaerter_id' => $antragsteller->id,
                    'zw_anwaerter_name' => trim(($antragsteller->vorname ?? '') . ' ' . ($antragsteller->nachname ?? '')),
                    'zw_anwaerter_mitgliedsnummer' => $antragsteller->mitgliedsnummer,
                    'freigabe_gs_id' => $this->resolveFreigabeGsId($antragsteller->id),
                    'freigabe_zw' => false,
                    'freigabe_gs' => false,
                    'bestaetigungen_komplett' => $validated['bestaetigung_angaben'],
                ])->load(['grund', 'status', 'zuchtwart.person', 'antragsteller', 'zuchtstaette']);
            });

            return response()->json([
                'success' => 'Zuchtstättenbesichtigung erfolgreich beantragt.',
                'error' => null,
                'data' => new ZuchtstaettenbesichtigungResource($zuchtstaettenbesichtigung),
            ], 201);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Zuchtstättenbesichtigung konnte nicht gespeichert werden.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtstaettenbesichtigung $zuchtstaettenbesichtigung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtstaettenbesichtigung $zuchtstaettenbesichtigung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtstaettenbesichtigung $zuchtstaettenbesichtigung)
    {
        //
    }

    private function createZuchtstaette(array $validated, int $antragstellerId, ?int $zwingerId, bool $assignToPerson): Zuchtstaette
    {
        $address = Arr::only($validated['zuchtstaette'] ?? [], [
            'strasse',
            'adresszusatz',
            'postleitzahl',
            'ort',
            'land',
            'laenderkuerzel',
        ]);

        $ownerType = $assignToPerson || ! $zwingerId ? Person::class : Zwinger::class;
        $ownerId = $ownerType === Person::class ? $antragstellerId : $zwingerId;

        $zuchtstaette = Zuchtstaette::create(array_merge($address, [
            'zwinger_id' => $zwingerId,
            'zuchtstaetteable_type' => $ownerType,
            'zuchtstaetteable_id' => $ownerId,
            'status_id' => $validated['status_id'] ?? 1,
            'anleger_id' => $antragstellerId,
            'land' => $address['land'] ?? 'Deutschland',
            'laenderkuerzel' => $address['laenderkuerzel'] ?? 'DE',
            'aktiv' => true,
            'standard' => true,
        ]));

        return $zuchtstaette;
    }

    private function syncRassen(?array $rassenIds, ?int $zwingerId, Zuchtstaette $zuchtstaette): void
    {
        $ids = collect($rassenIds ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();

        $zuchtstaette->rassen()->sync($ids);

        if (! $zwingerId || empty($ids)) {
            return;
        }

        $zwinger = Zwinger::find($zwingerId);

        if (! $zwinger) {
            return;
        }

        $zwinger->rassen()->syncWithoutDetaching($ids);
    }

    private function resolveFreigabeGsId(int $fallbackId): int
    {
        $configuredId = (int) config('drc.freigabe_gs_person_id', 0);

        return $configuredId > 0 ? $configuredId : $fallbackId;
    }
}
