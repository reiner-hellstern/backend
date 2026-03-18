## Laravel Trait: CheckActiveOwnership

Dieses Trait implementiert eine umfassende Prüfung für aktive Eigentümerschaft von Hunden in der DRC-Datenverwaltung. Es prüft, ob andere aktive Mitglieder außer einer vorgegebenen Person-ID aktuelle Eigentümer eines Hundes sind.

## Features des Traits:

### 1. **`hasOtherActiveOwners(int $hundId, ?int $excludePersonId = null)`**
- **Hauptfunktion** zur Prüfung anderer aktiver Eigentümer
- Schließt eine bestimmte Person-ID aus der Prüfung aus
- Berücksichtigt nur aktive Mitglieder und aktuelle Eigentümerschaften
- Gibt detaillierte Informationen über andere Eigentümer zurück

### 2. **`isCurrentOwner(int $hundId, int $personId)`**
- Prüft ob eine bestimmte Person aktueller aktiver Eigentümer ist
- Berücksichtigt Mitgliedschaftsstatus und Eigentümerschaftsdauer
- Gibt boolean-Wert zurück

### 3. **`getCurrentActiveOwners(int $hundId)`**
- Holt alle aktuellen aktiven Eigentümer eines Hundes
- Liefert vollständige Eigentümerinformationen
- Inklusive Mitgliedsnummern und Zeiträume

## Verwendung des Traits:

````php
// In einem Controller
class HundController extends Controller
{
    use CheckActiveOwnership;

