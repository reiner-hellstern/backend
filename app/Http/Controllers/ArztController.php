<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArztResource;
use App\Models\Arzt;
use App\Models\Fachgebiet;
use Illuminate\Http\Request;

class ArztController extends Controller
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

        $aerzte = Arzt::where(function ($query) use ($columns) {
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

        return ArztResource::collection($aerzte);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fachgebiete = Fachgebiet::where('aktiv', true)->orderBy('name')->get();

        return response()->json(['fachgebiete' => $fachgebiete]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeNew(Request $request)
    {
        $validated = $request->validate([
            'praxisname' => 'nullable|string|max:255',
            'titel' => 'nullable|string|max:100',
            'vorname' => 'required|string|max:255',
            'nachname' => 'required|string|max:255',
            'strasse' => 'nullable|string|max:255',
            'adresszusatz' => 'nullable|string|max:255',
            'postleitzahl' => 'nullable|string|max:20',
            'ort' => 'nullable|string|max:255',
            'land' => 'nullable|string|max:255',
            'land_kuerzel' => 'nullable|string|max:10',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'website_1' => 'nullable|string|max:255',
            'website_2' => 'nullable|string|max:255',
            'telefon_1' => 'nullable|string|max:50',
            'telefon_2' => 'nullable|string|max:50',
            'anmerkungen' => 'nullable|string',
            'aktiv' => 'boolean',
            'autocomplete' => 'boolean',
            'fachgebiete' => 'array',
            'fachgebiete.*' => 'exists:fachgebiete,id',
            'gutachter_fachgebiete' => 'array',
            'gutachter_fachgebiete.*' => 'exists:fachgebiete,id',
            'obergutachter_fachgebiete' => 'array',
            'obergutachter_fachgebiete.*' => 'exists:fachgebiete,id',
        ]);

        $arzt = Arzt::create($validated);

        // Attach fachgebiete with pivot data
        if (isset($validated['fachgebiete'])) {
            foreach ($validated['fachgebiete'] as $fachgebietId) {
                $pivotData = [
                    'gutachter' => in_array($fachgebietId, $validated['gutachter_fachgebiete'] ?? []),
                    'obergutachter' => in_array($fachgebietId, $validated['obergutachter_fachgebiete'] ?? []),
                ];

                $arzt->fachgebiete()->attach($fachgebietId, $pivotData);
            }
        }

        $arzt->load('fachgebiete');

        return response()->json($arzt, 201);
    }

    /**
     * Get all fachgebiete.
     */
    public function getFachgebiete()
    {
        $fachgebiete = Fachgebiet::where('aktiv', true)->orderBy('name')->get();

        return response()->json($fachgebiete);
    }

    /**
     * Get aerzte for overview page with pagination and search.
     */
    public function getAerzte(Request $request)
    {
        $search = $request->input('search', '');
        $fachgebieteFilter = $request->input('fachgebiete_filter', []);
        $sortField = $request->input('sort_field', 'nachname');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);

        $query = Arzt::with('fachgebiete');

        // Search functionality
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('vorname', 'LIKE', '%' . $search . '%')
                    ->orWhere('nachname', 'LIKE', '%' . $search . '%')
                    ->orWhere('praxisname', 'LIKE', '%' . $search . '%')
                    ->orWhere('email_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('email_2', 'LIKE', '%' . $search . '%');
            });
        }

        // Fachgebiete filter
        if (! empty($fachgebieteFilter)) {
            // Ensure it's an array
            if (is_string($fachgebieteFilter)) {
                $fachgebieteFilter = explode(',', $fachgebieteFilter);
            }
            $fachgebieteFilter = array_filter($fachgebieteFilter); // Remove empty values

            if (! empty($fachgebieteFilter)) {
                $query->whereHas('fachgebiete', function ($q) use ($fachgebieteFilter) {
                    $q->whereIn('fachgebiet_id', $fachgebieteFilter);
                });
            }
        }

        // Sorting
        $query->orderBy($sortField, $sortDirection);

        // Pagination

        $aerzte = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $aerzte->items(),
            'meta' => [
                'current_page' => $aerzte->currentPage(),
                'last_page' => $aerzte->lastPage(),
                'per_page' => $aerzte->perPage(),
                'total' => $aerzte->total(),
                'from' => $aerzte->firstItem(),
                'to' => $aerzte->lastItem(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArztRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'praxisname' => 'required|string|max:255',
            'titel' => 'nullable|string|max:100',
            'vorname' => 'nullable|string|max:255',
            'nachname' => 'nullable|string|max:255',
            'strasse' => 'nullable|string|max:255',
            'adresszusatz' => 'nullable|string|max:255',
            'postleitzahl' => 'nullable|string|max:20',
            'ort' => 'nullable|string|max:255',
            'land' => 'nullable|string|max:255',
            'land_kuerzel' => 'nullable|string|max:10',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'website_1' => 'nullable|string|max:255',
            'website_2' => 'nullable|string|max:255',
            'telefon_1' => 'nullable|string|max:50',
            'telefon_2' => 'nullable|string|max:50',
            'anmerkungen' => 'nullable|string',
            'aktiv' => 'boolean',
            'autocomplete' => 'boolean',
            'fachgebiete' => 'array',
            'fachgebiete.*' => 'exists:fachgebiete,id',
            'gutachter_fachgebiete' => 'array',
            'gutachter_fachgebiete.*' => 'exists:fachgebiete,id',
            'obergutachter_fachgebiete' => 'array',
            'obergutachter_fachgebiete.*' => 'exists:fachgebiete,id',
        ]);

        $arzt = Arzt::create($validated);

        // Attach fachgebiete with pivot data
        if (isset($validated['fachgebiete'])) {
            foreach ($validated['fachgebiete'] as $fachgebietId) {
                $pivotData = [
                    'gutachter' => in_array($fachgebietId, $validated['gutachter_fachgebiete'] ?? []),
                    'obergutachter' => in_array($fachgebietId, $validated['obergutachter_fachgebiete'] ?? []),
                ];

                $arzt->fachgebiete()->attach($fachgebietId, $pivotData);
            }
        }

        $arzt->load('fachgebiete');

        return response()->json($arzt, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Arzt $arzt)
    {
        $arzt->load('fachgebiete');

        return response()->json($arzt);
    }

    public function autocomplete(Request $request)
    {

        $praxisname = trim($request->pn);
        $nachname = trim($request->nn);
        $vorname = trim($request->vn);
        $strasse = trim($request->str);
        $plz = trim($request->plz);
        $ort = trim($request->ort);
        $complete = $request->c;
        $main = $request->m;

        $count = Arzt::when($nachname != '', function ($query) use ($nachname) {
            return $query->where('nachname', 'LIKE', '' . $nachname . '%');
        })->when($vorname != '', function ($query) use ($vorname) {
            return $query->where('vorname', 'LIKE', '' . $vorname . '%');
        })->when($strasse != '', function ($query) use ($strasse) {
            return $query->where('strasse', 'LIKE', '%' . $strasse . '%');
        })->when($plz != '', function ($query) use ($plz) {
            return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
        })->when($ort != '', function ($query) use ($ort) {
            return $query->where('ort', 'LIKE', '%' . $ort . '%');
        })->when($praxisname != '', function ($query) use ($praxisname) {
            return $query->where('praxisname', 'LIKE', '%' . $praxisname . '%');
        })
            ->count();

        if ($count <= 10) {
            $complete = true;
            $aerzte = Arzt::select('id', 'titel', 'praxisname', 'nachname', 'vorname', 'strasse', 'postleitzahl', 'ort')
                ->when($nachname != '', function ($query) use ($nachname) {
                    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                })->when($vorname != '', function ($query) use ($vorname) {
                    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })->when($praxisname != '', function ($query) use ($praxisname) {
                    return $query->where('praxisname', 'LIKE', '%' . $praxisname . '%');
                })
                ->limit(10)->orderBy($main, 'asc')->get();
        } else {

            $count = Arzt::when($nachname != '', function ($query) use ($nachname) {
                return $query->where('nachname', 'LIKE', '' . $nachname . '%');
            })->when($vorname != '', function ($query) use ($vorname) {
                return $query->where('vorname', 'LIKE', '' . $vorname . '%');
            })->when($strasse != '', function ($query) use ($strasse) {
                return $query->where('strasse', 'LIKE', '' . $strasse . '%');
            })->when($plz != '', function ($query) use ($plz) {
                return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
            })->when($ort != '', function ($query) use ($ort) {
                return $query->where('ort', 'LIKE', '%' . $ort . '%');
            })->when($praxisname != '', function ($query) use ($praxisname) {
                return $query->where('praxisname', 'LIKE', '%' . $praxisname . '%');
            })->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')
                ->count();

            if ($count < 200) {
                $complete = false;
                $aerzte = Arzt::when($nachname != '', function ($query) use ($nachname) {
                    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                })->when($vorname != '', function ($query) use ($vorname) {
                    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })->when($praxisname != '', function ($query) use ($praxisname) {
                    return $query->where('praxisname', 'LIKE', '%' . $praxisname . '%');
                })
                    ->limit(200)->orderBy($main, 'asc')->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')->pluck($main);
            } else {
                $aerzte = [];
                $complete = false;
            }
        }

        return [
            'complete' => $complete,
            'aerzte' => $count,
            'result' => $aerzte,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArztRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arzt $arzt)
    {
        $validated = $request->validate([
            'praxisname' => 'required|string|max:255',
            'titel' => 'nullable|string|max:100',
            'vorname' => 'nullable|string|max:255',
            'nachname' => 'nullable|string|max:255',
            'strasse' => 'nullable|string|max:255',
            'adresszusatz' => 'nullable|string|max:255',
            'postleitzahl' => 'nullable|string|max:20',
            'ort' => 'nullable|string|max:255',
            'land' => 'nullable|string|max:255',
            'land_kuerzel' => 'nullable|string|max:10',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'website_1' => 'nullable|string|max:255',
            'website_2' => 'nullable|string|max:255',
            'telefon_1' => 'nullable|string|max:50',
            'telefon_2' => 'nullable|string|max:50',
            'anmerkungen' => 'nullable|string',
            'aktiv' => 'nullable|boolean',
            'autocomplete' => 'nullable|boolean',
            'fachgebiete' => 'nullable|array',
            'fachgebiete.*' => 'exists:fachgebiete,id',
            'gutachter_fachgebiete' => 'nullable|array',
            'gutachter_fachgebiete.*' => 'exists:fachgebiete,id',
            'obergutachter_fachgebiete' => 'nullable|array',
            'obergutachter_fachgebiete.*' => 'exists:fachgebiete,id',
        ]);

        $arzt->update($validated);

        // Update fachgebiete relationship with pivot data
        if (isset($validated['fachgebiete'])) {
            $syncData = [];
            foreach ($validated['fachgebiete'] as $fachgebietId) {
                $syncData[$fachgebietId] = [
                    'gutachter' => in_array($fachgebietId, $validated['gutachter_fachgebiete'] ?? []),
                    'obergutachter' => in_array($fachgebietId, $validated['obergutachter_fachgebiete'] ?? []),
                ];
            }
            $arzt->fachgebiete()->sync($syncData);
        }

        $arzt->load('fachgebiete');

        return response()->json($arzt);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arzt $arzt)
    {
        //
    }
}
