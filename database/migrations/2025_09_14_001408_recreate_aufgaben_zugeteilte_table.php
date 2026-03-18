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
        // Drop existing table
        Schema::dropIfExists('aufgaben_zugeteilte');

        // Recreate with simple structure
        Schema::create('aufgaben_zugeteilte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aufgaben_id')->constrained('aufgaben')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['aufgaben_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aufgaben_zugeteilte');

        // Recreate original polymorphic structure
        Schema::create('aufgaben_zugeteilte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aufgaben_id')->constrained('aufgaben')->onDelete('cascade');
            $table->string('assignable_type');
            $table->unsignedBigInteger('assignable_id');
            $table->timestamps();

            $table->index(['assignable_type', 'assignable_id'], 'aufgaben_zuget_assign_idx');
            $table->unique(['aufgaben_id', 'assignable_type', 'assignable_id'], 'aufgaben_zuget_unique');
        });
    }
};
