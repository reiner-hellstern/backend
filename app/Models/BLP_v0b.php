<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLP_v0b extends Model
{
    use HasFactory;

    protected $table = 'blp_v0b';

    protected $appends = ['arbeitsfreude', 'nasengebrauch', 'fuehrigkeit', 'wasserfreude', 'koerperliche_haerte', 'freie_verlorensuche', 'standruhe', 'merken', 'wasser_stoebern', 'wasser_verlorensuche', 'einweisen_federwild', 'federwildschleppe', 'bringen_durchschnitt', 'bringen_hase_kanin', 'bringen_ente', 'bringen_federwild', 'gehorsam'];

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
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function getArbeitsfreudeAttribute()
    {
        return $this->a1_arbeitsfreude ? OptionBLP1Wertungspunkte11::where('wert', $this->a1_arbeitsfreude)->pluck('name')[0] : '';
    }

    public function getNasengebrauchAttribute()
    {
        return $this->a2_nasengebrauch ? OptionBLP1Wertungspunkte11::where('wert', $this->a2_nasengebrauch)->pluck('name')[0] : '';
    }

    public function getFuehrigkeitAttribute()
    {
        return $this->a3_fuehrigkeit ? OptionBLP1Wertungspunkte11::where('wert', $this->a3_fuehrigkeit)->pluck('name')[0] : '';
    }

    public function getWasserfreudeAttribute()
    {
        return $this->a4_wasserfreude ? OptionBLP1Wertungspunkte11::where('wert', $this->a4_wasserfreude)->pluck('name')[0] : '';
    }

    public function getKoerperlicheHaerteAttribute()
    {
        return $this->a5_koerperliche_haerte ? OptionBLP1Wertungspunkte11::where('wert', $this->a5_koerperliche_haerte)->pluck('name')[0] : '';
    }

    public function getFreieVerlorensucheAttribute()
    {
        return $this->a6_freie_verlorensuche ? OptionBLP1Wertungspunkte11::where('wert', $this->a6_freie_verlorensuche)->pluck('name')[0] : '';
    }

    public function getStandruheAttribute()
    {
        return $this->a7_standruhe ? OptionBLP1Wertungspunkte11::where('wert', $this->a7_standruhe)->pluck('name')[0] : '';
    }

    public function getMerkenAttribute()
    {
        return $this->a8_merken ? OptionBLP1Wertungspunkte11::where('wert', $this->a8_merken)->pluck('name')[0] : '';
    }

    public function getWasserStoebernAttribute()
    {
        return $this->a9_wasser_stoebern ? OptionBLP1Wertungspunkte11::where('wert', $this->a9_wasser_stoebern)->pluck('name')[0] : '';
    }

    public function getWasserVerlorensucheAttribute()
    {
        return $this->a9_wasser_verlorensuche ? OptionBLP1Wertungspunkte11::where('wert', $this->a9_wasser_verlorensuche)->pluck('name')[0] : '';
    }

    public function getEinweisenFederwildAttribute()
    {
        return $this->a10_einweisen_federwild ? OptionBLP1Wertungspunkte11::where('wert', $this->a10_einweisen_federwild)->pluck('name')[0] : '';
    }

    public function getFederwildschleppeAttribute()
    {
        return $this->a11_federwildschleppe ? OptionBLP1Wertungspunkte11::where('wert', $this->a11_federwildschleppe)->pluck('name')[0] : '';
    }

    public function getBringenDurchschnittAttribute()
    {
        return $this->a12_bringen_durchschnitt ? OptionBLP1Wertungspunkte11::where('wert', $this->a12_bringen_durchschnitt)->pluck('name')[0] : '';
    }

    public function getBringenHaseKaninAttribute()
    {
        return $this->a12a_bringen_hase_kanin ? OptionBLP1Wertungspunkte11::where('wert', $this->a12a_bringen_hase_kanin)->pluck('name')[0] : '';
    }

    public function getBringenEnteAttribute()
    {
        return $this->a12b_bringen_ente ? OptionBLP1Wertungspunkte11::where('wert', $this->a12b_bringen_ente)->pluck('name')[0] : '';
    }

    public function getBringenFederwildAttribute()
    {
        return $this->a12c_bringen_federwild ? OptionBLP1Wertungspunkte11::where('wert', $this->a12c_bringen_federwild)->pluck('name')[0] : '';
    }

    public function getGehorsamAttribute()
    {
        return $this->a13_gehorsam ? OptionBLP1Wertungspunkte11::where('wert', $this->a13_gehorsam)->pluck('name')[0] : '';
    }
}
