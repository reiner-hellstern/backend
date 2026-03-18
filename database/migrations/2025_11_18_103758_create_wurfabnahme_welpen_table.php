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
        Schema::create('wurfabnahme_welpen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wurfabnahme_id')->constrained('wurfabnahmen')->cascadeOnDelete();
            $table->foreignId('welpen_id')->constrained('welpen')->cascadeOnDelete();
            $table->integer('farbe_id')->constrained('farben')->nullable();
            $table->integer('augen_id')->constrained('bewertungen_augen')->nullable();
            $table->integer('gebiss_id')->constrained('bewertungen_gebiss')->nullable();
            $table->integer('hoden_id')->constrained('bewertungen_hoden')->nullable();
            $table->string('zaehne')->nullable();
            $table->string('zuchtausschliessende_fehler')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wurfabnahme_welpen');
    }
};
