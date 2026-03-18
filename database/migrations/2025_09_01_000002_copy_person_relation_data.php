<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Daten von personen.mitglied_id zu mitglieder.person_id kopieren
        DB::statement('
            UPDATE mitglieder m 
            JOIN personen p ON p.mitglied_id = m.id 
            SET m.person_id = p.id
            WHERE p.mitglied_id IS NOT NULL
        ');

        // Daten von personen.zwinger_id zu zwinger.person_id kopieren (falls zwinger Tabelle existiert)
        if (DB::getSchemaBuilder()->hasTable('zwinger')) {
            DB::statement('
                UPDATE zwinger z 
                JOIN personen p ON p.zwinger_id = z.id 
                SET z.person_id = p.id
                WHERE p.zwinger_id IS NOT NULL
            ');
        }

        // Prüfung: Alle mitglieder sollten jetzt eine person_id haben
        $orphanedMitglieder = DB::table('mitglieder')->whereNull('person_id')->count();
        if ($orphanedMitglieder > 0) {
            throw new Exception("$orphanedMitglieder Mitglieder haben keine Person-Zuordnung!");
        }

        echo "Migration erfolgreich: Alle Mitglieder haben jetzt eine person_id\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Daten zurück kopieren
        DB::statement('
            UPDATE personen p 
            JOIN mitglieder m ON m.person_id = p.id 
            SET p.mitglied_id = m.id
            WHERE m.person_id IS NOT NULL
        ');

        if (DB::getSchemaBuilder()->hasTable('zwinger')) {
            DB::statement('
                UPDATE personen p 
                JOIN zwinger z ON z.person_id = p.id 
                SET p.zwinger_id = z.id
                WHERE z.person_id IS NOT NULL
            ');
        }

        // person_id wieder auf NULL setzen
        DB::table('mitglieder')->update(['person_id' => null]);
        if (DB::getSchemaBuilder()->hasTable('zwinger')) {
            DB::table('zwinger')->update(['person_id' => null]);
        }
    }
};
