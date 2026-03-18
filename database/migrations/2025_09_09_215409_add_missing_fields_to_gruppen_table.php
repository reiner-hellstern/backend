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
        Schema::table('gruppen', function (Blueprint $table) {
            // Polymorphic relationship fields
            $table->unsignedBigInteger('gruppenable_id')->nullable();
            $table->string('gruppenable_type')->nullable();

            // Foreign key fields for Personen
            $table->unsignedBigInteger('vorstand1_id')->nullable();
            $table->unsignedBigInteger('vorstand2_id')->nullable();
            $table->unsignedBigInteger('kassenwart_id')->nullable();
            $table->unsignedBigInteger('schriftfuehrer_id')->nullable();

            // Address fields
            $table->string('strasse')->nullable();
            $table->string('postleitzahl')->nullable();
            $table->string('ort')->nullable();

            // Contact fields
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon')->nullable();

            // Hierarchy field
            $table->unsignedBigInteger('parent_id')->nullable();

            // Add foreign key constraints
            $table->foreign('vorstand1_id')->references('id')->on('personen')->onDelete('set null');
            $table->foreign('vorstand2_id')->references('id')->on('personen')->onDelete('set null');
            $table->foreign('kassenwart_id')->references('id')->on('personen')->onDelete('set null');
            $table->foreign('schriftfuehrer_id')->references('id')->on('personen')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('gruppen')->onDelete('set null');

            // Add index for polymorphic relationship
            $table->index(['gruppenable_type', 'gruppenable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gruppen', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['vorstand1_id']);
            $table->dropForeign(['vorstand2_id']);
            $table->dropForeign(['kassenwart_id']);
            $table->dropForeign(['schriftfuehrer_id']);
            $table->dropForeign(['parent_id']);

            // Drop index
            $table->dropIndex(['gruppenable_type', 'gruppenable_id']);

            // Drop columns
            $table->dropColumn([
                'gruppenable_id',
                'gruppenable_type',
                'vorstand1_id',
                'vorstand2_id',
                'kassenwart_id',
                'schriftfuehrer_id',
                'strasse',
                'postleitzahl',
                'ort',
                'website',
                'email',
                'telefon',
                'parent_id',
            ]);
        });
    }
};
