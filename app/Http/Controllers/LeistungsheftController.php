<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeistungsheftRequest;
use App\Http\Requests\UpdateLeistungsheftRequest;
use App\Http\Resources\OptionNameResource;
use App\Models\Gebuehr;
use App\Models\Leistungsheft;
use Illuminate\Http\Request;

class LeistungsheftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index_hund()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leistungsheft  $leistungsheft
     * @return \Illuminate\Http\Response
     */
    public function meta(Request $request)
    {

        $gebuehr_drc = Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
            ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
            ->where('gebuehrenkatalog_id', 7)
            ->where('aktiv', 1)
            ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        $gebuehr_kein_drc = Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
            ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
            ->where('gebuehrenkatalog_id', 8)
            ->where('aktiv', 1)
            ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        $gebuehr_drc_unvollstaendig = Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
            ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
            ->where('gebuehrenkatalog_id', 21)
            ->where('aktiv', 1)
            ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
            ->orderBy('gueltig_ab', 'desc')
            ->first();

        return ['drc' => $gebuehr_drc, 'nondrc' => $gebuehr_kein_drc, 'unvollstaendig' => $gebuehr_drc_unvollstaendig];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendmail(Request $request)
    {
        //

        $leistungsheft = Leistungsheft::find($request->id);
        $besteller = Person::find($leistungsheft->besteller_id);
        $hund = Hund::find($leistungsheft->hund_id);
        $text = $request->text;

        $data = [
            'titel' => 'Bestellung eines Leistungsheftes',
            'text' => $text,
            'besteller' => $besteller,
        ];
        $email = $besteller->email1;
        $email = 'goemmel@bloomproject.de';

        Mail::to($email)->send(new LeistungsheftBestellungRueckfrage($data));
        //  Mail::to($email)->send(new LeistungsheftBestellungRechungung($data));
        //  Mail::to($email)->send(new LeistungsheftBestellungInformation($data));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeistungsheftRequest $request)
    {
        $validated = $request->validated();

        $leistungsheft = new Leistungsheft();

        $leistungsheft->hund_id = $validated['leistungsheft']['hund_id'];
        $leistungsheft->besteller_id = $validated['leistungsheft']['besteller_id'];
        $leistungsheft->anmerkungen_besteller = $validated['leistungsheft']['anmerkungen_besteller'];
        $leistungsheft->at_versendet_am = $validated['leistungsheft']['at_versendet_am'];

        $leistungsheft->bezahlt = 0;
        $leistungsheft->status_id = 1;

        $leistungsheft->save();

        $status = new OptionNameResource($leistungsheft->status);

        return response()->json(['success' => 'success', 'leistungsheft_id' => $leistungsheft->id, 'status' => $status], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Leistungsheft $leistungsheft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeistungsheftRequest $request, Leistungsheft $leistungsheft)
    {
        $validated = $request->validated();

        $eigentuemers = $validated['eigentuemer'];

        // $eigentuemer_ids = $validated['eigentuemer_ids'];

        if (array_key_exists('hund_id', $validated)) {
            $leistungsheft->hund_id = $validated['hund_id'];
        }
        if (array_key_exists('besteller_id', $validated)) {
            $leistungsheft->besteller_id = $validated['besteller_id'];
        }
        if (array_key_exists('bemerkungen_besteller', $validated)) {
            $leistungsheft->bemerkungen_besteller = $validated['bemerkungen_besteller'];
        }
        if (array_key_exists('bemerkungen_drc', $validated)) {
            $leistungsheft->bemerkungen_drc = $validated['bemerkungen_drc'];
        }
        if (array_key_exists('bemerkungen_intern', $validated)) {
            $leistungsheft->bemerkungen_intern = $validated['bemerkungen_intern'];
        }

        $leistungsheft->save();

        $dokumente = $validated['dokumente'];
        $this->saveDokumente($leistungsheft, $dokumente);

        // BESTELLUNG
        if (array_key_exists('bestellen', $validated) && $validated['bestellen'] == 1) {

            $leistungsheft->gesendet = 1;
            $leistungsheft->status_id = 2;
            $leistungsheft->bestellt_am = now();

        } else {
            $leistungsheft->status_id = $validated['status_id'];
        }

        $leistungsheft->fresh();

        $status = new OptionNameResource($leistungsheft->status);

        return ['success' => true, 'status' => $status, 'bestellt_am' => $leistungsheft->bestellt_am];
    }

    /**
     * Get data needed for Leistungsheft order form
     * Returns only necessary data: leistungshefte, ahnentafeln, eigentuemer
     */
    public function getBestelldaten(int $hund_id)
    {
        $hund = \App\Models\Hund::select('id', 'name', 'wurfdatum', 'geschlecht_id', 'rasse_id', 'farbe_id')
            ->with([
                'geschlecht:id,name',
                'rasse:id,name',
                'farbe:id,name',
                'leistungshefte:id,hund_id,status_id,ausgestellt_am,vollstaendig',
                'leistungshefte.status:id,name',
                'ahnentafeln:id,hund_id,typ_id,status_id',
            ])
            ->find($hund_id);

        if (! $hund) {
            return response()->json([
                'success' => null,
                'error' => 'Hund nicht gefunden.',
                'data' => null,
            ], 404);
        }

        // Lade Eigentümer manuell (eigentuemer() Methode benötigt $this->id)
        $eigentuemer = \App\Models\Eigentuemer::where('hund_id', $hund_id)
            ->whereNull('bis')
            ->with(['person:id,vorname,nachname,email_1,email_2'])
            ->get()
            ->pluck('person')
            ->map(function ($person) {
                return [
                    'id' => $person->id,
                    'vorname' => $person->vorname,
                    'nachname' => $person->nachname,
                    'email' => $person->email_1 ?? $person->email_2,
                ];
            });

        $hund->eigentuemer = $eigentuemer;

        return response()->json([
            'success' => 'Bestelldaten erfolgreich geladen.',
            'error' => null,
            'data' => $hund,
        ]);
    }

    /**
     * Store a new Leistungsheft order (Bestellung)
     */
    public function storeBestellung(\App\Http\Requests\StoreLeistungsheftBestellungRequest $request)
    {
        try {
            $validated = $request->validated();

            // Prüfe ob User berechtigt ist (muss aktueller Eigentümer sein)
            $hund = \App\Models\Hund::findOrFail($validated['hund_id']);
            $user = $request->user();
            $isOwner = $hund->isCurrentOwner($validated['hund_id'], $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, für diesen Hund ein Leistungsheft zu bestellen.',
                ], 403);
            }

            // Prüfe ob bereits ein offener Antrag existiert (Status < 5)
            $existingAntrag = Leistungsheft::where('hund_id', $validated['hund_id'])
                ->where('status_id', '<', 5)
                ->first();

            if ($existingAntrag) {
                return response()->json([
                    'success' => null,
                    'error' => 'Für diesen Hund existiert bereits eine offene Leistungsheft-Bestellung.',
                ], 409);
            }

            // Hole alle ausgestellten Leistungshefte (Status = 5)
            $ausgestellteLeistungshefte = Leistungsheft::where('hund_id', $validated['hund_id'])
                ->where('status_id', 5)
                ->orderBy('ausgestellt_am', 'desc')
                ->get();

            $istErstesLeistungsheft = $ausgestellteLeistungshefte->isEmpty();

            // Besteller-Informationen
            $besteller = \App\Models\Person::find($validated['besteller_id']);
            $istMitglied = $besteller->mitglied()->exists();

            // Prüfe ob aktive DSGVO-Erklärung vorliegt (falls nicht Mitglied)
            $hatDSGVO = false;
            if (! $istMitglied) {
                $hatDSGVO = $besteller->hatAktiveDsgvoErklaerung();
            }

            // Hat der Hund eine DRC-Ahnentafel?
            $hatDRCAhnentafel = \App\Models\Ahnentafel::where('hund_id', $validated['hund_id'])
                ->where('typ_id', 1) // DRC-Ahnentafel
                ->where('status_id', 5) // Ausgestellt
                ->exists();

            // Berechne Gebühr
            $gebuehr = 0;
            $gebuehrGrund = '';

            if (! $hatDRCAhnentafel) {
                // Kein DRC-Hund → immer kostenpflichtig
                $gebuehrObj = Gebuehr::select('kosten_mitglied', 'kosten_nichtmitglied')
                    ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
                    ->where('gebuehrenkatalog_id', 8) // Leistungsheft Nicht-DRC
                    ->where('aktiv', 1)
                    ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
                    ->orderBy('gueltig_ab', 'desc')
                    ->first();

                $gebuehr = $istMitglied ? $gebuehrObj->kosten_mitglied : $gebuehrObj->kosten_nichtmitglied;
                $gebuehrGrund = 'Kein DRC-Hund';
            } elseif (! $istErstesLeistungsheft) {
                // Nicht erstes Leistungsheft → prüfe ob letztes voll war
                $letztesLeistungsheft = $ausgestellteLeistungshefte->first();

                // Wenn letztes LH nicht vollständig war → kostenpflichtig
                if (! $letztesLeistungsheft->vollstaendig) {
                    $gebuehrObj = Gebuehr::select('kosten_mitglied', 'kosten_nichtmitglied')
                        ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
                        ->where('gebuehrenkatalog_id', 21) // Leistungsheft unvollständig
                        ->where('aktiv', 1)
                        ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
                        ->orderBy('gueltig_ab', 'desc')
                        ->first();

                    $gebuehr = $istMitglied ? $gebuehrObj->kosten_mitglied : $gebuehrObj->kosten_nichtmitglied;
                    $gebuehrGrund = 'Letztes Leistungsheft nicht vollständig';
                }
            }

            // Erstelle Leistungsheft-Bestellung
            $leistungsheft = Leistungsheft::create([
                'hund_id' => $validated['hund_id'],
                'besteller_id' => $validated['besteller_id'],
                'bestellt_am' => now(),
                'status_id' => 1, // Status: Beantragt
                'gebuehr' => $gebuehr,
                'anmerkungen_besteller' => $validated['anmerkungen_besteller'] ?? null,
                'at_versendet_am' => $validated['at_versendet_am'] ?? null,
                'vollstaendig' => $validated['letztes_lh_vollstaendig'] ?? null,
            ]);

            return response()->json([
                'success' => 'Die Leistungsheft-Bestellung wurde erfolgreich eingereicht.',
                'error' => null,
                'data' => [
                    'leistungsheft_id' => $leistungsheft->id,
                    'hund_id' => $leistungsheft->hund_id,
                    'gebuehr' => $gebuehr,
                    'gebuehr_grund' => $gebuehrGrund,
                    'ist_erstes_leistungsheft' => $istErstesLeistungsheft,
                    'hat_drc_ahnentafel' => $hatDRCAhnentafel,
                    'ist_mitglied' => $istMitglied,
                    'hat_dsgvo' => $hatDSGVO,
                ],
            ], 201);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Die Bestellung konnte nicht eingereicht werden: ' . $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leistungsheft $leistungsheft)
    {
        //
    }
}
