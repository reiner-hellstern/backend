<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eigentuemer extends Model
{
    use HasFactory;

    protected $table = 'hund_person';

    protected $with = ['dokumente'];

    public function Seit(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value) && $value !== '0000-00-00') ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function Bis(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value) && $value !== '0000-00-00') ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('datum', 'desc');
    }
}
