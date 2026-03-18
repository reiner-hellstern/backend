<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCDUntersuchung_v1 extends Model
{
    use HasFactory;

    protected $table = 'ocd_untersuchungen_v1';

    protected $fillable = ['id', 'hund_id', 'typ_id', 'datum', 'ocd', 'coronid', 'bearbeitungscode', 'formularcode', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'ct_datum', 'ct_art_id', 'ct_vetsxl_nr', 'ct_grund_id', 'ct_arzt_id', 'ct_arzt_titel', 'ct_arzt_vorname', 'ct_arzt_nachname', 'ct_praxis_id', 'ct_praxis_name', 'ct_praxis_strasse', 'ct_praxis_plz', 'ct_praxis_ort', 'ct_praxis_land', 'ct_praxis_land_kuerzel', 'ct_praxis_email', 'ct_praxis_website', 'ct_praxis_telefon_1', 'ct_praxis_telefon_2', 'ct_anmerkungen', 'sedierung_praeparat', 'sedierung_menge', 'anmerkungen', 'dokument_id', 'dokumentable_id', 'dokumentable_type'];

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

    //  public function _option()
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
