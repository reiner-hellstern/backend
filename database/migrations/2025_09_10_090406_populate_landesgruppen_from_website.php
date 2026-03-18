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
        // Landesgruppe Nord - ID 2 in gruppen Tabelle
        // 1.Vorsitzende: Ingrid Steinhoff-Brücher
        $ingrid_id = DB::table('personen')
            ->where('vorname', 'Ingrid')
            ->where('nachname', 'Steinhoff-Brücher')
            ->where('postleitzahl', '29308')
            ->value('id');

        // 2.Vorsitzende: Silke David
        $silke_id = DB::table('personen')
            ->where('vorname', 'Silke')
            ->where('nachname', 'David')
            ->where('postleitzahl', '24568')
            ->value('id');

        // Schriftführerin: Ulrike Dunkhase
        $ulrike_dunkhase_id = DB::table('personen')
            ->where('vorname', 'Ulrike')
            ->where('nachname', 'Dunkhase')
            ->where('postleitzahl', '19243')
            ->value('id');

        // Update Landesgruppe Nord
        if ($ingrid_id) {
            DB::table('gruppen')->where('id', 2)->update([
                'vorstand1_id' => $ingrid_id,
                'vorstand2_id' => $silke_id,
                'schriftfuehrer_id' => $ulrike_dunkhase_id,
                'strasse' => 'Nördliches Sandfeld 24',
                'postleitzahl' => '29308',
                'ort' => 'Winsen/Aller',
                'telefon' => '05143 93495',
                'email' => 'v1@drc-lg-nord.de',
                'website' => 'http://www.drc-lg-nord.de',
                'updated_at' => now(),
            ]);
        }

        // Landesgruppe Mitte - ID 4 in gruppen Tabelle
        // 1.Vorsitzende: Miriam Steinmetz
        $miriam_id = DB::table('personen')
            ->where('vorname', 'Miriam')
            ->where('nachname', 'Steinmetz')
            ->where('postleitzahl', '97273')
            ->value('id');

        // 2.Vorsitzende: Doris Wirth
        $doris_wirth_id = DB::table('personen')
            ->where('vorname', 'Doris')
            ->where('nachname', 'Wirth')
            ->where('postleitzahl', '65620')
            ->value('id');

        // Schriftführerin: Andrea Kreß
        $andrea_kress_id = DB::table('personen')
            ->where('vorname', 'Andrea')
            ->where('nachname', 'Kreß')
            ->where('postleitzahl', '63589')
            ->value('id');

        // Kassenwartin: Kerstin Schlitt
        $kerstin_id = DB::table('personen')
            ->where('vorname', 'Kerstin')
            ->where('nachname', 'Schlitt')
            ->where('postleitzahl', '65527')
            ->value('id');

        // Update Landesgruppe Mitte
        DB::table('gruppen')->where('id', 4)->update([
            'vorstand1_id' => $miriam_id,
            'vorstand2_id' => $doris_wirth_id,
            'schriftfuehrer_id' => $andrea_kress_id,
            'kassenwart_id' => $kerstin_id,
            'strasse' => 'Untere Weinbergstr. 4',
            'postleitzahl' => '97273',
            'ort' => 'Kürnach',
            'telefon' => '09367 9861954',
            'email' => 'miriam-steinmetz@t-online.de',
            'website' => 'https://www.drc-lg-mitte.de/',
            'updated_at' => now(),
        ]);

        // Landesgruppe Südwest - ID 5 in gruppen Tabelle
        // 1.Vorsitzende: Petra Beringer
        $petra_id = DB::table('personen')
            ->where('vorname', 'Petra')
            ->where('nachname', 'Beringer')
            ->where('postleitzahl', '73614')
            ->value('id');

        // 2.Vorsitzender: Wolfgang Hinderer
        $wolfgang_id = DB::table('personen')
            ->where('vorname', 'Wolfgang')
            ->where('nachname', 'Hinderer')
            ->where('postleitzahl', '72631')
            ->value('id');

        // Schriftführerin: Sybille Keßler
        $sybille_id = DB::table('personen')
            ->where('vorname', 'Sybille')
            ->where('nachname', 'Keßler')
            ->where('postleitzahl', '77704')
            ->value('id');

        // Kassenwart: Michael Lonsinger
        $michael_lonsinger_id = DB::table('personen')
            ->where('vorname', 'Michael')
            ->where('nachname', 'Lonsinger')
            ->where('postleitzahl', '70563')
            ->value('id');

        // Update Landesgruppe Südwest
        DB::table('gruppen')->where('id', 5)->update([
            'vorstand1_id' => $petra_id,
            'vorstand2_id' => $wolfgang_id,
            'schriftfuehrer_id' => $sybille_id,
            'kassenwart_id' => $michael_lonsinger_id,
            'strasse' => 'Olgastrasse 12',
            'postleitzahl' => '73614',
            'ort' => 'Schorndorf',
            'telefon' => '07181 - 9378552',
            'email' => 'p.beringer@web.de',
            'website' => 'http://www.drc-lg-suedwest.org',
            'updated_at' => now(),
        ]);

        // Landesgruppe West - ID 3 in gruppen Tabelle
        // 1.Vorsitzender: René Afflerbach
        $rene_id = DB::table('personen')
            ->where('vorname', 'René')
            ->where('nachname', 'Afflerbach')
            ->where('postleitzahl', '57319')
            ->value('id');

        // 2.Vorsitzender: Michael Brühl
        $michael_bruehl_id = DB::table('personen')
            ->where('vorname', 'Michael')
            ->where('nachname', 'Brühl')
            ->where('postleitzahl', '53819')
            ->value('id');

        // Kassenwartin: Sarah Walter
        $sarah_id = DB::table('personen')
            ->where('vorname', 'Sarah')
            ->where('nachname', 'Walter')
            ->where('postleitzahl', '41539')
            ->value('id');

        // Pressewartin/Schriftführerin: Lisa Leferink
        $lisa_id = DB::table('personen')
            ->where('vorname', 'Lisa')
            ->where('nachname', 'Leferink')
            ->where('postleitzahl', '48455')
            ->value('id');

        // Update Landesgruppe West
        DB::table('gruppen')->where('id', 3)->update([
            'vorstand1_id' => $rene_id,
            'vorstand2_id' => $michael_bruehl_id,
            'kassenwart_id' => $sarah_id,
            'schriftfuehrer_id' => $lisa_id,
            'strasse' => 'Buchenstr. 26',
            'postleitzahl' => '57319',
            'ort' => 'Bad Berleburg',
            'telefon' => '0151-57350709',
            'email' => 'V1@drc-lg-west.de',
            'website' => 'http://www.drc-lg-west.de',
            'updated_at' => now(),
        ]);

        // Landesgruppe Ost - ID 9 in gruppen Tabelle
        // 1.Vorsitzende: Silke Hohmann
        $silke_hohmann_id = DB::table('personen')
            ->where('vorname', 'Silke')
            ->where('nachname', 'Hohmann')
            ->where('postleitzahl', '14550')
            ->value('id');

        // 2.Vorsitzende & Schriftführerin: Doris Bittkow-Thiel
        $doris_bittkow_id = DB::table('personen')
            ->where('vorname', 'Doris')
            ->where('nachname', 'Bittkow-Thiel')
            ->where('postleitzahl', '12105')
            ->value('id');

        // Kassenwart: Thomas Pfeiffer
        $thomas_id = DB::table('personen')
            ->where('vorname', 'Thomas')
            ->where('nachname', 'Pfeiffer')
            ->where('postleitzahl', '16341')
            ->value('id');

        // Update Landesgruppe Ost
        DB::table('gruppen')->where('id', 9)->update([
            'vorstand1_id' => $silke_hohmann_id,
            'vorstand2_id' => $doris_bittkow_id,
            'kassenwart_id' => $thomas_id,
            'schriftfuehrer_id' => $doris_bittkow_id, // kommissarisch
            'strasse' => 'Gartenstr. 75',
            'postleitzahl' => '14550',
            'ort' => 'Groß Kreutz',
            'telefon' => '01523 3683804',
            'email' => 'HohmannsGolden@web.de',
            'website' => 'http://www.drc-lg-ost.de',
            'updated_at' => now(),
        ]);

        // Landesgruppe Süd - ID 6 in gruppen Tabelle
        // 1.Vorsitzender: Tina Branz (kommissarisch)
        $tina_id = DB::table('personen')
            ->where('vorname', 'Tina')
            ->where('nachname', 'Branz')
            ->where('postleitzahl', '85084')
            ->value('id');

        // 2.Vorsitzende: Ulrike Zimmermann (kommissarisch)
        $ulrike_zimmermann_id = DB::table('personen')
            ->where('vorname', 'Ulrike')
            ->where('nachname', 'Zimmermann')
            ->where('postleitzahl', '82229')
            ->value('id');

        // Kassenwartin: Sonja Schröder
        $sonja_id = DB::table('personen')
            ->where('vorname', 'Sonja')
            ->where('nachname', 'Schröder')
            ->where('postleitzahl', '84107')
            ->value('id');

        // Schriftführerin: Christina Jachert-Maier
        $christina_id = DB::table('personen')
            ->where('vorname', 'Christina')
            ->where('nachname', 'Jachert-Maier')
            ->where('postleitzahl', '83607')
            ->value('id');

        // Update Landesgruppe Süd
        DB::table('gruppen')->where('id', 6)->update([
            'vorstand1_id' => $tina_id,
            'vorstand2_id' => $ulrike_zimmermann_id,
            'kassenwart_id' => $sonja_id,
            'schriftfuehrer_id' => $christina_id,
            'strasse' => 'Goethestr. 15',
            'postleitzahl' => '85084',
            'ort' => 'Reichertshofen',
            'telefon' => '08453 458465',
            'email' => 'tbranz@gmx.de',
            'website' => 'https://drc-lg-sued.de/',
            'updated_at' => now(),
        ]);

        // Landesgruppe Weser-Ems - ID 7 in gruppen Tabelle
        // 1.Vorsitzende: Bärbel Achelpöhler
        $baerbel_id = DB::table('personen')
            ->where('vorname', 'Bärbel')
            ->where('nachname', 'Achelpöhler')
            ->where('postleitzahl', '27628')
            ->value('id');

        // 2.Vorsitzende: Anna-Lina Freudenthal
        $anna_lina_id = DB::table('personen')
            ->where('vorname', 'Anna-Lina')
            ->where('nachname', 'Freudenthal')
            ->value('id');

        // Schriftführerin: Birgit Kröll
        $birgit_id = DB::table('personen')
            ->where('vorname', 'Birgit')
            ->where('nachname', 'Kröll')
            ->where('postleitzahl', '28865')
            ->value('id');

        // Kassenwart: Rudolf Lehrburger
        $rudolf_id = DB::table('personen')
            ->where('vorname', 'Rudolf')
            ->where('nachname', 'Lehrburger')
            ->where('postleitzahl', '28865')
            ->value('id');

        // Update Landesgruppe Weser-Ems
        DB::table('gruppen')->where('id', 7)->update([
            'vorstand1_id' => $baerbel_id,
            'vorstand2_id' => $anna_lina_id,
            'kassenwart_id' => $rudolf_id,
            'schriftfuehrer_id' => $birgit_id,
            'strasse' => 'Finnaer Berg 10',
            'postleitzahl' => '27628',
            'ort' => 'Hagen im Bremischen',
            'telefon' => '0176 22337554',
            'email' => 'baerbel.achelpoehler@gmail.com',
            'website' => 'http://www.drc-weser-ems.de',
            'updated_at' => now(),
        ]);

        echo "Migration completed. Some people may not have been found in the database.\n";
        echo "Check the following people manually if needed:\n";
        echo "- Anja Milz (Kassenwartin LG Nord)\n";
        echo "- Anna-Lina Freudenthal (2. Vorsitzende LG Weser-Ems)\n";
        echo "Please verify all assignments manually.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset all Landesgruppen to empty values
        DB::table('gruppen')
            ->whereIn('id', [2, 3, 4, 5, 6, 7, 9])
            ->update([
                'vorstand1_id' => null,
                'vorstand2_id' => null,
                'kassenwart_id' => null,
                'schriftfuehrer_id' => null,
                'strasse' => null,
                'postleitzahl' => null,
                'ort' => null,
                'website' => null,
                'email' => null,
                'telefon' => null,
                'updated_at' => now(),
            ]);
    }
};
