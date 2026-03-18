<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blutprobeneinlagerung extends Model
{
    use HasFactory;

    protected $table = 'blutprobeneinlagerungen';

    protected $fillable = [
        'hund_id',
        'labor_id',
        'arzt_id',
        'datum_blutentnahme',
        'datum_einlagerung',
        'labornummer',
        'erster_anfall',
        'anzahl_anfaelle',
        'ausschlussdiagnostik_am',
        'anmerkungen',
    ];

    protected function datumBlutentnahme(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function datumEinlagerung(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function ausschlussdiagnostikAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id');
    }

    public function arzt()
    {
        return $this->belongsTo(Arzt::class, 'arzt_id');
    }

    public function labor()
    {
        return $this->belongsTo(Labor::class, 'labor_id');
    }

    /**
     * Verwandte Hunde mit Epilepsie (Many-to-Many)
     */
    public function verwandteHunde()
    {
        return $this->belongsToMany(Hund::class, 'blutprobeneinlagerung_hund', 'blutprobeneinlagerung_id', 'hund_id')
            ->using(BlutprobeneinlagerungHund::class)
            ->withPivot('arzt_id', 'ausschlussdiagnostik_am')
            ->withTimestamps();
    }
}
