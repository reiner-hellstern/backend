<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtverbot extends Model
{
    use HasFactory;

    protected $table = 'zuchtverbote';

    protected $appends = ['aktiv'];

    protected $with = ['entscheider', 'dokumente', 'notizen', 'grund', 'status'];

    protected $guarded = [];

    public function zuchtverbotable()
    {
        return $this->morphTo();

    }

    public function verbotVon(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function verbotBis(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function entschiedenAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function beantragtAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function getAktivAttribute()
    {
        return $this->verbot_von < date('Y-m-d') && date('Y-m-d') < $this->verbot_bis ? 'aktiv' : '';
    }

    // public function grund()
    // {
    //    return $this->hasOne(Person::class);
    // }

    public function entscheider()
    {
        return $this->belongsTo(OptionZuchtverbotEntscheider::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function grund()
    {
        return $this->belongsTo(OptionZuchtverbotGrund::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function status()
    {
        return $this->belongsTo(OptionZuchtverbotStatus::class)->withDefault([
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
