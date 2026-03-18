<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCDUntersuchung extends Model
{
    use HasFactory;

    protected $table = 'ocd_untersuchungen';

    protected $fillable = ['id', 'hund_id', 'typ_id', 'datum', 'ocd', 'coronid', 'bearbeitungscode', 'formularcode', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'ct_datum', 'ct_art_id', 'ct_vetsxl_nr', 'ct_grund_id', 'ct_arzt_id', 'ct_arzt_titel', 'ct_arzt_vorname', 'ct_arzt_nachname', 'ct_praxis_id', 'ct_praxis_name', 'ct_praxis_strasse', 'ct_praxis_plz', 'ct_praxis_ort', 'ct_praxis_land', 'ct_praxis_land_kuerzel', 'ct_praxis_email', 'ct_praxis_website', 'ct_praxis_telefon_1', 'ct_praxis_telefon_2', 'ct_anmerkungen', 'sedierung_praeparat', 'sedierung_menge', 'anmerkungen', 'dokument_id', 'dokumentable_id', 'dokumentable_type'];

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function ocd_score_option()
    {
        return $this->belongsTo(OptionOCDScoring::class, 'ocd_id');
    }

    public function getOCDScoreAttribute()
    {
        return $this->ocd_id ? ['name' => $this->ocd_score_option->name, 'id' => $this->ocd_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOCDScoreRenderedAttribute()
    {
        return $this->ocd_id ? $this->ocd_score_option->name : '';
    }

    //  public function ocdl_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_l_id');
    //  }
    //  public function getOCDLScoreAttribute()
    //  {
    //     return $this->ocd_l_id ? [ 'name' => $this->ocdl_score_option->name, 'id' => $this->ocd_l_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDLScoreRenderedAttribute()
    //  {
    //     return $this->ocd_l_id ? $this->ocdl_score_option->name : '';
    //  }

    //  public function ocdr_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_r_id');
    // }
    //  public function getOCDRScoreAttribute()
    //  {
    //     return $this->ocd_r_id ? [ 'name' => $this->ocdr_score_option->name, 'id' => $this->ocd_r_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDRScoreRenderedAttribute()
    //  {
    //     return $this->ocd_r_id ? $this->ocdr_score_option->name : '';
    //  }

    // SCHULTER

    public function ocd_schulter_score_option()
    {
        return $this->belongsTo(OptionOCDScoring::class, 'ocd_schulter_id');
    }

    public function getOCDSchulterScoreAttribute()
    {
        return $this->ocd_schulter_id ? ['name' => $this->ocd_schulter_score_option->name, 'id' => $this->ocd_schulter_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOCDSchulterScoreRenderedAttribute()
    {
        return $this->ocd_schulter_id ? $this->ocd_schulter_score_option->name : '';
    }

    //  public function ocdl_schulter_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_schulter_l_id');
    //  }
    //  public function getOCDLSchulterScoreAttribute()
    //  {
    //     return $this->ocd_schulter_l_id ? [ 'name' => $this->ocdl_schulter_score_option->name, 'id' => $this->ocd_schulter_l_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDLSchulterScoreRenderedAttribute()
    //  {
    //     return $this->ocd_schulter_l_id ? $this->ocdl_schulter_score_option->name : '';
    //  }

    //  public function ocdr_schulter_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_schulter_r_id');
    // }
    //  public function getOCDRSchulterScoreAttribute()
    //  {
    //     return $this->ocd_schulter_r_id ? [ 'name' => $this->ocdr_schulter_score_option->name, 'id' => $this->ocd_schulter_r_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDRSchulterScoreRenderedAttribute()
    //  {
    //     return $this->ocd_schulter_r_id ? $this->ocdr_schulter_score_option->name : '';
    //  }

    // ELLENBOGEN

    public function ocd_ellenbogen_score_option()
    {
        return $this->belongsTo(OptionOCDScoring::class, 'ocd_ellenbogen_id');
    }

    public function getOCDEllenbogenScoreAttribute()
    {
        return $this->ocd_ellenbogen_id ? ['name' => $this->ocd_ellenbogen_score_option->name, 'id' => $this->ocd_ellenbogen_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOCDEllenbogenScoreRenderedAttribute()
    {
        return $this->ocd_ellenbogen_id ? $this->ocd_ellenbogen_score_option->name : '';
    }

    //  public function ocdl_ellenbogen_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_ellenbogen_l_id');
    //  }
    //  public function getOCDLEllenbogenScoreAttribute()
    //  {
    //     return $this->ocd_ellenbogen_l_id ? [ 'name' => $this->ocdl_ellenbogen_score_option->name, 'id' => $this->ocd_ellenbogen_l_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDLEllenbogenScoreRenderedAttribute()
    //  {
    //     return $this->ocd_ellenbogen_l_id ? $this->ocdl_ellenbogen_score_option->name : '';
    //  }

    //  public function ocdr_ellenbogen_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_ellenbogen_r_id');
    // }
    //  public function getOCDREllenbogenScoreAttribute()
    //  {
    //     return $this->ocd_ellenbogen_r_id ? [ 'name' => $this->ocdr_ellenbogen_score_option->name, 'id' => $this->ocd_ellenbogen_r_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDREllenbogenScoreRenderedAttribute()
    //  {
    //     return $this->ocd_ellenbogen_r_id ? $this->ocdr_ellenbogen_score_option->name : '';
    //  }

    // SPRUNGGELENK

    public function ocd_sprunggelenk_score_option()
    {
        return $this->belongsTo(OptionOCDScoring::class, 'ocd_sprunggelenk_id');
    }

    public function getOCDSprunggelenkScoreAttribute()
    {
        return $this->ocd_sprunggelenk_id ? ['name' => $this->ocd_sprunggelenk_score_option->name, 'id' => $this->ocd_sprunggelenk_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOCDSprunggelenkScoreRenderedAttribute()
    {
        return $this->ocd_sprunggelenk_id ? $this->ocd_sprunggelenk_score_option->name : '';
    }

    //  public function ocdl_sprunggelenk_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_sprunggelenk_l_id');
    //  }
    //  public function getOCDLSprunggelenkScoreAttribute()
    //  {
    //     return $this->ocd_sprunggelenk_l_id ? [ 'name' => $this->ocdl_sprunggelenk_score_option->name, 'id' => $this->ocd_sprunggelenk_l_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDLSprunggelenkScoreRenderedAttribute()
    //  {
    //     return $this->ocd_sprunggelenk_l_id ? $this->ocdl_sprunggelenk_score_option->name : '';
    //  }

    //  public function ocdr_sprunggelenk_score_option()
    //  {
    //    return $this->belongsTo(OptionOCDScoring::class, 'ocd_sprunggelenk_r_id');
    // }
    //  public function getOCDRSprunggelenkScoreAttribute()
    //  {
    //     return $this->ocd_sprunggelenk_r_id ? [ 'name' => $this->ocdr_sprunggelenk_score_option->name, 'id' => $this->ocd_sprunggelenk_r_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
    //  public function getOCDRSprunggelenkScoreRenderedAttribute()
    //  {
    //     return $this->ocd_sprunggelenk_r_id ? $this->ocdr_sprunggelenk_score_option->name : '';
    //  }

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
