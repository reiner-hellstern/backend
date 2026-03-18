<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wesenstest_v2 extends Model
{
    use HasFactory;

    protected $table = 'wesensteste_v2';

    // protected $appends = ['befragung_kontakt_sozialverhalten', 'befragung_kontakt_beschwichtigungsverhalten', 'befragung_kontakt_aggressionsverhalten', 'befragung_kontakt_aggressionsverhalten_identifizierung', 'menschengruppe_sozialverhalten' ];

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

    // public function befragung_kontakt_sozialverhalten_option() {
    //    return $this->belongsTo(OptionWesenstest2Sozialverhalten::class, 'befragung_kontakt_sozialverhalten_id');
    // }
    // public function getBefragungKontaktSozialverhaltenAttribute() {
    //    return $this->befragung_kontakt_sozialverhalten_id ? [ 'name' => $this->befragung_kontakt_sozialverhalten_option->name, 'id' => $this->befragung_kontakt_sozialverhalten_id, 'wert' => $this->befragung_kontakt_sozialverhalten_option->wert ] : [ 'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

    // public function befragung_kontakt_beschwichtigungsverhalten_option() {
    //    return $this->belongsTo(OptionWesenstest2Sozialverhalten::class, 'befragung_kontakt_beschwichtigungsverhalten_id');
    // }

    // public function getBefragungKontaktBeschwichtigungsverhaltenAttribute() {
    //    return $this->befragung_kontakt_beschwichtigungsverhalten_id ? [ 'name' => $this->befragung_kontakt_beschwichtigungsverhalten_option->name, 'id' => $this->befragung_kontakt_beschwichtigungsverhalten_id, 'wert' => $this->befragung_kontakt_beschwichtigungsverhalten_option->wert ] : [  'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

    // public function befragung_kontakt_aggressionsverhalten_option() {
    //    return $this->belongsTo(OptionWesenstest2Sozialverhalten::class, 'befragung_kontakt_aggressionsverhalten_id');
    // }
    // public function getBefragungKontaktAggressionsverhaltenAttribute() {
    //    return $this->befragung_kontakt_aggressionsverhalten_id? [ 'name' => $this->befragung_kontakt_aggressionsverhalten_option->name, 'id' => $this->befragung_kontakt_aggressionsverhalten_id, 'wert' => $this->befragung_kontakt_aggressionsverhalten_option->wert ] : [  'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

    // public function befragung_kontakt_aggressionsverhalten_identifizierung_option() {
    //    return $this->belongsTo(OptionWesenstest2Sozialverhalten::class, 'befragung_kontakt_aggressionsverhalten_identifizierung_id');
    // }
    // public function getBefragungKontaktAggressionsverhaltenIdentifizierungAttribute() {
    //    return $this->befragung_kontakt_aggressionsverhalten_identifizierung_id? [ 'name' => $this->befragung_kontakt_aggressionsverhalten_identifizierung_option->name, 'id' => $this->befragung_kontakt_aggressionsverhalten_identifizierung_id, 'wert' => $this->befragung_kontakt_aggressionsverhalten_identifizierung_option->wert ] : [  'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

    // public function menschengruppe_sozialverhalten_option() {
    //    return $this->belongsTo(OptionWesenstest2Sozialverhalten::class, 'menschengruppe_sozialverhalten_id');
    // }
    // public function getMenschengruppeSozialverhaltenAttribute() {
    //    return $this->menschengruppe_sozialverhalten_id? [ 'name' => $this->menschengruppe_sozialverhalten_option->name, 'id' => $this->menschengruppe_sozialverhalten_id, 'wert' => $this->menschengruppe_sozialverhalten_option->wert ] : [  'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

    // public function _option() {
    //    return $this->belongsTo(Option::class, '');
    // }
    // public function getAttribute() {
    //    return $this->_id? [ 'name' => $this->_option->name, 'id' => $this->_id, 'wert' => $this->_option->wert ] : [  'wert' => 0, 'name' =>'-', 'id' => 0 ];
    // }

}

