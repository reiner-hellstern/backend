<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Prüfen ob Foreign Key für Mitglieder bereits existiert
        $mitgliederFkExists = DB::select("
            SELECT COUNT(*) as count 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'mitglieder' 
            AND CONSTRAINT_NAME = 'mitglieder_person_id_foreign'
        ")[0]->count > 0;

        if (! $mitgliederFkExists) {
            Schema::table('mitglieder', function (Blueprint $table) {
                // person_id als required setzen
                $table->unsignedBigInteger('person_id')->nullable(false)->change();

                // Foreign Key Constraint hinzufügen
                $table->foreign('person_id')->references('id')->on('personen')->onDelete('cascade');
            });
        } else {
            // Nur NOT NULL setzen
            Schema::table('mitglieder', function (Blueprint $table) {
                $table->unsignedBigInteger('person_id')->nullable(false)->change();
            });
        }

        // Zwinger vorerst überspringen - zu komplex für jetzt
        // TODO: Zwinger-Relations später separat behandeln

        // Alte Spalten aus personen Tabelle entfernen
        if (Schema::hasColumn('personen', 'mitglied_id')) {
            Schema::table('personen', function (Blueprint $table) {
                $table->dropColumn('mitglied_id');
            });
        }

        // zwinger_id kann auch entfallen - wird durch person_zwinger Pivot-Tabelle ersetzt
        if (Schema::hasColumn('personen', 'zwinger_id')) {
            Schema::table('personen', function (Blueprint $table) {
                $table->dropColumn('zwinger_id');
            });
        }

        echo "Strukturumstellung abgeschlossen: Person->Mitglied Relation umgestellt\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Alte Spalten wieder hinzufügen
        Schema::table('personen', function (Blueprint $table) {
            $table->unsignedBigInteger('mitglied_id')->nullable();
            $table->unsignedBigInteger('zwinger_id')->nullable();
            $table->index('mitglied_id');
            $table->index('zwinger_id');
        });

        // Daten zurück kopieren
        DB::statement('
            UPDATE personen p 
            JOIN mitglieder m ON m.person_id = p.id 
            SET p.mitglied_id = m.id
        ');

        if (Schema::hasTable('zwinger')) {
            DB::statement('
                UPDATE personen p 
                JOIN zwinger z ON z.person_id = p.id 
                SET p.zwinger_id = z.id
            ');
        }

        // Foreign Keys und person_id Spalten entfernen
        Schema::table('mitglieder', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->dropIndex(['person_id']);
            $table->dropColumn('person_id');
        });

        if (Schema::hasTable('zwinger')) {
            Schema::table('zwinger', function (Blueprint $table) {
                if (Schema::hasColumn('zwinger', 'person_id')) {
                    $table->dropForeign(['person_id']);
                    $table->dropIndex(['person_id']);
                    $table->dropColumn('person_id');
                }
            });
        }
    }
};
