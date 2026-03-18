<?php

use App\Http\Controllers\AbilityController;
use App\Http\Controllers\AbstammungsnachweisController;
use App\Http\Controllers\AdminAbilityController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AhnentafelController;
use App\Http\Controllers\AnwartschaftController;
use App\Http\Controllers\AnwartschaftenTypenController;
use App\Http\Controllers\APDRController;
use App\Http\Controllers\ArztController;
use App\Http\Controllers\AufgabeController;
use App\Http\Controllers\AufgabenTemplateController;
use App\Http\Controllers\AugenuntersuchungController;
use App\Http\Controllers\AusbilderController;
use App\Http\Controllers\BankImportController;
use App\Http\Controllers\BankImportTestController;
use App\Http\Controllers\BankverbindungController;
use App\Http\Controllers\BasisdatenController;
use App\Http\Controllers\BestaetigungController;
use App\Http\Controllers\BezirksgruppeController;
use App\Http\Controllers\BezirksgruppenwechselController;
use App\Http\Controllers\BHPController;
use App\Http\Controllers\BLPController;
use App\Http\Controllers\BlutprobeneinlagerungController;
use App\Http\Controllers\BugtrackController;
use App\Http\Controllers\DeckruedeController;
use App\Http\Controllers\DoktreeController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\DokumentenkategorieController;
use App\Http\Controllers\DsgvoErklaerungController;
use App\Http\Controllers\EigentuemerController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EpilepsiebefundController;
use App\Http\Controllers\FCPController;
use App\Http\Controllers\FEUserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormwertController;
use App\Http\Controllers\GebuehrController;
use App\Http\Controllers\GebuehrengruppeController;
use App\Http\Controllers\GebuehrenkatalogController;
use App\Http\Controllers\GebuehrenordnungController;
use App\Http\Controllers\GentestController;
use App\Http\Controllers\GruppenController;
use App\Http\Controllers\HDEDUntersuchungController;
use App\Http\Controllers\HodenController;
use App\Http\Controllers\HPRController;
use App\Http\Controllers\HundabgabeantragController;
use App\Http\Controllers\HundanlageantragController;
use App\Http\Controllers\HundController;
use App\Http\Controllers\HundefuehrerController;
use App\Http\Controllers\HundPrerenderedController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InfotexteController;
use App\Http\Controllers\JASController;
use App\Http\Controllers\KaiserschnittController;
use App\Http\Controllers\KardiobefundController;
use App\Http\Controllers\KastrationSterilisationController;
use App\Http\Controllers\KommentarController;
use App\Http\Controllers\KontaktdatenaenderungController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LandesgruppeController;
use App\Http\Controllers\LeihstellungController;
use App\Http\Controllers\LeistungsheftController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LinkkategorieController;
use App\Http\Controllers\MainMenuItemController;
use App\Http\Controllers\MitgliedController;
use App\Http\Controllers\MitgliedschaftskuendigungController;
use App\Http\Controllers\MockTrailController;
use App\Http\Controllers\NeuzuechterseminarController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\NotizController;
use App\Http\Controllers\OCDUntersuchungController;
use App\Http\Controllers\OptionenController;
use App\Http\Controllers\OptionenEintragController;
use App\Http\Controllers\OptionenlistenController;
use App\Http\Controllers\OrgatreeController;
use App\Http\Controllers\ParallelwurfantragController;
use App\Http\Controllers\PatellaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PersonController;
// use App\Http\Controllers\PruefungsleiterberichtJagdController;
use App\Http\Controllers\PnSController;
use App\Http\Controllers\ProfileDokumenteItemController;
use App\Http\Controllers\ProfileVerwaltungItemController;
use App\Http\Controllers\PruefungController;
use App\Http\Controllers\PruefungsergebnisGenerischController;
use App\Http\Controllers\PruefungTypController;
use App\Http\Controllers\RechnungController;
use App\Http\Controllers\RechnungExportController;
use App\Http\Controllers\RechnungspostenController;
use App\Http\Controllers\RGPController;
use App\Http\Controllers\RichterController;
// use App\Http\Controllers\RechnungsexportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RSwPController;
use App\Http\Controllers\RSwPoRbController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\SchusstestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SonderleiterController;
use App\Http\Controllers\SRPController;
use App\Http\Controllers\StammbaumController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TitelController;
use App\Http\Controllers\TitelTypController;
use App\Http\Controllers\TPTollerBronzeController;
use App\Http\Controllers\TPTollerSilberController;
use App\Http\Controllers\UebernahmeantragController;
use App\Http\Controllers\UreterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuItemController;
use App\Http\Controllers\VeranstaltungController;
use App\Http\Controllers\VeranstaltungMeldungController;
use App\Http\Controllers\VeranstaltungTeamController;
use App\Http\Controllers\VerstorbeneController;
use App\Http\Controllers\WesenstestController;
use App\Http\Controllers\WorkingtestEinzelController;
use App\Http\Controllers\WorkingtestTeamController;
use App\Http\Controllers\WurfController;
use App\Http\Controllers\ZahnstatusController;
use App\Http\Controllers\ZuchthuendinController;
use App\Http\Controllers\ZuchtrassenantragController;
use App\Http\Controllers\ZuchtstaetteController;
use App\Http\Controllers\ZuchtstaettenbesichtigungController;
use App\Http\Controllers\ZuchtverbotController;
use App\Http\Controllers\ZuchtwartController;
use App\Http\Controllers\ZuchtzulassungsantragController;
use App\Http\Controllers\ZuechterController;
use App\Http\Controllers\ZweitwohnsitznachweisController;
use App\Http\Controllers\ZwingerController;
use App\Http\Controllers\ZwingerschutzController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('veranstaltungen/suche', [VeranstaltungController::class, 'suche']);

Route::get('bestaetigung/confirm/{bestaetigung:uuid}', [BestaetigungController::class, 'confirm']);
Route::get('bestaetigung/reject/{bestaetigung:uuid}', [BestaetigungController::class, 'reject']);

Route::post('print-deckbescheinigung', [PDFController::class, 'deckbescheinigung']);
Route::post('print-zustimmung-zuchtbuchuebernahme', [PDFController::class, 'zustimmung_zuchtbuchuebernahme']);
Route::post('print-zustimmung-ahnentafelzweitschrift', [PDFController::class, 'zustimmung_ahnentafelzweitschrift']);
Route::post('print-zustimmung-zuchtzulassung', [PDFController::class, 'zustimmung_zuchtzulassung']);

Route::post('feuser/checkauth', [FEUserController::class, 'checkAuth']);
Route::post('feuser/create', [FEUserController::class, 'create']);
Route::delete('feuser/delete', [FEUserController::class, 'delete']);
Route::put('feuser/update', [FEUserController::class, 'update']);
Route::get('feuser/sync', [FEUserController::class, 'sync']);

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();

    return [
        'user' => $user,
        'environment' => [
            'name' => app()->environment(),
            'is_development' => app()->environment(['local', 'development']),
            'test_email_enabled' => config('mail.test_override', false),
        ],
    ];
});

Route::middleware('auth:sanctum')->get('/users/{user}', function (Request $request) {
    return $request->user();
});

// CASL Abilities API
Route::middleware('auth:sanctum')->get('/abilities', [AbilityController::class, 'index']);
Route::middleware('auth:sanctum')->post('/abilities/refresh', [AbilityController::class, 'refresh']);

Route::post('users/storeimg', [FileController::class, 'store_image_profile']);

Route::get('test', [TestController::class, 'test']);

Route::post('hunde', [HundController::class, 'index']);
Route::post('hunde/prefilter/{prefilter?}', [HundController::class, 'prefilter']);
Route::get('hunde/zucht', [HundController::class, 'zucht']);
Route::post('hunde/suche', [HundController::class, 'suche']);
Route::post('hunde/autocomplete', [HundController::class, 'autocomplete']);
Route::post('hunde/auto', [HundController::class, 'auto']);
Route::get('hunde/auto/deckrueden/{hund}', [HundController::class, 'auto_matching_deckrueden']);
Route::get('hund/full/{hund}', [HundController::class, 'getAll']);
Route::post('hund/bereiche/{hund}', [HundController::class, 'getBereiche']);
Route::get('hund/detail/{id}', [HundController::class, 'detail']);
Route::get('hund/{hund}', [HundController::class, 'getAll']);
Route::get('hund/short/{id}', [HundController::class, 'short']);
Route::get('hund/profildaten/{id}', [HundController::class, 'profildaten']);
Route::put('hunde/update/', [HundController::class, 'hunde_update']);
Route::put('hund/update/{hund}', [HundController::class, 'hund_update']);
Route::post('hund/store', [HundController::class, 'store']);
Route::post('hund/create', [HundController::class, 'create']);
Route::post('hund/storeimg', [FileController::class, 'store_image_hund']);
Route::post('hund/imgorder', [HundController::class, 'store_images_order']);
Route::post('hund/deleteimg', [FileController::class, 'delete_image_hund']);
Route::get('hund/pruefungen/{hund}', [PruefungController::class, 'hund']);
Route::post('hund/zuchtverbot', [ZuchtverbotController::class, 'store']);
Route::delete('hund/zuchtverbot/{id}', [ZuchtverbotController::class, 'destroy']);
Route::put('hund/zuchtverbot/{id}', [ZuchtverbotController::class, 'update']);
Route::get('hund/eigentuemers/{hund_id}', [HundController::class, 'getEigentuemers']);

