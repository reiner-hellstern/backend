<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAhnentafelRequest;
use App\Http\Resources\AhnenResource;
use App\Models\Ahnentafel;
use App\Models\Gebuehr;
use App\Models\Hund;
use App\Models\Link;
use App\Models\Person;
use App\Traits\ApiResponses;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;

class AhnentafelController extends Controller
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
     * @param  \App\Models\Ahnentafelantrag  $ahnentafelantrag
     * @return \Illuminate\Http\Response
     */
    public function meta(Request $request)
    {

        $id = $request->id;
        $rasse_id = $request->rasse_id;
        $person_id = $request->antragsteller_id;

        $mitglied = Person::find($person_id)->mitglied()->first();

        //  $rasse = Hund::find($id)->rasse()->get();

        // switch ($rasse_id) {
        //    case 5: // 'Labrador Retriever'],
        //       $zo_link_id = 2;
        //       break;
        //    case 4: // Golden Retriever'],
        //       $zo_link_id = 1;
        //       break;
        //    case 3: // Flat Coated Retriever'],
        //       $zo_link_id = 3;
        //       break;
        //    case 6: // Nova Scotia Duck Tolling Retriever'],
        //       $zo_link_id = 6;
        //       break;
        //    case 2: // Curly Coated Retriever'],
        //       $zo_link_id = 5;
        //       break;
        //    case 1: // Chesapeake Bay Retriever'],
        //       $zo_link_id = 4;
        //       break;
        // }

        //  $url = Link::select('url', 'dateigroesse', 'name', 'fassung_vom')
        //  ->join('linkliste', 'linkliste.id', '=', 'links.linkliste_id')
        //  ->where('linkliste_id', $zo_link_id)
        //  ->where('aktiv', 1)
        //  ->whereDate('fassung_vom', '<=', date('Y-m-d'))
        //  ->orderBy('fassung_vom','desc')
        //  ->first();

        // $obj_gebuehr =  Gebuehr::select('gueltig_ab', 'kosten_mitglied', 'kosten_nichtmitglied', 'gueltig_bis', 'name')
        //    ->join('gebuehrenkatalog', 'gebuehrenkatalog.id', '=', 'gebuehren.gebuehrenkatalog_id')
        //    ->where('gebuehrenkatalog_id', 6)
        //    ->where('aktiv', 1)
        //    ->whereDate('gueltig_ab', '<=', date('Y-m-d'))
        //    ->orderBy('gueltig_ab', 'desc')
        //    ->first();

        //   $gebuehr = $mitglied ? $obj_gebuehr->kosten_mitglied : $obj_gebuehr->kosten_nichtmitglied;

        // TODO _ neue Links und Gebühren
        $url = '';
        $gebuehr = 0;

        return ['gebuehr' => $gebuehr];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $ahnentafel = Ahnentafel::with([
            'eigentuemer',
            'antragsteller',
            'hund',
            'dokumente',
            'eigentuemer.bestaetigungen' => function ($query) use ($id) {
                $query->where('bestaetigungen.bestaetigungable_id', '=', $id)->where('bestaetigungen.bestaetigungable_type', '=', 'App\Models\Ahnentafel');
            },
        ])
            ->where('id', $id)
            ->first();

        return $ahnentafel;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ahnentafel = new Ahnentafel();
        $ahnentafel->hund_id = $request->input('hund_id');
        $ahnentafel->typ_id = $request->input('typ_id');
        $ahnentafel->status_id = $request->input('status_id');
        $ahnentafel->standort_id = $request->input('standort_id');
        $ahnentafel->ausgestellt_am = $request->input('ausgestellt_am');

        $this->saveDokumente($ahnentafel, $request->input('dokumente'));

        $ahnentafel->save();

        return ['message' => 'Ahnentafel erfolgreich erstellt', 'ahnentafel' => $ahnentafel];
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
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */

    /**!SECTION
     *
    use App\Http\Controllers\AhnentafelController;

    $ahnentafel_controller = new AhnentafelController;

    $ahnentafel_controller->prerender(hund_id)
     */

    public function prerender($id)
    {

        $hund = Hund::find($id);

        return $hund;

        $hund = Hund::with([
            'formwert',
            'wesenstest',
            'pruefungentitel',
            'titeltitel',
            'gentests_total',
            'goniountersuchung',
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAhnentafelRequest $request, Ahnentafel $ahnentafel)
    {

        $ahnentafel->typ_id = $request->input('typ_id');
        $ahnentafel->status_id = $request->input('status_id');
        $ahnentafel->standort_id = $request->input('standort_id');
        $ahnentafel->ausgestellt_am = $request->input('ausgestellt_am');

        $this->saveDokumente($ahnentafel, $request->input('dokumente'));

        $ahnentafel->save();

        return ['message' => 'Ahnentafel erfolgreich aktualisiert', 'ahnentafel' => $ahnentafel];

        return $this->successResponse('Ahnentafel erfolgreich aktualisiert', $ahnentafel);
    }

    /**
     * Store a new Ahnentafel Zweitschrift application
     *
     * @return \Illuminate\Http\Response
     */
    public function storeZweitschrift(\App\Http\Requests\StoreAhnentafelZweitschriftRequest $request)
    {
        try {
            $validated = $request->validated();

            // Prüfen ob der User berechtigt ist (muss aktueller Eigentümer sein)
            $hund = Hund::findOrFail($validated['hund_id']);
            $user = $request->user();
            $isOwner = $hund->isCurrentOwner($validated['hund_id'], $user->person->id);

            if (! $isOwner) {
                return response()->json([
                    'success' => null,
                    'error' => 'Sie sind nicht berechtigt, für diesen Hund eine Ahnentafel-Zweitschrift zu beantragen.',
                ], 403);
            }

            // Prüfen ob bereits ein offener Antrag existiert
            $existingAntrag = Ahnentafel::where('hund_id', $validated['hund_id'])
                ->where('typ_id', 5) // Typ 5 = Zweitschrift
                ->whereIn('status_id', [1, 2, 3, 4]) // Offene Stati
                ->first();

            if ($existingAntrag) {
                return response()->json([
                    'success' => null,
                    'error' => 'Für diesen Hund existiert bereits ein offener Antrag auf eine Ahnentafel-Zweitschrift.',
                ], 409);
            }

            // Gebühr berechnen
            $person = Person::find($validated['antragsteller_id']);
            $mitglied = $person->mitglied()->first();

            // TODO: Gebühr aus Datenbank laden
            $gebuehr = 0; // Placeholder

            // Ahnentafel Zweitschrift Antrag erstellen
            $ahnentafel = Ahnentafel::create([
                'typ_id' => 5, // Zweitschrift
                'hund_id' => $validated['hund_id'],
                'antragsteller_id' => $validated['antragsteller_id'],
                'beantragt_am' => now(),
                'status_id' => 1, // Status: Neu/Offen
                'gebuehr' => $gebuehr,
                'kostenpflichtig' => $gebuehr > 0 ? 1 : 0,
                'anmerkung' => $validated['bemerkungen_antragsteller'] ?? null,
            ]);

            // Bestätigungen für ALLE Miteigentümer erstellen
            $bestaetigungen = [];
            if (isset($validated['eigentuemer_ids']) && is_array($validated['eigentuemer_ids'])) {
                foreach ($validated['eigentuemer_ids'] as $eigentuemer_id) {
                    $bestaetigung = new \App\Models\Bestaetigung();
                    $bestaetigung->person_id = $eigentuemer_id;
                    $ahnentafel->bestaetigungen()->save($bestaetigung);

                    $bestaetigung->fresh();

                    // Prüfe ob Miteigentümer E-Mail hat
                    $eigentuemer = Person::find($eigentuemer_id);
                    $hasEmail = ! empty($eigentuemer->email_1) || ! empty($eigentuemer->email_2);

                    $bestaetigungen[] = [
                        'person_id' => $eigentuemer_id,
                        'bestaetigung_id' => $bestaetigung->id,
                        'has_email' => $hasEmail,
                    ];

                    // TODO: Wenn E-Mail vorhanden, Bestätigungs-E-Mail senden
                    // if ($hasEmail) {
                    //    Mail::to($eigentuemer->email_1 ?? $eigentuemer->email_2)
                    //       ->send(new BestaetigungAnfordern($bestaetigung, $ahnentafel, $hund));
                    // }
                }
            }

            return response()->json([
                'success' => 'Der Antrag auf eine Ahnentafel-Zweitschrift wurde erfolgreich eingereicht.',
                'error' => null,
                'data' => [
                    'ahnentafel_id' => $ahnentafel->id,
                    'hund_id' => $ahnentafel->hund_id,
                    'bestaetigungen' => $bestaetigungen,
                ],
            ], 201);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'success' => null,
                'error' => 'Der Antrag konnte nicht eingereicht werden.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ahnentafel $ahnentafel)
    {
        //
    }
}
