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
        Schema::table('rechnungexports', function (Blueprint $table) {
            $table->string('format')->nullable()->after('titel'); // CSV, DTA etc.
            $table->string('von_rechnungsnummer')->nullable()->after('format'); // Von Rechnungsnummer
            $table->string('bis_rechnungsnummer')->nullable()->after('von_rechnungsnummer'); // Bis Rechnungsnummer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rechnungexports', function (Blueprint $table) {
            $table->dropColumn(['format', 'von_rechnungsnummer', 'bis_rechnungsnummer']);
        });
    }
};
