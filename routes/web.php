<?php

use App\Http\Controllers\BestaetigungController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HundPrerenderedController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RoutingController;
// use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\TestController;
use App\Models\Mitglied;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('generate-images-hunde', [FileController::class, 'generate_images_hunde']);

Route::get('/debug', function () {

    $query = Mitglied::join('personen', 'personen.mitglied_id', '=', 'mitglieder.id')->join('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')->join('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')->limit(500)->get();

    \Debugbar::info('Mitglieder: ' . $query);

    return view('welcome', ['query' => $query]);
});

Route::get('renderhund/{id}', [HundPrerenderedController::class, 'test']);

Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
Route::post('print-deckbescheinigung', [PDFController::class, 'deckbescheinigung']);

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail von Bloom',
        'body' => 'Das ist ein Test',
    ];

    \Mail::to('goemmel@bloomproject.de')->send(new \App\Mail\SendMail($details));

    dd('Email is Sent.');
});

Route::get('bestaetigung/confirm/{bestaetigung:uuid}', [BestaetigungController::class, 'confirm']);
Route::get('bestaetigung/reject/{bestaetigung:uuid}', [BestaetigungController::class, 'reject']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', [TestController::class, 'test']);

// PDF-Template Routes
// Route::get('/showroom', [ShowroomController::class, 'show']);

Route::get('/columns', [ColumnController::class, 'show']);

Route::get('/dokumente', [RoutingController::class, 'lists']);

Route::get('/pruefungen/{name}', [RoutingController::class, 'pruefungen']);

Route::get('/oeffentlich/{name}', [RoutingController::class, 'oeffentliche']);

Route::get('/dokumente/{name}', [RoutingController::class, 'dokumente']);