// Hundeabgabe
Route::get('hund/abgabe/{hund_id}', [HundabgabeantragController::class, 'show']);
Route::post('hund/abgabe/store', [HundabgabeantragController::class, 'store']);

// Verstorbene (Sterbedatum)
Route::get('hund/verstorbene/{hund_id}', [VerstorbeneController::class, 'show']);
Route::post('hund/verstorbene/store', [VerstorbeneController::class, 'store']);
Route::put('hund/verstorbene/{id}', [VerstorbeneController::class, 'update']);

Route::put('hund/basisdaten/{hund}', [BasisdatenController::class, 'update']);

Route::put('eigentuemer/{eigentuemer}', [EigentuemerController::class, 'update']);
Route::post('eigentuemer', [EigentuemerController::class, 'store']);
Route::post('hund/{hund_id}/eigentuemer', [EigentuemerController::class, 'addEigentuemer']);
Route::get('hund/{hund_id}/eigentuemer', [EigentuemerController::class, 'getCurrentOwners']);
Route::delete('hund/{hund_id}/eigentuemer/cleanup', [EigentuemerController::class, 'cleanupDuplicateOwners']);

Route::get('hundprerendered/prerender/{id}', [HundPrerenderedController::class, 'prerender']);
Route::get('hundprerendered/{hundprerendered}', [HundPrerenderedController::class, 'show']);

// HUND GESUNDHEIT

// MEHRFACHE FORMULARE
Route::post('zahnstatus', [ZahnstatusController::class, 'store']);
Route::post('augenuntersuchung', [AugenuntersuchungController::class, 'store']);
Route::post('hdeduntersuchung', [HDEDUntersuchungController::class, 'store']);
Route::post('ocduntersuchung', [OCDUntersuchungController::class, 'store']);
Route::post('gentest', [GentestController::class, 'store']);
Route::post('kardiobefund', [KardiobefundController::class, 'store']);
Route::post('epilepsiebefund', [EpilepsiebefundController::class, 'store']);
Route::post('hoden', [HodenController::class, 'store']);
Route::post('kaiserschnitt', [KaiserschnittController::class, 'store']);

Route::put('zahnstatus/{id}', [ZahnstatusController::class, 'update']);
Route::put('augenuntersuchung/{id}', [AugenuntersuchungController::class, 'update']);
Route::put('hdeduntersuchung/{id}', [HDEDUntersuchungController::class, 'update']);
Route::put('ocduntersuchung/{id}', [OCDUntersuchungController::class, 'update']);
Route::put('gentest/{id}', [GentestController::class, 'update']);
Route::put('kardiobefund/{id}', [KardiobefundController::class, 'update']);
Route::put('epilepsiebefund/{id}', [EpilepsiebefundController::class, 'update']);
Route::put('hoden/{hoden}', [HodenController::class, 'update']);
Route::put('kaiserschnitt/{kaiserschnitt}', [KaiserschnittController::class, 'update']);

Route::delete('zahnstatus/{id}', [ZahnstatusController::class, 'destroy']);
Route::delete('augenuntersuchung/{id}', [AugenuntersuchungController::class, 'destroy']);
Route::delete('hdeduntersuchung/{id}', [HDEDUntersuchungController::class, 'destroy']);
Route::delete('ocduntersuchung/{id}', [OCDUntersuchungController::class, 'destroy']);
Route::delete('gentest/{id}', [GentestController::class, 'destroy']);
Route::delete('kardiobefund/{id}', [KardiobefundController::class, 'destroy']);
Route::delete('epilepsiebefund/{id}', [EpilepsiebefundController::class, 'destroy']);
Route::delete('hoden/{hoden}', [HodenController::class, 'destroy']);
Route::delete('kaiserschnitt/{kaiserschnitt}', [KaiserschnittController::class, 'destroy']);

// EINFACHE FORMULARE
Route::get('blutprobeneinlagerung/check/{hund_id}', [BlutprobeneinlagerungController::class, 'checkExisting']);
Route::post('fcp', [FCPController::class, 'store']);
Route::post('patella', [PatellaController::class, 'store']);
Route::post('rute', [RuteController::class, 'store']);
Route::post('blutprobeneinlagerung', [BlutprobeneinlagerungController::class, 'store']);
Route::post('abstammungsnachweis', [AbstammungsnachweisController::class, 'store']);
Route::post('ureter', [UreterController::class, 'store']);
Route::get('kastrationsterilisation/check/{hund_id}', [KastrationSterilisationController::class, 'checkExisting']);
Route::post('kastrationsterilisation', [KastrationSterilisationController::class, 'store']);
Route::get('leihstellung/check/{hund_id}', [LeihstellungController::class, 'checkActive']);
Route::post('leihstellung', [LeihstellungController::class, 'store']);
Route::post('leihstellung/{id}/approve', [LeihstellungController::class, 'approve']);
Route::put('leihstellung/{id}', [LeihstellungController::class, 'update']);

Route::put('fcp/{fcp}', [FCPController::class, 'update']);
Route::put('patella/{patella}', [PatellaController::class, 'update']);
Route::put('rute/{rute}', [RuteController::class, 'update']);
Route::put('blutprobeneinlagerung/{blutprobeneinlagerung}', [BlutprobeneinlagerungController::class, 'update']);
Route::put('abstammungsnachweis/{abstammungsnachweis}', [AbstammungsnachweisController::class, 'update']);
Route::put('kardiobefund/{kardiobefund/}', [KardiobefundController::class, 'update']);
Route::put('epilepsiebefund/{epilepsiebefund}', [EpilepsiebefundController::class, 'update']);
Route::put('ureter/{ureter}', [UreterController::class, 'update']);
Route::put('kastrationsterilisation/{kastrationsterilisation}', [KastrationSterilisationController::class, 'update']);

// HUND TITEL
Route::get('titeltyp/{titeltyp}', [TitelTypController::class, 'show']);
Route::post('titeltypen/autocomplete', [TitelTypController::class, 'autocomplete']);
Route::post('titeltypen/autocomplete_select', [TitelTypController::class, 'autocomplete_select']);
Route::post('anwartschaftentypen/autocomplete', [AnwartschaftenTypenController::class, 'autocomplete']);
Route::post('anwartschaft', [AnwartschaftController::class, 'store']);
Route::post('titel/storeimg', [FileController::class, 'store_image_titel']);
Route::post('titel/antragchampionstitel', [TitelController::class, 'store_antragchampionstitel']);
Route::post('titels/checkstring', [TitelController::class, 'check_string']);

Route::post('titels/store', [TitelController::class, 'store']);
Route::post('titelmeldung', [TitelController::class, 'meldung_store']);
Route::put('titelmeldung/{titelmeldung}', [TitelController::class, 'meldung_update']);
Route::delete('titelmeldung/{titelmeldung}', [TitelController::class, 'meldung_destroy']);
Route::post('titel', [TitelController::class, 'store']);
Route::put('titel/{titel}', [TitelController::class, 'update']);
Route::delete('titel/{titel}', [TitelController::class, 'destroy']);

// HUND PRUEFUNGEN
Route::get('pruefungstyp/{pruefungstyp}', [PruefungTypController::class, 'show']);
Route::post('pruefungtypen/autocomplete', [PruefungTypController::class, 'autocomplete']);
Route::post('pruefungtypen/autocomplete_select', [PruefungTypController::class, 'autocomplete_select']);
Route::post('pruefungen/checkstring', [PruefungController::class, 'check_string']);

Route::post('pruefung', [PruefungController::class, 'store']);
Route::put('pruefung/{pruefung}', [PruefungController::class, 'update']);
Route::delete('pruefung/{pruefung}', [PruefungController::class, 'destroy']);
Route::post('pruefungsmeldung', [PruefungController::class, 'meldung_store']);
Route::put('pruefungsmeldung/{pruefung}', [PruefungController::class, 'meldung_update']);
Route::delete('pruefungsmeldung/{pruefung}', [PruefungController::class, 'meldung_destroy']);

Route::get('pruefungsergebnisgenerisch', [PruefungsergebnisGenerischController::class, 'index']);
Route::get('pruefungsergebnisgenerisch/{pruefung}', [PruefungsergebnisGenerischController::class, 'show']);
Route::post('pruefungsergebnisgenerisch', [PruefungsergebnisGenerischController::class, 'store']);
Route::put('pruefungsergebnisgenerisch/{pruefung}', [PruefungsergebnisGenerischController::class, 'update']);
Route::delete('pruefungsergebnisgenerisch/{pruefung}', [PruefungsergebnisGenerischController::class, 'destroy']);
Route::get('pruefungsergebnisgenerisch/meldung/{pruefung}', [PruefungsergebnisGenerischController::class, 'meldung_show']);
Route::post('pruefungsergebnisgenerisch/meldung', [PruefungsergebnisGenerischController::class, 'meldung_store']);
Route::put('pruefungsergebnisgenerisch/meldung/{pruefung}', [PruefungsergebnisGenerischController::class, 'meldung_update']);
Route::delete('pruefungsergebnisgenerisch/meldung/{pruefung}', [PruefungsergebnisGenerischController::class, 'meldung_destroy']);

