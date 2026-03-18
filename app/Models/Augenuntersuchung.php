<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Augenuntersuchung extends Model
{
    use HasFactory;

    protected $table = 'augenuntersuchungen';

    protected $append = ['typ', 'gesamtergebnis', 'dokumente'];

    protected $fillable = ['id', 'hund_id', 'anmerkungen', 'datum', 'gesamtergebnis_id', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'typ_id', 'mpp_id', 'mpp_iris', 'mpp_linse', 'mpp_komea', 'mpp_vorderkammer', 'phtvlphpv_id', 'phtvlphpv_nfrei_id', 'rd_id', 'rd_multifokal', 'rd_geo', 'rd_total', 'katarakt_nonkon_id', 'katarakt_kon_id', 'katarakt_cortikalis', 'katarakt_polpost', 'katarakt_sutura_ant', 'katarakt_punctata', 'katarakt_nuklearis', 'hypoplasie_mikropapille_id', 'cea_id', 'cea_choroidhypo', 'cea_kolobom', 'cea_sonstige', 'cea_sonstige_angaben', 'dyslpectabnorm_id', 'dyslpectabnorm_kurztrabekel', 'dyslpectabnorm_gewebebruecken', 'dyslpectabnorm_totaldyspl', 'entropium_id', 'ektropium_id', 'icaa_id', 'icaa_nfrei_id', 'distichiasis_id', 'korneadystrophie_id', 'linsenluxation_id', 'pra_rd_id', 'methode_id', 'ophtalmoskopie_d', 'ophtalmoskopie_ind', 'gonioskopie', 'tonometrie', 'mydriatikum', 'foto', 'weitere_methode_b', 'weitere_methode', 'spaltlampe', 'pla_id', 'primaerglaukom_id', 'ica_weite_id'];

    //  protected $appends = ['typ', 'mpp', 'phtvlphpv', 'phtvlphpv_nfrei', 'rd', 'katarakt_nonkon', 'katarakt_kon', 'hypoplasie_mikropapille', 'cea',  'dyslpectabnorm','entropium', 'ektropium', 'icaa', 'icaa_nfrei', 'distichiasis', 'korneadystrophie', 'linsenluxation', 'pra_rd', 'methode', 'pla', 'primaerglaukom', 'ica_weite'];

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

    public function typ_option()
    {
        return $this->belongsTo(OptionAUTyp::class, 'typ_id');
    }

    public function getTypAttribute()
    {
        return $this->typ_id ? ['name' => $this->typ_option->name, 'id' => $this->typ_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gesamtergebnis_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'gesamtergebnis_id');
    }

    public function getGesamtergebnisAttribute()
    {
        return $this->gesamtergebnis_id ? ['name' => $this->gesamtergebnis_option->name, 'id' => $this->gesamtergebnis_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function mpp_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'mpp_id');
    }

    public function getMppAttribute()
    {
        return $this->mpp_id ? $this->mpp_option->name : '';
    }

    public function phtvlphpv_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'phtvlphpv_id');
    }

    public function getPhtvlphpvAttribute()
    {
        return $this->phtvlphpv_id ? $this->phtvlphpv_option->name : '';
    }

    public function phtvlphpv_nfrei_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'phtvlphpv_nfrei_id');
    }

    public function getPhtvlphpvNfreiAttribute()
    {
        return $this->phtvlphpv_nfrei_id ? $this->phtvlphpv_nfrei_option->name : '';
    }

    public function rd_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'rd_id');
    }

    public function getRdAttribute()
    {
        return $this->rd_id ? $this->rd_option->name : '';
    }

    public function katarakt_nonkon_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'katarakt_nonkon_id');
    }

    public function getKataraktNonkonAttribute()
    {
        return $this->katarakt_nonkon_id ? $this->katarakt_nonkon_option->name : '';
    }

    public function katarakt_kon_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'katarakt_kon_id');
    }

    public function getKataraktKonAttribute()
    {
        return $this->katarakt_kon_id ? $this->katarakt_kon_option->name : '';
    }

    public function hypoplasie_mikropapille_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'hypoplasie_mikropapille_id');
    }

    public function getHypoplasieMikropapilleAttribute()
    {
        return $this->hypoplasie_mikropapille_id ? $this->hypoplasie_mikropapille_option->name : '';
    }

    public function cea_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'cea_id');
    }

    public function getCeaAttribute()
    {
        return $this->cea_id ? $this->cea_option->name : '';
    }

    public function dyslpectabnorm_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'dyslpectabnorm_id');
    }

    public function getDyslpectabnormAttribute()
    {
        return $this->dyslpectabnorm_id ? $this->dyslpectabnorm_option->name : '';
    }

    public function entropium_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'entropium_id');
    }

    public function getEntropiumAttribute()
    {
        return $this->entropium_id ? $this->entropium_option->name : '';
    }

    public function ektropium_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'ektropium_id');
    }

    public function getEktropiumAttribute()
    {
        return $this->ektropium_id ? $this->ektropium_option->name : '';
    }

    public function icaa_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'icaa_id');
    }

    public function getIcaaAttribute()
    {
        return $this->icaa_id ? $this->icaa_option->name : '';
    }

    public function icaa_nfrei_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'icaa_nfrei_id');
    }

    public function getIcaaNfreiAttribute()
    {
        return $this->icaa_nfrei_id ? $this->icaa_nfrei_option->name : '';
    }

    public function distichiasis_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'distichiasis_id');
    }

    public function getDistichiasisAttribute()
    {
        return $this->distichiasis_id ? $this->distichiasis_option->name : '';
    }

    public function korneadystrophie_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'korneadystrophie_id');
    }

    public function getKorneadystrophieAttribute()
    {
        return $this->korneadystrophie_id ? $this->korneadystrophie_option->name : '';
    }

    public function linsenluxation_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'linsenluxation_id');
    }

    public function getLinsenluxationAttribute()
    {
        return $this->linsenluxation_id ? $this->linsenluxation_option->name : '';
    }

    public function pra_rd_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'pra_rd_id');
    }

    public function getPraRdAttribute()
    {
        return $this->pra_rd_id ? $this->pra_rd_option->name : '';
    }

    // public function methode_option()
    // {
    //    return $this->belongsTo(OptionAUErbZweifel::class, 'methode_id');
    // }
    // public function getMethodeAttribute()
    // {
    //    return $this->methode_id ? $this->methode_option->name : '';
    // }

    public function pla_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'pla_id');
    }

    public function getPlaAttribute()
    {
        return $this->pla_id ? $this->pla_option->name : '';
    }

    public function primaerglaukom_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'primaerglaukom_id');
    }

    public function getPrimaerglaukomAttribute()
    {
        return $this->primaerglaukom_id ? $this->primaerglaukom_option->name : '';
    }

    public function ica_weite_option()
    {
        return $this->belongsTo(OptionAUErbZweifel::class, 'ica_weite_id');
    }

    public function getIcaWeiteAttribute()
    {
        return $this->ica_weite_id ? $this->ica_weite_option->name : '';
    }

    // public function _option()
    // {
    //    return $this->belongsTo(Option::class, '_id');
    // }
    // public function getAttribute()
    // {
    //    return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    // }
}
