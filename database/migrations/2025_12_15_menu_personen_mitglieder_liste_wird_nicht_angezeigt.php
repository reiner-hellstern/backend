<?php

use App\Traits\ExecuteSqlFile;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    use ExecuteSqlFile;

    public function up(): void
    {

        $this->executeSqlFile('2025_12_15_menu_personen_mitglieder_liste_wird_nicht_angezeigt.sql');
    }
};
