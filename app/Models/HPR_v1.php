<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HPR_v1 extends Model
{
    use HasFactory;

    protected $table = 'hpr_v1';

    protected $appends = ['haarwildschleppe', 'gesamtergebnis', 'marking_merken_land', 'einweisen_federwild', 'einweisen_gewaesser', 'verlorensuche', 'standtreiben', 'marking_merken_gewaesser'];

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

    public function gesamtergebnis_option()
    {
        return $this->belongsTo(OptionHPR1Gesamtpraedikat::class, 'gesamtergebnis_id');
    }

    public function getGesamtergebnisAttribute()
    {
        return $this->gesamtergebnis_id ? ['name' => $this->gesamtergebnis_option->name, 'id' => $this->gesamtergebnis_id, 'wert' => $this->gesamtergebnis_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function haarwildschleppe_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'haarwildschleppe_id');
    }

    public function getHaarwildschleppeAttribute()
    {
        return $this->haarwildschleppe_id ? ['name' => $this->haarwildschleppe_option->name, 'id' => $this->haarwildschleppe_id, 'wert' => $this->haarwildschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function marking_merken_land_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'marking_merken_land_id');
    }

    public function getMarkingMerkenLandAttribute()
    {
        return $this->marking_merken_land_id ? ['name' => $this->marking_merken_land_option->name, 'id' => $this->marking_merken_land_id, 'wert' => $this->marking_merken_land_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_federwild_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'einweisen_federwild_id');
    }

    public function getEinweisenFederwildAttribute()
    {
        return $this->einweisen_federwild_id ? ['name' => $this->einweisen_federwild_option->name, 'id' => $this->einweisen_federwild_id, 'wert' => $this->einweisen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_gewaesser_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'einweisen_gewaesser_id');
    }

    public function getEinweisenGewaesserAttribute()
    {
        return $this->einweisen_gewaesser_id ? ['name' => $this->einweisen_gewaesser_option->name, 'id' => $this->einweisen_gewaesser_id, 'wert' => $this->einweisen_gewaesser_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'verlorensuche_id');
    }

    public function getVerlorensucheAttribute()
    {
        return $this->verlorensuche_id ? ['name' => $this->verlorensuche_option->name, 'id' => $this->verlorensuche_id, 'wert' => $this->verlorensuche_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function standtreiben_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'standtreiben_id');
    }

    public function getStandtreibenAttribute()
    {
        return $this->standtreiben_id ? ['name' => $this->standtreiben_option->name, 'id' => $this->standtreiben_id, 'wert' => $this->standtreiben_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function marking_merken_gewaesser_option()
    {
        return $this->belongsTo(OptionHPR1Praedikat::class, 'marking_merken_gewaesser_id');
    }

    public function getMarkingMerkenGewaesserAttribute()
    {
        return $this->marking_merken_gewaesser_id ? ['name' => $this->marking_merken_gewaesser_option->name, 'id' => $this->marking_merken_gewaesser_id, 'wert' => $this->marking_merken_gewaesser_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
