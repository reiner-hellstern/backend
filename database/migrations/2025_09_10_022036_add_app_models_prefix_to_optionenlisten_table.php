<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Füge App\Models\ Präfix zu allen model Einträgen hinzu, die es noch nicht haben
        DB::table('optionenlisten')
            ->where('model', 'NOT LIKE', 'App\\Models\\%')
            ->update([
                'model' => DB::raw("CONCAT('App\\\\Models\\\\', model)"),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Entferne App\Models\ Präfix von allen model Einträgen
        DB::table('optionenlisten')
            ->where('model', 'LIKE', 'App\\Models\\%')
            ->update([
                'model' => DB::raw('SUBSTRING(model, 12)'),  // Entferne die ersten 11 Zeichen "App\\Models\\"
            ]);
    }
};
