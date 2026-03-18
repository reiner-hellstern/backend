<?php

namespace App\Traits;

use App\Models\Hund;
use App\Models\Person;
use Carbon\Carbon;

trait CheckActiveOwnership
{
    /**
     * Prüft, ob andere aktive Mitglieder (außer der angegebenen Person)
     * aktuelle Eigentümer eines Hundes sind
     *
     * @param  int  $hundId  - ID des Hundes
     * @param  int|null  $excludePersonId  - Person-ID die ausgeschlossen werden soll
     * @return array - Ergebnis der Prüfung
     */
    public function hasOtherActiveOwners(int $hundId, ?int $excludePersonId = null): array
    {
        $hund = Hund::find($hundId);

        if (! $hund) {
            return [
                'success' => false,
                'message' => 'Hund nicht gefunden',
                'has_other_owners' => false,
                'other_owners' => [],
            ];
        }

        // Aktuelle Eigentümer ermitteln (ohne Bis-Datum oder Bis-Datum in der Zukunft)
        $activeOwners = $hund->personen()
            ->whereHas('mitglied', function ($query) {
                // Nur aktive Mitglieder (kein Austrittsdatum oder Austrittsdatum in der Zukunft)
                $query->where(function ($subQuery) {
                    $subQuery->whereNull('datum_austritt')
                        ->orWhere('datum_austritt', '=', '0000-00-00')
                        ->orWhere('datum_austritt', '>', Carbon::now()->format('Y-m-d'));
                });
            })
            ->where(function ($query) {
                // Aktuelle Eigentümerschaft (kein Bis-Datum oder Bis-Datum in der Zukunft)
                $query->whereNull('hund_person.bis')
                    ->orWhere('hund_person.bis', '=', '0000-00-00')
                    ->orWhere('hund_person.bis', '>', Carbon::now()->format('Y-m-d'));
            })
            ->when($excludePersonId, function ($query) use ($excludePersonId) {
                // Angegebene Person ausschließen
                $query->where('personen.id', '!=', $excludePersonId);
            })
            ->with(['mitglied'])
            ->get();

        $hasOtherOwners = $activeOwners->count() > 0;

        // Detaillierte Informationen über andere Eigentümer
        $otherOwnersData = $activeOwners->map(function ($person) {
            return [
                'id' => $person->id,
                'name' => trim($person->vorname . ' ' . $person->nachname),
                'mitgliedsnummer' => $person->mitglied->mitglied_nr ?? null,
                'seit' => $person->pivot->seit ?? null,
                'bis' => $person->pivot->bis ?? null,
            ];
        });

        return [
            'success' => true,
            'has_other_owners' => $hasOtherOwners,
            'other_owners_count' => $activeOwners->count(),
            'other_owners' => $otherOwnersData->toArray(),
            'message' => $hasOtherOwners
                ? "Es gibt {$activeOwners->count()} andere DRC-Mitglieder mit Eigentumsrechten an diesem Hund."
                : 'Keine anderen aktiven DRC-Mitglieder mit Eigentumsrechten gefunden',
        ];
    }

    /**
     * Prüft, ob eine bestimmte Person aktuell Eigentümer eines Hundes ist
     *
     * @param  int  $hundId  - ID des Hundes
     * @param  int  $personId  - ID der Person
     */
    public function isCurrentOwner(int $hundId, int $personId): bool
    {
        $hund = Hund::find($hundId);

        if (! $hund) {
            return false;
        }

        return $hund->personen()
            ->where('personen.id', $personId)
            ->whereHas('mitglied', function ($query) {
                // Nur aktive Mitglieder
                $query->where(function ($subQuery) {
                    $subQuery->whereNull('datum_austritt')
                        ->orWhere('datum_austritt', '=', '0000-00-00')
                        ->orWhere('datum_austritt', '>', Carbon::now()->format('Y-m-d'));
                });
            })
            ->where(function ($query) {
                // Aktuelle Eigentümerschaft
                $query->whereNull('hund_person.bis')
                    ->orWhere('hund_person.bis', '=', '0000-00-00')
                    ->orWhere('hund_person.bis', '>', Carbon::now()->format('Y-m-d'));
            })
            ->exists();
    }

