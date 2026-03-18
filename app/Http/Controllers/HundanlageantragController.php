<?php

namespace App\Http\Controllers;

use App\Http\Resources\HundInitResource;
use App\Models\Ahnentafel;
use App\Models\Chipnummer;
use App\Models\Hund;
use App\Models\Hundanlageantrag;
use App\Models\Zuchtbuchnummer;
use App\Models\Zwinger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HundanlageantragController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $hundanlageantrag_typ = 2; // Bestandshund (Kauf)
        $hundanlageantrag_typ = 3; // Bestandshund (Verkauf)

        $user_id = Auth::id();

        $user = Auth::user();
        $person = $user->person;

        // HUND ANLEGEN ODER NICHT???

        if ($request->hund['id'] == 0) {
            // NEUEN HUND ANLEGEN

            $hundanlageantrag_typ = 1; // NEUANLAGE (Kauf)

            $hund = new Hund();

            $hund->aktiv = 0;
            $hund->freigabe = 0;
            $hund->created_id = $user_id;
            $hund->freigabe_id = 0;
            $hund->status_id = 10; // 10 = ungeprüft

            $hund->name = $request->hund['name'];

            $hund->farbe_id = $request->hund['farbe']['id'];
            $hund->geschlecht_id = $request->hund['geschlecht']['id'];
            $hund->rasse_id = $request->hund['rasse']['id'];

            $hund->wurfdatum = $request->hund['wurfdatum'];
            $hund->zuchtart_id = $request->hund['zuchtart']['id'];

            $hund->save();

            $ahnentafel = new Ahnentafel();
            $ahnentafel->hund_id = $hund->id;
            $ahnentafel->save();

            $hund->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
            $zuchtbuchnummer = new Zuchtbuchnummer();
            $zuchtbuchnummer->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
            $zuchtbuchnummer->order = 1;
            $hund->zuchtbuchnummern()->save($zuchtbuchnummer);

            $hund->chipnummer = $request->hund['chipnummer'];
            $chipnummer = new Chipnummer();
            $chipnummer->chipnummer = $request->hund['chipnummer'];
            $chipnummer->order = 1;
            $hund->chipnummern()->save($chipnummer);

            $hund->save();
        } else {
            // BESTANDSHUND
            $hund = Hund::find($request->hund['id']);

            $hundanlageantrag_typ = 2; // Bestandshund (Kauf)
            $ahnentafel = Ahnentafel::where('hund_id', $hund->id)->first();
        }

        $hundanlageantrag = new Hundanlageantrag();

        $hundanlageantrag->accessDRC_at = now();
        $hundanlageantrag->accessAntragsteller_at = now();

        $hundanlageantrag->antragsteller_id = $person->id;
        $hundanlageantrag->hund_id = $hund->id;
        $hundanlageantrag->typ_id = $hundanlageantrag_typ;
        $hundanlageantrag->status_id = $request->senden ? 2 : 1; // 1 = gespeichert, 2 = gesendet
        $hundanlageantrag->bemerkungen_antragsteller = $request->hundanlageantrag['bemerkungen_antragsteller'];
        $hundanlageantrag->sent_at = $request->senden ? now() : null;

        $hundanlageantrag->save();

        $hundanlageantrag2 = $hundanlageantrag->fresh();
        $hundanlageantrag2->load('hund', 'hund.vater', 'hund.mutter', 'hund.chipnummern', 'hund.zuchtbuchnummern', 'hund.dokumente');

        return response()->json(['success' => 'success', 'hund' => $hund, 'hundanlageantrag' => $hundanlageantrag2, 'ahnentafel' => $ahnentafel], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Hundanlageantrag $hundanlageantrag)
    {

        // $drc = $request->drc;
        // $user_id = Auth::id();

        // $hundanlageantrag->antragsteller_id == $drc ? $hundanlageantrag->accessDRC_at = now() : $hundanlageantrag->accessAntragsteller_at = now();
        // $hundanlageantrag->save();

        return response()->json(['success' => 'success', 'hundanlageantrag' => $hundanlageantrag], 200);
        $hund = Hund::with('chipnummern', 'zuchtbuchnummern', 'dokumente', 'images', 'personen', 'vater', 'mutter', 'zuchttauglichkeit')->find($hundanlageantrag->hund_id);

        //  $hund = Hund::with([
        //     'dokumente', 'personen', 'zwinger', 'zuechter', 'vater','mutter'
        //  ])->where('hunde.id', '=', $request->id)
        //    ->get();

        return response()->json(['success' => 'success', 'hundanlageantrag' => $hundanlageantrag, 'hund' => new HundInitResource($hund)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hundanlageantrag $hundanlageantrag)
    {

        $hundanlageantrag->bemerkungen_antragsteller = $request->bemerkungen_antragsteller;
        $hundanlageantrag->bemerkungen_drc = $request->bemerkungen_drc;

        if ($request->status_id == 40) {
            $hundanlageantrag->status_id = $request->status_id;
            $hundanlageantrag->bearbeiter_id = Auth::id();
            $hundanlageantrag->aktiv = 0;

            $hund = Hund::find($hundanlageantrag->hund_id);
            $hund->aktiv = 1;
            $hund->freigabe = 1;
            $hund->status_id = 40;
            $hund->freigabe_id = Auth::id();
            $hund->save();

        } elseif ($request->status_id == 50) {
            $hundanlageantrag->status_id = $request->status_id;
            $hundanlageantrag->bearbeiter_id = Auth::id();
            $hundanlageantrag->aktiv = 0;

            $hund = Hund::find($hundanlageantrag->hund_id);
            $hund->aktiv = 0;
            $hund->freigabe = 0;
            $hund->freigabe_id = Auth::id();
            $hund->status_id = 50;
            $hund->save();

        } elseif ($hundanlageantrag->status_id == 1 || $hundanlageantrag->status_id == 2) {
            $hundanlageantrag->status_id = $request->senden ? 2 : 1;
            $hundanlageantrag->bearbeiter_id = 0;
            $hundanlageantrag->aktiv = 1;
            $hundanlageantrag->sent_at = $request->senden && $hundanlageantrag->send_at == null ? now() : $hundanlageantrag->send_at;

            $hund = Hund::find($hundanlageantrag->hund_id);
            if (! $hund->freigabe) {
                $hund->name = $request->hund['name'];
                $hund->farbe_id = $request->hund['farbe']['id'];
                $hund->geschlecht_id = $request->hund['geschlecht']['id'];
                $hund->rasse_id = $request->hund['rasse']['id'];
                $hund->wurfdatum = $request->hund['wurfdatum'];
                $hund->zuchtart_id = $request->hund['zuchtart']['id'];

                $hund->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
                $hund->zuchtbuchnummern()->delete();
                $zuchtbuchnummer = new Zuchtbuchnummer();
                $zuchtbuchnummer->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
                $zuchtbuchnummer->order = 1;
                $hund->zuchtbuchnummern()->save($zuchtbuchnummer);

                $hund->chipnummer = $request->hund['chipnummer'];
                $hund->chipnummern()->delete();
                $chipnummer = new Chipnummer();
                $chipnummer->chipnummer = $request->hund['chipnummer'];
                $chipnummer->order = 1;
                $hund->chipnummern()->save($chipnummer);

                $hund->save();

            }
        } else {

            $hundanlageantrag->save();

            return response()->json(['success' => 'Interne Anmerkung gespeichert.'], 200);
        }

        $hundanlageantrag->save();

        $hundanlageantrag2 = $hundanlageantrag->fresh();
        $hundanlageantrag2->load('hund', 'hund.vater', 'hund.mutter', 'hund.chipnummern', 'hund.zuchtbuchnummern', 'hund.dokumente');

        $ahnentafel = Ahnentafel::where('hund_id', $hund->id)->first();

        return response()->json(['success' => 'success', 'hundanlageantrag' => $hundanlageantrag2, 'hund' => $hund, 'ahnentafel' => $ahnentafel], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hundanlageantrag $hundanlageantrag)
    {

        if ($hundanlageantrag->status_id == 40) {
            return response()->json(['error' => 'Hund wurde bereits freigegeben.'], 200);
        }

        if ($hundanlageantrag->status_id == 50) {
            return response()->json(['error' => 'Hund wurde bereits abgelehnt.'], 200);
        }

        if ($hundanlageantrag->status_id == 1) {

            $hund = Hund::find($hundanlageantrag->hund_id);

            if (! $hund->freigabe) {
                $hund->zuchtbuchnummern()->delete();
                $hund->chipnummern()->delete();
                $hund->ahnentafeln()->delete();
                $hund->images()->delete();
                $hund->dokumente()->delete();
                $hund->personen()->detach();
                $hund->delete();
            }

            $hundanlageantrag->delete();

            return response()->json(['success' => 'Antrag wurde gelöscht.'], 200);

        } else {
            return response()->json(['error' => 'Antrag ist bereits in Bearbeitung und kann nicht mehr gelöscht werden.'], 200);
        }

    }

    public function store_bemerkungen_drc(Request $request, Hundanlageantrag $hundanlageantrag)
    {

        $hundanlageantrag->bemerkungen_drc = $request->bemerkungen_drc;
        $hundanlageantrag->save();

        return response()->json(['success' => 'success', 'text' => 'Antrag bespeichert'], 200);
    }

    public function set_show_in_profile(Request $request, Hundanlageantrag $hundanlageantrag)
    {
        $hundanlageantrag->show_in_profile = $request->show_in_profile;
        $hundanlageantrag->save();

        return response()->json(['success' => 'success', 'text' => 'Anzeige geändert.'], 200);
    }

    public function setStatus(Request $request, Hundanlageantrag $hundanlageantrag)
    {
        $hundanlageantrag->status_id = $request->status_id;
        $hundanlageantrag->save();

        return response()->json(['success' => 'success', 'hundanlageantrag' => $hundanlageantrag], 200);
    }
}
