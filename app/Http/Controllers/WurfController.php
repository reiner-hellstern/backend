<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWurfRequest;
use App\Http\Resources\OptionResource;
use App\Http\Resources\WurfResource;
use App\Models\User;
use App\Models\Wurf;
use App\Traits\CheckActiveOwnership;
use App\Traits\GetPrerenderedHund;
use App\Traits\PrerenderHund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WurfController extends Controller
{
    use CheckActiveOwnership;
    use GetPrerenderedHund;
    use PrerenderHund;

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

        $wuerfe = Wurf::where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                if ($column['db_field_as']) {
                    $column['db_field'] = $column['db_field_as'];
                }
                $table = $column['table'] . '.';
                if ($column['filterable'] == true && $column['filtertype'] != 0) {
                    switch ($column['filtertype']) {
                        case 2:
                            $query->where($table . $column['db_field'], 'NOT LIKE', '%' . $column['filter'] . '%');
                            break;
                        case 3:
                            $query->where($table . $column['db_field'], 'LIKE', $column['filter'] . '%');
                            break;
                        case 4: //LEER
                            $query->where(function ($q) use ($column, $table) {
                                $q->whereNull($table . $column['db_field'])->orWhere($table . $column['db_field'], '=', '')->orWhere($table . $column['db_field'], '=', '0000-00-00');
                            });
                            break;
                        case 5:  //NICHT LEER
                            $query->whereNotNull($table . $column['db_field'])->where($table . $column['db_field'], '<>', '')->where($table . $column['db_field'], '<>', '0000-00-00');
                            break;
                        case 6:
                            $query->where($table . $column['db_field'], '=', $column['filter']);
                            break;
                        case 7:
                            $query->where($table . $column['db_field'], '<>', $column['filter']);
                            break;
                        case 8:
                            $query->where($table . $column['db_field'], '>', $column['filter'])->where($table . $column['db_field'], '<>', '');
                            break;
                        case 9:
                            $query->where($table . $column['db_field'], '<', $column['filter'])->where($table . $column['db_field'], '<>', '');
                            break;
                        case 10:
                            $query->where($table . $column['db_field'], '>=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                            break;
                        case 11:
                            $query->where($table . $column['db_field'], '<=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                            break;
                        case 12:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->whereDate($table . $column['db_field'], $sqldate);
                            break;
                        case 13:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($table . $column['db_field'], '<=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                            break;
                        case 14:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($table . $column['db_field'], '>=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                            break;
                        case 1:
                        default:
                            $query->where($table . $column['db_field'], 'LIKE', '%' . $column['filter'] . '%');
                            break;
                    }
                }
            }
        })->when($search != '', function ($query) use ($columns, $search) {
            $first = true;
            foreach ($columns as $column) {
                if ($column['db_field_as']) {
                    $column['db_field'] = $column['db_field_as'];
                }
                $table = $column['table'] . '.';
                if ($column['searchable'] == true) {
                    if ($first == true) {
                        $query->where($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                        $first = false;
                    } else {
                        $query->orWhere($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                    }
                }
            }
        })->orderBy($sortField, $sortDirection)->paginate($pagination);

        return WurfResource::collection($wuerfe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wurf  $hund
     * @return \Illuminate\Http\Response
     */
    public function show(Wurf $wurf)
    {
        $id = Auth::id();
        $user = User::find($id);

        $wurf->load([
            'nachkommen', 'dokumente',
        ]);
        // $wurf->load([
        //     'welpen.aktuelle_eigentuemer',
        //     'welpen.image',

        // ]);
        foreach ($wurf->nachkommen as $hund) {
            $prerender = $this->getPrerenderedHund($hund->id);
            $hund['prerendered'] = $prerender;
            // $eigentuemers = $this->getAllOwnersWithDetails($hund->id, $user->person_id);
            // $hund['eigentuemer'] = $eigentuemers;
            $hund['image'] = $hund->image(); //$hund->image();

            $hund['eigentuemer'] = $hund->eigentuemer();

        }

        /**
         * Gibt die Anzahl der bisherigen Würfe im Zwinger zurück
         * - wird frontendseitig verwendet
         * -> In der Wurfabnahme wird ab dem dritten Wurf eine weitere Option angezeigt
         */
        $wurf['wuerfe_count'] = $wurf->zwinger->wuerfe->count();
        /**
         * Fügt die aktiven Zuchtstätten des Zwingers zum Wurf hinzu.
         * - wird frontendseitig verwendet
         * -> In der Wurfabnahme wird auf 'eigung_parallelwurf' geprüft
         */
        $wurf['zuchtstaette'] = $wurf->zwinger->zuchtstaette;

        return $wurf;

        return WurfResource::collection($wurf);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wurf  $hund
     * @return \Illuminate\Http\Response
     */
    public function wurfakte(Wurf $wurf)
    {
        $id = Auth::id();
        $user = User::find($id);

        $wurf->load([
            'welpen',
        ]);

        return $wurf;

        return WurfResource::collection($wurf);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wurf  $hund
     * @return \Illuminate\Http\Response
     */
    public function welpen($id)
    {

        $wurf = Wurf::find($id)->with('welpen');

        //   foreach ($wurf->welpen as $hund) {
        //       $hund->images;
        //       $prerender = $this->getPrerenderedHund($hund->id);
        //       $hund['prerendered'] = $prerender;
        //       $eigentuemerPruefung = $this->getAllOwnersWithDetails($hund->id, $id);
        //       $hund['eigentuemer'] = $eigentuemerPruefung;
        //   }

        // $wurf['welpen'] = $wurf->welpen;

        return $wurf;

        return WurfResource::collection(Wurf::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

        if ($request->alter_min > 0) {
            $wurfdatum_min = Carbon::now()->subYears($request->alter_min)->format('Y-m-d');
        } else {
            $wurfdatum_min = '';
        }

        if ($request->alter_max > 0) {
            $wurfdatum_max = Carbon::now()->subYears($request->alter_max)->format('Y-m-d');
        } else {
            $wurfdatum_max = '';
        }

        $zwingername = trim($request->zwingername);
        $rasse_id = $request->rasse_id;
        $farbe_id = $request->farbe_id;
        $geschlecht_id = $request->geschlecht_id;

        $plz = $request->plz;
        $typ = $request->typ;
        $umkreis = $request->umkreis;
        $wuerfe = $request->wuerfe;
        $deckakte = $request->deckakte;

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

        $wuerfe = Wurf::with([
            'welpen',
            'vater',
            'mutter',
            'hunde',
        ])->select('wuerfe.*', 'rassen.name AS rasse_name', 'rasse_id', 'wuerfe.id')
            ->leftjoin('rassen', 'wuerfe.rasse_id', '=', 'rassen.id')
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                return $query->where('rasse_id', '=', $rasse_id);
            })
            ->when($wurfdatum_min != '', function ($query) use ($wurfdatum_min) {
                return $query->whereDate('wurfdatum', '<=', $wurfdatum_min);
            })
            ->when($wurfdatum_max != '', function ($query) use ($wurfdatum_max) {
                return $query->whereDate('wurfdatum', '>=', $wurfdatum_max);
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                return $query->whereHas('personen', function ($query) use ($plz_ids) {
                    $query->whereIn('postleitzahl', $plz_ids);
                });
            })
            ->limit(100)->groupBy('id')->get();

        $count = count($wuerfe);

        return [
            'wuerfe' => $wuerfe,
            'ergebnisliste' => $wuerfe,
            'anzahl' => $count,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function welpensuche(Request $request)
    {

        $geplant_von = $request->geplant_von;
        $geplant_bis = $request->geplant_bis;

        $wurfdatum_von = $request->wurfdatum_von;
        $wurfdatum_bis = $request->wurfdatum_bis;

        $deckdatum_von = $request->deckdatum_von;
        $deckdatum_bis = $request->deckdatum_bis;

        $abgabe_von = ($request->abgabe_von !== '' && $request->abgabe_von != 'undefined') ? Carbon::parse($request->abgabe_von)->format('Y-m-d') : null;
        $abgabe_bis = ($request->abgabe_bis !== '' && $request->abgabe_bis != 'undefined') ? Carbon::parse($request->abgabe_bis)->format('Y-m-d') : null;

        $rasse_id = $request->rasse_id;
        $farbe_id = $request->farbe_id;
        $geschlecht_id = $request->geschlecht_id;

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

        $wuerfe = Wurf::with([
            'welpen',
            'zuchthuendin',
            'deckruede',
            'zuechter',
        ])->select('wuerfe.*', 'rassen.name AS rasse_name', 'rasse_id', 'wuerfe.id')
            ->leftjoin('rassen', 'wuerfe.rasse_id', '=', 'rassen.id')
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                return $query->where('rasse_id', '=', $rasse_id);
            })
            ->when($abgabe_von != null, function ($query) use ($abgabe_von) {
                return $query->whereDate('abgabe_von', '<=', $abgabe_von);
            })
            ->when($abgabe_bis != null, function ($query) use ($abgabe_bis) {
                return $query->whereDate('abgabe_bis', '>=', $abgabe_bis);
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                return $query->whereHas('zwinger', function ($query) use ($plz_ids) {
                    $query->whereIn('postleitzahl', $plz_ids);
                });
            })
            ->limit(100)->groupBy('id')->orderBy('deckdatum', 'desc')->get();

        return [
            'wuerfe' => $wuerfe,
            'anzahl_wuerfe' => count($wuerfe),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function auto(Request $request)
    {
        $wuerfe = Wurf::where('name', 'like', $request->suche . '%')->orWhere('name', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('name', 'desc')->get();

        return OptionResource::collection($wuerfe);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wurf_update(UpdateWurfRequest $request, Wurf $wurf)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        //  return true;

        $validated = $request->validated();

        $update = $request->all();

        if (1) {

            $wurf->name = $update['name'];

            $wurf->save();

            return $wurf;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function wuerfe_update(Request $request)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        $ids = [];

        foreach ($request->all() as $update) {
            //      // $validated = $request->validated();
            //      if (1) {

            $wurf = Wurf::find($update['id']);
            $wurf->name = $update['name'];

            if ($wurf->save()) {
                $ids[] = $wurf->id;
            }
        }
        //  }

        return $ids;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wurf $wurf)
    {
        //
    }
}
