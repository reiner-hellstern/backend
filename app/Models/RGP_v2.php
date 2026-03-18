<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RGP_v2 extends Model
{
    use HasFactory;

    protected $table = 'rgp_v2';

    protected $appends = ['waldarbeit_riemenarbeit', 'waldarbeit_totverbellen', 'waldarbeit_totverweisen', 'waldarbeit_schleppe_hasekanin', 'waldarbeit_suche_bringen_nutzwild', 'waldarbeit_bringen', 'waldarbeit_buschieren', 'waldarbeit_fuchsschleppe', 'waldarbeit_bringen_fuchsschleppe', 'wasserarbeit_stoebern_ohne_ente', 'wasserarbeit_verlorensuche', 'wasserarbeit_stoebern_mit_ente', 'wasserarbeit_stoebern_mit_ente_zeugnis_bewertung', 'wasserarbeit_einweisen', 'wasserarbeit_bringen_ente', 'feldarbeit_federwildschleppe', 'feldarbeit_einweisen', 'feldarbeit_merken', 'feldarbeit_standruhe', 'feldarbeit_bringen_federwild', 'gehorsam_allgemein', 'gehorsam_stand', 'gehorsam_leinenfuehrigkeit', 'gehorsam_folgen', 'gehorsam_ablegen', 'arbeitsfreude', 'schussfestigkeit_land', 'schussfestigkeit_wasser', 'preis'];

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

    public function waldarbeit_riemenarbeit_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_riemenarbeit_id');
    }

    public function getWaldarbeitRiemenarbeitAttribute()
    {
        return $this->waldarbeit_riemenarbeit_id ? ['name' => $this->waldarbeit_riemenarbeit_option->name, 'id' => $this->waldarbeit_riemenarbeit_id, 'wert' => $this->waldarbeit_riemenarbeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_totverbellen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_totverbellen_id');
    }

    public function getWaldarbeitTotverbellenAttribute()
    {
        return $this->waldarbeit_totverbellen_id ? ['name' => $this->waldarbeit_totverbellen_option->name, 'id' => $this->waldarbeit_totverbellen_id, 'wert' => $this->waldarbeit_totverbellen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_totverweisen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_totverweisen_id');
    }

    public function getWaldarbeitTotverweisenAttribute()
    {
        return $this->waldarbeit_totverweisen_id ? ['name' => $this->waldarbeit_totverweisen_option->name, 'id' => $this->waldarbeit_totverweisen_id, 'wert' => $this->waldarbeit_totverweisen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_schleppe_hasekanin_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_schleppe_hasekanin_id');
    }

    public function getWaldarbeitSchleppeHasekaninAttribute()
    {
        return $this->waldarbeit_schleppe_hasekanin_id ? ['name' => $this->waldarbeit_schleppe_hasekanin_option->name, 'id' => $this->waldarbeit_schleppe_hasekanin_id, 'wert' => $this->waldarbeit_schleppe_hasekanin_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_suche_bringen_nutzwild_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_suche_bringen_nutzwild_id');
    }

    public function getWaldarbeitSucheBringenNutzwildAttribute()
    {
        return $this->waldarbeit_suche_bringen_nutzwild_id ? ['name' => $this->waldarbeit_suche_bringen_nutzwild_option->name, 'id' => $this->waldarbeit_suche_bringen_nutzwild_id, 'wert' => $this->waldarbeit_suche_bringen_nutzwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_bringen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_bringen_id');
    }

    public function getWaldarbeitBringenAttribute()
    {
        return $this->waldarbeit_bringen_id ? ['name' => $this->waldarbeit_bringen_option->name, 'id' => $this->waldarbeit_bringen_id, 'wert' => $this->waldarbeit_bringen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_buschieren_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_buschieren_id');
    }

    public function getWaldarbeitBuschierenAttribute()
    {
        return $this->waldarbeit_buschieren_id ? ['name' => $this->waldarbeit_buschieren_option->name, 'id' => $this->waldarbeit_buschieren_id, 'wert' => $this->waldarbeit_buschieren_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_fuchsschleppe_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_fuchsschleppe_id');
    }

    public function getWaldarbeitFuchsschleppeAttribute()
    {
        return $this->waldarbeit_fuchsschleppe_id ? ['name' => $this->waldarbeit_fuchsschleppe_option->name, 'id' => $this->waldarbeit_fuchsschleppe_id, 'wert' => $this->waldarbeit_fuchsschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function waldarbeit_bringen_fuchsschleppe_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'waldarbeit_bringen_fuchsschleppe_id');
    }

    public function getWaldarbeitBringenFuchsschleppeAttribute()
    {
        return $this->waldarbeit_bringen_fuchsschleppe_id ? ['name' => $this->waldarbeit_bringen_fuchsschleppe_option->name, 'id' => $this->waldarbeit_bringen_fuchsschleppe_id, 'wert' => $this->waldarbeit_bringen_fuchsschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_stoebern_ohne_ente_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_stoebern_ohne_ente_id');
    }

    public function getWasserarbeitStoebernOhneEnteAttribute()
    {
        return $this->wasserarbeit_stoebern_ohne_ente_id ? ['name' => $this->wasserarbeit_stoebern_ohne_ente_option->name, 'id' => $this->wasserarbeit_stoebern_ohne_ente_id, 'wert' => $this->wasserarbeit_stoebern_ohne_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_verlorensuche_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_verlorensuche_id');
    }

    public function getWasserarbeitVerlorensucheAttribute()
    {
        return $this->wasserarbeit_verlorensuche_id ? ['name' => $this->wasserarbeit_verlorensuche_option->name, 'id' => $this->wasserarbeit_verlorensuche_id, 'wert' => $this->wasserarbeit_verlorensuche_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_stoebern_mit_ente_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_stoebern_mit_ente_id');
    }

    public function getWasserarbeitStoebernMitEnteAttribute()
    {
        return $this->wasserarbeit_stoebern_mit_ente_id ? ['name' => $this->wasserarbeit_stoebern_mit_ente_option->name, 'id' => $this->wasserarbeit_stoebern_mit_ente_id, 'wert' => $this->wasserarbeit_stoebern_mit_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_id');
    }

    public function getWasserarbeitStoebernMitEnteZeugnisBewertungAttribute()
    {
        return $this->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_id ? ['name' => $this->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_option->name, 'id' => $this->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_id, 'wert' => $this->wasserarbeit_stoebern_mit_ente_zeugnis_bewertung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_einweisen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_einweisen_id');
    }

    public function getWasserarbeitEinweisenAttribute()
    {
        return $this->wasserarbeit_einweisen_id ? ['name' => $this->wasserarbeit_einweisen_option->name, 'id' => $this->wasserarbeit_einweisen_id, 'wert' => $this->wasserarbeit_einweisen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasserarbeit_bringen_ente_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'wasserarbeit_bringen_ente_id');
    }

    public function getWasserarbeitBringenEnteAttribute()
    {
        return $this->wasserarbeit_bringen_ente_id ? ['name' => $this->wasserarbeit_bringen_ente_option->name, 'id' => $this->wasserarbeit_bringen_ente_id, 'wert' => $this->wasserarbeit_bringen_ente_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function feldarbeit_federwildschleppe_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'feldarbeit_federwildschleppe_id');
    }

    public function getFeldarbeitFederwildschleppeAttribute()
    {
        return $this->feldarbeit_federwildschleppe_id ? ['name' => $this->feldarbeit_federwildschleppe_option->name, 'id' => $this->feldarbeit_federwildschleppe_id, 'wert' => $this->feldarbeit_federwildschleppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function feldarbeit_einweisen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'feldarbeit_einweisen_id');
    }

    public function getFeldarbeitEinweisenAttribute()
    {
        return $this->feldarbeit_einweisen_id ? ['name' => $this->feldarbeit_einweisen_option->name, 'id' => $this->feldarbeit_einweisen_id, 'wert' => $this->feldarbeit_einweisen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function feldarbeit_merken_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'feldarbeit_merken_id');
    }

    public function getFeldarbeitMerkenAttribute()
    {
        return $this->feldarbeit_merken_id ? ['name' => $this->feldarbeit_merken_option->name, 'id' => $this->feldarbeit_merken_id, 'wert' => $this->feldarbeit_merken_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function feldarbeit_standruhe_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'feldarbeit_standruhe_id');
    }

    public function getFeldarbeitStandruheAttribute()
    {
        return $this->feldarbeit_standruhe_id ? ['name' => $this->feldarbeit_standruhe_option->name, 'id' => $this->feldarbeit_standruhe_id, 'wert' => $this->feldarbeit_standruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function feldarbeit_bringen_federwild_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'feldarbeit_bringen_federwild_id');
    }

    public function getFeldarbeitBringenFederwildAttribute()
    {
        return $this->feldarbeit_bringen_federwild_id ? ['name' => $this->feldarbeit_bringen_federwild_option->name, 'id' => $this->feldarbeit_bringen_federwild_id, 'wert' => $this->feldarbeit_bringen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_allgemein_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'gehorsam_allgemein_id');
    }

    public function getGehorsamAllgemeinAttribute()
    {
        return $this->gehorsam_allgemein_id ? ['name' => $this->gehorsam_allgemein_option->name, 'id' => $this->gehorsam_allgemein_id, 'wert' => $this->gehorsam_allgemein_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_stand_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'gehorsam_stand_id');
    }

    public function getGehorsamStandAttribute()
    {
        return $this->gehorsam_stand_id ? ['name' => $this->gehorsam_stand_option->name, 'id' => $this->gehorsam_stand_id, 'wert' => $this->gehorsam_stand_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_leinenfuehrigkeit_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'gehorsam_leinenfuehrigkeit_id');
    }

    public function getGehorsamLeinenfuehrigkeitAttribute()
    {
        return $this->gehorsam_leinenfuehrigkeit_id ? ['name' => $this->gehorsam_leinenfuehrigkeit_option->name, 'id' => $this->gehorsam_leinenfuehrigkeit_id, 'wert' => $this->gehorsam_leinenfuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_folgen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'gehorsam_folgen_id');
    }

    public function getGehorsamFolgenAttribute()
    {
        return $this->gehorsam_folgen_id ? ['name' => $this->gehorsam_folgen_option->name, 'id' => $this->gehorsam_folgen_id, 'wert' => $this->gehorsam_folgen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gehorsam_ablegen_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'gehorsam_ablegen_id');
    }

    public function getGehorsamAblegenAttribute()
    {
        return $this->gehorsam_ablegen_id ? ['name' => $this->gehorsam_ablegen_option->name, 'id' => $this->gehorsam_ablegen_id, 'wert' => $this->gehorsam_ablegen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function arbeitsfreude_option()
    {
        return $this->belongsTo(OptionRGP2Leistungsziffer::class, 'arbeitsfreude_id');
    }

    public function getArbeitsfreudeAttribute()
    {
        return $this->arbeitsfreude_id ? ['name' => $this->arbeitsfreude_option->name, 'id' => $this->arbeitsfreude_id, 'wert' => $this->arbeitsfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_land_option()
    {
        return $this->belongsTo(OptionRGP2Schussfestigkeit::class, 'schussfestigkeit_land_id');
    }

    public function getSchussfestigkeitLandAttribute()
    {
        return $this->schussfestigkeit_land_id ? ['name' => $this->schussfestigkeit_land_option->name, 'id' => $this->schussfestigkeit_land_id, 'wert' => $this->schussfestigkeit_land_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_wasser_option()
    {
        return $this->belongsTo(OptionRGP2Schussfestigkeit::class, 'schussfestigkeit_wasser_id');
    }

    public function getSchussfestigkeitWasserAttribute()
    {
        return $this->schussfestigkeit_wasser_id ? ['name' => $this->schussfestigkeit_wasser_option->name, 'id' => $this->schussfestigkeit_wasser_id, 'wert' => $this->schussfestigkeit_wasser_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function preis_option()
    {
        return $this->belongsTo(OptionRGP2Preisklassen::class, 'preis_id');
    }

    public function getPreisAttribute()
    {
        return $this->preis_id ? ['name' => $this->preis_option->name, 'id' => $this->preis_id, 'wert' => $this->preis_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
