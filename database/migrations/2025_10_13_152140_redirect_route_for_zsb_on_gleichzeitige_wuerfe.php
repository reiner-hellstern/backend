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
        DB::table('orgatree_items')
            ->where('id', 424)
            ->update(['edit_to' => 'meine-zucht-zuchtstaettenbesichtigung-wegen-gleichzeitigen-wuerfen-beantragen']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('orgatree_items')
            ->where('id', 424)
            ->update(['edit_to' => 'meine-zucht-wuerfe-zwei-gleichzeitige-beantragen']);
    }
};
