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
        // Anja Milz als Kassenwartin der LG Nord hinzufügen
        DB::table('gruppen')->where('id', 2)->update([
            'kassenwart_id' => 24881, // Anja Milz
            'updated_at' => now(),
        ]);

        echo "Fixed missing assignments:\n";
        echo "- Anja Milz als Kassenwartin LG Nord\n";
        echo "Note: Sarah Walter (Kassenwartin LG West) not found in database\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('gruppen')->where('id', 2)->update([
            'kassenwart_id' => null,
            'updated_at' => now(),
        ]);
    }
};
