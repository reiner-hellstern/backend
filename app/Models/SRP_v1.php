<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SRP_v1 extends Model
{
    use HasFactory;

    protected $table = 'srp_v1';

    protected $appends = ['gesamtpraedikat', 'aufgabe1', 'aufgabe2', 'aufgabe3', 'aufgabe4', 'aufgabe5', 'aufgabe6', 'aufgabe7', 'aufgabe8', 'aufgabe9', 'aufgabe10'];

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

    public function aufgabe1_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe1_id');
    }

    public function getAufgabe1Attribute()
    {
        return $this->aufgabe1_id ? ['name' => $this->aufgabe1_option->name, 'id' => $this->aufgabe1_id, 'wert' => $this->aufgabe1_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe2_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe2_id');
    }

    public function getAufgabe2Attribute()
    {
        return $this->aufgabe2_id ? ['name' => $this->aufgabe2_option->name, 'id' => $this->aufgabe2_id, 'wert' => $this->aufgabe2_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe3_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe3_id');
    }

    public function getAufgabe3Attribute()
    {
        return $this->aufgabe3_id ? ['name' => $this->aufgabe3_option->name, 'id' => $this->aufgabe3_id, 'wert' => $this->aufgabe3_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe4_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe4_id');
    }

    public function getAufgabe4Attribute()
    {
        return $this->aufgabe4_id ? ['name' => $this->aufgabe4_option->name, 'id' => $this->aufgabe4_id, 'wert' => $this->aufgabe4_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe5_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe5_id');
    }

    public function getAufgabe5Attribute()
    {
        return $this->aufgabe5_id ? ['name' => $this->aufgabe5_option->name, 'id' => $this->aufgabe5_id, 'wert' => $this->aufgabe5_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe6_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe6_id');
    }

    public function getAufgabe6Attribute()
    {
        return $this->aufgabe6_id ? ['name' => $this->aufgabe6_option->name, 'id' => $this->aufgabe6_id, 'wert' => $this->aufgabe6_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe7_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe7_id');
    }

    public function getAufgabe7Attribute()
    {
        return $this->aufgabe7_id ? ['name' => $this->aufgabe7_option->name, 'id' => $this->aufgabe7_id, 'wert' => $this->aufgabe7_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe8_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe8_id');
    }

    public function getAufgabe8Attribute()
    {
        return $this->aufgabe8_id ? ['name' => $this->aufgabe8_option->name, 'id' => $this->aufgabe8_id, 'wert' => $this->aufgabe8_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe9_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe9_id');
    }

    public function getAufgabe9Attribute()
    {
        return $this->aufgabe9_id ? ['name' => $this->aufgabe9_option->name, 'id' => $this->aufgabe9_id, 'wert' => $this->aufgabe9_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function aufgabe10_option()
    {
        return $this->belongsTo(OptionSRP1Wertungspunkte::class, 'aufgabe10_id');
    }

    public function getAufgabe10Attribute()
    {
        return $this->aufgabe10_id ? ['name' => $this->aufgabe10_option->name, 'id' => $this->aufgabe10_id, 'wert' => $this->aufgabe10_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gesamtpraedikat_option()
    {
        return $this->belongsTo(OptionSRP1Praedikate::class, 'gesamtpraedikat_id');
    }

    public function getGesamtpraedikatAttribute()
    {
        return $this->gesamtpraedikat_id ? ['name' => $this->gesamtpraedikat_option->name, 'id' => $this->gesamtpraedikat_id, 'wert' => $this->gesamtpraedikat_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
