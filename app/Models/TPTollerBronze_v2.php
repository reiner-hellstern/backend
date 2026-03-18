<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPTollerBronze_v2 extends Model
{
    use HasFactory;

    protected $table = 'tptoller_bronze_v2';

    protected $appends = ['anschleichen', 'tolling', 'wasserfreude', 'bringen_ente', 'zusammenarbeit', 'schussfestigkeit'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function anschleichen_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Leistungsziffer::class, 'anschleichen_id');
    }

    public function getAnschleichenAttribute()
    {
        return $this->anschleichen_id ? ['name' => $this->anschleichen_option->name, 'id' => $this->anschleichen_id, 'wert' => $this->anschleichen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function tolling_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Leistungsziffer::class, 'tolling_id');
    }

    public function getTollingAttribute()
    {
        return $this->tolling_id ? ['name' => $this->tolling_option->name, 'id' => $this->tolling_id, 'wert' => $this->tolling_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserfreude_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Leistungsziffer::class, 'wasserfreude_id');
    }

    public function getWasserfreudeAttribute()
    {
        return $this->wasserfreude_id ? ['name' => $this->wasserfreude_option->name, 'id' => $this->wasserfreude_id, 'wert' => $this->wasserfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_ente_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Leistungsziffer::class, 'bringen_ente_id');
    }

    public function getBringenEnteAttribute()
    {
        return $this->bringen_ente_id ? ['name' => $this->bringen_ente_option->name, 'id' => $this->bringen_ente_id, 'wert' => $this->bringen_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function zusammenarbeit_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Leistungsziffer::class, 'zusammenarbeit_id');
    }

    public function getZusammenarbeitAttribute()
    {
        return $this->zusammenarbeit_id ? ['name' => $this->zusammenarbeit_option->name, 'id' => $this->zusammenarbeit_id, 'wert' => $this->zusammenarbeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_option()
    {
        return $this->belongsTo(OptionTPTollerBronze2Schussfestigkeit::class, 'schussfestigkeit_id');
    }

    public function getSchussfestigkeitAttribute()
    {
        return $this->schussfestigkeit_id ? ['name' => $this->schussfestigkeit_option->name, 'id' => $this->schussfestigkeit_id, 'wert' => $this->schussfestigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
