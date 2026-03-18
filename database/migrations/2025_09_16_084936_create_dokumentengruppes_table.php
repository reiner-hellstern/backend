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
        Schema::create('dokumentenkategorien', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('beschreibung')->nullable();
            $table->integer('reihenfolge')->default(0);
            $table->boolean('aktiv')->default(true);
            $table->timestamps();

            $table->index(['aktiv', 'reihenfolge']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentenkategorien');
    }
};
