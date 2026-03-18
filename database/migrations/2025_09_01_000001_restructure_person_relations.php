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
        // Schritt 1: Neue person_id Spalten hinzufügen
        Schema::table('mitglieder', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')->nullable()->after('id');
            $table->index('person_id');
        });

        // Prüfen ob zwinger Tabelle existiert, bevor wir sie ändern
        if (Schema::hasTable('zwinger')) {
            Schema::table('zwinger', function (Blueprint $table) {
                $table->unsignedBigInteger('person_id')->nullable()->after('id');
                $table->index('person_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitglieder', function (Blueprint $table) {
            $table->dropIndex(['person_id']);
            $table->dropColumn('person_id');
        });

        if (Schema::hasTable('zwinger')) {
            Schema::table('zwinger', function (Blueprint $table) {
                $table->dropIndex(['person_id']);
                $table->dropColumn('person_id');
            });
        }
    }
};
