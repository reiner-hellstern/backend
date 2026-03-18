<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leihstellung extends Model
{
    use HasFactory;

    protected $table = 'leihstellungen';

    protected $fillable = [
        'hund_id',
        'zwinger_id',
        'leihsteller_id',
        'leihnehmer_id',
        'von',
        'bis',
        'freigabe',
    ];

    public function Von(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function Bis(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class, 'zwinger_id', 'id');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id', 'id');
    }

    public function leihsteller()
    {
        return $this->belongsTo(Person::class, 'leihsteller_id', 'id');
    }

    public function leihnehmer()
    {
        return $this->belongsTo(Person::class, 'leihnehmer_id', 'id');
    }
}
