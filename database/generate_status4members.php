<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Mitglied;
use Carbon\Carbon;

// Laravel App Bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$heute = Carbon::today()->format('Y-m-d');

// Alle Mitglieder durchgehen und Status setzen
Mitglied::query()->each(function ($mitglied) use ($heute) {
    if (
        empty($mitglied->datum_austritt) ||
        $mitglied->datum_austritt === '0000-00-00' ||
        $mitglied->datum_austritt >= $heute
    ) {
        $mitglied->status_id = 2; // aktiv
    } else {
        $mitglied->status_id = 5; // inaktiv
    }
    $mitglied->save();
});
