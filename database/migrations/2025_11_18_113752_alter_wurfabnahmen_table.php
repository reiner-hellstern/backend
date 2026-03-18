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
        Schema::table('wurfabnahmen', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['wurf_id']);
            $table->dropForeign(['zuchtwart_id']);

            // Add new foreign key constraints
            $table->foreign('wurf_id')
                ->references('id')
                ->on('wuerfe')
                ->onDelete('cascade');

            $table->foreign('zuchtwart_id')
                ->references('id')
                ->on('zuchtwarte')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wurfabnahmen', function (Blueprint $table) {
            // Drop the new foreign key constraints
            $table->dropForeign(['wurf_id']);
            $table->dropForeign(['zuchtwart_id']);

            // Recreate the original foreign key constraints
            $table->foreign('wurf_id')
                ->references('id')
                ->on('wuerfe_stage0')
                ->onDelete('cascade');

            $table->foreign('zuchtwart_id')
                ->references('id')
                ->on('drc11_utf8mb4_unicode.zuchtwarte_alt')
                ->onDelete('cascade');
        });
    }
};
