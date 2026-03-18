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
        Schema::create('rechnungexports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('exportdatum');
            $table->string('dta_datei_pfad')->nullable(); // Pfad zur DTA-Export-Datei
            $table->string('csv_datei_pfad')->nullable(); // Pfad zur CSV-Export-Datei
            $table->string('titel')->nullable(); // Optional: Titel/Beschreibung des Exports
            $table->integer('anzahl_rechnungen')->default(0); // Anzahl exportierter Rechnungen
            $table->decimal('gesamtbetrag', 10, 2)->default(0); // Gesamtbetrag der exportierten Rechnungen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rechnungexports');
    }
};
