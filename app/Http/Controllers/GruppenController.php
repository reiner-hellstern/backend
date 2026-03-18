<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndSonderleiterRequest;
use App\Http\Requests\StoreAusbilderRequest;
use App\Http\Requests\StoreSonderleiterRequest;
use App\Http\Requests\UpdateAusbilderRequest;
use App\Http\Requests\UpdateSonderleiterRequest;
use App\Http\Resources\AusbilderResource;
use App\Http\Resources\SonderleiterResource;
use App\Models\Ausbilder;
use App\Models\Gruppe;
use App\Models\Mitglied;
use App\Models\Person;
use App\Models\Sonderleiter;
use Illuminate\Http\Request;

class GruppenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gruppe::with([
            'gruppenable',
            'vorstand1',
            'vorstand2',
            'kassenwart',
            'schriftfuehrer',
        ]);

        // Suche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('ort', 'LIKE', "%{$search}%")
                    ->orWhere('postleitzahl', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter nach Typ
        if ($request->has('type') && $request->type) {
            $query->where('gruppenable_type', 'LIKE', "%{$request->type}%");
        }

        // Sortierung
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $gruppen = $query->paginate($request->get('per_page', 25));

        // Für jede Gruppe zusätzliche Informationen hinzufügen
        $gruppen->getCollection()->transform(function ($gruppe) {
            // Typ des zugewiesenen Models bestimmen
            $gruppe->model_typ = $gruppe->gruppenable_type ? class_basename($gruppe->gruppenable_type) : 'N/A';

            // Anzahl Mitglieder hinzufügen
            $gruppe->anzahl_mitglieder = $gruppe->mitglieder_count;

            // Je nach Typ verschiedene zusätzliche Informationen
            switch ($gruppe->model_typ) {
                case 'Landesgruppe':
                    $gruppe->anzahl_bezirksgruppen = $gruppe->bezirksgruppen_count;
                    $gruppe->zusatz_info = $gruppe->anzahl_bezirksgruppen . ' Bezirksgruppen';
                    break;

                case 'Bezirksgruppe':
                    $gruppe->zugehoerige_landesgruppe = $gruppe->zugehoerigelandesgruppe;
                    $gruppe->zusatz_info = ($gruppe->zugehoerige_landesgruppe ?: 'N/A');
                    break;

                default:
                    $gruppe->zusatz_info = '';
                    break;
            }

            return $gruppe;
        });

        return response()->json([
            'success' => true,
            'data' => $gruppen->items(),
            'meta' => [
                'current_page' => $gruppen->currentPage(),
                'from' => $gruppen->firstItem(),
                'last_page' => $gruppen->lastPage(),
                'per_page' => $gruppen->perPage(),
                'to' => $gruppen->lastItem(),
                'total' => $gruppen->total(),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gruppe = Gruppe::with([
            'gruppenable',
            'vorstand1',
            'vorstand2',
            'kassenwart',
            'schriftfuehrer',
            'pressewart',
        ])->findOrFail($id);

        // Zusätzliche Informationen hinzufügen
        $gruppe->model_typ = $gruppe->gruppenable_type ? class_basename($gruppe->gruppenable_type) : 'N/A';
        $gruppe->anzahl_mitglieder = $gruppe->mitglieder_count;
        $gruppe->anzahl_bezirksgruppen = $gruppe->bezirksgruppen_count;

        return response()->json([
            'success' => true,
            'data' => $gruppe,
        ]);
    }

    /**
     * Update the specified group's basic information
     */
    public function update(Request $request, Gruppe $gruppe)
    {
        $request->validate([
            'strasse' => 'nullable|string|max:255',
            'postleitzahl' => 'nullable|string|max:10',
            'ort' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefon' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        try {
            $gruppe->update($request->only([
                'strasse',
                'postleitzahl',
                'ort',
                'email',
                'telefon',
                'website',
            ]));

            // Load relationships for response
            $gruppe->load([
                'vorstand1',
                'vorstand2',
                'kassenwart',
                'schriftfuehrer',
                'pressewart',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kontaktdaten erfolgreich aktualisiert',
                'data' => $gruppe,
            ]);

        } catch (\Exception $e) {
            \Log::error('Fehler beim Aktualisieren der Gruppe: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Aktualisieren der Kontaktdaten',
            ], 500);
        }
    }

    /**
     * Get members of a specific group
     */
    public function mitglieder(Request $request, $id)
    {
        $gruppe = Gruppe::findOrFail($id);

        // Mitglieder-Query basierend auf Gruppentyp
        $query = null;
        switch (class_basename($gruppe->gruppenable_type)) {
            case 'Bund':
                $query = Mitglied::with(['person', 'bezirksgruppe', 'landesgruppe']);
                break;

            case 'Landesgruppe':
                $query = Mitglied::with(['person', 'bezirksgruppe'])
                    ->where('landesgruppe_id', $gruppe->gruppenable_id);
                break;

            case 'Bezirksgruppe':
                $query = Mitglied::with(['person'])
                    ->where('bezirksgruppe_id', $gruppe->gruppenable_id);
                break;

            default:
                return response()->json([
                    'success' => false,
                    'error' => 'Unbekannter Gruppentyp',
                    'data' => [],
                    'meta' => [],
                ]);
        }

        // Suche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mitglied_nr', 'LIKE', "%{$search}%")
                    ->orWhereHas('person', function ($personQuery) use ($search) {
                        $personQuery->where('vorname', 'LIKE', "%{$search}%")
                            ->orWhere('nachname', 'LIKE', "%{$search}%")
                            ->orWhere('email_1', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter nach Status
        if ($request->has('status') && $request->status) {
            $query->where('status_id', $request->status);
        }

        // Sortierung
        $sortField = $request->get('sort_field', 'mitglied_nr');
        $sortDirection = $request->get('sort_direction', 'asc');

        if ($sortField === 'name') {
            $query->join('personen', 'mitglieder.person_id', '=', 'personen.id')
                ->orderBy('personen.nachname', $sortDirection)
                ->orderBy('personen.vorname', $sortDirection)
                ->select('mitglieder.*');
        } elseif ($sortField === 'eintritt') {
            $query->orderBy('datum_eintritt', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $mitglieder = $query->paginate($request->get('per_page', 25));

        // Status für jedes Mitglied berechnen
        $mitglieder->getCollection()->transform(function ($mitglied) {
            $mitglied->status = $this->getMitgliedStatus($mitglied);
            $mitglied->eintritt = $mitglied->datum_eintritt;

            return $mitglied;
        });

        return response()->json([
            'success' => true,
            'data' => $mitglieder->items(),
            'meta' => [
                'current_page' => $mitglieder->currentPage(),
                'from' => $mitglieder->firstItem(),
                'last_page' => $mitglieder->lastPage(),
                'per_page' => $mitglieder->perPage(),
                'to' => $mitglieder->lastItem(),
                'total' => $mitglieder->total(),
            ],
        ]);
    }

    /**
     * Determine member status
     */
    private function getMitgliedStatus($mitglied)
    {
        if ($mitglied->datum_austritt &&
            $mitglied->datum_austritt !== '0000-00-00' &&
            $mitglied->datum_austritt !== '') {
            return 'ausgetreten';
        }

        // Weitere Status-Logik kann hier hinzugefügt werden
        return 'aktiv';
    }

    /**
     * Get invoices/bills of a specific group
     */
    public function rechnungen(Request $request, $id)
    {
        $gruppe = Gruppe::findOrFail($id);

        $query = $gruppe->rechnungen();

        // Suche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rechnungsnummer', 'LIKE', "%{$search}%")
                    ->orWhere('anmerkungen', 'LIKE', "%{$search}%");
            });
        }

        // Filter nach Status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'bezahlt':
                    $query->where('bezahlt', true);
                    break;
                case 'offen':
                    $query->where('bezahlt', false)->where('storniert', false);
                    break;
                case 'ueberfaellig':
                    $query->where('bezahlt', false)
                        ->where('storniert', false)
                        ->where('faelligkeit', '<', now()->format('Y-m-d'));
                    break;
                case 'storniert':
                    $query->where('storniert', true);
                    break;
            }
        }

        // Filter nach Jahr
        if ($request->has('year') && $request->year) {
            $query->whereYear('rechnungsdatum', $request->year);
        }

        // Sortierung
        $sortField = $request->get('sort_field', 'rechnungsdatum');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $rechnungen = $query->paginate($request->get('per_page', 25));

        // Statistiken berechnen
        $allRechnungen = $gruppe->rechnungen();
        $statistics = [
            'total_count' => $allRechnungen->count(),
            'total_paid' => $allRechnungen->where('bezahlt', true)->sum('rechnungssumme'),
            'total_open' => $allRechnungen->where('bezahlt', false)->where('storniert', false)->sum('rechnungssumme'),
            'total_overdue' => $allRechnungen->where('bezahlt', false)
                ->where('storniert', false)
                ->where('faelligkeit', '<', now()->format('Y-m-d'))
                ->sum('rechnungssumme'),
        ];

        // Transform data for frontend
        $rechnungen->getCollection()->transform(function ($rechnung) {
            $rechnung->betreff = $rechnung->anmerkungen; // Map anmerkungen to betreff for frontend
            $rechnung->beschreibung = ''; // No description field in DB
            $rechnung->betrag = $rechnung->rechnungssumme;
            $rechnung->faelligkeitsdatum = $rechnung->faelligkeit;

            return $rechnung;
        });

        return response()->json([
            'success' => true,
            'data' => $rechnungen->items(),
            'meta' => [
                'current_page' => $rechnungen->currentPage(),
                'from' => $rechnungen->firstItem(),
                'last_page' => $rechnungen->lastPage(),
                'per_page' => $rechnungen->perPage(),
                'to' => $rechnungen->lastItem(),
                'total' => $rechnungen->total(),
            ],
            'statistics' => $statistics,
        ]);
    }

    /**
     * Get available years for invoices of a specific group
     */
    public function rechnungenYears($id)
    {
        $gruppe = Gruppe::findOrFail($id);

        $years = $gruppe->rechnungen()
            ->selectRaw('DISTINCT YEAR(rechnungsdatum) as year')
            ->whereNotNull('rechnungsdatum')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return response()->json([
            'success' => true,
            'years' => $years,
        ]);
    }

    /**
     * Get bankverbindungen for a gruppe
     */
    public function getBankverbindungen(Gruppe $gruppe)
    {
        try {
            $bankverbindungen = $gruppe->bankverbindungen()
                ->with('dokumente')
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $bankverbindungen,
                'message' => 'Bankverbindungen erfolgreich geladen.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Bankverbindungen.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Store a new bankverbindung for a gruppe
     */
    public function storeBankverbindung(Request $request, Gruppe $gruppe)
    {
        $request->validate([
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'bankname' => 'required|string|max:255',
            'kontoinhaber' => 'required|string|max:255',
            'land' => 'nullable|string|max:255',
            'ort' => 'nullable|string|max:255',
            'anmerkungen' => 'nullable|string',
            'gueltig_ab' => 'nullable|date',
            'gueltig_bis' => 'nullable|date|after_or_equal:gueltig_ab',
            'aktiv' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        try {
            $bankverbindung = $gruppe->bankverbindungen()->create([
                'iban' => $request->iban,
                'bic' => $request->bic,
                'bankname' => $request->bankname,
                'kontoinhaber' => $request->kontoinhaber,
                'land' => $request->land,
                'ort' => $request->ort,
                'anmerkungen' => $request->anmerkungen,
                'gueltig_ab' => $request->gueltig_ab,
                'gueltig_bis' => $request->gueltig_bis,
                'aktiv' => $request->boolean('aktiv'),
                'order' => $request->order ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'data' => $bankverbindung,
                'message' => 'Bankverbindung erfolgreich erstellt.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Erstellen der Bankverbindung.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Update a bankverbindung for a gruppe
     */
    public function updateBankverbindung(Request $request, Gruppe $gruppe, $bankverbindungId)
    {
        $request->validate([
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'bankname' => 'required|string|max:255',
            'kontoinhaber' => 'required|string|max:255',
            'land' => 'nullable|string|max:255',
            'ort' => 'nullable|string|max:255',
            'anmerkungen' => 'nullable|string',
            'gueltig_ab' => 'nullable|date',
            'gueltig_bis' => 'nullable|date|after_or_equal:gueltig_ab',
            'aktiv' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        try {
            $bankverbindung = $gruppe->bankverbindungen()->findOrFail($bankverbindungId);

            $bankverbindung->update([
                'iban' => $request->iban,
                'bic' => $request->bic,
                'bankname' => $request->bankname,
                'kontoinhaber' => $request->kontoinhaber,
                'land' => $request->land,
                'ort' => $request->ort,
                'anmerkungen' => $request->anmerkungen,
                'gueltig_ab' => $request->gueltig_ab,
                'gueltig_bis' => $request->gueltig_bis,
                'aktiv' => $request->boolean('aktiv'),
                'order' => $request->order,
            ]);

            return response()->json([
                'success' => true,
                'data' => $bankverbindung,
                'message' => 'Bankverbindung erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren der Bankverbindung.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Delete a bankverbindung for a gruppe
     */
    public function destroyBankverbindung(Gruppe $gruppe, $bankverbindungId)
    {
        try {
            $bankverbindung = $gruppe->bankverbindungen()->findOrFail($bankverbindungId);
            $bankverbindung->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bankverbindung erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Löschen der Bankverbindung.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Update the order of bankverbindungen for a gruppe
     */
    public function updateBankverbindungenOrder(Request $request, Gruppe $gruppe)
    {
        $request->validate([
            'bankverbindungen' => 'required|array',
            'bankverbindungen.*.id' => 'required|integer',
            'bankverbindungen.*.order' => 'required|integer',
        ]);

        try {
            foreach ($request->bankverbindungen as $item) {
                $gruppe->bankverbindungen()
                    ->where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reihenfolge der Bankverbindungen erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren der Reihenfolge.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Update funktionäre assignments for a group
     */
    public function updateFunktionaere(Request $request, $gruppeId)
    {
        $request->validate([
            'funktionär' => 'required|string|in:vorstand1,vorstand2,kassenwart,schriftfuehrer,pressewart',
            'person_id' => 'nullable|integer|exists:personen,id',
            'email' => 'nullable|email|max:255',
        ]);

        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $funktionär = $request->funktionär;

            // Update person assignment
            $gruppe->{$funktionär . '_id'} = $request->person_id;

            // Update email only if explicitly provided
            if ($request->has('email')) {
                $gruppe->{$funktionär . '_email'} = $request->email;
            }

            $gruppe->save();

            // Reload group with relationships for response
            $gruppe = $gruppe->fresh([
                'vorstand1', 'vorstand2', 'kassenwart',
                'schriftfuehrer', 'pressewart',
            ]);

            return response()->json([
                'success' => true,
                'message' => ucfirst($funktionär) . ' erfolgreich aktualisiert.',
                'data' => $gruppe,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren des Funktionärs.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Get all Ausbilder for a specific group (only group members)
     */
    public function getAusbilder(Request $request, $gruppeId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);

            // Get all group members who are also Ausbilder
            $query = Ausbilder::with([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
                'ausweisStatus:id,name,name_kurz',
                'ausbildertypen:id,name,name_kurz',
            ]);

            // Filter based on group type
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Ausbilder sehen
                    break;

                case 'Landesgruppe':
                    $query->whereHas('person.mitglied', function ($mitgliedQuery) use ($gruppe) {
                        $mitgliedQuery->where('landesgruppe_id', $gruppe->gruppenable_id);
                    });
                    break;

                case 'Bezirksgruppe':
                    $query->whereHas('person.mitglied', function ($mitgliedQuery) use ($gruppe) {
                        $mitgliedQuery->where('bezirksgruppe_id', $gruppe->gruppenable_id);
                    });
                    break;

                default:
                    return response()->json([
                        'error' => 'Unbekannter Gruppentyp',
                    ], 400);
            }

            $ausbilder = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => AusbilderResource::collection($ausbilder),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Laden der Ausbilder: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Laden der Ausbilder',
            ], 500);
        }
    }

    /**
     * Store a new Ausbilder for a group
     */
    public function storeAusbilder(StoreAusbilderRequest $request, $gruppeId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);

            // Check if person is a member of this group based on group type
            $isMember = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Personen zu Ausbildern machen
                    $isMember = Mitglied::where('person_id', $request->person_id)->exists();
                    break;

                case 'Landesgruppe':
                    $isMember = Mitglied::where('person_id', $request->person_id)
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $isMember = Mitglied::where('person_id', $request->person_id)
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                default:
                    return response()->json([
                        'error' => 'Unbekannter Gruppentyp',
                    ], 400);
            }

            if (! $isMember) {
                return response()->json([
                    'error' => 'Die Person muss Mitglied der Gruppe sein',
                ], 422);
            }

            $ausbilder = Ausbilder::create($request->validated());

            $ausbilder->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
                'ausweisStatus:id,name,name_kurz',
                'ausbildertypen:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ausbilder erfolgreich hinzugefügt',
                'data' => new AusbilderResource($ausbilder),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Erstellen des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Erstellen des Ausbilders',
            ], 500);
        }
    }

    /**
     * Update an existing Ausbilder for a group
     */
    public function updateAusbilder(UpdateAusbilderRequest $request, $gruppeId, $ausbilderId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $ausbilder = Ausbilder::findOrFail($ausbilderId);

            // Verify that this Ausbilder belongs to a member of this group based on group type
            $belongsToGroup = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Ausbilder bearbeiten
                    $belongsToGroup = $ausbilder->person->mitglied()->exists();
                    break;

                case 'Landesgruppe':
                    $belongsToGroup = $ausbilder->person->mitglied()
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $belongsToGroup = $ausbilder->person->mitglied()
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;
            }

            if (! $belongsToGroup) {
                return response()->json([
                    'error' => 'Zugriff verweigert',
                ], 403);
            }

            $ausbilder->update($request->validated());

            // Update Ausbildertypen if provided
            if ($request->has('ausbildertypen')) {
                $ausbilder->ausbildertypen()->sync($request->ausbildertypen);
            }

            $ausbilder->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
                'ausweisStatus:id,name,name_kurz',
                'ausbildertypen:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ausbilder erfolgreich aktualisiert',
                'data' => new AusbilderResource($ausbilder),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Aktualisieren des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Ausbilders',
            ], 500);
        }
    }

    /**
     * Delete/deactivate Ausbilder
     */
    public function destroyAusbilder($gruppeId, $ausbilderId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $ausbilder = Ausbilder::findOrFail($ausbilderId);

            // Verify that this Ausbilder belongs to a member of this group based on group type
            $belongsToGroup = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Ausbilder löschen
                    $belongsToGroup = $ausbilder->person->mitglied()->exists();
                    break;

                case 'Landesgruppe':
                    $belongsToGroup = $ausbilder->person->mitglied()
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $belongsToGroup = $ausbilder->person->mitglied()
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;
            }

            if (! $belongsToGroup) {
                return response()->json([
                    'error' => 'Zugriff verweigert',
                ], 403);
            }

            $ausbilder->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ausbilder erfolgreich gelöscht',
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Löschen des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Löschen des Ausbilders',
            ], 500);
        }
    }

    /**
     * Get all Sonderleiter for a specific group (only group members)
     */
    public function getSonderleiter(Request $request, $gruppeId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);

            // Get all group members who are also Sonderleiter
            $query = Sonderleiter::with([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
            ]);

            // Filter based on group type
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Sonderleiter sehen
                    break;

                case 'Landesgruppe':
                    $query->whereHas('person.mitglied', function ($mitgliedQuery) use ($gruppe) {
                        $mitgliedQuery->where('landesgruppe_id', $gruppe->gruppenable_id);
                    });
                    break;

                case 'Bezirksgruppe':
                    $query->whereHas('person.mitglied', function ($mitgliedQuery) use ($gruppe) {
                        $mitgliedQuery->where('bezirksgruppe_id', $gruppe->gruppenable_id);
                    });
                    break;

                default:
                    return response()->json([
                        'error' => 'Unbekannter Gruppentyp',
                    ], 400);
            }

            $sonderleiter = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => SonderleiterResource::collection($sonderleiter),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Laden der Sonderleiter: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Laden der Sonderleiter',
            ], 500);
        }
    }

    /**
     * Store a new Sonderleiter for a group
     */
    public function storeSonderleiter(StoreSonderleiterRequest $request, $gruppeId)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);

            // Check if person is a member of this group based on group type
            $isMember = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Personen zu Sonderleitern machen
                    $isMember = Mitglied::where('person_id', $request->person_id)->exists();
                    break;

                case 'Landesgruppe':
                    $isMember = Mitglied::where('person_id', $request->person_id)
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $isMember = Mitglied::where('person_id', $request->person_id)
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                default:
                    return response()->json([
                        'error' => 'Unbekannter Gruppentyp',
                    ], 400);
            }

            if (! $isMember) {
                return response()->json([
                    'error' => 'Die Person muss Mitglied der Gruppe sein',
                ], 422);
            }

            $validatedData = $request->validated();

            // Logik für aktiv-Status basierend auf Ende-Datum
            if (isset($validatedData['ende']) && ! empty($validatedData['ende'])) {
                // Wenn Ende gesetzt ist, automatisch aktiv = false
                $validatedData['aktiv'] = false;

                // Prüfen, ob Ende in der Zukunft liegt
                $ende = \Carbon\Carbon::parse($validatedData['ende']);
                $heute = \Carbon\Carbon::today();

                if ($ende->gt($heute)) {
                    // Ende liegt in der Zukunft -> auf heute setzen
                    $validatedData['ende'] = $heute->format('d.m.Y');
                }
            } else {
                // Wenn Ende nicht gesetzt oder leer, automatisch aktiv = true
                $validatedData['aktiv'] = true;
                $validatedData['ende'] = null;
            }

            $sonderleiter = Sonderleiter::create($validatedData);

            $sonderleiter->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sonderleiter erfolgreich hinzugefügt',
                'data' => new SonderleiterResource($sonderleiter),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Erstellen des Sonderleiters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Erstellen des Sonderleiters',
            ], 500);
        }
    }

    /**
     * Update an existing Sonderleiter for a group
     */
    public function updateSonderleiter(UpdateSonderleiterRequest $request, $gruppeId, $sonderleiterI)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $sonderleiter = Sonderleiter::findOrFail($sonderleiterI);

            // Verify that this Sonderleiter belongs to a member of this group based on group type
            $belongsToGroup = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Sonderleiter bearbeiten
                    $belongsToGroup = $sonderleiter->person->mitglied()->exists();
                    break;

                case 'Landesgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;
            }

            if (! $belongsToGroup) {
                return response()->json([
                    'error' => 'Zugriff verweigert',
                ], 403);
            }

            $validatedData = $request->validated();

            // Logik für aktiv-Status basierend auf Ende-Datum
            if (isset($validatedData['ende'])) {
                if (! empty($validatedData['ende'])) {
                    // Wenn Ende gesetzt ist, automatisch aktiv = false
                    $validatedData['aktiv'] = false;

                    // Prüfen, ob Ende in der Zukunft liegt
                    $ende = \Carbon\Carbon::parse($validatedData['ende']);
                    $heute = \Carbon\Carbon::today();

                    if ($ende->gt($heute)) {
                        // Ende liegt in der Zukunft -> auf heute setzen
                        $validatedData['ende'] = $heute->format('d.m.Y');
                    }
                } else {
                    // Wenn Ende leer/null ist, automatisch aktiv = true
                    $validatedData['aktiv'] = true;
                    $validatedData['ende'] = null;
                }
            } elseif (! isset($validatedData['ende']) || empty($validatedData['ende'])) {
                // Wenn Ende nicht gesetzt oder leer, automatisch aktiv = true
                $validatedData['aktiv'] = true;
            }

            $sonderleiter->update($validatedData);

            $sonderleiter->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sonderleiter erfolgreich aktualisiert',
                'data' => new SonderleiterResource($sonderleiter),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Aktualisieren des Sonderleiters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Sonderleiters',
            ], 500);
        }
    }

    /**
     * Delete/deactivate Sonderleiter
     */
    public function destroySonderleiter($gruppeId, $sonderleiterI)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $sonderleiter = Sonderleiter::findOrFail($sonderleiterI);

            // Verify that this Sonderleiter belongs to a member of this group based on group type
            $belongsToGroup = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Sonderleiter löschen
                    $belongsToGroup = $sonderleiter->person->mitglied()->exists();
                    break;

                case 'Landesgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;
            }

            if (! $belongsToGroup) {
                return response()->json([
                    'error' => 'Zugriff verweigert',
                ], 403);
            }

            $sonderleiter->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sonderleiter erfolgreich gelöscht',
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Löschen des Sonderleiters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Löschen des Sonderleiters',
            ], 500);
        }
    }

    /**
     * End Sonderleiter assignment
     */
    public function endSonderleiter(EndSonderleiterRequest $request, $gruppeId, $sonderleiterI)
    {
        try {
            $gruppe = Gruppe::findOrFail($gruppeId);
            $sonderleiter = Sonderleiter::findOrFail($sonderleiterI);

            // Verify that this Sonderleiter belongs to a member of this group based on group type
            $belongsToGroup = false;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    // Bund kann alle Sonderleiter beenden
                    $belongsToGroup = $sonderleiter->person->mitglied()->exists();
                    break;

                case 'Landesgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('landesgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;

                case 'Bezirksgruppe':
                    $belongsToGroup = $sonderleiter->person->mitglied()
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id)
                        ->exists();
                    break;
            }

            if (! $belongsToGroup) {
                return response()->json([
                    'error' => 'Zugriff verweigert',
                ], 403);
            }

            $sonderleiter->update([
                'ende' => $request->ende,
                'aktiv' => false,
            ]);

            $sonderleiter->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sonderleiter erfolgreich beendet',
                'data' => new SonderleiterResource($sonderleiter),
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler beim Beenden des Sonderleiters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Beenden des Sonderleiters',
            ], 500);
        }
    }

    /**
     * Get members for autocomplete in group context
     */
    public function getMitgliederAutocomplete(Request $request, Gruppe $gruppe)
    {
        try {
            $search = $request->get('search', '');
            $limit = $request->get('limit', 20);

            if (strlen($search) < 2) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }

            // Mitglieder-Query basierend auf Gruppentyp
            $query = null;
            switch (class_basename($gruppe->gruppenable_type)) {
                case 'Bund':
                    $query = Mitglied::with(['person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1', 'bezirksgruppe', 'landesgruppe']);
                    break;

                case 'Landesgruppe':
                    $query = Mitglied::with(['person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1', 'bezirksgruppe'])
                        ->where('landesgruppe_id', $gruppe->gruppenable_id);
                    break;

                case 'Bezirksgruppe':
                    $query = Mitglied::with(['person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1'])
                        ->where('bezirksgruppe_id', $gruppe->gruppenable_id);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'error' => 'Unbekannter Gruppentyp',
                        'data' => [],
                    ]);
            }

            $mitglieder = $query
                ->where('status', 1)  // Aktive Mitglieder
                ->whereHas('person', function ($personQuery) use ($search) {
                    $personQuery->where(function ($q) use ($search) {
                        $q->where('vorname', 'like', "%{$search}%")
                            ->orWhere('nachname', 'like', "%{$search}%")
                            ->orWhere('email_1', 'like', "%{$search}%");
                    });
                })
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $mitglieder,
            ]);
        } catch (\Exception $e) {
            \Log::error('Fehler bei Mitglieder-Autocomplete: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Laden der Mitglieder',
            ], 500);
        }
    }
}
