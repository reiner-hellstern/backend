<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbstammungsnachweisRequest;
use App\Http\Requests\UpdateAbstammungsnachweisRequest;
use App\Models\Abstammungsnachweis;
use App\Traits\SaveArzt;
use App\Traits\SaveLabor;

class AbstammungsnachweisController extends Controller
{
    use SaveArzt;
    use SaveLabor;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbstammungsnachweisRequest $request)
    {
        $abstammungsnachweis = new Abstammungsnachweis();

        $abstammungsnachweis->hund_id = $request->hund_id;
        $abstammungsnachweis->anmerkungen = $request->anmerkungen;
        $abstammungsnachweis->abstammungsnachweis = $request->abstammungsnachweis;
        $abstammungsnachweis->bestaetigt = $request->bestaetigt;
        $abstammungsnachweis->datum_feststellung = $request->datum_feststellung;
        $abstammungsnachweis->datum_blutentnahme = $request->datum_blutentnahme;
        $abstammungsnachweis->labornummer = $request->labornummer;

        $abstammungsnachweis->arzt_id = $this->saveArzt($request->arzt);
        $abstammungsnachweis->labor_id = $this->saveLabor($request->labor);

        $abstammungsnachweis->save();

        return ['message' => 'success', 'abstammungsnachweis' => $abstammungsnachweis];
    }

    /**
     * Display the specified resource.
     */
    public function show(Abstammungsnachweis $abstammungsnachweis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbstammungsnachweisRequest $request, Abstammungsnachweis $abstammungsnachweis)
    {
        $abstammungsnachweis->hund_id = $request->hund_id;
        $abstammungsnachweis->anmerkungen = $request->anmerkungen;
        $abstammungsnachweis->abstammungsnachweis = $request->abstammungsnachweis;
        $abstammungsnachweis->bestaetigt = $request->bestaetigt;
        $abstammungsnachweis->datum_feststellung = $request->datum_feststellung;
        $abstammungsnachweis->datum_blutentnahme = $request->datum_blutentnahme;
        $abstammungsnachweis->labornummer = $request->labornummer;

        $abstammungsnachweis->arzt_id = $this->saveArzt($request->arzt);
        $abstammungsnachweis->labor_id = $this->saveLabor($request->labor);

        $abstammungsnachweis->save();

        return ['message' => 'success', 'abstammungsnachweis' => $abstammungsnachweis];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abstammungsnachweis $abstammungsnachweis)
    {
        //
    }
}
