<?php

namespace App\Http\Controllers;

use App\Http\Resources\OptionNachnameResource;
use App\Http\Resources\OptionNameResource;
use App\Http\Resources\ZuchtwartResource;
use App\Models\Zuchtwart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZuchtwartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'mitglied_nr');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $zuchtwarte = Zuchtwart::leftjoin('personen', 'personen.id', '=', 'zuchtwarte.person_id')
            ->leftjoin('rasse_zuchtwart', 'zuchtwarte.id', '=', 'rasse_zuchtwart.zuchtwart_id')
            ->leftjoin('rassen', 'rasse_zuchtwart.rasse_id', '=', 'rassen.id')
            ->select('personen.*', 'rassen.name AS rasse')
            ->where(function ($query) use ($columns) {

                // $hunde = Hund::with(['farbe','rasse'])->where(function($query) use ($columns) {
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
                                $query->where(function ($q) use ($table, $column) {
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

        return ZuchtwartResource::collection($zuchtwarte);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

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

        // WUERFE   protected $with = ['wuerfe.zuchthuendin', 'wuerfe.deckruede', 'wuerfe.deckrueden', 'wuerfe.zwinger', 'wuerfe.zuechter', 'wuerfe.rasse', 'wuerfe.welpen', 'wuerfe.zuchtwart', 'wuerfe.images'];

        // $zuchtwarte = Zuchtwart::with(['rassen', 'personen'])->select( 'personen.*', 'zuchtwarte.*')

        // $zuchtwarte = Zuchtwart::with([ 'wuerfe', 'person', 'wuerfe.zuchthuendin', 'wuerfe.deckruede', 'wuerfe.deckrueden', 'wuerfe.zwinger', 'wuerfe.zuechter', 'wuerfe.rasse', 'wuerfe.welpen', 'wuerfe.zuchtwart', 'wuerfe.images'])
        //    ->leftjoin('personen',  'personen.id', '=', 'zuchtwarte.person_id')
        //    ->when($vorname != '', function ($query) use ($vorname) {
        //          $query->where('personen.vorname', 'LIKE', '%' . $vorname . '%');
        //    })
        //    ->when($nachname != '', function ($query) use ($nachname) {
        //       $query->where('personen.nachname', 'LIKE', '%' . $nachname . '%');
        //    })
        //    ->when(count($plz_ids), function ($query) use ($plz_ids) {
        //       $query->whereIn('personen.postleitzahl', $plz_ids);
        //    })
        //    ->groupby('personen.id')->get();

        // $count = 0;
        // return [
        //    'ergebnisliste' => $zuchtwarte,
        //    'anzahl' => $count
        // ];

        $zuchtwarte = Zuchtwart::with(['person'])
            ->select('zuchtwarte.*')
            ->leftjoin('personen', 'personen.id', '=', 'zuchtwarte.person_id')
            ->when($vorname != '', function ($query) use ($vorname) {
                $query->where('personen.vorname', 'LIKE', '%' . $vorname . '%');
            })
            ->when($nachname != '', function ($query) use ($nachname) {
                $query->where('personen.nachname', 'LIKE', '%' . $nachname . '%');
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                $query->whereIn('personen.postleitzahl', $plz_ids);
            })
            ->groupby('personen.id')->get();

        $count = 0;

        return [
            'ergebnisliste' => $zuchtwarte,
            'anzahl' => $count,
        ];

        return [
            'ergebnisliste' => ZuchtwartResource::collection($zuchtwarte),
            'anzahl' => $count,
        ];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wuerfe(Zuchtwart $zuchtwart)
    {

        return $zuchtwart->wuerfe;

    }

    /**
     *     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $filters = ($request->filters) ? $request->filters : [];
        $sort = $request->sort ? $request->sort : 'name';

        $zuchtwart = Zuchtwart::where(function ($query) use ($filters) {
            foreach ($filters as $filter) {
                $query->where($filter['db_field'], 'like', '% ' . $filter['filter'] . '%');
            }
        })->limit(250)->orderBy($sort, 'desc')->get();

        return OptionNameResource::collection($zuchtwart);
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
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtwart $zuchtwart)
    {
        return $zuchtwart;
    }

    // add a function showAll() that returns all the zuchtwarte
    public function showAll()
    {
        return Zuchtwart::all();
    }

    public function auto(Request $request)
    {
        $zuchtwart = Zuchtwart::leftjoin('personen', 'zuchtwarte.person_id', '=', 'personen.id')
            ->where('nachname', 'like', $request->suche . '%')
            ->orWhere('nachname', 'like', '% ' . $request->suche . '%')
            ->limit(250)->orderBy('nachname', 'desc')->get();

        return OptionNachnameResource::collection($zuchtwart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtwart $zuchtwart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtwart $zuchtwart)
    {
        //
    }
}
