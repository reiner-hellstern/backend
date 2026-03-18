<?php

namespace App\Http\Controllers;

use App\Models\Bankverbindung;
use App\Models\Mitglied;
use App\Models\Person;
use Illuminate\Http\Request;

class BankverbindungController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'person_id' => 'required|exists:personen,id',
                'mitglied_id' => 'nullable|exists:mitglieder,id',
                'bankverbindung_mitgliedsbeitraege' => 'nullable|array',
                'bankverbindung_mitgliedsbeitraege.kontoinhaber' => 'required_with:bankverbindung_mitgliedsbeitraege|string|max:255',
                'bankverbindung_mitgliedsbeitraege.bankname' => 'required_with:bankverbindung_mitgliedsbeitraege|string|max:255',
                'bankverbindung_mitgliedsbeitraege.bic' => 'required_with:bankverbindung_mitgliedsbeitraege|string|max:11',
                'bankverbindung_mitgliedsbeitraege.iban' => 'required_with:bankverbindung_mitgliedsbeitraege|string|max:34',
                'bankverbindung_vereinsleistungen' => 'nullable|array',
                'bankverbindung_vereinsleistungen.kontoinhaber' => 'required_with:bankverbindung_vereinsleistungen|string|max:255',
                'bankverbindung_vereinsleistungen.bankname' => 'required_with:bankverbindung_vereinsleistungen|string|max:255',
                'bankverbindung_vereinsleistungen.bic' => 'required_with:bankverbindung_vereinsleistungen|string|max:11',
                'bankverbindung_vereinsleistungen.iban' => 'required_with:bankverbindung_vereinsleistungen|string|max:34',
                'bemerkungen' => 'nullable|string|max:2000',
            ]);

            $bankverbindungIds = [];

            // Bankverbindung für Mitgliedsbeiträge erstellen (falls vorhanden)
            if (isset($validated['bankverbindung_mitgliedsbeitraege']) && isset($validated['mitglied_id'])) {
                $mitglied = Mitglied::findOrFail($validated['mitglied_id']);

                $bankverbindung = new Bankverbindung([
                    'kontoinhaber' => $validated['bankverbindung_mitgliedsbeitraege']['kontoinhaber'],
                    'bankname' => $validated['bankverbindung_mitgliedsbeitraege']['bankname'],
                    'bic' => $validated['bankverbindung_mitgliedsbeitraege']['bic'],
                    'iban' => $validated['bankverbindung_mitgliedsbeitraege']['iban'],
                    'gueltig_ab' => now()->format('Y-m-d'),
                    'aktiv' => 0, // Noch nicht aktiviert, muss erst überprüft werden
                    'anmerkungen' => $validated['bemerkungen'] ?? null,
                ]);

                $mitglied->bankverbindungen()->save($bankverbindung);
                $bankverbindungIds['mitglied'] = $bankverbindung->id;
            }

            // Bankverbindung für Vereinsleistungen erstellen (falls vorhanden)
            if (isset($validated['bankverbindung_vereinsleistungen'])) {
                $person = Person::findOrFail($validated['person_id']);

                $bankverbindung = new Bankverbindung([
                    'kontoinhaber' => $validated['bankverbindung_vereinsleistungen']['kontoinhaber'],
                    'bankname' => $validated['bankverbindung_vereinsleistungen']['bankname'],
                    'bic' => $validated['bankverbindung_vereinsleistungen']['bic'],
                    'iban' => $validated['bankverbindung_vereinsleistungen']['iban'],
                    'gueltig_ab' => now()->format('Y-m-d'),
                    'aktiv' => 0, // Noch nicht aktiviert, muss erst überprüft werden
                    'anmerkungen' => $validated['bemerkungen'] ?? null,
                ]);

                $person->bankverbindungen()->save($bankverbindung);
                $bankverbindungIds['person'] = $bankverbindung->id;
            }

            return response()->json([
                'success' => 'Bankverbindungen erfolgreich gespeichert',
                'error' => null,
                'data' => [
                    'bankverbindung_ids' => $bankverbindungIds,
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => null,
                'error' => 'Validierungsfehler: ' . implode(', ', array_merge(...array_values($e->errors()))),
                'data' => null,
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => null,
                'error' => 'Fehler beim Speichern der Bankverbindungen: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bankverbindung $bankverbindung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bankverbindung $bankverbindung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bankverbindung $bankverbindung)
    {
        //
    }

    /**
     * Autocomplete
     */
    public function autocomplete(Request $request)
    {
        // blz, bankname, land, bic

        $blz = trim($request->blz);
        $bankname = trim($request->bankname);
        $land = trim($request->land);
        $bic = trim($request->bic);
        $query = Bankverbindung::query();

        if (! empty($blz)) {
            $query->where('blz', 'LIKE', "%{$blz}%");
        }
        if (! empty($bankname)) {
            $query->where('bankname', 'LIKE', "%{$bankname}%");
        }
        if (! empty($land)) {
            $query->where('land', 'LIKE', "%{$land}%");
        }
        if (! empty($bic)) {
            $query->where('bic', 'LIKE', "%{$bic}%");
        }

        $results = $query->get()->sortBy('bankname');

        $result = [
            'blzs' => [],
            'banknames' => [],
            'lands' => [],
            'bics' => [],
        ];

        foreach ($results as $row) {
            if (! in_array($row->blz, $result['blzs']) && ! empty($row->blz)) {
                $result['blzs'][] = $row->blz;
            }
            if (! in_array($row->bankname, $result['banknames']) && ! empty($row->bankname)) {
                $result['banknames'][] = $row->bankname;
            }
            if (! in_array($row->land, $result['lands']) && ! empty($row->land)) {
                $result['lands'][] = $row->land;
            }
            if (! in_array($row->bic, $result['bics']) && ! empty($row->bic)) {
                $result['bics'][] = $row->bic;
            }
        }

        return response()->json($result);
    }
}
