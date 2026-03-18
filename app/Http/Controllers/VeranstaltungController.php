<?php

namespace App\Http\Controllers;

use App\Http\Resources\VeranstaltungAnmeldungResource;
use App\Http\Resources\VeranstaltungenResource;
use App\Http\Resources\VeranstaltungResource;
use App\Http\Resources\VeranstaltungssucheResource;
use App\Models\Hund;
use App\Models\Person;
use App\Models\Termin;
use App\Models\User;
use App\Models\Veranstaltung;
use App\Models\Veranstaltungen;
use App\Models\VeranstaltungMeldung;
use App\Models\Veranstaltungsaufgaben;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VeranstaltungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field');
        // switch ($sortField) {

        //    case 'erstertermin':
        //       $sortField = 'erstertermin_test';
        //       break;
        //    case 'letztertermin':
        //       $sortField = 'letztertermin_test';
        //       break;
        // }

        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $having = [];
        foreach ($columns as $column) {

            if ($column['having'] == true && $column['db_field_as'] != '' && $column['filterable'] == true && $column['filtertype'] != 0) {

                switch ($column['filtertype']) {
                    case 2:
                        array_push($having, '(`' . $column['db_field_as'] . "` NOT LIKE '%" . $column['filter'] . "%')");
                        break;
                    case 3:
                        array_push($having, '(`' . $column['db_field_as'] . "` LIKE '" . $column['filter'] . "%')");
                        break;
                    case 4: //LEER
                        // $having[] =  function ($q) use ($column) {
                        //    $q->havingRaw($column['db_field_as'])->orhavingRaw($column['db_field_as'], '=', '')->orhavingRaw($column['db_field_as'], '=', '0000-00-00');
                        // });
                        break;
                    case 5:  //NICHT LEER
                        array_push($having, '(`' . $column['db_field_as'] . "` <> '')");
                        array_push($having, '(`' . $column['db_field_as'] . "` <> '0000-00-00')");
                        break;
                    case 6:
                        array_push($having, '(`' . $column['db_field_as'] . "` = '" . $column['filter'] . "')");
                        break;
                    case 7:
                        array_push($having, '(`' . $column['db_field_as'] . "` <> '" . $column['filter'] . "')");
                        break;
                    case 8:
                        array_push($having, '(`' . $column['db_field_as'] . "` > '" . $column['filter'] . "')");
                        // array_push( $having, "(`".$column['db_field_as']."` <> '')");
                        break;
                    case 9:
                        array_push($having, '(`' . $column['db_field_as'] . "` < '" . $column['filter'] . "')");
                        // array_push( $having, "(`".$column['db_field_as']."` <> '')");
                        break;
                    case 10:
                        array_push($having, '(`' . $column['db_field_as'] . "` >= '" . $column['filter'] . "')");
                        // array_push( $having, "(`".$column['db_field_as']."` <> '')");
                        break;
                    case 11:
                        array_push($having, '(`' . $column['db_field_as'] . "` <= '" . $column['filter'] . "')");
                        // array_push( $having, "(`".$column['db_field_as']."` <> '')");
                        break;
                    case 12:
                        $sqldate = date('Y-m-d', strtotime($column['filter']));
                        array_push($having, '(`' . $column['db_field_as'] . "` = '" . $sqldate . "')");
                        break;
                    case 13:
                        $sqldate = date('Y-m-d', strtotime($column['filter']));
                        array_push($having, '(`' . $column['db_field_as'] . "` <= '" . $sqldate . "')");
                        array_push($having, '(`' . $column['db_field_as'] . "` <> '0000-00-00')");
                        break;
                    case 14:
                        $sqldate = date('Y-m-d', strtotime($column['filter']));
                        array_push($having, '(`' . $column['db_field_as'] . "` >= '" . $sqldate . "')");
                        array_push($having, '(`' . $column['db_field_as'] . "` <> '0000-00-00')");
                        break;
                    case 1:
                    default:
                        array_push($having, '(`' . $column['db_field_as'] . "` LIKE '%" . $column['filter'] . "%')");
                        break;
                }
            }
        }

        $having_string = count($having) ? implode(' AND ', $having) : true;

        $vlg = DB::table('landesgruppen')
            ->select(DB::raw('landesgruppe as vlandesgruppe'), 'id');
        $vbg = DB::table('bezirksgruppen')
            ->select(DB::raw('bezirksgruppe as vbezirksgruppe'), 'id');
        $alg = DB::table('landesgruppen')
            ->select(DB::raw('landesgruppe as alandesgruppe'), 'id');
        $abg = DB::table('bezirksgruppen')
            ->select(DB::raw('bezirksgruppe as abezirksgruppe'), 'id');
        $vkat = DB::table('veranstaltungskategorien')
            ->select(DB::raw('name as veranstaltungskategorie'), 'id');
        $vtyp = DB::table('veranstaltungstypen')
            ->select(DB::raw('name as veranstaltungstyp'), 'id');

        $minmaxDate = DB::table('termine')
            ->select('veranstaltung_id', DB::raw('MIN(date) as erstertermin'), DB::raw('MAX(date) as letztertermin'), DB::RAW('COUNT(veranstaltung_id) as termine_anzahl'))
            ->groupBy('termine.veranstaltung_id');

        $veranstaltungen = Veranstaltungen::select('veranstaltungen.*', 'veranstaltungskategorie', 'veranstaltungstyp', 'termine_anzahl', DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.id) as meldungen_alle'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.abgelehnt) as meldungen_abgelehnt'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.angenommen) as meldungen_angenommen'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.zugesagt) as meldungen_zugesagt'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.bestaetigt) as meldungen_bestaetigt'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.bezahlt) as meldungen_bezahlt'), DB::RAW('COUNT(DISTINCT veranstaltung_meldungen.storniert) as meldungen_storniert'), 'letztertermin', 'erstertermin', 'vlandesgruppe', 'alandesgruppe', 'vbezirksgruppe', 'abezirksgruppe')
            ->leftjoinSub($vlg, 'vlandesgruppen', 'vlandesgruppen.id', '=', 'veranstaltungen.veranstalter_landesgruppe_id')
            ->leftjoinSub($vbg, 'vbezirksgruppen', 'vbezirksgruppen.id', '=', 'veranstaltungen.veranstalter_bezirksgruppe_id')
            ->leftjoinSub($alg, 'alandesgruppen', 'alandesgruppen.id', '=', 'veranstaltungen.ausrichter_landesgruppe_id')
            ->leftjoinSub($abg, 'abezirksgruppen', 'abezirksgruppen.id', '=', 'veranstaltungen.ausrichter_bezirksgruppe_id')
            ->leftjoin('veranstaltung_meldungen', 'veranstaltungen.id', '=', 'veranstaltung_meldungen.veranstaltung_id')
            ->leftjoinSub($vkat, 'vkats', 'veranstaltungen.veranstaltungskategorie_id', '=', 'vkats.id')
            ->leftjoinSub($vtyp, 'vtypen', 'veranstaltungen.veranstaltungstyp_id', '=', 'vtypen.id')
            ->leftjoinSub($minmaxDate, 'jtermine', function ($join) {
                $join->on('veranstaltungen.id', '=', 'jtermine.veranstaltung_id');
            })
            ->where(function ($query) use ($columns) {
                foreach ($columns as $column) {

                    if ($column['filterable'] == true && $column['filtertype'] != 0) {

                        if ($column['db_field_as']) {
                            $column['db_field'] = $column['db_field_as'];
                        }
                        $table = $column['table'] ? $column['table'] . '.' : '';

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
                            $query->where($table . $column['db_field'], 'LIKE', "'%" . $search . "%'");
                            $first = false;
                        } else {
                            $query->orWhere($table . $column['db_field'], 'LIKE', "'%" . $search . "%'");
                        }
                    }
                }
            })
            ->groupBy('veranstaltungen.id')
            ->havingRaw($having_string)
            ->orderBy($sortField, $sortDirection)
            ->paginate($pagination);

        return VeranstaltungenResource::collection($veranstaltungen);

        return $veranstaltungen;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function arr_udiffassocFun($x, $y)
    {
        return ($x === $y) ? 0 : 1;
    }

    public function store(Request $request)
    {

        if ($request->id) {
            $veranstaltung = Veranstaltung::find($request->id);
        } else {
            $veranstaltung = new Veranstaltung();
        }

        // return [
        //    'equal' => array_udiff_assoc($veranstaltung->termine->toArray(),  $request->termine, function($a, $b)
        //    {
        //       if ($a['id']!==$b['id'])
        //         {
        //         return 0;
        //         }
        //         return 1;
        //       }),
        //    'diff' => array_udiff_assoc($veranstaltung->termine->toArray(),  $request->termine, function($a, $b)
        //    {
        //       if ($a['id']===$b['id'])
        //         {
        //         return 0;
        //         }
        //         return ($a['id']>$b['id'])?1:-1;
        //       }),
        //    'a_alt' => $veranstaltung->termine,
        //    'b_neu' => $request->termine
        // ];

        $veranstaltung->name = $request->name;
        $veranstaltung->beschreibung = $request->beschreibung;
        $veranstaltung->ausrichter_landesgruppe_id = $request->ausrichter['landesgruppe']['id'];
        $veranstaltung->veranstalter_landesgruppe_id = $request->veranstalter['landesgruppe']['id'];
        $veranstaltung->ausrichter_bezirksgruppe_id = $request->ausrichter['bezirksgruppe']['id'];
        $veranstaltung->veranstalter_bezirksgruppe_id = $request->veranstalter['bezirksgruppe']['id'];
        $veranstaltung->veranstalter_bund = $request->veranstalter['bund'];
        $veranstaltung->veranstaltungskategorie_id = $request->kategorie['id'];
        $veranstaltung->veranstaltungstyp_id = $request->typ['id'];
        $veranstaltung->untertitel = $request->untertitel;
        $veranstaltung->beschreibung = $request->beschreibung;

        $veranstaltung->zeitablauf = $request->zeitablauf;
        $veranstaltung->teilnehmer_min = $request->teilnehmer_min;
        $veranstaltung->teilnehmer_max = $request->teilnehmer_max;
        $veranstaltung->hunde_min = $request->hunde_min;
        $veranstaltung->hunde_max = $request->hunde_max;
        $veranstaltung->aufgaben_id = $request->aufgaben_id;
        $veranstaltung->aufgaben_anzahl = $request->aufgaben_anzahl;
        $veranstaltung->teilnehmer_limit_min = $request->teilnehmer_limit_min;
        $veranstaltung->teilnehmer_limit_max = $request->teilnehmer_limit_max;
        $veranstaltung->hunde_limit_min = $request->hunde_limit_min;
        $veranstaltung->hunde_limit_max = $request->hunde_limit_max;
        $veranstaltung->sonderleiter1_id = $request->sonderleiter1['id'];
        $veranstaltung->sonderleiter2_id = $request->sonderleiter2['id'];
        $veranstaltung->pruefungsleiter_id = $request->pruefungsleiter['id'];
        $veranstaltung->meldeadresse_id = $request->meldeadresse['id'];

        $veranstaltung->vaort_name = $request->veranstaltungsort['name'];
        $veranstaltung->vaort_strasse = $request->veranstaltungsort['strasse'];
        $veranstaltung->vaort_postleitzahl = $request->veranstaltungsort['postleitzahl'];
        $veranstaltung->vaort_ort = $request->veranstaltungsort['ort'];
        $veranstaltung->vaort_adresszusatz = $request->veranstaltungsort['adresszusatz'];
        $veranstaltung->vaort_land = $request->veranstaltungsort['land'];
        $veranstaltung->vaort_laengengrad = $request->veranstaltungsort['laengengrad'];
        $veranstaltung->vaort_breitengrad = $request->veranstaltungsort['breitengrad'];
        $veranstaltung->vaort_beschreibung = $request->veranstaltungsort['beschreibung'];

        $veranstaltung->valokal_name = $request->veranstaltungslokal['name'];
        $veranstaltung->valokal_strasse = $request->veranstaltungslokal['strasse'];
        $veranstaltung->valokal_postleitzahl = $request->veranstaltungslokal['postleitzahl'];
        $veranstaltung->valokal_ort = $request->veranstaltungslokal['ort'];
        $veranstaltung->valokal_adresszusatz = $request->veranstaltungslokal['adresszusatz'];
        $veranstaltung->valokal_land = $request->veranstaltungslokal['land'];
        $veranstaltung->valokal_laengengrad = $request->veranstaltungslokal['laengengrad'];
        $veranstaltung->valokal_breitengrad = $request->veranstaltungslokal['breitengrad'];
        $veranstaltung->valokal_beschreibung = $request->veranstaltungslokal['beschreibung'];

        $veranstaltung->meldung_notwendig_id = $request->meldung['notwendig']['id'];
        $veranstaltung->meldung_adresse_opt_id = $request->meldung['meldeadresse_opt']['id'];
        $veranstaltung->meldung_start = $request->meldung['meldestart'];
        $veranstaltung->meldung_schluss = $request->meldung['meldeschluss'];
        $veranstaltung->meldung_schluss_ausstellung_1 = $request->meldung['meldeschluss_ausstellung_1'];
        $veranstaltung->meldung_schluss_ausstellung_2 = $request->meldung['meldeschluss_ausstellung_2'];
        $veranstaltung->meldung_schluss_ausstellung_3 = $request->meldung['meldeschluss_ausstellung_3'];
        $veranstaltung->meldung_meldegeld_mitglieder = $request->meldung['meldegeld_mitglieder'];
        $veranstaltung->meldung_meldegeld_nichtmitglieder = $request->meldung['meldegeld_nichtmitglieder'];
        $veranstaltung->meldung_meldegeld_zahlungsfrist = $request->meldung['meldegeld_zahlungsfrist'];

        // $veranstaltung->meldung_unterlagen_jagdlich = $request->meldung['unterlagen_jgd'];
        // $veranstaltung->meldung_unterlagen_nichtjagdlich = $request->select['_unterlagen_jagdlich'];

        // $veranstaltung->meldeadresse_vorname = $request->meldeadresse['vorname'];
        // $veranstaltung->meldeadresse_nachname = $request->meldeadresse['nachname'];
        // $veranstaltung->meldeadresse_strasse = $request->meldeadresse['strasse'];
        // $veranstaltung->meldeadresse_postleitzahl = $request->meldeadresse['postleitzahl'];
        // $veranstaltung->meldeadresse_ort = $request->meldeadresse['ort'];
        // $veranstaltung->meldeadresse_adresszusatz = $request->meldeadresse['adresszusatz'];
        // $veranstaltung->meldeadresse_land = $request->meldeadresse['land'];
        // $veranstaltung->meldeadresse_telefon_1 = $request->meldeadresse['telefon_1'];
        // $veranstaltung->meldeadresse_email = $request->meldeadresse['email_1'];
        // $veranstaltung->meldeadresse_telefon = $request->meldeadresse['telefon'];
        // $veranstaltung->meldeadresse_email = $request->meldeadresse['email'];

        $veranstaltung->zahlung_optionen_id = $request->zahlung['zahlungsoptionen']['id'];
        $veranstaltung->zahlung_art_id = $request->zahlung['art']['id'];
        $veranstaltung->zahlung_bic = $request->zahlung['bic'];
        $veranstaltung->zahlung_iban = $request->zahlung['iban'];
        $veranstaltung->zahlung_bankname = $request->zahlung['bankname'];

        $veranstaltung->voraussetzungen = $request->voraussetzungen;
        $veranstaltung->tierarzt_vorschriften = $request->tierarzt_vorschriften;

        $veranstaltung->save();

        $veranstaltung->termine()->delete();

        foreach ($request->termine as $termin) {
            $t = new Termin();
            $t->date = $termin['date'];
            $t->beginn = $termin['beginn'];
            $t->ende = $termin['ende'];
            // $t->beschreibung = $termin['beschreibung'];
            $t->beschreibung = 'Zweiter Test';
            $veranstaltung->termine()->save($t);
        }

        // foreach ($request->meldungen as $meldung_client) {
        //    if ($meldung_client['id']) $meldung_server = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($meldung_client['id']);
        //    if ($meldung_client['id'] == 0 || !$meldung_server ) $meldung_server = new VeranstaltungMeldung;

        //    $meldung_server->startpos = $meldung_client['startpos'];
        //    $meldung_server->anmelder_id = $meldung_client['anmelder_id'];
        //    $meldung_server->mitglied_id = $meldung_client['mitglied_id'];
        //    $meldung_server->hund_id = $meldung_client['hund_id'];
        //    $meldung_server->bezahlt = $meldung_client['bezahlt'];
        //    $meldung_server->angemeldet_am = $meldung_client['angemeldet_am'];
        //    $meldung_server->storniert = $meldung_client['storniert'];
        //    $meldung_server->storniert_am = $meldung_client['storniert_am'];
        //    $meldung_server->angenommen = $meldung_client['angenommen'];
        //    $meldung_server->angenommen_am = $meldung_client['angenommen_am'];
        //    $meldung_server->angenommen_bemerkung = $meldung_client['angenommen_bemerkung'];
        //    $meldung_server->angenommen_mail = $meldung_client['angenommen_mail'];
        //    $meldung_server->abgelehnt = $meldung_client['abgelehnt'];
        //    $meldung_server->abgelehnt_am = $meldung_client['abgelehnt_am'];
        //    $meldung_server->abgelehnt_bemerkung = $meldung_client['abgelehnt_bemerkung'];
        //    $meldung_server->abgelehnt_mail = $meldung_client['abgelehnt_mail'];
        //    $meldung_server->zugesagt = $meldung_client['zugesagt'];
        //    $meldung_server->zugesagt_am = $meldung_client['zugesagt_am'];
        //    $meldung_server->zugesagt_bemerkung = $meldung_client['zugesagt_bemerkung'];
        //    $meldung_server->zugesagt_mail = $meldung_client['zugesagt_mail'];
        //    // $meldung_server->infomail = $meldung_client['infos_mail'];
        //    // $meldung_server->vorname = $meldung_client['person']['vorname'];
        //    // $meldung_server->nachname = $meldung_client['person']['nachname'];
        //    // $meldung_server->strasse = $meldung_client['person']['strasse'];
        //    // $meldung_server->postleitzahl = $meldung_client['person']['postleitzahl'];
        //    // $meldung_server->ort = $meldung_client['person']['ort'];
        //    // $meldung_server->adresszusatz = $meldung_client['person']['adresszusatz'];
        //    // $meldung_server->land = $meldung_client['person']['land'];
        //    // $meldung_server->telefon_1 = $meldung_client['person']['telefon_1'];
        //    // $meldung_server->telefon_2 = $meldung_client['person']['telefon_2'];
        //    // $meldung_server->email_1 = $meldung_client['person']['email_1'];
        //    // $meldung_server->email_2 = $meldung_client['person']['email_2'];
        //    // $meldung_server->mitgliedsnummer = $meldung_client['person']['mitgliedsnummer'];
        //    // $meldung_server->hundefuehrer.vorname = $meldung_client['hf']['vorname'];
        //    // $meldung_server->hundefuehrer.nachname = $meldung_client['hf']['nachname'];
        //    // $meldung_server->hundefuehrer.strasse = $meldung_client['hf']['strasse'];
        //    // $meldung_server->hundefuehrer.postleitzahl = $meldung_client['hf']['postleitzahl'];
        //    // $meldung_server->hundefuehrer.ort = $meldung_client['hf']['ort'];
        //    // $meldung_server->hundefuehrer.adresszusatz = $meldung_client['hf']['adresszusatz'];
        //    // $meldung_server->hundefuehrer.land = $meldung_client['hf']['land'];
        //    // $meldung_server->hundefuehrer.telefon_1 = $meldung_client['hf']['telefon_1'];
        //    // $meldung_server->hundefuehrer.telefon_2 = $meldung_client['hf']['telefon_2'];
        //    // $meldung_server->hundefuehrer.email_1 = $meldung_client['hf']['email_1'];
        //    // $meldung_server->hundefuehrer.email_2 = $meldung_client['hf']['email_2'];
        //    // $meldung_server->hundefuehrer.mitgliedsnummer = $meldung_client['hf']['mitgliedsnummer'];
        //    // $meldung_server->hund.name = $meldung_client['hund']['name'];
        //    // $meldung_server->hund.farb_name = $meldung_client['hund']['farb_name'];
        //    // $meldung_server->hund.geschlecht = $meldung_client['hund']['geschlecht'];
        //    // $meldung_server->hund.rasse_name = $meldung_client['hund']['rasse_name'];
        //    // $meldung_server->hund.zuchtbuchnummer = $meldung_client['hund']['zuchtbuchnummer'];
        //    // $meldung_server->hund.bemerkung = $meldung_client['hund']['bemerkung'];
        //    // $meldung_server->hund.interne_vermerke = $meldung_client['hund']['interne_vermerke'];
        //    // $meldung_server->hund.wurfdatum = $meldung_client['hund']['wurfdatum'];
        //    // $meldung_server->hund.zuchthund = $meldung_client['hund']['zuchthund'];
        //    // $meldung_server->hund.id = $meldung_client['hund']['id'];
        //    $meldung_server->save();
        // }

        $richter_ids = array_map(function ($richter) {
            return $richter['richter_id'];
        }, $request->richter);

        $veranstaltung->richter()->sync($richter_ids);

        $aufgaben_id = 0;
        if (count($request->aufgaben)) {
            $va_aufgaben = Veranstaltungsaufgaben::find($request->aufgaben_id);

            if (! $va_aufgaben) {
                $va_aufgaben = new Veranstaltungsaufgaben();
            }

            foreach ($request->aufgaben as $key => $aufgabe) {
                $va_aufgaben->{'r' . ($key + 1) . '_id'} = $aufgabe['richter'];
                $va_aufgaben->{'stewart' . ($key + 1)} = $aufgabe['stewart'];
                $va_aufgaben->{'pmax' . ($key + 1)} = $aufgabe['p_max'];
                $va_aufgaben->{'preq' . ($key + 1)} = $aufgabe['p_benoetigt'];
                $va_aufgaben->{'name' . ($key + 1)} = $aufgabe['name'];
            }
            for ($i = count($request->aufgaben) + 1; $i <= 12; $i++) {
                $va_aufgaben->{'r' . $i . '_id'} = null;
                $va_aufgaben->{'stewart' . $i} = null;
                $va_aufgaben->{'pmax' . $i} = null;
                $va_aufgaben->{'preq' . $i} = null;
                $va_aufgaben->{'name' . $i} = null;
            }
            $va_aufgaben->veranstaltung_id = $veranstaltung->id;
            $va_aufgaben->save();
            $aufgaben_id = $va_aufgaben->id;
        }
        $veranstaltung->aufgaben_id = $aufgaben_id;
        $veranstaltung->aufgaben_anzahl = count($request->aufgaben);
        $veranstaltung->save();

        return [
            'aufgaben_id' => $aufgaben_id,
            'veranstaltung' => $veranstaltung,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function suche(Request $request)
    {

        $termin_min = $request->datum_von;
        $termin_max = $request->datum_bis;
        $kategorie_id = $request->kategorie_id;
        $typ_id = $request->typ_id;
        $landesgruppe_id = $request->landesgruppe_id;
        $bezirksgruppe_id = $request->bezirksgruppe_id;
        $plz = $request->plz;
        $umkreis = $request->umkreis;
        $gruppe_id = $request->gruppe_id;
        // $person_id = $request->person_id;
        $person_id = $request->person ? Auth::user()->person->get('id') : ($request->person_id ? $request->person_id : 0);

        $limit = $request->gruppe_id ? 2000 : 100;

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

        $minmaxDate = DB::table('termine')
            ->select('veranstaltung_id', DB::raw('MIN(date) as erstertermin'), DB::raw('MAX(date) as letztertermin'), DB::RAW('COUNT(veranstaltung_id) as termine_anzahl'))
            ->groupBy('termine.veranstaltung_id');

        $termineDate = DB::table('termine')
            ->select('veranstaltung_id', 'date', 'beginn', 'ende')
            ->whereDate('date', '<=', $termin_max)
            ->whereDate('date', '>=', $termin_min);

        $dates = DB::table('termine')
            ->select('date');

        $veranstaltungen = Veranstaltungen::with(['sonderleiter1', 'sonderleiter2', 'pruefungsleiter', 'veranstalter_landesgruppe', 'veranstalter_bezirksgruppe', 'ausrichter_landesgruppe', 'ausrichter_bezirksgruppe', 'richter', 'termine', 'veranstaltungskategorie', 'unterlagen_jagdlich', 'unterlagen_nichtjagdlich'])
            ->select('veranstaltungen.*', 'erstertermin', 'letztertermin', 'termine_anzahl')
            ->leftjoinSub($minmaxDate, 'jtermine', function ($join) {
                $join->on('veranstaltungen.id', '=', 'jtermine.veranstaltung_id');
            })
            ->when($typ_id != 0, function ($query) use ($typ_id) {
                return $query->where('veranstaltungstyp_id', '=', $typ_id);
            })
            ->when($kategorie_id != 0, function ($query) use ($kategorie_id) {
                return $query->where('veranstaltungskategorie_id', '=', $kategorie_id);
            })
            ->when($landesgruppe_id != 0, function ($query) use ($landesgruppe_id) {
                return $query->where('ausrichter_landesgruppe_id', '=', $landesgruppe_id);
            })
            ->when($bezirksgruppe_id != 0, function ($query) use ($bezirksgruppe_id) {
                return $query->where('ausrichter_bezirksgruppe_id', '=', $bezirksgruppe_id);
            })
            ->when($gruppe_id != 0, function ($query) use ($gruppe_id) {
                return $query->where(function ($q) use ($gruppe_id) {
                    $q->where('ausrichter_id', '=', $gruppe_id)
                        ->orWhere('veranstalter_id', '=', $gruppe_id);
                });
            })
            ->when($person_id != 0, function ($query) use ($person_id) {
                return $query->whereHas('meldungen', function ($q) use ($person_id) {
                    $q->where('anmelder_id', '=', $person_id)
                        ->orWhere('hundefuehrer_id', '=', $person_id);
                });
            })
            ->when($termin_min != '0000-00-00', function ($query) use ($termin_min) {
                return $query->whereHas('termine', function ($query) use ($termin_min) {
                    $query->whereDate('date', '>=', $termin_min);
                });
            })
            ->when($termin_max != '0000-00-00', function ($query) use ($termin_max) {
                return $query->whereHas('termine', function ($query) use ($termin_max) {
                    $query->whereDate('date', '<=', $termin_max);
                });
            })
            ->when(count($plz_ids), function ($query) use ($plz_ids) {
                $query->whereIn('vaort_postleitzahl', $plz_ids);
            })
            ->limit($limit)->orderBy('erstertermin', 'desc')->get();

        $tree = [];

        foreach ($veranstaltungen as $key => $val) {
            $tree[$val->veranstaltungskategorie_id][$val->veranstaltungstyp_id][] = $key;
            // array_push($tree[$va->veranstaltungskategorie_id], [ $va->veranstaltungstyp_id => $va->id ]);
        }

        return [
            'ergebnisliste' => VeranstaltungssucheResource::collection($veranstaltungen),
            'anzahl' => 0,
            'tree' => $tree,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_teilnehmer(Request $request)
    {

        $user_id = Auth::id();
        $isAllowed = true;

        $input = $request->all();

        foreach ($input['meldungen'] as $meldung) {

            $m = VeranstaltungMeldung::with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->find($meldung['id']);

            if (! $m) {
                $m = new VeranstaltungMeldung();
                $m->veranstaltung_id = $meldung['veranstaltung_id'];
                $m->startpos = $meldung['startpos'];
                // $m->anmelder_id = $meldung['anmelder_id'];
                // $m->mitglied_id = $meldung['mitglied_id'];
                // $m->hund_id = $meldung['mitglied_id'];
                $m->bezahlt = $meldung['bezahlt'];
                $m->angemeldet_am = $meldung['angemeldet_am'];
                $m->storniert = $meldung['storniert'];
                $m->storniert_am = $meldung['storniert_am'];
                $m->angenommen = $meldung['angenommen'];
                $m->angenommen_am = $meldung['angenommen_am'];
                $m->angenommen_bemerkung = $meldung['angenommen_bemerkung'];
                $m->angenommen_mail = $meldung['angenommen_mail'];
                $m->abgelehnt = $meldung['abgelehnt'];
                $m->abgelehnt_am = $meldung['abgelehnt_am'];
                $m->abgelehnt_bemerkung = $meldung['abgelehnt_bemerkung'];
                $m->abgelehnt_mail = $meldung['abgelehnt_mail'];
                $m->zugesagt = $meldung['zugesagt'];
                $m->zugesagt_am = $meldung['zugesagt_am'];
                $m->zugesagt_bemerkung = $meldung['zugesagt_bemerkung'];
                $m->zugesagt_mail = $meldung['zugesagt_mail'];
                // $m->infomail = $meldung['infomail'];
                $m->team_id = $meldung['team_id'];
                // // anmelder
                // $m->anmelder.vorname = $meldung['anmelderable.vorname'];
                // $m->anmelder.nachname = $meldung['anmelderable.nachname'];
                // $m->anmelder.strasse = $meldung['anmelderable.strasse'];
                // $m->anmelder.postleitzahl = $meldung['anmelderable.postleitzahl'];
                // $m->anmelder.ort = $meldung['anmelderable.ort'];
                // $m->anmelder.adresszusatz = $meldung['anmelderable.adresszusatz'];
                // $m->anmelder.land = $meldung['anmelderable.land'];
                // $m->anmelder.telefon_1 = $meldung['anmelderable.telefon_1'];
                // $m->anmelder.telefon_2 = $meldung['anmelderable.telefon_2'];
                // $m->anmelder.email_1 = $meldung['anmelderable.email_1'];
                // $m->anmelder.email_2 = $meldung['anmelderable.email_2'];
                // $m->anmelder.mitgliedsnummer = $meldung['anmelderable.mitgliedsnummer'];
                // // hundefuehrer
                // $m->hundefuehrer.vorname = $meldung['hundefuehrerable.vorname'];
                // $m->hundefuehrer.nachname = $meldung['hundefuehrerable.nachname'];
                // $m->hundefuehrer.strasse = $meldung['hundefuehrerable.strasse'];
                // $m->hundefuehrer.postleitzahl = $meldung['hundefuehrerable.postleitzahl'];
                // $m->hundefuehrer.ort = $meldung['hundefuehrerable.ort'];
                // $m->hundefuehrer.adresszusatz = $meldung['hundefuehrerable.adresszusatz'];
                // $m->hundefuehrer.land = $meldung['hundefuehrerable.land'];
                // $m->hundefuehrer.telefon_1 = $meldung['hundefuehrerable.telefon_1'];
                // $m->hundefuehrer.telefon_2 = $meldung['hundefuehrerable.telefon_2'];
                // $m->hundefuehrer.email_1 = $meldung['hundefuehrerable.email_1'];
                // $m->hundefuehrer.email_2 = $meldung['hundefuehrerable.email_2'];
                // $m->hundefuehrer.mitgliedsnummer = $meldung['hundefuehrerable.mitgliedsnummer'];
                // // hund
                // $m->hund.name = $meldung['hundable.name'];
                // $m->hund.farb_name = $meldung['hundable.farb_name'];
                // $m->hund.geschlecht = $meldung['hundable.geschlecht'];
                // $m->hund.rasse_name = $meldung['hundable.rasse_name'];
                // $m->hund.zuchtbuchnummer = $meldung['hundable.zuchtbuchnummer'];
                // $m->hund.bemerkung = $meldung['hundable.bemerkung'];
                // $m->hund.interne_vermerke = $meldung['hundable.interne_vermerke'];
                // $m->hund.wurfdatum = $meldung['hundable.wurfdatum'];
                // $m->hund.zuchthund = $meldung['hundable.zuchthund'];
                // $m.hund.id = $meldung['hundable.id'];
                $m->save();
            } else {
                $m->startpos = $meldung['startpos'];
                // $m->anmelder_id = $meldung['anmelder_id'];
                // $m->mitglied_id = $meldung['mitglied_id'];
                // $m->hund_id = $meldung['mitglied_id'];
                $m->bezahlt = $meldung['bezahlt'];
                $m->angemeldet_am = $meldung['angemeldet_am'];
                $m->storniert = $meldung['storniert'];
                $m->storniert_am = $meldung['storniert_am'];
                $m->angenommen = $meldung['angenommen'];
                $m->angenommen_am = $meldung['angenommen_am'];
                $m->angenommen_bemerkung = $meldung['angenommen_bemerkung'];
                $m->angenommen_mail = $meldung['angenommen_mail'];
                $m->abgelehnt = $meldung['abgelehnt'];
                $m->abgelehnt_am = $meldung['abgelehnt_am'];
                $m->abgelehnt_bemerkung = $meldung['abgelehnt_bemerkung'];
                $m->abgelehnt_mail = $meldung['abgelehnt_mail'];
                $m->zugesagt = $meldung['zugesagt'];
                $m->zugesagt_am = $meldung['zugesagt_am'];
                $m->zugesagt_bemerkung = $meldung['zugesagt_bemerkung'];
                $m->zugesagt_mail = $meldung['zugesagt_mail'];
                // $m->infomail = $meldung['infomail'];
                $m->team_id = $meldung['team_id'];
                $m->save();
            }
        }

        return 'FERTIG!';
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Veranstaltung $veranstaltung)
    {

        // $veranstaltung = Veranstaltung::with(['termine', 'sonderleiter1', 'sonderleiter2', 'pruefungsleiter', 'meldungen', 'plberichtable', 'slberichtable', 'teams', 'richter', 'aufgaben'])->find($veranstaltung->id);
        // $id = Auth::id();

        return new VeranstaltungResource($veranstaltung);

        // $user = User::find($id);
        // $veranstaltung->termine;
        // $veranstaltung->sonderleiter1;
        // $veranstaltung->sonderleiter2;
        // $veranstaltung->pruefungsleiter;
        // $veranstaltung->anmeldungen;
        // $veranstaltung->teilnehmer;
        // $veranstaltung->unterlagen_jagdlich;
        // $veranstaltung->unterlagen_nichtjagdlich;

    }

    public function info(Veranstaltung $veranstaltung)
    {

        $id = Auth::id();

        return new VeranstaltungAnmeldungResource($veranstaltung);

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Veranstaltung $veranstaltung)
    {

        //  veranstaltung.id = $request->id

        $veranstaltung = Veranstaltung::find($request->id);
        $veranstaltung->name = $request->name;
        $veranstaltung->beschreibung = $request->beschreibung;
        $veranstaltung->ausrichter_landesgruppe_id = $request->ausrichter['landesgruppe']['id'];
        $veranstaltung->veranstalter_landesgruppe_id = $request->veranstalter['landesgruppe']['id'];
        $veranstaltung->ausrichter_bezirksgruppe_id = $request->ausrichter['bezirksgruppe']['id'];
        $veranstaltung->veranstalter_bezirksgruppe_id = $request->veranstalter['bezirksgruppe']['id'];
        $veranstaltung->veranstalter_bund = $request->veranstalter['bund'];
        $veranstaltung->veranstaltungskategorie_id = $request->kategorie['id'];
        $veranstaltung->veranstaltungstyp_id = $request->typ['id'];
        $veranstaltung->untertitel = $request->untertitel;
        $veranstaltung->beschreibung = $request->beschreibung;

        $veranstaltung->zeitablauf = $request->zeitablauf;
        $veranstaltung->teilnehmer_min = $request->teilnehmer_min;
        $veranstaltung->teilnehmer_max = $request->teilnehmer_max;
        $veranstaltung->hunde_min = $request->hunde_min;
        $veranstaltung->hunde_max = $request->hunde_max;
        $veranstaltung->teilnehmer_limit_min = $request->teilnehmer_limit_min;
        $veranstaltung->teilnehmer_limit_max = $request->teilnehmer_limit_max;
        $veranstaltung->hunde_limit_min = $request->hunde_limit_min;
        $veranstaltung->hunde_limit_max = $request->hunde_limit_max;
        $veranstaltung->aufgaben_anzahl = $request->aufgaben_anzahl;
        $veranstaltung->sonderleiter1_id = $request->sonderleiter1['id'];
        $veranstaltung->sonderleiter2_id = $request->sonderleiter2['id'];
        $veranstaltung->pruefungsleiter_id = $request->pruefungsleiter['id'];

        $veranstaltung->vaort_name = $request->veranstaltungsort['name'];
        $veranstaltung->vaort_strasse = $request->veranstaltungsort['strasse'];
        $veranstaltung->vaort_postleitzahl = $request->veranstaltungsort['postleitzahl'];
        $veranstaltung->vaort_ort = $request->veranstaltungsort['ort'];
        $veranstaltung->vaort_adresszusatz = $request->veranstaltungsort['adresszusatz'];
        $veranstaltung->vaort_land = $request->veranstaltungsort['land'];
        $veranstaltung->vaort_laengengrad = $request->veranstaltungsort['laengengrad'];
        $veranstaltung->vaort_breitengrad = $request->veranstaltungsort['breitengrad'];
        $veranstaltung->vaort_beschreibung = $request->veranstaltungsort['beschreibung'];

        $veranstaltung->valokal_name = $request->veranstaltungslokal['name'];
        $veranstaltung->valokal_strasse = $request->veranstaltungslokal['strasse'];
        $veranstaltung->valokal_postleitzahl = $request->veranstaltungslokal['postleitzahl'];
        $veranstaltung->valokal_ort = $request->veranstaltungslokal['ort'];
        $veranstaltung->valokal_adresszusatz = $request->veranstaltungslokal['adresszusatz'];
        $veranstaltung->valokal_land = $request->veranstaltungslokal['land'];
        $veranstaltung->valokal_laengengrad = $request->veranstaltungslokal['laengengrad'];
        $veranstaltung->valokal_breitengrad = $request->veranstaltungslokal['breitengrad'];
        $veranstaltung->valokal_beschreibung = $request->veranstaltungslokal['beschreibung'];

        $veranstaltung->meldung_notwendig_id = $request->meldung['notwendig']['id'];
        $veranstaltung->meldung_adresse_opt_id = $request->meldung['meldeadresse_opt']['id'];
        $veranstaltung->meldung_start = $request->meldung['meldestart'];
        $veranstaltung->meldung_schluss = $request->meldung['meldeschluss'];
        $veranstaltung->meldung_schluss_ausstellung_1 = $request->meldung['meldeschluss_ausstellung_1'];
        $veranstaltung->meldung_schluss_ausstellung_2 = $request->meldung['meldeschluss_ausstellung_2'];
        $veranstaltung->meldung_schluss_ausstellung_3 = $request->meldung['meldeschluss_ausstellung_3'];
        $veranstaltung->meldung_meldegeld_mitglieder = $request->meldung['meldegeld_mitglieder'];
        $veranstaltung->meldung_meldegeld_nichtmitglieder = $request->meldung['meldegeld_nichtmitglieder'];
        $veranstaltung->meldung_meldegeld_zahlungsfrist = $request->meldung['meldegeld_zahlungsfrist'];
        // $veranstaltung->meldung_unterlagen_jagdlich = $request->meldung['unterlagen_jgd'];
        // $veranstaltung->meldung_unterlagen_nichtjagdlich = $request->select['_unterlagen_jagdlich'];

        $veranstaltung->meldeadresse_vorname = $request->meldeadresse['vorname'];
        $veranstaltung->meldeadresse_nachname = $request->meldeadresse['nachname'];
        $veranstaltung->meldeadresse_strasse = $request->meldeadresse['strasse'];
        $veranstaltung->meldeadresse_postleitzahl = $request->meldeadresse['postleitzahl'];
        $veranstaltung->meldeadresse_ort = $request->meldeadresse['ort'];
        $veranstaltung->meldeadresse_adresszusatz = $request->meldeadresse['adresszusatz'];
        $veranstaltung->meldeadresse_land = $request->meldeadresse['land'];
        $veranstaltung->meldeadresse_telefon = $request->meldeadresse['telefon'];
        $veranstaltung->meldeadresse_email = $request->meldeadresse['email'];

        $veranstaltung->zahlung_optionen_id = $request->zahlung['zahlungsoptionen']['id'];
        $veranstaltung->zahlung_art_id = $request->zahlung['art']['id'];
        $veranstaltung->zahlung_bic = $request->zahlung['bic'];
        $veranstaltung->zahlung_iban = $request->zahlung['iban'];
        $veranstaltung->zahlung_bankname = $request->zahlung['bankname'];

        $veranstaltung->voraussetzungen = $request->voraussetzungen;
        $veranstaltung->tierarzt_vorschriften = $request->tierarzt_vorschriften;

        // $veranstaltung->termine = $request->termine;
        // $veranstaltung->termine()->delete();

        // return $veranstaltung->termine();

        $veranstaltung->save();

        foreach ($request->termine as $termin) {
            $t = new Termin();
            $t->date = $termin['date'];
            $t->beginn = $termin['beginn'];
            $t->ende = $termin['ende'];
            $t->beschreibung = $termin['beschreibung'];
            // $t->beschreibung = 'Zweiter Test';
            $veranstaltung->termine()->save($t);
        }

        return $veranstaltung;
    }

    /**
     * Get event with registration details for a specific person
     *
     * @return \Illuminate\Http\Response
     */
    public function meldung(Veranstaltung $veranstaltung, Request $request)
    {
        $person_id = $request->route('person_id');

        // If no person_id provided, use authenticated user's person
        if (! $person_id) {
            $user_id = Auth::id();
            if (! $user_id) {
                return response()->json([
                    'error' => 'Nicht authentifiziert',
                    'success' => false,
                    'data' => null,
                ], 401);
            }

            $user = User::find($user_id);
            if (! $user || ! $user->person) {
                return response()->json([
                    'error' => 'Keine Person für den authentifizierten Benutzer gefunden',
                    'success' => false,
                    'data' => null,
                ], 404);
            }

            $person_id = $user->person->id;
        }

        try {
            // Get event details
            $veranstaltung = Veranstaltung::with([
                'termine',
                'sonderleiter1',
                'sonderleiter2',
                'pruefungsleiter',
                'veranstaltungskategorie',
                'veranstaltungstyp',
                'ausrichter_landesgruppe',
                'ausrichter_bezirksgruppe',
                'veranstalter_landesgruppe',
                'veranstalter_bezirksgruppe',
            ])->find($veranstaltung->id);

            if (! $veranstaltung) {
                return response()->json([
                    'error' => 'Veranstaltung nicht gefunden',
                    'success' => false,
                    'data' => null,
                ], 404);
            }

            // Get registration details for the person
            $meldung = VeranstaltungMeldung::with([
                'anmelder',
                'hund',
                'hundefuehrer',
            ])
                ->where('veranstaltung_id', $veranstaltung->id)
                ->where(function ($query) use ($person_id) {
                    $query->where('anmelder_id', $person_id)
                        ->orWhere('hundefuehrer_id', $person_id);
                })
                ->first();

            return response()->json([
                'error' => false,
                'success' => 'Veranstaltung und Meldungsdaten erfolgreich geladen',
                'data' => [
                    'veranstaltung' => new VeranstaltungResource($veranstaltung),
                    'meldung' => $meldung ? [
                        'id' => $meldung->id,
                        'startpos' => $meldung->startpos,
                        'angemeldet_am' => $meldung->angemeldet_am,
                        'bezahlt' => $meldung->bezahlt,
                        'storniert' => $meldung->storniert,
                        'storniert_am' => $meldung->storniert_am,
                        'angenommen' => $meldung->angenommen,
                        'angenommen_am' => $meldung->angenommen_am,
                        'angenommen_bemerkung' => $meldung->angenommen_bemerkung,
                        'abgelehnt' => $meldung->abgelehnt,
                        'abgelehnt_am' => $meldung->abgelehnt_am,
                        'abgelehnt_bemerkung' => $meldung->abgelehnt_bemerkung,
                        'zugesagt' => $meldung->zugesagt,
                        'zugesagt_am' => $meldung->zugesagt_am,
                        'zugesagt_bemerkung' => $meldung->zugesagt_bemerkung,
                        'bestaetigt' => $meldung->bestaetigt,
                        'team_id' => $meldung->team_id,
                        'anmelder' => $meldung->anmelder,
                        'hundefuehrer' => $meldung->hundefuehrer,
                        'hund' => $meldung->hund,
                        'status' => $this->getMeldungStatus($meldung),
                    ] : null,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Daten: ' . $e->getMessage(),
                'success' => false,
                'data' => null,
            ], 500);
        }
    }

    /**
     * Get the status of a registration
     *
     * @param  \App\Models\VeranstaltungMeldung  $meldung
     * @return string
     */
    private function getMeldungStatus($meldung)
    {
        if ($meldung->storniert) {
            return 'storniert';
        }
        if ($meldung->abgelehnt) {
            return 'abgelehnt';
        }
        if ($meldung->bestaetigt) {
            return 'bestaetigt';
        }
        if ($meldung->zugesagt) {
            return 'zugesagt';
        }
        if ($meldung->angenommen) {
            return 'angenommen';
        }
        if ($meldung->bezahlt) {
            return 'bezahlt';
        }

        return 'angemeldet';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Veranstaltung $veranstaltung)
    {
        //
    }
}
