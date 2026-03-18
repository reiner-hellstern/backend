<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            ['name' => 'Backend', 'name_kurz' => 'backend', 'typ' => 'section', 'order' => 1],
            ['name' => 'Ärzte', 'name_kurz' => 'aerzte', 'typ' => 'section', 'order' => 2],
            ['name' => 'Ahnentafel', 'name_kurz' => 'ahnentafel', 'typ' => 'section', 'order' => 3],
            ['name' => 'Dashboard', 'name_kurz' => 'dashboard', 'typ' => 'section', 'order' => 4],
            ['name' => 'Debug', 'name_kurz' => 'debug', 'typ' => 'section', 'order' => 5],
            ['name' => 'Demo', 'name_kurz' => 'demo', 'typ' => 'section', 'order' => 6],
            ['name' => 'Development', 'name_kurz' => 'development', 'typ' => 'section', 'order' => 7],
            ['name' => 'E-Mails', 'name_kurz' => 'emails', 'typ' => 'section', 'order' => 8],
            ['name' => 'Formularelemente', 'name_kurz' => 'formelements', 'typ' => 'section', 'order' => 9],
            ['name' => 'Gebührenordnungen', 'name_kurz' => 'gebuehrenordnungen', 'typ' => 'section', 'order' => 10],
            ['name' => 'Global', 'name_kurz' => 'global', 'typ' => 'section', 'order' => 11],
            ['name' => 'Hunde', 'name_kurz' => 'hunde', 'typ' => 'section', 'order' => 12],
            ['name' => 'Landesbezirksgruppen', 'name_kurz' => 'landesbezirksgruppen', 'typ' => 'section', 'order' => 13],
            ['name' => 'Layout', 'name_kurz' => 'layout', 'typ' => 'section', 'order' => 14],
            ['name' => 'Mitglieder', 'name_kurz' => 'mitglieder', 'typ' => 'section', 'order' => 15],
            ['name' => 'Modals', 'name_kurz' => 'modals', 'typ' => 'section', 'order' => 16],
            ['name' => 'Nachkommen', 'name_kurz' => 'nachkommen', 'typ' => 'section', 'order' => 17],
            ['name' => 'Notifications', 'name_kurz' => 'notifications', 'typ' => 'section', 'order' => 18],
            ['name' => 'Personen', 'name_kurz' => 'personen', 'typ' => 'section', 'order' => 19],
            ['name' => 'Profil', 'name_kurz' => 'profil', 'typ' => 'section', 'order' => 20],
            ['name' => 'Prüfungen', 'name_kurz' => 'pruefungen', 'typ' => 'section', 'order' => 21],
            ['name' => 'Rechnungen', 'name_kurz' => 'rechnungen', 'typ' => 'section', 'order' => 22],
            ['name' => 'Richter', 'name_kurz' => 'richter', 'typ' => 'section', 'order' => 23],
            ['name' => 'Rollen & Rechte', 'name_kurz' => 'rollen_rechte', 'typ' => 'section', 'order' => 24],
            ['name' => 'Sonderleiter', 'name_kurz' => 'sonderleiter', 'typ' => 'section', 'order' => 25],
            ['name' => 'Tasks', 'name_kurz' => 'tasks', 'typ' => 'section', 'order' => 26],
            ['name' => 'Titel', 'name_kurz' => 'titel', 'typ' => 'section', 'order' => 27],
            ['name' => 'Users', 'name_kurz' => 'users', 'typ' => 'section', 'order' => 28],
            ['name' => 'Veranstaltungen', 'name_kurz' => 'veranstaltungen', 'typ' => 'section', 'order' => 29],
            ['name' => 'Würfe', 'name_kurz' => 'wuerfe', 'typ' => 'section', 'order' => 30],
            ['name' => 'Zuchtwarte', 'name_kurz' => 'zuchtwarte', 'typ' => 'section', 'order' => 31],
            ['name' => 'Züchter', 'name_kurz' => 'zuechter', 'typ' => 'section', 'order' => 32],
            ['name' => 'Zwinger', 'name_kurz' => 'zwinger', 'typ' => 'section', 'order' => 33],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['name_kurz' => $section['name_kurz']],
                $section
            );
        }
    }
}
