<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRichterRequest;
use App\Http\Requests\UpdateRichterRequest;
use App\Http\Resources\RichterCollection;
use App\Http\Resources\RichterResource;
use App\Models\OptionRichterstatus;
use App\Models\Person;
use App\Models\Richter;
use App\Models\Richtertyp;
use App\Traits\SavePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RichterController extends Controller
{
    use SavePerson;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'person.nachname');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);
        $search = $request->input('search', '');
        $statusFilter = $request->input('status_filter');
        $richtertypenFilter = $request->input('richtertypen_filter');

        // Base query mit allen benötigten Beziehungen
        $query = Richter::with([
            'person.mitglied.landesgruppe',
            'person.mitglied.bezirksgruppe',
            'richtertypen',
            'status',
        ]);

        // Search functionality
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('person', function ($personQuery) use ($search) {
                    $personQuery->where('vorname', 'LIKE', "%{$search}%")
                        ->orWhere('nachname', 'LIKE', "%{$search}%")
                        ->orWhere('email_1', 'LIKE', "%{$search}%");
                })
                    ->orWhere('fcinummer', 'LIKE', "%{$search}%")
                    ->orWhere('verein', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if (! empty($statusFilter)) {
            $query->where('status_id', $statusFilter);
        }

        if (! empty($richtertypenFilter)) {
            // Ensure it's an array
            if (is_string($richtertypenFilter)) {
                $richtertypenFilter = explode(',', $richtertypenFilter);
            }
            $richtertypenFilter = array_filter($richtertypenFilter); // Remove empty values

            if (! empty($richtertypenFilter)) {
                $query->whereHas('richtertypen', function ($q) use ($richtertypenFilter) {
                    $q->whereIn('richtertyp_id', $richtertypenFilter);
                });
            }
        }

        // Sorting
        switch ($sortField) {
            case 'person.nachname':
                $query->join('personen', 'richter.person_id', '=', 'personen.id')
                    ->orderBy('personen.nachname', $sortDirection)
                    ->orderBy('personen.vorname', $sortDirection)
                    ->select('richter.*');
                break;
            case 'person.mitglied.mitgliedsnummer':
                $query->join('personen', 'richter.person_id', '=', 'personen.id')
                    ->leftJoin('mitglieder', 'personen.id', '=', 'mitglieder.person_id')
                    ->orderBy('mitglieder.mitglied_nr', $sortDirection)
                    ->select('richter.*');
                break;
            case 'beginn':
                $query->orderBy('beginn', $sortDirection);
                break;
            case 'status.name':
                $query->join('optionen_richterstatus', 'richter.status_id', '=', 'optionen_richterstatus.id')
                    ->orderBy('optionen_richterstatus.name', $sortDirection)
                    ->select('richter.*');
                break;
            default:
                $query->orderBy('richter.id', $sortDirection);
        }

        $richter = $query->paginate($perPage);

        return new RichterCollection($richter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRichterRequest $request)
    {
        try {
            $personId = $request->person_id;

            // Handle person creation/finding using SavePerson trait
            if ($request->has('person') && ! $personId) {
                $personResult = $this->savePerson($request->person);
                $personId = $personResult['person_id'];
            }

            // Validate that person_id exists
            if (! $personId) {
                return response()->json([
                    'error' => 'Eine Person muss ausgewählt oder erstellt werden',
                ], 422);
            }

            // Check if person already has a Richter record
            if (Richter::where('person_id', $personId)->exists()) {
                return response()->json([
                    'error' => 'Diese Person ist bereits als Richter eingetragen',
                ], 422);
            }

            // Determine if person is DRC member
            $person = Person::with('mitglied')->find($personId);
            $isDrcMember = $person && $person->mitglied && $person->mitglied->mitglied_nr;

            $richter = Richter::create([
                'person_id' => $personId,
                'beginn' => $request->beginn,
                'ende' => $request->ende,
                'status_id' => $request->status_id,
                'drc' => $isDrcMember ? 1 : 0,
                'fcinummer' => $isDrcMember ? null : $request->fcinummer,
                'verein' => $isDrcMember ? null : $request->verein,
            ]);

            // Richtertypen zuordnen falls vorhanden
            if ($request->has('richtertypen') && ! empty($request->richtertypen)) {
                $richter->richtertypen()->sync($request->richtertypen);
            }

            return response()->json([
                'success' => 'Richter erfolgreich erstellt',
                'data' => new RichterResource($richter->load(['person.mitglied.landesgruppe', 'person.mitglied.bezirksgruppe', 'richtertypen', 'status'])),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Fehler beim Erstellen des Richters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Erstellen des Richters: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Richter $richter)
    {
        return new RichterResource($richter->load(['person', 'richtertypen', 'status']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRichterRequest $request, Richter $richter)
    {

        try {
            $richter->update($request->only([
                'person_id', 'beginn', 'ende', 'status_id', 'drc',
                'fcinummer', 'verein', 'telefon', 'mobil', 'email',
            ]));

            // Richtertypen aktualisieren falls vorhanden
            if ($request->has('richtertypen')) {
                $richter->richtertypen()->sync($request->richtertypen);
            }

            return response()->json([
                'success' => true,
                'message' => 'Richter erfolgreich aktualisiert',
                'data' => new RichterResource($richter->load(['person', 'richtertypen', 'status'])),
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Aktualisieren des Richters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Richters',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Richter $richter)
    {
        try {
            // Richtertypen-Zuordnungen entfernen
            $richter->richtertypen()->detach();

            $richter->delete();

            return response()->json([
                'success' => true,
                'message' => 'Richter erfolgreich gelöscht',
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Löschen des Richters: ' . $e->getMessage());

            return response()->json([
                'error' => 'Fehler beim Löschen des Richters',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available richter status options
     */
    public function getStatus()
    {
        return OptionRichterstatus::active()->orderBy('order')->get();
    }

    /**
     * Get available richter types
     */
    public function getRichtertypen()
    {
        return Richtertyp::active()->orderBy('order')->get();
    }
}