//   ALTER TABLE `wesensteste_v2` ADD `befragung_kontakt_aggressionsverhalten_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `befragung_kontakt_aggressionsverhalten_identifizierung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spaziergang_hundefuehrer_aktivitaet_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `menschengruppe_sozialverhalten_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `menschengruppe_beschwichtigungsverhalten_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `menschengruppe_aggressionsverhalten_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_sozialverhalten_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_sozialverhalten_1_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_sozialverhalten_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_sozialverhalten_2_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_beschwichtigungsverhalten_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_beschwichtigungsverhalten_1_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_beschwichtigungsverhalten_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_beschwichtigungsverhalten_2_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_aggressionsverhalten_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_aggressionsverhalten_1_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_aggressionsverhalten_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `beruehrung_aggressionsverhalten_2_bewertung_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_spielverhalten_ohne_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_spielverhalten_mit_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_beuteverhalten_mit_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_beuteverhalten_werfen_des_gegenstandes_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_beuteverhalten_werfen_des_gegenstandes_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_tragenzutragen_werfen_des_gegenstandes_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_tragenzutragen_werfen_des_gegenstandes_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_suchverhalten_werfen_des_gegenstandes_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_beschwichtigungsverhalten_ohne_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_aggressionsverhalten_ohne_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `spiel_aggressionsverhalten_mit_gegenstand_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_haptisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_akustisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_optisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_haptisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_akustisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_optisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_haptisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_akustisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_schreckhaftigkeit_optisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_haptisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_akustisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_optisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_haptisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_akustisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_optisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_haptisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_akustisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_beschwichtigung_optisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_haptisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_akustisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_optisch_1_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_haptisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_akustisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_optisch_2_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_haptisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_akustisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_neugierverhalten_optisch_3_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `parcours_aktivitaet_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_schreckhaftigkeit_100m_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_schreckhaftigkeit_50m_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_schreckhaftigkeit_20m_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_beschwichtigung_100m_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_beschwichtigung_50m_id` bigint(20) unsigned NOT NULL;
//   ALTER TABLE `wesensteste_v2` ADD `schuss_beschwichtigung_20m_id` bigint(20) unsigned NOT NULL;

// .   befragung_kontakt_sozialverhalten
// .   befragung_kontakt_beschwichtigungsverhalten
// .   befragung_kontakt_aggressionsverhalten
// .   befragung_kontakt_aggressionsverhalten_identifizierung
// spaziergang_hundefuehrer_aktivitaet
// .   menschengruppe_sozialverhalten
// menschengruppe_beschwichtigungsverhalten
// menschengruppe_aggressionsverhalten
// beruehrung_sozialverhalten_1
// beruehrung_sozialverhalten_1_bewertung
// beruehrung_sozialverhalten_2
// beruehrung_sozialverhalten_2_bewertung
// beruehrung_beschwichtigungsverhalten_1
// beruehrung_beschwichtigungsverhalten_1_bewertung
// beruehrung_beschwichtigungsverhalten_2
// beruehrung_beschwichtigungsverhalten_2_bewertung
// beruehrung_aggressionsverhalten_1
// beruehrung_aggressionsverhalten_1_bewertung
// beruehrung_aggressionsverhalten_2
// beruehrung_aggressionsverhalten_2_bewertung
// spiel_spielverhalten_ohne_gegenstand
// spiel_spielverhalten_mit_gegenstand
// spiel_beuteverhalten_mit_gegenstand
// spiel_beuteverhalten_werfen_des_gegenstandes_1
// spiel_beuteverhalten_werfen_des_gegenstandes_2
// spiel_tragenzutragen_werfen_des_gegenstandes_1
// spiel_tragenzutragen_werfen_des_gegenstandes_2
// spiel_suchverhalten_werfen_des_gegenstandes_2
// spiel_beschwichtigungsverhalten_ohne_gegenstand
// spiel_aggressionsverhalten_ohne_gegenstand
// spiel_aggressionsverhalten_mit_gegenstand
// parcours_schreckhaftigkeit_haptisch_1
// parcours_schreckhaftigkeit_akustisch_1
// parcours_schreckhaftigkeit_optisch_1
// parcours_schreckhaftigkeit_haptisch_2
// parcours_schreckhaftigkeit_akustisch_2
// parcours_schreckhaftigkeit_optisch_2
// parcours_schreckhaftigkeit_haptisch_3
// parcours_schreckhaftigkeit_akustisch_3
// parcours_schreckhaftigkeit_optisch_3
// parcours_beschwichtigung_haptisch_1
// parcours_beschwichtigung_akustisch_1
// parcours_beschwichtigung_optisch_1
// parcours_beschwichtigung_haptisch_2
// parcours_beschwichtigung_akustisch_2
// parcours_beschwichtigung_optisch_2
// parcours_beschwichtigung_haptisch_3
// parcours_beschwichtigung_akustisch_3
// parcours_beschwichtigung_optisch_3
// parcours_neugierverhalten_haptisch_1
// parcours_neugierverhalten_akustisch_1
// parcours_neugierverhalten_optisch_1
// parcours_neugierverhalten_haptisch_2
// parcours_neugierverhalten_akustisch_2
// parcours_neugierverhalten_optisch_2
// parcours_neugierverhalten_haptisch_3
// parcours_neugierverhalten_akustisch_3
// parcours_neugierverhalten_optisch_3
// parcours_aktivitaet
// schuss_schreckhaftigkeit_100m
// schuss_schreckhaftigkeit_50m
// schuss_schreckhaftigkeit_20m
// schuss_beschwichtigung_100m
// schuss_beschwichtigung_50m
// schuss_beschwichtigung_20m
