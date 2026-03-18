<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\HundeShortResource;
use App\Http\Resources\OptionResource;
use App\Http\Resources\PersonResource;
use App\Models\Hund;
use App\Models\Hundanlageantrag;
use App\Models\Mitglied;
use App\Models\OptionAdelstitel;
use App\Models\OptionAkademischerTitel;
use App\Models\OrgatreeItem;
use App\Models\Person;
use App\Models\User;
use App\Traits\CheckActiveOwnership;
use App\Traits\GetPrerenderedHund;
use App\Traits\PrerenderHund;
use Bouncer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    use CheckActiveOwnership;
    use GetPrerenderedHund;
    use PrerenderHund;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $personen = Person::where(function ($query) use ($columns) {
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
                            $query->where(function ($q) use ($table, $column) {
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

        return PersonResource::collection($personen);
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
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function hunde($id)
    {

        $hunde = Person::find($id)->hunde;

        return $hunde;

        //  return PersonResource::collection( $personen);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function zuchthunde($id)
    {

        $hunde = Person::find($id)->hunde;

        foreach ($hunde as $hund) {
            $hund->wesenstest;
            $hund->gutachten;
        }

        return $hunde;
        //  return PersonResource::collection( $personen);
    }

    public function zwinger($id)
    {

        $zwinger = Person::find($id)->zwinger;

        // $zwinger->rassen->wi;

        return $zwinger;

        //  return PersonResource::collection( $personen);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function person()
    {

        $caching = 0;

        $url = Config::get('app.url');

        $id = Auth::id();

        if (! $id) {
            return;
        }

        cache()->forget('userdata' . $id);
        cache()->forget('hundedata' . $id);

        $person = User::find($id)->person;

        $user = User::with(['person', 'person.mitglied', 'person.zwingers', 'person.funktionen', 'person.dokumente', 'person.listen', 'person.veranstaltungen', 'person.rechnungen', 'offeneAufgaben', 'offeneAufgaben.template', 'offeneAufgaben.template.section'])->find($id);

        // REMOVED: Automatic create-hund ability assignment
        // This was creating unwanted abilities with NULL entity_type
        // Bouncer::allow($user)->to('create-hund');

        // if (!$caching) {
        //    $user = User::with(['person', 'person.mitglied', 'person.zwinger', 'person.funktionen', 'person.dokumente', 'person.listen'])->find($id);
        // } else {
        //    $user = cache()->remember('userdata' . $id, 60 * 60 * 24, function () use ($id) {
        //       return User::with([
        //          'person',
        //          'person.mitglied',
        //          'person.mitglied.landesgruppe',
        //          'person.mitglied.bezirksgruppe',
        //          'person.zwinger',
        //          'person.funktionen',
        //          'person.dokumente',
        //          'person.listen',
        //          // 'person.hunde'
        //       ])->find($id);
        //    });
        // }

        $hunde2 = Hund::with([
            'images',
            'formwert',
            'geschlecht',
            'dokumente',
            'vater',
            'mutter',
            'wesenstest',
            'hundanlageantrag',
            'chipnummern',
            'zuchtbuchnummern',
            'pruefungen:id,extern,name,name_kurz,type_id,hund_id',
            'pruefungen.type',
            'titeltitel',
            'personen',
            'gentests_total',
            'goniountersuchung',
            'zuchtzulassung',
            'zahnstati' => function ($query) {
                $query->where('zahnstati.aktiv', '=', '1');
            },
            'hdeduntersuchungen' => function ($query) {
                $query->where('hded_untersuchungen.aktiv', '=', '1');
            },
            'ocduntersuchungen' => function ($query) {
                $query->where('ocd_untersuchungen.aktiv', '=', '1');
            },
            'augenuntersuchungen' => function ($query) {
                $query->where('augenuntersuchungen.aktive_au', '=', '1');
            },
        ])->select('hunde.*', 'hund_person.seit', 'hund_person.bis')
            ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
            ->where('hund_person.person_id', '=', $person->id)
            ->orderBy('wurfdatum', 'desc')
            ->get();

        $orgatreeitems = OrgatreeItem::orderBy('order')->where('parent_id', 0)->pluck('open', 'title');

        foreach ($hunde2 as $hund) {
            $hund['orgatree'] = $orgatreeitems;
            $hund['profile_orga'] = false;
            $hund['profile_dokumente'] = false;
        }

        // $hunde2 =  Hund::with([
        //    'images', 'dokumente', 'hundanlageantrag','personen',

        // ])->select('hunde.*')
        //    ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
        //    ->where('hund_person.person_id', '=', $person->id)
        //    ->orderBy('wurfdatum', 'desc')
        //    ->get();

        //  return $hunde2;

        // $hundeanlage =  Hundanlageantrag::with([
        //    'dokumente', 'hund', 'hund.vater', 'hund.mutter', 'hund.chipnummern', 'hund.zuchtbuchnummern'
        // ])->get();

        // $hunde2 =  Hund::with([
        //    'images', 'farbe', 'rasse', 'formwert', 'geschlecht', 'dokumente', 'wesenstest', 'pruefungen:id,extern,name,name_kurz,type_id,hund_id', 'pruefungen.type','titeltitel', 'personen', 'gentests_total', 'goniountersuchung',
        //    'zahnstati' => function ($query) {
        //       $query->where('zahnstati.aktiv', '=', '1');
        //    },
        //    'hdeduntersuchungen' => function ($query) {
        //       $query->where('hded_untersuchungen.aktiv', '=', '1');
        //    },
        //    'ocduntersuchungen' => function ($query) {
        //       $query->where('ocd_untersuchungen.aktiv', '=', '1');
        //    },
        //    'augenuntersuchungen' => function ($query) {
        //       $query->where('augenuntersuchungen.aktive_au', '=', '1');
        //    },
        // ])->select('hunde.*', 'zuchtbuchnummer', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
        //    ->leftjoin('optionen_geschlecht_hund', 'geschlecht_id', '=', 'optionen_geschlecht_hund.id')
        //    ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
        //    ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
        //    ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
        //    ->where('hund_person.person_id', '=', $person->id)
        //    ->orderBy('wurfdatum', 'desc')
        //    ->get();

        // if (!$caching) {
        //    $hunde2 =  Hund::with([
        //       'images', 'farbe', 'rasse', 'geschlecht', 'formwert', 'dokumente', 'wesenstest', 'pruefungentitel', 'titeltitel', 'personen', 'gentests_total', 'goniountersuchung',
        //       'zahnstati' => function ($query) {
        //          $query->where('zahnstati.aktiv', '=', '1');
        //       },
        //       'hdeduntersuchungen' => function ($query) {
        //          $query->where('hded_untersuchungen.aktiv', '=', '1');
        //       },
        //       'ocduntersuchungen' => function ($query) {
        //          $query->where('ocd_untersuchungen.aktiv', '=', '1');
        //       },
        //       'augenuntersuchungen' => function ($query) {
        //          $query->where('augenuntersuchungen.aktive_au', '=', '1');
        //       },
        //    ])->select('hunde.*', 'zuchtbuchnummer', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht_id', 'hunde.id')
        //       ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
        //       ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
        //       ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
        //       ->where('hund_person.person_id', '=', $person->id)
        //       ->orderBy('wurfdatum', 'desc')
        //       ->get();
        // } else {

        //    $hunde2 = cache()->remember('hundedata' . $id, 60 * 60 * 24, function () use ($person) {
        //       return Hund::with([
        //          'images', 'farbe', 'rasse', 'formwert', 'dokumente', 'wesenstest', 'pruefungen','titeltitel', 'personen', 'gentests_total', 'goniountersuchung',
        //          'zahnstati' => function ($query) {
        //             $query->where('zahnstati.aktiv', '=', '1');
        //          },
        //          'hdeduntersuchungen' => function ($query) {
        //             $query->where('hded_untersuchungen.aktiv', '=', '1');
        //          },
        //          'ocduntersuchungen' => function ($query) {
        //             $query->where('ocd_untersuchungen.aktiv', '=', '1');
        //          },
        //          'augenuntersuchungen' => function ($query) {
        //             $query->where('augenuntersuchungen.aktive_au', '=', '1');
        //          },
        //       ])->select('hunde.*', 'zuchtbuchnummer', 'farben.name AS farbe', 'rassen.name AS rasse', 'rasse_id', 'farbe_id', 'geschlecht', 'hunde.id')
        //          ->leftjoin('rassen', 'hunde.rasse_id', '=', 'rassen.id')
        //          ->leftjoin('farben', 'hunde.farbe_id', '=', 'farben.id')
        //          ->leftjoin('hund_person', 'hund_person.hund_id', '=', 'hunde.id')
        //          ->where('hund_person.person_id', '=', $person->id)
        //          ->orderBy('wurfdatum', 'desc')
        //          ->get();
        //    });
        // }

        $mitglied = $person->mitglied;
        if ($mitglied) {
            $landesgruppe = $mitglied->landesgruppe;
            $bezirksgruppe = $mitglied->bezirksgruppe;
            $mitgliedsart = $mitglied->mitgliedsart;
            $bankverbindungen = $mitglied->bankverbindungen;

            $mitglied['landesgruppe'] = $landesgruppe;
            $mitglied['bezirksgruppe'] = $bezirksgruppe;
            $mitglied['mitgliedschaft'] = $mitgliedsart;
            $mitglied['bankverbindungen'] = $bankverbindungen;

            // Attach associated members (e.g. children) to the person
            switch ($person->mitglied->mitgliedsart_id) {
                case '1': //Vollmitglied
                    $person->mitglied['familienmitglieder'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 2)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->get();
                    $person->mitglied['jugendmitglieder'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 3)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->get();
                    break;
                case '2': //Familienmitglied
                    $person->mitglied['vollmitglied'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 1)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->first();
                    break;
                case '3': //Jugendmitglied
                    $person->mitglied['vollmitglied'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 1)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->first();
                    break;
            }

            //  $mitglied['datum_austritt'] =  date('d.m.Y', strtotime($mitglied['datum_austritt']));
            //  $mitglied['datum_eintritt'] =  date('d.m.Y', strtotime($mitglied['datum_eintritt']));
        }

        // FIXME: Zwinger benötigt ser viel Zeit
        $zwinger = $person->zwingers()->first(); // Aktuell gültiger Zwinger
        if ($zwinger) {

            $zwinger['orgatree'] = $orgatreeitems;
            $zwinger['profile_orga'] = false;
            $zwinger['profile_dokumente'] = false;
            if ($zwinger->zuchtstaetten) {
                $zwinger->zuchtstaetten->load('zuchtstaettenbesichtigungen', 'zuchtstaettenbesichtigungen.zuchtwart', 'zuchtstaettenbesichtigungen.freigabe_gs', 'zuchtstaettenbesichtigungen.antragsteller', 'zuchtstaettenbesichtigungen.zuchtstaettenmaengel', 'zuchtstaettenbesichtigungen.dokumente', 'zuchtstaettenmaengel', 'dokumente', 'notizen');
                foreach ($zwinger->zuchtstaetten as $zuchtstaette) {
                    $zuchtstaette['orgatree'] = $orgatreeitems;
                    $zuchtstaette['profile_orga'] = false;
                    $zuchtstaette['profile_dokumente'] = false;
                    $zuchtstaette['profile_zuchtstaettenbesichtigungen'] = false;
                    $zuchtstaette['profile_zuchtstaettenmaengel'] = false;

                    foreach ($zuchtstaette->zuchtstaettenbesichtigungen as $besichtigung) {
                        $besichtigung['orgatree'] = $orgatreeitems;
                        $besichtigung['profile_orga'] = false;
                        $besichtigung['profile_dokumente'] = false;
                    }
                }
            }

            $zwinger->rassen;
            $zwinger->zuechter;
            $zwinger->personen;
            $wuerfe = $zwinger->wuerfe;
            // $zwinger->hunde;
            // $zwinger->load(['hunde' => function ($query) {
            //     $query->with(['pivot.leihstellung']);
            // }]);

            $zwinger->load('hunde', 'hunde.images', 'hunde.dokumente');

            // Lade Leihstellungen separat
            foreach ($zwinger->hunde as $hund) {
                if ($hund->pivot->leihstellung_id) {
                    $hund->pivot->load('leihstellung.dokumente', 'leihstellung.leihsteller');
                }
            }

            $zwinger->images;

            foreach ($wuerfe as $wurf) {
                //  $wurf->hunde;

                // foreach ($wurf->hunde as $hund) {
                // }
                $wurf['wurfdatum'] = date('d.m.Y', strtotime($wurf['wurfdatum']));
                $wurf['deckdatum'] = date('d.m.Y', strtotime($wurf['deckdatum']));
                $wurf->rasse;
                $wurf['vater'] = Hund::find($wurf->vater_id);
                $wurf['mutter'] = Hund::find($wurf->mutter_id);

                // foreach ($wurf->welpen as $hund) {
                //     $hund->images;
                //     $prerender = $this->getPrerenderedHund($hund->id);
                //     $hund['prerendered'] = $prerender;
                //     $eigentuemerPruefung = $this->getAllOwnersWithDetails($hund->id, $id);
                //     $hund['eigentuemer'] = $eigentuemerPruefung;
                // }

            }
        } else {
            $wuerfe = [];
            $zwinger = [];
        }

        $person['zwinger'] = $zwinger;
        // return $person;  // 4.41 Sekunden

        if ($zwinger) {
            $person['zwinger']['dokumente'] = $zwinger->dokumente;
        }

        // FIXME: Resource Zusammenstellung benötigt sehr viel Zeit
        $person['hunde'] = HundeShortResource::collection($hunde2);
        // $person['zuchthunde'] = HundeShortResource::collection($zuchthunde);
        $person['funktionen'] = $user->person->funktionen;
        $person['rollen'] = $user->roles;
        $person['listen'] = $user->person->listen;
        $person['mitglied'] = $mitglied;
        $person['profile_photo_url'] = $user->profile_photo_url;
        $person['person'] = $user->person;
        $person['bankverbindungen'] = $user->person->bankverbindungen;
        $person['dokumente'] = $user->person->dokumente;

        $person['aufgaben'] = $user->offeneAufgaben;
        $person['rechnungen'] = $user->person->rechnungen;
        $person['termine'] = $user->person->termine;
        $person['notifications'] = $user->ungeleseneNotifications;
        $person['veranstaltungen'] = $user->person->veranstaltungen;

        // $person['dokumente'] = '';
        $person['hundanlageantraege'] = $user->person->hundanlageantraege->load('hund', 'hund.vater', 'hund.mutter', 'hund.chipnummern', 'hund.zuchtbuchnummern', 'hund.dokumente');

        return $person;

        // return PersonResource::collection( Person::find($id));
    }

    public function personenakte(Person $person)
    {

        $person->load([
            'adressen',
            'user',
            'mitglied',
            'images',
            'bankverbindungen',
            'zuchtverbote',
            'vereinsstrafen',
            'mitglied.bankverbindungen',
            'mitglied.landesgruppe',
            'mitglied.bezirksgruppe',
            'mitglied.mitgliedsart',
            'hunde',
            'hunde.vater',
            'hunde.mutter',
            'hunde.chipnummern',
            'hunde.zuchtbuchnummern',
            'hunde.dokumente',
            'hunde.images',
            'hunde.eigentuemers',
            'zwinger',
            'zwinger.rassen',
            'zwinger.personen',
            'zwinger.images',
            'wuerfe',
            'wurfplaene',
            'funktionen',
            'dokumente',
            'listen',
        ]);

        if ($person->mitglied) {

            switch ($person->mitglied->mitgliedsart_id) {
                case '1': //Vollmitglied
                    $person->mitglied['familienmitglieder'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 2)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->get();
                    $person->mitglied['jugendmitglieder'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 3)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->get();
                    break;
                case '2': //Familienmitglied
                    $person->mitglied['vollmitglied'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 1)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->first();
                    break;
                case '3': //Jugendmitglied
                    $person->mitglied['vollmitglied'] = Mitglied::with('person', 'person.user', 'landesgruppe', 'bezirksgruppe', 'mitgliedsart')->where('mitgliedsart_id', 1)->where('mitglied_nr_basis', $person->mitglied->mitglied_nr_basis)->first();
                    break;
            }
        }

        return $person;

        // $mitglied = $person->mitglied;
        // if ($mitglied) {
        //    $landesgruppe = $mitglied->landesgruppe;
        //    $bezirksgruppe = $mitglied->bezirksgruppe;
        //    $mitgliedsart = $mitglied->mitgliedsart;

        //    $mitglied['landesgruppe'] = $landesgruppe;
        //    $mitglied['bezirksgruppe'] = $bezirksgruppe;
        //    $mitglied['mitgliedschaft'] = $mitgliedsart;

        //    //  $mitglied['datum_austritt'] =  date('d.m.Y', strtotime($mitglied['datum_austritt']));
        //    //  $mitglied['datum_eintritt'] =  date('d.m.Y', strtotime($mitglied['datum_eintritt']));
        // }

        // $zwinger = $person->zwinger;
        // if ($zwinger) {
        //    $zwinger->rassen;
        //    $zwinger->zuechter;
        //    $zwinger->personen;
        //    $wuerfe = $zwinger->wuerfe;
        //    $zwinger->images;
        //    foreach ($wuerfe as $wurf) {
        //       //  $wurf->hunde;

        //       // foreach ($wurf->hunde as $hund) {
        //       // }
        //       $wurf['wurfdatum'] =  date('d.m.Y', strtotime($wurf['wurfdatum']));
        //       $wurf['deckdatum'] =  date('d.m.Y', strtotime($wurf['deckdatum']));
        //       $wurf->rasse;
        //       $wurf['vater'] = Hund::find($wurf->vater_id);
        //       $wurf['mutter'] = Hund::find($wurf->mutter_id);
        //    }
        // } else {
        //    $wuerfe = [];
        //    $zwinger = [];
        // }

        // $person['zwinger'] = $zwinger;
        // if ($zwinger)  $person['zwinger']['dokumente'] = $zwinger->dokumente;
        // // $person['wuerfe'] = $wuerfe;
        // // $person['hunde'] = ''; // $hunde;
        // $person['hunde'] = HundeShortResource::collection($hunde2);
        // //  $person['zuchthunde'] = HundeShortResource::collection($zuchthunde);
        // $person['funktionen'] = $user->person->funktionen;
        // $person['listen'] = $user->person->listen;
        // $person['mitglied'] = $mitglied;
        // $person['profile_photo_url'] = $user->profile_photo_url;
        // $person['person'] = $user->person;
        // $person['dokumente'] = $user->person->dokumente;
        // $person['hundanlageantraege'] = $user->person->hundanlageantraege->load('hund', 'hund.vater', 'hund.mutter', 'hund.chipnummern', 'hund.zuchtbuchnummern' , 'hund.dokumente');
        return $person;

        // return PersonResource::collection( Person::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return $person->append('mitgliedsnummer');
        // return Person::find($person);
        // return PersonResource::collection(Person::find($person));
    }

    public function get_mitgliedsnummer(int $id)
    {
        return Person::find($id)->mitgliedsnummer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

        $personen = Person::with(['images'])->where('nachname', 'like', $request->suche . '%')->orWhere('nachname', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('nachname', 'desc')->get();
        $count = 1;

        return [
            'success' => 'Suche erfolgreich',
            'ergebnisliste' => $personen,
            'anzahl' => count($personen),
        ];
    }

    public function auto(Request $request)
    {
        $personen = Person::where('name', 'like', $request->suche . '%')->orWhere('name', 'like', '% ' . $request->suche . '%')->limit(250)->orderBy('name', 'desc')->get();
        //  return OptionResource::collection($personen);
    }

    public function autocomplete(Request $request)
    {
        $mitgliedsnummer = trim($request->nr ?? '');
        $nachname = trim($request->nn ?? '');
        $vorname = trim($request->vn ?? '');
        $strasse = trim($request->str ?? '');
        $plz = trim($request->plz ?? '');
        $ort = trim($request->ort ?? '');
        $geschlecht = trim($request->gid ?? '');
        $zwinger = trim($request->zid ?? '');
        $zuchtwarte = trim($request->zw ?? '');
        $hund = trim($request->hid ?? '');
        $bankverbindungen = trim($request->bv ?? '');
        $complete = $request->c;
        $main = $request->m;

        $countQuery = Person::select('nachname', 'vorname', 'geschlecht_id')
            ->when($hund != '' && $hund != '0', function ($query) use ($hund) {
                return $query->join('hund_person', 'hund_person.person_id', '=', 'personen.id')->where('hund_person.hund_id', '=', $hund);
            })->when($zwinger != '' && $zwinger != '0', function ($query) use ($zwinger) {
                return $query->join('person_zwinger', 'person_zwinger.person_id', '=', 'personen.id')->where('person_zwinger.zwinger_id', '=', $zwinger);
            })->when($zuchtwarte != '' && $zuchtwarte != '0', function ($query) {
                return $query->join('zuchtwarte', 'zuchtwarte.person_id', '=', 'personen.id')->where('zuchtwarte.aktiv', '=', 1);
            })
            // Join personenadressen always when address fields are queried
            ->when($strasse != '' || $plz != '' || $ort != '', function ($query) {
                return $query->join('personenadressen', 'personen.id', '=', 'personenadressen.person_id');
            })->when($geschlecht != '', function ($query) use ($geschlecht) {
                return $query->where('geschlecht_id', '=', $geschlecht);
            })->when($nachname != '', function ($query) use ($nachname) {
                return $query->where('nachname', 'LIKE', '' . $nachname . '%');
            })->when($vorname != '', function ($query) use ($vorname) {
                return $query->where('vorname', 'LIKE', '' . $vorname . '%');
            })->when($strasse != '', function ($query) use ($strasse) {
                return $query->where('personenadressen.strasse', 'LIKE', '%' . $strasse . '%');
            })->when($plz != '', function ($query) use ($plz) {
                return $query->where('personenadressen.postleitzahl', 'LIKE', '%' . $plz . '%');
            })->when($ort != '', function ($query) use ($ort) {
                return $query->where('personenadressen.ort', 'LIKE', '%' . $ort . '%');
            });

        $count = $countQuery->count();

        //    $count = Person::when($nachname != '', function ($query) use ($nachname) {
        //    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
        // })->when($vorname != '', function ($query) use ($vorname) {
        //    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
        // })->when($strasse != '', function ($query) use ($strasse) {
        //    return $query->where('strasse', 'LIKE', '%' . $strasse . '%');
        // })->when($plz != '', function ($query) use ($plz) {
        //    return $query->where('postleitzahl', 'LIKE', '%' . $plz . '%');
        // })->when($ort != '', function ($query) use ($ort) {
        //    return $query->where('ort', 'LIKE', '%' . $ort . '%');
        // })->count();

        if ($count <= 10) {
            $complete = true;
            $personen = Person::leftjoin('mitglieder', 'mitglieder.person_id', '=', 'personen.id')
                ->join('personenadressen', 'personen.id', '=', 'personenadressen.person_id')
                ->select('nachname', 'vorname', 'geschlecht_id', 'personen.id as id', 'mitglieder.id as mitglied_id', 'mitglieder.mitglied_nr as mitgliedsnummer')
                ->when($hund != '' && $hund != '0', function ($query) use ($hund) {
                    return $query->join('hund_person', 'hund_person.person_id', '=', 'personen.id')->where('hund_person.hund_id', '=', $hund);
                })->when($zwinger != '' && $zwinger != '0', function ($query) use ($zwinger) {
                    return $query->join('person_zwinger', 'person_zwinger.person_id', '=', 'personen.id')->where('person_zwinger.zwinger_id', '=', $zwinger);
                })
                ->when($zuchtwarte != '' && $zuchtwarte != '0', function ($query) {
                    return $query->join('zuchtwarte', 'zuchtwarte.person_id', '=', 'personen.id')->where('zuchtwarte.aktiv', '=', 1);
                })
                ->when($geschlecht != '', function ($query) use ($geschlecht) {
                    return $query->where('geschlecht_id', '=', $geschlecht);
                })->when($nachname != '', function ($query) use ($nachname) {
                    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                })->when($vorname != '', function ($query) use ($vorname) {
                    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('personenadressen.strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('personenadressen.postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('personenadressen.ort', 'LIKE', '%' . $ort . '%');
                })->limit(10)
                ->groupBy('personen.id')
                ->orderBy($main, 'asc')->get();
        } else {

            $count = Person::select('nachname', 'vorname', 'geschlecht_id')
                ->join('personenadressen', 'personen.id', '=', 'personenadressen.person_id')
                ->when($hund != '' && $hund != '0', function ($query) use ($hund) {
                    return $query->join('hund_person', 'hund_person.person_id', '=', 'personen.id')->where('hund_person.hund_id', '=', $hund);
                })->when($zwinger != '' && $zwinger != '0', function ($query) use ($zwinger) {
                    return $query->join('person_zwinger', 'person_zwinger.person_id', '=', 'personen.id')->where('person_zwinger.zwinger_id', '=', $zwinger);
                })->when($zuchtwarte != '' && $zuchtwarte != '0', function ($query) {
                    return $query->join('zuchtwarte', 'zuchtwarte.person_id', '=', 'personen.id')->where('zuchtwarte.aktiv', '=', 1);
                })->when($geschlecht != '', function ($query) use ($geschlecht) {
                    return $query->where('geschlecht_id', '=', $geschlecht);
                })->when($nachname != '', function ($query) use ($nachname) {
                    return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                })->when($vorname != '', function ($query) use ($vorname) {
                    return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                })->when($strasse != '', function ($query) use ($strasse) {
                    return $query->where('personenadressen.strasse', 'LIKE', '' . $strasse . '%');
                })->when($plz != '', function ($query) use ($plz) {
                    return $query->where('personenadressen.postleitzahl', 'LIKE', '%' . $plz . '%');
                })->when($ort != '', function ($query) use ($ort) {
                    return $query->where('personenadressen.ort', 'LIKE', '%' . $ort . '%');
                })->when(($strasse == '' && $plz == '' && $ort == '') && ($main != 'personenadressen.strasse' && $main != 'personenadressen.postleitzahl' && $main != 'personenadressen.ort'), function ($query) use ($main) {
                    return $query->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci');
                })->count();

            if ($count < 200) {
                $complete = false;
                $personen = Person::join('personenadressen', 'personen.id', '=', 'personenadressen.person_id')
                    ->when($hund != '' && $hund != '0', function ($query) use ($hund) {
                        return $query->join('hund_person', 'hund_person.person_id', '=', 'personen.id')->where('hund_person.hund_id', '=', $hund);
                    })->when($zwinger != '' && $zwinger != '0', function ($query) use ($zwinger) {
                        return $query->join('person_zwinger', 'person_zwinger.person_id', '=', 'personen.id')->where('person_zwinger.zwinger_id', '=', $zwinger);
                    })->when($zuchtwarte != '' && $zuchtwarte != '0', function ($query) {
                        return $query->join('zuchtwarte', 'zuchtwarte.person_id', '=', 'personen.id')->where('zuchtwarte.aktiv', '=', 1);
                    })->when($geschlecht != '', function ($query) use ($geschlecht) {
                        return $query->where('geschlecht_id', '=', $geschlecht);
                    })->when($nachname != '', function ($query) use ($nachname) {
                        return $query->where('nachname', 'LIKE', '' . $nachname . '%');
                    })->when($vorname != '', function ($query) use ($vorname) {
                        return $query->where('vorname', 'LIKE', '' . $vorname . '%');
                    })->when($strasse != '', function ($query) use ($strasse) {
                        return $query->where('personenadressen.strasse', 'LIKE', '' . $strasse . '%');
                    })->when($plz != '', function ($query) use ($plz) {
                        return $query->where('personenadressen.postleitzahl', 'LIKE', '%' . $plz . '%');
                    })->when($ort != '', function ($query) use ($ort) {
                        return $query->where('personenadressen.ort', 'LIKE', '%' . $ort . '%');
                    })
                    ->limit(200)
                    ->orderBy($main, 'asc')
                    ->when((($main != 'personenadressen.strasse' && $main != 'personenadressen.postleitzahl' && $main != 'personenadressen.ort') || ($strasse == '' && $plz == '' && $ort == '') && ($main != 'personenadressen.strasse' && $main != 'personenadressen.postleitzahl' && $main != 'personenadressen.ort')), function ($query) use ($main) {
                        return $query->groupByRaw($main . ' COLLATE utf8mb4_swedish_ci');
                    })
                    ->pluck($main);
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

    public function autocomplete_adelstitel(Request $request)
    {

        $titel = trim($request->t);

        $titels = OptionAdelstitel::select('id', 'name')
            ->when($titel != '', function ($query) use ($titel) {
                return $query->where('name', 'LIKE', '%' . $titel . '%');
            })
            ->where('aktiv', '=', '1')
            ->orderBy('name', 'asc')->get();

        return $titels;
    }

    public function autocomplete_akademische_titel(Request $request)
    {

        $titel = trim($request->t);

        $titels = OptionAkademischerTitel::select('id', 'name')
            ->when($titel != '', function ($query) use ($titel) {
                return $query->where('name', 'LIKE', '%' . $titel . '%');
            })
            ->where('aktiv', '=', '1')
            ->orderBy('name', 'asc')->get();

        return $titels;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update_kontakt(Request $request)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        //  return true;

        //    $validated = $request->validated();

        $user_id = Auth::id();

        $user = User::find($user_id);

        $person = Person::find($user->person_id);

        // $update = $request->all();

        if (1) {

            // $person->anrede  = $request['anrede'];
            //  $person->geschlecht  = $request['geschlecht'];
            //  $person->adelstitel  = $request['adelstitel'];
            //  $person->akademischetitel  = $request['akademischetitel'];
            $person->vorname = $request['vorname'] ? $request['vorname'] : '';
            // $person->nachname_praefix  = $request['nachname_praefix'];
            $person->nachname = $request['nachname'] ? $request['nachname'] : '';
            //  $person->geboren  = $request['geboren'];
            //  $person->post_anrede  = $request['post_anrede'];
            //  $person->post_name  = $request['post_name'];
            //  $person->post_co  = $request['post_co'];
            $person->strasse = $request['strasse'] ? $request['strasse'] : '';
            $person->adresszusatz = $request['adresszusatz'] ? $request['adresszusatz'] : '';
            $person->postleitzahl = $request['postleitzahl'] ? $request['postleitzahl'] : '';
            $person->ort = $request['ort'] ? $request['ort'] : '';
            //  $person->postfach_plz  = $request['postfach_plz'];
            //  $person->postfach_nummer  = $request['postfach_nummer'];
            //  $person->standard  = $request['standard'];
            $person->land = $request['land'] ? $request['land'] : '';
            //   $person->laenderkuerzel  = $request['laenderkuerzel'];
            $person->telefon_1 = $request['telefon_1'] ? $request['telefon_1'] : '';
            $person->telefon_2 = $request['telefon_2'] ? $request['telefon_2'] : '';
            $person->email_1 = $request['email_1'] ? $request['email_1'] : '';
            $person->email_2 = $request['email_2'] ? $request['email_2'] : '';
            //  $person->website_1  = $request['website_1'];
            //  $person->website_2  = $request['website_2'];
            //  $person->kommentar  = $request['kommentar'];
            //   $person->nachname_ohne_praefix  = $request['nachname_ohne_praefix'];
            //   $person->dsgvo  = $request['dsgvo'];
            $person->save();

            return response()->json(['success' => 'Kontaktdaten gespeichert']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function person_update(UpdatePersonRequest $request, Person $person)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        //  return true;

        $validated = $request->validated();

        $update = $request->all();

        if (1) {

            $person->mitglied_id = $update['mitglied_id'];
            $person->zwinger_id = $update['zwinger_id'];
            $person->mitgliedsnummer = $update['mitgliedsnummer'];
            $person->mitgliedsart = $update['mitgliedsart'];
            $person->anrede = $update['anrede'];
            $person->geschlecht_id = $update['geschlecht_id'];
            $person->adelstitel = $update['adelstitel'];
            $person->akademischetitel = $update['akademischetitel'];
            $person->vorname = $update['vorname'];
            $person->nachname_praefix = $update['nachname_praefix'];
            $person->nachname = $update['nachname'];
            $person->geboren = $update['geboren'];
            $person->post_anrede = $update['post_anrede'];
            $person->post_name = $update['post_name'];
            $person->post_co = $update['post_co'];
            $person->strasse = $update['strasse'];
            $person->adresszusatz = $update['adresszusatz'];
            $person->postleitzahl = $update['postleitzahl'];
            $person->ort = $update['ort'];
            $person->postfach_plz = $update['postfach_plz'];
            $person->postfach_nummer = $update['postfach_nummer'];
            $person->standard = $update['standard'];
            $person->land = $update['land'];
            $person->laenderkuerzel = $update['laenderkuerzel'];
            $person->telefon_1 = $update['telefon_1'];
            $person->telefon_2 = $update['telefon_2'];
            $person->telefon_3 = $update['telefon_3'];
            $person->email_1 = $update['email_1'];
            $person->email_2 = $update['email_2'];
            $person->website_1 = $update['website_1'];
            $person->website_2 = $update['website_2'];
            $person->kommentar = $update['kommentar'];
            $person->zwingernummer = $update['zwingernummer'];
            $person->zwingername = $update['zwingername'];
            $person->eintrittsdatum = $update['eintrittsdatum'];
            $person->austrittsdatum = $update['austrittsdatum'];
            $person->nachname_ohne_praefix = $update['nachname_ohne_praefix'];
            $person->dsgvo = $update['dsgvo'];
            $person->zwingername_praefix = $update['zwingername_praefix'];
            $person->zwingername_suffix = $update['zwingername_suffix'];
            $person->nachname_ehemals = $update['nachname_ehemals'];
            $person->save();

            return $person;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Hund  $hund
     * @return \Illuminate\Http\Response
     */
    public function personen_update(Request $request)
    {
        // Validatierung
        // read more on validation at http://laravel.com/docs/validation

        $ids = [];

        foreach ($request->all() as $update) {
            //      // $validated = $request->validated();
            //      if (1) {

            $person = Person::find($update['id']);
            $person->mitglied_id = $update['mitglied_id'];
            $person->zwinger_id = $update['zwinger_id'];
            $person->mitgliedsnummer = $update['mitgliedsnummer'];
            $person->mitgliedsart = $update['mitgliedsart'];
            $person->anrede_id = $update['anrede_id'];
            // $person->anrede  = $update['anrede'];
            $person->geschlecht = $update['geschlecht'];
            $person->adelstitel = $update['adelstitel'];
            $person->akademischetitel = $update['akademischetitel'];
            $person->vorname = $update['vorname'];
            $person->nachname_praefix = $update['nachname_praefix'];
            $person->nachname = $update['nachname'];
            $person->geboren = $update['geboren'];
            $person->post_anrede = $update['post_anrede'];
            $person->post_name = $update['post_name'];
            $person->post_co = $update['post_co'];
            $person->strasse = $update['strasse'];
            $person->adresszusatz = $update['adresszusatz'];
            $person->postleitzahl = $update['postleitzahl'];
            $person->ort = $update['ort'];
            $person->postfach_plz = $update['postfach_plz'];
            $person->postfach_nummer = $update['postfach_nummer'];
            $person->standard = $update['standard'];
            $person->land = $update['land'];
            $person->laenderkuerzel = $update['laenderkuerzel'];
            $person->telefon_1 = $update['telefon_1'];
            $person->telefon_2 = $update['telefon_2'];
            $person->telefon_3 = $update['telefon_3'];
            $person->email_1 = $update['email_1'];
            $person->email_2 = $update['email_2'];
            $person->website_1 = $update['website_1'];
            $person->website_2 = $update['website_2'];
            $person->kommentar = $update['kommentar'];
            $person->zwingernummer = $update['zwingernummer'];
            $person->zwingername = $update['zwingername'];
            $person->eintrittsdatum = $update['eintrittsdatum'];
            $person->austrittsdatum = $update['austrittsdatum'];
            $person->nachname_ohne_praefix = $update['nachname_ohne_praefix'];
            $person->dsgvo = $update['dsgvo'];
            $person->zwingername_praefix = $update['zwingername_praefix'];
            $person->zwingername_suffix = $update['zwingername_suffix'];
            $person->nachname_ehemals = $update['nachname_ehemals'];

            if ($person->save()) {
                $ids[] = $person->id;
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
    public function destroy(Person $person)
    {
        //
    }

    /**
     * Upload image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        //
        //       $path = $request->file('avatar')->storeAs(
        //     'avatars', $request->user()->id
        // );
        //      return 'KOMMPLETT';
        //      $request->validate([
        // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        // ]);

        if ($request->file()) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('uploads', $fileName, 'public');

            return $path;
        } else {
            return 'nix';
        }
    }

    /**
     * Get person with bank connections for forms
     */
    public function getPersonWithBankverbindungen($id)
    {
        try {
            $person = Person::with(['mitglied'])->find($id);

            if (! $person) {
                return response()->json([
                    'success' => false,
                    'error' => 'Person nicht gefunden',
                ], 404);
            }

            // 1. Persönliche Bankverbindung (für Vereinsleistungen)
            $persoenlicheBankverbindung = $person->bankverbindung;

            // 2. Mitglieds-Bankverbindung (für Mitgliedsbeiträge) - nur wenn Person ein Mitglied ist
            $mitgliedsBankverbindung = null;
            if ($person->mitglied) {
                $mitgliedsBankverbindung = $person->mitglied->bankverbindung;
            }

            // Person-Daten aufbereiten mit beiden Bankverbindungen
            $personData = $person->toArray();

            // Persönliche Bankverbindung hinzufügen
            $personData['persoenliche_bankverbindung'] = $persoenlicheBankverbindung ? [
                'id' => $persoenlicheBankverbindung->id,
                'iban' => $persoenlicheBankverbindung->iban,
                'bic' => $persoenlicheBankverbindung->bic,
                'kontoinhaber' => $persoenlicheBankverbindung->kontoinhaber,
                'bankname' => $persoenlicheBankverbindung->bankname,
                'mandatsreferenz' => $persoenlicheBankverbindung->mandatsreferenz,
                'gueltig_ab' => $persoenlicheBankverbindung->gueltig_ab,
                'gueltig_bis' => $persoenlicheBankverbindung->gueltig_bis,
                'aktiv' => $persoenlicheBankverbindung->aktiv,
            ] : null;

            // Mitglieds-Bankverbindung hinzufügen (falls vorhanden)
            $personData['mitglieds_bankverbindung'] = $mitgliedsBankverbindung ? [
                'id' => $mitgliedsBankverbindung->id,
                'iban' => $mitgliedsBankverbindung->iban,
                'bic' => $mitgliedsBankverbindung->bic,
                'kontoinhaber' => $mitgliedsBankverbindung->kontoinhaber,
                'bankname' => $mitgliedsBankverbindung->bankname,
                'mandatsreferenz' => $mitgliedsBankverbindung->mandatsreferenz,
                'gueltig_ab' => $mitgliedsBankverbindung->gueltig_ab,
                'gueltig_bis' => $mitgliedsBankverbindung->gueltig_bis,
                'aktiv' => $mitgliedsBankverbindung->aktiv,
            ] : null;

            // Mitgliedsstatus hinzufügen
            $personData['is_aktives_mitglied'] = $person->mitglied ? $person->mitglied->aktiv : false;
            $personData['mitgliedsnummer'] = $person->mitglied ? $person->mitglied->mitgliedsnummer : null;

            return response()->json([
                'success' => true,
                'data' => $personData,
                'message' => 'Person mit Bankverbindungen erfolgreich geladen',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Person: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search for persons with optional user filter.
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('query', '');
            $withUserOnly = $request->get('with_user_only', false);
            $users = $request->get('users', false); // New directive

            if (strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }

            $personsQuery = Person::query();

            // Filter to only persons who have user accounts if requested
            if ($withUserOnly || $users) {
                $personsQuery->whereHas('user');
            }

            // Always include user relationship
            $personsQuery->with('user');

            // Search in name fields and email
            $personsQuery->where(function ($q) use ($query) {
                $q->where('vorname', 'like', "%{$query}%")
                    ->orWhere('nachname', 'like', "%{$query}%")
                    ->orWhere('name_rufname', 'like', "%{$query}%")
                    ->orWhereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('email', 'like', "%{$query}%");
                    });
            });

            $persons = $personsQuery->limit(20)->get();

            return response()->json([
                'success' => true,
                'data' => PersonResource::collection($persons),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Suchen von Personen: ' . $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Get a simple list of all persons for assignments.
     */
    public function list()
    {
        $persons = Person::select(['id', 'vorname', 'nachname'])
            ->whereNotNull('nachname')
            ->orderBy('nachname')
            ->orderBy('vorname')
            ->get()
            ->map(function ($person) {
                $person->full_name = trim($person->vorname . ' ' . $person->nachname);

                return $person;
            });

        return response()->json([
            'success' => 'Personen erfolgreich geladen',
            'data' => $persons,
        ]);
    }

    /**
     * Get invoices/bills of a specific group
     */
    public function rechnungen(Request $request, $id)
    {

        $uid = Auth::id();

        if (! $uid) {
            return;
        }

        if (! $id) {
            $user = User::find($uid);
            if (! $user || ! $user->person_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Berechtigung, keine Person zugeordnet',
                ], 403);
            }
            $id = $user->person_id;
        }

        $person = Person::with('rechnungen')->findOrFail($id);

        $query = $person->rechnungen();

        // Suche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rechnungsnummer', 'LIKE', "%{$search}%")
                    ->orWhere('anmerkungen', 'LIKE', "%{$search}%");
            });
        }

        // Filter nach Status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'bezahlt':
                    $query->where('bezahlt', true);
                    break;
                case 'offen':
                    $query->where('bezahlt', false)->where('storniert', false);
                    break;
                case 'ueberfaellig':
                    $query->where('bezahlt', false)
                        ->where('storniert', false)
                        ->where('faelligkeit', '<', now()->format('Y-m-d'));
                    break;
                case 'storniert':
                    $query->where('storniert', true);
                    break;
            }
        }

        // Filter nach Jahr
        if ($request->has('year') && $request->year) {
            $query->whereYear('rechnungsdatum', $request->year);
        }

        // Sortierung
        $sortField = $request->get('sort_field', 'rechnungsdatum');
        switch ($sortField) {
            case 'betrag':
            case 'rechnungssumme':
            case 'faelligkeit':
            case 'bezahlt':
                // erlaubte Felder
                break;
            default:
                $sortField = 'rechnungsdatum';
        }

        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $rechnungen = $query->paginate($request->get('per_page', 25));

        // Statistiken berechnen
        $allRechnungen = $person->rechnungen();
        $statistics = [
            'total_count' => $allRechnungen->count(),
            'total_paid' => $allRechnungen->where('bezahlt', true)->sum('rechnungssumme'),
            'total_open' => $allRechnungen->where('bezahlt', false)->where('storniert', false)->sum('rechnungssumme'),
            'total_overdue' => $allRechnungen->where('bezahlt', false)
                ->where('storniert', false)
                ->where('faelligkeit', '<', now()->format('Y-m-d'))
                ->sum('rechnungssumme'),
        ];

        // Transform data for frontend
        // $rechnungen->getCollection()->transform(function ($rechnung) {
        //     $rechnung->betreff = $rechnung->name; // Map anmerkungen to betreff for frontend
        //     $rechnung->beschreibung = ''; // No description field in DB
        //     $rechnung->re = $rechnung->rechnungssumme;
        //     $rechnung->faelligkeitsdatum = $rechnung->faelligkeit;
        //     return $rechnung;
        // });

        return response()->json([
            'success' => true,
            'data' => $rechnungen->items(),
            'meta' => [
                'current_page' => $rechnungen->currentPage(),
                'from' => $rechnungen->firstItem(),
                'last_page' => $rechnungen->lastPage(),
                'per_page' => $rechnungen->perPage(),
                'to' => $rechnungen->lastItem(),
                'total' => $rechnungen->total(),
            ],
            'statistics' => $statistics,
        ]);
    }

    /**
     * Get available years for invoices of a specific group
     */
    public function rechnungenYears($id)
    {
        $uid = Auth::id();

        if (! $uid) {
            return;
        }

        if (! $id) {
            $user = User::find($uid);
            if (! $user || ! $user->person_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Berechtigung, keine Person zugeordnet',
                ], 403);
            }
            $id = $user->person_id;
        }

        $years = $gruppe->rechnungen()
            ->selectRaw('DISTINCT YEAR(rechnungsdatum) as year')
            ->whereNotNull('rechnungsdatum')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return response()->json([
            'success' => true,
            'years' => $years,
        ]);
    }

    /**
     * Autocomplete für Richter-Zuordnung
     * Sucht Personen und schließt bereits vorhandene Richter aus
     */
    public function autocompleteRichter(Request $request)
    {
        $search = trim($request->input('search', ''));
        $limit = $request->input('limit', 20);
        $excludeRichter = $request->input('exclude_richter', false);

        if (strlen($search) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $query = Person::with(['mitglied.landesgruppe', 'mitglied.bezirksgruppe'])
            ->where(function ($q) use ($search) {
                $q->where('vorname', 'LIKE', '%' . $search . '%')
                    ->orWhere('nachname', 'LIKE', '%' . $search . '%')
                    ->orWhereRaw("CONCAT(vorname, ' ', nachname) LIKE ?", ['%' . $search . '%'])
                    ->orWhereRaw("CONCAT(nachname, ' ', vorname) LIKE ?", ['%' . $search . '%']);
            });

        // Exclude persons who are already Richter if requested
        if ($excludeRichter) {
            $query->whereDoesntHave('richter');
        }

        $persons = $query->orderBy('nachname')
            ->orderBy('vorname')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => PersonResource::collection($persons),
        ]);
    }
}
