<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait ExecuteSqlFile
/**
 * Führt eine SQL-Datei aus demselben Verzeichnis aus
 */
{
    public function executeSqlFile(string $filename): void
    {
        $sqlFile = base_path('database/migrations/sqlfiles/' . $filename);

        if (! file_exists($sqlFile)) {
            throw new \Exception("SQL file not found: {$sqlFile}");
        }

        $sql = file_get_contents($sqlFile);

        if ($sql === false) {
            throw new \Exception("Could not read SQL file: {$sqlFile}");
        }

        // Entferne SQL-Kommentare und leere Zeilen
        $sql = preg_replace('/--.*$/m', '', $sql); // Einzeilige Kommentare
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Mehrzeilige Kommentare

        // Teile Statements auf (getrennt durch Semikolon)
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            function ($statement) {
                return ! empty($statement);
            }
        );

        // Führe jedes Statement einzeln aus
        foreach ($statements as $statement) {
            try {
                DB::statement($statement);
            } catch (\Exception $e) {
                throw new \Exception("Error executing SQL statement: {$statement}. Error: " . $e->getMessage());
            }
        }
    }
}
