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
        Schema::create('zweitwohnsitznachweise', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('zuchtstaette_id');
            $table->text('bemerkungen')->nullable();
            $table->boolean('aktiv')->default(true);
            $table->boolean('status')->default(false);
            $table->timestamp('bestaetigt_am')->nullable();
            $table->unsignedBigInteger('bestaetigt_von')->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('personen');
            $table->foreign('zuchtstaette_id')->references('id')->on('zuchtstaetten');
            $table->foreign('bestaetigt_von')->references('id')->on('personen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zweitwohnsitznachweise');
    }
};
