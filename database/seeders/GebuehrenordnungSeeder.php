<?php

namespace Database\Seeders;

use App\Models\Gebuehr;
use App\Models\Gebuehrengruppe;
use App\Models\Gebuehrenkatalog;
use App\Models\Gebuehrenordnung;
use Illuminate\Database\Seeder;

class GebuehrenordnungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gebührenordnung 2024 erstellen
        $gebuehrenordnung2024 = Gebuehrenordnung::create([
            'name' => 'DRC Gebühren- und Spesenordnung 2024',
            'gueltig_ab' => '2024-04-01',
            'gueltig_bis' => null,
        ]);

        // Gebührengruppen erstellen
        $mitgliedschaftGruppe = Gebuehrengruppe::create([
            'name' => 'Mitgliedschaft und Verwaltung',
            'name_kurz' => 'Mitgliedschaft',
            'typ' => 'mitgliedschaft',
            'order' => 10,
        ]);

        $ausstellungGruppe = Gebuehrengruppe::create([
            'name' => 'Zuchtschauen und Ausstellungen',
            'name_kurz' => 'Ausstellungen',
            'typ' => 'ausstellung',
            'order' => 20,
        ]);

        $pruefungGruppe = Gebuehrengruppe::create([
            'name' => 'Prüfungen und Tests',
            'name_kurz' => 'Prüfungen',
            'typ' => 'pruefung',
            'order' => 30,
        ]);

        $zuchtGruppe = Gebuehrengruppe::create([
            'name' => 'Zucht und Ahnentafeln',
            'name_kurz' => 'Zucht',
            'typ' => 'zucht',
            'order' => 40,
        ]);

        $gesundheitGruppe = Gebuehrengruppe::create([
            'name' => 'Gesundheitsuntersuchungen',
            'name_kurz' => 'Gesundheit',
            'typ' => 'gesundheit',
            'order' => 50,
        ]);

        $registrierungGruppe = Gebuehrengruppe::create([
            'name' => 'Registrierung',
            'name_kurz' => 'Registrierung',
            'typ' => 'registrierung',
            'order' => 60,
        ]);

        // Mitgliedschaft und Verwaltung
        $this->createKatalogEintraege($gebuehrenordnung2024, $mitgliedschaftGruppe, [
            ['DRC-Mitgliedsbeitrag (Vollmitglied)', 'Jahresbeitrag für Vollmitglieder', 59.00, 59.00],
            ['DRC-Mitgliedsbeitrag (Vollmitglied) - nach 1. Juli', 'Reduzierter Beitrag bei Eintritt nach 1. Juli', 30.00, 30.00],
            ['DRC-Mitgliedsbeitrag (Vollmitglied) - Ausland', 'Jahresbeitrag für Mitglieder außerhalb Deutschlands', 70.00, 70.00],
            ['DRC-Mitgliedsbeitrag (Vollmitglied) - Ausland nach 1. Juli', 'Reduzierter Beitrag Ausland nach 1. Juli', 35.00, 35.00],
            ['DRC-Mitgliedsbeitrag (Familienmitglied)', 'Jahresbeitrag für Familienmitglieder', 30.00, 30.00],
            ['DRC-Mitgliedsbeitrag (Familienmitglied) - nach 1. Juli', 'Reduzierter Familienbeitrag nach 1. Juli', 15.00, 15.00],
            ['Aufnahmegebühr', 'Einmalige Gebühr bei Aufnahme', 25.00, 25.00],
            ['2. Mahnung', 'Bearbeitungsgebühr für 2. Mahnung', 2.50, 2.50],
            ['Säumniszuschlag', 'Zuschlag gem. § 13(2) DRC Satzung', 10.00, 10.00],
            ['Bearbeitungsgebühr Rücklastschrift', 'Gebühr für Rücklastschriften', 10.00, 10.00],
        ]);

        // Zuchtschauen und Ausstellungen
        $this->createKatalogEintraege($gebuehrenordnung2024, $ausstellungGruppe, [
            ['DRC Zuchtschau - 1. Meldeschluss - 1. Hund', '8 Wochen vor Ausstellungstag', 35.00, 35.00],
            ['DRC Zuchtschau - 1. Meldeschluss - weitere Hunde', 'Jeder weitere Hund desselben Eigentümers', 30.00, 30.00],
            ['DRC Zuchtschau - 1. Meldeschluss - Baby/Jüngsten/Veteranen', 'Spezialklassen beim 1. Meldeschluss', 30.00, 30.00],
            ['DRC Zuchtschau - 2. Meldeschluss - 1. Hund', '4 Wochen vor Ausstellungstag', 45.00, 45.00],
            ['DRC Zuchtschau - 2. Meldeschluss - weitere Hunde', 'Jeder weitere Hund desselben Eigentümers', 40.00, 40.00],
            ['DRC Zuchtschau - 2. Meldeschluss - Baby/Jüngsten/Veteranen', 'Spezialklassen beim 2. Meldeschluss', 30.00, 30.00],
            ['DRC Zuchtschau - 3. Meldeschluss - 1. Hund', '2 Wochen vor Ausstellungstag', 55.00, 55.00],
            ['DRC Zuchtschau - 3. Meldeschluss - weitere Hunde', 'Jeder weitere Hund desselben Eigentümers', 50.00, 50.00],
            ['DRC Zuchtschau - 3. Meldeschluss - Baby/Jüngsten/Veteranen', 'Spezialklassen beim 3. Meldeschluss', 30.00, 30.00],
            ['Formwertbeurteilung', 'Einzelbeurteilung der Formwerte', 45.00, 90.00],
        ]);

        // Prüfungen und Tests
        $this->createKatalogEintraege($gebuehrenordnung2024, $pruefungGruppe, [
            ['Jagdliche Anlagensichtung (JAS)', 'Bewertung der jagdlichen Anlagen', 80.00, 120.00],
            ['Tollingprüfung NSDT-Retriever - Bronze', 'TP/Toller Bronze-Level', 80.00, 120.00],
            ['Tollingprüfung NSDT-Retriever - Silber', 'TP/Toller Silber-Level', 90.00, 130.00],
            ['Bringleistungsprüfung (BLP) - ohne Zusatzfächer', 'Standard BLP ohne Zusatzfächer', 90.00, 130.00],
            ['Bringleistungsprüfung (BLP) - mit Zusatzfächern', 'Erweiterte BLP mit Zusatzfächern', 120.00, 160.00],
            ['Retrievergebrauchsprüfung (RGP)', 'Vollständige Gebrauchsprüfung (zzgl. Gebühr lebende Ente)', 170.00, 230.00],
            ['Dr.Heraeus-Gedächtnis-Prüfung (HP/R)', 'Spezielle Gedächtnisprüfung', 150.00, 200.00],
            ['St.-John\'s-Retrieverprüfung (SRP)', 'Traditionelle St.-John\'s Prüfung', 150.00, 200.00],
            ['Prüfung nach dem Schuss (PnS)', 'Nachschussprüfung', 150.00, 210.00],
            ['Vereins-Schweißprüfung (RSw/P)', 'Schweißprüfung mit Richterbegleitung', 150.00, 210.00],
            ['Schweißprüfung ohne Richterbegleitung (SwP/o.Rb)', 'Schweißprüfung ohne Begleitung', 150.00, 210.00],
            ['Nachweis der Schussfestigkeit', 'Schussfestigkeitstest', 20.00, 32.50],
            ['Wesenstest', 'Charakterprüfung des Hundes', 45.00, 45.00],
            ['Begleithundeprüfung', 'Grundgehorsam und Sozialverhalten', 45.00, 45.00],
            ['Team-Day', 'Teamwettbewerb', 45.00, 45.00],
            ['Arbeitsprüfungen mit Dummies (APD) - pro Klasse', 'Dummy-Arbeitsprüfung einzelne Klasse', 45.00, 80.00],
            ['Workingtest - pro Klasse', 'Workingtest einzelne Klasse', 60.00, 75.00],
            ['Workingtest - Schnupperer & Veteranenklasse', 'Spezialklassen Workingtest', 45.00, 60.00],
            ['Mocktrial', 'Simulierte Jagdprüfung', 75.00, 90.00],
            ['German Cup - pro Team', 'Team-Wettbewerb German Cup', 300.00, 300.00],
            ['Newcomer Trophy', 'Nachwuchswettbewerb', 60.00, 60.00],
            ['Veteranen Cup', 'Wettbewerb für ältere Hunde', 50.00, 70.00],
            ['Workingtest-Finale', 'Finale der Workingtest-Serie', 120.00, 140.00],
            ['Einspruchsgebühr', 'Gebühr bei Einspruch gegen Prüfungsergebnis', 50.00, 50.00],
        ]);

        // Zucht und Ahnentafeln
        $this->createKatalogEintraege($gebuehrenordnung2024, $zuchtGruppe, [
            ['Erteilung Zwingerschutz', 'Schutz des Zwingernamens', 100.00, 100.00],
            ['Ablehnung/Änderung/Erweiterung Zwingerschutz', 'Bearbeitung Zwingerschutz-Änderungen', 40.00, 40.00],
            ['Zuchtzulassung je Hund', 'Zulassung zur Zucht pro Hund', 75.00, 75.00],
            ['Wurfeintragung DRC-Zuchtbuch je Welpe', 'Standard Wurfmeldung pro Welpe', 100.00, 100.00],
            ['Wurfeintragung bei verspäteter Meldung je Welpe', 'Verspätete Meldung (nach 8 Tagen) pro Welpe', 180.00, 180.00],
            ['Wurfeintragung ohne gültige Zuchtzulassung je Welpe', 'Eintragung ohne gültige Zuchtzulassung pro Welpe', 280.00, 280.00],
            ['Übernahme ins DRC-Zuchtbuch', 'Übernahme mit Ahnen bis 3. Generation', 150.00, 250.00],
            ['Ahnentafel-Zweitschrift je Hund', 'Ersatz für verlorene Ahnentafel', 100.00, 170.00],
            ['Ahnentafel-Korrektur je Hund', 'Korrektur von Ahnentafelangaben', 50.00, 100.00],
            ['Leistungsheft - Nicht DRC-Hunde', 'Leistungsheft für fremde Hunde', 35.00, 35.00],
        ]);

        // Gesundheitsuntersuchungen
        $this->createKatalogEintraege($gebuehrenordnung2024, $gesundheitGruppe, [
            ['HD-ED-Gutachten (nicht DRC-Zuchtbuch)', 'Gutachten für nicht eingetragene Hunde', 80.00, 80.00],
            ['HD-Obergutachten', 'Zweitgutachten für HD-Befunde', 100.00, 100.00],
            ['ED-Obergutachten', 'Zweitgutachten für ED-Befunde', 100.00, 100.00],
        ]);

        // Registrierung
        $this->createKatalogEintraege($gebuehrenordnung2024, $registrierungGruppe, [
            ['Bearbeitungsgebühr Registrierung', 'Grundgebühr für Registrierung', 70.00, 70.00],
            ['Wesensüberprüfung für Registrierung', 'Wesensprüfung im Rahmen der Registrierung', 45.00, 45.00],
            ['Überprüfung Rassestandard für Registrierung', 'Prüfung auf Rassekonformität', 200.00, 200.00],
            ['Registrierungsbescheinigung', 'Ausstellung der Registrierungsurkunde', 150.00, 150.00],
        ]);

        // Versandkostenpauschale für alle Zucht-/Registrierungsleistungen
        $this->createVersandkosten($gebuehrenordnung2024, $zuchtGruppe);
        $this->createVersandkosten($gebuehrenordnung2024, $registrierungGruppe);
    }

    /**
     * Erstelle Katalogeinträge und zugehörige Gebühren
     */
    private function createKatalogEintraege($gebuehrenordnung, $gruppe, $eintraege)
    {
        foreach ($eintraege as $eintrag) {
            [$name, $beschreibung, $betragMitglied, $betragNichtmitglied] = $eintrag;

            $katalogEintrag = Gebuehrenkatalog::create([
                'name' => $name,
                'beschreibung' => $beschreibung,
                'gebuehrengruppe_id' => $gruppe->id,
            ]);

            Gebuehr::create([
                'gebuehrenkatalog_id' => $katalogEintrag->id,
                'gebuehrenordnung_id' => $gebuehrenordnung->id,
                'kosten_mitglied' => $betragMitglied,
                'kosten_nichtmitglied' => $betragNichtmitglied,
                'gueltig_ab' => $gebuehrenordnung->gueltig_ab,
                'gueltig_bis' => $gebuehrenordnung->gueltig_bis,
                'aktiv' => true,
            ]);
        }
    }

    /**
     * Erstelle Versandkostenpauschale für Gruppen
     */
    private function createVersandkosten($gebuehrenordnung, $gruppe)
    {
        $katalogEintrag = Gebuehrenkatalog::create([
            'name' => 'Versandkostenpauschale',
            'beschreibung' => 'Pauschalgebühr für Versand von Dokumenten',
            'gebuehrengruppe_id' => $gruppe->id,
        ]);

        Gebuehr::create([
            'gebuehrenkatalog_id' => $katalogEintrag->id,
            'gebuehrenordnung_id' => $gebuehrenordnung->id,
            'kosten_mitglied' => 7.50,
            'kosten_nichtmitglied' => 7.50,
            'gueltig_ab' => $gebuehrenordnung->gueltig_ab,
            'gueltig_bis' => $gebuehrenordnung->gueltig_bis,
            'aktiv' => true,
        ]);
    }
}
