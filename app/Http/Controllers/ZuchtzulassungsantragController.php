<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZuchtzulassungsantragRequest;
use App\Http\Requests\UpdateZuchtzulassungsantragRequest;
use App\Http\Resources\OptionNameResource;
use App\Models\Gebuehr;
use App\Models\Link;
use App\Models\Person;
use App\Models\Zuchtzulassungsantrag;
use App\Traits\ApiResponses;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;

class ZuchtzulassungsantragController extends Controller
{
    use ApiResponses;
    use SaveDokumente;

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
     * Display the specified resource.
     *
     * @param  \App\Models\Zuchtzulassungsantrag  $zuchtzulassungsantrag
     * @return \Illuminate\Http\Response
     */
    public function meta(Request $request)
    {

        $id = $request->id;
        $rasse_id = $request->rasse_id;
        $person_id = $request->antragsteller_id;

        $mitglied = Person::find($person_id)->mitglied()->first();

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

        $url = Link::select('url', 'dateigroesse', 'name', 'fassung_vom')
            ->join('linkliste', 'linkliste.id', '=', 'links.linkliste_id')
            ->where('linkliste_id', $zo_link_id)
            ->where('aktiv', 1)
            ->whereDate('fassung_vom', '<=', date('Y-m-d'))
            ->orderBy('fassung_vom', 'desc')
            ->first();

        $obj_gebuehr = Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
            ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
            ->where('gebuehrenkatalog_id', 18)
            ->where('aktiv', 1)
            ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        $gebuehr = $mitglied ? $obj_gebuehr->kosten_mitglied : $obj_gebuehr->kosten_nichtmitglied;

        return ['link_zo' => $url,
            'gebuehr' => $gebuehr];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zuchtzulassungsantrag  $zuchtzulassungsantrag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $zuchtzulassungsantrag = Zuchtzulassungsantrag::with([
            'eigentuemer', 'antragsteller', 'hund', 'dokumente',
            'eigentuemer.bestaetigungen' => function ($query) use ($id) {
                $query->where('bestaetigungen.bestaetigungable_id', '=', $id)->where('bestaetigungen.bestaetigungable_type', '=', 'App\Models\Zuchtzulassungsantrag');
            },
        ])
            ->where('id', $id)
            ->first();

        return $zuchtzulassungsantrag;

    }

    public function store(StoreZuchtzulassungsantragRequest $request)
    {
        //

        $validated = $request->all();

        // $eigentuemer_ids = $validated['eigentuemer_ids'];

        $zuchtzulassungsantrag = new Zuchtzulassungsantrag();

        if (array_key_exists('hund_id', $validated)) {
            $zuchtzulassungsantrag->hund_id = $validated['hund_id'];
        }
        if (array_key_exists('antragsteller_id', $validated)) {
            $zuchtzulassungsantrag->antragsteller_id = $validated['antragsteller_id'];
        }
        if (array_key_exists('bemerkungen_antragsteller', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_antragsteller = $validated['bemerkungen_antragsteller'];
        }
        if (array_key_exists('bemerkungen_drc', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_drc = $validated['bemerkungen_drc'];
        }
        if (array_key_exists('bemerkungen_intern', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_intern = $validated['bemerkungen_intern'];
        }
        if (array_key_exists('ablehnung_begruendung', $validated)) {
            $zuchtzulassungsantrag->ablehnung_begruendung = $validated['ablehnung_begruendung'];
        }
        if (array_key_exists('link_zo', $validated)) {
            $zuchtzulassungsantrag->link_zo = $validated['link_zo'];
        }
        if (array_key_exists('gebuehr', $validated)) {
            $zuchtzulassungsantrag->gebuehr = $validated['gebuehr'];
        }

        $zuchtzulassungsantrag->bezahlt = 0;
        $zuchtzulassungsantrag->angenommen = 0;
        $zuchtzulassungsantrag->abgelehnt = 0;
        $zuchtzulassungsantrag->status_id = 1;

        if (array_key_exists('senden', $validated) && $validated['senden'] == 1) {
            $zuchtzulassungsantrag->gesendet = 1;
            $zuchtzulassungsantrag->status_id = 2;
            $zuchtzulassungsantrag->sent_at = now();
        }

        $zuchtzulassungsantrag->save();

        // $person_bestaetigung_ids = [];

        // foreach ($eigentuemer_ids as $eigentuemer_id) {
        //    $bestaetigung = new Bestaetigung();
        //    $bestaetigung->person_id = $eigentuemer_id;
        //    $zuchtzulassungsantrag->bestaetigungen()->save($bestaetigung);
        //    $person_bestaetigung_ids[] = ['person_id' => $eigentuemer_id, 'bestaetigung_id' => $bestaetigung->id];
        // }

        $status = new OptionNameResource($zuchtzulassungsantrag->status);

        //return $zuchtzulassungsantrag;
        return ['success' => true, 'antrag_id' => $zuchtzulassungsantrag->id, 'gesendet' => $zuchtzulassungsantrag->gesendet, 'status' => $status, 'sent_at' => $zuchtzulassungsantrag->sent_at];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZuchtzulassungsantragRequest $request, Zuchtzulassungsantrag $zuchtzulassungsantrag)
    {
        $validated = $request->validated();

        // $eigentuemer_ids = $validated['eigentuemer_ids'];

        if (array_key_exists('hund_id', $validated)) {
            $zuchtzulassungsantrag->hund_id = $validated['hund_id'];
        }
        if (array_key_exists('antragsteller_id', $validated)) {
            $zuchtzulassungsantrag->antragsteller_id = $validated['antragsteller_id'];
        }
        if (array_key_exists('bemerkungen_antragsteller', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_antragsteller = $validated['bemerkungen_antragsteller'];
        }
        if (array_key_exists('bemerkungen_drc', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_drc = $validated['bemerkungen_drc'];
        }
        if (array_key_exists('bemerkungen_intern', $validated)) {
            $zuchtzulassungsantrag->bemerkungen_intern = $validated['bemerkungen_intern'];
        }
        if (array_key_exists('ablehnung_begruendung', $validated)) {
            $zuchtzulassungsantrag->ablehnung_begruendung = $validated['ablehnung_begruendung'];
        }
        if (array_key_exists('link_zo', $validated)) {
            $zuchtzulassungsantrag->link_zo = $validated['link_zo'];
        }
        if (array_key_exists('gebuehr', $validated)) {
            $zuchtzulassungsantrag->gebuehr = $validated['gebuehr'];
        }
        if (array_key_exists('senden', $validated) && $validated['senden'] == 1) {
            $zuchtzulassungsantrag->gesendet = 1;
            $zuchtzulassungsantrag->status_id = 2;
            $zuchtzulassungsantrag->sent_at = now();
        } else {
            $zuchtzulassungsantrag->status_id = $validated['status_id'];
        }

        $zuchtzulassungsantrag->save();

        $dokumente = $validated['dokumente'];

        $this->saveDokumente($zuchtzulassungsantrag, $dokumente);

        $zuchtzulassungsantrag->fresh();

        $status = new OptionNameResource($zuchtzulassungsantrag->status);

        return ['success' => true, 'gesendet' => $zuchtzulassungsantrag->gesendet, 'status' => $status, 'sent_at' => $zuchtzulassungsantrag->sent_at];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zuchtzulassungsantrag $zuchtzulassungsantrag)
    {
        //
    }
}
