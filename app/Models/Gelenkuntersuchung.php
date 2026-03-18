<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelenkuntersuchung extends Model
{
    use HasFactory;

    protected $table = 'gelenkuntersuchungen';

    protected $with = ['gelenkuntersuchungable'];

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function gelenkuntersuchungable()
    {
        return $this->morphTo();
    }
}
