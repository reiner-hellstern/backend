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
        Schema::create('aufgaben_zugeteilte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aufgaben_id');
            $table->string('assignable_type'); // User, Person, Role
            $table->unsignedBigInteger('assignable_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('aufgaben_id')->references('id')->on('aufgaben')->onDelete('cascade');

            // Composite unique index to prevent duplicates
            $table->unique(['aufgaben_id', 'assignable_type', 'assignable_id'], 'aufgaben_zuget_unique');

            // Index for polymorphic relationship
            $table->index(['assignable_type', 'assignable_id'], 'aufgaben_zuget_assign_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aufgaben_zugeteilte');
    }
};
