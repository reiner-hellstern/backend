<?php

require __DIR__ . '/vendor/autoload.php';
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Hole alle Adressen
$adressen = DB::connection('mysql_web')->table('Adressen')->get();

// Hole die Spaltennamen der Zieltabelle
$zielFelder = DB::connection('mysql_web')->getSchemaBuilder()->getColumnListing('Adressen_eine_funktion');

// lösche alle Einträge in der Zieltabelle
DB::connection('mysql_web')->table('Adressen_eine_funktion')->truncate();

foreach ($adressen as $adresse) {
    // Funktion_1
    if (! empty($adresse->Funktion_1)) {
        // Funktionsname holen
        $funktionsname = DB::connection('mysql_web')
            ->table('Funktionen')
            ->where('FunKey', $adresse->Funktion_1)
            ->value('Funktion');

        $insert = [];
        foreach ($zielFelder as $feld) {
            if ($feld === 'Funktion') {
                $insert[$feld] = $adresse->Funktion_1;
            } elseif ($feld === 'Funktionsname') {
                $insert[$feld] = $funktionsname;
            } elseif (property_exists($adresse, $feld . '_1')) {
                $insert[$feld] = $adresse->{$feld . '_1'};
            } elseif (property_exists($adresse, $feld)) {
                $insert[$feld] = $adresse->{$feld};
            }
        }
        DB::connection('mysql_web')->table('Adressen_eine_funktion')->insert($insert);
    }
    // Funktion_2
    if (! empty($adresse->Funktion_2)) {
        $funktionsname = DB::connection('mysql_web')
            ->table('Funktionen')
            ->where('FunKey', $adresse->Funktion_2)
            ->value('Funktion');

        $insert = [];
        foreach ($zielFelder as $feld) {
            if ($feld === 'Funktion') {
                $insert[$feld] = $adresse->Funktion_2;
            } elseif ($feld === 'Funktionsname') {
                $insert[$feld] = $funktionsname;
            } elseif (property_exists($adresse, $feld . '_2')) {
                $insert[$feld] = $adresse->{$feld . '_2'};
            } elseif (property_exists($adresse, $feld)) {
                $insert[$feld] = $adresse->{$feld};
            }
        }
        DB::connection('mysql_web')->table('Adressen_eine_funktion')->insert($insert);
    }
}

echo "Übertragung abgeschlossen.\n";
