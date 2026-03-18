<?php

namespace App\Http\Controllers;

use App\Http\Resources\SonderleiterResource;
use App\Models\Sonderleiter;
use Illuminate\Http\Request;

class SonderleiterController extends Controller
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

        $sonderleiter = Sonderleiter::leftjoin('personen', 'personen.id', '=', 'sonderleiter.person_id')
            ->leftjoin('mitglieder', 'personen.mitglied_id', '=', 'mitglieder.id')
            ->leftjoin('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')
            ->leftjoin('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')
            ->where(function ($query) use ($columns) {
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
                                $query->where(function ($q) use ($column) {
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

        return SonderleiterResource::collection($sonderleiter);
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
     * @param  \App\Models\Zuchtwart  $zuchtwart
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtwart $zuchtwart)
    {
        return $zuchtwart;
    }

    public function auto(Request $request)
    {
        $zuchtwart = Zuchtwart::leftjoin('personen', 'zuchtwarte.person_id', '=', 'personen.id')->where('nachname', 'like', $request->suche . '%')->orWhere('nachname', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('nachname', 'desc')->get();

        return OptionNachnameResource::collection($zuchtwart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Zuchtwart  $zuchtwart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtwart $zuchtwart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zuchtwart  $zuchtwart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtwart $zuchtwart)
    {
        //
    }
}
