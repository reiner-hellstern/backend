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
        Schema::create('infotexte_assignables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('infotexte_id')->constrained('infotexte')->onDelete('cascade');
            $table->string('assignable_type');
            $table->unsignedBigInteger('assignable_id');
            $table->timestamps();
            $table->index(['assignable_type', 'assignable_id']);
            $table->unique(['infotexte_id', 'assignable_type', 'assignable_id'], 'infotexte_assignable_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infotexte_assignables');
    }
};