    /**
     * Gibt alle aktuellen aktiven DRC-Eigentümer eines Hundes zurück
     *
     * @param  int  $hundId  - ID des Hundes
     */
    public function getCurrentActiveOwners(int $hundId): array
    {
        $hund = Hund::find($hundId);

        if (! $hund) {
            return [
                'success' => false,
                'message' => 'Hund nicht gefunden',
                'owners' => [],
            ];
        }

        $owners = $hund->personen()
            ->whereHas('mitglied', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereNull('datum_austritt')
                        ->orWhere('datum_austritt', '=', '0000-00-00')
                        ->orWhere('datum_austritt', '>', Carbon::now()->format('Y-m-d'));
                });
            })
            ->where(function ($query) {
                $query->whereNull('hund_person.bis')
                    ->orWhere('hund_person.bis', '=', '0000-00-00')
                    ->orWhere('hund_person.bis', '>', Carbon::now()->format('Y-m-d'));
            })
            ->with(['mitglied'])
            ->get();

        $ownersData = $owners->map(function ($person) {
            return [
                'id' => $person->id,
                'name' => trim($person->vorname . ' ' . $person->nachname),
                'mitgliedsnummer' => $person->mitglied->mitglied_nr ?? null,
                'seit' => $person->pivot->seit ?? null,
                'bis' => $person->pivot->bis ?? null,
                'is_drc_mitglied' => true,
            ];
        });

        return [
            'success' => true,
            'owners_count' => $owners->count(),
            'owners' => $ownersData->toArray(),
        ];
    }

    /**
     * Gibt alle aktuellen Eigentümer eines Hundes mit vollständigen Kontaktdaten zurück
     * und prüft Mitgliedschaftsstatus sowie spezifische Person-Checks
     *
     * @param  int  $hundId  - ID des Hundes
     * @param  int|null  $checkPersonId  - Person-ID für spezielle Prüfungen (optional)
     * @return array - Vollständige Eigentümerinformationen mit Status-Checks
     */
    public function getAllOwnersWithDetails(int $hundId, ?int $checkPersonId = null): array
    {
        $hund = Hund::find($hundId);

        if (! $hund) {
            return [
                'success' => false,
                'message' => 'Hund nicht gefunden',
                'owners' => [],
                'owners_count' => 0,
                'has_owners' => false,
                'check_person_in_list' => false,
                'has_other_active_members' => false,
            ];
        }

        // ALLE aktuellen Eigentümer laden (mit und ohne Mitgliedschaft)
        $owners = $hund->personen()
            ->where(function ($query) {
                // Aktuelle Eigentümerschaft (kein Bis-Datum oder Bis-Datum in der Zukunft)
                $query->whereNull('hund_person.bis')
                    ->orWhere('hund_person.bis', '=', '0000-00-00')
                    ->orWhere('hund_person.bis', '>', Carbon::now()->format('Y-m-d'));
            })
            ->with([
                'mitglied' => function ($query) {
                    // Mitglied-Relation laden (kann null sein)
                    $query->select('id', 'mitglied_nr', 'datum_austritt');
                },
                'adressen' => function ($query) {
                    // Aktive/aktuelle Adresse laden
                    $query->where('aktiv', 1)
                        ->select('person_id', 'strasse', 'postleitzahl', 'ort', 'land');
                },
            ])
            ->get();

        $checkPersonInList = false;
        $hasOtherActiveMembers = false;

        // Eigentümer-Daten aufbereiten
        $ownersData = $owners->map(function ($person) use ($checkPersonId, &$checkPersonInList, &$hasOtherActiveMembers) {
            // Prüfen ob Person aktives DRC-Mitglied ist
            $isActiveMember = false;
            $mitgliedsnummer = null;

            if ($person->mitglied) {
                $mitgliedsnummer = $person->mitglied->mitglied_nr;
                $isActiveMember = (
                    $person->mitglied->datum_austritt == null ||
                    $person->mitglied->datum_austritt == '0000-00-00' ||
                    $person->mitglied->datum_austritt > Carbon::now()->format('Y-m-d')
                );
            } else {
            }

            // Hauptadresse ermitteln
            $hauptadresse = $person->adressen->first();

            // Person-Checks durchführen
            if ($checkPersonId && $person->id == $checkPersonId) {
                $checkPersonInList = true;
            }

            return [
                'id' => $person->id,
                'vorname' => $person->vorname ?? '',
                'nachname' => $person->nachname ?? '',
                'name' => trim(($person->vorname ?? '') . ' ' . ($person->nachname ?? '')),
                'strasse' => $hauptadresse ? trim($hauptadresse->strasse ?? '') : '',
                'ort' => $hauptadresse ? trim(($hauptadresse->postleitzahl ?? '') . ' ' . ($hauptadresse->ort ?? '')) : '',
                'telefon' => $hauptadresse->telefon ?? $person->telefon_1 ?? '',
                'email' => $hauptadresse->email ?? $person->email_1 ?? '',
                'mitgliedsnummer' => $mitgliedsnummer,
                'is_aktives_mitglied' => $isActiveMember,
                'eigentum_seit' => $person->pivot->seit ?? null,

            ];
        });

        // Zusätzliche Statistiken
        $activeMembersCount = $ownersData->where('is_aktives_mitglied', true)->count();
        $noMembershipCount = $ownersData->where('has_membership', false)->count();

        return [
            'personen' => $ownersData->toArray(),

            // Erweiterte Statistiken
            'statistik' => [
                'anzahl' => $owners->count(),
                'drc_mitglieder' => $activeMembersCount,
                'keine_mitgliedschaft' => $noMembershipCount,
                'eigener_hund' => $checkPersonInList,
            ],

            // Erweiterte Status-Messages
            // 'messages' => [
            //     'ownership_status' => $owners->count() > 0
            //         ? "Hund hat {$owners->count()} aktuelle(n) Eigentümer"
            //         : 'Hund hat keine aktuellen Eigentümer',
            //     'membership_status' => $activeMembersCount > 0
            //         ? "Davon sind {$activeMembersCount} aktive DRC-Mitglieder"
            //         : 'Keine aktiven DRC-Mitglieder unter den Eigentümern',
            //     'non_member_status' => $noMembershipCount > 0
            //         ? "Davon haben {$noMembershipCount} Person(en) keine DRC-Mitgliedschaft"
            //         : 'Alle Eigentümer haben eine DRC-Mitgliedschaft',
            //     'check_person_status' => $checkPersonId
            //         ? ($checkPersonInList
            //             ? 'Angegebene Person ist in der Eigentümerliste'
            //             : 'Angegebene Person ist NICHT in der Eigentümerliste')
            //         : null,
            // ],
        ];
    }
}
