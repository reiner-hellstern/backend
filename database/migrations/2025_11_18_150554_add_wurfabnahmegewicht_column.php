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
            $table->decimal('wurfabnahmegewicht', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wurfabnahme_welpen', function (Blueprint $table) {
            $table->dropColumn('wurfabnahmegewicht');
        });
    }
};