Route::get('ahnentafel/single/{hund}', [StammbaumController::class, 'single']);
Route::get('stammbaum/nachkommen/{hund}', [StammbaumController::class, 'nachkommen']);
// Route::get('ahnentafel/{hund}',[StammbaumController::class, 'eltern']);
Route::post('ahnentafelantrag/meta', [AhnentafelController::class, 'meta']);
Route::get('ahnentafel/{id}', [AhnentafelController::class, 'show']);
Route::post('ahnentafel', [AhnentafelController::class, 'store']);
Route::put('ahnentafel/{ahnentafel}', [AhnentafelController::class, 'update']);
Route::post('atzweitschriftantrag/meta', [AhnentafelController::class, 'meta']);
Route::post('hund/atzweitschriftantrag', [AhnentafelController::class, 'storeZweitschrift']);

Route::post('leistungshefte', [LeistungsheftController::class, 'index']);
Route::get('leistungsheft/meta', [LeistungsheftController::class, 'meta']);
Route::get('leistungsheft/bestelldaten/{hund_id}', [LeistungsheftController::class, 'getBestelldaten']);
Route::post('leistungsheft/bestellung', [LeistungsheftController::class, 'storeBestellung']);
Route::get('leistungsheft/{leistungsheft}', [LeistungsheftController::class, 'show']);
Route::post('leistungsheft', [LeistungsheftController::class, 'store']);
Route::put('leistungsheft/{leistungsheft}', [LeistungsheftController::class, 'update']);
Route::get('leistungshefte/{id}', [LeistungsheftController::class, 'index_hund']);

// DSGVO-Erklärungen
Route::get('dsgvo-erklaerungen', [DsgvoErklaerungController::class, 'index']);
Route::get('dsgvo-erklaerung/aktiv', [DsgvoErklaerungController::class, 'aktiv']);
Route::post('dsgvo-erklaerung', [DsgvoErklaerungController::class, 'store']);
Route::put('dsgvo-erklaerung/{id}/widerrufen', [DsgvoErklaerungController::class, 'widerrufen']);
Route::delete('dsgvo-erklaerung/{id}', [DsgvoErklaerungController::class, 'destroy']);

Route::post('personen', [PersonController::class, 'index']);
Route::get('personen/{id}/bankverbindungen', [PersonController::class, 'getPersonWithBankverbindungen']);
Route::get('personen/autocomplete', [PersonController::class, 'autocompleteRichter']);
// Route::get('persons/search', [PersonController::class, 'search']);
Route::post('person/autocomplete', [PersonController::class, 'autocomplete']);
Route::get('person/show/{person}', [PersonController::class, 'show']);
Route::get('person/get-mitgliedsnummer/{id}', [PersonController::class, 'get_mitgliedsnummer']);
Route::get('person/personenakte/{person}', [PersonController::class, 'personenakte']);
Route::get('person/hunde/{id}', [PersonController::class, 'hunde']);
Route::get('person/zuchthunde/{id}', [PersonController::class, 'zuchthunde']);
Route::get('person/zwinger/{id}', [PersonController::class, 'zwinger']);
Route::get('person/mitgliedschaft/{id}', [PersonController::class, 'mitgliedschaft']);
Route::post('personen/suche', [PersonController::class, 'suche']);
Route::get('person/auto', [PersonController::class, 'auto']);
Route::get('person/daten', [PersonController::class, 'person']); // ->middleware('cacheResponse:600');
//Route::get('person/daten',[PersonController::class, 'person']);
Route::put('personen/update/', [PersonController::class, 'personen_update']);
Route::put('person/update/{person}', [PersonController::class, 'person_update']);
Route::post('person/updatekontakt', [PersonController::class, 'update_kontakt']);

Route::get('person/rechnungen/{id}/', [PersonController::class, 'rechnungen']);
Route::get('person/rechnungen/years/{id}', [PersonController::class, 'rechnungenYears']);

Route::post('person/adelstitel/autocomplete', [PersonController::class, 'autocomplete_adelstitel']);
Route::post('person/akademischetitel/autocomplete', [PersonController::class, 'autocomplete_akademische_titel']);

Route::post('veranstaltungen', [VeranstaltungController::class, 'index']);
Route::get('veranstaltung/{veranstaltung}', [VeranstaltungController::class, 'show']);
Route::get('veranstaltung/{veranstaltung}/meldung/{person_id?}', [VeranstaltungController::class, 'meldung']);
Route::post('veranstaltung', [VeranstaltungController::class, 'store']);
Route::post('veranstaltung/teilnehmer', [VeranstaltungController::class, 'store_teilnehmer']);
Route::post('veranstaltung/storeteams', [VeranstaltungTeamController::class, 'store_teams']);
Route::post('veranstaltung/addteam', [VeranstaltungTeamController::class, 'add_team']);
Route::post('veranstaltung/removeteam', [VeranstaltungTeamController::class, 'remove_team']);

Route::post('veranstaltung/addmeldung', [VeranstaltungMeldungController::class, 'add_meldung']);
Route::get('veranstaltung/anmeldung/{veranstaltung}', [VeranstaltungController::class, 'info']);
Route::post('veranstaltung/anmeldung', [VeranstaltungMeldungController::class, 'anmeldung']);

Route::post('apdr1', [APDRController::class, 'store_v1']);
Route::post('bhp1', [BHPController::class, 'store_v1']);
Route::post('blp1', [BLPController::class, 'store_v1']);
Route::post('formwert1', [FormwertController::class, 'store_v1']);
Route::post('hpr1', [HPRController::class, 'store_v1']);
Route::post('jas1', [JASController::class, 'store_v1']);
Route::post('jas2', [JASController::class, 'store_v2']);
Route::post('mocktrail1', [MockTrailController::class, 'store_v1']);
Route::post('pns1', [PnSController::class, 'store_v1']);
Route::post('rgp1', [RGPController::class, 'store_v1']);
Route::post('rgp2', [RGPController::class, 'store_v2']);
Route::post('rswp1', [RSwPController::class, 'store_v1']);
Route::post('rswporb1', [RSwPoRbController::class, 'store_v1']);
Route::post('schusstest1', [SchusstestController::class, 'store_v1']);
Route::post('srp1', [SRPController::class, 'store_v1']);
Route::post('tptollerbronze1', [TPTollerBronzeController::class, 'store_v1']);
Route::post('tptollerbronze2', [TPTollerBronzeController::class, 'store_v2']);
Route::post('tptollersilber1', [TPTollerSilberController::class, 'store_v1']);
Route::post('wesenstest1', [WesenstestController::class, 'store_v1']);
Route::post('wesenstest2', [WesenstestController::class, 'store_v2']);
Route::post('workingteste1', [WorkingtestEinzelController::class, 'store_v1']);
Route::post('workingtestec1', [WorkingtestEinzelController::class, 'store_cell_v1']);
Route::post('workingtestea1', [WorkingtestEinzelController::class, 'store_aufgabe_v1']);
Route::post('workingtestt1', [WorkingtestTeamController::class, 'store_v1']);
Route::post('workingtesttc1', [WorkingtestTeamController::class, 'store_cell_v1']);
Route::post('workingtestta1', [WorkingtestTeamController::class, 'store_aufgabe_v1']);
Route::post('workingtestteams', [WorkingtestTeamController::class, 'store_teams_v1']);
// Route::post('plberichtjagd1',[PruefungsleiterberichtJagdController::class, 'store_v1']);

Route::post('wuerfe', [WurfController::class, 'index']);
Route::get('wurf/{wurf}', [WurfController::class, 'show']);
Route::get('wurf/welpen/{wurf}', [WurfController::class, 'welpen']);
Route::post('wuerfe/suche', [WurfController::class, 'suche']);
Route::post('wuerfe/welpensuche', [WurfController::class, 'welpensuche']);
Route::get('wuerfe/auto', [WurfController::class, 'auto']);
Route::put('wuerfe/update', [WurfController::class, 'wuerfe_update']);
Route::put('wurf/update/{wurf}', [WurfController::class, 'wurf_update']);
Route::post('wurf', [WurfController::class, 'store']);
Route::post('wurf/storeimg', [FileController::class, 'store_image_wurf']);
Route::post('wurf/deleteimg', [FileController::class, 'delete_image_wurf']);

Route::post('mitglieder', [MitgliedController::class, 'index']);
Route::post('mitglieder/prefilter/{typ?}', [MitgliedController::class, 'prefilter']);
Route::get('mitglieder/familie', [MitgliedController::class, 'index_familie']);
Route::get('mitglieder/jugend', [MitgliedController::class, 'index_jugend']);
Route::get('mitglieder/test/{test?}', [MitgliedController::class, 'test']);
Route::get('mitglieder/suche', [MitgliedController::class, 'suche']);
Route::post('mitglied/autocomplete', [MitgliedController::class, 'autocomplete']);
Route::get('mitglieder/show/{mitglied}', [MitgliedController::class, 'show']);
Route::get('mitglieder/get/{id}', [MitgliedController::class, 'get']);
Route::put('mitglieder/update/', [MitgliedController::class, 'mitglieder_update']);
Route::put('mitglied/update/{person}', [MitgliedController::class, 'mitglied_update']);

