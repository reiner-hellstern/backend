<?php

namespace App\Traits;

use App\Models\Person;
use App\Models\Personenadresse;

trait SavePerson
{
    /**
     * Save or find existing person based on provided data
     * Returns array with person_id and was_created flag
     */
    public function savePerson(array $person): array
    {
        // FALL 1: PERSON-ID UND ADRESS-ID VORHANDEN => Person existiert bereits, nothing to do
        if (isset($person['id']) && $person['id'] > 0 && isset($person['personenadresse_id']) && $person['personenadresse_id'] > 0) {
            return ['person_id' => $person['id'], 'was_created' => false];
        }

        // SUCHE PERSON IN DB
        $db_person = Person::join('personenadressen', 'personen.id', '=', 'personenadressen.person_id')
            ->where('personen.nachname', $person['nachname'])
            ->where('personen.vorname', $person['vorname'])
            ->where('personenadressen.strasse', $person['strasse'])
            ->where('personenadressen.postleitzahl', $person['postleitzahl'])
            ->where('personenadressen.ort', $person['ort'])
            ->select('personen.*')
            ->first();

        // PERSON WURDE GEFUNDEN => RETURN ID
        if ($db_person != null) {
            return ['person_id' => $db_person->id, 'was_created' => false];
        }

        // FALL 2: PERSON-ID VORHANDEN, ABER KEINE ADRESS-ID VORHANDEN
        // Person existiert, aber neue Adresse hinzufügen
        if (isset($person['id']) && $person['id'] > 0) {
            $personenadresse = new Personenadresse();
            $personenadresse->person_id = $person['id'];
            $personenadresse->strasse = $person['strasse'];
            $personenadresse->postleitzahl = $person['postleitzahl'];
            $personenadresse->ort = $person['ort'];
            $personenadresse->adresszusatz = $person['adresszusatz'] ?? '';
            $personenadresse->land = $person['land'] ?? 'Deutschland';
            $personenadresse->aktiv = 1;

            if (! $personenadresse->save()) {
                throw new \Exception('Personenadresse konnte nicht gespeichert werden');
            }

            return ['person_id' => $person['id'], 'was_created' => false];
        }

        // FALL 3: PERSON-ID NICHT VORHANDEN, KEINE ADRESS-ID VORHANDEN
        // Person neu anlegen
        $new_person = new Person();
        $new_person->nachname = $person['nachname'];
        $new_person->vorname = $person['vorname'];
        $new_person->anrede_id = $person['anrede_id'] ?? null;
        $new_person->adelstitel = $person['adelstitel'] ?? '';
        $new_person->akademischetitel = $person['akademischetitel'] ?? '';
        $new_person->strasse = $person['strasse'];
        $new_person->postleitzahl = $person['postleitzahl'];
        $new_person->ort = $person['ort'];
        $new_person->adresszusatz = $person['adresszusatz'] ?? '';
        $new_person->land = $person['land'] ?? 'Deutschland';
        $new_person->mitgliedsnummer = $person['mitgliedsnummer'] ?? '';
        $new_person->telefon_1 = $person['telefon_1'] ?? '';
        $new_person->telefon_2 = $person['telefon_2'] ?? '';
        $new_person->email_1 = $person['email_1'] ?? '';
        $new_person->email_2 = $person['email_2'] ?? '';
        $new_person->website_1 = $person['website_1'] ?? '';
        $new_person->website_2 = $person['website_2'] ?? '';

        if (! $new_person->save()) {
            throw new \Exception('Person konnte nicht gespeichert werden');
        }

        // Person-Adresse anlegen
        $personenadresse = new Personenadresse();
        $personenadresse->person_id = $new_person->id;
        $personenadresse->strasse = $new_person->strasse;
        $personenadresse->postleitzahl = $new_person->postleitzahl;
        $personenadresse->ort = $new_person->ort;
        $personenadresse->adresszusatz = $new_person->adresszusatz;
        $personenadresse->land = $new_person->land;
        $personenadresse->aktiv = 1;

        if (! $personenadresse->save()) {
            throw new \Exception('Personenadresse konnte nicht gespeichert werden');
        }

        return ['person_id' => $new_person->id, 'was_created' => true];
    }
}
