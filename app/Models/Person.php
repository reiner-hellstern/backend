<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'personen';

    protected $fillable = [
        //  'mitgliedsnummer',
        'mitgliedsart',
        'anrede_access',
        'anrede_id',
        'geschlecht',
        'adelstitel',
        'akademischetitel',
        'vorname',
        'nachname_praefix',
        'nachname',
        'geboren',
        'gestorben',
        'post_anrede',
        'post_name',
        'post_co',
        'strasse',
        'adresszusatz',
        'postleitzahl',
        'ort',
        'postfach_plz',
        'postfach_nummer',
        'standard',
        'land',
        'laenderkuerzel',
        'land_id',
        'telefon_1',
        'telefon_2',
        'telefon_3',
        'email_1',
        'email_2',
        'website_1',
        'website_2',
        'kommentar',
        'zwingernummer',
        'geschlecht_id',
        'zwingername',
        'eintrittsdatum',
        'austrittsdatum',
        'nachname_ohne_praefix',
        'dsgvo',
        'zwingername_praefix',
        'zwingername_suffix',
        'nachname_ehemals',
        'shadow',
        'jagdschein',
        'long',
        'lat',
    ];

    protected $with = ['adressen', 'anrede'];

    //  protected $with = ['mitglied', 'anrede'];

    protected $appends = ['mitgliedsnummer'];

    protected function Geboren(): Attribute
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

    public function adressen()
    {
        return $this->hasMany(Personenadresse::class)->orderBy('aktiv', 'desc')->orderBy('bis', 'desc');
    }

    public function adresse()
    {
        return $this->hasMany(Personenadresse::class)->where('personenadressen.aktiv', 1);
    }

    public function anrede()
    {
        return $this->belongsTo(OptionAnrede::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function getAnredeOptionAttribute()
    {
        // return [ 'name' =>'Bitte auswählen', 'id' => 0 ];
        return $this->anrede_id ? ['name' => $this->anrede->name, 'id' => $this->anrede_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getAkademischerTitelOptionAttribute()
    {
        return ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getAdelstitelOptionAttribute()
    {
        return ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function akademischer_titel()
    {
        return $this->belongsTo(OptionAkademischerTitel::class, 'akademischer_titel_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function adelstitel()
    {
        return $this->belongsTo(OptionAdelstitel::class, 'adelstitel_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function anmeldungen()
    {
        return $this->morphMany(VeranstaltungMeldung::class, 'anmelderable');
    }

    public function hundefuehrermeldungen()
    {
        return $this->morphMany(VeranstaltungMeldung::class, 'hundefuehrerable');
    }

    public function mitglied()
    {
        return $this->hasOne(Mitglied::class, 'person_id');
    }

    public function getMitgliedsnummerAttribute()
    {
        $aktiveMitgliedschaft = $this->mitglied()->aktiv()->first();

        return $aktiveMitgliedschaft ? $aktiveMitgliedschaft->mitglied_nr : null;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function gruppen()
    {
        return $this->belongsToMany(Gruppe::class);
    }

    public function hunde()
    {
        return $this->belongsToMany(Hund::class)->withPivot('seit', 'bis')->using(HundPerson::class)->orderBy('wurfdatum', 'desc');
    }

    public function welpen()
    {
        return $this->belongsToMany(Welpen::class)->orderBy('wurfdatum', 'desc');
    }

    public function wuerfe()
    {
        return $this->hasMany(Wurf::class, 'zuechter_id')->orderBy('wurfdatum', 'desc');
    }

    public function wurfplaene()
    {
        return $this->hasMany(Wurfplan::class, 'anleger_id')->orderBy('geplant_von', 'desc');
    }

    public function zuchthunde()
    {
        return $this->belongsToMany(Hund::class)->where(function ($query) {
            $query->where('zuchthund', 1);
        });
    }

    public function huendinnen()
    {
        return $this->belongsToMany(Hund::class)->where(function ($query) {
            $query->where('geschlecht_id', '1');
        });
    }

    /**
     * Alle Zwinger einer Person (Many-to-Many)
     */
    public function zwingers()
    {
        return $this->belongsToMany(Zwinger::class, 'person_zwinger')
            ->withPivot('von', 'bis', 'zwingername', 'leihstellung', 'anmerkung')
            ->withTimestamps()
            ->orderBy('von', 'desc');
    }

    /**
     * Aktuell gültiger Zwinger basierend auf von/bis Datumsfeldern
     */
    public function zwinger()
    {
        return $this->belongsToMany(Zwinger::class, 'person_zwinger')
            ->withPivot('von', 'bis', 'zwingername', 'leihstellung', 'anmerkung')
            ->withTimestamps()
            ->where('von', '<=', now())
            ->where(function ($query) {
                $query->whereNull('bis')
                    ->orWhere('bis', '>=', now());
            })
            ->orderBy('von', 'desc')
            ->limit(1);
    }

    // Haupt-Zwinger für Backward-Compatibility (falls zwinger_id noch in DB existiert)
    public function hauptzwinger()
    {
        return $this->zwinger()->first();
    }

    public function zuechter()
    {
        return $this->hasOne(Zuechter::class);
    }

    public function richter()
    {
        return $this->hasOne(Richter::class);
    }

    public function getFcirichternummerAttribute()
    {
        return $this->richter->first() ? $this->richter()->first()->fcinummer : '';
        // return $this->richter()->first()->fcinummer;
    }

    public function zuchtwart()
    {
        return $this->hasOne(Zuchtwart::class);
    }

    public function arzt()
    {
        return $this->hasOne(Arzt::class);
    }

    public function funktionen()
    {
        return $this->belongsToMany(Funktion::class);
    }

    public function listen()
    {
        return $this->belongsToMany(Liste::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function dsgvoErklaerungen()
    {
        return $this->hasMany(DsgvoErklaerung::class);
    }

    public function aktiveDsgvoErklaerung()
    {
        return $this->hasOne(DsgvoErklaerung::class)->aktiv()->latestOfMany('zugestimmt_am');
    }

    public function hatAktiveDsgvoErklaerung(?int $stufe = null): bool
    {
        $query = $this->dsgvoErklaerungen()->aktiv();

        if ($stufe !== null) {
            $query->stufe($stufe);
        }

        return $query->exists();
    }

    public function vereinsstrafen()
    {
        return $this->morphMany(Vereinsstrafe::class, 'vereinsstrafeable')->orderBy('updated_at', 'asc');
    }

    public function zuchtverbote()
    {
        return $this->morphMany(Zuchtverbot::class, 'zuchtverbotable')->orderBy('updated_at', 'asc');
    }

    public function bestaetigungen()
    {
        return $this->hasMany(Bestaetigung::class, 'person_id');
        // return $this->hasMany(Bestaetigung::class, 'person_id')->withDefault([ 'dokumente' => [] ]);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    public function hundanlageantraege()
    {
        return $this->hasMany(Hundanlageantrag::class, 'antragsteller_id')->where(function ($query) {
            $query->where('show_in_profile', '1');
        });
    }

    public function bankverbindungen()
    {
        return $this->morphMany(Bankverbindung::class, 'bankverbindungable')
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Aktuelle gültige Bankverbindung für persönliche Abrechnungen
     */
    public function bankverbindung()
    {
        return $this->morphOne(Bankverbindung::class, 'bankverbindungable')
            ->where('aktiv', 1)
            ->where('gueltig_ab', '<=', now())
            ->where(function ($query) {
                $query->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', now());
            })
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Ausbilder relationship
     */
    public function ausbilder()
    {
        return $this->hasMany(Ausbilder::class);
    }

    /**
     * Aktiver Ausbilder
     */
    public function aktiverAusbilder()
    {
        return $this->hasOne(Ausbilder::class)->amtierend()->aktiv();
    }

    /**
     * Sonderleiter relationship
     */
    public function sonderleiter()
    {
        return $this->hasMany(Sonderleiter::class);
    }

    /**
     * Aktiver Sonderleiter
     */
    public function aktiverSonderleiter()
    {
        return $this->hasOne(Sonderleiter::class)->amtierend()->aktiv();
    }

    /**
     * Alle Veranstaltungs-Meldungen einer Person
     */
    public function veranstaltungsmeldungen()
    {
        return $this->hasMany(VeranstaltungMeldung::class, 'anmelder_id');
    }

    public function veranstaltungen()
    {
        return $this->belongsToMany(Veranstaltung::class, 'veranstaltung_meldungen', 'anmelder_id', 'veranstaltung_id')->withPivot('abgelehnt', 'angenommen', 'zugesagt', 'angemeldet_am', 'bestaetigt', 'bezahlt', 'storniert')->withTimestamps();
    }

    public function rechnungen()
    {
        return $this->hasMany(Rechnung::class, 'kreditor_id')->orderBy('created_at', 'desc');
    }
}
