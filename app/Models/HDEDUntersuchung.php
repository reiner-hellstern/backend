<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDEDUntersuchung extends Model
{
    use HasFactory;

    protected $table = 'hded_untersuchungen';

    // protected $with = ['hd_score_option','ed_score_option', 'hdr_score_option', 'hdl_score_option', 'typ_option' ];

    protected $appends = ['hd_score', 'ed_score', 'hd_l_score', 'hd_r_score', 'ed_r_score', 'ed_l_score', 'ed_arthrose_l_score', 'ed_arthrose_r_score', 'hd_uwirbel_score', 'typ'];

    // protected $appends = ['hd_score', 'ed_score','ed_og_score','hd_og_score','hd_l_score','hd_r_score','ed_r_score','ed_l_score', 'edr_arthrose', 'edl_arthrose', 'hd_uwirbel', 'ed_scoretyp_id', 'hd_scoretyp'];

    protected $fillable = ['id', 'hund_id', 'datum', 'typ_id', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'bearbeitungscode', 'formularcode', 'roentgen_datum', 'roentgen_art_id', 'roentgen_arzt_id', 'roentgen_arzt_titel', 'roentgen_arzt_vorname', 'roentgen_arzt_nachname', 'roentgen_praxis_id', 'roentgen_praxis_name', 'roentgen_praxis_strasse', 'roentgen_praxis_plz', 'roentgen_praxis_ort', 'roentgen_praxis_land', 'roentgen_praxis_land_kuerzel', 'roentgen_praxis_email', 'roentgen_praxis_website', 'roentgen_praxis_telefon_1', 'roentgen_praxis_telefon_2', 'roentgen_vetsxl_nr', 'roentgen_anmerkungen', 'sedierung_praeparat', 'sedierung_menge', 'scoreable_id', 'scoreable_type', 'hd', 'hd_score_id', 'hd_score_og_id', 'hd_status_id', 'hd_ablehnung_id', 'hd_r_score_id', 'hd_r_status_id', 'hd_l_score_id', 'hd_l_status_id', 'hd_scoretyp', 'hd_scoretyp_id', 'hd_uwirbel', 'hd_uwirbel_score_id', 'ed', 'ed_score_id', 'ed_score_og_id', 'ed_status_id', 'ed_ablehnung_id', 'ed_r_score_id', 'ed_r_status_id', 'ed_l_score_id', 'ed_l_status_id', 'ed_r_arthrose_score_id', 'ed_l_arthrose_score_id', 'ed_scoretyp_id', 'ed_scoretyp_id', 'ct_datum', 'ct_grund_id', 'ipa', 'fcp', 'ocd', 'coronid', 'anmerkungen', 'dokument_id', 'dokumentable_id', 'dokumentable_type', 'gutachter_id', 'gutachter_titel', 'gutachter_vorname', 'gutachter_nachname', 'gutachter_strasse', 'gutachter_plz', 'gutachter_ort', 'gutachter_land', 'gutachter_land_kuerzel', 'gutachter_email', 'gutachter_website', 'gutachter_telefon_1', 'gutachter_telefon_2', 'hd_lagerung_mangelhaft', 'ed_lagerung_mangelhaft', 'hd_qualitaet_mangelhaft', 'ed_qualitaet_mangelhaft'];

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function ctDatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function roentgenDatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function patellaDatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
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

    public function typ_option()
    {
        return $this->belongsTo(OptionHDEDTyp::class, 'typ_id');
    }

    public function getTypAttribute()
    {
        return $this->typ_id ? ['name' => $this->typ_option->name, 'id' => $this->typ_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hd_score_option()
    {
        switch ($this->hd_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionHDScoringDRC::class, 'hd_score_id');
            case '2':
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_score_id');
            case '3':
                return $this->belongsTo(OptionHDScoringOFA::class, 'hd_score_id');
            case '4':
                return $this->belongsTo(OptionHDScoringHS::class, 'hd_score_id');
            case '5':
                return $this->belongsTo(OptionHDScoringCH::class, 'hd_score_id');
            case '6':
                return $this->belongsTo(OptionHDScoringSW::class, 'hd_score_id');
            default:
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_score_id');
        }
    }

    public function getHDScoreAttribute()
    {
        return $this->hd_score_id ? ['name' => $this->hd_score_option->name, 'id' => $this->hd_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getHDScoreRenderedAttribute()
    {
        return $this->hd_score_id ? $this->hd_score_option->name : '';
    }

    public function hdl_score_option()
    {
        switch ($this->hd_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionHDScoringDRC::class, 'hd_l_score_id');
            case '2':
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_l_score_id');
            case '3':
                return $this->belongsTo(OptionHDScoringOFA::class, 'hd_l_score_id');
            case '4':
                return $this->belongsTo(OptionHDScoringHS::class, 'hd_l_score_id');
            case '5':
                return $this->belongsTo(OptionHDScoringCH::class, 'hd_l_score_id');
            case '6':
                return $this->belongsTo(OptionHDScoringSW::class, 'hd_l_score_id');
            default:
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_l_score_id');
        }
    }

    public function getHDLScoreAttribute()
    {
        return $this->hd_l_score_id ? ['name' => $this->hdl_score_option->name, 'id' => $this->hd_l_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getHDLScoreRenderedAttribute()
    {
        return $this->hd_l_score_id ? $this->hdl_score_option->name : '';
    }

    public function hdr_score_option()
    {
        switch ($this->hd_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionHDScoringDRC::class, 'hd_r_score_id');
            case '2':
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_r_score_id');
            case '3':
                return $this->belongsTo(OptionHDScoringOFA::class, 'hd_r_score_id');
            case '4':
                return $this->belongsTo(OptionHDScoringHS::class, 'hd_r_score_id');
            case '5':
                return $this->belongsTo(OptionHDScoringCH::class, 'hd_r_score_id');
            case '6':
                return $this->belongsTo(OptionHDScoringSW::class, 'hd_r_score_id');
            default:
                return $this->belongsTo(OptionHDScoringFCI::class, 'hd_r_score_id');
        }
    }

    public function getHDRScoreAttribute()
    {
        return $this->hd_r_score_id ? ['name' => $this->hdr_score_option->name, 'id' => $this->hd_r_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getHDRScoreRenderedAttribute()
    {
        return $this->hd_r_score_id ? $this->hdr_score_option->name : '';
    }

    //  public function hd_scoretyp_option()
    //  {
    //     return $this->belongsTo(Option::class, 'hd_scoretyp_id');
    //  }
    //  public function getHDScoretypAttribute()
    //  {
    //     return $this->hd_scoretyp_id ? [ 'name' => $this->hd_scoretyp_option->name, 'id' => $this->hd_scoretyp_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    public function ed_score_option()
    {
        switch ($this->ed_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionEDScoringDRC::class, 'ed_score_id');
            case '2':
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_score_id');
            case '3':
                return $this->belongsTo(OptionEDScoringOFA::class, 'ed_score_id');
            case '4':
                return $this->belongsTo(OptionEDScoringHS::class, 'ed_score_id');
            case '5':
                return $this->belongsTo(OptionEDScoringCH::class, 'ed_score_id');
            case '6':
                return $this->belongsTo(OptionEDScoringSW::class, 'ed_score_id');
            default:
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_score_id');
        }
    }

    //  public function ed_score_option()
    //  {
    //     return $this->belongsTo(OptionEDScore::class, 'ed_score_id');
    //  }
    public function getEDScoreAttribute()
    {
        return $this->ed_score_id ? ['name' => $this->ed_score_option->name, 'id' => $this->ed_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getEDScoreRenderedAttribute()
    {
        return $this->ed_score_id ? $this->ed_score_option->name : '';
    }

    public function edl_score_option()
    {
        switch ($this->ed_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionEDScoringDRC::class, 'ed_l_score_id');
            case '2':
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_l_score_id');
            case '3':
                return $this->belongsTo(OptionEDScoringOFA::class, 'ed_l_score_id');
            case '4':
                return $this->belongsTo(OptionEDScoringHS::class, 'ed_l_score_id');
            case '5':
                return $this->belongsTo(OptionEDScoringCH::class, 'ed_l_score_id');
            case '6':
                return $this->belongsTo(OptionEDScoringSW::class, 'ed_l_score_id');
            default:
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_l_score_id');
        }
    }

    public function getEDLScoreAttribute()
    {
        return $this->ed_l_score_id ? ['name' => $this->edl_score_option->name, 'id' => $this->ed_l_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getEDLScoreRenderedAttribute()
    {
        return $this->ed_l_score_id ? $this->edl_score_option->name : '';
    }

    public function edr_score_option()
    {
        switch ($this->ed_scoretyp_id) {
            case '1':
                return $this->belongsTo(OptionEDScoringDRC::class, 'ed_r_score_id');
            case '2':
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_r_score_id');
            case '3':
                return $this->belongsTo(OptionEDScoringOFA::class, 'ed_r_score_id');
            case '4':
                return $this->belongsTo(OptionEDScoringHS::class, 'ed_r_score_id');
            case '5':
                return $this->belongsTo(OptionEDScoringCH::class, 'ed_r_score_id');
            case '6':
                return $this->belongsTo(OptionEDScoringSW::class, 'ed_r_score_id');
            default:
                return $this->belongsTo(OptionEDScoringFCI::class, 'ed_r_score_id');
        }
    }

    public function getEDRScoreAttribute()
    {
        return $this->ed_r_score_id ? ['name' => $this->edr_score_option->name, 'id' => $this->ed_r_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getEDRScoreRenderedAttribute()
    {
        return $this->ed_r_score_id ? $this->edr_score_option->name : '';
    }

    public function edr_arthrose_option()
    {
        return $this->belongsTo(OptionEDArthrosegrad::class, 'ed_arthrose_r_id');
    }

    public function getEDArthroseRScoreAttribute()
    {
        return $this->ed_arthrose_r_id ? ['name' => $this->edr_arthrose_option->name, 'id' => $this->ed_arthrose_r_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getEDArthroseRScoreRenderedAttribute()
    {
        return $this->ed_arthrose_r_id ? $this->edr_arthrose_option->name : '';
    }

    public function edl_arthrose_option()
    {
        return $this->belongsTo(OptionEDArthrosegrad::class, 'ed_arthrose_l_id');
    }

    public function getEDArthroseLScoreAttribute()
    {
        return $this->ed_arthrose_l_id ? ['name' => $this->edl_arthrose_option->name, 'id' => $this->ed_arthrose_r_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getEDArthroseLScoreRenderedAttribute()
    {
        return $this->ed_arthrose_l_id ? $this->edl_arthrose_option->name : '';
    }

    public function hd_uwirbel_option()
    {
        return $this->belongsTo(OptionHDUebergangswirbel::class, 'hd_uwirbel_score_id');
    }

    public function getHDUwirbelScoreAttribute()
    {
        return $this->hd_uwirbel_score_id ? ['name' => $this->hd_uwirbel_option->name, 'id' => $this->hd_uwirbel_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getHDUwirbelScoreRenderedAttribute()
    {
        return $this->hd_uwirbel_score_id ? $this->hd_uwirbel_option->name : '';
    }

    public function patella_option()
    {
        return $this->belongsTo(OptionPatella::class, 'patella_id');
    }

    public function getPatellaScoreAttribute()
    {
        return $this->patella_id ? ['name' => $this->patella_option->name, 'id' => $this->patella_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getPatellaScoreRenderedAttribute()
    {
        return $this->patella_id ? $this->patella_option->name : '';
    }

    //  public function _option()
    //  {
    //     return $this->belongsTo(Option::class, '_id');
    //  }
    //  public function getAttribute()
    //  {
    //     return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

}
