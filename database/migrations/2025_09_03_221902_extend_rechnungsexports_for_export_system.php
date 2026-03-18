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
        // Fehlende Spalten zur rechnungsexports Tabelle hinzufügen
        Schema::table('rechnungsexports', function (Blueprint $table) {
            $table->enum('status', ['erstellt', 'uebertragen', 'storniert'])->default('erstellt')->after('gesamtbetrag');
            $table->date('bank_uebertragen_am')->nullable()->after('status');
            $table->string('bank_uebertragen_von')->nullable()->after('bank_uebertragen_am');
            $table->foreignId('erstellt_von')->nullable()->constrained('users')->after('bank_uebertragen_von');
        });

        // Pivot-Tabelle für Rechnungsexport-Rechnung Beziehung erstellen
        Schema::create('rechnungsexport_rechnung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rechnungsexport_id')->constrained('rechnungsexports')->onDelete('cascade');
            $table->foreignId('rechnung_id')->constrained('rechnungen')->onDelete('cascade');
            $table->decimal('export_betrag', 10, 2);
            $table->string('export_typ');
            $table->timestamps();

            $table->unique(['rechnungsexport_id', 'rechnung_id']);
        });

        // rechnungsexport_id Spalte zur rechnungen Tabelle hinzufügen
        Schema::table('rechnungen', function (Blueprint $table) {
            $table->foreignId('rechnungsexport_id')->nullable()->constrained('rechnungsexports')->nullOnDelete()->after('dta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rechnungen', function (Blueprint $table) {
            $table->dropForeign(['rechnungsexport_id']);
            $table->dropColumn('rechnungsexport_id');
        });

        Schema::dropIfExists('rechnungsexport_rechnung');

        Schema::table('rechnungsexports', function (Blueprint $table) {
            $table->dropForeign(['erstellt_von']);
            $table->dropColumn([
                'status',
                'bank_uebertragen_am',
                'bank_uebertragen_von',
                'erstellt_von',
            ]);
        });
    }
};
