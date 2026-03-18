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
        Schema::create('kontaktdatenaenderungs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');

            // Namensdaten (aus personen Tabelle)
            $table->string('vorname')->nullable();
            $table->string('nachname')->nullable();
            $table->string('nachname_ehemals')->nullable();
            $table->date('geboren')->nullable();

            // Kontaktdaten (aus personen Tabelle)
            $table->string('telefon_1')->nullable();
            $table->string('telefon_2')->nullable();
            $table->string('telefon_3')->nullable();
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('website_1')->nullable();
            $table->string('website_2')->nullable();

            // Adressdaten (aus personen/personenadressen Tabelle)
            $table->string('strasse')->nullable();
            $table->string('adresszusatz')->nullable();
            $table->string('postleitzahl')->nullable();
            $table->string('ort')->nullable();
            $table->string('land')->nullable();
            $table->string('laenderkuerzel')->nullable();
            $table->string('postfach_plz')->nullable();
            $table->string('postfach_nummer')->nullable();

            // Status und Bemerkungen
            $table->text('bemerkungen')->nullable();
            $table->boolean('aktiv')->default(true);
            $table->timestamp('bestaetigt_am')->nullable();
            $table->unsignedBigInteger('bestaetigt_von')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('person_id')->references('id')->on('personen');
            $table->foreign('bestaetigt_von')->references('id')->on('personen');

            // Indexes
            $table->index('person_id');
            $table->index('aktiv');
            $table->index('bestaetigt_am');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontaktdatenaenderungs');
    }
};
