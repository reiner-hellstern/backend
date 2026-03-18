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
        // Aufgaben Templates Menü-Eintrag hinzufügen
        DB::table('main_menu_items')->insert([
            'title' => 'Aufgaben Templates',
            'title_short' => '',
            'parent_id' => 18,
            'icon' => '',
            'to' => '/aufgaben-templates',
            'aktiv' => 1,
            'order' => 11, // Vor Notification Templates (order 12)
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Order der nachfolgenden Menü-Einträge anpassen
        DB::table('main_menu_items')
            ->where('parent_id', 18)
            ->where('order', '>=', 11)
            ->where('title', '!=', 'Aufgaben Templates')
            ->increment('order');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menü-Eintrag entfernen
        DB::table('main_menu_items')
            ->where('title', 'Aufgaben Templates')
            ->where('to', '/aufgaben-templates')
            ->delete();

        // Order der nachfolgenden Menü-Einträge zurücksetzen
        DB::table('main_menu_items')
            ->where('parent_id', 18)
            ->where('order', '>', 11)
            ->decrement('order');
    }
};
