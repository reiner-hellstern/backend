<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateZwingerKontaktdatenRequest;
use App\Http\Requests\UpdateZwingerRassenRequest;
use App\Http\Requests\UpdateZwingerRequest;
use App\Http\Resources\OptionZwingernameResource;
use App\Http\Resources\ZwingerResource;
use App\Models\Person;
use App\Models\Wurf;
use App\Models\Zwinger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZwingerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $zwinger = Zwinger::where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                if ($column['filterable'] == true && $column['filtertype'] != 0) {
                    switch ($column['filtertype']) {
                        case 2:
                            $query->where($column['db_field'], 'NOT LIKE', '%' . $column['filter'] . '%');
                            break;
                        case 3:
                            $query->where($column['db_field'], 'LIKE', $column['filter'] . '%');
                            break;
                        case 4: //LEER
                            $query->where(function ($q) use ($column) {
                                $q->whereNull($column['db_field'])->orWhere($column['db_field'], '=', '')->orWhere($column['db_field'], '=', '0000-00-00');
                            });
                            break;
                        case 5:  //NICHT LEER
                            $query->whereNotNull($column['db_field'])->where($column['db_field'], '<>', '')->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 6:
                            $query->where($column['db_field'], '=', $column['filter']);
                            break;
                        case 7:
                            $query->where($column['db_field'], '<>', $column['filter']);
                            break;
                        case 8:
                            $query->where($column['db_field'], '>', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 9:
                            $query->where($column['db_field'], '<', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 10:
                            $query->where($column['db_field'], '>=', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 11:
                            $query->where($column['db_field'], '<=', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 12:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->whereDate($column['db_field'], $sqldate);
                            break;
                        case 13:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($column['db_field'], '<=', $sqldate)->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 14:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($column['db_field'], '>=', $sqldate)->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 1:
                        default:
                            $query->where($column['db_field'], 'LIKE', '%' . $column['filter'] . '%');
                            break;
                    }
                }
            }
        })->when($search != '', function ($query) use ($columns, $search) {
            $first = true;
            foreach ($columns as $column) {
                if ($column['searchable'] == true) {
                    if ($first == true) {
                        $query->where($column['db_field'], 'LIKE', '%' . $search . '%');
                        $first = false;
                    } else {
                        $query->orWhere($column['db_field'], 'LIKE', '%' . $search . '%');
                    }
                }
            }
        })->orderBy($sortField, $sortDirection)->paginate($pagination);

        return ZwingerResource::collection($zwinger);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Zwinger $zwinger)
    {
        return $zwinger->append('gemeinschaft');
        // return ZwingerResource::collection( Zwinger::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zwingerakte(Zwinger $zwinger)
    {

        $zwinger->load('images', 'zuchtstaetten', 'rassen', 'wuerfe', 'wurfplaene', 'wurfabnahmen', 'dokumente', 'personen');

        return $zwinger;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zwinger  $hund
     * @return \Illuminate\Http\Response
     */
    public function wuerfe($id)
    {

        $wuerfe = Zwinger::find($id)->wuerfe;

        return $wuerfe;

        return ZwingerResource::collection(Zwinger::find($id));
    }

    public function personen($id)
    {

        $personen = Zwinger::find($id)->personen;

        return $personen;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

        $name = trim($request->name);
        $vorname = trim($request->vorname);
        $nachname = trim($request->nachname);
        $rasse_id = $request->rasse_id;
        $plz = $request->plz;
        $umkreis = $request->umkreis;

        $plzs = DB::select('SELECT dest.plz, ACOS(
               SIN(RADIANS(src.breitengrad)) * SIN(RADIANS(dest.breitengrad)) 
               + COS(RADIANS(src.breitengrad)) * COS(RADIANS(dest.breitengrad))
               * COS(RADIANS(src.laengengrad) - RADIANS(dest.laengengrad))
         ) * 6380 AS distance
         FROM postleitzahlen dest
         CROSS JOIN postleitzahlen src
         WHERE src.plz = ?
         HAVING distance < ?
         ORDER BY distance;', [$plz, $umkreis]);

        $plz_ids = [];
        foreach ($plzs as $plz) {
            $plz_ids[] = $plz->plz;
        }

        $count = 0;
        // $count =  Zwinger::select( 'id')
        // ->leftjoin('rasse_zwinger', 'rasse_zwinger.zwinger_id', '=', 'zwinger.id')
        // ->when($name != '', function ($query) use ($name) {
        //    $query->where('zwinger.zwingername', 'LIKE', '%' . $name . '%');
        // })
        // ->when($vorname != '', function ($query) use ($vorname) {
        //    $query->where('personen.vorname', 'LIKE', '%' . $vorname . '%');
        // })
        // ->when($nachname != '', function ($query) use ($nachname) {
        //    $query->where('personen.nachname', 'LIKE', '%' . $nachname . '%');
        // })
        // ->when($rasse_id != 0, function ($query) use ($rasse_id) {
        //    $query->where('rasse_zwinger.rasse_id', '=', $rasse_id);
        // })
        // ->when(count($plz_ids), function ($query) use ($plz_ids) {
        //    $query->whereIn('zwinger.postleitzahl', $plz_ids);
        // })
        // ->count();

        $zwinger = Zwinger::with(['rassen', 'personen', 'images', 'wuerfe'])->select('zwinger.*')
            ->leftjoin('rasse_zwinger', 'rasse_zwinger.zwinger_id', '=', 'zwinger.id')
            ->leftjoin('person_zwinger', 'person_zwinger.zwinger_id', '=', 'zwinger.id')
            ->leftjoin('personen', 'personen.id', '=', 'person_zwinger.person_id')
            ->when($name != '', function ($query) use ($name) {
                $query->where('zwinger.zwingername', 'LIKE', '%' . $name . '%');
            })
            ->when($vorname != '', function ($query) use ($vorname) {
                $query->where('personen.vorname', 'LIKE', '%' . $vorname . '%');
            })
            ->when($nachname != '', function ($query) use ($nachname) {
                $query->where('personen.nachname', 'LIKE', '%' . $nachname . '%');
            })
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                $query->where('rasse_zwinger.rasse_id', '=', $rasse_id);
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                $query->whereIn('zwinger.postleitzahl', $plz_ids);
            })
            ->groupby('zwinger.id')->orderBy('zwinger.postleitzahl')->limit(100)->get();

        //   $zwinger = Zwinger::where('zwingername',  'like', '%'.$request->name.'%')->limit(250)->orderBy('zwingername', 'desc')->get();

        return [
            'ergebnisliste' => $zwinger, // ZwingerResource::collection($zwinger),
            'anzahl' => $count,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function auto(Request $request)
    {
        $zwinger = Zwinger::where('zwingername', 'like', $request->suche . '%')->orWhere('zwingername', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('zwingername', 'desc')->get();

        return OptionZwingernameResource::collection($zwinger);
    }

    public function autocomplete(Request $request)
    {

        $fcinummer = trim($request->zn);
        $zwingername = trim($request->zn);
        $drcnummer = trim($request->zn);
        $strasse = trim($request->str);
        $plz = trim($request->plz);
        $ort = trim($request->ort);
        $complete = $request->c;
        $main = $request->m;

        $count = Zwinger::when($zwingername != '', function ($query) use ($zwingername) {
            return $query->where('zwingername', 'LIKE', '%' . $zwingername . '%');
        })->when($strasse != '', function ($query) use ($strasse) {
            return $query->where('strasse', 'LIKE', '%' . $strasse . '%');
        })->when($plz != '', function ($query) use ($plz) {
            return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
        })->when($ort != '', function ($query) use ($ort) {
            return $query->where('ort', 'LIKE', '%' . $ort . '%');
        })
            ->count();

        if ($count <= 10) {
            $complete = true;
            $zwingers = Zwinger::select('id', 'zwingername', 'strasse', 'postleitzahl', 'ort', 'fcinummer', 'gebiet', 'zwingernummer')
                ->when($zwingername != '', function ($query) use ($zwingername) {
                    return $query->where('zwingername', 'LIKE', '%' . $zwingername . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })
                ->limit(10)->orderBy($main, 'asc')->get();
        } else {

            $count = Zwinger::when($zwingername != '', function ($query) use ($zwingername) {
                return $query->where('zwingername', 'LIKE', '%' . $zwingername . '%');
            })->when($strasse != '', function ($query) use ($strasse) {
                return $query->where('strasse', 'LIKE', '' . $strasse . '%');
            })->when($plz != '', function ($query) use ($plz) {
                return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
            })->when($ort != '', function ($query) use ($ort) {
                return $query->where('ort', 'LIKE', '%' . $ort . '%');
            })
                ->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')
                ->count();

            if ($count < 200) {
                $complete = false;
                $zwingers = Zwinger::when($zwingername != '', function ($query) use ($zwingername) {
                    return $query->where('zwingername', 'LIKE', '%' . $zwingername . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })
                    ->limit(200)->orderBy($main, 'asc')->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')->pluck($main);
            } else {
                $zwingers = [];
                $complete = false;
            }
        }

        return [
            'complete' => $complete,
            'zwingers' => $count,
            'result' => $zwingers,
        ];
    }

    public function zuechter_autocomplete(Request $request)
    {

        $nachname = trim($request->nn);
        $vorname = trim($request->vn);
        $zwinger_id = trim($request->zid);
        $main = $request->m;

        $personen = Person::leftjoin('mitglieder', 'mitglieder.id', '=', 'personen.mitglied_id')
            ->leftjoin('person_zwinger', 'person_zwinger.person_id', '=', 'personen.id')
            ->select('nachname', 'vorname', 'strasse', 'postleitzahl', 'ort', 'mitglied_id', 'personen.id as id', 'mitglieder.mitglied_nr as mitgliedsnummer')
            ->where('person_zwinger.zwinger_id', $zwinger_id)
            ->when($nachname != '', function ($query) use ($nachname) {
                return $query->where('nachname', 'LIKE', '' . $nachname . '%');
            })->when($vorname != '', function ($query) use ($vorname) {
                return $query->where('vorname', 'LIKE', '' . $vorname . '%');
            })->limit(10)->orderBy($main, 'asc')->get();

        return [
            'complete' => true,
            'personen' => count($personen),
            'result' => $personen,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function zwinger_update(UpdateZwingerRequest $request, Zwinger $zwinger)
    {

        $validated = $request->validated();

        $update = $request->all();

        if (1) {

            $zwinger->strasse = $update['strasse'];
            $zwinger->adresszusatz = $update['adresszusatz'];
            $zwinger->postleitzahl = $update['postleitzahl'];
            $zwinger->ort = $update['ort'];
            $zwinger->land = $update['land'];
            $zwinger->laenderkuerzel = $update['laenderkuerzel'];
            $zwinger->telefon_1 = $update['telefon_1'];
            $zwinger->telefon_2 = $update['telefon_2'];
            $zwinger->website = $update['website'];
            $zwinger->website_1 = $update['website_1'];
            $zwinger->website_2 = $update['website_2'];
            $zwinger->email_1 = $update['email_1'];
            $zwinger->email_2 = $update['email_2'];
            $zwinger->bemerkung = $update['bemerkung'];
            $zwinger->rasse = $update['rasse'];
            $zwinger->verein = $update['verein'];
            $zwinger->mitgliedsnummer = $update['mitgliedsnummer'];
            $zwinger->zwingernummer = $update['zwingernummer'];
            $zwinger->zwingername = $update['zwingername'];
            $zwinger->zwingername_praefix = $update['zwingername_praefix'];
            $zwinger->zwingername_suffix = $update['zwingername_suffix'];
            $zwinger->gebiet = $update['gebiet'];
            $zwinger->fcinummer = $update['fcinummer'];
            $zwinger->liste = $update['liste'];
            $zwinger->dsgvo = $update['dsgvo'];

            $zwinger->save();

            return $zwinger;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function zwingers_update(Request $request)
    {
        // Validatierung
        // http://laravel.com/docs/validation

        $ids = [];

        foreach ($request->all() as $update) {
            //      // $validated = $request->validated();
            //      if (1) {

            $zwinger = Zwinger::find($update['id']);
            $zwinger->strasse = $update['strasse'];
            $zwinger->adresszusatz = $update['adresszusatz'];
            $zwinger->postleitzahl = $update['postleitzahl'];
            $zwinger->ort = $update['ort'];
            $zwinger->land = $update['land'];
            $zwinger->laenderkuerzel = $update['laenderkuerzel'];
            $zwinger->telefon_1 = $update['telefon_1'];
            $zwinger->telefon_2 = $update['telefon_2'];
            $zwinger->website = $update['website'];
            $zwinger->website_1 = $update['website_1'];
            $zwinger->website_2 = $update['website_2'];
            $zwinger->email_1 = $update['email_1'];
            $zwinger->email_2 = $update['email_2'];
            $zwinger->bemerkung = $update['bemerkung'];
            $zwinger->rasse = $update['rasse'];
            $zwinger->verein = $update['verein'];
            $zwinger->mitgliedsnummer = $update['mitgliedsnummer'];
            $zwinger->zwingernummer = $update['zwingernummer'];
            $zwinger->zwingername = $update['zwingername'];
            $zwinger->zwingername_praefix = $update['zwingername_praefix'];
            $zwinger->zwingername_suffix = $update['zwingername_suffix'];
            $zwinger->gebiet = $update['gebiet'];
            $zwinger->fcinummer = $update['fcinummer'];
            $zwinger->liste = $update['liste'];
            $zwinger->dsgvo = $update['dsgvo'];
            if ($zwinger->save()) {
                $ids[] = $zwinger->id;
            }
        }
        //  }

        return $ids;
    }

    public function antrag_zuchtrasse_show(Request $request)
    {
        return $request;
    }

    public function antrag_zuchtrasse_update(Request $request)
    {
        return $request;
    }

    public function antrag_zuchtrasse_store(Request $request)
    {
        return $request;
    }

    public function antrag_zuchtrasse_delete(Request $request)
    {
        return $request;
    }

    /**
     * Update Zwinger Rassen
     *
     * Logik:
     * - Bestehende Rassen, die nicht mehr ausgewählt sind, werden deaktiviert (aktiv=0, bis=heute)
     *   AUSNAHME: Wenn für die Rasse kein Wurf existiert, wird die Relation gelöscht
     * - Neue Rassen werden hinzugefügt (aktiv=1, von=heute)
     * - Bereits aktive Rassen bleiben unverändert
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function zuchtrasse_update(UpdateZwingerRassenRequest $request)
    {
        $validated = $request->validated();

        try {
            $zwinger = Zwinger::findOrFail($validated['zwinger_id']);

            // Prüfen ob der authentifizierte User berechtigt ist
            $user = $request->user();
            $isOwner = $zwinger->personen->contains('id', $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, diesen Zwinger zu bearbeiten.',
                ], 403);
            }

            DB::transaction(function () use ($zwinger, $validated) {
                $neueRassenIds = $validated['rassen'];
                $heute = Carbon::now()->format('Y-m-d');

                // Hole alle bestehenden Rassen-Relationen für diesen Zwinger
                $bestehendeRassen = DB::table('rasse_zwinger')
                    ->where('zwinger_id', $zwinger->id)
                    ->get();

                // Verarbeite bestehende Rassen
                foreach ($bestehendeRassen as $bestehendeRasse) {
                    $rasseId = $bestehendeRasse->rasse_id;

                    // Wenn die Rasse nicht mehr in der neuen Auswahl ist
                    if (! in_array($rasseId, $neueRassenIds)) {
                        // Prüfen ob die Rasse bereits verwendet wurde (hat einen Wurfbuchstaben)
                        $hatWurfbuchstabe = ! empty($bestehendeRasse->wurfbuchstabe);

                        if ($hatWurfbuchstabe) {
                            // Rasse deaktivieren und bis-Datum setzen
                            DB::table('rasse_zwinger')
                                ->where('id', $bestehendeRasse->id)
                                ->update([
                                    'aktiv' => 0,
                                    'bis' => $heute,
                                    'updated_at' => now(),
                                ]);
                        } else {
                            // Relation komplett löschen, wenn kein Wurfbuchstabe existiert
                            DB::table('rasse_zwinger')
                                ->where('id', $bestehendeRasse->id)
                                ->delete();
                        }
                    }
                    // Wenn die Rasse in der neuen Auswahl ist und bereits existiert,
                    // bleibt sie unverändert
                }

                // Füge neue Rassen hinzu
                $bestehendeRassenIds = $bestehendeRassen->pluck('rasse_id')->toArray();

                foreach ($neueRassenIds as $neueRasseId) {
                    if (! in_array($neueRasseId, $bestehendeRassenIds)) {
                        DB::table('rasse_zwinger')->insert([
                            'zwinger_id' => $zwinger->id,
                            'rasse_id' => $neueRasseId,
                            'aktiv' => 1,
                            'von' => $heute,
                            'bis' => null,
                            'wurfbuchstabe' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

            // Lade die aktualisierten Rassen mit allen Details im Laravel-Pivot-Format
            $aktualisiertRassen = DB::table('rasse_zwinger')
                ->join('rassen', 'rasse_zwinger.rasse_id', '=', 'rassen.id')
                ->where('rasse_zwinger.zwinger_id', $zwinger->id)
                ->select(
                    'rassen.id',
                    'rassen.name',
                    'rassen.name_lang',
                    'rassen.name_kurz',
                    'rassen.buchstabe',
                    'rasse_zwinger.aktiv as pivot_aktiv',
                    'rasse_zwinger.von as pivot_von',
                    'rasse_zwinger.bis as pivot_bis',
                    'rasse_zwinger.wurfbuchstabe as pivot_wurfbuchstabe'
                )
                ->get()
                ->map(function ($rasse) {
                    return [
                        'id' => $rasse->id,
                        'name' => $rasse->name,
                        'name_lang' => $rasse->name_lang,
                        'name_kurz' => $rasse->name_kurz,
                        'buchstabe' => $rasse->buchstabe,
                        'pivot' => [
                            'aktiv' => $rasse->pivot_aktiv,
                            'von' => $rasse->pivot_von,
                            'bis' => $rasse->pivot_bis,
                            'wurfbuchstabe' => $rasse->pivot_wurfbuchstabe,
                        ],
                    ];
                });

            return response()->json([
                'success' => 'Die Rassen wurden erfolgreich aktualisiert.',
                'error' => null,
                'data' => [
                    'zwinger_id' => $zwinger->id,
                    'rassen' => $aktualisiertRassen,
                ],
            ], 200);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Rassen konnten nicht aktualisiert werden.',
            ], 500);
        }
    }

    public function zuchtrasse_store(Request $request)
    {
        return $request;
    }

    public function zuchtrasse_delete(Request $request)
    {
        return $request;
    }

    /**
     * Update Zwinger Kontaktdaten
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function kontaktdaten_update(UpdateZwingerKontaktdatenRequest $request)
    {
        $validated = $request->validated();

        try {
            $zwinger = Zwinger::findOrFail($validated['zwinger_id']);

            // Prüfen ob der authentifizierte User berechtigt ist
            // (sollte Eigentümer oder Mitinhaber des Zwingers sein)
            $user = $request->user();
            $isOwner = $zwinger->personen->contains('id', $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, diesen Zwinger zu bearbeiten.',
                ], 403);
            }

            // Kontaktdaten aktualisieren
            $zwinger->telefon_1 = $validated['telefon_1'];
            $zwinger->telefon_2 = $validated['telefon_2'] ?? null;
            $zwinger->email_1 = $validated['email_1'];
            $zwinger->email_2 = $validated['email_2'] ?? null;
            $zwinger->website_1 = $validated['website_1'] ?? null;

            $zwinger->save();

            return response()->json([
                'success' => 'Die Kontaktdaten wurden erfolgreich aktualisiert.',
                'error' => null,
                'data' => [
                    'zwinger_id' => $zwinger->id,
                ],
            ], 200);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Kontaktdaten konnten nicht aktualisiert werden.',
            ], 500);
        }
    }
}
