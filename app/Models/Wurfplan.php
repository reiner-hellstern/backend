<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wurfplan extends Model
{
    use HasFactory;

    protected $table = 'wurfplaene';

    protected $with = ['huendin', 'anleger', 'rasse', 'zwinger'];

    protected function geplantVon(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function geplantBis(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function veroeffentlichtBis(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function huendin()
    {
        return $this->belongsTo(Hund::class, 'huendin_id');
    }

    public function anleger()
    {
        return $this->belongsTo(Hund::class, 'anleger_id');
    }

    public function rasse()
    {
        return $this->belongsTo(Rasse::class, 'rasse_id');
    }

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class, 'zwinger_id');
    }
}
