<?php

namespace App\Http\Controllers;

use App\Models\DsgvoErklaerung;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DsgvoErklaerungController extends Controller
{
    /**
     * Hole alle DSGVO-Erklärungen einer Person
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_id' => 'required|exists:personen,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => null,
                'error' => 'Ungültige Person-ID.',
                'data' => null,
            ], 400);
        }

        $erklaerungen = DsgvoErklaerung::where('person_id', $request->person_id)
            ->orderBy('zugestimmt_am', 'desc')
            ->get();

        return response()->json([
            'success' => 'DSGVO-Erklärungen erfolgreich geladen.',
            'error' => null,
            'data' => $erklaerungen,
        ]);
    }

    /**
     * Hole aktive DSGVO-Erklärung einer Person
     */
    public function aktiv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_id' => 'required|exists:personen,id',
            'stufe' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => null,
                'error' => 'Ungültige Anfrage.',
                'data' => null,
            ], 400);
        }

        $person = Person::find($request->person_id);
        $hatDsgvo = $person->hatAktiveDsgvoErklaerung($request->stufe);

        $erklaerung = null;
        if ($hatDsgvo) {
            $query = $person->dsgvoErklaerungen()->aktiv();
            if ($request->stufe) {
                $query->stufe($request->stufe);
            }
            $erklaerung = $query->latest('zugestimmt_am')->first();
        }

        return response()->json([
            'success' => $hatDsgvo ? 'Aktive DSGVO-Erklärung gefunden.' : null,
            'error' => ! $hatDsgvo ? 'Keine aktive DSGVO-Erklärung vorhanden.' : null,
            'data' => [
                'hat_dsgvo' => $hatDsgvo,
                'erklaerung' => $erklaerung,
            ],
        ]);
    }

    /**
     * Erstelle neue DSGVO-Erklärung
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_id' => 'required|exists:personen,id',
            'stufe' => 'required|integer|min:1',
            'zugestimmt_am' => 'required|date_format:d.m.Y',
            'bemerkungen' => 'nullable|string',
        ], [
            'person_id.required' => 'Die Person-ID ist erforderlich.',
            'person_id.exists' => 'Die Person existiert nicht.',
            'stufe.required' => 'Die DSGVO-Stufe ist erforderlich.',
            'zugestimmt_am.required' => 'Das Zustimmungsdatum ist erforderlich.',
            'zugestimmt_am.date_format' => 'Das Zustimmungsdatum muss im Format TT.MM.JJJJ angegeben werden.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => null,
                'error' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $erklaerung = DsgvoErklaerung::create([
            'person_id' => $request->person_id,
            'stufe' => $request->stufe,
            'zugestimmt_am' => $request->zugestimmt_am,
            'bemerkungen' => $request->bemerkungen,
            'ist_aktiv' => true,
        ]);

        return response()->json([
            'success' => 'DSGVO-Erklärung erfolgreich erstellt.',
            'error' => null,
            'data' => $erklaerung,
        ], 201);
    }

    /**
     * Widerrufe DSGVO-Erklärung
     */
    public function widerrufen(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'widerrufen_am' => 'nullable|date_format:d.m.Y',
        ], [
            'widerrufen_am.date_format' => 'Das Widerrufsdatum muss im Format TT.MM.JJJJ angegeben werden.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => null,
                'error' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $erklaerung = DsgvoErklaerung::find($id);

        if (! $erklaerung) {
            return response()->json([
                'success' => null,
                'error' => 'DSGVO-Erklärung nicht gefunden.',
                'data' => null,
            ], 404);
        }

        $erklaerung->widerrufen($request->widerrufen_am);

        return response()->json([
            'success' => 'DSGVO-Erklärung erfolgreich widerrufen.',
            'error' => null,
            'data' => $erklaerung->fresh(),
        ]);
    }

    /**
     * Lösche DSGVO-Erklärung
     */
    public function destroy(int $id)
    {
        $erklaerung = DsgvoErklaerung::find($id);

        if (! $erklaerung) {
            return response()->json([
                'success' => null,
                'error' => 'DSGVO-Erklärung nicht gefunden.',
                'data' => null,
            ], 404);
        }

        $erklaerung->delete();

        return response()->json([
            'success' => 'DSGVO-Erklärung erfolgreich gelöscht.',
            'error' => null,
            'data' => null,
        ]);
    }
}
