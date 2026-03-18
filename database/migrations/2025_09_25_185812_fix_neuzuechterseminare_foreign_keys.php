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
            // Alte Foreign Keys entfernen
            $table->dropForeign('neuzuechterseminare_ibfk_1'); // event_id
            $table->dropForeign('neuzuechterseminare_ibfk_2'); // person_id -> hunde (falsch)

            // event_id nullable machen
            $table->unsignedBigInteger('event_id')->nullable()->change();

            // Korrekte Foreign Keys neu hinzufügen
            $table->foreign('event_id')->references('id')->on('veranstaltungen')->onDelete('set null');
            $table->foreign('person_id')->references('id')->on('personen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('neuzuechterseminare', function (Blueprint $table) {
            // Neue Foreign Keys entfernen
            $table->dropForeign(['event_id']);
            $table->dropForeign(['person_id']);

            // event_id wieder NOT NULL machen
            $table->unsignedBigInteger('event_id')->nullable(false)->change();

            // Alte (falsche) Foreign Keys wieder hinzufügen
            $table->foreign('event_id', 'neuzuechterseminare_ibfk_1')->references('id')->on('veranstaltungen')->onDelete('restrict');
            $table->foreign('person_id', 'neuzuechterseminare_ibfk_2')->references('id')->on('hunde')->onDelete('restrict');
        });
    }
};