Route::post('hundefuehrer', [HundefuehrerController::class, 'index']);
Route::get('hundefuehrer/show/{hundefuehrer}', [HundefuehrerController::class, 'show']);
Route::get('hundefuehrer/meldungen/{hundefuehrer}', [HundefuehrerController::class, 'meldungen']);
Route::post('hundefuehrer/store', [HundefuehrerController::class, 'store']);
Route::put('hundefuehrer/update/{richter}', [RichterController::class, 'update']);

// RESTful Richter API
Route::get('richter', [RichterController::class, 'index']);
Route::post('richter', [RichterController::class, 'store']);
Route::put('richter/{richter}', [RichterController::class, 'update']);
Route::delete('richter/{richter}', [RichterController::class, 'destroy']);
Route::get('richter/status', [RichterController::class, 'getStatus']);
Route::get('richter/richtertypen', [RichterController::class, 'getRichtertypen']);

// Legacy Richter API (für Kompatibilität)
Route::post('richter/legacy', [RichterController::class, 'legacyIndex']);
Route::post('richter/suche', [RichterController::class, 'suche']);
Route::post('richter/auto', [RichterController::class, 'auto']);
Route::get('richter/show/{person}', [RichterController::class, 'show']);
Route::post('richter/store/legacy', [RichterController::class, 'legacyStore']);
Route::put('richter/update', [RichterController::class, 'richters_update']);
Route::put('richter/update/{richter}', [RichterController::class, 'richter_update']);

Route::post('aerzte', [ArztController::class, 'index']);
Route::get('aerzte', [ArztController::class, 'getAerzte']);
Route::post('aerzte/suche', [ArztController::class, 'suche']);
Route::get('arzt/show/{arzt}', [ArztController::class, 'show']);
Route::post('arzt/store', [ArztController::class, 'store']);
Route::post('arzt/store-new', [ArztController::class, 'storeNew']);
Route::put('arzt/update/{arzt}', [ArztController::class, 'update']);
Route::post('arzt/autocomplete', [ArztController::class, 'autocomplete']);
Route::get('arzt/create', [ArztController::class, 'create']);
Route::get('arzt/fachgebiete', [ArztController::class, 'getFachgebiete']);

Route::post('labore', [LaborController::class, 'index']);
Route::post('labore/suche', [LaborController::class, 'suche']);
Route::get('labor/show/{labor}', [LaborController::class, 'show']);
Route::post('labor/store', [LaborController::class, 'store']);
Route::put('labor/update/{labor}', [LaborController::class, 'update']);
Route::post('labor/autocomplete', [LaborController::class, 'autocomplete']);

Route::post('zwinger', [ZwingerController::class, 'index']);
Route::get('zwinger/wuerfe/{id}', [ZwingerController::class, 'wuerfe']);
Route::get('zwinger/personen/{id}', [ZwingerController::class, 'personen']);
Route::post('zwinger/suche', [ZwingerController::class, 'suche']);
Route::post('zwinger/auto', [ZwingerController::class, 'auto']);
Route::get('zwinger/zwingerakte/{zwinger}', [ZwingerController::class, 'zwingerakte']);
Route::get('zwinger/show/{zwinger}', [ZwingerController::class, 'show']);
Route::put('zwingers/update', [ZwingerController::class, 'zwingers_update']);
Route::put('zwinger/update/{zwinger}', [ZwingerController::class, 'zwinger_update']);
Route::put('zwinger/kontaktdaten/update', [ZwingerController::class, 'kontaktdaten_update']);
Route::post('zwinger/storeimg', [FileController::class, 'store_image_zwinger']);
Route::post('zwinger/imgorder', [ZwingerController::class, 'store_images_order']);
Route::post('zwinger/deleteimg', [FileController::class, 'delete_image_zwinger']);
Route::post('zwinger/autocomplete', [ZwingerController::class, 'autocomplete']);
Route::post('zwinger/zuechter/autocomplete', [ZwingerController::class, 'zuechter_autocomplete']);

Route::post('zwinger/zuchtrasse', [ZwingerController::class, 'zuchtrasse_store']);
Route::put('zwinger/zuchtrasse/update', [ZwingerController::class, 'zuchtrasse_update']);
Route::delete('zwinger/zuchtrasse', [ZwingerController::class, 'zuchtrasse_delete']);
Route::post('zwinger/parallelwurf', [ZwingerController::class, 'parallelwurf_store']);
Route::delete('zwinger/parallelwurf', [ZwingerController::class, 'parallelwurf_delete']);

Route::post('zuchtrassenantrag', [ZuchtrassenantragController::class, 'store']);
Route::put('zuchtrassenantrag/{zuchtrassenantrag}', [ZuchtrassenantragController::class, 'update']);
Route::get('zuchtrassenantrag/{zuchtrassenantrag}', [ZuchtrassenantragController::class, 'show']);
Route::delete('zuchtrassenantrag/{zuchtrassenantrag}', [ZuchtrassenantragController::class, 'destroy']);

Route::post('parallelwurfantrag', [ParallelwurfantragController::class, 'store']);
Route::put('parallelwurfantrag/{parallelwurfantrag}', [ParallelwurfantragController::class, 'update']);
Route::get('parallelwurfantrag/{parallelwurfantrag}', [ParallelwurfantragController::class, 'show']);
Route::delete('parallelwurfantrag/{parallelwurfantrag}', [ParallelwurfantragController::class, 'destroy']);

Route::post('zwingerschutz', [ZwingerschutzController::class, 'store']);
Route::put('zwingerschutz/{zwingerschutz}', [ZwingerschutzController::class, 'update']);
Route::get('zwingerschutz/{zwingerschutz}', [ZwingerschutzController::class, 'show']);
Route::delete('zwingerschutz/{zwingerschutz}', [ZwingerschutzController::class, 'destroy']);

Route::post('zuchtstaette/anlegen', [ZuchtstaetteController::class, 'anlegen']);

Route::post('zuchtstaettenbesichtigung', [ZuchtstaettenbesichtigungController::class, 'store']);
Route::put('zuchtstaettenbesichtigung/{zuchtstaettenbesichtigung}', [ZuchtstaettenbesichtigungController::class, 'update']);
Route::get('zuchtstaettenbesichtigung/{zuchtstaettenbesichtigung}', [ZuchtstaettenbesichtigungController::class, 'show']);
Route::delete('zuchtstaettenbesichtigung/{zuchtstaettenbesichtigung}', [ZuchtstaettenbesichtigungController::class, 'destroy']);

// Route::post('zuchtstaettenbesichtigungantrag',[ZuchtstaettenbesichtigungantragController::class, 'store']);
// Route::put('zuchtstaettenbesichtigungantrag/{zuchtstaettenbesichtigungantrag}',[ZuchtstaettenbesichtigungantragController::class, 'update']);
// Route::get('zuchtstaettenbesichtigungantrag/{zuchtstaettenbesichtigungantrag}',[ZuchtstaettenbesichtigungantragController::class, 'show']);
// Route::delete('zuchtstaettenbesichtigungantrag/{zuchtstaettenbesichtigungantrag}',[ZuchtstaettenbesichtigungantragController::class, 'destroy']);

Route::get('zuchtwarte/showall', [ZuchtwartController::class, 'showAll']);
Route::post('zuchtwarte', [ZuchtwartController::class, 'index']);
Route::post('zuchtwarte/suche', [ZuchtwartController::class, 'suche']);
Route::post('zuchtwart/auto', [ZuchtwartController::class, 'auto']);
Route::get('zuchtwart/show/{zuchtwart}', [ZuchtwartController::class, 'show']);
Route::get('zuchtwart/wuerfe/{zuchtwart}', [ZuchtwartController::class, 'wuerfe']);
Route::get('zuchtwart/wurfabnahmen/{zuchtwart}', [ZuchtwartController::class, 'wurfabnahmen']);
Route::get('zuchtwart/besichtigungen/{zuchtwart}', [ZuchtwartController::class, 'besichtigungen']);
Route::put('zuchtwarte/update', [ZuchtwartController::class, 'zuchtwarte_update']);
Route::put('zuchtwart/update/{zuchtwart}', [ZuchtwartController::class, 'zuchtwart_update']);

Route::post('zuechter', [ZuechterController::class, 'index']);
Route::post('zuechter/suche', [ZuechterController::class, 'suche']);
Route::post('zuechter/auto', [ZuechterController::class, 'auto']);
Route::get('zuechter/show/{zuechter}', [ZuechterController::class, 'show']);
Route::put('zuechter/update', [ZuechterController::class, 'zuechters_update']);
Route::put('zuechter/update/{zuechter}', [ZuechterController::class, 'zuechter_update']);

Route::post('zuchthuendin', [ZuchthuendinController::class, 'index']);
Route::get('zuchthuendin/suche', [ZuchthuendinController::class, 'suche']);
Route::post('zuchthuendin/auto', [ZuchthuendinController::class, 'auto']);
Route::get('zuchthuendin/show/{zuchthuendin}', [ZuchthuendinController::class, 'show']);
Route::put('zuchthuendin/update', [ZuchthuendinController::class, 'zuchthuendin_update']);
Route::put('zuchthuendin/update/{zuchthuendin}', [ZuchthuendinController::class, 'zuchthuendin_update']);

