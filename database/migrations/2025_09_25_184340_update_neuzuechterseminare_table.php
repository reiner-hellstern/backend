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
        Schema::table('neuzuechterseminare', function (Blueprint $table) {
            // Neue Spalten hinzufügen (datum, event_id und aktiv bleiben bestehen)
            $table->string('ort')->nullable()->after('datum');
            $table->text('bemerkungen')->nullable()->after('ort');
            $table->timestamp('bestaetigt_am')->nullable()->after('aktiv');
            $table->unsignedBigInteger('bestaetigt_von')->nullable()->after('bestaetigt_am');

            // Foreign key für bestaetigt_von (referenziert personen.id)
            $table->foreign('bestaetigt_von')->references('id')->on('personen')->onDelete('set null');

            // bestaetigt Spalte in status umbenennen für bessere Klarheit
            $table->renameColumn('bestaetigt', 'status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('neuzuechterseminare', function (Blueprint $table) {
            // Foreign key constraint entfernen
            $table->dropForeign(['bestaetigt_von']);

            // Neue Spalten entfernen
            $table->dropColumn([
                'ort',
                'bemerkungen',
                'bestaetigt_am',
                'bestaetigt_von',
            ]);

            // status zurück in bestaetigt umbenennen
            $table->renameColumn('status', 'bestaetigt');
        });
    }
};
