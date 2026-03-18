<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zahnstatus_v1 extends Model
{
    use HasFactory;

    protected $table = 'zahnstati_v1';

    protected $append = ['gebiss', 'quelle'];

    protected $fillable = ['id', 'gebiss_id', 'quelle_id', 'aktiv', 'anmerkung', 'bewertung', 'col', 'cor', 'cul', 'cur', 'datum', 'gutachter_email', 'gutachter_id', 'gutachter_land', 'gutachter_land_kuerzel', 'gutachter_nachname', 'gutachter_ort', 'gutachter_plz', 'gutachter_praxis', 'gutachter_strasse', 'gutachter_telefon_1', 'gutachter_telefon_2', 'gutachter_titel', 'gutachter_vorname', 'gutachter_website', 'hund_id', 'i1ol', 'i1or', 'i1ul', 'i1ur', 'i2ol', 'i2or', 'i2ul', 'i2ur', 'i3ol', 'i3or', 'i3ul', 'i3ur', 'id', 'm1ol', 'm1or', 'm1ul', 'm1ur', 'm2ol', 'm2or', 'm2ul', 'm2ur', 'm3ul', 'm3ur', 'p1ol', 'p1or', 'p1ul', 'p1ur', 'p2ol', 'p2or', 'p2ul', 'p2ur', 'p3ol', 'p3or', 'p3ul', 'p3ur', 'p4ol', 'p4or', 'p4ul', 'p4ur', 'pruefung_id', 'textform', 'veranstaltung_id'];

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function gebiss_option()
    {
        return $this->belongsTo(OptionZSGebiss::class, 'gebiss_id');
    }

    public function getGebissAttribute()
    {
        return $this->gebiss_id ? ['name' => $this->gebiss_option->name, 'id' => $this->gebiss_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function quelle_option()
    {
        return $this->belongsTo(OptionZSQuelle::class, 'quelle_id');
    }

    public function getQuelleAttribute()
    {
        return $this->quelle_id ? ['name' => $this->quelle_option->name, 'id' => $this->quelle_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    //  public function veranstaltung_option()
    //  {
    //     return $this->belongsTo(Option::class, '_id');
    //  }
    //  public function getAttribute()
    //  {
    //     return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    //  public function _option()
    //  {
    //     return $this->belongsTo(Option::class, '_id');
    //  }
    //  public function getAttribute()
    //  {
    //     return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

}