Route::post('deckruede', [DeckruedeController::class, 'index']);
Route::get('deckruede/suche', [DeckruedeController::class, 'suche']);
Route::post('deckruede/auto', [DeckruedeController::class, 'auto']);
Route::get('deckruede/show/{zuchthund}', [DeckruedeController::class, 'show']);
Route::put('deckruede/update', [DeckruedeController::class, 'deckrueden_update']);
Route::put('deckruede/update/{zuchthund}', [DeckruedeController::class, 'deckruede_update']);

Route::get('bezirksgruppe/show/{id}', [BezirksgruppeController::class, 'show']);
Route::get('bezirksgruppe/plz/{plz}', [BezirksgruppeController::class, 'plz']);
Route::post('bezirksgruppen/geojson', [BezirksgruppeController::class, 'geojson']);
Route::get('landesgruppe/show/{id}', [LandesgruppeController::class, 'show']);
Route::get('landesgruppe/bezirksgruppen/{id}', [LandesgruppeController::class, 'show']);
Route::get('landesgruppe/postleitzahlen/{id}', [LandesgruppeController::class, 'show']);

Route::post('setting', [SettingController::class, 'index']);
Route::get('setting/suche', [SettingController::class, 'suche']);
Route::get('setting/{section}', [SettingController::class, 'get']);
Route::get('setting/show/{setting}', [SettingController::class, 'show']);
Route::post('setting/store', [SettingController::class, 'store']);
Route::put('setting/update', [SettingController::class, 'update']);

