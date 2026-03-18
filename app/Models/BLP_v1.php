<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLP_v1 extends Model
{
    use HasFactory;

    protected $table = 'blp_v1';

    protected $appends = ['koerperliche_maengel', 'arbeitsfreude', 'nasengebrauch', 'fuehrigkeit', 'wasserfreude', 'koerperliche_haerte', 'freie_verlorensuche', 'standruhe', 'merken', 'wasserarbeit_a1', 'wasserarbeit_b1', 'wasserarbeit_b2', 'einweisen_federwild', 'wildschleppe', 'bringen_hase_kanin', 'bringen_ente', 'bringen_federwild', 'gehorsam', 'schussfestigkeit_land', 'schussfestigkeit_wasserarbeit', 'temperament', 'selbstsicherheit', 'vertraeglichkeit', 'sonstiges_wesenverhalten'];

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

    public function koerperliche_maengel_option()
    {
        return $this->belongsTo(OptionBLP1KoerperlicheMaengel::class, 'koerperliche_maengel_id');
    }

    public function getKoerperlicheMaengelAttribute()
    {
        return $this->koerperliche_maengel_id ? ['name' => $this->koerperliche_maengel_option->name, 'id' => $this->koerperliche_maengel_id, 'wert' => $this->koerperliche_maengel_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_land_option()
    {
        return $this->belongsTo(OptionBLP1Schussfestigkeit::class, 'schussfestigkeit_land_id');
    }

    public function getSchussfestigkeitLandAttribute()
    {
        return $this->schussfestigkeit_land_id ? ['name' => $this->schussfestigkeit_land_option->name, 'id' => $this->schussfestigkeit_land_id, 'wert' => $this->schussfestigkeit_land_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_wasserarbeit_option()
    {
        return $this->belongsTo(OptionBLP1Wasserarbeit::class, 'schussfestigkeit_wasserarbeit_id');
    }

    public function getSchussfestigkeitWasserarbeitAttribute()
    {
        return $this->schussfestigkeit_wasserarbeit_id ? ['name' => $this->schussfestigkeit_wasserarbeit_option->name, 'id' => $this->schussfestigkeit_wasserarbeit_id, 'wert' => $this->schussfestigkeit_wasserarbeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function selbstsicherheit_option()
    {
        return $this->belongsTo(OptionBLP1Selbstsicherheit::class, 'selbstsicherheit_id');
    }

    public function getSelbstsicherheitAttribute()
    {
        return $this->selbstsicherheit_id ? ['name' => $this->selbstsicherheit_option->name, 'id' => $this->selbstsicherheit_id, 'wert' => $this->selbstsicherheit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vertraeglichkeit_option()
    {
        return $this->belongsTo(OptionBLP1Vertraeglichkeit::class, 'vertraeglichkeit_id');
    }

    public function getVertraeglichkeitAttribute()
    {
        return $this->vertraeglichkeit_id ? ['name' => $this->vertraeglichkeit_option->name, 'id' => $this->vertraeglichkeit_id, 'wert' => $this->vertraeglichkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function sonstiges_wesenverhalten_option()
    {
        return $this->belongsTo(OptionBLP1SonstigesVerhalten::class, 'sonstiges_wesenverhalten_id');
    }

    public function getSonstigesWesenverhaltenAttribute()
    {
        return $this->sonstiges_wesenverhalten_id ? ['name' => $this->sonstiges_wesenverhalten_option->name, 'id' => $this->sonstiges_wesenverhalten_id, 'wert' => $this->sonstiges_wesenverhalten_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function temperament_option()
    {
        return $this->belongsTo(OptionBLP1Temperament::class, 'temperament_id');
    }

    public function getTemperamentAttribute()
    {
        return $this->temperament_id ? ['name' => $this->temperament_option->name, 'id' => $this->temperament_id, 'wert' => $this->temperament_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wildschleppe_option()
    {
        return $this->belongsTo(OptionBLP1Wildschleppe::class, 'wildschleppe_id');
    }

    public function getWildschleppeAttribute()
    {
        return $this->wildschleppe_id ? ['name' => $this->wildschleppe_option->name, 'id' => $this->wildschleppe_id, 'wert' => $this->wildschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    // 10-----------------------------------------------------------------------------------------------

    public function standruhe_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte10::class, 'standruhe_id');
    }

    public function getStandruheAttribute()
    {
        return $this->standruhe_id ? ['name' => $this->standruhe_option->name, 'id' => $this->standruhe_id, 'wert' => $this->standruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_federwild_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte10::class, 'einweisen_federwild_id');
    }

    public function getEinweisenFederwildAttribute()
    {
        return $this->einweisen_federwild_id ? ['name' => $this->einweisen_federwild_option->name, 'id' => $this->einweisen_federwild_id, 'wert' => $this->einweisen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_hase_kanin_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte10::class, 'bringen_hase_kanin_id');
    }

    public function getBringenHaseKaninAttribute()
    {
        return $this->bringen_hase_kanin_id ? ['name' => $this->bringen_hase_kanin_option->name, 'id' => $this->bringen_hase_kanin_id, 'wert' => $this->bringen_hase_kanin_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_ente_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte10::class, 'bringen_ente_id');
    }

    public function getBringenEnteAttribute()
    {
        return $this->bringen_ente_id ? ['name' => $this->bringen_ente_option->name, 'id' => $this->bringen_ente_id, 'wert' => $this->bringen_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_federwild_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte10::class, 'bringen_federwild_id');
    }

    public function getBringenFederwildAttribute()
    {
        return $this->bringen_federwild_id ? ['name' => $this->bringen_federwild_option->name, 'id' => $this->bringen_federwild_id, 'wert' => $this->bringen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    // 11 --------------------------------------------------------------------------------------------

    public function arbeitsfreude_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'arbeitsfreude_id');
    }

    public function getArbeitsfreudeAttribute()
    {
        return $this->arbeitsfreude_id ? ['name' => $this->arbeitsfreude_option->name, 'id' => $this->arbeitsfreude_id, 'wert' => $this->arbeitsfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function nasengebrauch_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'nasengebrauch_id');
    }

    public function getNasengebrauchAttribute()
    {
        return $this->nasengebrauch_id ? ['name' => $this->nasengebrauch_option->name, 'id' => $this->nasengebrauch_id, 'wert' => $this->nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function fuehrigkeit_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'fuehrigkeit_id');
    }

    public function getFuehrigkeitAttribute()
    {
        return $this->fuehrigkeit_id ? ['name' => $this->fuehrigkeit_option->name, 'id' => $this->fuehrigkeit_id, 'wert' => $this->fuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserfreude_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'wasserfreude_id');
    }

    public function getWasserfreudeAttribute()
    {
        return $this->wasserfreude_id ? ['name' => $this->wasserfreude_option->name, 'id' => $this->wasserfreude_id, 'wert' => $this->wasserfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'koerperliche_haerte_id');
    }

    public function getKoerperlicheHaerteAttribute()
    {
        return $this->koerperliche_haerte_id ? ['name' => $this->koerperliche_haerte_option->name, 'id' => $this->koerperliche_haerte_id, 'wert' => $this->koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function merken_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'merken_id');
    }

    public function getMerkenAttribute()
    {
        return $this->merken_id ? ['name' => $this->merken_option->name, 'id' => $this->merken_id, 'wert' => $this->merken_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_b2_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'wasserarbeit_b2_id');
    }

    public function getWasserarbeitB2Attribute()
    {
        return $this->wasserarbeit_b2_id ? ['name' => $this->wasserarbeit_b2_option->name, 'id' => $this->wasserarbeit_b2_id, 'wert' => $this->wasserarbeit_b2_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte11::class, 'gehorsam_id');
    }

    public function getGehorsamAttribute()
    {
        return $this->gehorsam_id ? ['name' => $this->gehorsam_option->name, 'id' => $this->gehorsam_id, 'wert' => $this->gehorsam_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    // 12-----------------------------------------------------------------------------------------------
    public function freie_verlorensuche_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte12::class, 'freie_verlorensuche_id');
    }

    public function getFreieVerlorensucheAttribute()
    {
        return $this->freie_verlorensuche_id ? ['name' => $this->freie_verlorensuche_option->name, 'id' => $this->freie_verlorensuche_id, 'wert' => $this->freie_verlorensuche_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_b1_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte12::class, 'wasserarbeit_b1_id');
    }

    public function getWasserarbeitB1Attribute()
    {
        return $this->wasserarbeit_b1_id ? ['name' => $this->wasserarbeit_b1_option->name, 'id' => $this->wasserarbeit_b1_id, 'wert' => $this->wasserarbeit_b1_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_a1_option()
    {
        return $this->belongsTo(OptionBLP1Wertungspunkte12::class, 'wasserarbeit_a1_id');
    }

    public function getWasserarbeitA1Attribute()
    {
        return $this->wasserarbeit_b1_id ? ['name' => $this->wasserarbeit_a1_option->name, 'id' => $this->wasserarbeit_a1_id, 'wert' => $this->wasserarbeit_a1_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    /////////////////////
}
