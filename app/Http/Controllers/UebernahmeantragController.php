<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUebernahmeantragRequest;
use App\Http\Requests\UpdateUebernahmeantragRequest;
use App\Http\Resources\OptionNameResource;
use App\Mail\ZustimmungAnfordern;
use App\Models\Bestaetigung;
use App\Models\Gebuehr;
use App\Models\Hund;
use App\Models\Link;
use App\Models\Person;
use App\Models\Uebernahmeantrag;
use App\Traits\ApiResponses;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UebernahmeantragController extends Controller
{
    use ApiResponses;
    use SaveDokumente;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function meta(Request $request)
    {

        //  $id = $request->id;
        $rasse_id = $request->rasse_id;
        $person_id = $request->antragsteller_id;

        // $mitglied = Person::find($person_id)->mitglied()->first();

        // switch ($rasse_id) {
        //    case 1: // 'Labrador Retriever'],
        //       $zo_link_id = 1;
        //       break;
        //    case 2: // Golden Retriever'],
        //       $zo_link_id = 2;
        //       break;
        //    case 3: // Flat Coated Retriever'],
        //       $zo_link_id = 3;
        //       break;
        //    case 4: // Nova Scotia Duck Tolling Retriever'],
        //       $zo_link_id = 4;
        //       break;
        //    case 5: // Curly Coated Retriever'],
        //       $zo_link_id = 5;
        //       break;
        //    case 6: // Chesapeake Bay Retriever'],
        //       $zo_link_id = 6;
        //       break;
        //    }

        //    $url = Link::select('url', 'dateigroesse')->where('id', $zo_link_id)->first();

        //    $obj_gebuehr =  Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
        //    ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
        //    ->where('gebuehrenkatalog_id', 6)
        //    ->where('aktiv', 1)
        //    ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
        //    ->orderBy('gueltig_ab','desc')
        //    ->first();

        //    $gebuehr = $mitglied ? $obj_gebuehr->kosten_mitglied : $obj_gebuehr->kosten_nichtmitglied;

        // TODO _ neue Links und Gebühren
        $url = '';
        $gebuehr = 0;

        return ['link_zo' => $url,
            'gebuehr' => $gebuehr];

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $uebernahmeantrag = Uebernahmeantrag::with([
            'eigentuemer', 'antragsteller', 'hund', 'dokumente',
            'eigentuemer.bestaetigungen' => function ($query) use ($id) {
                $query->where('bestaetigungen.bestaetigungable_id', '=', $id)->where('bestaetigungen.bestaetigungable_type', '=', 'App\Models\Uebernahmeantrag');
            },
        ])->where('id', $id)
            ->first();

        return $uebernahmeantrag;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendmailbestaetigung(Request $request)
    {
        //

        $uid = $request->uid;
        $uebernahmeantrag = Uebernahmeantrag::find($request->uid);
        $bestaetigung = Bestaetigung::find($request->bid);

        $hund = Hund::find($uebernahmeantrag->hund_id);
        $antragsteller = Person::find($uebernahmeantrag->antragsteller_id);
        $empfaenger = Person::find($request->eid);

        $data = [
            'confirm' => 'http://localhost:8000/api/bestaetigung/confirm/' . $bestaetigung->uuid,
            'reject' => 'http://localhost:8000/api/bestaetigung/reject/' . $bestaetigung->uuid,
            'titel' => 'Antrag auf Zuchtbuchübernahme',
            'text' => 'Es wurde ein Antrag zur Zuchtbuchübernahme gestellt. Als Miteigentümer benötigen wir von Ihnen eine Zustimmung. Bitte bestätigen Sie die Übernahme des Hundes.',
            'hund' => $hund,
            'antragsteller' => $antragsteller,
            'empfaenger' => $empfaenger,
        ];

        $email = 'goemmel@bloomproject.de';

        Mail::to($email)->send(new ZustimmungAnfordern($data));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUebernahmeantragRequest $request)
    {
        //

        $validated = $request->validated();

        $uebernahmeantrag = new Uebernahmeantrag();

        if (array_key_exists('hund_id', $validated)) {
            $uebernahmeantrag->hund_id = $validated['hund_id'];
        }
        if (array_key_exists('antragsteller_id', $validated)) {
            $uebernahmeantrag->antragsteller_id = $validated['antragsteller_id'];
        }
        if (array_key_exists('bemerkungen_antragsteller', $validated)) {
            $uebernahmeantrag->bemerkungen_antragsteller = $validated['bemerkungen_antragsteller'];
        }
        if (array_key_exists('at_versendet_am', $validated)) {
            $uebernahmeantrag->at_versendet_am = $validated['at_versendet_am'];
        }

        $uebernahmeantrag->bezahlt = 0;
        $uebernahmeantrag->angenommen = 0;
        $uebernahmeantrag->abgelehnt = 0;
        $uebernahmeantrag->status_id = 1;

        $uebernahmeantrag->save();

        $eigentuemer_ids = $validated['eigentuemer_ids'];
        $eigentuemers = [];

        foreach ($eigentuemer_ids as $eigentuemer_id) {
            $bestaetigung = new Bestaetigung();
            $bestaetigung->person_id = $eigentuemer_id;
            $uebernahmeantrag->bestaetigungen()->save($bestaetigung);

            $bestaetigung->fresh();
            $eigentuemers[] = ['id' => $eigentuemer_id, 'bestaetigung_id' => $bestaetigung->id];

            $hund = Hund::find($uebernahmeantrag->hund_id);
            $antragsteller = Person::find($uebernahmeantrag->antragsteller_id);
            $empfaenger = Person::find($eigentuemer_id);

            $data = [
                'confirm' => 'http://localhost:8000/api/bestaetigung/confirm/' . $bestaetigung->uuid,
                'reject' => 'http://localhost:8000/api/bestaetigung/reject/' . $bestaetigung->uuid,
                'titel' => 'Antrag auf Zuchtbuchübernahme',
                'text' => 'Es wurde ein Antrag zur Zuchtbuchübernahme gestellt. Als Miteigentümer benötigen wir von Ihnen eine Zustimmung. Bitte bestätigen Sie die Übernahme des Hundes.',
                'hund' => $hund,
                'antragsteller' => $antragsteller,
                'empfaenger' => $empfaenger,
            ];

            // TODO - change email
            $email = 'goemmel@bloomproject.de';

            Mail::to($email)->send(new ZustimmungAnfordern($data));

        }

        $status = new OptionNameResource($uebernahmeantrag->status);

        return response()->json(['success' => 'success', 'antrag_id' => $uebernahmeantrag->id, 'status' => $status, 'eigentuemer' => $eigentuemers], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUebernahmeantragRequest $request, Uebernahmeantrag $uebernahmeantrag)
    {
        $validated = $request->validated();

        $eigentuemers = $validated['eigentuemer'];

        // $eigentuemer_ids = $validated['eigentuemer_ids'];

        if (array_key_exists('hund_id', $validated)) {
            $uebernahmeantrag->hund_id = $validated['hund_id'];
        }
        if (array_key_exists('antragsteller_id', $validated)) {
            $uebernahmeantrag->antragsteller_id = $validated['antragsteller_id'];
        }
        if (array_key_exists('bemerkungen_antragsteller', $validated)) {
            $uebernahmeantrag->bemerkungen_antragsteller = $validated['bemerkungen_antragsteller'];
        }
        if (array_key_exists('bemerkungen_drc', $validated)) {
            $uebernahmeantrag->bemerkungen_drc = $validated['bemerkungen_drc'];
        }
        if (array_key_exists('bemerkungen_intern', $validated)) {
            $uebernahmeantrag->bemerkungen_intern = $validated['bemerkungen_intern'];
        }
        if (array_key_exists('ablehnung_begruendung', $validated)) {
            $uebernahmeantrag->ablehnung_begruendung = $validated['ablehnung_begruendung'];
        }

        $uebernahmeantrag->save();

        $dokumente = $validated['dokumente'];
        $this->saveDokumente($uebernahmeantrag, $dokumente);

        foreach ($eigentuemers as $eigentuemer) {
            $bestaetigung = Bestaetigung::find($eigentuemer['bestaetigung_id']);
            $this->saveDokumente($bestaetigung, $eigentuemer['bestaetigungen']['dokumente']);
        }

        // SENDEN
        if (array_key_exists('senden', $validated) && $validated['senden'] == 1) {

            $uebernahmeantrag->gesendet = 1;
            $uebernahmeantrag->status_id = 2;
            $uebernahmeantrag->sent_at = now();

        } else {
            $uebernahmeantrag->status_id = $validated['status_id'];
        }

        $uebernahmeantrag->fresh();

        $status = new OptionNameResource($uebernahmeantrag->status);

        return ['success' => true, 'gesendet' => $uebernahmeantrag->gesendet, 'status' => $status, 'sent_at' => $uebernahmeantrag->sent_at, 'eigentuemer' => $eigentuemers];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Uebernahmeantrag $uebernahmeantrag)
    {
        //
    }
}
