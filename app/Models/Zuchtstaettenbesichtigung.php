<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtstaettenbesichtigung extends Model
{
    use HasFactory;

    protected $table = 'zuchtstaettenbesichtigungen';

    protected $with = ['status', 'grund', 'zuchtwart', 'antragsteller', 'zuchtstaette'];

    protected $guarded = [];

    protected $casts = [
        'bestaetigung_angaben' => 'boolean',
        'bestaetigung_zo_einhaltung' => 'boolean',
        'bestaetigung_zk_verfuegbarkeit' => 'boolean',
        'bestaetigung_wa_vorzeigen' => 'boolean',
        'bestaetigung_umzugsregeln' => 'boolean',
        'bestaetigung_bezahlung' => 'boolean',
        'bestaetigung_thematik_aktivierung' => 'boolean',
        'bestaetigung_zs_antrag' => 'boolean',
        'zw_anwaerter' => 'boolean',
        'freigabe_zw' => 'boolean',
        'freigabe_gs' => 'boolean',
        'aktivierung_automatisch' => 'boolean',
    ];

    public function terminAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function freigabeAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function freigabeGsAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function abgelehntAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function aktivierungAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function zuchtstaettenmaengel()
    {
        return $this->morphMany(Zuchtstaettenmangel::class, 'quelleable')->orderBy('updated_at', 'asc');
    }

    public function antragsteller()
    {
        return $this->belongsTo(Person::class);
    }

    public function freigabe_gs()
    {
        return $this->belongsTo(Person::class);
    }

    public function zuchtwart()
    {
        return $this->belongsTo(Zuchtwart::class);
    }

    public function zuchtstaette()
    {
        return $this->belongsTo(Zuchtstaette::class);
    }

    public function released_by()
    {
        return $this->belongsTo(Person::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionZstBesichtigungStatus::class)->withDefault([
            'id' => 0,
            'name' => 'nicht definiert',
        ]);
    }

    public function grund()
    {
        return $this->belongsTo(OptionZstBesichtigungGrund::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
