<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAhnentafelantragRequest;
use App\Http\Requests\UpdateAhnentafelantragRequest;
use App\Models\Ahnentafelantrag;

class AhnentafelantragController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ahnentafelantrag  $ahnentafelantrag
     * @return \Illuminate\Http\Response
     */
    public function meta(Request $request)
    {

        $id = $request->id;
        $rasse_id = $request->rasse_id;
        $person_id = $request->person_id;

        //  $rasse = Hund::find($id)->rasse()->get();

        switch ($rasse_id) {
            case 5: // 'Labrador Retriever'],
                $zo_link_id = 2;
                break;
            case 4: // Golden Retriever'],
                $zo_link_id = 1;
                break;
            case 3: // Flat Coated Retriever'],
                $zo_link_id = 3;
                break;
            case 6: // Nova Scotia Duck Tolling Retriever'],
                $zo_link_id = 6;
                break;
            case 2: // Curly Coated Retriever'],
                $zo_link_id = 5;
                break;
            case 1: // Chesapeake Bay Retriever'],
                $zo_link_id = 4;
                break;
        }

        $gebuehr = Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
            ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
            ->where('gebuehrenkatalog_id', 6)
            ->where('aktiv', 1)
            ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        // $gebuehr = Gebuehr::where('id', 18)->where('aktiv', 1)->first();

        //  query()
        //  ->select('gebuehr.*')
        //  ->join('gebuehrenstaende', 'gebuehrenstaende.typ_id', '=', 'gebuehren.id')
        //  ->orderBy('companies.name')

        return ['gebuehr' => $gebuehr];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAhnentafelantragRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ahnentafelantrag $ahnentafelantrag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAhnentafelantragRequest $request, Ahnentafelantrag $ahnentafelantrag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ahnentafelantrag $ahnentafelantrag)
    {
        //
    }
}
