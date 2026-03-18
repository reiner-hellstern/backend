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
        Schema::table('wurfabnahme_welpen', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['welpen_id']);

            // Rename the column
            $table->renameColumn('welpen_id', 'hund_id');

            // Recreate the foreign key with the new column name
            $table->foreign('hund_id')
                ->references('id')
                ->on('hunde')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wurfabnahme_welpen', function (Blueprint $table) {
            // Drop the foreign key constraint with the new column name
            $table->dropForeign(['hund_id']);

            // Rename the column back to the original
            $table->renameColumn('hund_id', 'welpen_id');

            // Recreate the original foreign key
            $table->foreign('welpen_id')
                ->references('id')
                ->on('welpen')
                ->onDelete('cascade');
        });
    }
};
