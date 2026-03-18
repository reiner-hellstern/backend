<?php

namespace App\Http\Controllers;

use App\Http\Controllers\templates\dokumente\AenderungsantrragMitgliedschaftstypController;
use App\Http\Controllers\templates\dokumente\AenderungsmeldungBankverbindungController;
use App\Http\Controllers\templates\dokumente\AenderungsmeldungKontaktdatenController;
use App\Http\Controllers\templates\dokumente\AntragAufInternationalenZwingerschutzController;
use App\Http\Controllers\templates\dokumente\AntragAufZuchtvereinWechselController;
use App\Http\Controllers\templates\dokumente\AntragAufZwingerUebernahmeController;
use App\Http\Controllers\templates\dokumente\AntragZuchtbuchuebernahmeController;
use App\Http\Controllers\templates\dokumente\AntragZuchtzulassungController;
use App\Http\Controllers\templates\dokumente\AufnahmeantragDRCVereinsmitgliedschaftController;
use App\Http\Controllers\templates\dokumente\BerichtUeberZuchtstaettenbesichtigungController;
use App\Http\Controllers\templates\dokumente\ChipnummernListeBarcodeListeController;
use App\Http\Controllers\templates\dokumente\CTEllenbogenController;
use App\Http\Controllers\templates\dokumente\DeckbescheinigungDeckmeldungController;
use App\Http\Controllers\templates\dokumente\DokumenteSandboxController;
use App\Http\Controllers\templates\dokumente\EDVerifizierungController;
use App\Http\Controllers\templates\dokumente\GelenkGutachtenController;
use App\Http\Controllers\templates\dokumente\GelenkRoentgenController;
use App\Http\Controllers\templates\dokumente\KuendigungMitgliedschaftController;
use App\Http\Controllers\templates\dokumente\WelpenkaeuferController;
use App\Http\Controllers\templates\dokumente\WurfabnahmeberichtController;
use App\Http\Controllers\templates\dokumente\ZwingerKontaktdatenAendernController;
use App\Http\Controllers\templates\dokumente\ZwingerLoeschenController;
use App\Http\Controllers\templates\jadliche\BringleistungspruefungController;
use App\Http\Controllers\templates\jadliche\GebrauchspruefungController;
use App\Http\Controllers\templates\jadliche\HeraeusController;
use App\Http\Controllers\templates\jadliche\JagdlicheAnlagensichtungController;
use App\Http\Controllers\templates\jadliche\StJohnController;
use App\Http\Controllers\templates\jadliche\TollingBronzeController;
use App\Http\Controllers\templates\jadliche\TollingSilberController;
use App\Http\Controllers\templates\jadliche\VereinspruefungController;
use App\Http\Controllers\templates\jadliche\VereinspruefungNachSchussController;
use App\Http\Controllers\templates\nicht_jadliche\ArbeitspruefungMitDummiesController;
use App\Http\Controllers\templates\nicht_jadliche\FormwertbeurteilungController;
use App\Http\Controllers\templates\nicht_jadliche\NachsuchenberichtController;
use App\Http\Controllers\templates\nicht_jadliche\PruefungsleiterberichtController;
use App\Http\Controllers\templates\nicht_jadliche\WesenstestController;
use App\Http\Controllers\templates\oeffentlich\AuftragZurEinlagerungVonBlutController;
use App\Http\Controllers\templates\oeffentlich\DnaProfilGentestFormularController;
use App\Http\Controllers\templates\oeffentlich\ZahnstatusTAFormularController;
use App\Models\Pruefung;
use ErrorException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class RoutingController extends Controller
{
    public function lists()
    {
        return view('pdf.dokumente');
    }

    public function pruefungen(string $name, string $formDataAsJson = '')
    {
        switch ($name) {
            case 'heraeus':
                $controller = new HeraeusController();

                return $controller->show($formDataAsJson);
            case 'toller-bronze':
                $controller = new TollingBronzeController();

                return $controller->show($formDataAsJson);
            case 'toller-silber':
                $controller = new TollingSilberController();

                return $controller->show($formDataAsJson);
            case 'vereinspruefung-mit-rb':
                $controller = new VereinspruefungController();

                return $controller->show(true);
            case 'vereinspruefung-ohne-rb':
                $controller = new VereinspruefungController();

                return $controller->show(false);
            case 'vereinspruefung-nach-schuss':
                $controller = new VereinspruefungNachSchussController();

                return $controller->show($formDataAsJson);
            case 'st-john':
                $controller = new StJohnController();

                return $controller->show($formDataAsJson);
            case 'jagdliche-anlagensichtung':
                $controller = new JagdlicheAnlagensichtungController();

                return $controller->show($formDataAsJson);
            case 'bringleistungspruefung':
                $controller = new BringleistungspruefungController();

                return $controller->show($formDataAsJson);
            case 'gebrauchspruefung':
                $controller = new GebrauchspruefungController();

                return $controller->show($formDataAsJson);
            case 'njp-formwert':
                $controller = new FormwertbeurteilungController();

                return $controller->show($formDataAsJson);
            case 'njp-wesenstest':
                $controller = new WesenstestController();

                return $controller->show($formDataAsJson);
            case 'njp-arbeitspruefung-mit-dummies':
                $controller = new ArbeitspruefungMitDummiesController();

                return $controller->show($formDataAsJson);
            case 'nachsuchenbericht-mit-rb':
                $controller = new NachsuchenberichtController();

                return $controller->show(true);
            case 'nachsuchenbericht-ohne-rb':
                $controller = new NachsuchenberichtController();

                return $controller->show(false);
            case 'pruefungsleiterbericht':
                $pruefung = Pruefung::find(532);
                $controller = new PruefungsleiterberichtController();

                return $controller->show($pruefung);
            default:
                throw new ErrorException('404 page not found');
        }
    }

    public function oeffentliche(string $name, string $formDataAsJson = '')
    {
        switch ($name) {
            case 'auftrag-zur-einlagerung-von-blut':
                $controller = new AuftragZurEinlagerungVonBlutController();

                return $controller->show($formDataAsJson);
            case 'dna-profil-gentest-formular':
                $controller = new DnaProfilGentestFormularController();

                return $controller->show($formDataAsJson);
            case 'zahnstatus-ta-formular':
                $controller = new ZahnstatusTAFormularController();

                return $controller->show();
            default:
                throw new ErrorException('404 page not found');
        }
    }

    public function dokumente(string $name, string $formDataAsJson = '')
    {
        switch ($name) {
            case 'sandbox':
                $controller = new DokumenteSandboxController();

                return $controller->show();
            case 'kuendigung-drc-mitgliedschaft':
                $controller = new KuendigungMitgliedschaftController();

                return $controller->show($formDataAsJson);
            case 'antrag-zuchtbuchuebernahme':
                $controller = new AntragZuchtbuchuebernahmeController();

                return $controller->show();
            case 'antrag-zuchtzulassung':
                $controller = new AntragZuchtzulassungController();

                return $controller->show();
            case 'deckbescheinigung-deckmeldung':
                $controller = new DeckbescheinigungDeckmeldungController();

                return $controller->show();
            case 'wurfabnahmebericht':
                $controller = new WurfabnahmeberichtController();

                return $controller->show($formDataAsJson);
            case 'wurfabnahmebericht-drc-version':
                $controller = new WurfabnahmeberichtController();

                return $controller->showDRCVersion($formDataAsJson);
            case 'wurfabnahmebericht-kaeufer-version':
                $controller = new WurfabnahmeberichtController();

                return $controller->showKaeuferVersion($formDataAsJson);
            case 'chipnummern-liste-barcode-liste':
                $controller = new ChipnummernListeBarcodeListeController();

                return $controller->show();
            case 'welpenkaeufer':
                $controller = new WelpenkaeuferController();

                return $controller->show();
            case 'aufnahmeantrag-vereinsmitgliedschaft':
                $controller = new AufnahmeantragDRCVereinsmitgliedschaftController();

                return $controller->show();
            case 'aenderungsmeldung-bankverbindung':
                $controller = new AenderungsmeldungBankverbindungController();

                return $controller->show($formDataAsJson);
            case 'aenderungsmeldung-kontaktdaten':
                $controller = new AenderungsmeldungKontaktdatenController();

                return $controller->show();
            case 'aenderungsantrag-vereinsmitgliedschaftstyp':
                $controller = new AenderungsantrragMitgliedschaftstypController();

                return $controller->show();
            case 'gelenk-gutachten':
                $controller = new GelenkGutachtenController();

                return $controller->show($formDataAsJson);
            case 'ed-verifizierung':
                $controller = new EDVerifizierungController();

                return $controller->show($formDataAsJson);
            case 'gelenk-roentgen':
                $controller = new GelenkRoentgenController();

                return $controller->show($formDataAsJson);
            case 'ct-ellenbogen':
                $controller = new CTEllenbogenController();

                return $controller->show($formDataAsJson);
            case 'antrag-auf-internationalen-zwingerschutz':
                $controller = new AntragAufInternationalenZwingerschutzController();

                return $controller->show();
            case 'bericht-ueber-zuchtstaettenbesichtigung':
                $controller = new BerichtUeberZuchtstaettenbesichtigungController();

                return $controller->show();
            case 'antrag-auf-zwinger-uebernahme':
                $controller = new AntragAufZwingerUebernahmeController();

                return $controller->show($formDataAsJson);
            case 'antrag-auf-zuchtverein-wechsel':
                $controller = new AntragAufZuchtvereinWechselController();

                return $controller->show();
            case 'zwinger-loeschen':
                $controller = new ZwingerLoeschenController();

                return $controller->show();
            case 'zwinger-kontaktdaten-aendern':
                $controller = new ZwingerKontaktdatenAendernController();

                return $controller->show();
            default:
                throw new RouteNotFoundException('404 page not found');
        }
    }
}
