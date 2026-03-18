<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patella extends Model
{
    use HasFactory;

    protected $table = 'patellas';

    protected $fillable = ['id', 'hund_id', 'typ_id', 'datum', 'ocd', 'coronid', 'bearbeitungscode', 'formularcode', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'ct_datum', 'ct_art_id', 'ct_vetsxl_nr', 'ct_grund_id', 'ct_arzt_id', 'ct_arzt_titel', 'ct_arzt_vorname', 'ct_arzt_nachname', 'ct_praxis_id', 'ct_praxis_name', 'ct_praxis_strasse', 'ct_praxis_plz', 'ct_praxis_ort', 'ct_praxis_land', 'ct_praxis_land_kuerzel', 'ct_praxis_email', 'ct_praxis_website', 'ct_praxis_telefon_1', 'ct_praxis_telefon_2', 'ct_anmerkungen', 'sedierung_praeparat', 'sedierung_menge', 'anmerkungen', 'dokument_id', 'dokumentable_id', 'dokumentable_type'];

    protected function datumOperation(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function arzt()
    {
        return $this->belongsTo(Arzt::class, 'arzt_id');
    }

    public function score_rechts()
    {
        return $this->belongsTo(OptionPatellaLuxationScoring::class, 'score_rechts_id');
    }

    public function score_gesamt()
    {
        return $this->belongsTo(OptionPatellaLuxationScoring::class, 'score_gesamt_id');
    }

    public function score_links()
    {
        return $this->belongsTo(OptionPatellaLuxationScoring::class, 'score_links_id');
    }

    // public function operationsgrund()
    // {
    //     return $this->belongsTo(OptionPatellaLuxationScoring::class, 'grund_operation_id');
    // }

    // public function scopeAktiv($query)
    // {
    //    return $query->where('aktiv', true);
    // }

    // public function hund()
    // {
    //     return $this->belongsTo(Hund::class);
    // }
}
