<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKommentarRequest;
use App\Http\Requests\UpdateKommentarRequest;
use App\Models\Kommentar;
use App\Traits\GetStatusAfterKommentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// WERDEN IN DER ENTPSRECHENDEN DB TABELLE BENÖTIGT

// ALTER TABLE `tablename` ADD `accessAntragsteller_at` TIMESTAMP;
// ALTER TABLE `tablename` ADD `accessDRC_at` TIMESTAMP;

class KommentarController extends Controller
{
    use GetStatusAfterKommentar;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKommentarRequest $request)
    {

        $user_id = Auth::id();
        if (! $user_id) {
            return;
        }

        $model = $request->model;
        $klasse = "App\Models\\" . $model['model'];
        $db_model = $klasse::find($model['id']);

        $kommentar = new Kommentar();
        $kommentar->text = $request->text;
        $request->antragsteller ? $kommentar->drc = 0 : $kommentar->drc = 1;
        $kommentar->user_id = $user_id;

        $db_model->kommentare()->save($kommentar);
        $kommentar->save();

        // $request->antragsteller ? $db_model->accessAntragsteller_at = now() : $db_model->accessDRC_at = now();
        $status = $this->getStatusAfterKommentar($model['model'], $request->antragsteller);
        if ($status['id'] != 0) {
            $db_model->status_id = $status['id'];
            $db_model->save();
        } else {
            $status = $db_model->status;
        }

        return response()->json([
            'success' => 'Kommentar gespeichert.',
            'kommentar' => $kommentar,
            'status' => $status,
            // 'accessDRC_at' => $db_model->accessDRC_at,
            // 'accessAntragsteller_at' => $db_model->accessAntragsteller_at
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Kommentar $kommentar)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kommentar  $kommentar
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {

        $model = "App\Models\\" . $request->model;
        $db_model = $model::find($request->id);

        $request->antragsteller ? $db_model->accessAntragsteller_at = now() : $db_model->accessDRC_at = now();

        $db_model->save();

        return response()->json([
            'success' => 'success',
            'kommentare' => $db_model->kommentare,
            'accessDRC_at' => $db_model->accessDRC_at,
            'accessAntragsteller_at' => $db_model->accessAntragsteller_at,
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKommentarRequest $request, Kommentar $kommentar)
    {

        $kommentar->text = $request->text;
        $kommentar->save();

        return response()->json([
            'success' => 'Kommentar gespeichert.',
            'kommentar' => $kommentar,
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kommentar $kommentar)
    {

        $kommentar->delete();

        return response()->json([
            'success' => 'Notiz gelöscht.',
            'id' => $kommentar->id,
        ]);

    }
}
