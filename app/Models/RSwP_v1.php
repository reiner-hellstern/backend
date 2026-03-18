<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSwP_v1 extends Model
{
    use HasFactory;

    protected $table = 'rswp_v1';

    protected $appends = ['praedikat', 'preis'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    public function praedikat_option()
    {
        return $this->belongsTo(OptionRSWP1Praedikate::class, 'praedikat_id');
    }

    public function getPraedikatAttribute()
    {
        return $this->praedikat_id ? ['name' => $this->praedikat_option->name, 'id' => $this->praedikat_id, 'wert' => $this->praedikat_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function preis_option()
    {
        return $this->belongsTo(OptionRSWP1Preisklassen::class, 'preis_id');
    }

    public function getPreisAttribute()
    {
        return $this->preis_id ? ['name' => $this->preis_option->name, 'id' => $this->preis_id, 'wert' => $this->preis_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
