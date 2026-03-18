<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBasisdatenRequest;
use App\Http\Requests\UpdateBasisdatenRequest;
use App\Models\Chipnummer;
use App\Models\Hund;
use App\Models\Zuchtbuchnummer;
use App\Traits\SaveArzt;
use App\Traits\SavePerson;
use App\Traits\SaveZwinger;

class BasisdatenController extends Controller
{
    use SaveArzt;
    use SavePerson;
    use SaveZwinger;

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
    public function store(StoreBasisdatenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBasisdatenRequest $request, Hund $hund)
    {

        // return $request;
        // return $hund;

        $hund->name = $request->hund['name'];
        $hund->rasse_id = $request->hund['rasse']['id'];
        $hund->farbe_id = $request->hund['farbe']['id'];
        $hund->geschlecht_id = $request->hund['geschlecht']['id'];
        if (count($request->hund['zuchtbuchnummern'])) {
            $hund->zuchtbuchnummer = $request->hund['zuchtbuchnummern'][0];
        }
        if (count($request->hund['chipnummern'])) {
            $hund->chipnummer = $request->hund['chipnummern'][0];
        }

        $zuchtbuchnummern = $request->hund['zuchtbuchnummern'];
        $hund->zuchtbuchnummern()->delete();
        foreach ($zuchtbuchnummern as $key => $zuchtbuchnummer) {
            $new_zuchtbuchnummer = new Zuchtbuchnummer();
            $new_zuchtbuchnummer->zuchtbuchnummer = $zuchtbuchnummer;
            $new_zuchtbuchnummer->order = $key + 1;
            $hund->zuchtbuchnummern()->save($new_zuchtbuchnummer);
        }

        $chipnummern = $request->hund['chipnummern'];
        $hund->chipnummern()->delete();
        foreach ($chipnummern as $key => $chipnummer) {
            $new_chipnummer = new Chipnummer();
            $new_chipnummer->chipnummer = $chipnummer;
            $new_chipnummer->order = $key + 1;
            $hund->chipnummern()->save($new_chipnummer);
        }

        $hund->drc_gstb_nr = $request->hund['drc_gstb_nr'];
        $hund->gstb_nr = $request->hund['gstb_nr'];
        $hund->taetowierung = isset($request->hund['taetowierung']) ? $request->hund['taetowierung'] : '';
        $hund->wurfdatum = $request->hund['wurfdatum'];
        $hund->zuchtart_id = $request->hund['zuchtart']['id'];
        $hund->verstorben = $request->hund['verstorben'];
        $hund->sterbedatum = $request->hund['sterbedatum'];
        $hund->todesursache_anmerkung = $request->hund['todesursache_anmerkung'];
        $hund->todesursache_id = isset($request->hund['todesursache']) ? $request->hund['todesursache']['id'] : $hund->todesursache_id;

        $hund->vater_id = isset($request->vater['id']) ? $request->vater['id'] : null;
        $hund->mutter_id = isset($request->mutter['id']) ? $request->mutter['id'] : null;
        $hund->vater_zuchtbuchnummer = $request->vater['zuchtbuchnummer'];
        $hund->mutter_zuchtbuchnummer = $request->mutter['zuchtbuchnummer'];
        $hund->vater_name = $request->vater['name'];
        $hund->mutter_name = $request->mutter['name'];

        $hund->zwinger_id = $this->saveZwinger($request->herkunftszuchtstaette);
        $hund->zwinger_name = $request->herkunftszuchtstaette['zwingername'];
        $hund->zwinger_strasse = $request->herkunftszuchtstaette['strasse'];
        $hund->zwinger_plz = $request->herkunftszuchtstaette['postleitzahl'];
        $hund->zwinger_ort = $request->herkunftszuchtstaette['ort'];
        $hund->zwinger_fci = $request->herkunftszuchtstaette['fcinummer'];
        $hund->zwinger_telefon = $request->herkunftszuchtstaette['telefon'];

        $hund->zuechter_id = $request->herkunftszuchtstaette['zuechter_id'];
        $hund->zuechter_vorname = $request->herkunftszuchtstaette['zuechter_vorname'];
        $hund->zuechter_nachname = $request->herkunftszuchtstaette['zuechter_nachname'];

        $person = $request->herkunftszuchtstaette['person'];
        if ($request->herkunftszuchtstaette['confirmations']['zuechteradresse'] == 1 || $request->herkunftszuchtstaette['confirmations']['zuechteradresse'] == true) {
            $person['strasse'] = $request->herkunftszuchtstaette['strasse'];
            $person['adresszusatz'] = '';
            $person['postleitzahl'] = $request->herkunftszuchtstaette['postleitzahl'];
            $person['ort'] = $request->herkunftszuchtstaette['ort'];
            $person['land'] = $request->herkunftszuchtstaette['land'];
            $person['telefon_1'] = $request->herkunftszuchtstaette['telefon'];
        }

        $result = $this->savePerson($person);
        $hund->zuechter_id = $result['person_id'];

        // $hund->bemerkung = $request->bemerkung;

        // $hund->zwinger_id = $request->herkunftszuchtstaette['id'];
        // $hund->zwinger_nr = $request->herkunftszuchtstaette['zuechter_id'];
        // $hund->zwinger_name = $request->herkunftszuchtstaette['zwingername'];
        // $hund->zwinger_strasse = $request->herkunftszuchtstaette['strasse'];
        // $hund->zwinger_plz = $request->herkunftszuchtstaette['postleitzahl'];
        // $hund->zwinger_ort = $request->herkunftszuchtstaette['ort'];
        // $hund->zwinger_fci = $request->herkunftszuchtstaette['fcinummer'];
        // $hund->zwinger_telefon = $request->herkunftszuchtstaette['telefon'];
        // $hund->zuechter_id = $request->herkunftszuchtstaette['zuechter_id'];
        // $hund->zuechter_vorname = $request->zuechter_vorname;
        // $hund->zuechter_nachname = $request->zuechter_nachname;

        $hund->save();

        return response()->json(['hund' => $hund, 'person' => $person], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
