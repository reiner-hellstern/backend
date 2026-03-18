<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateMembersToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migriert aktive Mitglieder in die Users-Tabelle';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starte Migration der aktiven Mitglieder...');

        // Passwort vom User mit ID 24 holen
        $templateUser = User::find(24);
        if (! $templateUser) {
            $this->error('Fehler: User mit ID 24 nicht gefunden!');

            return 1;
        }

        $defaultPassword = $templateUser->password;
        $this->info('Template Passwort geholt: ' . substr($defaultPassword, 0, 20) . '...');

        // Alle aktiven Mitglieder finden (mit mitgliedsart und ohne aktuelles Austrittsdatum, mit E-Mail)
        $activeMembers = DB::table('personen')
            ->whereNotNull('mitgliedsart')
            ->where(function ($query) {
                $query->whereNull('austrittsdatum')
                    ->orWhere('austrittsdatum', '0000-00-00 00:00:00')
                    ->orWhere('austrittsdatum', '>', now());
            })
            ->whereNotNull('email_1')
            ->where('email_1', '!=', '')
            ->get();

        $this->info('Gefunden: ' . count($activeMembers) . ' aktive Mitglieder mit E-Mail');

        $created = 0;
        $skipped = 0;
        $errors = 0;

        $progressBar = $this->output->createProgressBar(count($activeMembers));
        $progressBar->start();

        foreach ($activeMembers as $person) {
            try {
                // Prüfen ob User bereits existiert
                $existingUser = User::where('person_id', $person->id)
                    ->orWhere('email', $person->email_1)
                    ->first();

                if ($existingUser) {
                    $skipped++;
                    $progressBar->advance();
                    continue;
                }

                // Name zusammensetzen
                $name = trim(($person->vorname ?? '') . ' ' . ($person->nachname ?? ''));
                if (empty($name)) {
                    $name = 'Mitglied ' . $person->id;
                }

                // User erstellen
                $user = User::create([
                    'person_id' => $person->id,
                    'name' => $name,
                    'email' => $person->email_1,
                    'password' => $defaultPassword,
                    'aktiv' => 0, // inaktiv
                ]);

                // Rolle "Mitglied" (ID 4) zuweisen
                $user->assign('mg'); // Mitglied Role

                // Prüfen ob Züchter (hat Zwingernummer)
                if (! empty($person->zwingernummer) && $person->zwingernummer !== '0') {
                    $user->assign('zuechter'); // Züchter Role
                }

                $created++;

            } catch (\Exception $e) {
                $this->error("Fehler bei Person ID {$person->id}: " . $e->getMessage());
                $errors++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info('=== Zusammenfassung ===');
        $this->info("Erstellt: {$created} User");
        $this->info("Übersprungen: {$skipped} User");
        $this->info("Fehler: {$errors} User");
        $this->info('Gesamt verarbeitet: ' . ($created + $skipped + $errors) . ' Personen');

        return 0;
    }
}
