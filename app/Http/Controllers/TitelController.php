<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTitelRequest;
use App\Http\Requests\UpdateTitelRequest;
use App\Http\Resources\OptionNameWertlosResource;
use App\Models\Anwartschaft;
use App\Models\Titel;
use App\Models\TitelTyp;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TitelController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function show(Titel $titel)
    {
        //
    }

    public function store(StoreTitelRequest $request)
    {

        $validated = $request->all();
        $user_id = Auth::id();

        foreach ($validated as $t) {

            $ausrichter_id = array_key_exists('ausrichter', $t) ? $t['ausrichter']['id'] : null;
            $ausrichter_name = array_key_exists('ausrichter', $t) ? $t['ausrichter']['name'] : null;
            $dokumente = array_key_exists('dokumente', $t) ? $t['dokumente'] : [];
            $tags = array_key_exists('tags', $t) ? $t['tags'] : [];

            $titel = new Titel();
            $titel->hund_id = $t['hund_id'];
            $titel->type_id = $t['type_id'];
            $titel->status_id = $t['status_id'];
            $titel->datum = $t['datum'];
            $titel->ort = $t['ort'];

            $titel->extern = $t['extern'];
            $titel->drc = $t['extern'] ? 0 : 1;
            $titel->ausrichter = $ausrichter_name;
            $titel->ausrichter_id = $ausrichter_id;
            $titel->jahr = $t['jahr'];
            $titel->name = $t['name'];
            $titel->name_kurz = $t['name_kurz'];
            $titel->created_id = $user_id;
            $titel->freigabe_id = ($t['status_id'] != 1) ? $user_id : 0;
            $titel->save();

            $this->saveDokumente($titel, $dokumente);

            $titel = $titel->fresh();
            $titel->tags = $tags;

            $output_return[] = $titel;
        }

        // return $output_return;

        return response()->json([
            'success' => 'Titel gespeichert.',
            'titels' => $output_return,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTitelRequest $request, Titel $titel)
    {
        $validated = $request->all();

        $user_id = Auth::id();

        $ausrichter_id = array_key_exists('ausrichter', $validated) ? $validated['ausrichter']['id'] : null;
        $ausrichter_name = array_key_exists('ausrichter', $validated) ? $validated['ausrichter']['name'] : null;
        $dokumente = array_key_exists('dokumente', $validated) ? $validated['dokumente'] : [];
        $tags = array_key_exists('tags', $validated) ? $validated['tags'] : [];

        $titel->type_id = $validated['type_id'];
        $titel->status_id = $validated['status_id'];
        $titel->datum = $validated['datum'];
        $titel->ort = $validated['ort'];

        $titel->extern = $validated['extern'];
        $titel->drc = $validated['extern'] ? 0 : 1;
        $titel->ausrichter = $ausrichter_name;
        $titel->ausrichter_id = $ausrichter_id;
        $titel->jahr = $validated['jahr'];
        $titel->name = $validated['name'];
        $titel->name_kurz = $validated['name_kurz'];
        $titel->freigabe_id = ($validated['status_id'] != 1) ? $user_id : 0;
        $titel->save();

        $this->saveDokumente($titel, $dokumente);

        $titel = $titel->fresh();
        $titel->tags = $tags;

        return [
            'titel' => $titel,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Titel $titel)
    {
        $user_id = Auth::id();

        $titel->delete();

        return response()->json([
            'success' => 'Titel gelöscht.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function meldung_store(StoreTitelRequest $request)
    {
        //
        $validated = $request->all();

        $user_id = Auth::id();

        $ausrichter_id = array_key_exists('ausrichter', $validated) ? $validated['ausrichter']['id'] : null;
        $ausrichter_name = array_key_exists('ausrichter', $validated) ? $validated['ausrichter']['name'] : null;
        $dokumente = array_key_exists('dokumente', $validated) ? $validated['dokumente'] : [];
        $tags = array_key_exists('tags', $validated) ? $validated['tags'] : [];

        $titelmeldung = new Titel();
        $titelmeldung->hund_id = $validated['hund_id'];
        $titelmeldung->type_id = $validated['type_id'];
        $titelmeldung->status_id = 1;
        $titelmeldung->datum = $validated['datum'];
        $titelmeldung->ort = $validated['ort'];
        $titelmeldung->freigabe_id = null;
        $titelmeldung->extern = 1;
        $titelmeldung->drc = 0;
        $titelmeldung->ausrichter = $ausrichter_name;
        $titelmeldung->ausrichter_id = $ausrichter_id;
        $titelmeldung->jahr = $validated['jahr'];
        $titelmeldung->name = $validated['name'];
        $titelmeldung->name_kurz = $validated['name_kurz'];
        $titelmeldung->created_id = $user_id;
        $titelmeldung->save();

        foreach ($dokumente as $dokument) {
            $tags = $dokument['tags'];
            unset($dokument['tags']);
            $dokument = $titelmeldung->dokumente()->create($dokument);
            $dokument->tags()->sync($tags);
        }

        $titelmeldung = $titelmeldung->fresh();
        $titelmeldung->tags = $tags;

        return [
            'titel' => $titelmeldung,
        ];
    }

    public function meldung_update(UpdateTitelRequest $request, Titel $titel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function meldung_destroy(Titel $titel)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_antragchampionstitel(Request $request)
    {
        //
        $user_id = Auth::id();
        $antrag = new Titel();
        $antrag->hund_id = $request->antrag['hund_id'];
        $antrag->type_id = $request->antrag['titeltyp']['id'];
        $antrag->antrag = 1;
        $antrag->created_id = $user_id;
        $antrag->save();

        $anwartschaften = $request->anwartschaften;

        foreach ($anwartschaften as &$anwartschaft) {

            $a = new Anwartschaft();
            $a->datum = $anwartschaft['datum'];
            $a->land = $anwartschaft['land'];
            // $a->land_id = $anwartschaft['land']['id'];
            $a->postleitzahl = $anwartschaft['postleitzahl'];
            $a->ort = $anwartschaft['ort'];
            $a->anwartschafttyp_id = $anwartschaft['anwartschafttyp']['id'];
            $a->titel_id = $antrag->id;
            $a->save();

            $anwartschaft['id'] = $a->id;
            $anwartschaft['titel_id'] = $antrag->id;
        }
        unset($anwartschaft);

        return [
            'antrag' => $antrag,
            'anwartschaften' => $anwartschaften,
        ];

        return $antrag;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_string(Request $request)
    {

        $content = $request->titelstring;

        $hund_id = 0;
        $titeltypen = TitelTyp::with('ausrichters')->where('regex', '!=', '')->get();
        $erkannte_titels = [];

        // $content = "Dt.-Ch. Dt.-VCh. CS(m.Arb.)'10 Sieger-Leipzig/Berlin'09/Brandenb.'11 GW'13 Int.-Ch. C.I.E. NL/Lux./BeNeLux.-Ch. NL-VCh. ES'10 Winner-NL'10/BeNeLux.'14'16 VWinner-BeNeLux/Amsterd.'16";

        // $content = "Sieger-Leipzig/Berlin'09/Brandenb.'11";

        foreach ($titeltypen as $titelstyp) {

            $titel_id = 0;
            $titel_name = 'NICHT GEFUNDEN';

            for ($i = 0; $i < 5 && trim($content); $i++) {

                ////  TYP 1
                if ($titelstyp['regex_type'] == 1) {
                    preg_match('/' . $titelstyp['regex'] . '/', $content, $matches);

                    $jahre = [];
                    $ausrichters = [];

                    if ($matches) {

                        $titel_id = $titelstyp['id'];
                        $titel_name = $titelstyp['name'];
                        $titel_name_kurz = $titelstyp['name_kurz'];
                        $titel_land = $titelstyp['land'];

                        $ausrichter_matched = true;
                        // ZERLEGE UND FINDE AUSRICHTER
                        if ($titelstyp['ausrichter_matchindex']) {

                            // prüfe:
                            // 1. im Suchergebnis des regulären Ausdrucks ist der gewünschte Index vorhanden
                            // 2. es gibt einen Wert im Suchergebnis
                            if (array_key_exists($titelstyp['ausrichter_matchindex'], $matches) && ($matches[$titelstyp['ausrichter_matchindex']])) {

                                // Zerlege das Suchergebnis in ein Array von Ausrichtern

                                // a. anhand des Separator-Symbols
                                if ($titelstyp['ausrichter_separator']) {
                                    $regfound_ausrichters = explode($titelstyp['ausrichter_separator'], $matches[$titelstyp['ausrichter_matchindex']]);
                                } else { // b. kein Separator. Ein Eintrag in Array
                                    $regfound_ausrichters[] = $matches[$titelstyp['ausrichter_matchindex']];
                                }

                                // Prüfe, ob es für den Titeltyp ein Liste von möglichen Ausrichtern gibt
                                if (count($titelstyp['ausrichters'])) {

                                    // Prüfe, ob die gefundenen Ausrichter in der Liste der möglichen Ausrichter vorhanden sind ....
                                    foreach ($regfound_ausrichters as $regfound_ausrichter) {

                                        $ausrichter = '';
                                        foreach ($titelstyp['ausrichters'] as $ausrichter) {
                                            if ($ausrichter['name_kurz'] == $regfound_ausrichter) {
                                                // ... und nimm die entsprechende Id in eine Array von gefundenen IDs auf
                                                $ausrichters[] = [
                                                    'id' => $ausrichter['id'],
                                                    'name_kurz' => $ausrichter['name_kurz'],
                                                    'name' => $ausrichter['name'],
                                                    'titel_kurz' => $ausrichter['titel_kurz'],
                                                    'titel' => $ausrichter['titel'],
                                                    'land' => $ausrichter['land'],
                                                ];
                                            } else {
                                                $ausrichter_matched = false;
                                                $ausrichters = [];
                                            }
                                        }

                                    }
                                }
                            } else {
                                $ausrichters = [];
                            }
                        }

                        if ($ausrichter_matched) {

                            $pattern = trim(preg_quote($matches[0], '/'));
                            $content = preg_replace("/(^|[\s])" . $pattern . "($|[\s])/", ' ', $content);
                            $content = trim(str_replace('  ', ' ', $content));

                            // ZERLEGE JAHRE
                            if ($titelstyp['jahr_matchindex']) {

                                if ($matches[$titelstyp['jahr_matchindex']]) {

                                    $jahrestring = ltrim($matches[$titelstyp['jahr_matchindex']], "'");

                                    if ($titelstyp['jahr_separator']) {
                                        $jahre = explode($titelstyp['jahr_separator'], $jahrestring);
                                    } else {
                                        $jahre[] = $jahrestring;
                                    }
                                } else {
                                    $jahre = [];
                                }
                            }

                            // ERSTELLE ERKANNTE TITEL GGF. AUS AUSRICHTERN UND JAHREN
                            if (count($ausrichters) && count($jahre)) {

                                foreach ($jahre as $jahr) {

                                    if (intval($jahr) <= 99 && intval($jahr) >= 50) {
                                        $jahr = '19' . $jahr;
                                    }
                                    if (intval($jahr) <= 49 && intval($jahr) >= 00) {
                                        $jahr = '20' . $jahr;
                                    }

                                    foreach ($ausrichters as $ausrichter) {

                                        if ($ausrichter['id']) {

                                            $jahr_kurz = $jahr;
                                        }
                                        $erkannte_titels[] = [
                                            'case' => 'aj',
                                            'id' => $titel_id,
                                            'extern' => $titelstyp['extern'],
                                            'hund_id' => $hund_id,
                                            'name' => $ausrichter['titel'],
                                            'name_kurz' => $ausrichter['titel_kurz'],
                                            'ausrichter_id' => $ausrichter['id'],
                                            'ausrichter_name' => $ausrichter['name'],
                                            'ausrichter_name_kurz' => $ausrichter['name_kurz'],
                                            'land' => $ausrichter['land'],
                                            'jahr' => $jahr,
                                            'jahr_kurz' => $jahr_kurz,

                                        ];
                                    }
                                }
                            } elseif (count($ausrichters) && ! count($jahre)) {

                                foreach ($ausrichters as $ausrichter) {
                                    $erkannte_titels[] = [
                                        'case' => 'a',
                                        'id' => $titel_id,
                                        'hund_id' => $hund_id,
                                        'extern' => $titelstyp['extern'],
                                        'name' => $ausrichter['titel'],
                                        'name_kurz' => $ausrichter['titel_kurz'],
                                        'ausrichter_id' => $ausrichter['id'],
                                        'ausrichter_name' => $ausrichter['name'],
                                        'ausrichter_name_kurz' => $ausrichter['name_kurz'],
                                        'land' => $ausrichter['land'],
                                        'jahr' => 0,
                                        'jahr_kurz' => '',

                                    ];
                                }
                            } elseif (count($jahre) && ! count($ausrichters)) {

                                foreach ($jahre as $jahr) {
                                    $jahr_kurz = $jahr;
                                    if (intval($jahr) <= 99 && intval($jahr) >= 50) {
                                        $jahr = '19' . $jahr;
                                    }
                                    if (intval($jahr) <= 49 && intval($jahr) >= 00) {
                                        $jahr = '20' . $jahr;
                                    }

                                    $erkannte_titels[] = [
                                        'case' => 'j',
                                        'id' => $titel_id,
                                        'extern' => $titelstyp['extern'],
                                        'hund_id' => $hund_id,
                                        'name' => $titel_name,
                                        'name_kurz' => $titel_name_kurz,
                                        'ausrichter_id' => 0,
                                        'ausrichter_name' => '',
                                        'ausrichter_name_kurz' => '',
                                        'land' => $titel_land,
                                        'jahr' => $jahr,
                                        'jahr_kurz' => $jahr_kurz,

                                    ];
                                }
                            } elseif (! count($jahre) && ! count($ausrichters)) {

                                $erkannte_titels[] = [
                                    'case' => 'null',
                                    'extern' => $titelstyp['extern'],
                                    'id' => $titel_id,
                                    'hund_id' => $hund_id,
                                    'name' => $titel_name,
                                    'name_kurz' => $titel_name_kurz,
                                    'ausrichter_id' => 0,
                                    'ausrichter_name' => '',
                                    'ausrichter_name_kurz' => '',
                                    'land' => $titel_land,
                                    'jahr' => 0,
                                    'jahr_kurz' => '',

                                ];
                            }
                        }
                    } else {
                        $i = 10;
                    }
                }

                // TYP 2
                if ($titelstyp['regex_type'] == 2) {

                    preg_match('/' . $titelstyp['multiregex'] . '/', $content, $multimatches);

                    if ($multimatches) {

                        $titel_id = $titelstyp['id'];
                        $titel_name = $titelstyp['name'];
                        $titel_name_kurz = $titelstyp['name_kurz'];
                        $titel_land = $titelstyp['land'];

                        $matches = [];

                        preg_match_all("/((([\w][ÖÜÄöüä\w\.,\-\/]+)(('\d\d)+)){1,})/", $multimatches[2], $matches);

                        foreach ($matches[0] as $match) {

                            $jahre = [];
                            $ausrichters = [];
                            $ausrichter_matched = false;

                            preg_match("/([ÖÜÄöüä\w\.,\-\/]+)(('\d\d)+)/", $match, $lmatch);
                            // $lmatch[1] = Ausrichters
                            // $lmatch[2] = Jahre

                            $regfound_ausrichters = explode('/', $lmatch[1]);

                            foreach ($regfound_ausrichters as $regfound_ausrichter) {

                                foreach ($titelstyp['ausrichters'] as $ar) {

                                    if ($ar['name_kurz'] == $regfound_ausrichter) {

                                        // return ['1' => $regfound_ausrichter, '2' => $ar['name_kurz']];
                                        $ausrichters[] = [
                                            'id' => $ar['id'],
                                            'name_kurz' => $ar['name_kurz'],
                                            'name' => $ar['name'],
                                            'titel_kurz' => $ar['titel_kurz'],
                                            'titel' => $ar['titel'],
                                            'land' => $ar['land'],
                                        ];

                                        $ausrichter_matched = true;

                                    }
                                }
                            }

                            if ($ausrichter_matched) {
                                $pattern = trim(preg_quote($multimatches[0], '/'));
                                $content = preg_replace("/(^|[\s])" . $pattern . "($|[\s])/", ' ', $content);
                                $content = trim(str_replace('  ', ' ', $content));
                            }

                            $jahrestring = ltrim($lmatch[2], "'");
                            $jahre = explode("'", $jahrestring);

                            foreach ($jahre as $jahr) {

                                $jahr_kurz = $jahr;
                                if (intval($jahr) <= 99 && intval($jahr) >= 50) {
                                    $jahr = '19' . $jahr;
                                }
                                if (intval($jahr) <= 49 && intval($jahr) >= 00) {
                                    $jahr = '20' . $jahr;
                                }

                                foreach ($ausrichters as $ausrichter) {

                                    $erkannte_titels[] = [
                                        'case' => 'aj',
                                        'id' => $titel_id,
                                        'extern' => $titelstyp['extern'],
                                        'hund_id' => $hund_id,
                                        'name' => $ausrichter['titel'],
                                        'name_kurz' => $ausrichter['titel_kurz'],
                                        'ausrichter_id' => $ausrichter['id'],
                                        'ausrichter_name' => $ausrichter['name'],
                                        'ausrichter_name_kurz' => $ausrichter['name_kurz'],
                                        'ausrichter_label' => $titelstyp['ausrichter_label'],
                                        'land' => $ausrichter['land'],
                                        'jahr' => $jahr,
                                        'jahr_kurz' => $jahr_kurz,
                                        'kategorie' => $titelstyp['kategorie'],
                                        'feldbezeichner' => $titelstyp['feldbezeichner'],
                                        'ausrichter' => ['id' => $ausrichter['id'], 'name' => $ausrichter['name']],
                                        'optionen_ausrichters' => OptionNameWertlosResource::collection($titelstyp['ausrichters']),
                                        'content' => $multimatches[0],
                                    ];
                                }
                            }

                        }
                    }
                }
            }
        }

        return [
            'titels' => $erkannte_titels,
            'unerkannt' => $content,
        ];

    }
}
