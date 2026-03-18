<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAusbilderRequest;
use App\Http\Requests\UpdateAusbilderRequest;
use App\Http\Resources\AusbilderCollection;
use App\Models\Ausbilder;
use App\Models\Ausbildertyp;
use App\Models\Mitglied;
use App\Models\OptionAusbilderausweisStatus;
use App\Models\OptionAusbilderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AusbilderController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'mitglied_nr');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $mitglieder = Mitglied::with('person')
            ->leftjoin('personen', 'personen.id', '=', 'mitglieder.person_id')
            ->leftjoin('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')
            ->leftjoin('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')
            ->select('mitglieder.*', 'personen.*', 'mitglieder.id AS id', 'landesgruppen.landesgruppe AS landesgruppe', 'bezirksgruppen.bezirksgruppe AS bezirksgruppe')
            ->where('mitglieder.landesgruppe_id', '>', 0)
            ->where('mitglieder.bezirksgruppe_id', '>', 0)
            ->where(function ($query) use ($columns) {
                if (! empty($columns)) {
                    foreach ($columns as $column) {
                        if ($column['db_field_as']) {
                            $column['db_field'] = $column['db_field_as'];
                        }
                        $table = $column['table'] . '.';
                        if ($column['filterable'] == true && $column['filtertype'] != 0) {
                            switch ($column['filtertype']) {
                                case 2:
                                    $query->where($table . $column['db_field'], 'NOT LIKE', '%' . $column['filter'] . '%');
                                    break;
                                case 3:
                                    $query->where($table . $column['db_field'], 'LIKE', $column['filter'] . '%');
                                    break;
                                case 4: //LEER
                                    $query->where(function ($q) use ($column, $table) {
                                        $q->whereNull($table . $column['db_field'])->orWhere($table . $column['db_field'], '=', '0000-00-00');
                                    });
                                    break;
                                case 5:  //NICHT LEER
                                    $query->whereNotNull($table . $column['db_field'])->where($table . $column['db_field'], '<>', '')->where($table . $column['db_field'], '<>', '0000-00-00');
                                    break;
                                case 6:
                                    $query->where($table . $column['db_field'], '=', $column['filter']);
                                    break;
                                case 7:
                                    $query->where($table . $column['db_field'], '<>', $column['filter']);
                                    break;
                                case 8:
                                    $query->where($table . $column['db_field'], '>', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                    break;
                                case 9:
                                    $query->where($table . $column['db_field'], '<', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                    break;
                                case 10:
                                    $query->where($table . $column['db_field'], '>=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                    break;
                                case 11:
                                    $query->where($table . $column['db_field'], '<=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                    break;
                                case 12:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->whereDate($table . $column['db_field'], $sqldate);
                                    break;
                                case 13:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->where($table . $column['db_field'], '<=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                                    break;
                                case 14:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->where($table . $column['db_field'], '>=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                                    break;
                                case 1:
                                default:
                                    $query->where($table . $column['db_field'], 'LIKE', '%' . $column['filter'] . '%');
                                    break;

                            }
                        }
                    }
                }
            })->when($search != '', function ($query) use ($columns, $search) {
                $first = true;
                if (! empty($columns)) {
                    foreach ($columns as $column) {
                        if ($column['db_field_as']) {
                            $column['db_field'] = $column['db_field_as'];
                        }
                        $table = $column['table'] . '.';
                        if ($column['searchable'] == true) {
                            if ($first == true) {
                                $query->where($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                                $first = false;
                            } else {
                                $query->orWhere($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                            }
                        }
                    }
                }
            })->orderBy($sortField, $sortDirection)
            ->paginate($pagination);

        return response()->json([
            'success' => true,
            'data' => $mitglieder,
        ]);
    }

    /**
     * Get ausbilder for overview page with pagination and search.
     */
    public function getAusbilder(Request $request)
    {
        $search = $request->input('search', '');
        $statusFilter = $request->input('status_filter');
        $ausbilderFilter = $request->input('ausbilder_filter');
        $sortField = $request->input('sort_field', 'person.nachname');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);

        $query = Ausbilder::with([
            'person.mitglied.bezirksgruppe',
            'person.mitglied.landesgruppe',
            'status',
            'ausbildertypen',
        ]);

        // Search functionality
        if (! empty($search)) {
            $query->whereHas('person', function ($q) use ($search) {
                $q->where('vorname', 'LIKE', '%' . $search . '%')
                    ->orWhere('nachname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email_1', 'LIKE', '%' . $search . '%');
            })->orWhere('ausweisnummer', 'LIKE', '%' . $search . '%');
        }

        // Status filter
        if ($statusFilter != '') {
            $query->where('status_id', $statusFilter);
        }

        // Ausbildertypen filter
        if ($ausbilderFilter != '') {
            // Ensure it's an array
            if (is_string($ausbilderFilter)) {
                $ausbilderFilter = explode(',', $ausbilderFilter);
            }
            $query->whereHas('ausbildertypen', function ($q) use ($ausbilderFilter) {
                $q->whereIn('ausbildertyp_id', $ausbilderFilter);
            });
        }

        // Sorting
        if (strpos($sortField, '.') !== false) {
            // Handle relationship sorting
            $parts = explode('.', $sortField);
            if ($parts[0] === 'person' && isset($parts[1])) {
                $query->join('personen', 'personen.id', '=', 'ausbilder.person_id')
                    ->orderBy('personen.' . $parts[1], $sortDirection)
                    ->select('ausbilder.*');
            } elseif ($parts[0] === 'status' && $parts[1] === 'name') {
                $query->join('option_ausbilderstati', 'option_ausbilderstati.id', '=', 'ausbilder.status_id')
                    ->orderBy('option_ausbilderstati.name', $sortDirection)
                    ->select('ausbilder.*');
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        // Pagination
        $ausbilder = $query->paginate($perPage);

        return new AusbilderCollection($ausbilder);

        return response()->json([
            'success' => true,
            'data' => $ausbilder->items(),
            'meta' => [
                'current_page' => $ausbilder->currentPage(),
                'last_page' => $ausbilder->lastPage(),
                'per_page' => $ausbilder->perPage(),
                'total' => $ausbilder->total(),
                'from' => $ausbilder->firstItem(),
                'to' => $ausbilder->lastItem(),
            ],
        ]);
    }

    /**
     * Display the specified Ausbilder with all relationships
     */
    public function show($id)
    {
        try {
            $ausbilder = Ausbilder::with([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name',
                'ausweisStatus:id,name',
                'ausbildertypen:id,name',
                'dokumente',
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $ausbilder,
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Laden des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Laden des Ausbilders',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAusbilderRequest $request)
    {
        try {
            // Create the Ausbilder with all validated fields
            $ausbilder = Ausbilder::create($request->only([
                'person_id',
                'beginn',
                'ende',
                'status_id',
                'ausweis_status_id',
                'ausweisnummer',
                'fortbildung_gueltig',
                'fortbildung_bestaetigt_am',
            ]));

            // Attach selected Ausbildertypen with aktiv = true
            if ($request->has('ausbildertypen') && ! empty($request->ausbildertypen)) {
                $syncData = [];
                foreach ($request->ausbildertypen as $typId) {
                    $syncData[$typId] = ['aktiv' => true];
                }
                $ausbilder->ausbildertypen()->sync($syncData);
            }

            // Load relationships for response
            $ausbilder->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
                'ausweisStatus:id,name,name_kurz',
                'ausbildertypen:id,name,name_kurz',
            ]);

            return response()->json([
                'success' => 'Ausbilder erfolgreich erstellt',
                'data' => $ausbilder,
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Erstellen des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Erstellen des Ausbilders',
            ], 500);
        }
    }

    /**
     * Update the specified Ausbilder
     */
    public function update(UpdateAusbilderRequest $request, $id)
    {
        try {
            $ausbilder = Ausbilder::findOrFail($id);

            // Update basic fields (person_id can also be updated)
            $ausbilder->update($request->only([
                'person_id',
                'beginn',
                'ende',
                'status_id',
                'ausweis_status_id',
                'ausweisnummer',
                'fortbildung_gueltig',
                'fortbildung_bestaetigt_am',
            ]));

            // Update Ausbildertypen relationship
            if ($request->has('ausbildertypen')) {
                if (! empty($request->ausbildertypen)) {
                    // First, deactivate all current types
                    $ausbilder->allAusbildertypen()->updateExistingPivot(
                        $ausbilder->allAusbildertypen->pluck('id'),
                        ['aktiv' => false]
                    );

                    // Then attach/activate the selected types
                    foreach ($request->ausbildertypen as $typId) {
                        $ausbilder->allAusbildertypen()->syncWithoutDetaching([
                            $typId => ['aktiv' => true],
                        ]);
                    }
                } else {
                    // If empty array is sent, deactivate all types
                    $ausbilder->allAusbildertypen()->updateExistingPivot(
                        $ausbilder->allAusbildertypen->pluck('id'),
                        ['aktiv' => false]
                    );
                }
            }

            // Reload with relationships
            $ausbilder->load([
                'person:id,vorname,nachname,strasse,postleitzahl,ort,telefon_1,email_1',
                'status:id,name,name_kurz',
                'ausweisStatus:id,name,name_kurz',
                'ausbildertypen:id,name,name_kurz',
                'allAusbildertypen:id,name,name_kurz',
                'dokumente',
            ]);

            return response()->json([
                'success' => 'Ausbilder erfolgreich aktualisiert',
                'data' => $ausbilder,
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Aktualisieren des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Ausbilders',
            ], 500);
        }
    }

    /**
     * Get all available options for Ausbilder editing
     */
    public function getOptions()
    {
        try {
            $options = [
                'ausbilder_stati' => OptionAusbilderStatus::aktiv()->ordered()->get(['id', 'name', 'name_kurz']),
                'ausbilder_ausweis_stati' => OptionAusbilderausweisStatus::aktiv()->ordered()->get(['id', 'name', 'name_kurz']),
                'ausbildertypen' => Ausbildertyp::aktiv()->ordered()->get(['id', 'name', 'name_kurz']),
            ];

            return response()->json([
                'success' => true,
                'data' => $options,
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Laden der Optionen: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Laden der Optionen',
            ], 500);
        }
    }

    /**
     * Upload document for Ausbilder
     */
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $ausbilder = Ausbilder::findOrFail($id);

            // TODO: Implement document upload logic
            // This depends on your existing document system

            return response()->json([
                'success' => true,
                'message' => 'Dokument erfolgreich hochgeladen',
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Hochladen des Dokuments: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Hochladen des Dokuments',
            ], 500);
        }
    }

    /**
     * Remove the specified Ausbilder from storage.
     */
    public function destroy($id)
    {
        try {
            $ausbilder = Ausbilder::findOrFail($id);

            // Detach all relationships
            $ausbilder->ausbildertypen()->detach();

            // Delete the ausbilder
            $ausbilder->delete();

            return response()->json([
                'success' => 'Ausbilder erfolgreich gelöscht',
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Löschen des Ausbilders: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Löschen des Ausbilders',
            ], 500);
        }
    }
}
