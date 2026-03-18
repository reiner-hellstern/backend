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
        Schema::create('dsgvo_erklaerungen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('personen')->onDelete('cascade');

            // Stufe der DSGVO-Erklärung (z.B. 1 = Basis, 2 = erweitert, etc.)
            $table->unsignedTinyInteger('stufe')->default(1)->comment('Stufe der DSGVO-Erklärung');

            // Datum der Zustimmung
            $table->date('zugestimmt_am')->comment('Datum der Zustimmung zur DSGVO');

            // Optional: Datum des Widerrufs
            $table->date('widerrufen_am')->nullable()->comment('Datum des Widerrufs der DSGVO-Zustimmung');

            // Optional: Bemerkungen
            $table->text('bemerkungen')->nullable();

            // Status: aktiv/widerrufen
            $table->boolean('ist_aktiv')->default(true)->comment('Ist die DSGVO-Erklärung noch aktiv?');

            $table->timestamps();

            // Indizes für häufige Abfragen
            $table->index(['person_id', 'ist_aktiv']);
            $table->index('zugestimmt_am');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsgvo_erklaerungen');
    }
};
