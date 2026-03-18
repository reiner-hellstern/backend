<?php
/**
 * Laravel Skript zum Aktualisieren der veranstalter_id und ausrichter_id
 * in der veranstaltungen Tabelle mit ordentlichem gruppenable-Mapping
 *
 * Verwendung: php update_veranstaltungen_gruppen_v2.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Gruppe;
use App\Models\Veranstaltung;
use Illuminate\Support\Facades\DB;

// Laravel App Bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "✓ Laravel Bootstrap erfolgreich\n";

// Erstelle Mapping-Caches für bessere Performance
echo "🔄 Erstelle Gruppen-Mappings...\n";

// Hole Bund Gruppe ID
$bundGruppe = Gruppe::where('gruppenable_type', 'App\\Models\\Bund')->first();
if (! $bundGruppe) {
    exit("❌ Keine Bund-Gruppe gefunden!\n");
}
$bundGruppeId = $bundGruppe->id;
echo "✓ Bund Gruppe ID: $bundGruppeId\n";

// Erstelle Landesgruppen-Mapping: landesgruppe_id => gruppen_id
$landesGruppenMapping = [];
$landesGruppen = Gruppe::where('gruppenable_type', 'App\\Models\\Landesgruppe')->get();
foreach ($landesGruppen as $gruppe) {
    $landesGruppenMapping[$gruppe->gruppenable_id] = $gruppe->id;
}
echo '✓ Landesgruppen-Mapping: ' . count($landesGruppenMapping) . " Einträge\n";

// Erstelle Bezirksgruppen-Mapping: bezirksgruppe_id => gruppen_id
$bezirksGruppenMapping = [];
$bezirksGruppen = Gruppe::where('gruppenable_type', 'App\\Models\\Bezirksgruppe')->get();
foreach ($bezirksGruppen as $gruppe) {
    $bezirksGruppenMapping[$gruppe->gruppenable_id] = $gruppe->id;
}
echo '✓ Bezirksgruppen-Mapping: ' . count($bezirksGruppenMapping) . " Einträge\n";

// Debug: Zeige ein paar Mapping-Beispiele
echo "🔍 Debug - Beispiel Mappings:\n";
echo '   Landesgruppen: ' . json_encode(array_slice($landesGruppenMapping, 0, 5, true)) . "\n";
echo '   Bezirksgruppen: ' . json_encode(array_slice($bezirksGruppenMapping, 0, 5, true)) . "\n";

// Backup erstellen
$backupTable = 'veranstaltungen_backup_' . date('Ymd_His');
DB::statement("CREATE TABLE $backupTable AS SELECT * FROM veranstaltungen");
echo "✓ Backup erstellt: $backupTable\n";

// Alle Veranstaltungen laden
$veranstaltungen = Veranstaltung::all();

$total = $veranstaltungen->count();
$updated = 0;

echo "📊 Verarbeite $total Veranstaltungen...\n";

foreach ($veranstaltungen as $index => $veranstaltung) {
    $changes = [];

    // Bestimme Veranstalter Gruppe
    $veranstalterGruppeId = bestimmeGruppeId(
        $veranstaltung->veranstalter_bund,
        $veranstaltung->veranstalter_landesgruppe_id,
        $veranstaltung->veranstalter_bezirksgruppe_id,
        $bundGruppeId,
        $landesGruppenMapping,
        $bezirksGruppenMapping
    );

    // Bestimme Ausrichter Gruppe
    $ausrichterGruppeId = bestimmeGruppeId(
        $veranstaltung->ausrichter_bund,
        $veranstaltung->ausrichter_landesgruppe_id,
        $veranstaltung->ausrichter_bezirksgruppe_id,
        $bundGruppeId,
        $landesGruppenMapping,
        $bezirksGruppenMapping
    );

    // Prüfe ob Updates nötig sind
    $needsUpdate = false;
    $updates = [];

    if ($veranstalterGruppeId && $veranstaltung->veranstalter_id != $veranstalterGruppeId) {
        $updates['veranstalter_id'] = $veranstalterGruppeId;
        $changes[] = "veranstalter_id: {$veranstaltung->veranstalter_id} → $veranstalterGruppeId";
        $needsUpdate = true;
    }

    if ($ausrichterGruppeId && $veranstaltung->ausrichter_id != $ausrichterGruppeId) {
        $updates['ausrichter_id'] = $ausrichterGruppeId;
        $changes[] = "ausrichter_id: {$veranstaltung->ausrichter_id} → $ausrichterGruppeId";
        $needsUpdate = true;
    }

    if ($needsUpdate) {
        // Direkte Zuweisung um Mass Assignment zu umgehen
        if (isset($updates['veranstalter_id'])) {
            $veranstaltung->veranstalter_id = $updates['veranstalter_id'];
        }
        if (isset($updates['ausrichter_id'])) {
            $veranstaltung->ausrichter_id = $updates['ausrichter_id'];
        }
        $veranstaltung->save();
        $updated++;

        echo "🔄 ID {$veranstaltung->id}: " . implode(', ', $changes) . "\n";
    }

    // Progress anzeigen
    if (($index + 1) % 100 == 0) {
        $progress = round((($index + 1) / $total) * 100, 1);
        echo "📈 Progress: $progress% (" . ($index + 1) . "/$total)\n";
    }
}

echo "\n✅ Verarbeitung abgeschlossen:\n";
echo "   - Gesamt: $total\n";
echo "   - Aktualisiert: $updated\n";
echo "   - Backup: $backupTable\n";

// Statistiken anzeigen
echo "\n📊 Aktuelle Statistiken:\n";
showStatistics();

function bestimmeGruppeId($isBund, $landesgruppenId, $bezirksgruppenId, $bundGruppeId, $landesGruppenMapping, $bezirksGruppenMapping)
{
    // Wenn Bund true ist, dann Bund Gruppe
    if ($isBund == 1) {
        return $bundGruppeId;
    }

    // Wenn Bezirksgruppen-ID vorhanden, dann Bezirksgruppe (hat Priorität vor Landesgruppe)
    if ($bezirksgruppenId && $bezirksgruppenId > 0) {
        return $bezirksGruppenMapping[$bezirksgruppenId] ?? null;
    }

    // Wenn Landesgruppen-ID vorhanden, dann Landesgruppe
    if ($landesgruppenId && $landesgruppenId > 0) {
        return $landesGruppenMapping[$landesgruppenId] ?? null;
    }

    return null;
}

function showStatistics()
{
    // Gesamt-Übersicht
    $stats = DB::table('veranstaltungen')
        ->selectRaw('
            COUNT(*) as total_veranstaltungen,
            COUNT(veranstalter_id) as veranstalter_gesetzt,
            COUNT(ausrichter_id) as ausrichter_gesetzt
        ')
        ->first();

    echo "   - Gesamt Veranstaltungen: {$stats->total_veranstaltungen}\n";
    echo "   - Veranstalter gesetzt: {$stats->veranstalter_gesetzt}\n";
    echo "   - Ausrichter gesetzt: {$stats->ausrichter_gesetzt}\n\n";

    // Aufschlüsselung nach Gruppentypen
    $typen = DB::table('veranstaltungen')
        ->join('gruppen', 'veranstaltungen.veranstalter_id', '=', 'gruppen.id')
        ->select('gruppen.gruppenable_type', DB::raw('COUNT(*) as anzahl'))
        ->groupBy('gruppen.gruppenable_type')
        ->get();

    echo "📋 Veranstalter nach Typ:\n";
    foreach ($typen as $typ) {
        $type = str_replace('App\\Models\\', '', $typ->gruppenable_type);
        echo "   - $type: {$typ->anzahl}\n";
    }

    // Problematische Einträge anzeigen
    $problematic = DB::table('veranstaltungen')
        ->whereNull('veranstalter_id')
        ->orWhereNull('ausrichter_id')
        ->count();

    if ($problematic > 0) {
        echo "\n⚠️  $problematic Veranstaltungen ohne vollständige Zuordnung\n";
    }
}

echo "\n🏁 Skript beendet.\n";
