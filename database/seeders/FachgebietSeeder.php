<?php

namespace Database\Seeders;

use App\Models\Fachgebiet;
use Illuminate\Database\Seeder;

class FachgebietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fachgebiete = [
            [
                'name' => 'Allgemeinmedizin',
                'beschreibung' => 'Allgemeine medizinische Versorgung',
                'aktiv' => true,
            ],
            [
                'name' => 'Orthopädie',
                'beschreibung' => 'Erkrankungen des Bewegungsapparats',
                'aktiv' => true,
            ],
            [
                'name' => 'Dermatologie',
                'beschreibung' => 'Hauterkrankungen und Allergien',
                'aktiv' => true,
            ],
            [
                'name' => 'Kardiologie',
                'beschreibung' => 'Herz- und Kreislauferkrankungen',
                'aktiv' => true,
            ],
            [
                'name' => 'Ophthalmologie',
                'beschreibung' => 'Augenerkrankungen und Augenheilkunde',
                'aktiv' => true,
            ],
            [
                'name' => 'Neurologie',
                'beschreibung' => 'Erkrankungen des Nervensystems',
                'aktiv' => true,
            ],
            [
                'name' => 'Innere Medizin',
                'beschreibung' => 'Innere Erkrankungen und Diagnostik',
                'aktiv' => true,
            ],
            [
                'name' => 'Onkologie',
                'beschreibung' => 'Krebserkrankungen und Tumorbehandlung',
                'aktiv' => true,
            ],
            [
                'name' => 'Zahnheilkunde',
                'beschreibung' => 'Zahnmedizin und Maulhöhlenerkrankungen',
                'aktiv' => true,
            ],
            [
                'name' => 'Reproduktionsmedizin',
                'beschreibung' => 'Fortpflanzungsmedizin und Geburtshilfe',
                'aktiv' => true,
            ],
            [
                'name' => 'Verhaltensmedizin',
                'beschreibung' => 'Verhaltensauffälligkeiten und Verhaltensstörungen',
                'aktiv' => true,
            ],
        ];

        foreach ($fachgebiete as $fachgebiet) {
            Fachgebiet::create($fachgebiet);
        }
    }
}
