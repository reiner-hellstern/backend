<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontaktdatenaenderungRequest;
use App\Http\Requests\UpdateKontaktdatenaenderungRequest;
use App\Http\Resources\KontaktdatenaenderungResource;
use App\Models\Kontaktdatenaenderung;
use App\Models\Person;
use App\Models\Personenadresse;
use App\Models\Zuchtstaette;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class KontaktdatenaenderungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $kontaktdatenaenderungen = Kontaktdatenaenderung::with(['person', 'bestaetigtVon'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => 'Kontaktdatenänderungen erfolgreich geladen',
                'data' => KontaktdatenaenderungResource::collection($kontaktdatenaenderungen),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Kontaktdatenänderungen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKontaktdatenaenderungRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // 1. Kontaktdatenänderung erstellen
            $kontaktdatenaenderung = Kontaktdatenaenderung::create($request->validated());

            // 2. Business Logic: Adresse und Zuchtstätte verarbeiten
            $this->processAdressUndZuchtstaettenAenderung($kontaktdatenaenderung, $request);

            DB::commit();

            return response()->json([
                'success' => 'Kontaktdatenänderung erfolgreich gespeichert und verarbeitet',
                'data' => new KontaktdatenaenderungResource($kontaktdatenaenderung->load(['person', 'dokumente'])),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Fehler beim Speichern der Kontaktdatenänderung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontaktdatenaenderung $kontaktdatenaenderung): JsonResponse
    {
        try {
            $kontaktdatenaenderung->load(['person', 'bestaetigtVon', 'dokumente']);

            return response()->json([
                'success' => 'Kontaktdatenänderung erfolgreich geladen',
                'data' => new KontaktdatenaenderungResource($kontaktdatenaenderung),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Kontaktdatenänderung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage (für Office-Bearbeitung).
     */
    public function update(UpdateKontaktdatenaenderungRequest $request, Kontaktdatenaenderung $kontaktdatenaenderung): JsonResponse
    {
        try {
            $kontaktdatenaenderung->update($request->validated());

            return response()->json([
                'success' => 'Kontaktdatenänderung erfolgreich aktualisiert',
                'data' => new KontaktdatenaenderungResource($kontaktdatenaenderung->load(['person', 'bestaetigtVon'])),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren der Kontaktdatenänderung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontaktdatenaenderung $kontaktdatenaenderung): JsonResponse
    {
        try {
            $kontaktdatenaenderung->delete();

            return response()->json([
                'success' => 'Kontaktdatenänderung erfolgreich gelöscht',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen der Kontaktdatenänderung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verarbeitet Adress- und Zuchtstättenänderungen
     */
    private function processAdressUndZuchtstaettenAenderung(Kontaktdatenaenderung $kontaktdatenaenderung, StoreKontaktdatenaenderungRequest $request): void
    {
        $person = Person::find($kontaktdatenaenderung->person_id);
        $hasAdresseChange = $this->hasAdresseChange($kontaktdatenaenderung);

        if ($hasAdresseChange) {
            $this->processAdresseAenderung($person, $kontaktdatenaenderung);
            $this->checkAndDeactivateBreedingStation($person, $kontaktdatenaenderung);
        }

        // TODO: Hier könnten Notifications für Namensdatenänderungen eingefügt werden
        if ($this->hasNameChange($kontaktdatenaenderung)) {
            // Notification/Task für Office-Bearbeitung erstellen
            $this->createNameChangeNotification($kontaktdatenaenderung);
        }
    }

    /**
     * Prüft ob sich Adressdaten geändert haben
     */
    private function hasAdresseChange(Kontaktdatenaenderung $kontaktdatenaenderung): bool
    {
        return ! empty($kontaktdatenaenderung->strasse) ||
               ! empty($kontaktdatenaenderung->postleitzahl) ||
               ! empty($kontaktdatenaenderung->ort);
    }

    /**
     * Prüft ob sich Namensdaten geändert haben
     */
    private function hasNameChange(Kontaktdatenaenderung $kontaktdatenaenderung): bool
    {
        return ! empty($kontaktdatenaenderung->vorname) ||
               ! empty($kontaktdatenaenderung->nachname) ||
               ! empty($kontaktdatenaenderung->geburtsdatum);
    }

    /**
     * Verarbeitet Adressänderung
     */
    private function processAdresseAenderung(Person $person, Kontaktdatenaenderung $kontaktdatenaenderung): void
    {
        $heute = Carbon::now()->format('Y-m-d');

        // Aktuelle Adresse deaktivieren
        Personenadresse::where('person_id', $person->id)
            ->where('aktiv', 1)
            ->update([
                'aktiv' => 0,
                'bis' => $heute,
            ]);

        // Neue Adresse erstellen - mit allen verfügbaren Feldern
        Personenadresse::create([
            'person_id' => $person->id,
            'strasse' => $kontaktdatenaenderung->strasse,
            'adresszusatz' => $kontaktdatenaenderung->adresszusatz,
            'postleitzahl' => $kontaktdatenaenderung->postleitzahl,
            'ort' => $kontaktdatenaenderung->ort,
            'land' => $kontaktdatenaenderung->land,
            'laenderkuerzel' => $kontaktdatenaenderung->laenderkuerzel,
            'aktiv' => 1,
            'von' => $heute,
            'standard' => 1, // Als neue Standardadresse setzen
        ]);

        // Personendaten aktualisieren (optional)
        $person->update([
            'strasse' => $kontaktdatenaenderung->strasse,
            'postleitzahl' => $kontaktdatenaenderung->postleitzahl,
            'ort' => $kontaktdatenaenderung->ort,
            'land' => $kontaktdatenaenderung->land,
            'laenderkuerzel' => $kontaktdatenaenderung->laenderkuerzel,
        ]);
    }

    /**
     * Prüft und deaktiviert Zuchtstätte bei Adressänderung
     */
    private function checkAndDeactivateBreedingStation(Person $person, Kontaktdatenaenderung $kontaktdatenaenderung): void
    {
        // Prüfe ob Person einen Zwinger hat - verwende first() um das Model zu holen
        $zwinger = $person->zwinger()->first();
        if (! $zwinger) {
            return;
        }

        // Aktuelle Zuchtstätte des Zwingers finden
        $aktuelleZuchtstaette = Zuchtstaette::where('zwinger_id', $zwinger->id)
            ->where('aktiv', 1)
            ->first();

        if (! $aktuelleZuchtstaette) {
            return;
        }

        // Prüfe ob neue Adresse mit Zuchtstättenadresse übereinstimmt
        $addressMatches = $aktuelleZuchtstaette->strasse === $kontaktdatenaenderung->strasse &&
                         $aktuelleZuchtstaette->postleitzahl === $kontaktdatenaenderung->postleitzahl &&
                         $aktuelleZuchtstaette->ort === $kontaktdatenaenderung->ort;

        if (! $addressMatches) {
            // Zuchtstätte deaktivieren wenn Adressen nicht übereinstimmen
            $aktuelleZuchtstaette->update([
                'aktiv' => 0,
                'bis' => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }

    /**
     * Erstellt Notification für Namensdatenänderung
     */
    private function createNameChangeNotification(Kontaktdatenaenderung $kontaktdatenaenderung): void
    {
        // TODO: Hier könnte eine Notification oder Task erstellt werden
        // für die Office-Bearbeitung von Namensdatenänderungen

        // Beispiel:
        // Notification::create([
        //     'type' => 'name_change_request',
        //     'data' => ['kontaktdatenaenderung_id' => $kontaktdatenaenderung->id],
        //     'notifiable_type' => 'App\Models\Role',
        //     'notifiable_id' => $office_role_id
        // ]);
    }
}
