<?php

namespace App\Console\Commands;

use App\Models\Veranstaltung;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateVeranstaltungenGruppenIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'veranstaltungen:update-gruppen-ids 
                           {--dry-run : Nur anzeigen was passieren würde, ohne Änderungen}
                           {--limit= : Anzahl der zu verarbeitenden Datensätze begrenzen}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aktualisiert veranstalter_id und ausrichter_id in der veranstaltungen Tabelle basierend auf den Bund/Landesgruppen/Bezirksgruppen Feldern';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $limit = $this->option('limit');

        $this->info('Starte Update der Veranstaltungen Gruppen-IDs...');
        $this->info($isDryRun ? 'DRY RUN - Keine Änderungen werden gespeichert' : 'LIVE RUN - Änderungen werden gespeichert');

        // Hole Bund Gruppe (angenommen ID 1 für Bund)
        $bundGruppeId = $this->getBundGruppeId();

        if (! $bundGruppeId) {
            $this->error('Bund Gruppe nicht gefunden. Bitte stellen Sie sicher, dass eine Bund-Gruppe existiert.');

            return 1;
        }

        $this->info("Bund Gruppe ID: {$bundGruppeId}");

        // Query für Veranstaltungen
        $query = Veranstaltung::query();

        if ($limit) {
            $query->limit((int) $limit);
        }

        $veranstaltungen = $query->get();
        $totalCount = $veranstaltungen->count();

        $this->info("Verarbeite {$totalCount} Veranstaltungen...");

        $updated = 0;
        $errors = 0;

        $progressBar = $this->output->createProgressBar($totalCount);

        foreach ($veranstaltungen as $veranstaltung) {
            try {
                $updates = [];

                // Bestimme Veranstalter Gruppe
                $veranstalterGruppeId = $this->bestimmeGruppeId(
                    $veranstaltung->veranstalter_bund,
                    $veranstaltung->veranstalter_landesgruppen_id,
                    $veranstaltung->veranstalter_bezirksgruppen_id,
                    $bundGruppeId
                );

                // Bestimme Ausrichter Gruppe
                $ausrichterGruppeId = $this->bestimmeGruppeId(
                    $veranstaltung->ausrichter_bund,
                    $veranstaltung->ausrichter_landesgruppen_id,
                    $veranstaltung->ausrichter_bezirksgruppen_id,
                    $bundGruppeId
                );

                // Prüfe ob Updates nötig sind
                if ($veranstalterGruppeId && $veranstaltung->veranstalter_id !== $veranstalterGruppeId) {
                    $updates['veranstalter_id'] = $veranstalterGruppeId;
                }

                if ($ausrichterGruppeId && $veranstaltung->ausrichter_id !== $ausrichterGruppeId) {
                    $updates['ausrichter_id'] = $ausrichterGruppeId;
                }

                // Führe Updates durch
                if (! empty($updates)) {
                    if ($isDryRun) {
                        $this->line("\nVeranstaltung ID {$veranstaltung->id} würde aktualisiert:");
                        foreach ($updates as $field => $value) {
                            $oldValue = $veranstaltung->$field ?? 'null';
                            $this->line("  {$field}: {$oldValue} -> {$value}");
                        }
                    } else {
                        $veranstaltung->update($updates);
                    }
                    $updated++;
                }

            } catch (\Exception $e) {
                $this->error("Fehler bei Veranstaltung ID {$veranstaltung->id}: " . $e->getMessage());
                $errors++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('Verarbeitung abgeschlossen:');
        $this->info("- Gesamt verarbeitet: {$totalCount}");
        $this->info("- Aktualisiert: {$updated}");
        $this->info("- Fehler: {$errors}");

        if ($isDryRun && $updated > 0) {
            $this->info('Führen Sie den Befehl ohne --dry-run aus, um die Änderungen zu speichern.');
        }

        return 0;
    }

    /**
     * Bestimmt die Gruppen-ID basierend auf der Logik
     */
    private function bestimmeGruppeId($isBund, $landesgruppenId, $bezirksgruppenId, $bundGruppeId)
    {
        // Wenn Bund true ist, dann Bund Gruppe
        if ($isBund) {
            return $bundGruppeId;
        }

        // Wenn Bezirksgruppen-ID vorhanden, dann Bezirksgruppe
        if ($bezirksgruppenId) {
            // Prüfe ob Bezirksgruppe existiert
            if ($this->gruppeExists('App\Models\Bezirksgruppe', $bezirksgruppenId)) {
                return $this->getGruppeIdByMorphable('App\Models\Bezirksgruppe', $bezirksgruppenId);
            }
        }

        // Wenn Landesgruppen-ID vorhanden, dann Landesgruppe
        if ($landesgruppenId) {
            // Prüfe ob Landesgruppe existiert
            if ($this->gruppeExists('App\Models\Landesgruppe', $landesgruppenId)) {
                return $this->getGruppeIdByMorphable('App\Models\Landesgruppe', $landesgruppenId);
            }
        }

        return null;
    }

    /**
     * Holt die Bund Gruppen-ID
     */
    private function getBundGruppeId()
    {
        // Annahme: Bund hat einen speziellen Eintrag oder ist durch gruppenable_type identifizierbar
        return DB::table('gruppen')
            ->where('gruppenable_type', 'App\Models\Bund')
            ->orWhere('name', 'like', '%Bund%')
            ->orWhere('kurzbez', 'DRC')
            ->first()?->id;
    }

    /**
     * Prüft ob eine Gruppe mit dem gegebenen Typ und der ID existiert
     */
    private function gruppeExists($type, $id)
    {
        return DB::table(strtolower(class_basename($type)) . 's')
            ->where('id', $id)
            ->exists();
    }

    /**
     * Holt die Gruppen-ID basierend auf morphable Typ und ID
     */
    private function getGruppeIdByMorphable($type, $morphableId)
    {
        return DB::table('gruppen')
            ->where('gruppenable_type', $type)
            ->where('gruppenable_id', $morphableId)
            ->first()?->id;
    }
}
