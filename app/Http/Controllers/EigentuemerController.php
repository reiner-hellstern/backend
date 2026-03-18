<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEigentuemerRequest;
use App\Http\Requests\StoreEigentuemerRequest;
use App\Http\Requests\UpdateEigentuemerRequest;
use App\Models\Eigentuemer;
use App\Models\Hund;
use App\Models\Person;
use App\Traits\CheckActiveOwnership;
use App\Traits\PrerenderHund;
use App\Traits\SaveDokumente;
use App\Traits\SavePerson;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EigentuemerController extends Controller
{
    use CheckActiveOwnership;
    use PrerenderHund;
    use SaveDokumente;
    use SavePerson;

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
    public function store(StoreEigentuemerRequest $request)
    {

        $person = $request->person;
        $dokumente = $request->dokumente;

        $result = $this->savePerson($person);
        $person_id = $result['person_id'];

        $eigentuemer = new Eigentuemer();

        $eigentuemer->freigabe_id = Auth::id();
        $eigentuemer->person_id = $person_id;
        $eigentuemer->hund_id = $request->hund_id;
        $eigentuemer->seit = $request->seit;
        $eigentuemer->anmerkung = $request->anmerkung;
        $eigentuemer->aktiv = $request->bis ? 0 : 1;
        $eigentuemer->bis = $request->bis;

        $this->saveDokumente($eigentuemer, $dokumente);

        $eigentuemer->save();

        return $eigentuemer;

    }

    /**
     * Display the specified resource.
     */
    public function show(Eigentuemer $eigentuemer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEigentuemerRequest $request, Eigentuemer $eigentuemer)
    {

        $dokumente = $request->dokumente;

        $eigentuemer->seit = $request->seit;
        $eigentuemer->anmerkung = $request->anmerkung;
        $eigentuemer->aktiv = $request->bis ? 0 : 1;
        $eigentuemer->bis = $request->bis;

        $this->saveDokumente($eigentuemer, $dokumente);

        $eigentuemer->save();

        return $eigentuemer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eigentuemer $eigentuemer)
    {
        //
    }

    /**
     * Füge einen neuen Eigentümer zu einem Hund hinzu
     */
    public function addEigentuemer(AddEigentuemerRequest $request)
    {

        try {
            $validated = $request->validated();

            $hundId = $validated['hund_id'];
            $eigentuemerData = $validated['eigentuemer'];

            // Hund prüfen
            $hund = Hund::findOrFail($hundId);

            // Person-Daten für SavePerson-Trait aufbereiten
            $personData = [
                'vorname' => $eigentuemerData['vorname'],
                'nachname' => $eigentuemerData['nachname'],
                'strasse' => $eigentuemerData['strasse'],
                'postleitzahl' => $eigentuemerData['postleitzahl'],
                'ort' => $eigentuemerData['ort'],
                'anrede_id' => $eigentuemerData['anrede']['id'] ?? null,
                'adelstitel' => $eigentuemerData['adelstitel'] ?? '',
                'akademischetitel' => $eigentuemerData['akademischetitel'] ?? '',
                'email_1' => $eigentuemerData['email_1'] ?? '',
                'telefon_1' => $eigentuemerData['telefon'] ?? '',
                'adresszusatz' => $eigentuemerData['adresszusatz'] ?? '',
                'land' => $eigentuemerData['land'] ?? 'Deutschland',
            ];

            DB::beginTransaction();

            // 1. Person speichern oder finden (mit SavePerson-Trait)
            $personResult = $this->savePerson($personData);
            $personId = $personResult['person_id'];
            $wasCreated = $personResult['was_created'];

            // 2. Prüfen, ob Person bereits als Eigentümer in hund_person eingetragen ist
            $existingOwnership = DB::table('hund_person')
                ->where('hund_id', $hundId)
                ->where('person_id', $personId)
                ->where(function ($query) {
                    // Aktiv = 1 oder aktiv = null (legacy data)
                    $query->where('aktiv', 1)
                        ->orWhereNull('aktiv');
                })
                ->where(function ($query) {
                    $query->whereNull('bis')
                        ->orWhere('bis', '=', '0000-00-00')
                        ->orWhere('bis', '>', Carbon::now()->format('Y-m-d'));
                })
                ->exists();

            if ($existingOwnership) {
                DB::rollBack();

                return response()->json([
                    'success' => null,
                    'error' => 'Diese Person ist bereits als aktiver Eigentümer für diesen Hund eingetragen.',
                    'data' => null,
                ], 200);
            }

            // 3. Neue Eigentümerschaft in hund_person-Tabelle erstellen
            DB::table('hund_person')->insert([
                'hund_id' => $hundId,
                'person_id' => $personId,
                'seit' => Carbon::now()->format('Y-m-d'),
                'bis' => null,
                'freigabe_id' => Auth::id(),
                'aktiv' => 1,
                'anmerkung' => 'Miteigentümer extern gemeldet',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            $this->prerenderHund($hundId);

            return response()->json([
                'success' => $wasCreated
                    ? 'Neue Person wurde erstellt und als Miteigentümer hinzugefügt'
                    : 'Bestehende Person wurde als Miteigentümer hinzugefügt',
                'error' => null,
                'data' => [
                    'person_id' => $personId,
                    'was_created' => $wasCreated,
                    'hund_id' => $hundId,
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => null,
                'error' => 'Validierungsfehler: ' . implode(', ', array_merge(...array_values($e->errors()))),
                'data' => null,
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Fehler beim Hinzufügen des Miteigentümers: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Bereinige doppelte Eigentümereinträge für einen Hund
     */
    public function cleanupDuplicateOwners($hundId)
    {
        try {
            DB::beginTransaction();

            // Finde doppelte Einträge (gleiche hund_id und person_id)
            $duplicates = DB::table('hund_person')
                ->select('hund_id', 'person_id', DB::raw('COUNT(*) as count'), DB::raw('MIN(id) as keep_id'))
                ->where('hund_id', $hundId)
                ->groupBy('hund_id', 'person_id')
                ->having('count', '>', 1)
                ->get();

            $deletedCount = 0;
            foreach ($duplicates as $duplicate) {
                // Lösche alle außer dem ältesten Eintrag
                $deleted = DB::table('hund_person')
                    ->where('hund_id', $duplicate->hund_id)
                    ->where('person_id', $duplicate->person_id)
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();

                $deletedCount += $deleted;
            }

            DB::commit();

            $this->prerenderHund($hundId);

            return response()->json([
                'success' => "Bereinigung abgeschlossen. {$deletedCount} doppelte Einträge entfernt.",
                'error' => null,
                'data' => [
                    'deleted_count' => $deletedCount,
                    'duplicate_groups' => $duplicates->count(),
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => null,
                'error' => 'Fehler beim Bereinigen der Duplikate: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Lade die aktuellen Eigentümer eines Hundes
     */
    public function getCurrentOwners($hundId)
    {
        try {
            $hund = Hund::with(['personen' => function ($query) {
                $query->wherePivot('aktiv', 1)
                    ->whereNull('hund_person.bis')
                    ->orWhere('hund_person.bis', '>', Carbon::now()->format('Y-m-d'));
            }])->findOrFail($hundId);

            return response()->json([
                'success' => 'Eigentümer erfolgreich geladen',
                'error' => null,
                'data' => [
                    'hund' => $hund,
                    'eigentuemer' => $hund->personen,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => null,
                'error' => 'Fehler beim Laden der Eigentümer: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
