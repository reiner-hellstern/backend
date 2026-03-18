<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnwartschaftenTypenRequest;
use App\Http\Requests\UpdateAnwartschaftenTypenRequest;
use App\Models\AnwartschaftenTypen;
use Illuminate\Http\Request;

class AnwartschaftenTypenController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnwartschaftenTypenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(AnwartschaftenTypen $anwartschaftenTypen)
    {
        //
    }

    public function autocomplete(Request $request)
    {

        $mitgliedsnummer = trim($request->nr);
        $nachname = trim($request->nn);
        $vorname = trim($request->vn);
        $strasse = trim($request->str);
        $plz = trim($request->plz);
        $ort = trim($request->ort);
        $complete = $request->c;
        $main = $request->m;

        $count = AnwartschaftenTypen::when($nachname != '', function ($query) use ($nachname) {
            return $query->where('nachname', 'LIKE', '' . $nachname . '%');
        })->when($vorname != '', function ($query) use ($vorname) {
            return $query->where('vorname', 'LIKE', '' . $vorname . '%');
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
            $personen = AnwartschaftenTypen::leftjoin('mitglieder', 'mitglieder.id', '=', 'personen.mitglied_id')->select('nachname', 'vorname', 'strasse', 'postleitzahl', 'ort', 'mitglied_id', 'personen.id as id', 'mitglieder.mitglied_nr as mitgliedsnummer')
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
                })
                ->limit(10)->orderBy($main, 'asc')->get();
        } else {

            $count = AnwartschaftenTypen::when($nachname != '', function ($query) use ($nachname) {
                return $query->where('nachname', 'LIKE', '' . $nachname . '%');
            })->when($vorname != '', function ($query) use ($vorname) {
                return $query->where('vorname', 'LIKE', '' . $vorname . '%');
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
                $personen = AnwartschaftenTypen::when($nachname != '', function ($query) use ($nachname) {
                    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                })->when($vorname != '', function ($query) use ($vorname) {
                    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('ort', 'LIKE', '%' . $ort . '%');
                })
                    ->limit(200)->orderBy($main, 'asc')->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')->pluck($main);
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnwartschaftenTypenRequest $request, AnwartschaftenTypen $anwartschaftenTypen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnwartschaftenTypen $anwartschaftenTypen)
    {
        //
    }
}
