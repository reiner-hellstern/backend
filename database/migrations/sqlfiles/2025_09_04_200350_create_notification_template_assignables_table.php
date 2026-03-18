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
        Schema::create('notification_template_assignables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_template_id')->nullable();
            $table->morphs('assignable'); // Creates assignable_id and assignable_type columns
            $table->timestamps();

            // Unique constraint to prevent duplicate assignments
            //  $table->unique(['notification_template_id', 'assignable_id', 'assignable_type'], 'nt_assignable_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_template_assignables');
    }
};
