<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotizRequest;
use App\Http\Requests\UpdateNotizRequest;
use App\Models\Hund;
use App\Models\Notiz;
use App\Models\Rechnung;
use Illuminate\Support\Facades\Auth;

class NotizController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotizRequest $request)
    {
        $user_id = Auth::id();
        if (! $user_id) {
            return;
        }

        switch ($request['type']) {
            case 'Hund':
                $model = Hund::find($request['id']);
                break;
            case 'Rechnung':
                $model = Rechnung::find($request['id']);
                break;
            default:
                return response()->json([
                    'error' => 'Kein Model gefunden',

                ]);

        }

        $notiz = new Notiz();

        $notiz->text = $request['text'];
        $notiz->user_id = $user_id;

        $model->notizen()->save($notiz);

        return response()->json([
            'success' => 'Notiz gespeichert.',
            'notiz' => $notiz,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Notiz $notiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotizRequest $request, Notiz $notiz)
    {

        $notiz->text = $request->text;
        $notiz->save();

        return response()->json([
            'success' => 'Notiz updated.',
            'notiz' => $notiz,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notiz $notiz)
    {
        $notiz->delete();

        return response()->json([
            'success' => 'Notiz gelöscht.',
            'id' => $notiz->id,
        ]);

    }
}
