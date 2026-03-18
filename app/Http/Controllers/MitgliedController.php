<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMitgliedRequest;
use App\Http\Resources\MitgliedResource;
use App\Http\Resources\OptionNachnameResource;
use App\Models\Mitglied;
use App\Models\Person;
use Illuminate\Http\Request;

class MitgliedController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'mitglied_nr');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $mitglieder = Mitglied::with('person', 'status')
            ->leftjoin('personen', 'personen.id', '=', 'mitglieder.person_id')
            ->leftjoin('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')
            ->leftjoin('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')
            ->select('mitglieder.*', 'personen.*', 'personen.id AS person_id', 'mitglieder.id AS id', 'landesgruppen.landesgruppe AS landesgruppe', 'bezirksgruppen.bezirksgruppe AS bezirksgruppe')
            ->where('mitglieder.landesgruppe_id', '>', 0)
            ->where('mitglieder.bezirksgruppe_id', '>', 0)
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
                                $query->where(function ($q) use ($column, $table) {
                                    $q->whereNull($table . $column['db_field'])->orWhere($table . $column['db_field'], '=', '0000-00-00');
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
            })->orderBy($sortField, $sortDirection)
            ->paginate($pagination);

        return MitgliedResource::collection($mitglieder);
    }

    public function prefilter(Request $request, $typ = 0)
    {

        $sortField = $request->input('sort_field', 'mitglied_nr');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        //   $mitglieder = Mitglied::with(['personen', 'landesgruppen', 'bezirksgruppen'])->join('personen', 'personen.mitglied_id', '=', 'mitglieder.id')->join('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')->join('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')->where(function($query) use ($columns) {

        $mitglieder = Mitglied::leftjoin('personen', 'personen.mitglied_id', '=', 'mitglieder.id')
            ->leftjoin('landesgruppen', 'landesgruppen.id', '=', 'mitglieder.landesgruppe_id')
            ->leftjoin('bezirksgruppen', 'bezirksgruppen.id', '=', 'mitglieder.bezirksgruppe_id')
            ->select('mitglieder.*', 'personen.*', 'personen.id AS person_id', 'mitglieder.id AS id', 'landesgruppen.landesgruppe AS landesgruppe', 'bezirksgruppen.bezirksgruppe AS bezirksgruppe')

            ->where(function ($query) use ($columns) {

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
            })->where('mitglied_nr_art', '=', $typ)
            ->when($search != '', function ($query) use ($columns, $search) {
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

        return MitgliedResource::collection($mitglieder);
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
    public function show(Mitglied $mitglied)
    {

        return $mitglied->person;

        return MitgliedResource::collection(Mitglied::find($mitglied));
    }

    public function get(Request $request)
    {

        return MitgliedResource::collection(Mitglied::leftjoin('personen', 'mitglieder.id', '=', 'personen.mitglied_id')->where('mitglied_nr', '=', $request->id)->get());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {
        return Mitglied::where('name', 'like', $request->suche . '%')->orWhere('name', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('name', 'desc')->pluck('name');
    }

    public function auto(Request $request)
    {
        //   $mitglieder = Mitglied::leftjoin('personen', 'mitglieder.person_id', '=', 'personen.id')->where('nachname',  'like', $request->suche.'%')->orWhere('nachname',  'like', '% '.$request->suche.'%')->limit(250)->orderBy('nachname', 'desc')->get();
        //   return OptionNachnameResource::collection( $mitglieder);

    }

    public function autocomplete(Request $request)
    {

        $mitgliedsnummer = trim($request->mitglied_nr);

        if ($request->single) {
            $complete = true;
            $count = 1;
            $personen = Person::select('nachname', 'vorname', 'strasse', 'postleitzahl', 'ort', 'email_1', 'email_2', 'telefon_1', 'telefon_2', 'website_1', 'website_2', 'land', 'personen.id as id', 'mitglieder.id as mitglied_id', 'mitglieder.mitglied_nr as mitgliedsnummer')
                ->leftjoin('mitglieder', 'personen.id', '=', 'mitglieder.person_id')
                ->where('mitglieder.mitglied_nr', '=', $mitgliedsnummer)
                ->get();

        } else {

            $count = Mitglied::where('mitglied_nr', 'LIKE', $mitgliedsnummer . '%')->count();

            // leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')->select('hunde.*', 'farben.name AS farbe', 'rassen.name AS rasse')
            if ($count <= 25) {
                $complete = true;
                $personen = Person::select('nachname', 'vorname', 'strasse', 'postleitzahl', 'ort', 'email_1', 'email_2', 'telefon_1', 'telefon_2', 'website_1', 'website_2', 'land', 'mitglieder.id as mitglied_id', 'personen.id as id', 'mitglieder.mitglied_nr as mitgliedsnummer')
                    ->leftjoin('mitglieder', 'personen.id', '=', 'mitglieder.person_id')
                    ->where('mitglieder.mitglied_nr', 'LIKE', $mitgliedsnummer . '%')
                    ->limit(25)->orderBy('mitglieder.mitglied_nr', 'asc')->get();
            } elseif ($count < 200) {
                $complete = false;
                $personen = Mitglied::where('mitglied_nr', 'LIKE', $mitgliedsnummer . '%')
                    ->limit(200)->orderBy('mitglieder.mitglied_nr', 'asc')->pluck('mitglieder.mitglied_nr');
            } else {
                $personen = [];
                $complete = false;
            }
        }

        return [
            'complete' => $complete,
            'personen' => $count,
            'result' => $personen,
        ];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mitglied  $mitglied
     * @return \Illuminate\Http\Response
     */
    public function mitglied_update(UpdateMitgliedRequest $request)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        //  return true;

        // $validated = $request->validated();

        $update = $request->all();

        $nummer = $update['id'];

        $person = Person::find($nummer);

        return [
            'id' => $nummer,
            'person_find' => $person,
        ];

        $mitglied = $person->mitglied();

        if (1) {

            $mitglied->landesgruppe_id = $update['landesgruppe']['id'];
            $mitglied->bezirksgruppe_id = $update['bezirksgruppe']['id'];
            $mitglied->save();

            $person->vorname = $update['vorname'];
            $person->save();

            return $mitglied;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function mitglieder_update(Request $request)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        $ids = [];

        foreach ($request->all() as $update) {
            //      // $validated = $request->validated();
            //      if (1) {

            $mitglied = Mitglied::find($update['id']);
            $mitglied->landesgruppe_id = $update['landesgruppe']['id'];
            $mitglied->bezirksgruppe_id = $update['bezirksgruppe']['id'];

            if ($mitglied->save()) {
                $ids[] = $mitglied->id;
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
    public function destroy(Mitglied $mitglied)
    {
        //
    }
}
