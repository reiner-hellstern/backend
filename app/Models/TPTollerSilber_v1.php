<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPTollerSilber_v1 extends Model
{
    use HasFactory;

    protected $table = 'tptoller_silber_v1';

    protected $appends = ['anschleichen', 'tolling', 'passivitaet', 'merken', 'einweisen_wasserflaeche', 'bringen_ente', 'suche_nutzwild', 'einweisen_federnutzwild', 'bringen_federwild', 'bringen_haarwild', 'gehorsam', 'arbeitsfreude', 'fuehrigkeit', 'nasengebrauch', 'gesamturteil', 'schussfestigkeit_land', 'schussfestigkeit_wasserarbeit', 'temperament', 'selbstsicherheit', 'vertraeglichkeit', 'sonstige_wesenverhalten'];

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
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'anschleichen_id');
    }

    public function getAnschleichenAttribute()
    {
        return $this->anschleichen_id ? ['name' => $this->anschleichen_option->name, 'id' => $this->anschleichen_id, 'wert' => $this->anschleichen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function tolling_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte12::class, 'tolling_id');
    }

    public function getTollingAttribute()
    {
        return $this->tolling_id ? ['name' => $this->tolling_option->name, 'id' => $this->tolling_id, 'wert' => $this->tolling_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function arbeitsfreude_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'arbeitsfreude_id');
    }

    public function getArbeitsfreudeAttribute()
    {
        return $this->arbeitsfreude_id ? ['name' => $this->arbeitsfreude_option->name, 'id' => $this->arbeitsfreude_id, 'wert' => $this->arbeitsfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_ente_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'bringen_ente_id');
    }

    public function getBringenEnteAttribute()
    {
        return $this->bringen_ente_id ? ['name' => $this->bringen_ente_option->name, 'id' => $this->bringen_ente_id, 'wert' => $this->bringen_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_land_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Schussfestigkeit::class, 'schussfestigkeit_land_id');
    }

    public function getSchussfestigkeitLandAttribute()
    {
        return $this->schussfestigkeit_land_id ? ['name' => $this->schussfestigkeit_land_option->name, 'id' => $this->schussfestigkeit_land_id, 'wert' => $this->schussfestigkeit_land_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_wasserarbeit_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wasserarbeit::class, 'schussfestigkeit_wasserarbeit_id');
    }

    public function getSchussfestigkeitWasserarbeitAttribute()
    {
        return $this->schussfestigkeit_wasserarbeit_id ? ['name' => $this->schussfestigkeit_wasserarbeit_option->name, 'id' => $this->schussfestigkeit_wasserarbeit_id, 'wert' => $this->schussfestigkeit_wasserarbeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function passivitaet_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'passivitaet_id');
    }

    public function getPassivitaetAttribute()
    {
        return $this->passivitaet_id ? ['name' => $this->passivitaet_option->name, 'id' => $this->passivitaet_id, 'wert' => $this->passivitaet_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function merken_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'merken_id');
    }

    public function getMerkenAttribute()
    {
        return $this->merken_id ? ['name' => $this->merken_option->name, 'id' => $this->merken_id, 'wert' => $this->merken_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_wasserflaeche_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'einweisen_wasserflaeche_id');
    }

    public function getEinweisenWasserflaecheAttribute()
    {
        return $this->einweisen_wasserflaeche_id ? ['name' => $this->einweisen_wasserflaeche_option->name, 'id' => $this->einweisen_wasserflaeche_id, 'wert' => $this->einweisen_wasserflaeche_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function suche_nutzwild_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte12::class, 'suche_nutzwild_id');
    }

    public function getSucheNutzwildAttribute()
    {
        return $this->suche_nutzwild_id ? ['name' => $this->suche_nutzwild_option->name, 'id' => $this->suche_nutzwild_id, 'wert' => $this->suche_nutzwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_federnutzwild_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'einweisen_federnutzwild_id');
    }

    public function getEinweisenFedernutzwildAttribute()
    {
        return $this->einweisen_federnutzwild_id ? ['name' => $this->einweisen_federnutzwild_option->name, 'id' => $this->einweisen_federnutzwild_id, 'wert' => $this->einweisen_federnutzwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_federwild_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'bringen_federwild_id');
    }

    public function getBringenFederwildAttribute()
    {
        return $this->bringen_federwild_id ? ['name' => $this->bringen_federwild_option->name, 'id' => $this->bringen_federwild_id, 'wert' => $this->bringen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bringen_haarwild_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'bringen_haarwild_id');
    }

    public function getBringenHaarwildAttribute()
    {
        return $this->bringen_haarwild_id ? ['name' => $this->bringen_haarwild_option->name, 'id' => $this->bringen_haarwild_id, 'wert' => $this->bringen_haarwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'gehorsam_id');
    }

    public function getGehorsamAttribute()
    {
        return $this->gehorsam_id ? ['name' => $this->gehorsam_option->name, 'id' => $this->gehorsam_id, 'wert' => $this->gehorsam_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function fuehrigkeit_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'fuehrigkeit_id');
    }

    public function getFuehrigkeitAttribute()
    {
        return $this->fuehrigkeit_id ? ['name' => $this->fuehrigkeit_option->name, 'id' => $this->fuehrigkeit_id, 'wert' => $this->fuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function nasengebrauch_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Wertungspunkte11::class, 'nasengebrauch_id');
    }

    public function getNasengebrauchAttribute()
    {
        return $this->nasengebrauch_id ? ['name' => $this->nasengebrauch_option->name, 'id' => $this->nasengebrauch_id, 'wert' => $this->nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gesamturteil_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Gesamturteil::class, 'gesamturteil_id');
    }

    public function getGesamturteilAttribute()
    {
        return $this->gesamturteil_id ? ['name' => $this->gesamturteil_option->name, 'id' => $this->gesamturteil_id, 'wert' => $this->gesamturteil_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function temperament_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Temperament::class, 'temperament_id');
    }

    public function getTemperamentAttribute()
    {
        return $this->temperament_id ? ['name' => $this->temperament_option->name, 'id' => $this->temperament_id, 'wert' => $this->temperament_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function selbstsicherheit_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Selbstsicherheit::class, 'selbstsicherheit_id');
    }

    public function getSelbstsicherheitAttribute()
    {
        return $this->selbstsicherheit_id ? ['name' => $this->selbstsicherheit_option->name, 'id' => $this->selbstsicherheit_id, 'wert' => $this->selbstsicherheit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vertraeglichkeit_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1Vertraeglichkeit::class, 'vertraeglichkeit_id');
    }

    public function getVertraeglichkeitAttribute()
    {
        return $this->vertraeglichkeit_id ? ['name' => $this->vertraeglichkeit_option->name, 'id' => $this->vertraeglichkeit_id, 'wert' => $this->vertraeglichkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function sonstige_wesenverhalten_option()
    {
        return $this->belongsTo(OptionTPTollerSilber1SonstigesVerhalten::class, 'sonstige_wesenverhalten_id');
    }

    public function getSonstigeWesenverhaltenAttribute()
    {
        return $this->sonstige_wesenverhalten_id ? ['name' => $this->sonstige_wesenverhalten_option->name, 'id' => $this->sonstige_wesenverhalten_id, 'wert' => $this->sonstige_wesenverhalten_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
