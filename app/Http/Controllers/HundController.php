<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHundRequest;
use App\Http\Resources\AbstammungsnachweisResource;
use App\Http\Resources\AugenuntersuchungRenderedResource;
// use App\Models\Image;
use App\Http\Resources\AugenuntersuchungResource;
use App\Http\Resources\BlutprobeneinlagerungResource;
use App\Http\Resources\EigentuemerwechselantragResource;
use App\Http\Resources\EpilepsiebefundResource;
use App\Http\Resources\FCPResource;
use App\Http\Resources\GelenkuntersuchungResource;
use App\Http\Resources\GentestRenderedResource;
use App\Http\Resources\GentestResource;
use App\Http\Resources\HDEDUntersuchungRenderedResource;
use App\Http\Resources\HDEDUntersuchungResource;
use App\Http\Resources\HodenResource;
use App\Http\Resources\HundBasisdatenResource;
use App\Http\Resources\HundeShortResource;
use App\Http\Resources\HundesucheResource;
use App\Http\Resources\HundInitResource;
use App\Http\Resources\HundResource;
use App\Http\Resources\HundTableResource;
use App\Http\Resources\KaiserschnittResource;
use App\Http\Resources\KardiobefundResource;
use App\Http\Resources\KastrationSterilisationResource;
use App\Http\Resources\OCDUntersuchungRenderedResource;
use App\Http\Resources\OCDUntersuchungResource;
use App\Http\Resources\OptionNameResource;
use App\Http\Resources\OptionZBNrResource;
use App\Http\Resources\PatellaResource;
use App\Http\Resources\PruefungResource;
use App\Http\Resources\RuteResource;
use App\Http\Resources\TitelResource;
use App\Http\Resources\UreterResource;
use App\Http\Resources\ZahnstatusRenderedResource;
use App\Http\Resources\ZahnstatusResource;
use App\Models\Ahnentafel;
use App\Models\Eigentuemer;
use App\Models\Hund;
use App\Models\Leistungsheft;
use App\Models\Person;
use App\Models\Postleitzahl;
use App\Models\PruefungTyp;
use App\Models\TitelTyp;
use App\Models\Uebernahmeantrag;
use App\Models\Zuchtbuchnummer;
use App\Models\Zuchtzulassung;
use App\Models\Zuchtzulassungsantrag;
use App\Traits\GetPrerenderedHund;
use App\Traits\PrerenderHund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;

class HundController extends Controller
{
    use GetPrerenderedHund;
    use PrerenderHund;

