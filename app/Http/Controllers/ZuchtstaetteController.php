<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZuchtstaetteAnlegenRequest;
use App\Http\Resources\OptionResource;
use App\Http\Resources\ZuchtstaetteResource;
use App\Models\Bestaetigung;
use App\Models\Zuchtstaette;
use App\Models\Zuchtstaettenbesichtigung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ZuchtstaetteController extends Controller
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

        $zuchtstaetten = Zuchtstaette::where(function ($query) use ($columns) {
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

        return ZuchtstaetteResource::collection($zuchtstaetten);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zuchtstaette  $zuchtstaette
     * @return \Illuminate\Http\Response
     */
    public function show(Zuchtstaette $id)
    {

        return ZuchtstaetteResource::collection(Zuchtstaette::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {
        return Zuchtstaette::where('name', 'like', $request->suche . '%')->orWhere('name', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('name', 'desc')->pluck('name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function auto(Request $request)
    {
        $hunde = Zuchtstaette::where('name', 'like', $request->suche . '%')->orWhere('name', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('name', 'desc')->get();

        return OptionResource::collection($hunde);
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zuchtstaette $zuchtstaette)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtstaette $zuchtstaette)
    {
        //
    }

    /**
     * Neue Zuchtstätte anlegen
     *
     * Prüft ob die Zuchtstätte bereits existiert und legt sie ggf. an.
     * Optional kann auch eine Zuchtstättenbesichtigung mit angelegt werden.
     */
    public function anlegen(StoreZuchtstaetteAnlegenRequest $request)
    {
        $validated = $request->validated();

        try {
            $result = DB::transaction(function () use ($validated) {
                $zuchtstaetteData = $validated['zuchtstaette'];

                // Prüfen ob Zuchtstätte bereits existiert (Strasse, PLZ, Ort)
                $existingZuchtstaette = Zuchtstaette::where('strasse', $zuchtstaetteData['strasse'])
                    ->where('postleitzahl', $zuchtstaetteData['postleitzahl'])
                    ->where('ort', $zuchtstaetteData['ort'])
                    ->first();

                if ($existingZuchtstaette) {
                    throw new \Exception('Eine Zuchtstätte mit dieser Adresse existiert bereits.');
                }

                // Neue Zuchtstätte anlegen
                $zuchtstaette = Zuchtstaette::create([
                    'strasse' => $zuchtstaetteData['strasse'],
                    'adresszusatz' => $zuchtstaetteData['adresszusatz'] ?? null,
                    'postleitzahl' => $zuchtstaetteData['postleitzahl'],
                    'ort' => $zuchtstaetteData['ort'],
                    'land' => $zuchtstaetteData['land'],
                    'laenderkuerzel' => $zuchtstaetteData['laenderkuerzel'] ?? 'DE',
                    'status_id' => $zuchtstaetteData['status_id'],
                    'anleger_id' => $zuchtstaetteData['anleger_id'],
                    'zwinger_id' => $zuchtstaetteData['zwinger_id'] ?? null,
                    'aktiv' => false, // Wird erst nach Freigabe aktiviert
                    'standard' => false,
                ]);

                $zuchtstaettenbesichtigungId = null;

                // Wenn Zuchtstättenbesichtigung-Daten vorhanden sind
                if (isset($validated['zuchtstaettenbesichtigung'])) {
                    $besichtigungData = $validated['zuchtstaettenbesichtigung'];

                    $zuchtstaettenbesichtigung = Zuchtstaettenbesichtigung::create([
                        'status_id' => $besichtigungData['status_id'],
                        'grund_id' => $besichtigungData['grund_id'],
                        'antragsteller_id' => $besichtigungData['antragsteller_id'],
                        'zuchtwart_id' => $besichtigungData['zuchtwart_id'],
                        'zuchtstaette_id' => $zuchtstaette->id,
                        'termin_am' => $besichtigungData['termin_am'],
                        'bestaetigung_angaben' => $besichtigungData['bestaetigung_angaben'],
                        'aktivierung_automatisch' => $besichtigungData['aktivierung_automatisch'] ?? false,
                        'aktivierung_am' => $besichtigungData['aktivierung_am'] ?? null,
                        'freigabe_zw' => false,
                        'freigabe_gs' => false,
                        'bestaetigungen_komplett' => $besichtigungData['bestaetigung_angaben'],
                    ]);

                    $zuchtstaettenbesichtigungId = $zuchtstaettenbesichtigung->id;
                }

                // Bestätigungen für Miteigentümer anlegen
                if (! empty($validated['miteigentuemer_ids'])) {
                    foreach ($validated['miteigentuemer_ids'] as $miteigentuemerId) {
                        Bestaetigung::create([
                            'bestaetigungable_type' => Zuchtstaette::class,
                            'bestaetigungable_id' => $zuchtstaette->id,
                            'person_id' => $miteigentuemerId,
                            'bestaetigt' => false,
                            'abgelehnt' => false,
                        ]);
                    }
                }

                return [
                    'zuchtstaette_id' => $zuchtstaette->id,
                    'zuchtstaettenbesichtigung_id' => $zuchtstaettenbesichtigungId,
                ];
            });

            return response()->json([
                'success' => 'Die Zuchtstätte wurde erfolgreich angelegt.',
                'error' => null,
                'data' => $result,
            ], 201);

        } catch (\Exception $exception) {
            if ($exception->getMessage() === 'Eine Zuchtstätte mit dieser Adresse existiert bereits.') {
                return response()->json([
                    'success' => null,
                    'error' => $exception->getMessage(),
                ], 409); // Conflict
            }

            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Zuchtstätte konnte nicht angelegt werden.',
            ], 500);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Zuchtstätte konnte nicht angelegt werden.',
            ], 500);
        }
    }
}
