<?php

namespace App\Http\Controllers;

use App\Http\Resources\HundeShortResource;
use App\Models\Hund;
// use App\Models\Image;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
// use App\Models\Bezahlart;
// use App\Http\Resources\BezahlartResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

        $url = Config::get('app.url');

        $id = Auth::id();

        if (! $id) {
            return;
        }

        $person = User::find($id)->person;
        $user = cache()->remember('hundedata', 60 * 60 * 24, function () use ($id) {
            return User::with(['person',
                'person.mitglied',
                'person.mitglied.landesgruppe',
                'person.mitglied.bezirksgruppe',
                'person.zwinger',
                'person.funktionen',
                'person.dokumente',
                'person.listen',
                // 'person.hunde'
            ])
                ->find($id);
        });

        $hunde2 = cache()->remember('hundedata', 60 * 60 * 24, function () use ($person) {
            return Hund::with([
                'images', 'farbe', 'rasse', 'geschlecht', 'formwert', 'dokumente', 'wesenstest', 'pruefungentitel', 'personen', 'gentests_total', 'goniountersuchung',
                'zahnstati' => function ($query) {
                    $query->where('zahnstati.aktiv', '=', '1');
                },
                'hdeduntersuchungen' => function ($query) {
                    $query->where('hded_untersuchungen.aktiv', '=', '1');
                },
                'ocduntersuchungen' => function ($query) {
                    $query->where('ocd_untersuchungen.aktiv', '=', '1');
                },
                'augenuntersuchungen' => function ($query) {
                    $query->where('augenuntersuchungen.aktive_au', '=', '1');
                },
            ])->select('hunde.*', 'zuchtbuchnummer', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
                ->leftjoin('geschlecht', 'geschlecht_id', '=', 'optionen_geschlecht_hund.id')
                ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
                ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
                ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
                ->where('hund_person.person_id', '=', $person->id)
                ->orderBy('wurfdatum', 'desc')
                ->get();
        });

        return $user . $hunde2;

        return 'A:' . response()->json($user, 200, [], JSON_PRETTY_PRINT);

        $mitglied = $person->mitglied;
        if ($mitglied) {
            $landesgruppe = $mitglied->landesgruppe;
            $bezirksgruppe = $mitglied->bezirksgruppe;
            $mitgliedsart = $mitglied->mitgliedsart;

            $mitglied['landesgruppe'] = $landesgruppe;
            $mitglied['bezirksgruppe'] = $bezirksgruppe;
            $mitglied['mitgliedschaft'] = $mitgliedsart;

            //  $mitglied['datum_austritt'] =  date('d.m.Y', strtotime($mitglied['datum_austritt']));
            //  $mitglied['datum_eintritt'] =  date('d.m.Y', strtotime($mitglied['datum_eintritt']));
        }

        $zwinger = $person->zwinger;
        if ($zwinger) {
            $zwinger->rassen;
            $zwinger->zuechter;
            $zwinger->personen;
            $wuerfe = $zwinger->wuerfe;
            $zwinger->images;
            foreach ($wuerfe as $wurf) {
                //  $wurf->hunde;

                // foreach ($wurf->hunde as $hund) {
                // }
                $wurf['wurfdatum'] = date('d.m.Y', strtotime($wurf['wurfdatum']));
                $wurf['deckdatum'] = date('d.m.Y', strtotime($wurf['deckdatum']));
                $wurf->rasse;
                $wurf['vater'] = Hund::find($wurf->vater_id);
                $wurf['mutter'] = Hund::find($wurf->mutter_id);
            }
        } else {
            $wuerfe = [];
            $zwinger = [];
        }

        $person['zwinger'] = $zwinger;
        if ($zwinger) {
            $person['zwinger']['dokumente'] = $zwinger->dokumente;
        }
        // $person['wuerfe'] = $wuerfe;
        // $person['hunde'] = ''; // $hunde;
        $person['hunde'] = HundeShortResource::collection($hunde2);
        //  $person['zuchthunde'] = HundeShortResource::collection($zuchthunde);
        $person['funktionen'] = $user->person->funktionen;
        $person['listen'] = $user->person->listen;
        $person['mitglied'] = $mitglied;
        $person['profile_photo_url'] = $user->profile_photo_url;
        $person['person'] = $user->person;
        $person['dokumente'] = $user->person->dokumente;

        return 1;

        return $person;

    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
