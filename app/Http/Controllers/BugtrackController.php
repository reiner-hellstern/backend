<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBugtrackRequest;
use App\Http\Requests\UpdateBugtrackRequest;
use App\Http\Resources\BugtrackTableResource;
use App\Models\Bugtrack;
use App\Models\OptionBugtrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugtrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $bugtracks = Bugtrack::leftjoin('optionen_bugtracks', 'bugtracker.page_id', '=', 'optionen_bugtracks.id')->leftjoin('users', 'users.id', '=', 'bugtracker.page_id')->select('bugtracker.*', 'optionen_bugtracks.name AS pagename', 'users.name AS author')->where(function ($query) use ($columns) {
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

        return BugtrackTableResource::collection($bugtracks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBugtrackRequest $request)
    {
        $id = Auth::id();
        if (! $id) {
            return;
        }

        $bugtrack = new Bugtrack();

        $bugtrack->text = $request['text'];
        $bugtrack->url = $request['url'];
        $bugtrack->user_id = $id;
        $bugtrack->page_id = $request['page_id'];
        $bugtrack->page_name = $request['page_name'];
        $bugtrack->closed = 0;

        $bugtrack->save();

        $bugtrack = Bugtrack::find($bugtrack->id);

        return response()->json([
            'success' => 'Bugtrack gespeichert.',
            'bugtrack' => $bugtrack,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bugtrack  $bugtrack
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request['id'];

        $bugtracks = $id > 0 ? Bugtrack::where('page_id', $id)->get() : Bugtrack::all();
        $offen = $id > 0 ? Bugtrack::where('page_id', $id)->where('closed', 0)->count() : Bugtrack::where('closed', 0)->count();

        return response()->json([
            'offen' => $offen,
            'bugtracks' => $bugtracks,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bugtrack  $bugtrack
     * @return \Illuminate\Http\Response
     */
    public function grouped(Request $request)
    {

        $groups = Bugtrack::where('closed', 0)->groupBy('page_id')->orderBy('page_id')->pluck('page_id');
        $bugtracks = [];

        foreach ($groups as $group) {

            $bugtracks[$group]['bugs'] = Bugtrack::where('page_id', $group)->where('closed', 0)->get();
            $bugtracks[$group]['offen'] = Bugtrack::where('page_id', $group)->where('closed', 0)->count();
            $bugtracks[$group]['name'] = OptionBugtrack::where('id', $group)->first()->name;
            $bugtracks[$group]['id'] = $group;
        }

        return response()->json([
            'offen' => Bugtrack::where('closed', 0)->count(),
            'erledigt' => Bugtrack::where('closed', 1)->count(),
            'bugtrackgroups' => $bugtracks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBugtrackRequest $request, Bugtrack $bugtrack)
    {

        $bugtrack->text = $request->text;
        $bugtrack->url = $request->url;
        $bugtrack->page_id = $request->page_id;
        $bugtrack->page_name = $request->page_name;
        $bugtrack->closed = $request->closed;
        $bugtrack->save();

        $bugtrack = Bugtrack::find($bugtrack->id);

        return response()->json([
            'success' => 'Bugtrack updated.',
            'bugtrack' => $bugtrack,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bugtrack $bugtrack)
    {
        $bugtrack->delete();

        return response()->json([
            'success' => 'Bugtrack gelöscht.',
            'id' => $bugtrack->id,
        ]);

    }
}
