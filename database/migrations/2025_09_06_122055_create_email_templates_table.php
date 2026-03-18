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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('thema');
            $table->string('position');
            $table->string('vue_component')->nullable();
            $table->string('slug')->unique();
            $table->string('subject'); // Hier ist der Unterschied: subject statt text
            $table->longText('body'); // Hier ist der Unterschied: body zusätzlich
            $table->string('file');
            $table->boolean('aktiv')->default(true);
            $table->timestamps();

            // Indexes wie bei notification_templates
            $table->index(['section_id', 'position']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
