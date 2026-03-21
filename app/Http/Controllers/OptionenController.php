<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnwartschaftTypResource;
use App\Http\Resources\BeitragsartResource;
use App\Http\Resources\BezirksgruppeResource;
use App\Http\Resources\FarbeResource;
use App\Http\Resources\LandesgruppeResource;
use App\Http\Resources\MitgliedsartResource;
use App\Http\Resources\OptionNameArrayResource;
use App\Http\Resources\OptionNameIconColorResource;
use App\Http\Resources\OptionNameResource;
use App\Http\Resources\PruefungenIdResource;
use App\Http\Resources\PruefungTypResource;
use App\Http\Resources\RasseResource;
use App\Http\Resources\TitelTypResource;
// use App\Models\Bezahlart;
// use App\Http\Resources\BezahlartResource;
use App\Http\Resources\VeranstaltungstypResource;
use App\Models\AnwartschaftTyp;
use App\Models\Ausbildertyp;
use App\Models\Beitragsarten;
use App\Models\BewertungAugen;
use App\Models\BewertungED;
use App\Models\BewertungGebiss;
use App\Models\BewertungHD;
use App\Models\BewertungHoden;
use App\Models\Bezirksgruppe;
use App\Models\Clubzeitung;
use App\Models\Fachgebiet;
use App\Models\Farbe;
use App\Models\Gruppe;
use App\Models\Landesgruppe;
use App\Models\Mitgliedsart;
use App\Models\OptionAllgFreiNichtfrei;
use App\Models\OptionAnrede;
use App\Models\OptionAntragStatus;
use App\Models\OptionAPDR1Ausschlussgrund;
use App\Models\OptionAPDR1Resultat;
use App\Models\OptionAPDR1Test1Ausfuehrung;
use App\Models\OptionAPDR1Test2Ausfuehrung;
use App\Models\OptionAPDR1Test3Ausfuehrung;
use App\Models\OptionAPDR1Test4Ausfuehrung;
use App\Models\OptionArtikelAnlagetyp;
use App\Models\OptionATStandort;
use App\Models\OptionATStatus;
use App\Models\OptionATTyp;
use App\Models\OptionAUCEAForm;
use App\Models\OptionAUErblich;
use App\Models\OptionAUErbVorlaeufig;
use App\Models\OptionAUErbZweifel;
use App\Models\OptionAufgabeStatus;
use App\Models\OptionAUICAAGrad;
use App\Models\OptionAUKataraktForm;
use App\Models\OptionAULid;
use App\Models\OptionAUMPPLocation;
use App\Models\OptionAUPHTVLGrad;
use App\Models\OptionAURDForm;
use App\Models\OptionAusbilderausweisStatus;
use App\Models\OptionAusbilderStatus;
use App\Models\OptionAUTyp;
use App\Models\OptionBezahlart;
use App\Models\OptionBezahlstatus;
use App\Models\OptionBLP1KoerperlicheMaengel;
use App\Models\OptionBLP1Schussfestigkeit;
use App\Models\OptionBLP1Selbstsicherheit;
use App\Models\OptionBLP1SonstigesVerhalten;
use App\Models\OptionBLP1Temperament;
use App\Models\OptionBLP1Vertraeglichkeit;
use App\Models\OptionBLP1Wasserarbeit;
use App\Models\OptionBLP1Wertungspunkte10;
use App\Models\OptionBLP1Wertungspunkte11;
use App\Models\OptionBLP1Wertungspunkte12;
use App\Models\OptionBLP1Wildschleppe;
use App\Models\OptionBugtrack;
use App\Models\OptionCoronoidUntersuchungsgrund;
use App\Models\OptionEDArthrosegrad;
use App\Models\OptionEDScoringDRC;
use App\Models\OptionEDScoringFCI;
use App\Models\OptionEDScoringTyp;
use App\Models\OptionEktoperUreter;
use App\Models\Optionen;
use App\Models\OptionFcpGrund;
use App\Models\OptionFormwert1Augenfarbe;
use App\Models\OptionFormwert1Augenform;
use App\Models\OptionFormwert1Ausdruck;
use App\Models\OptionFormwert1Behaenge;
use App\Models\OptionFormwert1Brust;
use App\Models\OptionFormwert1Brusttiefe;
use App\Models\OptionFormwert1Ellenbogen;
use App\Models\OptionFormwert1Fang;
use App\Models\OptionFormwert1Gebiss;
use App\Models\OptionFormwert1Gesamterscheinung;
use App\Models\OptionFormwert1Geschlechterpraege;
use App\Models\OptionFormwert1Hals;
use App\Models\OptionFormwert1Hinterhand;
use App\Models\OptionFormwert1Hinterlaeufe;
use App\Models\OptionFormwert1Hoden;
use App\Models\OptionFormwert1Knochenstaerke;
use App\Models\OptionFormwert1Kondition;
use App\Models\OptionFormwert1Kopf;
use App\Models\OptionFormwert1Kruppe;
use App\Models\OptionFormwert1Lenden;
use App\Models\OptionFormwert1Oberarme;
use App\Models\OptionFormwert1Oberkopf;
use App\Models\OptionFormwert1Oberlefzen;
use App\Models\OptionFormwert1Pfoten;
use App\Models\OptionFormwert1Pigmentierung;
use App\Models\OptionFormwert1Ruecken;
use App\Models\OptionFormwert1Rute;
use App\Models\OptionFormwert1Schultern;
use App\Models\OptionFormwert1Stop;
use App\Models\OptionFormwert1Unterlefzen;
use App\Models\OptionFormwert1Verhalten;
use App\Models\OptionFormwert1Vorbrust;
use App\Models\OptionFormwert1Vorderhand;
use App\Models\OptionFormwert1Vorderlaeufe;
use App\Models\OptionFormwert1Winkelung;
use App\Models\OptionGelenkuntersuchungTyp;
use App\Models\OptionGentestFarbeBraun;
use App\Models\OptionGentestFarbeGelb;
use App\Models\OptionGentestFarbverduennung;
use App\Models\OptionGentestHaarlaenge;
use App\Models\OptionGentestStd;
use App\Models\OptionGeschlechtHund;
use App\Models\OptionGeschlechtPerson;
use App\Models\OptionHDEDAblehnungGrund;
use App\Models\OptionHDEDBeurteilungStatus;
use App\Models\OptionHDEDCTGrund;
use App\Models\OptionHDEDRoentgenbilderArt;
use App\Models\OptionHDScoringCH;
use App\Models\OptionHDScoringDRC;
use App\Models\OptionHDScoringFCI;
use App\Models\OptionHDScoringFI;
use App\Models\OptionHDScoringHS;
use App\Models\OptionHDScoringNL;
use App\Models\OptionHDScoringOFA;
use App\Models\OptionHDScoringSW;
use App\Models\OptionHDScoringTyp;
use App\Models\OptionHDUebergangswirbel;
use App\Models\OptionHDWinkelmessungNorberg;
use App\Models\OptionHodenQuelle;
use App\Models\OptionHodenSenkung;
use App\Models\OptionHodenTastbarkeit;
use App\Models\OptionHPR1Gesamtpraedikat;
use App\Models\OptionHPR1Praedikat;
use App\Models\OptionJAS1Punkte12;
use App\Models\OptionJAS1Punkte13;
use App\Models\OptionJAS1Schussfestigkeit;
use App\Models\OptionJAS1Selbstsicherheit;
use App\Models\OptionJAS1SonstigesVerhalten;
use App\Models\OptionJAS1Temperament;
use App\Models\OptionJAS1Verhaltensvermerk;
use App\Models\OptionJAS1Vertraeglichkeit;
use App\Models\OptionJAS1Wild;
use App\Models\OptionJAS2Aufgabenbewertung;
use App\Models\OptionJAS2Praedikate;
use App\Models\OptionJAS2Schussfestigkeit;
use App\Models\OptionJAS2Selbstsicherheit;
use App\Models\OptionJAS2SonstigesVerhalten;
use App\Models\OptionJAS2Temperament;
use App\Models\OptionJAS2Vertraeglichkeit;
use App\Models\OptionJAS2Wild;
use App\Models\OptionKaiserschnittQuelle;
use App\Models\OptionKardioBefund;
use App\Models\OptionKardioUntersuchungsart;
use App\Models\OptionKastrationSterilisation;
use App\Models\OptionLHStatus;
use App\Models\OptionLHTyp;
use App\Models\OptionMGStatus;
use App\Models\OptionMockTrail1Ausschlussgrund;
use App\Models\OptionOCDUntersuchungsgrund;
use App\Models\OptionPatellaLuxationScoring;
use App\Models\OptionPNS1Leistungsziffer;
use App\Models\OptionPruefungsleiterberichtJagdlich1Bodenzustand;
use App\Models\OptionPruefungsleiterberichtJagdlich1Fachrichtergruppen;
use App\Models\OptionPruefungsleiterberichtJagdlich1Faehrte;
use App\Models\OptionPruefungsleiterberichtJagdlich1Faehrtenzeit;
use App\Models\OptionPruefungsleiterberichtJagdlich1Federwild;
use App\Models\OptionPruefungsleiterberichtJagdlich1Fuchs;
use App\Models\OptionPruefungsleiterberichtJagdlich1Haarwild;
use App\Models\OptionPruefungsleiterberichtJagdlich1Pruefungen;
use App\Models\OptionPruefungsleiterberichtJagdlich1Pruefungsgelaende;
use App\Models\OptionPruefungsleiterberichtJagdlich1Temperatur;
use App\Models\OptionPruefungsleiterberichtJagdlich1Wetter;
use App\Models\OptionPruefungsleiterberichtJagdlich1Wildarten;
use App\Models\OptionPruefungsleiterberichtJagdlich1Wind;
use App\Models\OptionPruefungStatus;
use App\Models\OptionRGP1Bestandenzusatz;
use App\Models\OptionRGP1KoerperlicheMaengel;
use App\Models\OptionRGP1Leistungsziffer;
use App\Models\OptionRGP1Preisklassen;
use App\Models\OptionRGP1Schussfestigkeit;
use App\Models\OptionRGP1Wasserarbeit;
use App\Models\OptionRGP1Wesenverhalten;
use App\Models\OptionRGP2Bestandenzusatz;
use App\Models\OptionRGP2KoerperlicheMaengel;
use App\Models\OptionRGP2Leistungsziffer;
use App\Models\OptionRGP2Preisklassen;
use App\Models\OptionRGP2Schussfestigkeit;
use App\Models\OptionRGP2Wasserarbeit;
use App\Models\OptionRGP2Wesenverhalten;
use App\Models\OptionRichterstatus;
use App\Models\OptionRSWP1Hundetyp;
use App\Models\OptionRSWP1Praedikate;
use App\Models\OptionRSWP1Preisklassen;
use App\Models\OptionRSWP1Todesursache;
use App\Models\OptionRSWP1Wild;
use App\Models\OptionRSWPORB1Hundetyp;
use App\Models\OptionRSWPORB1Praedikate;
use App\Models\OptionRSWPORB1Preisklassen;
use App\Models\OptionRSWPORB1Todesursache;
use App\Models\OptionRSWPORB1Wild;
use App\Models\OptionRuteFehlbildung;
use App\Models\OptionSchusstest1Beschwichtigungsverhalten;
use App\Models\OptionSchusstest1Schreckhaftigkeit;
use App\Models\OptionSchusstest1Schussfestigkeit;
use App\Models\OptionSRP1Praedikate;
use App\Models\OptionSRP1Wertungspunkte;
use App\Models\OptionTitelStatus;
use App\Models\OptionTodesursache;
use App\Models\OptionTPTollerBronze1KoerperlicheMaengel;
use App\Models\OptionTPTollerBronze1Leistungsziffer;
use App\Models\OptionTPTollerBronze1Schussfestigkeit;
use App\Models\OptionTPTollerBronze1Verhaltensweisen;
use App\Models\OptionTPTollerSilber1Gesamturteil;
use App\Models\OptionTPTollerSilber1KoerperlicheMaengel;
use App\Models\OptionTPTollerSilber1Punkte11;
use App\Models\OptionTPTollerSilber1Schussfestigkeit;
use App\Models\OptionTPTollerSilber1Selbstsicherheit;
use App\Models\OptionTPTollerSilber1SonstigesVerhalten;
use App\Models\OptionTPTollerSilber1Temperament;
use App\Models\OptionTPTollerSilber1Vertraeglichkeit;
use App\Models\OptionTPTollerSilber1Wasserarbeit;
use App\Models\OptionTPTollerSilber1Wertungspunkte11;
use App\Models\OptionTPTollerSilber1Wertungspunkte12;
use App\Models\OptionVaAnmeldeoption;
use App\Models\OptionVaMeldeoption;
use App\Models\OptionVaMeldeunterlagenJagdlich;
use App\Models\OptionVaMeldeunterlagenNichtJagdlich;
use App\Models\OptionVaVoraussetzungenBlp;
use App\Models\OptionVaVoraussetzungenHpr;
use App\Models\OptionVaVoraussetzungenHprAp;
use App\Models\OptionVaVoraussetzungenRgp;
use App\Models\OptionVaVoraussetzungenSrp;
use App\Models\OptionVaVoraussetzungenTpbronze;
use App\Models\OptionVaVoraussetzungenTpsilber;
use App\Models\OptionVaZahlungsoption;
use App\Models\OptionVereinsstrafeEntscheider;
use App\Models\OptionVereinsstrafeGrund;
use App\Models\OptionVereinsstrafeStatus;
use App\Models\OptionWesenstest1Aggressionsverhalten;
use App\Models\OptionWesenstest1Aktivitaet;
use App\Models\OptionWesenstest1ArbeitSport;
use App\Models\OptionWesenstest1BegruendungNichtBestanden;
use App\Models\OptionWesenstest1Beruehrung;
use App\Models\OptionWesenstest1Beschwichtigungsverhalten;
use App\Models\OptionWesenstest1Beuteverhalten;
use App\Models\OptionWesenstest1Neugierverhalten;
use App\Models\OptionWesenstest1Pruefungen;
use App\Models\OptionWesenstest1Schreckhaftigkeit;
use App\Models\OptionWesenstest1Sozialverhalten;
use App\Models\OptionWesenstest1Spielverhalten;
use App\Models\OptionWesenstest1Suchverhalten;
use App\Models\OptionWesenstest1TragenZutragen;
use App\Models\OptionWesenstest1Umwelterfahrungen;
use App\Models\OptionWesenstest1Urteil;
use App\Models\OptionWesenstest1Vorpruefungen;
use App\Models\OptionWesenstest2Aggressionsverhalten;
use App\Models\OptionWesenstest2Aktivitaet;
use App\Models\OptionWesenstest2ArbeitSport;
use App\Models\OptionWesenstest2BegruendungNichtBestanden;
use App\Models\OptionWesenstest2Beruehrung;
use App\Models\OptionWesenstest2Beschwichtigungsverhalten;
use App\Models\OptionWesenstest2Beuteverhalten;
use App\Models\OptionWesenstest2Neugierverhalten;
use App\Models\OptionWesenstest2Pruefungen;
use App\Models\OptionWesenstest2Schreckhaftigkeit;
use App\Models\OptionWesenstest2Sozialverhalten;
use App\Models\OptionWesenstest2Spielverhalten;
use App\Models\OptionWesenstest2Suchverhalten;
use App\Models\OptionWesenstest2TragenZutragen;
use App\Models\OptionWesenstest2Umwelterfahrungen;
use App\Models\OptionWesenstest2Urteil;
use App\Models\OptionWesenstest2Vorpruefungen;
use App\Models\OptionWurfStatus;
use App\Models\OptionZSGebiss;
use App\Models\OptionZSQuelle;
use App\Models\OptionZstBesichtigungGrund;
use App\Models\OptionZstBesichtigungStatus;
use App\Models\OptionZSZahnzustand;
use App\Models\OptionZSZahnzustandI;
use App\Models\OptionZuchtart;
use App\Models\OptionZuchtstaettenmangelEntscheider;
use App\Models\OptionZuchtstaettenmangelGrund;
use App\Models\OptionZuchtstaettenmangelStatus;
use App\Models\OptionZuchttauglichkeit;
use App\Models\OptionZuchtverbotEntscheider;
use App\Models\OptionZuchtverbotGrund;
use App\Models\OptionZuchtverbotStatus;
use App\Models\Pruefung;
use App\Models\PruefungTyp;
use App\Models\Rasse;
use App\Models\Richtertyp;
use App\Models\RichtertypZusatz;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Titel;
use App\Models\TitelTyp;
use App\Models\User;
use App\Models\Veranstaltungskategorie;
use App\Models\Veranstaltungstyp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::id();
        if (! $id) {
            return;
        }

        $person = User::find($id)->person;

        // RASSEN - FARBE
        $rassen = RasseResource::collection(Rasse::all()->sortBy('order'));
        $farben = FarbeResource::collection(Farbe::all()->sortBy('name'));
        $farben_rasse = [];
        foreach ($rassen as $key => $rasse) {
            $rassefarben = FarbeResource::collection($rasse->farben);
            $farben_rasse[$rasse->id] = $rassefarben;
        }
        $farben_rasse['0'] = $farben;

        // anerkannte Farben
        $anerkannte_farben_rasse = [];
        foreach ($rassen as $key => $rasse) {
            $rassefarben = FarbeResource::collection($rasse->anerkannte_farben);
            //$rassefarben[10] = ['id' => 0, 'name' => "Bitte auswählen"];
            $anerkannte_farben_rasse[$rasse->id] = $rassefarben;
        }
        // $farben_rasse['0'] = $farben;

        // WURF / ZUCHTHUNDE
        $zuchthunde = $person->hunde()->where('zuchtzulassung_id', '>', 0)->get();
        $zuchthuendinnen = $person->huendinnen()->where('zuchtzulassung_id', '>', 0)->get();
        $zuchthuendinnen = OptionNameResource::collection($zuchthuendinnen->sortBy('name'));
        $zuchthunde = OptionNameResource::collection($zuchthunde->sortBy('name'));

        // VERANSTALTUNGEN
        $veranstaltungskategorien = OptionNameIconColorResource::collection(Veranstaltungskategorie::all()->sortBy('order'));
        $veranstaltungstypen = VeranstaltungstypResource::collection(Veranstaltungstyp::all()->sortBy('name'));
        $veranstaltung_kat_typ = [];
        foreach ($veranstaltungskategorien as $key => $kat) {
            $typen = OptionNameResource::collection($kat->typen);
            $veranstaltung_kat_typ[$kat->id] = $typen;
        }
        $veranstaltung_kat_typ['0'] = $veranstaltungstypen;

        // MITGLIEDER / LANDES-/BEZIRKSGRUPPEN

        // $mitgliedsarten = MitgliedsartResource::collection(Mitgliedsart::all()->sortBy('name'));
        $landesgruppen = LandesgruppeResource::collection(Landesgruppe::all()->sortBy('landesgruppe'));

        $landesgruppen_fuer_suche = Landesgruppe::where('suche', '=', 1)->get();
        $landesgruppen_suche = LandesgruppeResource::collection($landesgruppen_fuer_suche);

        $bezirksgruppen = BezirksgruppeResource::collection(Bezirksgruppe::all()->sortBy('name'));
        foreach ($landesgruppen as $key => $landesgruppe) {
            $landesgruppebezirksgruppen = BezirksgruppeResource::collection($landesgruppe->bezirksgruppen);
            $bezirksgruppen_landesgruppe[$landesgruppe->id] = $landesgruppebezirksgruppen;
        }
        $bezirksgruppen_landesgruppe['0'] = $bezirksgruppen;

        // $bezahlarten = BezahlartResource::collection(Bezahlart::all()->sortBy("name"));

        $test = [
            'string' => '',
            'checkbox' => 0,
            'radiobutton' => 0,
            'radiobuttons' => 0,
            'textarea' => '',
            'select' => ['id' => 0, 'name' => 'Bitte auswählen'],
            'input' => '',
            'upload' => 0,
            'number' => 0,
            'uploadstring' => 0,
            'checkbox1' => 0,
            'checkbox2' => 0,
            'checkbox3' => 0,
        ];

        return [
            'zuchthuendinnen' => $zuchthuendinnen,  //FIXME -
            'zuchthunde' => $zuchthunde, //FIXME -

            'test' => $test,

            // ALLGEMEIN
            // 'yes_no' => [['text' => 'Ja', 'value' => 1], ['text' => 'Nein', 'value' => 0]],
            'yes_no' => [['name' => 'Ja', 'id' => 1], ['name' => 'Nein', 'id' => 0]],
            'bestaetigt_nichtbestaetigt' => [['name' => 'bestätigt', 'id' => 1], ['name' => 'nicht bestätigt', 'id' => 0]],
            'positiv_negativ' => [['name' => 'positiv', 'id' => 1], ['name' => 'negativ', 'id' => 0]],
            'yes_no_bestanden' => [['name' => 'Ja / Bestanden', 'id' => 1], ['name' => 'Nein / Nicht bestanden', 'id' => 0]],
            'yes_no_bestanden_select' => [['name' => 'Ja / Bestanden', 'id' => true], ['name' => 'Nein / Nicht bestanden', 'id' => false]],
            'bestanden' => [['name' => 'Bestanden', 'id' => 1], ['name' => 'Nicht bestanden', 'id' => 0]],
            'bestanden_select' => [['name' => 'Bestanden', 'id' => true], ['name' => 'Nicht bestanden', 'id' => false]],
            'truefalse_select' => [['name' => 'Ja', 'id' => true], ['name' => 'Nein', 'id' => false]],
            'frei_nichtfrei' => OptionNameResource::collection(OptionAllgFreiNichtfrei::all()->sortBy('order')),
            'geschlecht_hund' => OptionNameResource::collection(OptionGeschlechtHund::all()->sortBy('name')),
            'geschlecht_person' => OptionNameResource::collection(OptionGeschlechtPerson::all()->sortBy('name')),
            'anrede' => OptionNameResource::collection(OptionAnrede::all()->sortBy('order')),
            'zuchttauglichkeiten' => OptionNameResource::collection(OptionZuchttauglichkeit::all()->sortBy('order')),
            'zuchtarten' => OptionNameResource::collection(OptionZuchtart::all()->sortBy('order')),
            'zstbesichtigung_grund' => OptionNameResource::collection(OptionZstBesichtigungGrund::all()->sortBy('order')),

            'bugtracks' => OptionNameResource::collection(OptionBugtrack::all()->sortBy('name')),
            'sections' => OptionNameResource::collection(Section::all()->sortBy('name')),

            // Aufgaben
            'aufgabe_stati' => OptionNameResource::collection(OptionAufgabeStatus::all()->sortBy('order')),

            // RECHNUNGEN / BEZAHLUNG
            'bezahlstatus' => OptionNameResource::collection(OptionBezahlstatus::aktiv()->get()->sortBy('name')),

            // TAGS
            'tags' => OptionNameResource::collection(Tag::all()->sortBy('name')),
            'tags_indexed' => OptionNameArrayResource::collection(Tag::all()->keyBy->id),

            // HUND
            'titel_stati' => OptionNameResource::collection(OptionTitelStatus::all()->sortBy('order')),
            'pruefung_stati' => OptionNameResource::collection(OptionPruefungStatus::all()->sortBy('order')),
            'titel_typen' => TitelTypResource::collection(TitelTyp::all()->sortBy('name')),
            'pruefungen_typen' => PruefungTypResource::collection(PruefungTyp::all()->sortBy('name')),
            'anwartschaft_typen' => AnwartschaftTypResource::collection(AnwartschaftTyp::all()->sortBy('name')),
            'rassen' => RasseResource::collection($rassen),
            'farben' => $farben_rasse,
            'anerkannte_farben' => $anerkannte_farben_rasse,
            'todesursachen' => OptionNameResource::collection(OptionTodesursache::all()->sortBy('order')),

            'antrag_stati' => OptionNameResource::collection(OptionAntragStatus::all()->sortBy('order')),
            'at_standorte' => OptionNameResource::collection(OptionATStandort::all()->sortBy('order')),
            'at_stati' => OptionNameResource::collection(OptionATStatus::all()->sortBy('order')),
            'at_typen' => OptionNameResource::collection(OptionATTyp::all()->sortBy('order')),
            'lh_stati' => OptionNameResource::collection(OptionLHStatus::all()->sortBy('order')),
            'lh_typen' => OptionNameResource::collection(OptionLHTyp::all()->sortBy('order')),
            'bezahlarten' => OptionNameResource::collection(OptionBezahlart::all()->sortBy('order')),
            'bezahlstati' => OptionNameResource::collection(OptionBezahlstatus::all()->sortBy('order')),
            'artikel_anlagetypen' => OptionNameResource::collection(OptionArtikelAnlagetyp::all()->sortBy('order')),
            // 'titel_drc' => OptionNameResource::collection(TitelTyp::where('verband_verein', 'DRC')->where('championstitel', 0)->get()->sortBy("name")),
            // 'titel_champion_drc' => OptionNameResource::collection(TitelTyp::where('verband_verein', 'DRC')->where('championstitel', 1)->get()->sortBy("name")),
            // 'titel_extern' => OptionNameResource::collection(TitelTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->where('championstitel', 0)->get()->sortBy("name")),
            // 'titel_champion_extern' => OptionNameResource::collection(TitelTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->where('championstitel', 1)->get()->sortBy("name")),
            // 'pruefungen_drc' => OptionNameResource::collection(PruefungTyp::where('verband_verein', 'DRC')->get()->sortBy("name")),
            // 'pruefungen_extern' => OptionNameResource::collection(PruefungTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->get()->sortBy("name")),

            // MITGLIEDSCHAFT / VERANSTALTUNG
            'beitragsarten' => BeitragsartResource::collection(Beitragsarten::all()->sortBy('order')),
            'landesgruppen' => LandesgruppeResource::collection($landesgruppen),
            'bezirksgruppen' => $bezirksgruppen_landesgruppe,
            'landesgruppen_suche' => $landesgruppen_suche,
            'gruppen' => OptionNameResource::collection(Gruppe::all()->sortBy('order')),

            'mitgliedsarten' => MitgliedsartResource::collection(Mitgliedsart::all()->sortBy('name')), // $mitgliedsarten,
            'clubzeitungen' => OptionNameResource::collection(Clubzeitung::all()->sortBy('name')),
            'mitgliedsstatus' => OptionNameResource::collection(OptionMGStatus::all()->sortBy('order')),

            'zuchtverbot_entscheider' => OptionNameResource::collection(OptionZuchtverbotEntscheider::all()->sortBy('name')),
            'vereinsstrafe_entscheider' => OptionNameResource::collection(OptionVereinsstrafeEntscheider::all()->sortBy('name')),
            'zuchtverbot_gruende' => OptionNameResource::collection(OptionZuchtverbotGrund::all()->sortBy('name')),
            'vereinsstrafe_gruende' => OptionNameResource::collection(OptionVereinsstrafeGrund::all()->sortBy('name')),
            'zuchtverbot_stati' => OptionNameResource::collection(OptionZuchtverbotStatus::all()->sortBy('name')),
            'vereinsstrafe_stati' => OptionNameResource::collection(OptionVereinsstrafeStatus::all()->sortBy('name')),
            'zuchtstaettenmangel_entscheider' => OptionNameResource::collection(OptionZuchtstaettenmangelEntscheider::all()->sortBy('name')),
            'zuchtstaettenmangel_gruende' => OptionNameResource::collection(OptionZuchtstaettenmangelGrund::all()->sortBy('name')),
            'zuchtstaettenmangel_stati' => OptionNameResource::collection(OptionZuchtstaettenmangelStatus::all()->sortBy('name')),

            'ausbildertypen' => OptionNameResource::collection(Ausbildertyp::all()->sortBy('order')),
            'ausbilder_stati' => OptionNameResource::collection(OptionAusbilderStatus::all()->sortBy('order')),
            //  'sonderleiter_stati' => OptionNameResource::collection(OptionSonderleiterStatus::all()->sortBy('order')),
            'ausbilderausweis_stati' => OptionNameResource::collection(OptionAusbilderausweisStatus::all()->sortBy('order')),

            'richter_stati' => OptionNameResource::collection(OptionRichterstatus::all()->sortBy('order')),
            'richtertypen' => OptionNameResource::collection(Richtertyp::all()->sortBy('order')),
            'richtertypenzusaetze' => OptionNameResource::collection(RichtertypZusatz::all()->sortBy('order')),

            // WURF
            'wurf_stati' => OptionNameResource::collection(OptionWurfStatus::all()->sortBy('order')),
            'wurfabnahme_augen' => OptionNameResource::collection(BewertungAugen::all()->sortBy('order')),
            'wurfabnahme_gebiss' => OptionNameResource::collection(BewertungGebiss::all()->sortBy('order')),
            'wurfabnahme_hoden' => OptionNameResource::collection(BewertungHoden::all()->sortBy('order')),
            'ed' => OptionNameResource::collection(BewertungED::all()->sortBy('order')),
            'hd' => OptionNameResource::collection(BewertungHD::all()->sortBy('order')),

            // HUND GESUNDHEIT

            'ed_Scoring_Typen' => OptionNameResource::collection(OptionEDScoringTyp::all()->sortBy('order')),
            'hd_Scoring_Typen' => OptionNameResource::collection(OptionHDScoringTyp::all()->sortBy('order')),
            'ed_Scoring_DRC' => OptionNameResource::collection(OptionEDScoringDRC::all()->sortBy('order')),
            'ed_Scoring_FCI' => OptionNameResource::collection(OptionEDScoringFCI::all()->sortBy('order')),
            'hd_Scoring_DRC' => OptionNameResource::collection(OptionHDScoringDRC::all()->sortBy('order')),
            'hd_Scoring_FCI' => OptionNameResource::collection(OptionHDScoringFCI::all()->sortBy('order')),
            'hd_Scoring_OFA' => OptionNameResource::collection(OptionHDScoringOFA::all()->sortBy('order')),
            'hd_Scoring_HS' => OptionNameResource::collection(OptionHDScoringHS::all()->sortBy('order')),
            'hd_Scoring_NL' => OptionNameResource::collection(OptionHDScoringNL::all()->sortBy('order')),
            'hd_Scoring_FI' => OptionNameResource::collection(OptionHDScoringFI::all()->sortBy('order')),
            'hd_Scoring_CH' => OptionNameResource::collection(OptionHDScoringCH::all()->sortBy('order')),
            'hd_Scoring_SW' => OptionNameResource::collection(OptionHDScoringSW::all()->sortBy('order')),
            'ed_Arthrosegrad' => OptionNameResource::collection(OptionEDArthrosegrad::all()->sortBy('order')),
            'hded_Ablehnung_Grund' => OptionNameResource::collection(OptionHDEDAblehnungGrund::all()->sortBy('order')),
            'hded_Roentgenbilder_Art' => OptionNameResource::collection(OptionHDEDRoentgenbilderArt::all()->sortBy('order')),
            'hded_Beurteilung_Status' => OptionNameResource::collection(OptionHDEDBeurteilungStatus::all()->sortBy('order')),
            'hd_Uebergangswirbel' => OptionNameResource::collection(OptionHDUebergangswirbel::all()->sortBy('order')),
            'hd_Winkelmessung_Norberg' => OptionNameResource::collection(OptionHDWinkelmessungNorberg::all()->sortBy('order')),
            'hded_CT_Grund' => OptionNameResource::collection(OptionHDEDCTGrund::all()->sortBy('order')),
            'ocd_Untersuchungsgrund' => OptionNameResource::collection(OptionOCDUntersuchungsgrund::all()->sortBy('order')),
            'coronoid_Untersuchungsgrund' => OptionNameResource::collection(OptionCoronoidUntersuchungsgrund::all()->sortBy('order')),
            'gelenkuntersuchung_Typ' => OptionNameResource::collection(OptionGelenkuntersuchungTyp::all()->sortBy('order')),

            'fcp_Grund' => OptionNameResource::collection(OptionFcpGrund::all()->sortBy('order')),
            'rute_Fehlbildung' => OptionNameResource::collection(OptionRuteFehlbildung::all()->sortBy('order')),
            'patella_Luxation_Scoring' => OptionNameResource::collection(OptionPatellaLuxationScoring::all()->sortBy('order')),
            'ektoper_Ureter_Scoring' => OptionNameResource::collection(OptionEktoperUreter::all()->sortBy('order')),
            'hoden_Tastbarkeit' => OptionNameResource::collection(OptionHodenTastbarkeit::all()->sortBy('order')),
            'hoden_Senkung' => OptionNameResource::collection(OptionHodenSenkung::all()->sortBy('order')),
            'hoden_Quelle' => OptionNameResource::collection(OptionHodenQuelle::all()->sortBy('order')),
            'kastration_Sterilisation' => OptionNameResource::collection(OptionKastrationSterilisation::all()->sortBy('order')),
            'kardio_Befunde' => OptionNameResource::collection(OptionKardioBefund::all()->sortBy('order')),
            'kardio_Untersuchungsarten' => OptionNameResource::collection(OptionKardioUntersuchungsart::all()->sortBy('order')),
            'kaiserschnitt_Quelle' => OptionNameResource::collection(OptionKaiserschnittQuelle::all()->sortBy('order')),

            'gentest_full' => OptionNameResource::collection(OptionGentestStd::all()->sortBy('order')),
            'gentest_std' => OptionNameResource::collection(OptionGentestStd::aktiv()->get()->sortBy('order')),
            'gentest_farbe_gelb' => OptionNameResource::collection(OptionGentestFarbeGelb::aktiv()->get()->sortBy('order')),
            'gentest_farbe_braun' => OptionNameResource::collection(OptionGentestFarbeBraun::aktiv()->get()->sortBy('order')),
            'gentest_farbverduennung' => OptionNameResource::collection(OptionGentestFarbverduennung::aktiv()->get()->sortBy('order')),
            'gentest_haarlaenge' => OptionNameResource::collection(OptionGentestHaarlaenge::aktiv()->get()->sortBy('order')),

            'zs_Zahnzustand' => OptionNameResource::collection(OptionZSZahnzustand::aktiv()->get()->sortBy('order')),
            'zs_Zahnzustand_I' => OptionNameResource::collection(OptionZSZahnzustandI::aktiv()->get()->sortBy('order')),
            'zs_Gebiss' => OptionNameResource::collection(OptionZSGebiss::aktiv()->get()->sortBy('order')),
            'zs_GebissR' => OptionNameResource::collection(OptionZSGebiss::aktiv()->get()->sortBy('order')),
            'zs_Quelle' => OptionNameResource::collection(OptionZSQuelle::aktiv()->get()->sortBy('order')),

            'au_Typen' => OptionNameResource::collection(OptionAUTyp::all()->sortBy('order')),
            'au_CEAForm' => OptionNameResource::collection(OptionAUCEAForm::all()->sortBy('order')),
            'au_CEAFormRadio' => OptionNameResource::collection(OptionAUCEAForm::all()->sortBy('order')),
            'au_ICAAGrad' => OptionNameResource::collection(OptionAUICAAGrad::all()->sortBy('order')),
            'au_PHTVLGrad' => OptionNameResource::collection(OptionAUPHTVLGrad::all()->sortBy('order')),
            'au_RDForm' => OptionNameResource::collection(OptionAURDForm::all()->sortBy('order')),
            'au_MPPLocation' => OptionNameResource::collection(OptionAUMPPLocation::all()->sortBy('order')),
            'au_KataraktForm' => OptionNameResource::collection(OptionAUKataraktForm::all()->sortBy('order')),
            'au_Lid' => OptionNameResource::collection(OptionAULid::aktiv()->get()->sortBy('order')),
            'au_ErbZweifel' => OptionNameResource::collection(OptionAUErbZweifel::all()->sortBy('order')),
            'au_ErbZweifelRadio' => OptionNameResource::collection(OptionAUErbZweifel::all()->sortBy('order')),
            'au_ErbVorlaeufig' => OptionNameResource::collection(OptionAUErbVorlaeufig::all()->sortBy('order')),
            'au_Erblich' => OptionNameResource::collection(OptionAUErblich::all()->sortBy('order')),

            'fachgebiete' => OptionNameResource::collection(Fachgebiet::all()->sortBy('order')),

            // VERANSTALTUNG
            'va_kategorien' => $veranstaltungskategorien,
            'va_typen' => $veranstaltung_kat_typ,
            'va_typenhans' => 'HANS',

            'va_meldeunterlagen_nicht_jagdlich' => OptionNameResource::collection(OptionVaMeldeunterlagenNichtJagdlich::all()->sortBy('order')),
            'va_meldeunterlagen_jagdlich' => OptionNameResource::collection(OptionVaMeldeunterlagenJagdlich::all()->sortBy('order')),
            'va_anmeldeoptionen' => OptionNameResource::collection(OptionVaAnmeldeoption::all()->sortBy('order')),
            'va_meldeoptionen' => OptionNameResource::collection(OptionVaMeldeoption::all()->sortBy('order')),
            'va_zahlungsoptionen' => OptionNameResource::collection(OptionVaZahlungsoption::all()->sortBy('order')),

            'va_voraussetzungen_blp' => PruefungenIdResource::collection(OptionVaVoraussetzungenBlp::all()->sortBy('order')),
            'va_voraussetzungen_hpr' => PruefungenIdResource::collection(OptionVaVoraussetzungenHpr::all()->sortBy('order')),
            'va_voraussetzungen_hpr_ap' => OptionNameResource::collection(OptionVaVoraussetzungenHprAp::all()->sortBy('order')),
            'va_voraussetzungen_rgp' => OptionNameResource::collection(OptionVaVoraussetzungenRgp::all()->sortBy('order')),
            'va_voraussetzungen_srp' => PruefungenIdResource::collection(OptionVaVoraussetzungenSrp::all()->sortBy('order')),
            'va_voraussetzungen_tpbronze' => PruefungenIdResource::collection(OptionVaVoraussetzungenTpbronze::all()->sortBy('order')),
            'va_voraussetzungen_tpsilber' => OptionNameResource::collection(OptionVaVoraussetzungenTpsilber::all()->sortBy('order')),

            'va_APDR1Test1Ausfuehrung' => OptionNameResource::collection(OptionAPDR1Test1Ausfuehrung::all()->sortBy('order')),
            'va_APDR1Test2Ausfuehrung' => OptionNameResource::collection(OptionAPDR1Test2Ausfuehrung::all()->sortBy('order')),
            'va_APDR1Test3Ausfuehrung' => OptionNameResource::collection(OptionAPDR1Test3Ausfuehrung::all()->sortBy('order')),
            'va_APDR1Test4Ausfuehrung' => OptionNameResource::collection(OptionAPDR1Test4Ausfuehrung::all()->sortBy('order')),
            'va_APDR1Resultat' => OptionNameResource::collection(OptionAPDR1Resultat::all()->sortBy('order')),
            'va_APDR1Ausschlussgrund' => OptionNameResource::collection(OptionAPDR1Ausschlussgrund::all()->sortBy('order')),
            'va_BLP1KoerperlicheMaengel' => OptionNameResource::collection(OptionBLP1KoerperlicheMaengel::all()->sortBy('order')),
            'va_BLP1Schussfestigkeit' => OptionNameResource::collection(OptionBLP1Schussfestigkeit::all()->sortBy('order')),
            'va_BLP1Selbstsicherheit' => OptionNameResource::collection(OptionBLP1Selbstsicherheit::all()->sortBy('order')),
            'va_BLP1SonstigesVerhalten' => OptionNameResource::collection(OptionBLP1SonstigesVerhalten::all()->sortBy('order')),
            'va_BLP1Temperament' => OptionNameResource::collection(OptionBLP1Temperament::all()->sortBy('order')),
            'va_BLP1Vertraeglichkeit' => OptionNameResource::collection(OptionBLP1Vertraeglichkeit::all()->sortBy('order')),
            'va_BLP1Wasserarbeit' => OptionNameResource::collection(OptionBLP1Wasserarbeit::all()->sortBy('order')),
            'va_BLP1Wertungspunkte10' => OptionNameResource::collection(OptionBLP1Wertungspunkte10::all()->sortBy('order')),
            'va_BLP1Wertungspunkte11' => OptionNameResource::collection(OptionBLP1Wertungspunkte11::all()->sortBy('order')),
            'va_BLP1Wertungspunkte12' => OptionNameResource::collection(OptionBLP1Wertungspunkte12::all()->sortBy('order')),
            'va_BLP1Wildschleppe' => OptionNameResource::collection(OptionBLP1Wildschleppe::all()->sortBy('order')),
            'va_Formwert1Augenfarbe' => OptionNameResource::collection(OptionFormwert1Augenfarbe::all()->sortBy('order')),
            'va_Formwert1Augenform' => OptionNameResource::collection(OptionFormwert1Augenform::all()->sortBy('order')),
            'va_Formwert1Ausdruck' => OptionNameResource::collection(OptionFormwert1Ausdruck::all()->sortBy('order')),
            'va_Formwert1Behaenge' => OptionNameResource::collection(OptionFormwert1Behaenge::all()->sortBy('order')),
            'va_Formwert1Brust' => OptionNameResource::collection(OptionFormwert1Brust::all()->sortBy('order')),
            'va_Formwert1Brusttiefe' => OptionNameResource::collection(OptionFormwert1Brusttiefe::all()->sortBy('order')),
            'va_Formwert1Ellenbogen' => OptionNameResource::collection(OptionFormwert1Ellenbogen::all()->sortBy('order')),
            'va_Formwert1Fang' => OptionNameResource::collection(OptionFormwert1Fang::all()->sortBy('order')),
            'va_Formwert1Gebiss' => OptionNameResource::collection(OptionFormwert1Gebiss::all()->sortBy('order')),
            'va_Formwert1Gebiss_radio' => OptionNameResource::collection(OptionFormwert1Gebiss::all()->sortBy('order')),
            'va_Formwert1Gesamterscheinung' => OptionNameResource::collection(OptionFormwert1Gesamterscheinung::all()->sortBy('order')),
            'va_Formwert1Geschlechterpraege' => OptionNameResource::collection(OptionFormwert1Geschlechterpraege::all()->sortBy('order')),
            'va_Formwert1Hals' => OptionNameResource::collection(OptionFormwert1Hals::all()->sortBy('order')),
            'va_Formwert1Hinterhand' => OptionNameResource::collection(OptionFormwert1Hinterhand::all()->sortBy('order')),
            'va_Formwert1Hinterlaeufe' => OptionNameResource::collection(OptionFormwert1Hinterlaeufe::all()->sortBy('order')),
            'va_Formwert1Hoden' => OptionNameResource::collection(OptionFormwert1Hoden::all()->sortBy('order')),
            'va_Formwert1Knochenstaerke' => OptionNameResource::collection(OptionFormwert1Knochenstaerke::all()->sortBy('order')),
            'va_Formwert1Kondition' => OptionNameResource::collection(OptionFormwert1Kondition::all()->sortBy('order')),
            'va_Formwert1Kruppe' => OptionNameResource::collection(OptionFormwert1Kruppe::all()->sortBy('order')),
            'va_Formwert1Kopf' => OptionNameResource::collection(OptionFormwert1Kopf::all()->sortBy('order')),
            'va_Formwert1Lenden' => OptionNameResource::collection(OptionFormwert1Lenden::all()->sortBy('order')),
            'va_Formwert1Oberarme' => OptionNameResource::collection(OptionFormwert1Oberarme::all()->sortBy('order')),
            'va_Formwert1Oberkopf' => OptionNameResource::collection(OptionFormwert1Oberkopf::all()->sortBy('order')),
            'va_Formwert1Oberlefzen' => OptionNameResource::collection(OptionFormwert1Oberlefzen::all()->sortBy('order')),
            'va_Formwert1Pfoten' => OptionNameResource::collection(OptionFormwert1Pfoten::all()->sortBy('order')),
            'va_Formwert1Pigmentierung' => OptionNameResource::collection(OptionFormwert1Pigmentierung::all()->sortBy('order')),
            'va_Formwert1Ruecken' => OptionNameResource::collection(OptionFormwert1Ruecken::all()->sortBy('order')),
            'va_Formwert1Rute' => OptionNameResource::collection(OptionFormwert1Rute::all()->sortBy('order')),
            'va_Formwert1Schultern' => OptionNameResource::collection(OptionFormwert1Schultern::all()->sortBy('order')),
            'va_Formwert1Stop' => OptionNameResource::collection(OptionFormwert1Stop::all()->sortBy('order')),
            'va_Formwert1Unterlefzen' => OptionNameResource::collection(OptionFormwert1Unterlefzen::all()->sortBy('order')),
            'va_Formwert1Verhalten' => OptionNameResource::collection(OptionFormwert1Verhalten::all()->sortBy('order')),
            'va_Formwert1Vorbrust' => OptionNameResource::collection(OptionFormwert1Vorbrust::all()->sortBy('order')),
            'va_Formwert1Vorderhand' => OptionNameResource::collection(OptionFormwert1Vorderhand::all()->sortBy('order')),
            'va_Formwert1Vorderlaeufe' => OptionNameResource::collection(OptionFormwert1Vorderlaeufe::all()->sortBy('order')),
            'va_Formwert1Winkelung' => OptionNameResource::collection(OptionFormwert1Winkelung::all()->sortBy('order')),
            'va_HPR1Gesamtpraedikat' => OptionNameResource::collection(OptionHPR1Gesamtpraedikat::all()->sortBy('order')),
            'va_HPR1Praedikat' => OptionNameResource::collection(OptionHPR1Praedikat::all()->sortBy('order')),
            'va_JAS1Punkte12' => OptionNameResource::collection(OptionJAS1Punkte12::all()->sortBy('order')),
            'va_JAS1Punkte13' => OptionNameResource::collection(OptionJAS1Punkte13::all()->sortBy('order')),
            'va_JAS1Schussfestigkeit' => OptionNameResource::collection(OptionJAS1Schussfestigkeit::all()->sortBy('order')),
            'va_JAS1SonstigesVerhalten' => OptionNameResource::collection(OptionJAS1SonstigesVerhalten::all()->sortBy('order')),
            'va_JAS1Selbstsicherheit' => OptionNameResource::collection(OptionJAS1Selbstsicherheit::all()->sortBy('order')),
            'va_JAS1Temperament' => OptionNameResource::collection(OptionJAS1Temperament::all()->sortBy('order')),
            'va_JAS1Verhaltensvermerk' => OptionNameResource::collection(OptionJAS1Verhaltensvermerk::all()->sortBy('order')),
            'va_JAS1Vertraeglichkeit' => OptionNameResource::collection(OptionJAS1Vertraeglichkeit::all()->sortBy('order')),
            'va_JAS1Wild' => OptionNameResource::collection(OptionJAS1Wild::all()->sortBy('order')),
            'va_JAS2Praedikate' => OptionNameResource::collection(OptionJAS2Praedikate::all()->sortBy('order')),
            'va_JAS2Aufgabenbewertung' => OptionNameResource::collection(OptionJAS2Aufgabenbewertung::all()->sortBy('order')),
            'va_JAS2Schussfestigkeit' => OptionNameResource::collection(OptionJAS2Schussfestigkeit::all()->sortBy('order')),
            'va_JAS2Selbstsicherheit' => OptionNameResource::collection(OptionJAS2Selbstsicherheit::all()->sortBy('order')),
            'va_JAS2SonstigesVerhalten' => OptionNameResource::collection(OptionJAS2SonstigesVerhalten::all()->sortBy('order')),
            'va_JAS2Temperament' => OptionNameResource::collection(OptionJAS2Temperament::all()->sortBy('order')),
            'va_JAS2Vertraeglichkeit' => OptionNameResource::collection(OptionJAS2Vertraeglichkeit::all()->sortBy('order')),
            'va_JAS2Wild' => OptionNameResource::collection(OptionJAS2Wild::all()->sortBy('order')),
            'va_MockTrail1Ausschlussgrund' => OptionNameResource::collection(OptionMockTrail1Ausschlussgrund::all()->sortBy('order')),
            'va_PNS1Leistungsziffer' => OptionNameResource::collection(OptionPNS1Leistungsziffer::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Bodenzustand' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Bodenzustand::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Fachrichtergruppen' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Fachrichtergruppen::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Faehrte' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Faehrte::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Faehrtenzeit' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Faehrtenzeit::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Federwild' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Federwild::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Fuchs' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Fuchs::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Haarwild' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Haarwild::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Pruefungen' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Pruefungen::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Pruefungsgelaende' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Pruefungsgelaende::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Temperatur' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Temperatur::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Wildarten' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Wildarten::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Wind' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Wind::all()->sortBy('order')),
            'va_PruefungsleiterberichtJagdlich1Wetter' => OptionNameResource::collection(OptionPruefungsleiterberichtJagdlich1Wetter::all()->sortBy('order')),
            'va_RGP1Bestandenzusatz' => OptionNameResource::collection(OptionRGP1Bestandenzusatz::all()->sortBy('order')),
            'va_RGP1KoerperlicheMaengel' => OptionNameResource::collection(OptionRGP1KoerperlicheMaengel::all()->sortBy('order')),
            'va_RGP1Leistungsziffer' => OptionNameResource::collection(OptionRGP1Leistungsziffer::all()->sortBy('order')),
            'va_RGP1Preisklassen' => OptionNameResource::collection(OptionRGP1Preisklassen::all()->sortBy('order')),
            'va_RGP1Schussfestigkeit' => OptionNameResource::collection(OptionRGP1Schussfestigkeit::all()->sortBy('order')),
            'va_RGP1Wasserarbeit' => OptionNameResource::collection(OptionRGP1Wasserarbeit::all()->sortBy('order')),
            'va_RGP1Wesenverhalten' => OptionNameResource::collection(OptionRGP1Wesenverhalten::all()->sortBy('order')),
            'va_RGP2Bestandenzusatz' => OptionNameResource::collection(OptionRGP2Bestandenzusatz::all()->sortBy('order')),
            'va_RGP2KoerperlicheMaengel' => OptionNameResource::collection(OptionRGP2KoerperlicheMaengel::all()->sortBy('order')),
            'va_RGP2Leistungsziffer' => OptionNameResource::collection(OptionRGP2Leistungsziffer::all()->sortBy('order')),
            'va_RGP2Preisklassen' => OptionNameResource::collection(OptionRGP2Preisklassen::all()->sortBy('order')),
            'va_RGP2Schussfestigkeit' => OptionNameResource::collection(OptionRGP2Schussfestigkeit::all()->sortBy('order')),
            'va_RGP2Wasserarbeit' => OptionNameResource::collection(OptionRGP2Wasserarbeit::all()->sortBy('order')),
            'va_RGP2Wesenverhalten' => OptionNameResource::collection(OptionRGP2Wesenverhalten::all()->sortBy('order')),
            'va_SRP1Wertungspunkte' => OptionNameResource::collection(OptionSRP1Wertungspunkte::all()->sortBy('order')),
            'va_SRP1Praedikate' => OptionNameResource::collection(OptionSRP1Praedikate::all()->sortBy('order')),
            'va_RSWP1Praedikate' => OptionNameResource::collection(OptionRSWP1Praedikate::all()->sortBy('order')),
            'va_RSWP1Preisklassen' => OptionNameResource::collection(OptionRSWP1Preisklassen::all()->sortBy('order')),
            'va_RSWP1Hundetyp' => OptionNameResource::collection(OptionRSWP1Hundetyp::all()->sortBy('order')),
            'va_RSWP1Todesursache' => OptionNameResource::collection(OptionRSWP1Todesursache::all()->sortBy('order')),
            'va_RSWP1Wild' => OptionNameResource::collection(OptionRSWP1Wild::all()->sortBy('order')),
            'va_RSWPORB1Preisklassen' => OptionNameResource::collection(OptionRSWPORB1Preisklassen::all()->sortBy('order')),
            'va_RSWPORB1Praedikate' => OptionNameResource::collection(OptionRSWPORB1Praedikate::all()->sortBy('order')),
            'va_RSWPORB1Hundetyp' => OptionNameResource::collection(OptionRSWPORB1Hundetyp::all()->sortBy('order')),
            'va_RSWPORB1Todesursache' => OptionNameResource::collection(OptionRSWPORB1Todesursache::all()->sortBy('order')),
            'va_RSWPORB1Wild' => OptionNameResource::collection(OptionRSWPORB1Wild::all()->sortBy('order')),
            'va_Schusstest1Schussfestigkeit' => OptionNameResource::collection(OptionSchusstest1Schussfestigkeit::all()->sortBy('order')),
            'va_Schusstest1Beschwichtigungsverhalten' => OptionNameResource::collection(OptionSchusstest1Beschwichtigungsverhalten::all()->sortBy('order')),
            'va_Schusstest1Schreckhaftigkeit' => OptionNameResource::collection(OptionSchusstest1Schreckhaftigkeit::all()->sortBy('order')),
            'va_TPTollerBronze1KoerperlicheMaengel' => OptionNameResource::collection(OptionTPTollerBronze1KoerperlicheMaengel::all()->sortBy('order')),
            'va_TPTollerBronze1Leistungsziffer' => OptionNameResource::collection(OptionTPTollerBronze1Leistungsziffer::all()->sortBy('order')),
            'va_TPTollerBronze1Schussfestigkeit' => OptionNameResource::collection(OptionTPTollerBronze1Schussfestigkeit::all()->sortBy('order')),
            'va_TPTollerBronze1Verhaltensweisen' => OptionNameResource::collection(OptionTPTollerBronze1Verhaltensweisen::all()->sortBy('order')),
            'va_TPTollerSilber1Gesamturteil' => OptionNameResource::collection(OptionTPTollerSilber1Gesamturteil::all()->sortBy('order')),
            'va_TPTollerSilber1KoerperlicheMaengel' => OptionNameResource::collection(OptionTPTollerSilber1KoerperlicheMaengel::all()->sortBy('order')),
            'va_TPTollerSilber1Punkte11' => OptionNameResource::collection(OptionTPTollerSilber1Punkte11::all()->sortBy('order')),
            'va_TPTollerSilber1Schussfestigkeit' => OptionNameResource::collection(OptionTPTollerSilber1Schussfestigkeit::all()->sortBy('order')),
            'va_TPTollerSilber1Selbstsicherheit' => OptionNameResource::collection(OptionTPTollerSilber1Selbstsicherheit::all()->sortBy('order')),
            'va_TPTollerSilber1SonstigesVerhalten' => OptionNameResource::collection(OptionTPTollerSilber1SonstigesVerhalten::all()->sortBy('order')),
            'va_TPTollerSilber1Temperament' => OptionNameResource::collection(OptionTPTollerSilber1Temperament::all()->sortBy('order')),
            'va_TPTollerSilber1Vertraeglichkeit' => OptionNameResource::collection(OptionTPTollerSilber1Vertraeglichkeit::all()->sortBy('order')),
            'va_TPTollerSilber1Wasserarbeit' => OptionNameResource::collection(OptionTPTollerSilber1Wasserarbeit::all()->sortBy('order')),
            'va_TPTollerSilber1Wertungspunkte11' => OptionNameResource::collection(OptionTPTollerSilber1Wertungspunkte11::all()->sortBy('order')),
            'va_TPTollerSilber1Wertungspunkte12' => OptionNameResource::collection(OptionTPTollerSilber1Wertungspunkte12::all()->sortBy('order')),
            'va_Wesenstest1Aggressionsverhalten' => OptionNameResource::collection(OptionWesenstest1Aggressionsverhalten::all()->sortBy('order')),
            'va_Wesenstest1Aktivitaet' => OptionNameResource::collection(OptionWesenstest1Aktivitaet::all()->sortBy('order')),
            'va_Wesenstest1ArbeitSport' => OptionNameResource::collection(OptionWesenstest1ArbeitSport::all()->sortBy('order')),
            'va_Wesenstest1BegruendungNichtBestanden' => OptionNameResource::collection(OptionWesenstest1BegruendungNichtBestanden::all()->sortBy('order')),
            'va_Wesenstest1Beruehrung' => OptionNameResource::collection(OptionWesenstest1Beruehrung::all()->sortBy('order')),
            'va_Wesenstest1Beschwichtigungsverhalten' => OptionNameResource::collection(OptionWesenstest1Beschwichtigungsverhalten::all()->sortBy('order')),
            'va_Wesenstest1Beuteverhalten' => OptionNameResource::collection(OptionWesenstest1Beuteverhalten::all()->sortBy('order')),
            'va_Wesenstest1Neugierverhalten' => OptionNameResource::collection(OptionWesenstest1Neugierverhalten::all()->sortBy('order')),
            'va_Wesenstest1Pruefungen' => OptionNameResource::collection(OptionWesenstest1Pruefungen::all()->sortBy('order')),
            'va_Wesenstest1Schreckhaftigkeit' => OptionNameResource::collection(OptionWesenstest1Schreckhaftigkeit::all()->sortBy('order')),
            'va_Wesenstest1Sozialverhalten' => OptionNameResource::collection(OptionWesenstest1Sozialverhalten::all()->sortBy('order')),
            'va_Wesenstest1Spielverhalten' => OptionNameResource::collection(OptionWesenstest1Spielverhalten::all()->sortBy('order')),
            'va_Wesenstest1Suchverhalten' => OptionNameResource::collection(OptionWesenstest1Suchverhalten::all()->sortBy('order')),
            'va_Wesenstest1TragenZutragen' => OptionNameResource::collection(OptionWesenstest1TragenZutragen::all()->sortBy('order')),
            'va_Wesenstest1Urteil' => OptionNameResource::collection(OptionWesenstest1Urteil::all()->sortBy('order')),
            'va_Wesenstest1Umwelterfahrungen' => OptionNameResource::collection(OptionWesenstest1Umwelterfahrungen::all()->sortBy('order')),
            'va_Wesenstest1Vorpruefungen' => OptionNameResource::collection(OptionWesenstest1Vorpruefungen::all()->sortBy('order')),
            'va_Wesenstest2Aggressionsverhalten' => OptionNameResource::collection(OptionWesenstest2Aggressionsverhalten::all()->sortBy('order')),
            'va_Wesenstest2Aktivitaet' => OptionNameResource::collection(OptionWesenstest2Aktivitaet::all()->sortBy('order')),
            'va_Wesenstest2ArbeitSport' => OptionNameResource::collection(OptionWesenstest2ArbeitSport::all()->sortBy('order')),
            'va_Wesenstest2BegruendungNichtBestanden' => OptionNameResource::collection(OptionWesenstest2BegruendungNichtBestanden::all()->sortBy('order')),
            'va_Wesenstest2Beruehrung' => OptionNameResource::collection(OptionWesenstest2Beruehrung::all()->sortBy('order')),
            'va_Wesenstest2Beschwichtigungsverhalten' => OptionNameResource::collection(OptionWesenstest2Beschwichtigungsverhalten::all()->sortBy('order')),
            'va_Wesenstest2Beuteverhalten' => OptionNameResource::collection(OptionWesenstest2Beuteverhalten::all()->sortBy('order')),
            'va_Wesenstest2Neugierverhalten' => OptionNameResource::collection(OptionWesenstest2Neugierverhalten::all()->sortBy('order')),
            'va_Wesenstest2Pruefungen' => OptionNameResource::collection(OptionWesenstest2Pruefungen::all()->sortBy('order')),
            'va_Wesenstest2Schreckhaftigkeit' => OptionNameResource::collection(OptionWesenstest2Schreckhaftigkeit::all()->sortBy('order')),
            'va_Wesenstest2Sozialverhalten' => OptionNameResource::collection(OptionWesenstest2Sozialverhalten::all()->sortBy('order')),
            'va_Wesenstest2Spielverhalten' => OptionNameResource::collection(OptionWesenstest2Spielverhalten::all()->sortBy('order')),
            'va_Wesenstest2Suchverhalten' => OptionNameResource::collection(OptionWesenstest2Suchverhalten::all()->sortBy('order')),
            'va_Wesenstest2TragenZutragen' => OptionNameResource::collection(OptionWesenstest2TragenZutragen::all()->sortBy('order')),
            'va_Wesenstest2Urteil' => OptionNameResource::collection(OptionWesenstest2Urteil::all()->sortBy('order')),
            'va_Wesenstest2Umwelterfahrungen' => OptionNameResource::collection(OptionWesenstest2Umwelterfahrungen::all()->sortBy('order')),
            'va_Wesenstest2Vorpruefungen' => OptionNameResource::collection(OptionWesenstest2Vorpruefungen::all()->sortBy('order')),
            'va_Wesenstest2SelectAggressionsverhalten' => OptionNameResource::collection(OptionWesenstest2Aggressionsverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectAktivitaet' => OptionNameResource::collection(OptionWesenstest2Aktivitaet::all()->sortBy('order')),
            'va_Wesenstest2SelectArbeitSport' => OptionNameResource::collection(OptionWesenstest2ArbeitSport::all()->sortBy('order')),
            'va_Wesenstest2SelectBegruendungNichtBestanden' => OptionNameResource::collection(OptionWesenstest2BegruendungNichtBestanden::all()->sortBy('order')),
            'va_Wesenstest2SelectBeruehrung' => OptionNameResource::collection(OptionWesenstest2Beruehrung::all()->sortBy('order')),
            'va_Wesenstest2SelectBeschwichtigungsverhalten' => OptionNameResource::collection(OptionWesenstest2Beschwichtigungsverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectBeuteverhalten' => OptionNameResource::collection(OptionWesenstest2Beuteverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectNeugierverhalten' => OptionNameResource::collection(OptionWesenstest2Neugierverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectPruefungen' => OptionNameResource::collection(OptionWesenstest2Pruefungen::all()->sortBy('order')),
            'va_Wesenstest2SelectSchreckhaftigkeit' => OptionNameResource::collection(OptionWesenstest2Schreckhaftigkeit::all()->sortBy('order')),
            'va_Wesenstest2SelectSozialverhalten' => OptionNameResource::collection(OptionWesenstest2Sozialverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectSpielverhalten' => OptionNameResource::collection(OptionWesenstest2Spielverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectSuchverhalten' => OptionNameResource::collection(OptionWesenstest2Suchverhalten::all()->sortBy('order')),
            'va_Wesenstest2SelectTragenZutragen' => OptionNameResource::collection(OptionWesenstest2TragenZutragen::all()->sortBy('order')),
            'va_Wesenstest2SelectUrteil' => OptionNameResource::collection(OptionWesenstest2Urteil::all()->sortBy('order')),
            'va_Wesenstest2SelectUmwelterfahrungen' => OptionNameResource::collection(OptionWesenstest2Umwelterfahrungen::all()->sortBy('order')),
            'va_Wesenstest2SelectVorpruefungen' => OptionNameResource::collection(OptionWesenstest2Vorpruefungen::all()->sortBy('order')),

        ];
    }

    public function webindex()
    {

        $id = Auth::id();

        if ($id) {
            $person = User::find($id)->person;
            $zuchthunde = $person->hunde()->where('zuchthund', 1)->get();
            $zuchthuendinnen = $person->huendinnen()->where('zuchthund', 1)->get();
            $zuchthuendinnen = OptionNameResource::collection($zuchthuendinnen->sortBy('name'));
            $zuchthunde = OptionNameResource::collection($zuchthunde->sortBy('name'));
        } else {
            $zuchthunde = [];
            $zuchthuendinnen = [];
        }

        // RASSEN - FARBE
        $rassen = RasseResource::collection(Rasse::all()->sortBy('order'));
        $farben = FarbeResource::collection(Farbe::all()->sortBy('name'));
        $farben_rasse = [];
        foreach ($rassen as $key => $rasse) {
            $rassefarben = FarbeResource::collection($rasse->farben);
            $farben_rasse[$rasse->id] = $rassefarben;
        }
        $farben_rasse['0'] = $farben;

        // VERANSTALTUNGEN
        $veranstaltungskategorien = OptionNameIconColorResource::collection(Veranstaltungskategorie::all()->sortBy('order'));
        $veranstaltungstypen = VeranstaltungstypResource::collection(Veranstaltungstyp::all()->sortBy('name'));
        $veranstaltung_kat_typ = [];
        foreach ($veranstaltungskategorien as $key => $kat) {
            $typen = OptionNameResource::collection($kat->typen);
            $veranstaltung_kat_typ[$kat->id] = $typen;
        }
        $veranstaltung_kat_typ['0'] = $veranstaltungstypen;

        // MITGLIEDER / LANDES-/BEZIRKSGRUPPEN
        $mitgliedsarten = MitgliedsartResource::collection(Mitgliedsart::all()->sortBy('name'));
        $landesgruppen = LandesgruppeResource::collection(Landesgruppe::all()->sortBy('landesgruppe'));
        $bezirksgruppen = BezirksgruppeResource::collection(Bezirksgruppe::all()->sortBy('name'));
        foreach ($landesgruppen as $key => $landesgruppe) {
            $landesgruppebezirksgruppen = BezirksgruppeResource::collection($landesgruppe->bezirksgruppen);
            $bezirksgruppen_landesgruppe[$landesgruppe->id] = $landesgruppebezirksgruppen;
        }
        $bezirksgruppen_landesgruppe['0'] = $bezirksgruppen;

        // $bezahlarten = BezahlartResource::collection(Bezahlart::all()->sortBy("name"));

        return [
            'zuchthuendinnen' => $zuchthuendinnen,  //FIXME -
            'zuchthunde' => $zuchthunde, //FIXME -

            // ALLGEMEIN
            // 'yes_no' => [['text' => 'Ja', 'value' => 1], ['text' => 'Nein', 'value' => 0]],
            'yes_no' => [['name' => 'Ja', 'id' => 1], ['name' => 'Nein', 'id' => 0]],
            'bestaetigt_nichtbestaetigt' => [['name' => 'bestätigt', 'id' => 1], ['name' => 'nicht bestätigt', 'id' => 0]],
            'positiv_negativ' => [['name' => 'positiv', 'id' => 1], ['name' => 'negativ', 'id' => 0]],
            'yes_no_bestanden' => [['name' => 'Ja / Bestanden', 'id' => 1], ['name' => 'Nein / Nicht bestanden', 'id' => 0]],
            'yes_no_bestanden_select' => [['name' => 'Ja / Bestanden', 'id' => true], ['name' => 'Nein / Nicht bestanden', 'id' => false]],
            'bestanden' => [['name' => 'Bestanden', 'id' => 1], ['name' => 'Nicht bestanden', 'id' => 0]],
            'bestanden_select' => [['name' => 'Bestanden', 'id' => true], ['name' => 'Nicht bestanden', 'id' => false]],
            'truefalse_select' => [['name' => 'Ja', 'id' => true], ['name' => 'Nein', 'id' => false]],
            'frei_nichtfrei' => OptionNameResource::collection(OptionAllgFreiNichtfrei::all()->sortBy('order')),
            'geschlecht_hund' => OptionNameResource::collection(OptionGeschlechtHund::all()->sortBy('name')),
            'geschlecht_person' => OptionNameResource::collection(OptionGeschlechtPerson::all()->sortBy('name')),
            'anrede' => OptionNameResource::collection(OptionAnrede::all()->sortBy('order')),
            'zuchttauglichkeiten' => OptionNameResource::collection(OptionZuchttauglichkeit::all()->sortBy('order')),
            'zuchtarten' => OptionNameResource::collection(OptionZuchtart::all()->sortBy('order')),
            'zstbesichtigung_grund' => OptionNameResource::collection(OptionZstBesichtigungGrund::all()->sortBy('order')),
            'zstbesichtigung_status' => OptionNameArrayResource::collection(OptionZstBesichtigungStatus::all()->keyBy->id),
            // TAGS
            // 'tags' => OptionNameResource::collection(Tag::all()->sortBy("name")),
            // 'tags_indexed' => OptionNameArrayResource::collection(Tag::all()->keyBy->id),

            // HUND
            // 'titel_stati' => OptionNameResource::collection(OptionTitelStatus::all()->sortBy("order")),
            // 'pruefung_stati' => OptionNameResource::collection(OptionPruefungStatus::all()->sortBy("order")),
            // 'titel_typen' => TitelTypResource::collection(TitelTyp::all()->sortBy("name")),
            // 'pruefungen_typen' => PruefungTypResource::collection(PruefungTyp::all()->sortBy("name")),
            // 'anwartschaft_typen' => AnwartschaftTypResource::collection(AnwartschaftTyp::all()->sortBy("name")),
            'rassen' => RasseResource::collection($rassen),
            'farben' => $farben_rasse,

            'antrag_stati' => OptionNameResource::collection(OptionAntragStatus::all()->sortBy('order')),
            'at_standorte' => OptionNameResource::collection(OptionATStandort::all()->sortBy('order')),
            'at_stati' => OptionNameResource::collection(OptionATStatus::all()->sortBy('order')),
            'at_typen' => OptionNameResource::collection(OptionATTyp::all()->sortBy('order')),
            'lh_stati' => OptionNameResource::collection(OptionLHStatus::all()->sortBy('order')),
            'lh_typen' => OptionNameResource::collection(OptionLHTyp::all()->sortBy('order')),
            'bezahlarten' => OptionNameResource::collection(OptionBezahlart::all()->sortBy('order')),
            'bezahlstati' => OptionNameResource::collection(OptionBezahlstatus::all()->sortBy('order')),
            // 'titel_drc' => OptionNameResource::collection(TitelTyp::where('verband_verein', 'DRC')->where('championstitel', 0)->get()->sortBy("name")),
            // 'titel_champion_drc' => OptionNameResource::collection(TitelTyp::where('verband_verein', 'DRC')->where('championstitel', 1)->get()->sortBy("name")),
            // 'titel_extern' => OptionNameResource::collection(TitelTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->where('championstitel', 0)->get()->sortBy("name")),
            // 'titel_champion_extern' => OptionNameResource::collection(TitelTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->where('championstitel', 1)->get()->sortBy("name")),
            // 'pruefungen_drc' => OptionNameResource::collection(PruefungTyp::where('verband_verein', 'DRC')->get()->sortBy("name")),
            // 'pruefungen_extern' => OptionNameResource::collection(PruefungTyp::where('verband_verein', '!=', 'DRC')->orWhereNull('verband_verein')->get()->sortBy("name")),

            // MITGLIEDSCHAFT / VERANSTALTUNG
            'landesgruppen' => LandesgruppeResource::collection($landesgruppen),
            'bezirksgruppen' => $bezirksgruppen_landesgruppe,
            'mitgliedsarten' => $mitgliedsarten,
            'clubzeitungen' => OptionNameResource::collection(Clubzeitung::all()->sortBy('name')),

            // VERANSTALTUNG
            'va_kategorien' => $veranstaltungskategorien,
            'va_typen' => $veranstaltung_kat_typ,

            'va_meldeunterlagen_nicht_jagdlich' => OptionNameResource::collection(OptionVaMeldeunterlagenNichtJagdlich::all()->sortBy('order')),
            'va_meldeunterlagen_jagdlich' => OptionNameResource::collection(OptionVaMeldeunterlagenJagdlich::all()->sortBy('order')),
            'va_anmeldeoptionen' => OptionNameResource::collection(OptionVaAnmeldeoption::all()->sortBy('order')),
            'va_meldeoptionen' => OptionNameResource::collection(OptionVaMeldeoption::all()->sortBy('order')),
            'va_zahlungsoptionen' => OptionNameResource::collection(OptionVaZahlungsoption::all()->sortBy('order')),

            'va_voraussetzungen_blp' => PruefungenIdResource::collection(OptionVaVoraussetzungenBlp::all()->sortBy('order')),
            'va_voraussetzungen_hpr' => PruefungenIdResource::collection(OptionVaVoraussetzungenHpr::all()->sortBy('order')),
            'va_voraussetzungen_hpr_ap' => OptionNameResource::collection(OptionVaVoraussetzungenHprAp::all()->sortBy('order')),
            'va_voraussetzungen_rgp' => OptionNameResource::collection(OptionVaVoraussetzungenRgp::all()->sortBy('order')),
            'va_voraussetzungen_srp' => PruefungenIdResource::collection(OptionVaVoraussetzungenSrp::all()->sortBy('order')),
            'va_voraussetzungen_tpbronze' => PruefungenIdResource::collection(OptionVaVoraussetzungenTpbronze::all()->sortBy('order')),
            'va_voraussetzungen_tpsilber' => OptionNameResource::collection(OptionVaVoraussetzungenTpsilber::all()->sortBy('order')),

            // AUFGABEN
            'aufgabe_stati' => OptionNameResource::collection(OptionAufgabeStatus::all()->sortBy('order')),
            'aufgaben_templates' => \App\Models\AufgabenTemplate::select(['id', 'name', 'thema'])->orderBy('name')->get(),

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Optionen $optionen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Optionen $optionen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Optionen $optionen)
    {
        //
    }

    /**
     * Get gruppe details with bankverbindung
     */
    public function getGruppeDetails($id)
    {
        $gruppe = Gruppe::with('bankverbindung')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $gruppe,
        ]);
    }
}
