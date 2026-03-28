<?php

namespace App\Models;

use App\Traits\CheckActiveOwnership;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hund extends Model
{
    use CheckActiveOwnership;
    use HasFactory;

    protected $table = 'hunde';

    protected $with = ['rasse', 'farbe', 'zuchtbuchnummern', 'chipnummern', 'geschlecht',  'zuchtart', 'zuchtzulassung', 'verstorben'];

    protected $appends = ['alter'];

    public function getAlterAttribute()
    {
        return $this->wurfdatum ? Carbon::parse($this->wurfdatum)->diffInMonths(Carbon::now()) : '';
    }

    /**
     * Carbon-Caster für wurfdatum Feld (Datum)
     */
    protected function wurfdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function sterbedatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    public function verstorben()
    {
        return $this->hasOne(Verstorbene::class, 'hund_id', 'id')->withDefault(false);
    }

    public function setZuchthundAttribute($value)
    {
        ($value == 'Ja' || $value == true || $value == '1') ? $this->attributes['zuchthund'] = true : $this->attributes['zuchthund'] = false;
    }

    public function hundanlageantrag()
    {
        return $this->hasOne(Hundanlageantrag::class);
    }

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class, 'zwinger_id', 'id');
    }

    public function zwingers()
    {
        return $this->belongsToMany(Zwinger::class, 'hund_zwinger')
            ->withPivot('von', 'bis', 'anmerkung', 'leihstellung_id', 'leihstellung')
            ->using(HundZwinger::class);
    }

    public function status()
    {
        return $this->belongsTo(HundStatus::class, 'status_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function zuchtart()
    {
        return $this->belongsTo(OptionZuchtart::class, 'zuchtart_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function getZuchtartNameAttribute()
    {
        return $this->zuchtart_id ? $this->zuchtart->name : '';
    }

    public function zuchttauglichkeit()
    {
        return $this->belongsTo(OptionZuchttauglichkeit::class, 'zuchttauglichkeit_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    // public function todesursache()
    // {
    //    return $this->belongsTo(OptionTodesursache::class, 'todesursache_id', 'id')->withDefault([
    //       'id' => 0,
    //       'name' => 'Bitte auswählen',
    //    ]);
    // }

    public function getZuchttauglichkeitNameAttribute()
    {
        return $this->zuchttauglichkeit_id ? $this->zuchttauglichkeit->name : '';
    }

    public function chipnummern()
    {
        return $this->hasMany(Chipnummer::class)->orderBy('order', 'asc');
    }

    public function zuchtbuchnummern()
    {
        return $this->hasMany(Zuchtbuchnummer::class)->orderBy('order', 'asc');
    }

    public function leistungshefte()
    {
        return $this->hasMany(Leistungsheft::class)->orderBy('order', 'asc');
    }

    public function ahnentafeln()
    {
        return $this->hasMany(Ahnentafel::class)->orderBy('order', 'asc');
    }

    public function mutter()
    {
        return $this->belongsTo(Hund::class, 'mutter_id', 'id')->withDefault([
            'id' => 0,
            'name' => $this->mutter_name,
            'zuchtbuchnummer' => $this->mutter_zuchtbuchnummer,
        ]);
    }

    public function vater()
    {
        return $this->belongsTo(Hund::class, 'vater_id', 'id')->withDefault([
            'id' => 0,
            'name' => $this->vater_name,
            'zuchtbuchnummer' => $this->vater_zuchtbuchnummer,
        ]);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    public function image()
    {
        return $this->morphMany(Image::class, 'imageable')->first();
    }

    public function meldungen()
    {
        return $this->morphMany(VeranstaltungMeldung::class, 'hundable')
            ->with(['veranstaltung', 'anmelder', 'hundefuehrer'])
           // ->orderBy( Termin::select('date')->join('veranstaltungen', 'veranstaltungen.id', '=', 'termine.veranstaltung_id')->whereColumn('termine.veranstaltung_id', 'veranstaltungen.id')->latest('termine.date')->take(1));
            ->orderByDesc(Termin::select('date')->join('veranstaltungen', 'veranstaltungen.id', '=', 'termine.veranstaltung_id')->whereColumn('termine.veranstaltung_id', 'veranstaltung_meldungen.veranstaltung_id')->take(1));
    }

    public function anmeldungen()
    {
        return $this->morphMany(VeranstaltungAnmeldung::class, 'hundable');
    }

    public function wesenstest2()
    {
        return $this->hasOne(Wesenstest::class);
    }

    public function formwert()
    {
        return $this->hasMany(Pruefung::class)->where('bestanden', '=', '1')->whereIn('resultable_type', ['App\Models\Formwert_v0', 'App\Models\Formwert_v1', 'App\Models\Formwert_v2', 'App\Models\Formwert_v3'])->orderBy('datum');
    }

    public function wesenstest()
    {
        return $this->hasMany(Pruefung::class)->where('bestanden', '=', '1')->whereIn('resultable_type', ['App\Models\Wesenstest_v0', 'App\Models\Wesenstest_v1', 'App\Models\Wesenstest_v2'])->orderBy('datum');
    }

    public function geschlecht()
    {
        return $this->belongsTo(OptionGeschlechtHund::class, 'geschlecht_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function rasse()
    {
        return $this->belongsTo(Rasse::class, 'rasse_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
            'name_kurz' => '',
            'buchstabe' => '',
        ]);
    }

    public function farbe()
    {
        return $this->belongsTo(Farbe::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function personen()
    {
        return $this->belongsToMany(Person::class, 'hund_person')->withPivot('id', 'seit', 'bis', 'anmerkung', 'freigabe_id')->using(HundPerson::class)->orderByRaw('-bis asc')->orderBy('seit', 'desc');
    }

    public function eigentuemers()
    {
        return $this->hasMany(Eigentuemer::class)->with(['person', 'dokumente'])->orderByRaw('-bis asc')->orderBy('seit', 'desc');
    }

    public function eigentuemers_aktuell()
    {
        return $this->getAllOwnersWithDetails($this->id, auth()->user()?->person_id);
    }

    public function hundefuehrers()
    {
        return $this->belongsToMany(Person::class, 'hund_hundefuehrer')->withPivot('gesperrt', 'gesperrt_von', 'gesperrt_bis', 'anmerkung')->using(HundHundefuehrer::class);
    }

    public function wurf()
    {
        return $this->belongsTo(Wurf::class); // ->orderBy('datum');
    }

    public function hdeduntersuchungen()
    {
        return $this->hasMany(HDEDUntersuchung::class)->orderBy('datum', 'desc');
    }

    public function gelenkuntersuchungen()
    {
        return $this->hasMany(Gelenkuntersuchung::class)->orderBy('datum', 'desc');
    }

    // public function gelenkuntersuchungen()
    // {
    //    return $this->morphToMany(Gelenkuntersuchung::class, 'untersuchungable')->orderBy('datum', 'desc');
    // }

    public function gentests()
    {
        return $this->hasMany(Gentest::class)->orderBy('datum', 'desc');
    }

    public function gentests_abgeleitet()
    {
        return $this->hasMany(GentestsAbgeleitet::class);
    }

    public function gentests_total()
    {
        return $this->hasMany(GentestsTotal::class);
    }

    public function ocduntersuchungen()
    {
        return $this->hasMany(OCDUntersuchung::class)->orderBy('datum', 'desc');
    }

    public function augenuntersuchungen()
    {
        return $this->hasMany(Augenuntersuchung::class)->orderBy('datum', 'desc');
    }

    public function goniountersuchung()
    {
        return $this->hasMany(Augenuntersuchung::class)->where('aktive_gonio', '=', '1')->orderBy('datum');
    }

    public function zahnstati()
    {
        return $this->hasMany(Zahnstatus::class)->orderBy('datum', 'desc');
    }

    public function rute()
    {
        return $this->hasOne(Rute::class);
    }

    public function patella()
    {
        return $this->hasOne(Patella::class);
    }

    public function fcp()
    {
        return $this->hasOne(FCP::class);
    }

    public function hodenuntersuchungen()
    {
        return $this->hasMany(Hoden::class)->orderBy('datum', 'desc');
    }

    public function blutprobeneinlagerungen()
    {
        return $this->hasMany(Blutprobeneinlagerung::class);
    }

    public function abstammungsnachweis()
    {
        return $this->hasOne(Abstammungsnachweis::class);
    }

    public function kardiobefunde()
    {
        return $this->hasMany(Kardiobefund::class)->orderBy('datum', 'desc');
    }

    public function epilepsiebefunde()
    {
        return $this->hasMany(Epilepsiebefund::class)->orderBy('datum', 'desc');
    }

    public function ureter()
    {
        return $this->hasOne(Ureter::class);
    }

    public function kaiserschnitte()
    {
        return $this->hasMany(Kaiserschnitt::class)->orderBy('datum', 'desc');
    }

    public function kastrationsterilisation()
    {
        return $this->hasOne(KastrationSterilisation::class);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('datum', 'desc');
    }

    public function vereinsstrafen()
    {
        return $this->morphToMany(Vereinsstrafe::class, 'vereinsstrafeable')->orderBy('updated_at', 'asc');
    }

    public function zuchtverbote()
    {
        return $this->morphMany(Zuchtverbot::class, 'zuchtverbotable')->orderBy('updated_at', 'asc');
    }

    public function gutachten()
    {
        return $this->hasOne(Gutachten::class);
    }

    public function anwartschaften()
    {
        return $this->hasMany(Anwartschaft::class);
    }

    public function titel()
    {
        return $this->hasMany(Titel::class);
    }

    public function titeltitel()
    {
        return $this->hasManyThrough(TitelTyp::class, Titel::class, 'hund_id', 'id', 'id', 'type_id');
    }

    public function pruefungen()
    {
        return $this->hasMany(Pruefung::class);
    }

    public function pruefungentitel()
    {
        return $this->hasManyThrough(PruefungTyp::class, Pruefung::class, 'hund_id', 'id', 'id', 'type_id')->where('bestanden', '=', 1);
    }

    public function temptitel()
    {
        return $this->hasOne(TempTitel::class);
    }

    public function temppruefungen()
    {
        return $this->hasOne(TempPruefung::class);
    }

    public function formwert_tmp()
    {
        return $this->hasOne(Formwert::class);
    }

    public function tpg()
    {
        return $this->hasOne(TPG::class);
    }

    public function zuchtzulassung()
    {
        return $this->hasOne(Zuchtzulassung::class)->withDefault(false);
    }

    public function zuchtzulassungsantraege()
    {
        return $this->hasMany(Zuchtzulassungsantrag::class);
    }

    public function wuerfe()
    {

        // return $this->hasMany(Wurf::class, 'mutter_id', 'id')->orderBy('wurfdatum', 'desc');
        return ($this->geschlecht_id == '2') ? $this->hasMany(Wurf::class, 'vater_id')->orderBy('wurfdatum', 'desc') : $this->hasMany(Wurf::class, 'mutter_id')->orderBy('wurfdatum', 'desc');
    }

    public function wuerfe_r()
    {

        // return $this->hasMany(Wurf::class, 'mutter_id', 'id')->orderBy('wurfdatum', 'desc');
        return $this->hasMany(Wurf::class, 'vater_id')->orderBy('wurfdatum', 'desc');
    }

    public function wuerfe_h()
    {

        // return $this->hasMany(Wurf::class, 'mutter_id', 'id')->orderBy('wurfdatum', 'desc');
        return $this->hasMany(Wurf::class, 'mutter_id')->orderBy('wurfdatum', 'desc');
    }

    public function wurfplaene()
    {

        // return $this->hasMany(Wurf::class, 'mutter_id', 'id')->orderBy('wurfdatum', 'desc');
        if ($this->geschlecht_id == '2') {
            return $this->hasMany(Wurfplan::class, 'huendin_id')->orderBy('geplant_von', 'desc');
        } else {
            return $this->hasMany(Wurfplan::class, 'huendin_id')->orderBy('geplant_von', 'desc');
        }
    }

    public function uebernahmeantraege()
    {
        return $this->hasMany(Uebernahmeantrag::class, 'hund_id', 'id')->orderBy('created_at', 'desc')->limit(1);
    }

    public function eigentuemerwechselantraege()
    {
        return $this->hasMany(Hundanlageantrag::class, 'hund_id', 'id')->whereIn('hundanlageantraege.typ_id', [1, 2, 3])->orderBy('created_at', 'desc')->limit(1);
    }

    public function eigentuemer()
    {
        return $this->getAllOwnersWithDetails($this->id, auth()->user()?->person_id);
    }
}
