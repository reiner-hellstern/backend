<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leistungsheft extends Model
{
    use HasFactory;

    protected $table = 'leistungshefte';

    protected $fillable = [
        'hund_id',
        'besteller_id',
        'bestellt_am',
        'status_id',
        'gebuehr',
        'anmerkungen_besteller',
        'at_versendet_am',
        'vollstaendig',
        'bezahlt',
        'ausgestellt_am',
        'versendet_am',
        'bezahlt_am',
        'bemerkungen_drc',
        'bemerkungen_intern',
    ];

    protected $with = ['status', 'bezahlstatus',  'atstatus', 'kommentare', 'dokumente', 'besteller', 'anlagetyp'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    protected function bestelltAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function ausgestelltAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function versendetAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function bezahltAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function atversendetAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function atstatusDatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function status()
    {
        return $this->belongsTo(OptionLHStatus::class, 'status_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function besteller()
    {
        return $this->belongsTo(Person::class, 'besteller_id', 'id');
    }

    public function kommentare()
    {
        return $this->morphMany(Kommentar::class, 'kommentarable');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')
            ->withPivot('status')
            ->orderBy('updated_at', 'asc');
    }

    public function bezahlart()
    {
        return $this->belongsTo(OptionBezahlart::class, 'bezahlart_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function bezahlstatus()
    {
        return $this->belongsTo(OptionBezahlstatus::class, 'bezahlstatus_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function atstatus()
    {
        return $this->belongsTo(OptionATStandort::class, 'atstatus_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function anlagetyp()
    {
        return $this->belongsTo(OptionArtikelAnlagetyp::class, 'anlagetyp_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    //  public function getBezahlstatusOptionAttribute()
    //  {
    //     return $this->bezahlstatus_id ? ['name' => $this->bezahlstatus->name, 'id' => $this->bezahlstatus_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    //  }
}
