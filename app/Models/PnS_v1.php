<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PnS_v1 extends Model
{
    use HasFactory;

    protected $table = 'pns_v1';

    protected $appends = ['schweissarbeit', 'allgemeines_verhalten_gehorsam', 'haarwildschleppe', 'verlorensuche_wasser', 'verlorensuche_wald', 'einweisen_feld_markieren_standruhe', 'einweisen_schleppspur_apport', 'gesamtpunktzahl'];

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

    // SELECTBOXEN
    public function schweissarbeit_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'schweissarbeit_id');
    }

    public function getSchweissarbeitAttribute()
    {
        return $this->schweissarbeit_id ? ['name' => $this->schweissarbeit_option->name, 'id' => $this->schweissarbeit_id, 'wert' => $this->schweissarbeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function allgemeines_verhalten_gehorsam_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'allgemeines_verhalten_gehorsam_id');
    }

    public function getAllgemeinesVerhaltenGehorsamAttribute()
    {
        return $this->allgemeines_verhalten_gehorsam_id ? ['name' => $this->allgemeines_verhalten_gehorsam_option->name, 'id' => $this->allgemeines_verhalten_gehorsam_id, 'wert' => $this->allgemeines_verhalten_gehorsam_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function haarwildschleppe_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'haarwildschleppe_id');
    }

    public function getHaarwildschleppeAttribute()
    {
        return $this->haarwildschleppe_id ? ['name' => $this->haarwildschleppe_option->name, 'id' => $this->haarwildschleppe_id, 'wert' => $this->haarwildschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wasser_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'verlorensuche_wasser_id');
    }

    public function getVerlorensucheWasserAttribute()
    {
        return $this->verlorensuche_wasser_id ? ['name' => $this->verlorensuche_wasser_option->name, 'id' => $this->verlorensuche_wasser_id, 'wert' => $this->verlorensuche_wasser_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wald_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'verlorensuche_wald_id');
    }

    public function getVerlorensucheWaldAttribute()
    {
        return $this->verlorensuche_wald_id ? ['name' => $this->verlorensuche_wald_option->name, 'id' => $this->verlorensuche_wald_id, 'wert' => $this->verlorensuche_wald_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_feld_markieren_standruhe_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'einweisen_feld_markieren_standruhe_id');
    }

    public function getEinweisenFeldMarkierenStandruheAttribute()
    {
        return $this->einweisen_feld_markieren_standruhe_id ? ['name' => $this->einweisen_feld_markieren_standruhe_option->name, 'id' => $this->einweisen_feld_markieren_standruhe_id, 'wert' => $this->einweisen_feld_markieren_standruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function einweisen_schleppspur_apport_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'einweisen_schleppspur_apport_id');
    }

    public function getEinweisenSchleppspurApportAttribute()
    {
        return $this->einweisen_schleppspur_apport_id ? ['name' => $this->einweisen_schleppspur_apport_option->name, 'id' => $this->einweisen_schleppspur_apport_id, 'wert' => $this->einweisen_schleppspur_apport_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gesamtpunktzahl_option()
    {
        return $this->belongsTo(OptionPNS1Leistungsziffer::class, 'gesamtpunktzahl_id');
    }

    public function getGesamtpunktzahlAttribute()
    {
        return $this->gesamtpunktzahl_id ? ['name' => $this->gesamtpunktzahl_option->name, 'id' => $this->gesamtpunktzahl_id, 'wert' => $this->gesamtpunktzahl_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
