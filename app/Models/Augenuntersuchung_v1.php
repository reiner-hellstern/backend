<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Augenuntersuchung_v1 extends Model
{
    use HasFactory;

    protected $table = 'augenuntersuchungen_v1';

    protected $fillable = ['id', 'hund_id', 'datum', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'typ_id', 'mpp_id', 'mpp_nfrei_id', 'phtvlphpv_id', 'phtvlphpv_nfrei_id', 'katarakt_kon_id', 'rd_id', 'rd_nfrei_id', 'katarakt_nonkon_id', 'hypoplasie_mikropapille_id', 'cea_id', 'cea_nfrei_id', 'dyslpectabnorm_id', 'dyslpectabnorm_nfrei_id', 'entropium_id', 'ektropium_id', 'icaa_id', 'distichiasis_id', 'korneadystrophie_id', 'linsenluxation_id', 'pra_rd_id', 'methode_id', 'ophtalmoskopie', 'gonioskopie', 'tonometrie', 'foto', 'weitere_methode', 'katarakt_kon_nfrei_id'];

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

    // public function _option()
    // {
    //    return $this->belongsTo(Option::class, '_id');
    // }
    // public function getAttribute()
    // {
    //    return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    // }
}
