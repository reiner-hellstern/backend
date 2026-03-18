<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Laravel App Bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Passwort vom User mit ID 24 holen
$templateUser = DB::table('users')->where('id', 24)->first();
if (! $templateUser) {
    echo "Fehler: User mit ID 24 nicht gefunden!\n";
    exit(1);
}

$defaultPassword = $templateUser->password;
echo 'Template Passwort geholt: ' . substr($defaultPassword, 0, 20) . "...\n";

// Alle aktiven Mitglieder finden (ohne Austrittsdatum und mit E-Mail)
$activeMembers = DB::table('personen')
    ->whereNull('austrittsdatum')
    ->whereNotNull('email_1')
    ->where('email_1', '!=', '')
    ->get();

echo 'Gefunden: ' . count($activeMembers) . " aktive Mitglieder mit E-Mail\n";

$created = 0;
$skipped = 0;
$errors = 0;

foreach ($activeMembers as $person) {
    try {
        // Prüfen ob User bereits existiert
        $existingUser = DB::table('users')
            ->where('person_id', $person->id)
            ->orWhere('email', $person->email_1)
            ->first();

        if ($existingUser) {
            echo "Übersprungen: Person ID {$person->id} - User existiert bereits\n";
            $skipped++;
            continue;
        }

        // Name zusammensetzen
        $name = trim(($person->vorname ?? '') . ' ' . ($person->nachname ?? ''));
        if (empty($name)) {
            $name = 'Mitglied ' . $person->id;
        }

        // User erstellen
        $userId = DB::table('users')->insertGetId([
            'person_id' => $person->id,
            'name' => $name,
            'email' => $person->email_1,
            'password' => $defaultPassword,
            'aktiv' => 0, // inaktiv
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "User erstellt: ID {$userId} für Person {$person->id} ({$name})\n";

        // Rolle "Mitglied" (ID 4) zuweisen
        DB::table('assigned_roles')->insert([
            'role_id' => 4, // Mitglied
            'entity_id' => $userId,
            'entity_type' => 'App\\Models\\User',
            'scope' => 1,
        ]);

        // Prüfen ob Züchter (hat Zwingernummer)
        if (! empty($person->zwingernummer)) {
            DB::table('assigned_roles')->insert([
                'role_id' => 5, // Züchter
                'entity_id' => $userId,
                'entity_type' => 'App\\Models\\User',
                'scope' => 1,
            ]);
            echo "  -> Züchter-Rolle zugewiesen (Zwingernummer: {$person->zwingernummer})\n";
        }

        $created++;

    } catch (Exception $e) {
        echo "Fehler bei Person ID {$person->id}: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "\n=== Zusammenfassung ===\n";
echo "Erstellt: {$created} User\n";
echo "Übersprungen: {$skipped} User\n";
echo "Fehler: {$errors} User\n";
echo 'Gesamt verarbeitet: ' . ($created + $skipped + $errors) . " Personen\n";
