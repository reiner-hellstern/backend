<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JAS_v2 extends Model
{
    use HasFactory;

    protected $table = 'jas_v2';

    protected $appends = ['arbeitseifer', 'finderwille', 'selbststaendigkeit', 'nasengebrauch', 'koerperliche_haerte', 'fuehrigkeit', 'spurwille', 'arbeitsruhe', 'wasserfreude', 'konzentration', 'einschaetzung_entfernung', 'schussfestigkeit', 'temperament', 'selbstsicherheit', 'vertraeglichkeit', 'praedikat'];

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

    public function arbeitseifer_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'arbeitseifer_id');
    }

    public function getArbeitseiferAttribute()
    {
        return $this->arbeitseifer_id ? ['name' => $this->arbeitseifer_option->name, 'id' => $this->arbeitseifer_id, 'wert' => $this->arbeitseifer_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function finderwille_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'finderwille_id');
    }

    public function getFinderwilleAttribute()
    {
        return $this->finderwille_id ? ['name' => $this->finderwille_option->name, 'id' => $this->finderwille_id, 'wert' => $this->finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function selbststaendigkeit_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'selbststaendigkeit_id');
    }

    public function getSelbststaendigkeitAttribute()
    {
        return $this->selbststaendigkeit_id ? ['name' => $this->selbststaendigkeit_option->name, 'id' => $this->selbststaendigkeit_id, 'wert' => $this->selbststaendigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'nasengebrauch_id');
    }

    public function getNasengebrauchAttribute()
    {
        return $this->nasengebrauch_id ? ['name' => $this->nasengebrauch_option->name, 'id' => $this->nasengebrauch_id, 'wert' => $this->nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'koerperliche_haerte_id');
    }

    public function getKoerperlicheHaerteAttribute()
    {
        return $this->koerperliche_haerte_id ? ['name' => $this->koerperliche_haerte_option->name, 'id' => $this->koerperliche_haerte_id, 'wert' => $this->koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function fuehrigkeit_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'fuehrigkeit_id');
    }

    public function getFuehrigkeitAttribute()
    {
        return $this->fuehrigkeit_id ? ['name' => $this->fuehrigkeit_option->name, 'id' => $this->fuehrigkeit_id, 'wert' => $this->fuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function spurwille_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'spurwille_id');
    }

    public function getSpurwilleAttribute()
    {
        return $this->spurwille_id ? ['name' => $this->spurwille_option->name, 'id' => $this->spurwille_id, 'wert' => $this->spurwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function arbeitsruhe_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'arbeitsruhe_id');
    }

    public function getArbeitsruheAttribute()
    {
        return $this->arbeitsruhe_id ? ['name' => $this->arbeitsruhe_option->name, 'id' => $this->arbeitsruhe_id, 'wert' => $this->arbeitsruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserfreude_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'wasserfreude_id');
    }

    public function getWasserfreudeAttribute()
    {
        return $this->wasserfreude_id ? ['name' => $this->wasserfreude_option->name, 'id' => $this->wasserfreude_id, 'wert' => $this->wasserfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function konzentration_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'konzentration_id');
    }

    public function getKonzentrationAttribute()
    {
        return $this->konzentration_id ? ['name' => $this->konzentration_option->name, 'id' => $this->konzentration_id, 'wert' => $this->konzentration_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einschaetzung_entfernung_option()
    {
        return $this->belongsTo(OptionJAS2Aufgabenbewertung::class, 'einschaetzung_entfernung_id');
    }

    public function getEinschaetzungEntfernungAttribute()
    {
        return $this->einschaetzung_entfernung_id ? ['name' => $this->einschaetzung_entfernung_option->name, 'id' => $this->einschaetzung_entfernung_id, 'wert' => $this->einschaetzung_entfernung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_option()
    {
        return $this->belongsTo(OptionJAS2Schussfestigkeit::class, 'schussfestigkeit_id');
    }

    public function getSchussfestigkeitAttribute()
    {
        return $this->schussfestigkeit_id ? ['name' => $this->schussfestigkeit_option->name, 'id' => $this->schussfestigkeit_id, 'wert' => $this->schussfestigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function temperament_option()
    {
        return $this->belongsTo(OptionJAS2Temperament::class, 'temperament_id');
    }

    public function getTemperamentAttribute()
    {
        return $this->temperament_id ? ['name' => $this->temperament_option->name, 'id' => $this->temperament_id, 'wert' => $this->temperament_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function selbstsicherheit_option()
    {
        return $this->belongsTo(OptionJAS2Selbstsicherheit::class, 'selbstsicherheit_id');
    }

    public function getSelbstsicherheitAttribute()
    {
        return $this->selbstsicherheit_id ? ['name' => $this->selbstsicherheit_option->name, 'id' => $this->selbstsicherheit_id, 'wert' => $this->selbstsicherheit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vertraeglichkeit_option()
    {
        return $this->belongsTo(OptionJAS2Vertraeglichkeit::class, 'vertraeglichkeit_id');
    }

    public function getVertraeglichkeitAttribute()
    {
        return $this->vertraeglichkeit_id ? ['name' => $this->vertraeglichkeit_option->name, 'id' => $this->vertraeglichkeit_id, 'wert' => $this->vertraeglichkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    // public function sonstige_wesenverhalten_option()
    //  {
    //     return $this->belongsTo(OptionJAS2SonstigeWesenverhalten::class, 'sonstige_wesenverhalten_id');
    //  }
    //  public function getSonstigeWesenverhaltenAttribute()
    //  {
    //     return $this->sonstige_wesenverhalten_id ? [ 'name' => $this->sonstige_wesenverhalten_option->name, 'id' => $this->sonstige_wesenverhalten_id, 'wert' => $this->sonstige_wesenverhalten_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    public function praedikat_option()
    {
        return $this->belongsTo(OptionJAS2Praedikate::class, 'praedikat_id');
    }

    public function getPraedikatAttribute()
    {
        return $this->praedikat_id ? ['name' => $this->praedikat_option->name, 'id' => $this->praedikat_id, 'wert' => $this->praedikat_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wild_option()
    {
        return $this->belongsTo(OptionJAS2Wild::class, 'wild_id');
    }

    public function getWildAttribute()
    {
        return $this->wild_id ? ['name' => $this->wild_option->name, 'id' => $this->wild_id, 'wert' => $this->wild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
