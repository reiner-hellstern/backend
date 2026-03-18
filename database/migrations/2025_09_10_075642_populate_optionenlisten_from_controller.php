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
        // Erst alle bestehenden Einträge löschen (falls vorhanden)
        DB::table('optionenlisten')->truncate();

        // Alle Optionenlisten aus dem OptionenController extrahiert
        $optionenlisten = [
            // ALLGEMEIN - Section ID 1
            ['name' => 'OptionAllgFreiNichtfrei', 'model' => 'App\\Models\\OptionAllgFreiNichtfrei', 'sortierung' => 'o', 'section_id' => 1],
            ['name' => 'OptionGeschlechtHund', 'model' => 'App\\Models\\OptionGeschlechtHund', 'sortierung' => 'n', 'section_id' => 1],
            ['name' => 'OptionGeschlechtPerson', 'model' => 'App\\Models\\OptionGeschlechtPerson', 'sortierung' => 'n', 'section_id' => 1],
            ['name' => 'OptionAnrede', 'model' => 'App\\Models\\OptionAnrede', 'sortierung' => 'o', 'section_id' => 1],
            ['name' => 'OptionZuchttauglichkeit', 'model' => 'App\\Models\\OptionZuchttauglichkeit', 'sortierung' => 'o', 'section_id' => 1],
            ['name' => 'OptionZuchtart', 'model' => 'App\\Models\\OptionZuchtart', 'sortierung' => 'o', 'section_id' => 1],
            ['name' => 'OptionZstBesichtigungGrund', 'model' => 'App\\Models\\OptionZstBesichtigungGrund', 'sortierung' => 'o', 'section_id' => 1],
            ['name' => 'OptionBugtrack', 'model' => 'App\\Models\\OptionBugtrack', 'sortierung' => 'n', 'section_id' => 1],
            ['name' => 'Section', 'model' => 'App\\Models\\Section', 'sortierung' => 'n', 'section_id' => 1],
            ['name' => 'OptionTodesursache', 'model' => 'App\\Models\\OptionTodesursache', 'sortierung' => 'o', 'section_id' => 1],

            // BEZAHLUNG/RECHNUNGEN - Section ID 2
            ['name' => 'OptionBezahlstatus', 'model' => 'App\\Models\\OptionBezahlstatus', 'sortierung' => 'n', 'section_id' => 2],
            ['name' => 'OptionBezahlart', 'model' => 'App\\Models\\OptionBezahlart', 'sortierung' => 'o', 'section_id' => 2],
            ['name' => 'OptionArtikelAnlagetyp', 'model' => 'App\\Models\\OptionArtikelAnlagetyp', 'sortierung' => 'o', 'section_id' => 2],

            // HUND/ZUCHT - Section ID 3
            ['name' => 'OptionTitelStatus', 'model' => 'App\\Models\\OptionTitelStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionPruefungStatus', 'model' => 'App\\Models\\OptionPruefungStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'TitelTyp', 'model' => 'App\\Models\\TitelTyp', 'sortierung' => 'n', 'section_id' => 3],
            ['name' => 'PruefungTyp', 'model' => 'App\\Models\\PruefungTyp', 'sortierung' => 'n', 'section_id' => 3],
            ['name' => 'AnwartschaftTyp', 'model' => 'App\\Models\\AnwartschaftTyp', 'sortierung' => 'n', 'section_id' => 3],
            ['name' => 'Rasse', 'model' => 'App\\Models\\Rasse', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'Farbe', 'model' => 'App\\Models\\Farbe', 'sortierung' => 'n', 'section_id' => 3],
            ['name' => 'OptionAntragStatus', 'model' => 'App\\Models\\OptionAntragStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionATStandort', 'model' => 'App\\Models\\OptionATStandort', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionATStatus', 'model' => 'App\\Models\\OptionATStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionATTyp', 'model' => 'App\\Models\\OptionATTyp', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionLHStatus', 'model' => 'App\\Models\\OptionLHStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionLHTyp', 'model' => 'App\\Models\\OptionLHTyp', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'OptionWurfStatus', 'model' => 'App\\Models\\OptionWurfStatus', 'sortierung' => 'o', 'section_id' => 3],
            ['name' => 'Tag', 'model' => 'App\\Models\\Tag', 'sortierung' => 'n', 'section_id' => 3],

            // MITGLIEDSCHAFT - Section ID 4
            ['name' => 'Beitragsarten', 'model' => 'App\\Models\\Beitragsarten', 'sortierung' => 'o', 'section_id' => 4],
            ['name' => 'Landesgruppe', 'model' => 'App\\Models\\Landesgruppe', 'sortierung' => 'n', 'section_id' => 4],
            ['name' => 'Bezirksgruppe', 'model' => 'App\\Models\\Bezirksgruppe', 'sortierung' => 'n', 'section_id' => 4],
            ['name' => 'Gruppe', 'model' => 'App\\Models\\Gruppe', 'sortierung' => 'o', 'section_id' => 4],
            ['name' => 'Mitgliedsart', 'model' => 'App\\Models\\Mitgliedsart', 'sortierung' => 'n', 'section_id' => 4],
            ['name' => 'Clubzeitung', 'model' => 'App\\Models\\Clubzeitung', 'sortierung' => 'n', 'section_id' => 4],

            // STRAFEN/VERBOTE - Section ID 5
            ['name' => 'OptionZuchtverbotEntscheider', 'model' => 'App\\Models\\OptionZuchtverbotEntscheider', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionVereinsstrafeEntscheider', 'model' => 'App\\Models\\OptionVereinsstrafeEntscheider', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionZuchtverbotGrund', 'model' => 'App\\Models\\OptionZuchtverbotGrund', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionVereinsstrafeGrund', 'model' => 'App\\Models\\OptionVereinsstrafeGrund', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionZuchtverbotStatus', 'model' => 'App\\Models\\OptionZuchtverbotStatus', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionVereinsstrafeStatus', 'model' => 'App\\Models\\OptionVereinsstrafeStatus', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionZuchtstaettenmangelEntscheider', 'model' => 'App\\Models\\OptionZuchtstaettenmangelEntscheider', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionZuchtstaettenmangelGrund', 'model' => 'App\\Models\\OptionZuchtstaettenmangelGrund', 'sortierung' => 'n', 'section_id' => 5],
            ['name' => 'OptionZuchtstaettenmangelStatus', 'model' => 'App\\Models\\OptionZuchtstaettenmangelStatus', 'sortierung' => 'n', 'section_id' => 5],

            // GESUNDHEIT/BEWERTUNGEN - Section ID 6
            ['name' => 'BewertungAugen', 'model' => 'App\\Models\\BewertungAugen', 'sortierung' => 'o', 'section_id' => 6],
            ['name' => 'BewertungGebiss', 'model' => 'App\\Models\\BewertungGebiss', 'sortierung' => 'o', 'section_id' => 6],
            ['name' => 'BewertungHoden', 'model' => 'App\\Models\\BewertungHoden', 'sortierung' => 'o', 'section_id' => 6],
            ['name' => 'BewertungED', 'model' => 'App\\Models\\BewertungED', 'sortierung' => 'o', 'section_id' => 6],
            ['name' => 'BewertungHD', 'model' => 'App\\Models\\BewertungHD', 'sortierung' => 'o', 'section_id' => 6],

            // HD/ED SCORING - Section ID 7
            ['name' => 'OptionEDScoringTyp', 'model' => 'App\\Models\\OptionEDScoringTyp', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringTyp', 'model' => 'App\\Models\\OptionHDScoringTyp', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionEDScoringDRC', 'model' => 'App\\Models\\OptionEDScoringDRC', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionEDScoringFCI', 'model' => 'App\\Models\\OptionEDScoringFCI', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringDRC', 'model' => 'App\\Models\\OptionHDScoringDRC', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringFCI', 'model' => 'App\\Models\\OptionHDScoringFCI', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringOFA', 'model' => 'App\\Models\\OptionHDScoringOFA', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringHS', 'model' => 'App\\Models\\OptionHDScoringHS', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringNL', 'model' => 'App\\Models\\OptionHDScoringNL', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringFI', 'model' => 'App\\Models\\OptionHDScoringFI', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringCH', 'model' => 'App\\Models\\OptionHDScoringCH', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDScoringSW', 'model' => 'App\\Models\\OptionHDScoringSW', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionEDArthrosegrad', 'model' => 'App\\Models\\OptionEDArthrosegrad', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDEDAblehnungGrund', 'model' => 'App\\Models\\OptionHDEDAblehnungGrund', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDEDRoentgenbilderArt', 'model' => 'App\\Models\\OptionHDEDRoentgenbilderArt', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDEDBeurteilungStatus', 'model' => 'App\\Models\\OptionHDEDBeurteilungStatus', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDUebergangswirbel', 'model' => 'App\\Models\\OptionHDUebergangswirbel', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDWinkelmessungNorberg', 'model' => 'App\\Models\\OptionHDWinkelmessungNorberg', 'sortierung' => 'o', 'section_id' => 7],
            ['name' => 'OptionHDEDCTGrund', 'model' => 'App\\Models\\OptionHDEDCTGrund', 'sortierung' => 'o', 'section_id' => 7],

            // ANDERE GESUNDHEITSUNTERSUCHUNGEN - Section ID 8
            ['name' => 'OptionOCDUntersuchungsgrund', 'model' => 'App\\Models\\OptionOCDUntersuchungsgrund', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionCoronoidUntersuchungsgrund', 'model' => 'App\\Models\\OptionCoronoidUntersuchungsgrund', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionGelenkuntersuchungTyp', 'model' => 'App\\Models\\OptionGelenkuntersuchungTyp', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionFcpGrund', 'model' => 'App\\Models\\OptionFcpGrund', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionRuteFehlbildung', 'model' => 'App\\Models\\OptionRuteFehlbildung', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionPatellaLuxationScoring', 'model' => 'App\\Models\\OptionPatellaLuxationScoring', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionEktoperUreter', 'model' => 'App\\Models\\OptionEktoperUreter', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionHodenTastbarkeit', 'model' => 'App\\Models\\OptionHodenTastbarkeit', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionHodenSenkung', 'model' => 'App\\Models\\OptionHodenSenkung', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionHodenQuelle', 'model' => 'App\\Models\\OptionHodenQuelle', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionKastrationSterilisation', 'model' => 'App\\Models\\OptionKastrationSterilisation', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionKardioBefund', 'model' => 'App\\Models\\OptionKardioBefund', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionKardioUntersuchungsart', 'model' => 'App\\Models\\OptionKardioUntersuchungsart', 'sortierung' => 'o', 'section_id' => 8],
            ['name' => 'OptionKaiserschnittQuelle', 'model' => 'App\\Models\\OptionKaiserschnittQuelle', 'sortierung' => 'o', 'section_id' => 8],

            // GENTESTS - Section ID 9
            ['name' => 'OptionGentestStd', 'model' => 'App\\Models\\OptionGentestStd', 'sortierung' => 'o', 'section_id' => 9],
            ['name' => 'OptionGentestFarbeGelb', 'model' => 'App\\Models\\OptionGentestFarbeGelb', 'sortierung' => 'o', 'section_id' => 9],
            ['name' => 'OptionGentestFarbeBraun', 'model' => 'App\\Models\\OptionGentestFarbeBraun', 'sortierung' => 'o', 'section_id' => 9],
            ['name' => 'OptionGentestFarbverduennung', 'model' => 'App\\Models\\OptionGentestFarbverduennung', 'sortierung' => 'o', 'section_id' => 9],
            ['name' => 'OptionGentestHaarlaenge', 'model' => 'App\\Models\\OptionGentestHaarlaenge', 'sortierung' => 'o', 'section_id' => 9],

            // ZAHNSTATUS - Section ID 10
            ['name' => 'OptionZSZahnzustand', 'model' => 'App\\Models\\OptionZSZahnzustand', 'sortierung' => 'o', 'section_id' => 10],
            ['name' => 'OptionZSZahnzustandI', 'model' => 'App\\Models\\OptionZSZahnzustandI', 'sortierung' => 'o', 'section_id' => 10],
            ['name' => 'OptionZSGebiss', 'model' => 'App\\Models\\OptionZSGebiss', 'sortierung' => 'o', 'section_id' => 10],
            ['name' => 'OptionZSQuelle', 'model' => 'App\\Models\\OptionZSQuelle', 'sortierung' => 'o', 'section_id' => 10],

            // AUGENUNTERSUCHUNG - Section ID 11
            ['name' => 'OptionAUTyp', 'model' => 'App\\Models\\OptionAUTyp', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUCEAForm', 'model' => 'App\\Models\\OptionAUCEAForm', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUICAAGrad', 'model' => 'App\\Models\\OptionAUICAAGrad', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUPHTVLGrad', 'model' => 'App\\Models\\OptionAUPHTVLGrad', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAURDForm', 'model' => 'App\\Models\\OptionAURDForm', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUMPPLocation', 'model' => 'App\\Models\\OptionAUMPPLocation', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUKataraktForm', 'model' => 'App\\Models\\OptionAUKataraktForm', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAULid', 'model' => 'App\\Models\\OptionAULid', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUErbZweifel', 'model' => 'App\\Models\\OptionAUErbZweifel', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUErbVorlaeufig', 'model' => 'App\\Models\\OptionAUErbVorlaeufig', 'sortierung' => 'o', 'section_id' => 11],
            ['name' => 'OptionAUErblich', 'model' => 'App\\Models\\OptionAUErblich', 'sortierung' => 'o', 'section_id' => 11],

            // VERANSTALTUNGEN ALLGEMEIN - Section ID 12
            ['name' => 'Veranstaltungskategorie', 'model' => 'App\\Models\\Veranstaltungskategorie', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'Veranstaltungstyp', 'model' => 'App\\Models\\Veranstaltungstyp', 'sortierung' => 'n', 'section_id' => 12],
            ['name' => 'OptionVaMeldeunterlagenNichtJagdlich', 'model' => 'App\\Models\\OptionVaMeldeunterlagenNichtJagdlich', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaMeldeunterlagenJagdlich', 'model' => 'App\\Models\\OptionVaMeldeunterlagenJagdlich', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaAnmeldeoption', 'model' => 'App\\Models\\OptionVaAnmeldeoption', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaMeldeoption', 'model' => 'App\\Models\\OptionVaMeldeoption', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaZahlungsoption', 'model' => 'App\\Models\\OptionVaZahlungsoption', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenBlp', 'model' => 'App\\Models\\OptionVaVoraussetzungenBlp', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenHpr', 'model' => 'App\\Models\\OptionVaVoraussetzungenHpr', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenHprAp', 'model' => 'App\\Models\\OptionVaVoraussetzungenHprAp', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenRgp', 'model' => 'App\\Models\\OptionVaVoraussetzungenRgp', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenSrp', 'model' => 'App\\Models\\OptionVaVoraussetzungenSrp', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenTpbronze', 'model' => 'App\\Models\\OptionVaVoraussetzungenTpbronze', 'sortierung' => 'o', 'section_id' => 12],
            ['name' => 'OptionVaVoraussetzungenTpsilber', 'model' => 'App\\Models\\OptionVaVoraussetzungenTpsilber', 'sortierung' => 'o', 'section_id' => 12],

            // APDR1 PRÜFUNG - Section ID 13
            ['name' => 'OptionAPDR1Test1Ausfuehrung', 'model' => 'App\\Models\\OptionAPDR1Test1Ausfuehrung', 'sortierung' => 'o', 'section_id' => 13],
            ['name' => 'OptionAPDR1Test2Ausfuehrung', 'model' => 'App\\Models\\OptionAPDR1Test2Ausfuehrung', 'sortierung' => 'o', 'section_id' => 13],
            ['name' => 'OptionAPDR1Test3Ausfuehrung', 'model' => 'App\\Models\\OptionAPDR1Test3Ausfuehrung', 'sortierung' => 'o', 'section_id' => 13],
            ['name' => 'OptionAPDR1Test4Ausfuehrung', 'model' => 'App\\Models\\OptionAPDR1Test4Ausfuehrung', 'sortierung' => 'o', 'section_id' => 13],
            ['name' => 'OptionAPDR1Resultat', 'model' => 'App\\Models\\OptionAPDR1Resultat', 'sortierung' => 'o', 'section_id' => 13],
            ['name' => 'OptionAPDR1Ausschlussgrund', 'model' => 'App\\Models\\OptionAPDR1Ausschlussgrund', 'sortierung' => 'o', 'section_id' => 13],

            // BLP1 PRÜFUNG - Section ID 14
            ['name' => 'OptionBLP1KoerperlicheMaengel', 'model' => 'App\\Models\\OptionBLP1KoerperlicheMaengel', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Schussfestigkeit', 'model' => 'App\\Models\\OptionBLP1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Selbstsicherheit', 'model' => 'App\\Models\\OptionBLP1Selbstsicherheit', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1SonstigesVerhalten', 'model' => 'App\\Models\\OptionBLP1SonstigesVerhalten', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Temperament', 'model' => 'App\\Models\\OptionBLP1Temperament', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Vertraeglichkeit', 'model' => 'App\\Models\\OptionBLP1Vertraeglichkeit', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Wasserarbeit', 'model' => 'App\\Models\\OptionBLP1Wasserarbeit', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Wertungspunkte10', 'model' => 'App\\Models\\OptionBLP1Wertungspunkte10', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Wertungspunkte11', 'model' => 'App\\Models\\OptionBLP1Wertungspunkte11', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Wertungspunkte12', 'model' => 'App\\Models\\OptionBLP1Wertungspunkte12', 'sortierung' => 'o', 'section_id' => 14],
            ['name' => 'OptionBLP1Wildschleppe', 'model' => 'App\\Models\\OptionBLP1Wildschleppe', 'sortierung' => 'o', 'section_id' => 14],

            // FORMWERT PRÜFUNGEN - Section ID 15
            ['name' => 'OptionFormwert1Augenfarbe', 'model' => 'App\\Models\\OptionFormwert1Augenfarbe', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Augenform', 'model' => 'App\\Models\\OptionFormwert1Augenform', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Ausdruck', 'model' => 'App\\Models\\OptionFormwert1Ausdruck', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Behaenge', 'model' => 'App\\Models\\OptionFormwert1Behaenge', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Brust', 'model' => 'App\\Models\\OptionFormwert1Brust', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Brusttiefe', 'model' => 'App\\Models\\OptionFormwert1Brusttiefe', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Ellenbogen', 'model' => 'App\\Models\\OptionFormwert1Ellenbogen', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Fang', 'model' => 'App\\Models\\OptionFormwert1Fang', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Gebiss', 'model' => 'App\\Models\\OptionFormwert1Gebiss', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Gesamterscheinung', 'model' => 'App\\Models\\OptionFormwert1Gesamterscheinung', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Geschlechterpraege', 'model' => 'App\\Models\\OptionFormwert1Geschlechterpraege', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Hals', 'model' => 'App\\Models\\OptionFormwert1Hals', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Hinterhand', 'model' => 'App\\Models\\OptionFormwert1Hinterhand', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Hinterlaeufe', 'model' => 'App\\Models\\OptionFormwert1Hinterlaeufe', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Hoden', 'model' => 'App\\Models\\OptionFormwert1Hoden', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Knochenstaerke', 'model' => 'App\\Models\\OptionFormwert1Knochenstaerke', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Kondition', 'model' => 'App\\Models\\OptionFormwert1Kondition', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Kruppe', 'model' => 'App\\Models\\OptionFormwert1Kruppe', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Kopf', 'model' => 'App\\Models\\OptionFormwert1Kopf', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Lenden', 'model' => 'App\\Models\\OptionFormwert1Lenden', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Oberarme', 'model' => 'App\\Models\\OptionFormwert1Oberarme', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Oberkopf', 'model' => 'App\\Models\\OptionFormwert1Oberkopf', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Oberlefzen', 'model' => 'App\\Models\\OptionFormwert1Oberlefzen', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Pfoten', 'model' => 'App\\Models\\OptionFormwert1Pfoten', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Pigmentierung', 'model' => 'App\\Models\\OptionFormwert1Pigmentierung', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Ruecken', 'model' => 'App\\Models\\OptionFormwert1Ruecken', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Rute', 'model' => 'App\\Models\\OptionFormwert1Rute', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Schultern', 'model' => 'App\\Models\\OptionFormwert1Schultern', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Stop', 'model' => 'App\\Models\\OptionFormwert1Stop', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Unterlefzen', 'model' => 'App\\Models\\OptionFormwert1Unterlefzen', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Verhalten', 'model' => 'App\\Models\\OptionFormwert1Verhalten', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Vorbrust', 'model' => 'App\\Models\\OptionFormwert1Vorbrust', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Vorderhand', 'model' => 'App\\Models\\OptionFormwert1Vorderhand', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Vorderlaeufe', 'model' => 'App\\Models\\OptionFormwert1Vorderlaeufe', 'sortierung' => 'o', 'section_id' => 15],
            ['name' => 'OptionFormwert1Winkelung', 'model' => 'App\\Models\\OptionFormwert1Winkelung', 'sortierung' => 'o', 'section_id' => 15],

            // HPR PRÜFUNGEN - Section ID 16
            ['name' => 'OptionHPR1Gesamtpraedikat', 'model' => 'App\\Models\\OptionHPR1Gesamtpraedikat', 'sortierung' => 'o', 'section_id' => 16],
            ['name' => 'OptionHPR1Praedikat', 'model' => 'App\\Models\\OptionHPR1Praedikat', 'sortierung' => 'o', 'section_id' => 16],

            // JAS PRÜFUNGEN - Section ID 17
            ['name' => 'OptionJAS1Punkte12', 'model' => 'App\\Models\\OptionJAS1Punkte12', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Punkte13', 'model' => 'App\\Models\\OptionJAS1Punkte13', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Schussfestigkeit', 'model' => 'App\\Models\\OptionJAS1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1SonstigesVerhalten', 'model' => 'App\\Models\\OptionJAS1SonstigesVerhalten', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Selbstsicherheit', 'model' => 'App\\Models\\OptionJAS1Selbstsicherheit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Temperament', 'model' => 'App\\Models\\OptionJAS1Temperament', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Verhaltensvermerk', 'model' => 'App\\Models\\OptionJAS1Verhaltensvermerk', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Vertraeglichkeit', 'model' => 'App\\Models\\OptionJAS1Vertraeglichkeit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS1Wild', 'model' => 'App\\Models\\OptionJAS1Wild', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Praedikate', 'model' => 'App\\Models\\OptionJAS2Praedikate', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Aufgabenbewertung', 'model' => 'App\\Models\\OptionJAS2Aufgabenbewertung', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Schussfestigkeit', 'model' => 'App\\Models\\OptionJAS2Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Selbstsicherheit', 'model' => 'App\\Models\\OptionJAS2Selbstsicherheit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2SonstigesVerhalten', 'model' => 'App\\Models\\OptionJAS2SonstigesVerhalten', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Temperament', 'model' => 'App\\Models\\OptionJAS2Temperament', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Vertraeglichkeit', 'model' => 'App\\Models\\OptionJAS2Vertraeglichkeit', 'sortierung' => 'o', 'section_id' => 17],
            ['name' => 'OptionJAS2Wild', 'model' => 'App\\Models\\OptionJAS2Wild', 'sortierung' => 'o', 'section_id' => 17],

            // WEITERE PRÜFUNGSTYPEN - Section ID 18
            ['name' => 'OptionMockTrail1Ausschlussgrund', 'model' => 'App\\Models\\OptionMockTrail1Ausschlussgrund', 'sortierung' => 'o', 'section_id' => 18],
            ['name' => 'OptionPNS1Leistungsziffer', 'model' => 'App\\Models\\OptionPNS1Leistungsziffer', 'sortierung' => 'o', 'section_id' => 18],

            // PRÜFUNGSLEITERBERICHTE - Section ID 19
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Bodenzustand', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Bodenzustand', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Fachrichtergruppen', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Fachrichtergruppen', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Faehrte', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Faehrte', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Faehrtenzeit', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Faehrtenzeit', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Federwild', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Federwild', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Fuchs', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Fuchs', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Haarwild', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Haarwild', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Pruefungen', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Pruefungen', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Pruefungsgelaende', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Pruefungsgelaende', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Temperatur', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Temperatur', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Wildarten', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Wildarten', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Wind', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Wind', 'sortierung' => 'o', 'section_id' => 19],
            ['name' => 'OptionPruefungsleiterberichtJagdlich1Wetter', 'model' => 'App\\Models\\OptionPruefungsleiterberichtJagdlich1Wetter', 'sortierung' => 'o', 'section_id' => 19],

            // RGP PRÜFUNGEN - Section ID 20
            ['name' => 'OptionRGP1Bestandenzusatz', 'model' => 'App\\Models\\OptionRGP1Bestandenzusatz', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1KoerperlicheMaengel', 'model' => 'App\\Models\\OptionRGP1KoerperlicheMaengel', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1Leistungsziffer', 'model' => 'App\\Models\\OptionRGP1Leistungsziffer', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1Preisklassen', 'model' => 'App\\Models\\OptionRGP1Preisklassen', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1Schussfestigkeit', 'model' => 'App\\Models\\OptionRGP1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1Wasserarbeit', 'model' => 'App\\Models\\OptionRGP1Wasserarbeit', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP1Wesenverhalten', 'model' => 'App\\Models\\OptionRGP1Wesenverhalten', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Bestandenzusatz', 'model' => 'App\\Models\\OptionRGP2Bestandenzusatz', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2KoerperlicheMaengel', 'model' => 'App\\Models\\OptionRGP2KoerperlicheMaengel', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Leistungsziffer', 'model' => 'App\\Models\\OptionRGP2Leistungsziffer', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Preisklassen', 'model' => 'App\\Models\\OptionRGP2Preisklassen', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Schussfestigkeit', 'model' => 'App\\Models\\OptionRGP2Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Wasserarbeit', 'model' => 'App\\Models\\OptionRGP2Wasserarbeit', 'sortierung' => 'o', 'section_id' => 20],
            ['name' => 'OptionRGP2Wesenverhalten', 'model' => 'App\\Models\\OptionRGP2Wesenverhalten', 'sortierung' => 'o', 'section_id' => 20],

            // SRP/RSWP PRÜFUNGEN - Section ID 21
            ['name' => 'OptionSRP1Wertungspunkte', 'model' => 'App\\Models\\OptionSRP1Wertungspunkte', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionSRP1Praedikate', 'model' => 'App\\Models\\OptionSRP1Praedikate', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWP1Praedikate', 'model' => 'App\\Models\\OptionRSWP1Praedikate', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWP1Preisklassen', 'model' => 'App\\Models\\OptionRSWP1Preisklassen', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWP1Hundetyp', 'model' => 'App\\Models\\OptionRSWP1Hundetyp', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWP1Todesursache', 'model' => 'App\\Models\\OptionRSWP1Todesursache', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWP1Wild', 'model' => 'App\\Models\\OptionRSWP1Wild', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWPORB1Preisklassen', 'model' => 'App\\Models\\OptionRSWPORB1Preisklassen', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWPORB1Praedikate', 'model' => 'App\\Models\\OptionRSWPORB1Praedikate', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWPORB1Hundetyp', 'model' => 'App\\Models\\OptionRSWPORB1Hundetyp', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWPORB1Todesursache', 'model' => 'App\\Models\\OptionRSWPORB1Todesursache', 'sortierung' => 'o', 'section_id' => 21],
            ['name' => 'OptionRSWPORB1Wild', 'model' => 'App\\Models\\OptionRSWPORB1Wild', 'sortierung' => 'o', 'section_id' => 21],

            // SCHUSSTEST - Section ID 22
            ['name' => 'OptionSchusstest1Schussfestigkeit', 'model' => 'App\\Models\\OptionSchusstest1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 22],
            ['name' => 'OptionSchusstest1Beschwichtigungsverhalten', 'model' => 'App\\Models\\OptionSchusstest1Beschwichtigungsverhalten', 'sortierung' => 'o', 'section_id' => 22],
            ['name' => 'OptionSchusstest1Schreckhaftigkeit', 'model' => 'App\\Models\\OptionSchusstest1Schreckhaftigkeit', 'sortierung' => 'o', 'section_id' => 22],

            // TOLLER PRÜFUNGEN - Section ID 23
            ['name' => 'OptionTPTollerBronze1KoerperlicheMaengel', 'model' => 'App\\Models\\OptionTPTollerBronze1KoerperlicheMaengel', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerBronze1Leistungsziffer', 'model' => 'App\\Models\\OptionTPTollerBronze1Leistungsziffer', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerBronze1Schussfestigkeit', 'model' => 'App\\Models\\OptionTPTollerBronze1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerBronze1Verhaltensweisen', 'model' => 'App\\Models\\OptionTPTollerBronze1Verhaltensweisen', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Gesamturteil', 'model' => 'App\\Models\\OptionTPTollerSilber1Gesamturteil', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1KoerperlicheMaengel', 'model' => 'App\\Models\\OptionTPTollerSilber1KoerperlicheMaengel', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Punkte11', 'model' => 'App\\Models\\OptionTPTollerSilber1Punkte11', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Schussfestigkeit', 'model' => 'App\\Models\\OptionTPTollerSilber1Schussfestigkeit', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Selbstsicherheit', 'model' => 'App\\Models\\OptionTPTollerSilber1Selbstsicherheit', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1SonstigesVerhalten', 'model' => 'App\\Models\\OptionTPTollerSilber1SonstigesVerhalten', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Temperament', 'model' => 'App\\Models\\OptionTPTollerSilber1Temperament', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Vertraeglichkeit', 'model' => 'App\\Models\\OptionTPTollerSilber1Vertraeglichkeit', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Wasserarbeit', 'model' => 'App\\Models\\OptionTPTollerSilber1Wasserarbeit', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Wertungspunkte11', 'model' => 'App\\Models\\OptionTPTollerSilber1Wertungspunkte11', 'sortierung' => 'o', 'section_id' => 23],
            ['name' => 'OptionTPTollerSilber1Wertungspunkte12', 'model' => 'App\\Models\\OptionTPTollerSilber1Wertungspunkte12', 'sortierung' => 'o', 'section_id' => 23],

            // WESENSTEST - Section ID 24
            ['name' => 'OptionWesenstest1Aggressionsverhalten', 'model' => 'App\\Models\\OptionWesenstest1Aggressionsverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Aktivitaet', 'model' => 'App\\Models\\OptionWesenstest1Aktivitaet', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1ArbeitSport', 'model' => 'App\\Models\\OptionWesenstest1ArbeitSport', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1BegruendungNichtBestanden', 'model' => 'App\\Models\\OptionWesenstest1BegruendungNichtBestanden', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Beruehrung', 'model' => 'App\\Models\\OptionWesenstest1Beruehrung', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Beschwichtigungsverhalten', 'model' => 'App\\Models\\OptionWesenstest1Beschwichtigungsverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Beuteverhalten', 'model' => 'App\\Models\\OptionWesenstest1Beuteverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Neugierverhalten', 'model' => 'App\\Models\\OptionWesenstest1Neugierverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Pruefungen', 'model' => 'App\\Models\\OptionWesenstest1Pruefungen', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Schreckhaftigkeit', 'model' => 'App\\Models\\OptionWesenstest1Schreckhaftigkeit', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Sozialverhalten', 'model' => 'App\\Models\\OptionWesenstest1Sozialverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Spielverhalten', 'model' => 'App\\Models\\OptionWesenstest1Spielverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Suchverhalten', 'model' => 'App\\Models\\OptionWesenstest1Suchverhalten', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1TragenZutragen', 'model' => 'App\\Models\\OptionWesenstest1TragenZutragen', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Urteil', 'model' => 'App\\Models\\OptionWesenstest1Urteil', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Umwelterfahrungen', 'model' => 'App\\Models\\OptionWesenstest1Umwelterfahrungen', 'sortierung' => 'o', 'section_id' => 24],
            ['name' => 'OptionWesenstest1Vorpruefungen', 'model' => 'App\\Models\\OptionWesenstest1Vorpruefungen', 'sortierung' => 'o', 'section_id' => 24],

            // WESENSTEST 2 - Section ID 25
            ['name' => 'OptionWesenstest2Aggressionsverhalten', 'model' => 'App\\Models\\OptionWesenstest2Aggressionsverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Aktivitaet', 'model' => 'App\\Models\\OptionWesenstest2Aktivitaet', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2ArbeitSport', 'model' => 'App\\Models\\OptionWesenstest2ArbeitSport', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2BegruendungNichtBestanden', 'model' => 'App\\Models\\OptionWesenstest2BegruendungNichtBestanden', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Beruehrung', 'model' => 'App\\Models\\OptionWesenstest2Beruehrung', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Beschwichtigungsverhalten', 'model' => 'App\\Models\\OptionWesenstest2Beschwichtigungsverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Beuteverhalten', 'model' => 'App\\Models\\OptionWesenstest2Beuteverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Neugierverhalten', 'model' => 'App\\Models\\OptionWesenstest2Neugierverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Pruefungen', 'model' => 'App\\Models\\OptionWesenstest2Pruefungen', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Schreckhaftigkeit', 'model' => 'App\\Models\\OptionWesenstest2Schreckhaftigkeit', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Sozialverhalten', 'model' => 'App\\Models\\OptionWesenstest2Sozialverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Spielverhalten', 'model' => 'App\\Models\\OptionWesenstest2Spielverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Suchverhalten', 'model' => 'App\\Models\\OptionWesenstest2Suchverhalten', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2TragenZutragen', 'model' => 'App\\Models\\OptionWesenstest2TragenZutragen', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Urteil', 'model' => 'App\\Models\\OptionWesenstest2Urteil', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Umwelterfahrungen', 'model' => 'App\\Models\\OptionWesenstest2Umwelterfahrungen', 'sortierung' => 'o', 'section_id' => 25],
            ['name' => 'OptionWesenstest2Vorpruefungen', 'model' => 'App\\Models\\OptionWesenstest2Vorpruefungen', 'sortierung' => 'o', 'section_id' => 25],

            // ZUSÄTZLICHE MODELS AUS WEBINDEX - Section ID 26
            ['name' => 'OptionZstBesichtigungStatus', 'model' => 'App\\Models\\OptionZstBesichtigungStatus', 'sortierung' => 'o', 'section_id' => 26],

            // TPTollerBronze1 SPEZIAL - Section ID 27 (missing from earlier)
            ['name' => 'OptionTPTollerBronze1Wertungspunkte4', 'model' => 'App\\Models\\OptionTPTollerBronze1Wertungspunkte4', 'sortierung' => 'o', 'section_id' => 27],

            // BHP1 PRÜFUNGEN - Section ID 28
            ['name' => 'OptionBHP1Gesamtbeurteilungen', 'model' => 'App\\Models\\OptionBHP1Gesamtbeurteilungen', 'sortierung' => 'o', 'section_id' => 28],
            ['name' => 'OptionBHP1VerhaltenUnbefangenheiten', 'model' => 'App\\Models\\OptionBHP1VerhaltenUnbefangenheiten', 'sortierung' => 'o', 'section_id' => 28],

            // WEITERE MISSING MODELS - Section ID 29
            ['name' => 'OptionEDScoringLang', 'model' => 'App\\Models\\OptionEDScoringLang', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionEDScoringOfel', 'model' => 'App\\Models\\OptionEDScoringOfel', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionEDScoringTypen', 'model' => 'App\\Models\\OptionEDScoringTypen', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionEktoperUreterScorings', 'model' => 'App\\Models\\OptionEktoperUreterScorings', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionOCDScoring', 'model' => 'App\\Models\\OptionOCDScoring', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionHDEDTypen', 'model' => 'App\\Models\\OptionHDEDTypen', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionBLP1Wertungspunkte', 'model' => 'App\\Models\\OptionBLP1Wertungspunkte', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionVaStartklassen', 'model' => 'App\\Models\\OptionVaStartklassen', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionPruefungenKlassen', 'model' => 'App\\Models\\OptionPruefungenKlassen', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionZuchtstaetteStati', 'model' => 'App\\Models\\OptionZuchtstaetteStati', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionZuchtzulassungStati', 'model' => 'App\\Models\\OptionZuchtzulassungStati', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionHDScoringSV', 'model' => 'App\\Models\\OptionHDScoringSV', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionBLP1Wertungspunkte4', 'model' => 'App\\Models\\OptionBLP1Wertungspunkte4', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionGentestAbgeleitet', 'model' => 'App\\Models\\OptionGentestAbgeleitet', 'sortierung' => 'o', 'section_id' => 29],
            ['name' => 'OptionGentestAlle', 'model' => 'App\\Models\\OptionGentestAlle', 'sortierung' => 'o', 'section_id' => 29],
        ];

        // Jetzt alle Einträge einfügen
        foreach ($optionenlisten as $option) {
            DB::table('optionenlisten')->insert([
                'name' => $option['name'],
                'model' => $option['model'],
                'sortierung' => $option['sortierung'],
                'section_id' => $option['section_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Alle eingefügten Einträge wieder löschen
        DB::table('optionenlisten')->truncate();
    }
};
