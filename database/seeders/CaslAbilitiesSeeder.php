<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CaslAbilitiesSeeder extends Seeder
{
    public function run()
    {
        // Definiere Standard-Abilities für CASL
        $abilities = [
            // Dashboard
            ['name' => 'view', 'entity' => 'Dashboard'],
            ['name' => 'manage', 'entity' => 'Dashboard'],

            // Personen
            ['name' => 'personenakte', 'entity' => 'App\Models\Person'],
            ['name' => 'view', 'entity' => 'App\Models\Person'],
            ['name' => 'create', 'entity' => 'App\Models\Person'],
            ['name' => 'edit', 'entity' => 'App\Models\Person'],
            ['name' => 'delete', 'entity' => 'App\Models\Person'],
            ['name' => 'manage', 'entity' => 'App\Models\Person'],

            // Hunde
            ['name' => 'hundeakte', 'entity' => 'App\Models\Hund'],
            ['name' => 'view', 'entity' => 'App\Models\Hund'],
            ['name' => 'create', 'entity' => 'App\Models\Hund'],
            ['name' => 'edit', 'entity' => 'App\Models\Hund'],
            ['name' => 'delete', 'entity' => 'App\Models\Hund'],
            ['name' => 'manage', 'entity' => 'App\Models\Hund'],

            // Zwinger
            ['name' => 'zwingerakte', 'entity' => 'App\Models\Zwinger'],
            ['name' => 'view', 'entity' => 'App\Models\Zwinger'],
            ['name' => 'create', 'entity' => 'App\Models\Zwinger'],
            ['name' => 'edit', 'entity' => 'App\Models\Zwinger'],
            ['name' => 'manage', 'entity' => 'App\Models\Zwinger'],

            //Wurf
            ['name' => 'wurfakte', 'entity' => 'App\Models\Wurf'],
            ['name' => 'view', 'entity' => 'App\Models\Wurf'],
            ['name' => 'create', 'entity' => 'App\Models\Wurf'],
            ['name' => 'edit', 'entity' => 'App\Models\Wurf'],
            ['name' => 'delete', 'entity' => 'App\Models\Wurf'],
            ['name' => 'manage', 'entity' => 'App\Models\Wurf'],

            // Administrative Bereiche
            ['name' => 'view', 'entity' => 'Admin'],
            ['name' => 'manage', 'entity' => 'Admin'],
            ['name' => 'create', 'entity' => 'User'],
            ['name' => 'edit', 'entity' => 'User'],
            ['name' => 'delete', 'entity' => 'User'],

        ];

        // Erstelle alle Abilities
        foreach ($abilities as $ability) {
            Bouncer::ability()->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity'],
            ]);
        }

        // Erstelle Standard-Rollen falls nicht vorhanden
        if (! Bouncer::role()->where('name', 'admin')->exists()) {
            $adminRole = Bouncer::role()->create([
                'name' => 'admin',
                'title' => 'Administrator',
            ]);

            // Admin kann alles
            Bouncer::allow($adminRole)->everything();
        }

        $gsRole = Bouncer::role()->where('name', 'gs')->first();
        if (! $gsRole) {
            $gsRole = Bouncer::role()->create([
                'name' => 'gs',
                'title' => 'Geschäftsstelle',
            ]);
        }

        // Zuchtwart-spezifische Berechtigungen
        Bouncer::allow($gsRole)->to([
            'view', 'create', 'edit', 'manage', 'delete',
        ], [
            'App\Models\Person',
            'App\Models\Hund',
            'App\Models\Zwinger',
        ]);

        $this->command->info('CASL Abilities und Rollen wurden erstellt.');
    }
}