    public function index(Request $request)
    {

        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $hunde = Hund::leftjoin('optionen_geschlecht_hund', 'hunde.geschlecht_id', '=', 'optionen_geschlecht_hund.id')->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')->select('hunde.*', 'optionen_geschlecht_hund.name AS geschlecht_name', 'farben.name AS farbe_name', 'rassen.name AS rasse_name')->where(function ($query) use ($columns) {
            // $hunde = Hund::with(['farbe','rasse'])->where(function($query) use ($columns) {
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
                            $query->where(function ($q) use ($column, $table) {
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

        return HundTableResource::collection($hunde);
    }

    public function prefilter(Request $request, $prefilter = '')
    {

        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $hunde = Hund::leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')->select('hunde.*', 'farben.name AS farbe_name', 'rassen.name AS rasse_name')->where(function ($query) use ($columns) {
            // $hunde = Hund::with(['farbe','rasse'])->where(function($query) use ($columns) {
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
                            $query->where(function ($q) use ($column, $table) {
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
        })->where(function ($query) use ($prefilter) {
            switch ($prefilter) {
                case 'drc':
                    $query->where('zuchtbuchnummer', 'REGEXP', '^\d{2}');
                    break;
                case 'zucht':
                    $query->where('zuchthund', '=', 'true')->orWhere('zuchthund', '=', '1');
                    break;
                case 'deckruede':
                    $query->where('geschlecht_id', '=', 2);
                    break;
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

        return HundResource::collection($hunde);
    }

    public function zucht(Request $request)
    {
        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $hunde = Hund::join('wesensteste', 'wesensteste.hund_id', '=', 'hunde.id')->where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                if ($column['filterable'] == true && $column['filtertype'] != 0) {
                    switch ($column['filtertype']) {
                        case 2:
                            $query->where($column['db_field'], 'NOT LIKE', '%' . $column['filter'] . '%');
                            break;
                        case 3:
                            $query->where($column['db_field'], 'LIKE', $column['filter'] . '%');
                            break;
                        case 4: //LEER
                            $query->where(function ($q) use ($column) {
                                $q->whereNull($column['db_field'])->orWhere($column['db_field'], '=', '')->orWhere($column['db_field'], '=', '0000-00-00');
                            });
                            break;
                        case 5:  //NICHT LEER
                            $query->whereNotNull($column['db_field'])->where($column['db_field'], '<>', '')->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 6:
                            $query->where($column['db_field'], '=', $column['filter']);
                            break;
                        case 7:
                            $query->where($column['db_field'], '<>', $column['filter']);
                            break;
                        case 8:
                            $query->where($column['db_field'], '>', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 9:
                            $query->where($column['db_field'], '<', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 10:
                            $query->where($column['db_field'], '>=', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 11:
                            $query->where($column['db_field'], '<=', $column['filter'])->where($column['db_field'], '<>', '');
                            break;
                        case 12:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->whereDate($column['db_field'], $sqldate);
                            break;
                        case 13:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($column['db_field'], '<=', $sqldate)->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 14:
                            $sqldate = date('Y-m-d', strtotime($column['filter']));
                            $query->where($column['db_field'], '>=', $sqldate)->where($column['db_field'], '<>', '0000-00-00');
                            break;
                        case 1:
                        default:
                            $query->where($column['db_field'], 'LIKE', '%' . $column['filter'] . '%');
                            break;
                    }
                }
            }
        })->when($search != '', function ($query) use ($columns, $search) {
            $first = true;
            foreach ($columns as $column) {

                if ($column['searchable'] == true) {
                    if ($first == true) {
                        $query->where($column['db_field'], 'LIKE', '%' . $search . '%');
                        $first = false;
                    } else {
                        $query->orWhere($column['db_field'], 'LIKE', '%' . $search . '%');
                    }
                }
            }
        })->orderBy($sortField, $sortDirection)->paginate($pagination);

        return HundResource::collection($hunde);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function zuchthund_person(Hund $id)
    {

        return HundResource::collection(Hund::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hund $hund)
    {

        $hund['gutachten'] = $hund->gutachten;
        $hund['titel'] = $hund->temptitel;
        $hund['formwert'] = $hund->formwert_tmp;
        $hund['tpg'] = $hund->tpg;
        $hund['pruefungen'] = $hund->temppruefungen;
        $hund['personen'] = $hund->personen;
        $hund['wesenstest'] = $hund->wesenstest;
        if ($hund['wesenstest']) {
            $hund['wesenstest']['zzl_bemerkungen'] = strtolower($hund['wesenstest']['zzl_bemerkungen']);
            $hund['wesenstest']['zzl_datum'] = ($hund['wesenstest']['zzl_datum'] == '0000-00-00') ? '' : date('d.m.Y', strtotime($hund['wesenstest']['zzl_datum']));
        }

        return $hund;

        return HundResource::collection($hund);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Hund $hund)
    {

        $prerender = $this->getPrerenderedHund($hund->id);

        $url = Config::get('app.url');

        $hund->load('chipnummern', 'ocduntersuchungen', 'augenuntersuchungen', 'notizen', 'dokumente', 'titel', 'titel.type', 'titel.type.ausrichters', 'anwartschaften', 'patella', 'gelenkuntersuchungen', 'hdeduntersuchungen', 'images', 'formwert', 'wesenstest', 'pruefungen', 'pruefungen.type', 'pruefungen.resultable', 'pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze', 'personen', 'gentests', 'zahnstati', 'hundefuehrers', 'wuerfe', 'wuerfe_r', 'wuerfe_h', 'meldungen', 'meldungen.veranstaltung', 'meldungen.veranstaltung.termine', 'zwingers', 'zwingers.images', 'zwingers.personen', 'zwingers.rassen', 'zuchtverbote', 'zuchtverbote.entscheider', 'zuchtverbote.dokumente', 'zuchtzulassung', 'zuchtzulassungsantraege', 'zuchtzulassungsantraege.antragsteller', 'leistungshefte', 'uebernahmeantraege');

        $images = $hund->images;
        $firstimg = count($images) ? $url . '/storage/' . $images[0]->path : '';
        $hund['foto'] = $firstimg ? $firstimg : '';

        $formwert = [];
        $wesenstest = [];
        $auflagen = [];

        //
        // FORMWERT
        //

        if (count($hund->formwert)) {

            if ($hund->formwert[0]->resultable_type == 'App\\Models\\Formwert_v0' || $hund->formwert[0]->resultable_type == 'App\\Models\\Formwert_v1') {
                $formwert['datum'] = $hund->formwert[0]->resultable->datum;
                $formwert['beurteilung'] = $hund->formwert[0]->resultable->beurteilung;
                $formwert['formwert'] = $hund->formwert[0]->resultable->formwert;
                $formwert['risthoehe'] = $hund->formwert[0]->resultable->risthoehe;
                $formwert['richter'] = $hund->formwert[0]->resultable->richter;

                if ($hund->formwert[0]->resultable->auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->auflagen;
                }
                if ($hund->formwert[0]->resultable->augen_auflagen_gonio) {
                    $auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_gonio;
                }
                if ($hund->formwert[0]->resultable->augen_auflagen_hc) {
                    $auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_hc;
                }
                if ($hund->formwert[0]->resultable->augen_auflagen_rd) {
                    $auflagen[] = $hund->formwert[0]->resultable->augen_auflagen_rd;
                }
                if ($hund->formwert[0]->resultable->ed_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->ed_auflagen;
                }
                if ($hund->formwert[0]->resultable->fw_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->fw_auflagen;
                }
                if ($hund->formwert[0]->resultable->gebiss_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->gebiss_auflagen;
                }
                if ($hund->formwert[0]->resultable->gentest_auflagen_pra) {
                    $auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_pra;
                }
                if ($hund->formwert[0]->resultable->gentest_auflagen_sonst) {
                    $auflagen[] = $hund->formwert[0]->resultable->gentest_auflagen_sonst;
                }
                if ($hund->formwert[0]->resultable->hd_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->hd_auflagen;
                }
                if ($hund->formwert[0]->resultable->leistung_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->leistung_auflagen;
                }
                if ($hund->formwert[0]->resultable->sonst_auflagen) {
                    $auflagen[] = $hund->formwert[0]->resultable->sonst_auflagen;
                }
            }
        }

        //
        // WESENSTEST
        //
        if (count($hund->wesenstest)) {

            if ($hund->wesenstest[0]->resultable_type == 'App\\Models\\Wesenstest_v0' || $hund->wesenstest[0]->resultable_type == 'App\\Models\\Wesenstest_v1') {
                $wesenstest['datum'] = $hund->wesenstest[0]->resultable->datum;
            }

            $wesenstest['datum'] = $hund->wesenstest[0]->resultable->datum;
            $wesenstest['alter'] = $hund->wesenstest[0]->resultable->alter;
            $wesenstest['richter'] = $hund->wesenstest[0]->resultable->richter;
            $wesenstest['ort'] = $hund->wesenstest[0]->resultable->ort;
            $wesenstest['beurteilung'] = $hund->wesenstest[0]->resultable->beurteilung;

            $wesenstest['zusammenfassung'] = [
                [
                    'titel' => 'Temperament, Bewegungs-, Spielverhalten',
                    'text' => $hund->wesenstest[0]->resultable->t_b_s,
                ],
                [
                    'titel' => 'Ausdauer, Unerschrockenheit, Aufmerksamkeit',
                    'text' => $hund->wesenstest[0]->resultable->a_u_h_a,
                ],
                [
                    'titel' => 'Beuteverhalten, Tragen, Zutragen, Spürverhalten',
                    'text' => $hund->wesenstest[0]->resultable->b_b_s_s,
                ],
                [
                    'titel' => 'Unterordnungsbereitschaft, Bindung',
                    'text' => $hund->wesenstest[0]->resultable->u_b,
                ],
                [
                    'titel' => 'Sicherheit gegenüber Menschen, Kreisprobe, Seitenlage',
                    'text' => $hund->wesenstest[0]->resultable->s_m_k_r,
                ],
                [
                    'titel' => 'Sicherheit gegenüber optischen und akustischen Reizen',
                    'text' => $hund->wesenstest[0]->resultable->s_r,
                ],
                [
                    'titel' => 'Schussfestigkeit',
                    'text' => $hund->wesenstest[0]->resultable->schuss,
                ],
                [
                    'titel' => 'Kampftrieb, Misstrauen',
                    'text' => $hund->wesenstest[0]->resultable->k_m,
                ],
                [
                    'titel' => 'Unerwünschte Eigenschaften',
                    'text' => $hund->wesenstest[0]->resultable->unerw_eigenschaften,
                ],
                [
                    'titel' => 'Bemerkungen',
                    'text' => $hund->wesenstest[0]->resultable->bemerkung,
                ],
                [
                    'titel' => 'Auflagen',
                    'text' => $hund->wesenstest[0]->resultable->auflage,
                ],
            ];

            if ($hund->wesenstest[0]->resultable->auflage) {
                $auflagen[] = $hund->wesenstest[0]->resultable->auflage;
            }
        }

        $herkunftszuchtstaette = [
            'id' => $hund->zwinger_id,
            'zwingername' => $hund->zwinger_name,
            'zuechter' => $hund->zuechter_vorname . ' ' . $hund->zuechter_nachname, // $hund->zuechter_vorname . ' ' . $hund->zuechter_nachname,
            'zuechter_vorname' => $hund->zuechter_vorname,
            'zuechter_nachname' => $hund->zuechter_nachname,
            'zuechter_id' => $hund->zuechter_id,
            'strasse' => $hund->zwinger_strasse,
            'postleitzahl' => $hund->zwinger_plz,
            'ort' => $hund->zwinger_ort,
            'fcinummer' => $hund->zwinger_fci,
            'land' => $hund->zwinger_land,
            'telefon' => $hund->zwinger_tel,
        ];

        $vater = [
            'id' => $hund->vater_id,
            'name' => $hund->vater_name,
            'zuchtbuchnummer' => $hund->vater_zuchtbuchnummer,
            'geschlecht' => 2,
        ];

        $mutter = [
            'id' => $hund->mutter_id,
            'name' => $hund->mutter_name,
            'zuchtbuchnummer' => $hund->mutter_zuchtbuchnummer,
            'geschlecht' => 1,
        ];

        $output = [];

        $output['prerendered'] = $prerender;

        $output['notizen'] = $hund->notizen;
        $output['dokumente'] = $hund->dokumente;
        $output['pruefungen'] = PruefungResource::collection($hund->pruefungen);
        $output['titels'] = TitelResource::collection($hund->titel);
        $output['anwartschaften'] = $hund->anwartschaften;
        $output['images'] = $images;
        $output['hund_id'] = $hund->id;
        $output['basisdaten'] = new HundBasisdatenResource($hund);
        $output['meldungen'] = $hund->meldungen;
        $output['personen'] = $hund->personen;
        $output['hundefuehrers'] = $hund->hundefuehrers;
        $output['wuerfe'] = $hund->geschlecht_id == 2 ? $hund->wuerfe_r : $hund->wuerfe_h;
        $output['wurfplaene'] = $hund->wurfplaene;
        $output['zuchtverbote'] = $hund->zuchtverbote;
        $output['zwingers'] = $hund->zwingers;
        $output['zuchtzulassung'] = $hund->zuchtzulassung;
        $output['zuchtzulassungsantraege'] = $hund->zuchtzulassungsantraege;
        $output['verstorben'] = $hund->verstorben;
        $output['ahnentafeln'] = $hund->ahnentafeln;
        $output['leistungshefte'] = $hund->leistungshefte;
        $output['uebernahmeantraege'] = $hund->uebernahmeantraege;
        $output['formwert'] = $formwert;
        $output['wesenstest'] = $wesenstest;
        $output['zuchtauflagen'] = $auflagen;
        $output['herkunftszuchtstaette'] = $herkunftszuchtstaette;
        $output['vater'] = $vater;
        $output['mutter'] = $mutter;
        $output['eigentuemers'] = $hund->eigentuemers;
        $output['eigentuemerwechselantraege'] = EigentuemerwechselantragResource::collection($hund->eigentuemerwechselantraege);
        $output['ocduntersuchungen'] = OCDUntersuchungResource::collection($hund->ocduntersuchungen);
        $output['augenuntersuchungen'] = AugenuntersuchungResource::collection($hund->augenuntersuchungen);
        $output['hdeduntersuchungen'] = HDEDUntersuchungResource::collection($hund->hdeduntersuchungen);
        $output['gelenkuntersuchungen'] = GelenkuntersuchungResource::collection($hund->gelenkuntersuchungen);
        $output['gentests'] = GentestResource::collection($hund->gentests);
        $output['zahnstati'] = ZahnstatusResource::collection($hund->zahnstati);
        $output['patella'] = $hund->patella ? new PatellaResource($hund->patella) : [];
        $output['fcp'] = $hund->fcp ? new FCPResource($hund->fcp) : [];
        $output['hodenuntersuchungen'] = HodenResource::collection($hund->hodenuntersuchungen);
        $output['rute'] = $hund->rute ? new RuteResource($hund->rute) : [];
        $output['blutprobeneinlagerung'] = $hund->blutprobeneinlagerung ? new BlutprobeneinlagerungResource($hund->blutprobeneinlagerung) : [];
        $output['abstammungsnachweis'] = $hund->abstammungsnachweis ? new AbstammungsnachweisResource($hund->abstammungsnachweis) : [];
        $output['kardiobefunde'] = KardiobefundResource::collection($hund->kardiobefunde);
        $output['epilepsiebefunde'] = EpilepsiebefundResource::collection($hund->epilepsiebefunde);
        $output['ureter'] = $hund->ureter ? new UreterResource($hund->ureter) : [];
        $output['kaiserschnitte'] = KaiserschnittResource::collection($hund->kaiserschnitte);
        $output['kastrationsterilisation'] = $hund->kastrationsterilisation ? new KastrationSterilisationResource($hund->kastrationsterilisation) : [];

        // $output['gentests_rendered'] = GentestRenderedResource::collection($hund->gentests);
        // $output['augenuntersuchungen_rendered'] = AugenuntersuchungRenderedResource::collection($hund->augenuntersuchungen);
        // $output['zahnstati_rendered'] = ZahnstatusRenderedResource::collection($hund->zahnstati);
        // $output['ocduntersuchungen_rendered'] = OCDUntersuchungRenderedResource::collection($hund->ocduntersuchungen);
        // $output['patella_rendered'] = PatellaRenderedResource::collection($hund->patella);
        // $output['hdeduntersuchungen_rendered'] = HDEDUntersuchungRenderedResource::collection($hund->hdeduntersuchungen);

        return $output;

        // return HundResource::collection($hund);
    }

    public function getBereiche(Request $request, Hund $hund)
    {

        $bereiche = $request->input('bereiche');

        $url = Config::get('app.url');

        $output = [];

        //  $hund->load('chipnummern', 'ocduntersuchungen', 'augenuntersuchungen', 'notizen', 'dokumente', 'titel', 'titel.type', 'anwartschaften', 'patellauntersuchungen', 'hdeduntersuchungen', 'images', 'formwert', 'wesenstest',  'pruefungen','pruefungen.type', 'pruefungen.resultable','pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze','personen', 'gentests', 'zahnstati', 'hundefuehrers', 'wuerfe', 'wuerfe_r', 'wuerfe_h', 'meldungen', 'zwingers', 'zwingers.images', 'zwingers.personen', 'zwingers.rassen', 'zuchtverbote',  'zuchtverbote.entscheider', 'zuchtverbote.dokumente', 'zuchtzulassung', 'zuchtzulassungsantraege', 'zuchtzulassungsantraege.antragsteller', 'leistungshefte');

        // $hund->load('titel', 'titel.type',  'pruefungen','pruefungen.type', 'pruefungen.resultable','pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze', 'images');

        foreach ($bereiche as $bereich) {

            switch ($bereich) {
                case 'prerendered':
                    $output['prerendered'] = $this->getPrerenderedHund($hund->id);
                    break;
                case 'pruefungen':
                    $hund->load('pruefungen', 'pruefungen.type', 'pruefungen.resultable', 'pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze');
                    $output['pruefungen'] = PruefungResource::collection($hund->pruefungen);
                    break;
                case 'titels':
                    $output['titels'] = TitelResource::collection($hund->titel);
                    break;
                case 'meldungen':
                    // $hund->load('meldungen');
                    // $meldungen = $hund->meldungen()->with(['veranstaltung'])->get();
                    // $output['meldungen'] = $meldungen;
                    $output['meldungen'] = $hund->load(['meldungen', 'meldungen.veranstaltung', 'meldungen.veranstaltung.termine'])->meldungen;
                    break;
                case 'images':
                    $images = $hund->images;
                    $firstimg = count($images) ? $url . '/storage/' . $images[0]->path : '';
                    $hund['foto'] = $firstimg ? $firstimg : '';
                    $output['images'] = $images;
                    break;
                case 'ocduntersuchungen':
                    $output['ocduntersuchungen'] = OCDUntersuchungResource::collection($hund->ocduntersuchungen);
                    break;
                case 'augenuntersuchungen':
                    $output['augenuntersuchungen'] = AugenuntersuchungResource::collection($hund->augenuntersuchungen);
                    break;
                case 'hdeduntersuchungen':
                    $output['hdeduntersuchungen'] = HDEDUntersuchungResource::collection($hund->hdeduntersuchungen);
                    break;
                case 'gelenkuntersuchungen':
                    $output['gelenkuntersuchungen'] = GelenkuntersuchungResource::collection($hund->gelenkuntersuchungen);
                    break;
                case 'gentests':
                    $output['gentests'] = GentestResource::collection($hund->gentests);
                    break;
                case 'zahnstati':
                    $output['zahnstati'] = ZahnstatusResource::collection($hund->zahnstati);
                    break;
                case 'patella':
                    $output['patella'] = PatellaResource::collection($hund->patella);
                    break;
                case 'notizen':
                    $output['notizen'] = $hund->notizen;
                    break;
                case 'dokumente':
                    $output['dokumente'] = $hund->dokumente;
                    break;
                case 'anwartschaften':
                    $output['anwartschaften'] = $hund->anwartschaften;
                    break;
                case 'basisdaten':
                    $output['basisdaten'] = new HundBasisdatenResource($hund);
                    break;
                case 'eigentuemer':
                    $output['eigentuemer'] = $hund->personen;
                    break;
                case 'hundefuehrers':
                    $output['hundefuehrers'] = $hund->hundefuehrers;
                    break;
                case 'wuerfe':
                    $output['wuerfe'] = $hund->geschlecht_id == 2 ? $hund->wuerfe_r : $hund->wuerfe_h;
                    break;
                case 'wurfplaene':
                    $output['wurfplaene'] = $hund->wurfplaene;
                    break;
                case 'zuchtverbote':
                    $output['zuchtverbote'] = $hund->zuchtverbote;
                    break;
                case 'zwingers':
                    $output['zwingers'] = $hund->zwingers;
                    break;
                case 'zuchtzulassung':
                    $output['zuchtzulassung'] = $hund->zuchtzulassung;
                    break;
                case 'zuchtzulassungsantraege':
                    $output['zuchtzulassungsantraege'] = $hund->zuchtzulassungsantraege;
                    break;
                case 'ahnentafeln':
                    $output['ahnentafeln'] = $hund->ahnentafeln;
                    break;
                case 'leistungshefte':
                    $output['leistungshefte'] = $hund->leistungshefte;
                    break;
            }
        }

        $output['hund_id'] = $hund->id;

        return $output;
    }

    public function getBereich(Request $request)
    {

        $bereiche = $request->input('bereiche');

        $url = Config::get('app.url');

        $output = [];

        $string_bereiche = "'" . implode("','", $bereiche) . "'";

        $hund = Hund::with('titel', 'titel.type', 'pruefungen', 'pruefungen.type', 'pruefungen.resultable', 'pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze', 'images')->find($request->input('id'));

        $hund = Hund::find($request->input('id'));
        $hund->load('titel', 'titel.type', 'pruefungen', 'pruefungen.type', 'pruefungen.resultable', 'pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze', 'images');
        //  return $string_bereiche;

        return;

        // $hund->load('titel', 'titel.type', 'pruefungen', 'images');

        foreach ($bereiche as $bereich) {

            switch ($bereich) {
                case 'titels':
                    // $hund->load('titel', 'titel.type');
                    $output['titels'] = $hund->titel;
                    break;
                case 'pruefungen':
                    // $hund->load('pruefungen');
                    $output['pruefungen'] = PruefungResource::collection($hund->pruefungen);
                    break;
                case 'meldungen':
                    $hund->load('meldungen');
                    $meldungen = $hund->meldungen()->with(['veranstaltung'])->get();
                    $output['meldungen'] = $meldungen;
                    break;
                case 'images':
                    //  $hund->load('images');
                    $images = $hund->images;
                    $firstimg = count($images) ? $url . '/storage/' . $images[0]->path : '';
                    $hund['foto'] = $firstimg ? $firstimg : '';
                    $output['images'] = $images;
            }
        }

        $output['hund_id'] = $hund->id;

        return $output;

        $url = Config::get('app.url');

        $hund->load('chipnummern', 'ocduntersuchungen', 'augenuntersuchungen', 'notizen', 'dokumente', 'titel', 'titel.type', 'anwartschaften', 'patella', 'gelenkuntersuchungen', 'hdeduntersuchungen', 'images', 'formwert', 'wesenstest', 'pruefungen', 'pruefungen.type', 'pruefungen.resultable', 'pruefungen.type.classements', 'pruefungen.type.wertungen', 'pruefungen.type.ausrichters', 'pruefungen.type.zusaetze', 'personen', 'gentests', 'zahnstati', 'hundefuehrers', 'wuerfe', 'wuerfe_r', 'wuerfe_h', 'meldungen', 'zwingers', 'zwingers.images', 'zwingers.personen', 'zwingers.rassen', 'zuchtverbote', 'zuchtverbote.entscheider', 'zuchtverbote.dokumente', 'zuchtzulassung', 'zuchtzulassungsantraege', 'zuchtzulassungsantraege.antragsteller', 'leistungshefte');

        $images = $hund->images;
        $firstimg = count($images) ? $url . '/storage/' . $images[0]->path : '';
        $hund['foto'] = $firstimg ? $firstimg : '';

        $meldungen = $hund->meldungen()->with(['veranstaltung'])->get();

        $output = [];
        $output['ocduntersuchungen'] = OCDUntersuchungResource::collection($hund->ocduntersuchungen);
        $output['augenuntersuchungen'] = AugenuntersuchungResource::collection($hund->augenuntersuchungen);
        $output['hdeduntersuchungen'] = HDEDUntersuchungResource::collection($hund->hdeduntersuchungen);
        $output['gelenkuntersuchungen'] = GelenkuntersuchungResource::collection($hund->gelenkuntersuchungen);
        $output['gentests'] = GentestResource::collection($hund->gentests);
        $output['zahnstati'] = ZahnstatusResource::collection($hund->zahnstati);
        $output['patella'] = PatellaResource::collection($hund->patella);
        $output['notizen'] = $hund->notizen;
        $output['dokumente'] = $hund->dokumente;
        $output['pruefungen'] = PruefungResource::collection($hund->pruefungen);
        $output['titels'] = $hund->titel;
        $output['anwartschaften'] = $hund->anwartschaften;
        $output['images'] = $images;
        $output['hund_id'] = $hund->id;
        $output['basisdaten'] = new HundBasisdatenResource($hund);
        $output['meldungen'] = $meldungen;
        $output['eigentuemers'] = $hund->personen;
        $output['hundefuehrers'] = $hund->hundefuehrers;

        return $output;

        // return HundResource::collection($hund);
    }

    /**
     * Return a list of all persons, that are Eigentuemer of the given Hund.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEigentuemers(Request $request)
    {
        $hund_id = $request->route('hund_id');
        $personen_id = Eigentuemer::where('hund_id', $hund_id)->get()->pluck('person_id');
        $personen = Person::whereIn('id', $personen_id)->get();

        return $personen;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {

        $hund = Hund::with([
            'gutachten',
            'images',
            'formwert_tmp',
            'formwert',
            'wesenstest',
            'pruefungentitel',
            'pruefungen',
            'pruefungen.type',
            'pruefungen.resultable',
            'pruefungen.type.classements',
            'pruefungen.type.wertungen',
            'pruefungen.type.ausrichters',
            'pruefungen.type.zusaetze',
            'temptitel',
            'tpg',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'vater',
            'mutter',
            'zuchtbuchnummern',
            'chipnummern',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1');
            },
            'gelenkuntersuchungen' => function ($query) {
                $query->where('gelenkuntersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'zuchtbuchnummer', 'hunde.id')
            ->where('hunde.id', '=', $request->id)
            ->get();

        return new HundesucheResource($hund[0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function short(Request $request)
    {

        $id = $request->id;

        $hund = Hund::with([
            'gutachten',
            'images',
            'formwert',
            'dokumente',
            'wesenstest',
            'pruefungentitel',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1');
            },
            'gelenkuntersuchungen' => function ($query) {
                $query->where('gelenkuntersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'zuchtbuchnummer', 'hunde.id')
            ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
            ->where('hunde.id', '=', $id)
            ->get();

        return HundeShortResource::collection($hund);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function profildaten(Request $request)
    {

        $id = $request->id;

        $uebernahmeantrag = Uebernahmeantrag::where('hund_id', '=', $id)->orderBy('id', 'desc')->get();
        $zuchtzulassungsantrag = Zuchtzulassungsantrag::where('hund_id', '=', $id)->orderBy('id', 'desc')->get();
        $atzweitschiftantrag = Ahnentafel::where('hund_id', '=', $id)->whereIn('status_id', [1, 2])->orderBy('id', 'desc')->get();
        $leistungshefte = Leistungsheft::with('besteller', 'kommentare')->where('hund_id', '=', $id)->orderBy('id', 'asc')->get();

        $output = [];
        $output['leistungshefte'] = $leistungshefte;
        $output['uebernahmeantraege'] = $uebernahmeantrag;
        $output['zuchtzulassungsantraege'] = $zuchtzulassungsantrag;
        $output['atzweitschriftantraege'] = $atzweitschiftantrag;
        $output['profildaten'] = true;

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function load_anlegen(Hund $hund)
    {

        $hund->load('chipnummern', 'zuchtbuchnummern', 'dokumente', 'images', 'personen', 'vater', 'mutter', 'hundanlageantrag');

        //  $hund = Hund::with([
        //     'dokumente', 'personen', 'zwinger', 'zuechter', 'vater','mutter'
        //  ])->where('hunde.id', '=', $request->id)
        //    ->get();

        return new HundInitResource($hund);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

        if ($request->alter_min > 0) {
            $wurfdatum_min = Carbon::now()->subYears($request->alter_min)->format('Y-m-d');
        } else {
            $wurfdatum_min = '';
        }

        if ($request->alter_max > 0) {
            $wurfdatum_max = Carbon::now()->subYears($request->alter_max)->format('Y-m-d');
        } else {
            $wurfdatum_max = '';
        }

        $name = trim($request->name);
        $zuchtbuchnummer = trim($request->zuchtbuchnummer);
        $rasse_id = $request->rasse_id;
        $farbe_id = $request->farbe_id;
        // $farbe_id = 0;
        $geschlecht_id = $request->geschlecht_id;

        $auflagen = $request->auflagen;
        $zaehne = $request->zaehne;
        $gebiss = $request->gebiss;

        // HD
        $hd = is_object($request->hd) ? $request->hd : json_decode($request->hd);
        if ($hd != new stdClass()) {
            if (property_exists($hd, 'fci')) {
                $hd_fci = $hd->fci;
                $hd_drc = $hd->drc;
            } else {
                $hd_drc = null;
                $hd_fci = null;
            }
        } else {
            $hd_drc = null;
            $hd_fci = null;
            $hd_sonstige = null;
        }

        // ED
        $ed = is_object($request->ed) ? $request->ed : json_decode($request->ed);
        if ($ed != new stdClass()) {
            if (property_exists($ed, 'fci')) {
                $ed_fci = $ed->fci;
                $ed_drc = $ed->drc;
            } else {
                $ed_drc = null;
                $ed_fci = null;
            }
        } else {
            $ed_sonstige = null;
            $ed_drc = null;
            $ed_fci = null;
        }

        // AUGEN (IS OBJECT)
        $augen = is_object($request->augen) ? $request->augen : json_decode($request->augen);

        // GENTESTS (IS OBJECT)
        $gentests = is_object($request->gentests) ? $request->gentests : json_decode($request->gentests);

        // PRUEFUNGEN
        $pruefungen = is_array($request->pruefungen) ? $request->pruefungen : json_decode($request->pruefungen);

        $a_pruefungen = [];
        foreach ($pruefungen as $pruefung) {
            switch ($pruefung) {
                case 'jas':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%JAS%')->pluck('id');
                    $a_pruefungen[] = $pt; // [26,930];
                    break;
                case 'blp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%BLP%')->pluck('id');
                    $a_pruefungen[] = $pt; // [22,184,202,218,239,246,247,751,756,923];
                    break;
                case 'rgp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%RGP%')->pluck('id');
                    $a_pruefungen[] = $pt; //[28,185];
                    break;
                case 'pns':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%PNS%')->pluck('id');
                    $a_pruefungen[] = $pt; //[27,635,752];
                    break;
                case 'hpr':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%HP/R%')->pluck('id');
                    $a_pruefungen[] = $pt; // [24,935];
                    break;
                case 'hzp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%HZP%')->pluck('id');
                    $a_pruefungen[] = $pt; // [23,186,203,219,240,248,249,753,757,924];

                    break;
                case 'jep':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%JEP%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'vjp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%VJP%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'vswp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%VSwP%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'vgp':

                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%VGP%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'btr':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%Btr%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'wesenstest':
                    $pt = PruefungTyp::where('name', 'LIKE', '%Wesenstest%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'bhp':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%BHP%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'working':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%WT%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
                case 'apd':
                    $pt = PruefungTyp::where('name_kurz', 'LIKE', '%APD%')->pluck('id');
                    $a_pruefungen[] = $pt;
                    break;
            }
        }

        // TITELS
        $titels = is_array($request->titels) ? $request->titels : json_decode($request->titels);

        $a_titels = [];
        foreach ($titels as $titel) {
            switch ($titel) {
                //  ["dt_champion","vdh_champion","jugend_champion","dt_arbeitschampion","dt_jagdchampion","auslaendische"]
                case 'dt_champion':
                    $pt = TitelTyp::where('feldbezeichner', 'DT-CH')->pluck('id');
                    $a_titels[] = $pt; // [26,930];
                    break;
                case 'vdh_champion':
                    $pt = TitelTyp::where('feldbezeichner', 'VDH-CH')->pluck('id');
                    $a_titels[] = $pt; // [22,184,202,218,239,246,247,751,756,923];
                    break;
                case 'jugend_champion':
                    $pt = TitelTyp::where('feldbezeichner', 'JUGEND-CH')->pluck('id');
                    $a_titels[] = $pt; //[28,185];
                    break;
                case 'dt_arbeitschampion':
                    $pt = TitelTyp::where('kategorie', 'Arbeits-Champion Deutschland')->pluck('id');
                    $a_titels[] = $pt; //[27,635,752];
                    break;
                case 'dt_jagdchampion':
                    $pt = TitelTyp::where('kategorie', 'Jagd-Champion Deutschland')->pluck('id');
                    $a_titels[] = $pt; // [24,935];
                    break;
                case 'auslaendische':
                    $pt = TitelTyp::whereIn('feldbezeichner', ['INT1-CH', 'NAT-CH'])->pluck('id');
                    $a_titels[] = $pt; // [23,186,203,219,240,248,249,753,757,924];
                    break;
            }
        }

        $zuchttauglichkeit = $request->zuchttauglichkeit;

        $plz = $request->plz;
        $typ = $request->typ;
        $umkreis = $request->umkreis;
        $wuerfe = $request->wuerfe;
        $deckakte = $request->deckakte;

        $plzs = DB::select('SELECT dest.plz, ACOS(
                                 SIN(RADIANS(src.breitengrad)) * SIN(RADIANS(dest.breitengrad)) 
                                 + COS(RADIANS(src.breitengrad)) * COS(RADIANS(dest.breitengrad))
                                 * COS(RADIANS(src.laengengrad) - RADIANS(dest.laengengrad))
                           ) * 6380 AS distance
                           FROM postleitzahlen dest
                           CROSS JOIN postleitzahlen src
                           WHERE src.plz = ?
                           HAVING distance < ?
                           ORDER BY distance;', [$plz, $umkreis]);

        $plz_ids = [];
        foreach ($plzs as $plz) {
            $plz_ids[] = $plz->plz;
        }

        $count = Hund::leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
            ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
            ->leftjoin('zuchtbuchnummern', 'hunde.id', '=', 'zuchtbuchnummern.hund_id')
            ->when($zuchtbuchnummer != '', function ($query) use ($zuchtbuchnummer) {
                $zuchtbuchnummers = preg_split('/( |-|\/)/', $zuchtbuchnummer);
                foreach ($zuchtbuchnummers as $z) {
                    $query->where('zuchtbuchnummern.zuchtbuchnummer', 'LIKE', '%' . $z . '%');
                }
            })
            ->when($name != '', function ($query) use ($name) {
                $namen = explode(' ', $name);
                foreach ($namen as $n) {
                    $query->where('hunde.name', 'LIKE', '%' . $n . '%');
                }
            })
            ->when($typ == 2, function ($query) {
                return $query->where('zuchthund', '=', 1);
            })
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                return $query->where('rasse_id', '=', $rasse_id);
            })
            ->when($geschlecht_id != 0, function ($query) use ($geschlecht_id) {
                return $query->where('geschlecht_id', '=', $geschlecht_id);
            })
            ->when($farbe_id != 0, function ($query) use ($farbe_id) {
                return $query->where('farbe_id', '=', $farbe_id);
            })
            ->when($wurfdatum_min != '', function ($query) use ($wurfdatum_min) {
                return $query->whereDate('wurfdatum', '<=', $wurfdatum_min);
            })
            ->when($wurfdatum_max != '', function ($query) use ($wurfdatum_max) {
                return $query->whereDate('wurfdatum', '>=', $wurfdatum_max);
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                return $query->whereHas('personen', function ($query) use ($plz_ids) {
                    $query->whereIn('postleitzahl', $plz_ids);
                });
            })
            ->when(count($a_pruefungen), function ($query) use ($a_pruefungen) {
                foreach ($a_pruefungen as $pruefung) {
                    $query->whereHas('pruefungen', function ($query) use ($pruefung) {
                        $query->whereIn('pruefungen.type_id', $pruefung);
                    });
                }
            })
            ->when(count($a_titels), function ($query) use ($a_titels) {
                foreach ($a_titels as $titel) {
                    $query->whereHas('titel', function ($query) use ($titel) {
                        $query->whereIn('titels.type_id', $titel);
                    });
                }
            })
            ->when($gentests != new stdClass(), function ($query) use ($gentests) {
                foreach ($gentests as $key => $value) {
                    $query->whereHas('gentests', function ($query) use ($key, $value) {
                        $query->whereIn('gentests.' . $key, $value);
                    });
                }
            })
            ->when($augen != new stdClass(), function ($query) use ($augen) {
                foreach ($augen as $key => $value) {
                    $query->whereHas('augenuntersuchungen', function ($query) use ($key, $value) {
                        if (is_array($value)) {
                            $query->whereIn('augenuntersuchungen.' . $key, $value);
                        } else {
                            $query->where('augenuntersuchungen.' . $key, '=', $value);
                        }
                    });
                }
            })
            ->when(($hd_drc), function ($query) use ($hd_drc, $hd_fci) {
                $query->whereHas('gelenkuntersuchungen', function ($query) use ($hd_drc, $hd_fci) {

                    $query->where(function ($q) use ($hd_drc) {
                        $q->where('gelenkuntersuchungen.hd_scoretyp_id', 1)->whereIn('gelenkuntersuchungen.hd_score_id', $hd_drc);
                    });
                    $query->orWhere(function ($q) use ($hd_fci) {
                        $q->where('gelenkuntersuchungen.hd_scoretyp_id', 2)->whereIn('gelenkuntersuchungen.hd_score_id', $hd_fci);
                    });
                });
            })
            ->when(($ed_drc), function ($query) use ($ed_drc, $ed_fci) {
                $query->whereHas('gelenkuntersuchungen', function ($query) use ($ed_drc, $ed_fci) {
                    $query->where(function ($q) use ($ed_drc) {
                        $q->where('gelenkuntersuchungen.ed_scoretyp_id', 1)->whereIn('gelenkuntersuchungen.ed_score_id', $ed_drc);
                    });
                    $query->orWhere(function ($q) use ($ed_fci) {
                        $q->where('gelenkuntersuchungen.ed_scoretyp_id', 2)->whereIn('gelenkuntersuchungen.ed_score_id', $ed_fci);
                    });
                });
            })
            ->count();

        if ($count > 100) {

            return [
                'pruefungen' => [],
                'hunde' => [],
                'ergebnisliste' => [],
                'anzahl' => 0,
                'message' => [
                    'type' => 'success',
                    'text' => $count . ' Hunde gefunden. Bitte grenzen Sie die Suche weiter ein.',
                ],
            ];
        }

        $hunde = Hund::with([
            'gutachten',
            'formwert_tmp',
            'formwert',
            'wesenstest',
            'pruefungentitel',
            'temptitel',
            'tpg',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'gelenkuntersuchungen' => function ($query) {
                $query->where('gelenkuntersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'farben.name AS farbe_name', 'rassen.name AS rasse_name', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
            ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
            ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
            ->leftjoin('zuchtbuchnummern', 'hunde.id', '=', 'zuchtbuchnummern.hund_id')
            ->when($zuchtbuchnummer != '', function ($query) use ($zuchtbuchnummer) {
                $zuchtbuchnummers = preg_split('/( |-|\/)/', $zuchtbuchnummer);
                foreach ($zuchtbuchnummers as $z) {
                    $query->where('zuchtbuchnummern.zuchtbuchnummer', 'LIKE', '%' . $z . '%');
                }
            })
            ->when($name != '', function ($query) use ($name) {
                $namen = explode(' ', $name);
                foreach ($namen as $n) {
                    $query->where('hunde.name', 'LIKE', '%' . $n . '%');
                }
            })
            ->when($typ == 2, function ($query) {
                return $query->where('zuchthund', '=', 1);
            })
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                return $query->where('rasse_id', '=', $rasse_id);
            })
            ->when($geschlecht_id != 0, function ($query) use ($geschlecht_id) {
                return $query->where('geschlecht_id', '=', $geschlecht_id);
            })
            ->when($farbe_id != 0, function ($query) use ($farbe_id) {
                return $query->where('farbe_id', '=', $farbe_id);
            })
            ->when($wurfdatum_min != '', function ($query) use ($wurfdatum_min) {
                return $query->whereDate('wurfdatum', '<=', $wurfdatum_min);
            })
            ->when($wurfdatum_max != '', function ($query) use ($wurfdatum_max) {
                return $query->whereDate('wurfdatum', '>=', $wurfdatum_max);
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                return $query->whereHas('personen', function ($query) use ($plz_ids) {
                    $query->whereIn('postleitzahl', $plz_ids);
                });
            })
            ->when(count($a_pruefungen), function ($query) use ($a_pruefungen) {
                foreach ($a_pruefungen as $pruefung) {
                    $query->whereHas('pruefungen', function ($query) use ($pruefung) {
                        $query->whereIn('pruefungen.type_id', $pruefung);
                    });
                }
            })
            ->when(count($a_titels), function ($query) use ($a_titels) {
                foreach ($a_titels as $titel) {
                    $query->whereHas('titel', function ($query) use ($titel) {
                        $query->whereIn('titels.type_id', $titel);
                    });
                }
            })
            ->when($gentests != new stdClass(), function ($query) use ($gentests) {
                foreach ($gentests as $key => $value) {
                    $query->whereHas('gentests', function ($query) use ($key, $value) {
                        $query->whereIn('gentests.' . $key, $value);
                    });
                }
            })
            ->when($augen != new stdClass(), function ($query) use ($augen) {
                foreach ($augen as $key => $value) {
                    $query->whereHas('augenuntersuchungen', function ($query) use ($key, $value) {
                        if (is_array($value)) {
                            $query->whereIn('augenuntersuchungen.' . $key, $value);
                        } else {
                            $query->where('augenuntersuchungen.' . $key, '=', $value);
                        }
                    });
                }
            })
            ->when(($hd_drc), function ($query) use ($hd_drc, $hd_fci) {
                $query->whereHas('gelenkuntersuchungen', function ($query) use ($hd_drc, $hd_fci) {

                    $query->where(function ($q) use ($hd_drc) {
                        $q->where('gelenkuntersuchungen.hd_scoretyp_id', 1)->whereIn('gelenkuntersuchungen.hd_score_id', $hd_drc);
                    });
                    $query->orWhere(function ($q) use ($hd_fci) {
                        $q->where('gelenkuntersuchungen.hd_scoretyp_id', 2)->whereIn('gelenkuntersuchungen.hd_score_id', $hd_fci);
                    });
                });
            })
            ->when(($ed_drc), function ($query) use ($ed_drc, $ed_fci) {
                $query->whereHas('gelenkuntersuchungen', function ($query) use ($ed_drc, $ed_fci) {
                    $query->where(function ($q) use ($ed_drc) {
                        $q->where('gelenkuntersuchungen.ed_scoretyp_id', 1)->whereIn('gelenkuntersuchungen.ed_score_id', $ed_drc);
                    });
                    $query->orWhere(function ($q) use ($ed_fci) {
                        $q->where('gelenkuntersuchungen.ed_scoretyp_id', 2)->whereIn('gelenkuntersuchungen.ed_score_id', $ed_fci);
                    });
                });
            })
            ->limit(100)->groupBy('id')->orderBy('hunde.name')->get();

        //  ->paginate(100);
        // 'zahnstati' => function ($query) {
        //    $query->where('zahnstati.aktiv', '=', '1');
        // },
        // 'hdeduntersuchungen' => function ($query) {
        //    $query->where('hded_untersuchungen.aktiv', '=', '1');
        // },
        // 'ocduntersuchungen' => function ($query) {
        //    $query->where('ocd_untersuchungen.aktiv', '=', '1');
        // },
        // 'augenuntersuchungen' => function ($query) {
        //    $query->where('augenuntersuchungen.aktive_au', '=', '1');
        // },

        // $url = Config::get('app.url');

        // return $hunde;

        $success = count($hunde) ? (count($hunde) == 1 ? 'Ein Hund gefunden' : count($hunde) . ' Hunde gefunden') : 'Kein Hund gefunden';

        return [
            'pruefungen' => $pruefungen,
            'hunde' => $hunde,
            'ergebnisliste' => HundesucheResource::collection($hunde),
            'anzahl' => count($hunde),
            'message' => [
                'type' => 'success',
                'text' => $success,
            ],
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function auto(Request $request)
    {
        $filters = ($request->filters) ? $request->filters : [];
        $search = $request->suche;
        $main = $request->main;
        $param = ['db_field' => $main];

        $hunde = Hund::where(function ($query) use ($main, $search) {
            $query->where($main, 'like', $search . '%')->orWhere($main, 'like', '% ' . $search . '%');
        })
            ->where(function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    $query->where($filter['db_field'], '=', $filter['filter']);
                }
            })
            ->limit(250)->orderBy($main, 'desc')->get();

        switch ($main) {
            case 'zuchtbuchnummer':
                return OptionZBNrResource::collection($hunde);
            case 'name':
            case 'default':
                return OptionNameResource::collection($hunde);
        }

        return OptionNameResource::collection($hunde);
    }

    public function autocomplete(Request $request)
    {
        $rasse_id = $request->rid;
        $zuchtbuchnummer = trim($request->zuchtbuchnummer);
        if (str_contains($zuchtbuchnummer, 'DRC-B')) {
            $rasse_id = 1;
        }
        if (str_contains($zuchtbuchnummer, 'DRC-C')) {
            $rasse_id = 2;
        }
        if (str_contains($zuchtbuchnummer, 'DRC-F')) {
            $rasse_id = 3;
        }
        if (str_contains($zuchtbuchnummer, 'DRC-G')) {
            $rasse_id = 4;
        }
        if (str_contains($zuchtbuchnummer, 'DRC-L')) {
            $rasse_id = 5;
        }
        if (str_contains($zuchtbuchnummer, 'DRC-T')) {
            $rasse_id = 6;
        }

        $zuchtbuchnummer = preg_replace('/(DRC-)[BCFGLT]( ){0,1}/', '', $zuchtbuchnummer);
        $zuchtbuchnummer = preg_replace('/(DRC )/', '', $zuchtbuchnummer);
        $zuchtbuchnummer = preg_replace('/( DRC)/', '', $zuchtbuchnummer);
        $zuchtbuchnummer = preg_replace('/(VDH\/DRC)/', '', $zuchtbuchnummer);
        $name = trim($request->name);

        $geschlecht_id = $request->gid;
        $complete = $request->c;
        $main = $request->m;
        $person_id = $request->pid;
        $zwinger_id = $request->zid;
        $hund_id = $request->hid;
        $rasse_ids = $request->rids;
        $omit_hunde_ids = $request->omitdids;

        $count = Hund::when($person_id != 0, function ($query) use ($person_id) {
            return $query->join('hund_person', 'hund_person.hund_id', '=', 'hunde.id')->where('hund_person.person_id', '=', $person_id);
        })
            ->when($zwinger_id != 0, function ($query) use ($zwinger_id) {
                return $query->join('hund_zwinger', 'hund_zwinger.hund_id', '=', 'hunde.id')->where('hund_zwinger.zwinger_id', '=', $zwinger_id);
            })
            ->when($rasse_ids != null, function ($query) use ($rasse_ids) {
                return $query->whereIn('hunde.rasse_id', $rasse_ids);
            })
            ->when($zuchtbuchnummer != '', function ($query) use ($zuchtbuchnummer) {
                $query->join('zuchtbuchnummern', 'hunde.id', '=', 'zuchtbuchnummern.hund_id');
                $zuchtbuchnummers = preg_split('/( |-|\/)/', $zuchtbuchnummer);
                foreach ($zuchtbuchnummers as $z) {
                    $query->where('zuchtbuchnummern.zuchtbuchnummer', 'LIKE', '%' . $z . '%');
                }
            })
            ->when($name != '', function ($query) use ($name) {
                $namen = explode(' ', $name);
                foreach ($namen as $n) {
                    $query->where('hunde.name', 'LIKE', '%' . $n . '%');
                }
            })
            ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                return $query->where('rasse_id', '=', $rasse_id);
            })
            ->when($geschlecht_id != 0, function ($query) use ($geschlecht_id) {
                return $query->where('geschlecht_id', '=', $geschlecht_id);
            })
            ->when(! empty($omit_hunde_ids), function ($query) use ($omit_hunde_ids) {
                return $query->whereNotIn('hunde.id', $omit_hunde_ids);
            })
            ->where('hunde.freigabe', '=', 1)
            ->where('hunde.aktiv', '=', 1)
            ->count();

        if ($count <= 100) {
            $complete = true;
            $hunde = Hund::select('hunde.name', 'zuchtbuchnummern.zuchtbuchnummer', 'farben.name AS farbe_name', 'rassen.name AS rasse_name', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
                ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
                ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
                ->leftjoin('zuchtbuchnummern', 'hunde.id', '=', 'zuchtbuchnummern.hund_id')
                ->when($rasse_ids != null, function ($query) use ($rasse_ids) {
                    return $query->whereIn('hunde.rasse_id', $rasse_ids);
                })
                ->when($zuchtbuchnummer != '', function ($query) use ($zuchtbuchnummer) {
                    $query->where('zuchtbuchnummern.zuchtbuchnummer', 'LIKE', '%' . $zuchtbuchnummer . '%');
                })
                ->when($name != '', function ($query) use ($name) {
                    $namen = explode(' ', $name);
                    foreach ($namen as $n) {
                        $query->where('hunde.name', 'LIKE', '%' . $n . '%');
                    }
                })
                ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                    return $query->where('rasse_id', '=', $rasse_id);
                })
                ->when($geschlecht_id != 0, function ($query) use ($geschlecht_id) {
                    return $query->where('geschlecht_id', '=', $geschlecht_id);
                })
                ->when($person_id != 0, function ($query) use ($person_id) {
                    return $query->join('hund_person', 'hund_person.hund_id', '=', 'hunde.id')->where('hund_person.person_id', '=', $person_id);
                })
                ->when($zwinger_id != 0, function ($query) use ($zwinger_id) {
                    return $query->join('hund_zwinger', 'hund_zwinger.hund_id', '=', 'hunde.id')->where('hund_zwinger.zwinger_id', '=', $zwinger_id);
                })
                ->when(! empty($omit_hunde_ids), function ($query) use ($omit_hunde_ids) {
                    return $query->whereNotIn('hunde.id', $omit_hunde_ids);
                })
                ->where('hunde.freigabe', '=', 1)
                ->where('hunde.aktiv', '=', 1)
                ->limit(100)
                ->orderBy('hunde.name', 'asc')
                ->groupBy('hunde.name')
                ->get();
        } elseif ($count <= 999) {
            $complete = false;
            $hunde = Hund::when($rasse_ids != null, function ($query) use ($rasse_ids) {
                return $query->whereIn('hunde.rasse_id', $rasse_ids);
            })
                ->when($zuchtbuchnummer != '', function ($query) use ($zuchtbuchnummer) {
                    $query->leftjoin('zuchtbuchnummern', 'hunde.id', '=', 'zuchtbuchnummern.hund_id');
                    $zuchtbuchnummers = preg_split('/( |-|\/)/', $zuchtbuchnummer);
                    foreach ($zuchtbuchnummers as $z) {
                        $query->where('zuchtbuchnummern.zuchtbuchnummer', 'LIKE', '%' . $z . '%');
                    }
                })
                ->when($name != '', function ($query) use ($name) {
                    $namen = explode(' ', $name);
                    foreach ($namen as $n) {
                        $query->where('hunde.name', 'LIKE', '%' . $n . '%');
                    }
                })
                ->when($rasse_id != 0, function ($query) use ($rasse_id) {
                    return $query->where('rasse_id', '=', $rasse_id);
                })
                ->when($geschlecht_id != 0, function ($query) use ($geschlecht_id) {
                    return $query->where('geschlecht_id', '=', $geschlecht_id);
                })
                ->when($person_id != 0, function ($query) use ($person_id) {
                    return $query->join('hund_person', 'hund_person.hund_id', '=', 'hunde.id')->where('hund_person.person_id', '=', $person_id);
                })
                ->when($zwinger_id != 0, function ($query) use ($zwinger_id) {
                    return $query->join('hund_zwinger', 'hund_zwinger.hund_id', '=', 'hunde.id')->where('hund_zwinger.zwinger_id', '=', $zwinger_id);
                })
                ->when(! empty($omit_hunde_ids), function ($query) use ($omit_hunde_ids) {
                    return $query->whereNotIn('hunde.id', $omit_hunde_ids);
                })
                ->where('hunde.freigabe', '=', 1)
                ->where('hunde.aktiv', '=', 1)
                ->limit(200)->orderBy($main, 'asc')->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci')->pluck($main);
        } else {
            $hunde = [];
            $complete = false;
        }

        return [
            'complete' => $complete,
            'hunde' => $count,
            'result' => $hunde,
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function auto_matching_deckrueden(Request $request)
    {
        $huendin = Hund::find($request->id);
        $search = $request->suche;
        $main = $request->main;

        $hunde = Hund::where(function ($query) use ($main, $search) {
            $query->where($main, 'like', $search . '%')->orWhere($main, 'like', '% ' . $search . '%');
        })
            ->where('rasse_id', '=', $huendin->rasse_id)
            ->where('geschlecht_id', '=', 2)
            ->limit(250)->orderBy($main, 'desc')->get();

        switch ($main) {
            case 'zuchtbuchnummer':
                return OptionZBNrResource::collection($hunde);
            case 'name':
            case 'default':
                return OptionNameResource::collection($hunde);
        }

        return OptionNameResource::collection($hunde);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return $request;

        $freigabe = 0;
        $aktiv = 0;
        $freigabe_id = 0;

        if ($request->hund['id'] == 0) {
        }

        $user_id = Auth::id();

        $hund = new Hund();
        $hund->aktiv = $aktiv;
        $hund->freigabe = $freigabe;
        $hund->freigabe_id = $freigabe_id;

        $hund->name = $request->hund['name'];

        $hund->chipnummer = $request->hund['chipnummer'];
        $hund->drc_gstb_nr = $request->hund['drc_gstb_nr'];
        $hund->gstb_nr = $request->hund['gstb_nr'];

        $hund->farbe_id = $request->hund['farbe']['id'];
        // $hund->farbe_name = $request->hund['farbe']['name'];
        $hund->geschlecht_id = $request->hund['geschlecht']['id'];
        // $hund->geschlecht_name = $request->hund['geschlecht']['name'];
        $hund->rasse_id = $request->hund['rasse']['id'];
        // $hund->rasse_name = $request->hund['rasse']['name'];

        $hund->mutter_id = $request->hund['mutter_id'];
        $hund->mutter_name = $request->hund['mutter_name'];
        $hund->mutter_zuchtbuchnummer = $request->hund['mutter_zuchtbuchnummer'];

        $hund->rasse_id = $request->hund['rasse']['id'];

        $hund->vater_id = $request->hund['vater_id'];
        $hund->vater_name = $request->hund['vater_name'];
        $hund->vater_zuchtbuchnummer = $request->hund['vater_zuchtbuchnummer'];
        $hund->wurfdatum = $request->hund['wurfdatum'];
        // $hund->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
        // $hund->zuchthund = $request->hund['zuchthund'];
        $hund->zuechter_nachname = $request->hund['zuechter']['nachname'];
        $hund->zuechter_vorname = $request->hund['zuechter']['vorname'];
        // $hund->zwinger_land = $request->hund['zwinger']['land'];
        $hund->zwinger_ort = $request->hund['zwinger']['ort'];
        $hund->zwinger_plz = $request->hund['zwinger']['postleitzahl'];
        $hund->zwinger_strasse = $request->hund['zwinger']['strasse'];
        $hund->created_id = $user_id;
        $hund->freigabe_id = $freigabe_id;
        $hund->save();

        $zuchtbuchnummer = new Zuchtbuchnummer();
        $zuchtbuchnummer->zuchtbuchnummer = $request->hund['chipnummer'];
        $zuchtbuchnummer->order = 1;
        $hund->zuchtbuchnummern()->save($zuchtbuchnummer);

        $chipnummer = new Chipnummer();
        $chipnummer->chipnummer = $request->hund['chipnummer'];
        $chipnummer->order = 1;
        $hund->chipnummern()->save($chipnummer);

        if ($request->hund['zuechter']['id'] == 0) {

            $hund->zuechter_vorname = $request->hund['zuechter']['vorname'];
            $hund->zuechter_nachname = $request->hund['zuechter']['nachname'];
            $hund->zuechter_id = $request->hund['zuechter']['id'];
        }

        if ($request->hund['zwinger']['id'] == 0) {

            $hund->zwinger_name = $request->hund['zwinger']['name'];
            $hund->zwinger_id = $request->hund['zwinger']['id'];
            $hund->zwinger_strasse = $request->hund['zwinger']['strasse'];
            $hund->zwinger_plz = $request->hund['zwinger']['postleitzahl'];
            $hund->zwinger_ort = $request->hund['zwinger']['ort'];
            $hund->zwinger_telefon = $request->hund['zwinger']['telefon_1'];
            $hund->zwinger_fci = $request->hund['zwinger']['fcinummer'];
        }

        foreach ($request->hund['eigentuemers'] as $eigentuemer) {

            if ($eigentuemer['id'] != 0) {

                $person = Person::find($eigentuemer['id']);
                $hund->personen()->save($person);
            }
        }
        $hund->save();

        $hund2 = Hund::with([
            'images',
            'farbe',
            'rasse',
            'geschlecht',
            'formwert',
            'dokumente',
            'wesenstest',
            'pruefungentitel',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'gelenkuntersuchungen' => function ($query) {
                $query->where('gelenkuntersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'zuchtbuchnummer', 'optionen_geschlecht_hund.name AS geschlecht', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
            ->leftjoin('optionen_geschlecht_hund', 'geschlecht_id', '=', 'optionen_geschlecht_hund.id')
            ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
            ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
            ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
            ->find($hund->id);

        return new HundeShortResource($hund2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dokumente:  {allgemein: [], titel: [], gesundheit: [], pruefungen: []}
        // pruefungenselect: []
        // pruefungentitel:[]
        // mutter: {zuchtbuchnummer: "", name: "", id: 0}
        // vater: {zuchtbuchnummer: "", name: "", id: 0}
        // farbe: {id: 0, name: "Bitte auswählen"}
        // rasse: {id: 0, name: "Bitte auswählen"}
        // zuchttauglichkeit: {id: 0, name: "Bitte auswählen"}

        $freigabe = 0;
        $aktiv = 0;
        $freigabe_id = 0;

        if ($request->hund['id'] == 0) {
        }

        $user_id = Auth::id();
        // $user = User::find($user_id);
        // $person = Person::find($user->person_id);

        $hund = new Hund();
        $hund->aktiv = $aktiv;
        $hund->freigabe = $freigabe;
        $hund->freigabe_id = $freigabe_id;
        //   $hund->bemerkung = $request->hund['bemerkung'];
        //   $hund->bestaetigung = $request->hund['bestaetigung'];
        $hund->chipnummer = $request->hund['chipnummer'];
        // $hund->chipnummer = $request->hund['chipnummer'];
        $hund->drc_gstb_nr = $request->hund['drc_gstb_nr'];
        $hund->farbe_id = $request->hund['farbe']['id'];
        //  $hund->farbe_name = $request->hund['farbe']['name'];
        // $hund->freigabe = $freigabe;
        $hund->geschlecht_id = $request->hund['geschlecht']['id'];
        //   $hund->geschlecht_name = $request->hund['geschlecht']['name'];
        $hund->gstb_nr = $request->hund['gstb_nr'];

        // $hund->interne_vermerke = $request->hund['interne_vermerke'];
        $hund->mutter_id = $request->hund['mutter_id'];
        $hund->mutter_name = $request->hund['mutter_name'];
        $hund->mutter_zuchtbuchnummer = $request->hund['mutter_zuchtbuchnummer'];
        $hund->name = $request->hund['name'];
        $hund->rasse_id = $request->hund['rasse']['id'];
        //   $hund->rasse_name = $request->hund['rasse']['name'];
        $hund->vater_id = $request->hund['vater_id'];
        $hund->vater_name = $request->hund['vater_name'];
        $hund->vater_zuchtbuchnummer = $request->hund['vater_zuchtbuchnummer'];
        $hund->wurfdatum = $request->hund['wurfdatum'];
        // $hund->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
        // $hund->zuchthund = $request->hund['zuchthund'];
        $hund->zuechter_nachname = $request->hund['zuechter']['nachname'];
        $hund->zuechter_vorname = $request->hund['zuechter']['vorname'];
        // $hund->zwinger_land = $request->hund['zwinger']['land'];
        $hund->zwinger_ort = $request->hund['zwinger']['ort'];
        $hund->zwinger_plz = $request->hund['zwinger']['postleitzahl'];
        $hund->zwinger_strasse = $request->hund['zwinger']['strasse'];
        $hund->created_id = $user_id;
        $hund->freigabe_id = $freigabe_id;
        $hund->save();

        $zuchtbuchnummer = new Zuchtbuchnummer();
        $zuchtbuchnummer->zuchtbuchnummer = $request->hund['zuchtbuchnummer'];
        $zuchtbuchnummer->order = 1;

        $hund->zuchtbuchnummern()->save($zuchtbuchnummer);

        if ($request->hund['zuechter']['id'] == 0) {

            $hund->zuechter_vorname = $request->hund['zuechter']['vorname'];
            $hund->zuechter_nachname = $request->hund['zuechter']['nachname'];
            $hund->zuechter_id = $request->hund['zuechter']['id'];
        } else {
            // PRUEFE
            // zuechter {
            //    adresszusatz
            //    anrede
            //    email_1
            //    email_2
            //    id
            //    land
            //    mitgliedsnummer
            //    nachname
            //    ort
            //    postleitzahl
            //    strasse
            //    telefon_1
            //    telefon_2
            //    vorname
            // }
        }

        if ($request->hund['zwinger']['id'] == 0) {

            $hund->zwinger_name = $request->hund['zwinger']['name'];
            $hund->zwinger_id = $request->hund['zwinger']['id'];
            $hund->zwinger_strasse = $request->hund['zwinger']['strasse'];
            $hund->zwinger_plz = $request->hund['zwinger']['postleitzahl'];
            $hund->zwinger_ort = $request->hund['zwinger']['ort'];
            $hund->zwinger_telefon = $request->hund['zwinger']['telefon_1'];
            $hund->zwinger_fci = $request->hund['zwinger']['fcinummer'];
        } else {
            // zwinger {
            //    adresszusatz
            //    email_1
            //    email_2
            //    fcinummer
            //    gemeinschaft
            //    id
            //    land
            //    ort
            //    postleitzahl
            //    strasse
            //    telefon_1
            //    telefon_2
            //    website_1
            //    website_2
            //    zwingername
            //    zwingernummer
            // }

        }

        foreach ($request->hund['eigentuemers'] as $eigentuemer) {

            if ($eigentuemer['id'] != 0) {

                $person = Person::find($eigentuemer['id']);
                $hund->personen()->save($person);
            } else {
                // eigentuemers: {
                //    adresszusatz
                //    anrede
                //    email_1
                //    email_2
                //    id
                //    land
                //    mitgliedsnummer
                //    nachname
                //    ort
                //    postleitzahl
                //    strasse
                //    telefon_1
                //    telefon_2
                //    vorname
                // }
            }
        }
        $hund->save();

        $hund2 = Hund::with([
            'images',
            'farbe',
            'rasse',
            'formwert',
            'dokumente',
            'wesenstest',
            'pruefungentitel',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'gelenkuntersuchungen' => function ($query) {
                $query->where('gelenkuntersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'zuchtbuchnummer', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
            ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
            ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
            ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
            ->find($hund->id);

        return new HundeShortResource($hund2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function hund_update(UpdateHundRequest $request, Hund $hund)
    {

        $validated = $request->validated();

        $update = $request->all();

        if (1) {

            $hund->name = $update['name'];
            $hund->rasse_id = $update['rasse']['id'];
            $hund->farbe_id = $update['farbe']['id'];
            $hund->zuchtbuchnummer = $update['zuchtbuchnummer'];
            $hund->wurfdatum = $update['wurfdatum'];
            $hund->chipnummer = $update['chipnummer'];
            $hund->geschlecht_id = $update['geschlecht']['id'];
            $hund->vater_zuchtbuchnummer = $update['vater_zuchtbuchnummer'];
            $hund->mutter_zuchtbuchnummer = $update['mutter_zuchtbuchnummer'];
            $hund->zuchthund = $update['zuchthund'];
            $hund->zwinger_nr = $update['zwinger_nr'];
            $hund->mutter_name = $update['mutter_name'];
            $hund->vater_name = $update['vater_name'];
            $hund->zwinger_name = $update['zwinger_name'];
            $hund->zwinger_strasse = $update['zwinger_strasse'];
            $hund->zwinger_plz = $update['zwinger_plz'];
            $hund->zwinger_ort = $update['zwinger_ort'];
            $hund->zwinger_fci = $update['zwinger_fci'];
            $hund->zwinger_nr = $update['zwinger_nr'];
            $hund->bemerkung = $update['bemerkung'];
            $hund->save();

            return $hund;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function hunde_update(Request $request)
    {
        // Validatierung
        // http://laravel.com/docs/validation

        $ids = [];

        foreach ($request->all() as $update) {
            //      // $validated = $request->validated();
            //      if (1) {

            $hund = Hund::find($update['id']);
            $hund->name = $update['name'];
            $hund->rasse_id = $update['rasse']['id'];
            $hund->farbe_id = $update['farbe']['id'];
            $hund->zuchtbuchnummer = $update['zuchtbuchnummer'];
            $hund->wurfdatum = $update['wurfdatum'];
            $hund->chipnummer = $update['chipnummer'];
            $hund->geschlecht_id = $update['geschlecht']['id'];
            $hund->vater_zuchtbuchnummer = $update['vater_zuchtbuchnummer'];
            $hund->mutter_zuchtbuchnummer = $update['mutter_zuchtbuchnummer'];
            $hund->zuchthund = $update['zuchthund'];
            $hund->zwinger_nr = $update['zwinger_nr'];
            $hund->mutter_name = $update['mutter_name'];
            $hund->vater_name = $update['vater_name'];
            $hund->zwinger_name = $update['zwinger_name'];
            $hund->zwinger_strasse = $update['zwinger_strasse'];
            $hund->zwinger_plz = $update['zwinger_plz'];
            $hund->zwinger_ort = $update['zwinger_ort'];
            $hund->zwinger_fci = $update['zwinger_fci'];
            $hund->zwinger_nr = $update['zwinger_nr'];
            $hund->bemerkung = $update['bemerkung'];
            if ($hund->save()) {
                $ids[] = $hund->id;
            }
        }
        //  }

        return $ids;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hund $hund)
    {
        //
    }
}
