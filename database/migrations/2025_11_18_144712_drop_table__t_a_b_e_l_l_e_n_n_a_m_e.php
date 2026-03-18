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
        Schema::dropIfExists('TABELLENNAME');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('TABELLENNAME', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hund_id');
            $table->date('datum');
            $table->string('zbnr', 25);
            $table->unsignedBigInteger('rasse_id');
            $table->string('ort', 25);
            $table->integer('i');
            $table->integer('ii');
            $table->integer('iii');
            $table->integer('iv');
            $table->integer('v');
            $table->integer('vi');
            $table->integer('vii');
            $table->string('titel', 20);
            $table->unsignedBigInteger('pruefung_id');
            $table->integer('punkte');
            $table->tinyInteger('bestanden');
            $table->string('ausschlussgrund', 75);
            $table->integer('testfeld2');
            $table->integer('testfeld3');
        });
    }
};
