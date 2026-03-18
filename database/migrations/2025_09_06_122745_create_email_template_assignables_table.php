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
        Schema::create('email_template_assignables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_template_id')->constrained('email_templates')->onDelete('cascade');
            $table->string('assignable_type');
            $table->unsignedBigInteger('assignable_id');
            $table->timestamps();

            // Index for polymorphic relationship
            $table->index(['assignable_type', 'assignable_id']);

            // Unique constraint to prevent duplicate assignments
            $table->unique(['email_template_id', 'assignable_type', 'assignable_id'], 'email_template_assignable_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_template_assignables');
    }
};
