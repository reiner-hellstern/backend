<?php

namespace App\Http\Controllers;

use App\Models\VeranstaltungMeldung;
use Illuminate\Http\Request;

class VeranstaltungMeldungController extends Controller
{
    public function add_meldung(Request $request)
    {

        $input = $request->all();

        $meldung = new VeranstaltungMeldung();

        $meldung->anmelder_id = $input['meldung']['anmelder']['id'];
        $meldung->hund_id = $input['meldung']['hund']['id'];
        $meldung->hundefuehrer_id = $input['meldung']['hundefuehrer']['id'];

        $meldung->angemeldet_am = date('Y-m-d H:i:s');

        $meldung->storniert = 0;
        $meldung->angenommen = 0;
        $meldung->bezahlt = 0;
        $meldung->zugesagt = 0;
        $meldung->abgelehnt = 0;
        $meldung->veranstaltung_id = $input['va_id'];
        $meldung->save();

        return ['id' => $meldung->id];
    }

    public function anmeldung(Request $request)
    {

        $input = $request->all();

        $meldung = new VeranstaltungMeldung();

        $meldung->anmelder_id = $input['meldung']['anmelder']['id'];
        $meldung->hund_id = $input['meldung']['hund']['id'];
        $meldung->hundefuehrer_id = $input['meldung']['hundefuehrer']['id'];
        $meldung->angemeldet_am = date('Y-m-d H:i:s');

        $meldung->storniert = 0;
        $meldung->angenommen = 0;
        $meldung->bezahlt = 0;
        $meldung->zugesagt = 0;
        $meldung->abgelehnt = 0;
        $meldung->veranstaltung_id = $input['va_id'];
        $meldung->save();

        return ['id' => $meldung->id];
    }
}
