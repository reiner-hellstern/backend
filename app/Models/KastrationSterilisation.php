<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KastrationSterilisation extends Model
{
    use HasFactory;

    protected $table = 'kastration_sterilisation';

    protected $fillable = [
        'hund_id',
        'eingriff_am',
        'kastration',
        'sterilisation',
        'grund_id',
        'grund_text',
        'arzt_id',
    ];

    protected function eingriffsAm(): Attribute
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

    public function grund()
    {
        return $this->belongsTo(OptionKastrationSterilisation::class, 'grund_id');
    }
}