    /**
     * Prüfung vor Hundeabgabe
     */
    public function checkBeforeTransfer(Request $request)
    {
        $hundId = $request->input('hund_id');
        $currentPersonId = $request->input('current_person_id');

        // Prüfen ob andere aktive Mitglieder Eigentümer sind
        $result = $this->hasOtherActiveOwners($hundId, $currentPersonId);

        if (!$result['success']) {
            return response()->json(['error' => $result['message']], 404);
        }

        if ($result['has_other_owners']) {
            return response()->json([
                'warning' => true,
                'message' => 'Achtung: Dieser Hund hat noch andere aktive Eigentümer!',
                'details' => $result['message'],
                'other_owners' => $result['other_owners']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Keine anderen aktiven Eigentümer vorhanden - Transfer möglich'
        ]);
    }

    /**
     * Eigentümerschaftsvalidierung
     */
    public function validateOwnership(Request $request)
    {
        $hundId = $request->input('hund_id');
        $personId = $request->input('person_id');

        // Prüfen ob Person aktueller Eigentümer ist
        if (!$this->isCurrentOwner($hundId, $personId)) {
            return response()->json([
                'error' => 'Person ist nicht aktueller aktiver Eigentümer dieses Hundes'
            ], 403);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Alle Eigentümer anzeigen
     */
    public function showOwners(int $hundId)
    {
        $ownersResult = $this->getCurrentActiveOwners($hundId);

        if (!$ownersResult['success']) {
            return response()->json(['error' => $ownersResult['message']], 404);
        }

        return response()->json([
            'owners' => $ownersResult['owners'],
            'count' => $ownersResult['owners_count']
        ]);
    }

    /**
     * Hundeabgabe mit Validierung
     */
    public function transferOwnership(Request $request)
    {
        $hundId = $request->input('hund_id');
        $abgeberPersonId = $request->input('abgeber_person_id');
        $empfaengerPersonId = $request->input('empfaenger_person_id');

        // 1. Prüfen ob Abgeber aktueller Eigentümer ist
        if (!$this->isCurrentOwner($hundId, $abgeberPersonId)) {
            return response()->json([
                'error' => 'Abgeber ist nicht aktueller Eigentümer'
            ], 403);
        }

        // 2. Prüfen ob andere aktive Eigentümer existieren
        $otherOwners = $this->hasOtherActiveOwners($hundId, $abgeberPersonId);
        
        if ($otherOwners['has_other_owners']) {
            return response()->json([
                'error' => 'Transfer nicht möglich - andere aktive Eigentümer vorhanden',
                'other_owners' => $otherOwners['other_owners']
            ], 422);
        }

        // 3. Transfer durchführen...
        // Eigentümerschaft beenden und neue anlegen
        
        return response()->json(['success' => true]);
    }
}
````

## In Service-Klassen:

````php
class HundOwnershipService
{
    use CheckActiveOwnership;

    public function canTransferOwnership(int $hundId, int $personId): bool
    {
        // Ist Person aktueller Eigentümer?
        if (!$this->isCurrentOwner($hundId, $personId)) {
            return false;
        }

        // Gibt es andere aktive Eigentümer?
        $result = $this->hasOtherActiveOwners($hundId, $personId);
        
        return !$result['has_other_owners'];
    }

    public function getOwnershipSummary(int $hundId): array
    {
        $owners = $this->getCurrentActiveOwners($hundId);
        
        return [
            'total_owners' => $owners['owners_count'],
            'can_single_transfer' => $owners['owners_count'] === 1,
            'owners_details' => $owners['owners']
        ];
    }
}
````

## Rückgabe-Struktur:

### `hasOtherActiveOwners()`:
```php
[
    'success' => true/false,
    'has_other_owners' => true/false,
    'other_owners_count' => int,
    'other_owners' => [
        [
            'id' => 123,
            'name' => 'Max Mustermann',
            'mitgliedsnummer' => 'M123456',
            'seit' => '01.01.2020',
            'bis' => null
        ]
    ],
    'message' => 'Beschreibung des Ergebnisses'
]
```

### `getCurrentActiveOwners()`:
```php
[
    'success' => true/false,
    'owners_count' => int,
    'owners' => [
        [
            'id' => 123,
            'name' => 'Max Mustermann',
            'mitgliedsnummer' => 'M123456',
            'seit' => '01.01.2020',
            'bis' => null,
            'is_active_member' => true
        ]
    ]
]
```

## Das Trait berücksichtigt:

1. **Aktive Mitgliedschaft**: Nur Personen mit gültiger DRC-Mitgliedschaft
2. **Aktuelle Eigentümerschaft**: Ohne Enddatum oder Enddatum in der Zukunft
3. **Personenausschluss**: Flexibler Ausschluss einer Person-ID
4. **Vollständige Fehlerbehandlung**: Aussagekräftige Rückgabewerte
5. **Performance**: Optimierte Datenbankabfragen mit Eager Loading

Das Trait ist ideal für alle Anwendungsfälle rund um Hundebesitz, Eigentumsübertragungen und Berechtigungsprüfungen in der DRC-Datenverwaltung.



Hier sind konkrete Beispiele, wie das **CheckActiveOwnership** Trait im PersonController verwendet werden kann:

## 1. Grundlegende Integration

Das Trait ist bereits korrekt eingebunden:

````php
class PersonController extends Controller
{
    use CheckActiveOwnership;
    use GetPrerenderedHund;
    use PrerenderHund;
    // ...
}
````

## 2. Praktische Verwendungsbeispiele

### A) Hundeübertragung mit Eigentumsvalidierung

````php
/**
 * Prüft Eigentümerschaften vor Hundeübertragung
 */
public function checkHundeabgabe(Request $request)
{
    $hundId = $request->input('hund_id');
    $abgeberPersonId = $request->input('abgeber_person_id');

    // 1. Prüfen ob Abgeber aktueller Eigentümer ist
    if (!$this->isCurrentOwner($hundId, $abgeberPersonId)) {
        return response()->json([
            'error' => 'Die angegebene Person ist nicht aktueller Eigentümer dieses Hundes',
            'code' => 'NOT_OWNER'
        ], 403);
    }

    // 2. Prüfen ob andere aktive Eigentümer existieren
    $otherOwners = $this->hasOtherActiveOwners($hundId, $abgeberPersonId);
    
    if (!$otherOwners['success']) {
        return response()->json(['error' => $otherOwners['message']], 404);
    }

    if ($otherOwners['has_other_owners']) {
        return response()->json([
            'warning' => true,
            'message' => 'Achtung: Dieser Hund hat noch andere aktive Eigentümer!',
            'details' => $otherOwners['message'],
            'other_owners' => $otherOwners['other_owners'],
            'can_transfer' => false
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Hundeabgabe möglich - keine anderen aktiven Eigentümer',
        'can_transfer' => true
    ]);
}
````

### B) Erweiterte Personenakte mit Eigentumsinfo

````php
/**
 * Erweitert die bestehende personenakte() Methode
 */
public function personenakte(Person $person)
{
    // Bestehender Code...
    $person->load([
        'adressen', 'user', 'mitglied', 'images', 'bankverbindungen',
        'zuchtverbote', 'vereinsstrafen', 'mitglied.bankverbindungen',
        'mitglied.landesgruppe', 'mitglied.bezirksgruppe', 'mitglied.mitgliedsart',
        'hunde', 'hunde.vater', 'hunde.mutter', 'hunde.chipnummern',
        'hunde.zuchtbuchnummern', 'hunde.dokumente', 'hunde.images',
        'hunde.eigentuemers', 'zwinger', 'zwinger.rassen', 'zwinger.personen',
        'zwinger.images', 'wuerfe', 'wurfplaene', 'funktionen', 'dokumente', 'listen',
    ]);

    // Eigentumsrechte für jeden Hund prüfen
    foreach ($person->hunde as $hund) {
        $ownershipInfo = $this->getCurrentActiveOwners($hund->id);
        $hund['ownership_info'] = [
            'is_sole_owner' => $ownershipInfo['owners_count'] === 1,
            'total_owners' => $ownershipInfo['owners_count'],
            'all_owners' => $ownershipInfo['owners'] ?? [],
            'can_transfer_alone' => $ownershipInfo['owners_count'] === 1
        ];

        // Prüfen ob Person aktueller Eigentümer ist
        $hund['is_current_owner'] = $this->isCurrentOwner($hund->id, $person->id);
    }

    // Bestehender Code...
    return $person;
}
````

### C) Neue Methode für Hundeberechtigungen

````php
/**
 * Überprüft Hundeberechtigungen für eine Person
 */
public function hundeBerechtigungen(Request $request)
{
    $personId = $request->input('person_id');
    $hundId = $request->input('hund_id', null);

    $person = Person::find($personId);
    if (!$person) {
        return response()->json(['error' => 'Person nicht gefunden'], 404);
    }

    // Alle Hunde oder nur ein spezifischer Hund
    $hunde = $hundId ? [$hundId] : $person->hunde->pluck('id')->toArray();

    $berechtigungen = [];

    foreach ($hunde as $hId) {
        $ownership = $this->getCurrentActiveOwners($hId);
        $isOwner = $this->isCurrentOwner($hId, $personId);
        $otherOwners = $this->hasOtherActiveOwners($hId, $personId);

        $berechtigungen[$hId] = [
            'hund_id' => $hId,
            'is_owner' => $isOwner,
            'total_owners' => $ownership['owners_count'],
            'has_other_owners' => $otherOwners['has_other_owners'],
            'other_owners' => $otherOwners['other_owners'] ?? [],
            'permissions' => [
                'can_edit' => $isOwner,
                'can_transfer' => $isOwner && !$otherOwners['has_other_owners'],
                'can_delete' => $isOwner && !$otherOwners['has_other_owners'],
                'needs_consent' => $otherOwners['has_other_owners']
            ]
        ];
    }

    return response()->json([
        'person_id' => $personId,
        'hunde_berechtigungen' => $berechtigungen
    ]);
}
````

### D) Integration in die bestehende person() Methode

````php
/**
 * Erweitert die bestehende person() Methode für eingeloggte User
 */
public function person()
{
    // Bestehender Code bis zu den Hunden...
    
    $orgatreeitems = OrgatreeItem::orderBy('order')->where('parent_id', 0)->pluck('open', 'title');

    foreach ($hunde2 as $hund) {
        $hund['orgatree'] = $orgatreeitems;
        $hund['profile_orga'] = false;
        $hund['profile_dokumente'] = false;
        
        // NEUE EIGENTUMSINFO HINZUFÜGEN
        $ownershipResult = $this->getCurrentActiveOwners($hund->id);
        $hund['ownership'] = [
            'is_sole_owner' => $ownershipResult['owners_count'] === 1,
            'total_active_owners' => $ownershipResult['owners_count'],
            'can_transfer_alone' => $ownershipResult['owners_count'] === 1,
            'other_owners' => $this->hasOtherActiveOwners($hund->id, $person->id)
        ];
        
        // Zugriffsrechte basierend auf Eigentümerschaft
        $hund['zugriffsrechte'] = $this->isCurrentOwner($hund->id, $person->id);
    }

    // Rest des bestehenden Codes...
    $person['hunde'] = HundeShortResource::collection($hunde2);
    
    return $person;
}
````

### E) API-Endpoint für Ownership-Checks

````php
/**
 * Dedicated API endpoint für Eigentumsvalidierung
 */
public function validateOwnership(Request $request)
{
    $hundId = $request->input('hund_id');
    $personId = $request->input('person_id');
    $action = $request->input('action', 'check'); // check, transfer, edit

    if (!$hundId || !$personId) {
        return response()->json(['error' => 'Hund-ID und Person-ID erforderlich'], 400);
    }

    $result = [
        'hund_id' => $hundId,
        'person_id' => $personId,
        'action' => $action
    ];

    // Basis-Ownership Check
    $isOwner = $this->isCurrentOwner($hundId, $personId);
    $result['is_current_owner'] = $isOwner;

    if (!$isOwner && $action !== 'check') {
        return response()->json(array_merge($result, [
            'error' => 'Person ist nicht aktueller Eigentümer',
            'allowed' => false
        ]), 403);
    }

    // Andere Eigentümer prüfen
    $otherOwners = $this->hasOtherActiveOwners($hundId, $personId);
    $result['other_owners'] = $otherOwners;

    // Action-spezifische Validierung
    switch ($action) {
        case 'transfer':
            $result['allowed'] = $isOwner && !$otherOwners['has_other_owners'];
            $result['message'] = $result['allowed'] 
                ? 'Transfer erlaubt' 
                : 'Transfer nicht möglich - andere Eigentümer vorhanden';
            break;
            
        case 'edit':
            $result['allowed'] = $isOwner;
            $result['message'] = $isOwner ? 'Bearbeitung erlaubt' : 'Keine Berechtigung';
            break;
            
        default:
            $allOwners = $this->getCurrentActiveOwners($hundId);
            $result['all_owners'] = $allOwners;
            $result['allowed'] = true;
            $result['message'] = 'Ownership-Status abgerufen';
    }

    return response()->json($result);
}
````

## 3. Frontend-Integration

Das Frontend kann diese Endpunkte so nutzen:

````javascript
// Vor Hundeabgabe prüfen
async checkBeforeTransfer(hundId, abgeberPersonId) {
    const response = await this.$http.post('/api/person/check-hundeabgabe', {
        hund_id: hundId,
        abgeber_person_id: abgeberPersonId
    });
    
    if (response.data.warning) {
        // Warnung anzeigen: andere Eigentümer vorhanden
        this.showWarning(response.data.message, response.data.other_owners);
        return false;
    }
    
    return response.data.can_transfer;
}

// Berechtigungen für UI-Elemente
async checkPermissions(hundId, personId) {
    const response = await this.$http.post('/api/person/validate-ownership', {
        hund_id: hundId,
        person_id: personId,
        action: 'check'
    });
    
    // UI-Buttons basierend auf Berechtigungen ein/ausblenden
    this.canEdit = response.data.is_current_owner;
    this.canTransfer = response.data.other_owners.has_other_owners === false;
}
````

Diese Integration ermöglicht es, die Eigentumsvalidierung nahtlos in bestehende Workflows zu integrieren und sowohl für API-Calls als auch für UI-Logik zu verwenden.