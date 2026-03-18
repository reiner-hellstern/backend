<?php

namespace App\Http\Controllers;

use App\Http\Resources\AhnenResource;
use App\Models\Hund;
use App\Traits\GetPrerenderedHund;
use Illuminate\Http\Request;

class StammbaumController extends Controller
{
    use GetPrerenderedHund;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eltern(Hund $hund)
    {

        //  return new AhnenResource( new Hund, 0, 4);
        return new AhnenResource($hund, 1, 5);
    }

    public function single(Hund $hund)
    {

        //  return new AhnenResource( new Hund, 0, 4);
        return new AhnenResource($hund, 0, 5);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nachkommen(Hund $hund)
    {
        $output = [];

        // $output['prerendered'] = $this->getPrerenderedHund($hund->id);
        $output['hund'] = $hund;
        // $output['prerendered']['geschlecht_id'] = $hund->geschlecht_id;
        $output['wuerfe'] = $hund->geschlecht_id == 2 ? $hund->wuerfe_r : $hund->wuerfe_h;

        return $output;
    }

    public function prerender($id)
    {

        $hund = Hund::find($id);

        return $hund;

        $hund = Hund::with([
            'formwert', 'wesenstest', 'pruefungentitel', 'titeltitel', 'gentests_total', 'goniountersuchung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'zuchtbuchnummer', 'hunde.id')
            ->where('hunde.id', '=', $id)
            ->get();

        return $hund;
    }
}
