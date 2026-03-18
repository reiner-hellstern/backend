<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deckruede extends Model
{
    use HasFactory;

    protected $table = 'hunde';

    protected $with = ['rasse', 'zuchtart', 'zuchtzulassung'];

    protected function wurfdatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function zuchtzulassung()
    {
        return $this->belongsTo(Zuchtzulassung::class, 'zuchtzulassung_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'keine Zuchtzulassung eingetragen',
        ]);
    }

    public function zuchtart()
    {
        return $this->belongsTo(OptionZuchtart::class, 'zuchtart_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function rasse()
    {
        return $this->belongsTo(Rasse::class, 'rasse_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
            'name_kurz' => '',
            'buchstabe' => '',
        ]);
    }

    public function wuerfe()
    {
        return $this->belongsToMany(Wurf::class);
    }
}
