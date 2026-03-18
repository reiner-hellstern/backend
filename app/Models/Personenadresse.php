<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personenadresse extends Model
{
    use HasFactory;

    protected $table = 'personenadressen';

    protected $fillable = [
        'person_id',
        'strasse',
        'adresszusatz',
        'postleitzahl',
        'ort',
        'land',
        'laenderkuerzel',
        'postfach_plz',
        'postfach_nummer',
        'standard',
        'long',
        'lat',
        'aktiv',
        'order',
        'von',
        'bis',
        'land_id',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'standard' => 'boolean',
        'von' => 'date',
        'bis' => 'date',
    ];

    public function von(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
        );
    }

    public function bis(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
        );
    }
}