Route::get('hundefuehrers/{hund}', [HundefuehrerController::class, 'index']);
Route::get('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'show']);
Route::post('hundefuehrer', [HundefuehrerController::class, 'store']);
Route::put('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'update']);
Route::delete('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'destroy']);

Route::post('mitgliedschaftskuendigungs/{hund}', [MitgliedschaftskuendigungController::class, 'index']);
Route::get('mitgliedschaftskuendigung/{mitgliedschaftskuendigung}', [MitgliedschaftskuendigungController::class, 'show']);
Route::post('mitgliedschaftskuendigung', [MitgliedschaftskuendigungController::class, 'store']);
Route::put('mitgliedschaftskuendigung/{mitgliedschaftskuendigung}', [MitgliedschaftskuendigungController::class, 'update']);
Route::delete('mitgliedschaftskuendigung/{mitgliedschaftskuendigung}', [MitgliedschaftskuendigungController::class, 'destroy']);

Route::post('bezirksgruppenwechsels/{hund}', [BezirksgruppenwechselController::class, 'index']);
Route::get('bezirksgruppenwechsel/{bezirksgruppenwechsel}', [BezirksgruppenwechselController::class, 'show']);
Route::post('bezirksgruppenwechsel', [BezirksgruppenwechselController::class, 'store']);
Route::put('bezirksgruppenwechsel/{bezirksgruppenwechsel}', [BezirksgruppenwechselController::class, 'update']);
Route::delete('bezirksgruppenwechsel/{bezirksgruppenwechsel}', [BezirksgruppenwechselController::class, 'destroy']);

Route::post('hundefuehrers/{hund}', [HundefuehrerController::class, 'index']);
Route::get('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'show']);
Route::post('hundefuehrer', [HundefuehrerController::class, 'store']);
Route::put('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'update']);
Route::delete('hundefuehrer/{hundefuehrer}', [HundefuehrerController::class, 'destroy']);

// Route::get('mainmenuitems',[MainMenuItemController::class, 'index'])->middleware('cacheResponse:600');
// Route::get('usermenuitems',[UserMenuItemController::class, 'index'])->middleware('cacheResponse:600');
// Route::get('profiledokumenteitems',[ProfileDokumenteItemController::class, 'index'])->middleware('cacheResponse:600');
// Route::get('profileverwaltungitems',[ProfileVerwaltungItemController::class, 'index'])->middleware('cacheResponse:600');
// Route::get('doktree',[DoktreeController::class, 'index'])->middleware('cacheResponse:600');
// Route::get('orgatree',[OrgatreeController::class, 'index'])->middleware('cacheResponse:600');

// Admin routes for menu management - MUST BE BEFORE mainmenuitems/{id}
Route::get('mainmenuitems/all', [MainMenuItemController::class, 'indexAll']);
// Route::get('main-menu-items/role/{roleId}', [MainMenuItemController::class, 'role']);
// Route::post('main-menu-items/sync-role', [MainMenuItemController::class, 'syncRole']);
// Route::post('main-menu-items/order', [MainMenuItemController::class, 'updateOrder']);
// Route::post('main-menu-items/activation', [MainMenuItemController::class, 'updateActivation']);

// Legacy routes - keep for compatibility
Route::get('mainmenuitems', [MainMenuItemController::class, 'index']); // ->middleware('cacheResponse:600');
Route::post('mainmenuitems/sync-role', [MainMenuItemController::class, 'syncRole']); // ->middleware('cacheResponse:600');
Route::get('mainmenuitems/role/{id}', [MainMenuItemController::class, 'role']); // ->middleware('cacheResponse:600')
Route::post('mainmenuitems/order', [MainMenuItemController::class, 'updateOrder']);
Route::post('mainmenuitems/activation', [MainMenuItemController::class, 'updateActivation']);
Route::get('usermenuitems', [UserMenuItemController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('profiledokumenteitems', [ProfileDokumenteItemController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('profileverwaltungitems', [ProfileVerwaltungItemController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('doktree', [DoktreeController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('orgatree', [OrgatreeController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('options', [OptionenController::class, 'index']); // ->middleware('cacheResponse:600');
Route::get('optionen/gruppe/{id}', [OptionenController::class, 'getGruppeDetails']);
Route::get('tags', [TagController::class, 'tree']); // ->middleware('cacheResponse:600');

Route::get('weboptions', [OptionenController::class, 'webindex']); // ->middleware('cacheResponse:600');

Route::post('dokument/multi', [DokumentController::class, 'uploadMulti']);
Route::post('dokument/hund', [DokumentController::class, 'uploadHund']);
Route::post('dokument/person', [DokumentController::class, 'uploadPerson']);
Route::post('dokument/wurf', [DokumentController::class, 'uploadWurf']);
Route::post('dokument/zwinger', [DokumentController::class, 'uploadZwinger']);
Route::post('dokument/mitglied', [DokumentController::class, 'uploadMitglied']);
Route::post('dokument/zuechter', [DokumentController::class, 'uploadZuechter']);
Route::post('dokument/veranstaltung', [DokumentController::class, 'uploadVeranstaltung']);
Route::delete('dokument/{dokument}', [DokumentController::class, 'destroy']);
Route::post('dokument/removemodel', [DokumentController::class, 'removeModel']);
Route::post('dokument/storemodel', [DokumentController::class, 'storeModel']);
Route::post('dokument/move', [DokumentController::class, 'move']);
Route::put('dokument/update', [DokumentController::class, 'update']);

// Dokumentenkategorien Routes
// Route::get('dokumentenkategorien/roles/available', [DokumentenkategorieController::class, 'getAvailableRoles']);
Route::get('dokumentenkategorien/roles/list', [DokumentenkategorieController::class, 'rolesList']);
Route::put('dokumentenkategorien-order', [DokumentenkategorieController::class, 'updateOrder']);
Route::get('dokumentenkategorien', [DokumentenkategorieController::class, 'index']);
Route::post('dokumentenkategorien', [DokumentenkategorieController::class, 'store']);
Route::get('dokumentenkategorien/{dokumentenkategorie}', [DokumentenkategorieController::class, 'show']);
Route::put('dokumentenkategorien/{dokumentenkategorie}', [DokumentenkategorieController::class, 'update']);
Route::delete('dokumentenkategorien/{dokumentenkategorie}', [DokumentenkategorieController::class, 'destroy']);

// Role assignments for Dokumentenkategorien
Route::post('dokumentenkategorien/{dokumentenkategorie}/roles', [DokumentenkategorieController::class, 'assignRole']);
Route::delete('dokumentenkategorien/{dokumentenkategorie}/roles/{role}', [DokumentenkategorieController::class, 'unassignRole']);

Route::post('fileupload', [FileController::class, 'single_upload']);
Route::post('filesupload', [FileController::class, 'multi_upload']);

Route::post('images/order', [ImageController::class, 'store_images_order']);
Route::post('images/storebu', [ImageController::class, 'store_images_bu']);

Route::get('uebernahmeantrag/{id}', [UebernahmeantragController::class, 'show']);
Route::post('uebernahmeantrag', [UebernahmeantragController::class, 'store']);
Route::put('uebernahmeantrag/{uebernahmeantrag}', [UebernahmeantragController::class, 'update']);
Route::post('uebernahmeantrag/meta', [UebernahmeantragController::class, 'meta']);
Route::post('uebernahmeantrag/sendmailbestaetigung', [UebernahmeantragController::class, 'sendmailbestaetigung']);

Route::get('hundanlageantrag/{hundanlageantrag}', [HundanlageantragController::class, 'show']);
Route::post('hundanlageantrag', [HundanlageantragController::class, 'store']);
Route::put('hundanlageantrag/{hundanlageantrag}', [HundanlageantragController::class, 'update']);
Route::post('hundanlageantrag/meta', [HundanlageantragController::class, 'meta']);
Route::delete('hundanlageantrag/{hundanlageantrag}', [HundanlageantragController::class, 'destroy']);
Route::put('hundanlageantrag/storebemerkungendrc/{hundanlageantrag}', [HundanlageantragController::class, 'store_bemerkungen_drc']);
Route::put('hundanlageantrag/setshowinprofile/{hundanlageantrag}', [HundanlageantragController::class, 'set_show_in_profile']);

Route::get('zuchtzulassungsantrag/{id}', [ZuchtzulassungsantragController::class, 'show']);
Route::post('zuchtzulassungsantrag', [ZuchtzulassungsantragController::class, 'store']);
Route::put('zuchtzulassungsantrag/{zuchtzulassungsantrag}', [ZuchtzulassungsantragController::class, 'update']);
Route::post('zuchtzulassungsantrag/meta', [ZuchtzulassungsantragController::class, 'meta']);

Route::post('notiz', [NotizController::class, 'store']);
Route::put('notiz/{notiz}', [NotizController::class, 'update']);
Route::delete('notiz/{notiz}', [NotizController::class, 'destroy']);

Route::post('kommentar', [KommentarController::class, 'store']);
Route::put('kommentar/{kommentar}', [KommentarController::class, 'update']);
Route::delete('kommentar/{kommentar}', [KommentarController::class, 'destroy']);
Route::post('kommentare', [KommentarController::class, 'showAll']);

Route::post('notifications', [NotificationController::class, 'index']);
Route::post('notification/{notification}/mark-read', [NotificationController::class, 'markRead']);
Route::post('notification', [NotificationController::class, 'store']);
Route::get('notification/{notification}', [NotificationController::class, 'show']);
Route::put('notification/{notification}', [NotificationController::class, 'update']);
Route::delete('notification/{notification}', [NotificationController::class, 'destroy']);

// Link-Verwaltung
Route::put('linkkategorien/order', [LinkkategorieController::class, 'updateOrder']);
Route::get('linkkategorien', [LinkkategorieController::class, 'index']);
Route::post('linkkategorie', [LinkkategorieController::class, 'store']);
Route::get('linkkategorie/{linkkategorie}', [LinkkategorieController::class, 'show']);
Route::put('linkkategorie/{linkkategorie}', [LinkkategorieController::class, 'update']);
Route::delete('linkkategorie/{linkkategorie}', [LinkkategorieController::class, 'destroy']);
// Route::apiResource('linkkategorien', LinkkategorieController::class);
Route::put('links/order', [LinkController::class, 'updateOrder']);
Route::apiResource('links', LinkController::class);

Route::post('land/autocomplete', [LandController::class, 'autocomplete']);
Route::post('bank/autocomplete', [BankverbindungController::class, 'autocomplete']);
Route::post('bankverbindungen', [BankverbindungController::class, 'store']);

Route::post('bugtracks/gruppiert', [BugtrackController::class, 'grouped']);
Route::post('bugtracks', [BugtrackController::class, 'index']);
Route::get('bugtracks/{id}', [BugtrackController::class, 'show']);
Route::post('bugtrack', [BugtrackController::class, 'store']);
Route::put('bugtrack/{bugtrack}', [BugtrackController::class, 'update']);
Route::delete('bugtrack/{bugtrack}', [BugtrackController::class, 'destroy']);

Route::post('generate-pdf', [PDFController::class, 'triggerPDFGeneration']);

// User Management Routes
Route::get('users', [UserController::class, 'list']); // For assignments
Route::post('users', [UserController::class, 'index']);
Route::post('users/store', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

// Roles and Persons Lists for Assignments
Route::get('roles', [RoleController::class, 'index']);
Route::get('persons', [PersonController::class, 'list']);

// User Status Management
Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive']);

// User Password Management
Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword']);
Route::post('users/{user}/send-password-reset', [UserController::class, 'sendPasswordReset']);

// User Email Management
Route::post('users/{user}/send-verification', [UserController::class, 'sendEmailVerification']);

// User Person Linking
Route::post('users/{user}/link-person', [UserController::class, 'linkPerson']);
Route::post('users/{user}/create-and-link-person', [UserController::class, 'createAndLinkPerson']);
Route::delete('users/{user}/unlink-person', [UserController::class, 'unlinkPerson']);

// User Photo Management
Route::post('users/{user}/upload-photo', [UserController::class, 'uploadPhoto']);

// User Permissions Overview
Route::get('users/{user}/permissions', [UserController::class, 'getPermissions']);

// User Role Management
Route::get('users/{user}/roles', [UserController::class, 'roles']);
Route::post('users/{user}/roles', [UserController::class, 'assignRole']);
Route::delete('users/{user}/roles/{role}', [UserController::class, 'removeRole']);
Route::put('users/{user}/roles', [UserController::class, 'syncRoles']);

// User Ability Management
Route::get('users/{user}/abilities', [UserController::class, 'abilities']);
Route::post('users/{user}/abilities', [UserController::class, 'addAbility']);
Route::put('users/{user}/abilities', [UserController::class, 'syncAbilities']);
Route::delete('users/{user}/abilities', [UserController::class, 'removeAbility']);

// User Login Tracking
Route::put('users/{user}/last-login', [UserController::class, 'updateLastLogin']);

// User Status Management
Route::put('users/{user}/toggle-active', [UserController::class, 'toggleActive']);

// Admin Routes for Role and Ability Management
Route::prefix('admin')->group(function () {
    // Admin Role Management
    Route::get('roles', [AdminRoleController::class, 'index']);
    Route::post('roles', [AdminRoleController::class, 'store']);
    Route::get('roles/{role}', [AdminRoleController::class, 'show']);
    Route::put('roles/{role}', [AdminRoleController::class, 'update']);
    Route::delete('roles/{role}', [AdminRoleController::class, 'destroy']);

    // Get available models for abilities
    Route::get('models', [AdminRoleController::class, 'getModels']);

    // Role Abilities Management
    Route::get('roles/{role}/abilities', [AdminRoleController::class, 'abilities']);
    Route::post('roles/{role}/abilities', [AdminRoleController::class, 'assignAbility']);
    Route::delete('roles/{role}/abilities/{ability}', [AdminRoleController::class, 'removeAbility']);
    Route::put('roles/{role}/abilities', [AdminRoleController::class, 'syncAbilities']);

    // Role Users Management
    Route::get('roles/{role}/users', [AdminRoleController::class, 'users']);
    Route::post('roles/{role}/users', [AdminRoleController::class, 'bulkAssignUsers']);
    Route::delete('roles/{role}/users', [AdminRoleController::class, 'bulkRemoveUsers']);

    // Admin Ability Management
    Route::get('abilities', [AdminAbilityController::class, 'index']);
    Route::post('abilities', [AdminAbilityController::class, 'store']);
    Route::get('abilities/{ability}', [AdminAbilityController::class, 'show']);
    Route::put('abilities/{ability}', [AdminAbilityController::class, 'update']);
    Route::delete('abilities/{ability}', [AdminAbilityController::class, 'destroy']);

    // Ability Roles Management
    Route::get('abilities/{ability}/roles', [AdminAbilityController::class, 'roles']);
    Route::post('abilities/{ability}/roles', [AdminAbilityController::class, 'assignToRole']);
    Route::delete('abilities/{ability}/roles/{role}', [AdminAbilityController::class, 'removeFromRole']);
    Route::post('abilities/{ability}/roles/bulk', [AdminAbilityController::class, 'bulkAssignToRoles']);
    Route::delete('abilities/{ability}/roles/bulk', [AdminAbilityController::class, 'bulkRemoveFromRoles']);

    // Helper Endpoints
    Route::get('abilities/entity-types', [AdminAbilityController::class, 'entityTypes']);
});

// Rechnungen Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('rechnungen/personen', [RechnungController::class, 'getPersonen']);
    Route::post('rechnungen', [RechnungController::class, 'Index']);
    Route::get('rechnungen/{rechnung}', [RechnungController::class, 'show']);
    Route::put('rechnungen/{rechnung}', [RechnungController::class, 'update']);
    Route::post('rechnungen/suche', [RechnungController::class, 'suche']);

    // Bank Import for Payment Matching
    Route::post('bank-import', [BankImportController::class, 'import']);
    Route::get('bank-import-debug', [BankImportController::class, 'debug']);
    Route::get('bank-import-test', [BankImportController::class, 'testImport']);
    Route::post('bank-import-simple', [BankImportTestController::class, 'testImport']);

    //  Route::apiResource('rechnungen', RechnungController::class);
    Route::post('rechnungen/{rechnung}/posten', [RechnungController::class, 'addPosten']);
    Route::delete('rechnungen/{rechnung}/posten/{posten}', [RechnungController::class, 'removePosten']);
    Route::post('rechnungen/{rechnung}/bezahlt', [RechnungController::class, 'markiereBezahlt']);

    // SEPA/DTA Export
    // Route::post('rechnungen/export-lastschriften', [RechnungController::class, 'exportLastschriften']);
    // Route::post('rechnungen/export-ueberweisungen', [RechnungController::class, 'exportUeberweisungen']);
    // Route::post('rechnungen/{rechnung}/ruecklastschrift', [RechnungController::class, 'ruecklastschrift']);

    // Optionen für Dropdowns
    // Route::get('rechnungen/options', [RechnungController::class, 'options']);

    // Rechnungsposten Management
    Route::put('rechnungsposten/{rechnungsposten}', [RechnungspostenController::class, 'update']);
    Route::delete('rechnungsposten/{rechnungsposten}', [RechnungspostenController::class, 'destroy']);

});

// Notification Template Management
Route::middleware('auth:sanctum')->group(function () {
    // Notification Template Routes
    Route::get('notification-templates', [NotificationTemplateController::class, 'index']);
    Route::post('notification-templates', [NotificationTemplateController::class, 'store']);
    Route::get('notification-templates/{notificationTemplate}', [NotificationTemplateController::class, 'show']);
    Route::put('notification-templates/{notificationTemplate}', [NotificationTemplateController::class, 'update']);
    Route::delete('notification-templates/{notificationTemplate}', [NotificationTemplateController::class, 'destroy']);

    // Additional NotificationTemplate endpoints
    Route::post('notification-templates/{notificationTemplate}/test', [NotificationTemplateController::class, 'test']);
    Route::get('notification-templates/sections/list', [NotificationTemplateController::class, 'sectionsList']);
    Route::get('notification-templates/roles/list', [NotificationTemplateController::class, 'rolesList']);
    Route::get('notification-templates/users/list', [NotificationTemplateController::class, 'usersList']);
    Route::post('notification-templates/users/search', [NotificationTemplateController::class, 'usersSearch']);
    Route::get('notification-templates/data-objects/{type}', [NotificationTemplateController::class, 'dataObjectsList']);

    // Role assignments
    Route::post('notification-templates/{notificationTemplate}/roles', [NotificationTemplateController::class, 'assignRole']);
    Route::delete('notification-templates/{notificationTemplate}/roles/{role}', [NotificationTemplateController::class, 'unassignRole']);

    // User assignments
    Route::post('notification-templates/{notificationTemplate}/users', [NotificationTemplateController::class, 'assignUser']);
    Route::delete('notification-templates/{notificationTemplate}/users/{user}', [NotificationTemplateController::class, 'unassignUser']);
});

// Aufgaben Template Management
Route::middleware('auth:sanctum')->group(function () {
    // Aufgaben Templates Routes
    Route::get('aufgaben-templates', [AufgabenTemplateController::class, 'index']);
    Route::post('aufgaben-templates', [AufgabenTemplateController::class, 'store']);
    Route::get('aufgaben-templates/{aufgabenTemplate}', [AufgabenTemplateController::class, 'show']);
    Route::put('aufgaben-templates/{aufgabenTemplate}', [AufgabenTemplateController::class, 'update']);
    Route::delete('aufgaben-templates/{aufgabenTemplate}', [AufgabenTemplateController::class, 'destroy']);

    // Aufgaben Templates - Assignment Routes
    Route::post('aufgaben-templates/{aufgabenTemplate}/zugeteilte/roles', [AufgabenTemplateController::class, 'syncZugeteilteRoles']);
    Route::delete('aufgaben-templates/{aufgabenTemplate}/zugeteilte/roles/{role}', [AufgabenTemplateController::class, 'removeZugeteilteRole']);
    Route::post('aufgaben-templates/{aufgabenTemplate}/zugeteilte/persons', [AufgabenTemplateController::class, 'syncZugeteiltePersons']);
    Route::post('aufgaben-templates/{aufgabenTemplate}/zugeteilte/users', [AufgabenTemplateController::class, 'syncZugeteilteUsers']);
    Route::delete('aufgaben-templates/{aufgabenTemplate}/zugeteilte/users/{user}', [AufgabenTemplateController::class, 'removeZugeteilteUser']);
    Route::post('aufgaben-templates/{aufgabenTemplate}/uebernahmeberechtigte/roles', [AufgabenTemplateController::class, 'syncUebernahmeberechtigteRoles']);
    Route::delete('aufgaben-templates/{aufgabenTemplate}/uebernahmeberechtigte/roles/{role}', [AufgabenTemplateController::class, 'removeUebernahmeberechtigteRole']);
    Route::post('aufgaben-templates/{aufgabenTemplate}/uebernahmeberechtigte/persons', [AufgabenTemplateController::class, 'syncUebernahmeberechtigtePersons']);
    Route::post('aufgaben-templates/{aufgabenTemplate}/uebernahmeberechtigte/users', [AufgabenTemplateController::class, 'syncUebernahmeberechtigteUsers']);
    Route::delete('aufgaben-templates/{aufgabenTemplate}/uebernahmeberechtigte/users/{user}', [AufgabenTemplateController::class, 'removeUebernahmeberechtigteUser']);

    // Aufgaben Templates - List Routes
    Route::get('aufgaben-templates/sections/list', [AufgabenTemplateController::class, 'sections']);
    Route::get('aufgaben-templates/roles/list', [AufgabenTemplateController::class, 'rolesList']);
    Route::get('aufgaben-templates/users/list', [AufgabenTemplateController::class, 'usersList']);
    Route::post('aufgaben-templates/users/search', [AufgabenTemplateController::class, 'usersSearch']);
});

// Aufgaben Management
Route::middleware('auth:sanctum')->group(function () {
    // Aufgaben Routes
    Route::get('aufgaben', [AufgabeController::class, 'index']);
    Route::post('aufgaben', [AufgabeController::class, 'store']);
    Route::get('aufgaben/{aufgabe}', [AufgabeController::class, 'show']);
    Route::put('aufgaben/{aufgabe}', [AufgabeController::class, 'update']);
    Route::delete('aufgaben/{aufgabe}', [AufgabeController::class, 'destroy']);

    // Aufgaben Assignment Routes
    Route::post('aufgaben/{aufgabe}/assign-users', [AufgabeController::class, 'assignUsers']);
    Route::delete('aufgaben/{aufgabe}/users/{user}', [AufgabeController::class, 'removeUser']);
    Route::post('aufgaben/{aufgabe}/take-over', [AufgabeController::class, 'takeOver']);
    Route::get('aufgaben/{aufgabe}/available-users', [AufgabeController::class, 'getAvailableUsers']);

    // Aufgaben Helper Routes
    Route::get('aufgaben/status/list', [AufgabeController::class, 'statusList']);
    Route::post('aufgaben/users/search', [AufgabeController::class, 'usersSearch']);
});

// Email Template Management
Route::middleware('auth:sanctum')->group(function () {
    // Email Template Routes
    Route::get('email-templates/roles/list', [EmailTemplateController::class, 'rolesList']);
    Route::get('email-templates', [EmailTemplateController::class, 'index']);
    Route::post('email-templates', [EmailTemplateController::class, 'store']);
    Route::get('email-templates/{emailTemplate}', [EmailTemplateController::class, 'show']);
    Route::put('email-templates/{emailTemplate}', [EmailTemplateController::class, 'update']);
    Route::delete('email-templates/{emailTemplate}', [EmailTemplateController::class, 'destroy']);

    // Email Template test email
    Route::post('email-templates/{emailTemplate}/test', [EmailTemplateController::class, 'test']);

    // Role assignments
    Route::post('email-templates/{emailTemplate}/roles', [EmailTemplateController::class, 'assignRole']);
    Route::delete('email-templates/{emailTemplate}/roles/{role}', [EmailTemplateController::class, 'unassignRole']);

    // Person assignments
    Route::post('email-templates/{emailTemplate}/persons', [EmailTemplateController::class, 'assignPerson']);
    Route::delete('email-templates/{emailTemplate}/persons/{person}', [EmailTemplateController::class, 'unassignPerson']);

    // Search endpoints
    Route::post('email-templates/persons/search', [EmailTemplateController::class, 'personsSearch']);
});

// Infotexte Management
Route::middleware('auth:sanctum')->group(function () {
    // Infotexte Routes
    Route::get('infotexte', [InfotexteController::class, 'index']);
    Route::post('infotexte', [InfotexteController::class, 'store']);
    Route::get('infotexte/{infotexte}', [InfotexteController::class, 'show']);
    Route::put('infotexte/{infotexte}', [InfotexteController::class, 'update']);
    Route::delete('infotexte/{infotexte}', [InfotexteController::class, 'destroy']);

    // Rollen-Zuweisung
    Route::post('infotexte/{infotexte}/roles', [InfotexteController::class, 'assignRole']);
    Route::delete('infotexte/{infotexte}/roles/{role}', [InfotexteController::class, 'unassignRole']);
});

// Einträge einer Optionenliste
Route::middleware('auth:sanctum')->group(function () {
    Route::get('optionenlisten/{optionenliste}/eintraege', [OptionenEintragController::class, 'index']);
    Route::post('optionenlisten/{optionenliste}/eintraege', [OptionenEintragController::class, 'store']);
    Route::put('optionenlisten/{optionenliste}/eintraege/{id}', [OptionenEintragController::class, 'update']);
    Route::delete('optionenlisten/{optionenliste}/eintraege/{id}', [OptionenEintragController::class, 'destroy']);
    Route::post('optionenlisten/{optionenliste}/eintraege/reorder', [OptionenEintragController::class, 'reorder']);
    // Optionenlisten Verwaltung
    Route::get('optionenlisten', [OptionenlistenController::class, 'index']);
    Route::get('optionenlisten/{id}', [OptionenlistenController::class, 'show']);
    Route::put('optionenlisten/{id}', [OptionenlistenController::class, 'update']);

    // Gruppenverwaltung
    Route::get('gruppen', [GruppenController::class, 'index']);
    Route::get('gruppen/{id}', [GruppenController::class, 'show']);
    Route::put('gruppen/{gruppe}', [GruppenController::class, 'update']);
    Route::get('gruppen/{id}/mitglieder', [GruppenController::class, 'mitglieder']);
    Route::get('gruppen/{id}/rechnungen', [GruppenController::class, 'rechnungen']);
    Route::get('gruppen/{id}/rechnungen/years', [GruppenController::class, 'rechnungenYears']);

    // Bankverbindungen für Gruppen
    Route::get('gruppen/{gruppe}/bankverbindungen', [GruppenController::class, 'getBankverbindungen']);
    Route::post('gruppen/{gruppe}/bankverbindungen', [GruppenController::class, 'storeBankverbindung']);
    Route::put('gruppen/{gruppe}/bankverbindungen/{bankverbindung}', [GruppenController::class, 'updateBankverbindung']);
    Route::delete('gruppen/{gruppe}/bankverbindungen/{bankverbindung}', [GruppenController::class, 'destroyBankverbindung']);
    Route::put('gruppen/{gruppe}/bankverbindungen-order', [GruppenController::class, 'updateBankverbindungenOrder']);

    // Funktionäre für Gruppen
    Route::put('gruppen/{gruppe}/funktionaere', [GruppenController::class, 'updateFunktionaere']);

    // Mitglieder für Gruppen
    Route::get('gruppen/{gruppe}/mitglieder/autocomplete', [GruppenController::class, 'getMitgliederAutocomplete']);

    // Ausbilder für Gruppen
    Route::get('gruppen/{gruppe}/ausbilder', [GruppenController::class, 'getAusbilder']);
    Route::post('gruppen/{gruppe}/ausbilder', [GruppenController::class, 'storeAusbilder']);
    Route::put('gruppen/{gruppe}/ausbilder/{ausbilder}', [GruppenController::class, 'updateAusbilder']);
    Route::delete('gruppen/{gruppe}/ausbilder/{ausbilder}', [GruppenController::class, 'destroyAusbilder']);

    // Sonderleiter für Gruppen
    Route::get('gruppen/{gruppe}/sonderleiter', [GruppenController::class, 'getSonderleiter']);
    Route::post('gruppen/{gruppe}/sonderleiter', [GruppenController::class, 'storeSonderleiter']);
    Route::put('gruppen/{gruppe}/sonderleiter/{sonderleiter}', [GruppenController::class, 'updateSonderleiter']);
    Route::delete('gruppen/{gruppe}/sonderleiter/{sonderleiter}', [GruppenController::class, 'destroySonderleiter']);
    Route::put('gruppen/{gruppe}/sonderleiter/{sonderleiter}/end', [GruppenController::class, 'endSonderleiter']);

    // Ausbilder
    // Route::get('ausbilder', [AusbilderController::class, 'index']);
    Route::post('ausbilders', [AusbilderController::class, 'index']);
    Route::post('ausbilder', [AusbilderController::class, 'store']);
    Route::get('ausbilder/{ausbilder}', [AusbilderController::class, 'show']);
    Route::put('ausbilder/{ausbilder}', [AusbilderController::class, 'update']);
    Route::get('ausbilder/options', [AusbilderController::class, 'getOptions']);
    Route::get('ausbilder', [AusbilderController::class, 'getAusbilder']);
    Route::post('ausbilder/{ausbilder}/documents', [AusbilderController::class, 'uploadDocument']);
    Route::delete('ausbilder/{ausbilder}', [AusbilderController::class, 'destroy']);

    // Sonderleiter
    Route::get('sonderleiter', [SonderleiterController::class, 'index']);
    Route::post('sonderleiter', [SonderleiterController::class, 'store']);
    Route::get('sonderleiter/{sonderleiter}', [SonderleiterController::class, 'show']);
    Route::put('sonderleiter/{sonderleiter}', [SonderleiterController::class, 'update']);
    Route::delete('sonderleiter/{sonderleiter}', [SonderleiterController::class, 'destroy']);

    // PLZ-Zuordnungen für Bezirksgruppen
    Route::get('bezirksgruppen/{id}/plz-zuordnungen', [BezirksgruppeController::class, 'plzZuordnungen']);
    Route::get('bezirksgruppen/{id}/plz-zuordnungen/bundeslaender', [BezirksgruppeController::class, 'plzZuordnungenBundeslaender']);
    Route::delete('bezirksgruppen/{bezirksgruppeId}/plz-zuordnungen/{plzId}', [BezirksgruppeController::class, 'removePlzZuordnung']);
});

// Gebührenordnung Management
Route::middleware('auth:sanctum')->group(function () {
    // Gebührenordnungen - WICHTIG: Spezifische Routen MÜSSEN vor apiResource stehen!
    // Spezifische Routen MÜSSEN vor dem apiResource stehen!
    Route::get('gebuehrenordnung/aktuell', [GebuehrenordnungController::class, 'aktuell']);
    Route::get('gebuehrenordnungen/{gebuehrenordnung}/verfuegbare-katalog', [GebuehrenordnungController::class, 'verfuegbareKatalogEintraege']);
    Route::get('gebuehrenordnungen/{gebuehrenordnung}/gruppen', [GebuehrenordnungController::class, 'gruppen']);
    Route::get('gebuehrenordnungen/{gebuehrenordnung}/gebuehren', [GebuehrenordnungController::class, 'gebuehren']);
    Route::post('gebuehrenordnungen/{gebuehrenordnung}/gebuehren', [GebuehrenordnungController::class, 'storeGebuehr']);
    Route::put('gebuehrenordnungen/{gebuehrenordnung}/gebuehren-order', [GebuehrenordnungController::class, 'updateGebuehrenOrder']);

    // API Resource mit korrektem Parameter-Namen - NACH den spezifischen Routen!
    Route::apiResource('gebuehrenordnungen', GebuehrenordnungController::class)->parameters([
        'gebuehrenordnungen' => 'gebuehrenordnung',
    ]);

    // Gebühren
    Route::get('gebuehren/aktuell', [GebuehrController::class, 'getAktuelleGebuehren']);
    Route::get('gebuehren', [GebuehrController::class, 'index']);
    Route::post('gebuehren', [GebuehrController::class, 'store']);
    Route::put('gebuehren/{gebuehr}', [GebuehrController::class, 'update']);
    Route::delete('gebuehren/{gebuehr}', [GebuehrController::class, 'destroy']);

    // Gebührengruppen
    Route::get('gebuehrengruppe', [GebuehrengruppeController::class, 'index']);
    Route::post('gebuehrengruppe', [GebuehrengruppeController::class, 'store']);
    Route::get('gebuehrengruppe/{gebuehrengruppe}', [GebuehrengruppeController::class, 'show']);
    Route::put('gebuehrengruppe/{gebuehrengruppe}', [GebuehrengruppeController::class, 'update']);
    Route::delete('gebuehrengruppe/{gebuehrengruppe}', [GebuehrengruppeController::class, 'destroy']);
    Route::put('gebuehrengruppen-order', [GebuehrengruppeController::class, 'updateOrder']);

    // Gebuehrenkatalog
    Route::apiResource('gebuehrenkatalog', GebuehrenkatalogController::class);
    Route::post('gebuehrenkatalog/{gebuehrenkatalog}/gebuehr', [GebuehrenkatalogController::class, 'setGebuehr']);
});

// Neuzüchterseminare
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('neuzuechterseminare', NeuzuechterseminarController::class)->parameters([
        'neuzuechterseminare' => 'neuzuechterseminar',
    ]);
});

// Zweitwohnsitznachweise
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('zweitwohnsitznachweise', ZweitwohnsitznachweisController::class)->parameters([
        'zweitwohnsitznachweise' => 'zweiwohnsitznachweis',
    ]);
});

// Rechnung Export System
Route::middleware('auth:sanctum')->prefix('rechnungexport')->group(function () {
    // Export-Statistiken und Vorschau
    Route::get('statistiken', [RechnungExportController::class, 'getExportStatistiken']);
    Route::post('vorschau', [RechnungExportController::class, 'getExportVorschau']);

    // Export erstellen und verwalten
    Route::post('create', [RechnungExportController::class, 'createExport']);
    Route::get('', [RechnungExportController::class, 'getExports']);
    Route::get('{id}', [RechnungExportController::class, 'getExportDetails']);
    Route::get('{id}/rechnungen', [RechnungExportController::class, 'getExportRechnungen']);
    Route::put('{id}/mark-transferred', [RechnungExportController::class, 'markAsTransferred']);

    // Datei-Downloads (Sicherheitsprüfungen sind im Controller implementiert)
    Route::get('{id}/download/{filename}', [RechnungExportController::class, 'downloadFile'])
        ->where('filename', '.*\.(csv|xml|dta)$');
});

// Kontaktdatenänderungen
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('kontaktdatenaenderungen', KontaktdatenaenderungController::class);
});
