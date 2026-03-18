<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JAS_v1 extends Model
{
    use HasFactory;

    protected $table = 'jas_v1';

    protected $appends = ['verlorensuche_wald_arbeitseifer', 'verlorensuche_wald_finderwille', 'verlorensuche_wald_selbststaendigkeit', 'verlorensuche_wald_nasengebrauch', 'verlorensuche_wald_koerperliche_haerte', 'verlorensuche_feld_arbeitseifer', 'verlorensuche_feld_finderwille', 'verlorensuche_feld_selbststaendigkeit', 'verlorensuche_feld_nasengebrauch', 'verlorensuche_feld_fuehrigkeit', 'verlorensuche_feld_koerperliche_haerte', 'schleppspur_arbeitseifer', 'schleppspur_finderwille', 'schleppspur_selbststaendigkeit', 'schleppspur_nasengebrauch', 'schleppspur_koerperliche_haerte', 'schleppspur_spurwille', 'wasser_arbeitseifer', 'wasser_finderwille', 'wasser_selbststaendigkeit', 'wasser_nasengebrauch', 'wasser_arbeitsruhe', 'wasser_fuehrigkeit', 'wasser_koerperliche_haerte', 'wasser_wasserfreude', 'markierung_finderwille', 'markierung_nasengebrauch', 'markierung_arbeitsruhe', 'markierung_koerperliche_haerte', 'markierung_konzentration', 'markierung_einschaetzung_entfernung', 'schussfestigkeit', 'temperament', 'selbstsicherheit', 'vertraeglichkeit', 'sonstige_wesenverhalten'];

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

    public function verlorensuche_wald_arbeitseifer_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_wald_arbeitseifer_id');
    }

    public function getVerlorensucheWaldArbeitseiferAttribute()
    {
        return $this->verlorensuche_wald_arbeitseifer_id ? ['name' => $this->verlorensuche_wald_arbeitseifer_option->name, 'id' => $this->verlorensuche_wald_arbeitseifer_id, 'wert' => $this->verlorensuche_wald_arbeitseifer_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wald_finderwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_wald_finderwille_id');
    }

    public function getVerlorensucheWaldFinderwilleAttribute()
    {
        return $this->verlorensuche_wald_finderwille_id ? ['name' => $this->verlorensuche_wald_finderwille_option->name, 'id' => $this->verlorensuche_wald_finderwille_id, 'wert' => $this->verlorensuche_wald_finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wald_selbststaendigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_wald_selbststaendigkeit_id');
    }

    public function getVerlorensucheWaldSelbststaendigkeitAttribute()
    {
        return $this->verlorensuche_wald_selbststaendigkeit_id ? ['name' => $this->verlorensuche_wald_selbststaendigkeit_option->name, 'id' => $this->verlorensuche_wald_selbststaendigkeit_id, 'wert' => $this->verlorensuche_wald_selbststaendigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wald_nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'verlorensuche_wald_nasengebrauch_id');
    }

    public function getVerlorensucheWaldNasengebrauchAttribute()
    {
        return $this->verlorensuche_wald_nasengebrauch_id ? ['name' => $this->verlorensuche_wald_nasengebrauch_option->name, 'id' => $this->verlorensuche_wald_nasengebrauch_id, 'wert' => $this->verlorensuche_wald_nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_wald_koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_wald_koerperliche_haerte_id');
    }

    public function getVerlorensucheWaldKoerperlicheHaerteAttribute()
    {
        return $this->verlorensuche_wald_koerperliche_haerte_id ? ['name' => $this->verlorensuche_wald_koerperliche_haerte_option->name, 'id' => $this->verlorensuche_wald_koerperliche_haerte_id, 'wert' => $this->verlorensuche_wald_koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_arbeitseifer_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_feld_arbeitseifer_id');
    }

    public function getVerlorensucheFeldArbeitseiferAttribute()
    {
        return $this->verlorensuche_feld_arbeitseifer_id ? ['name' => $this->verlorensuche_feld_arbeitseifer_option->name, 'id' => $this->verlorensuche_feld_arbeitseifer_id, 'wert' => $this->verlorensuche_feld_arbeitseifer_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_finderwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_feld_finderwille_id');
    }

    public function getVerlorensucheFeldFinderwilleAttribute()
    {
        return $this->verlorensuche_feld_finderwille_id ? ['name' => $this->verlorensuche_feld_finderwille_option->name, 'id' => $this->verlorensuche_feld_finderwille_id, 'wert' => $this->verlorensuche_feld_finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_selbststaendigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_feld_selbststaendigkeit_id');
    }

    public function getVerlorensucheFeldSelbststaendigkeitAttribute()
    {
        return $this->verlorensuche_feld_selbststaendigkeit_id ? ['name' => $this->verlorensuche_feld_selbststaendigkeit_option->name, 'id' => $this->verlorensuche_feld_selbststaendigkeit_id, 'wert' => $this->verlorensuche_feld_selbststaendigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'verlorensuche_feld_nasengebrauch_id');
    }

    public function getVerlorensucheFeldNasengebrauchAttribute()
    {
        return $this->verlorensuche_feld_nasengebrauch_id ? ['name' => $this->verlorensuche_feld_nasengebrauch_option->name, 'id' => $this->verlorensuche_feld_nasengebrauch_id, 'wert' => $this->verlorensuche_feld_nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_fuehrigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_feld_fuehrigkeit_id');
    }

    public function getVerlorensucheFeldFuehrigkeitAttribute()
    {
        return $this->verlorensuche_feld_fuehrigkeit_id ? ['name' => $this->verlorensuche_feld_fuehrigkeit_option->name, 'id' => $this->verlorensuche_feld_fuehrigkeit_id, 'wert' => $this->verlorensuche_feld_fuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function verlorensuche_feld_koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'verlorensuche_feld_koerperliche_haerte_id');
    }

    public function getVerlorensucheFeldKoerperlicheHaerteAttribute()
    {
        return $this->verlorensuche_feld_koerperliche_haerte_id ? ['name' => $this->verlorensuche_feld_koerperliche_haerte_option->name, 'id' => $this->verlorensuche_feld_koerperliche_haerte_id, 'wert' => $this->verlorensuche_feld_koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schleppspur_arbeitseifer_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'schleppspur_arbeitseifer_id');
    }

    public function getSchleppspurArbeitseiferAttribute()
    {
        return $this->schleppspur_arbeitseifer_id ? ['name' => $this->schleppspur_arbeitseifer_option->name, 'id' => $this->schleppspur_arbeitseifer_id, 'wert' => $this->schleppspur_arbeitseifer_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schleppspur_finderwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'schleppspur_finderwille_id');
    }

    public function getSchleppspurFinderwilleAttribute()
    {
        return $this->schleppspur_finderwille_id ? ['name' => $this->schleppspur_finderwille_option->name, 'id' => $this->schleppspur_finderwille_id, 'wert' => $this->schleppspur_finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schleppspur_selbststaendigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'schleppspur_selbststaendigkeit_id');
    }

    public function getSchleppspurSelbststaendigkeitAttribute()
    {
        return $this->schleppspur_selbststaendigkeit_id ? ['name' => $this->schleppspur_selbststaendigkeit_option->name, 'id' => $this->schleppspur_selbststaendigkeit_id, 'wert' => $this->schleppspur_selbststaendigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schleppspur_nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'schleppspur_nasengebrauch_id');
    }

    public function getSchleppspurNasengebrauchAttribute()
    {
        return $this->schleppspur_nasengebrauch_id ? ['name' => $this->schleppspur_nasengebrauch_option->name, 'id' => $this->schleppspur_nasengebrauch_id, 'wert' => $this->schleppspur_nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    //   public function schleppspur_fuehrigkeit_option()
    //    {
    //       return $this->belongsTo(OptionJAS1Punkte13::class, 'schleppspur_fuehrigkeit_id');
    //    }
    //    public function getSchleppspurFuehrigkeitAttribute()
    //    {
    //       return $this->schleppspur_fuehrigkeit_id ? [ 'name' => $this->schleppspur_fuehrigkeit_option->name, 'id' => $this->schleppspur_fuehrigkeit_id, 'wert' => $this->schleppspur_fuehrigkeit_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //    }

    public function schleppspur_koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'schleppspur_koerperliche_haerte_id');
    }

    public function getSchleppspurKoerperlicheHaerteAttribute()
    {
        return $this->schleppspur_koerperliche_haerte_id ? ['name' => $this->schleppspur_koerperliche_haerte_option->name, 'id' => $this->schleppspur_koerperliche_haerte_id, 'wert' => $this->schleppspur_koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schleppspur_spurwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'schleppspur_spurwille_id');
    }

    public function getSchleppspurSpurwilleAttribute()
    {
        return $this->schleppspur_spurwille_id ? ['name' => $this->schleppspur_spurwille_option->name, 'id' => $this->schleppspur_spurwille_id, 'wert' => $this->schleppspur_spurwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_arbeitseifer_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_arbeitseifer_id');
    }

    public function getWasserArbeitseiferAttribute()
    {
        return $this->wasser_arbeitseifer_id ? ['name' => $this->wasser_arbeitseifer_option->name, 'id' => $this->wasser_arbeitseifer_id, 'wert' => $this->wasser_arbeitseifer_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_finderwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_finderwille_id');
    }

    public function getWasserFinderwilleAttribute()
    {
        return $this->wasser_finderwille_id ? ['name' => $this->wasser_finderwille_option->name, 'id' => $this->wasser_finderwille_id, 'wert' => $this->wasser_finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_selbststaendigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_selbststaendigkeit_id');
    }

    public function getWasserSelbststaendigkeitAttribute()
    {
        return $this->wasser_selbststaendigkeit_id ? ['name' => $this->wasser_selbststaendigkeit_option->name, 'id' => $this->wasser_selbststaendigkeit_id, 'wert' => $this->wasser_selbststaendigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'wasser_nasengebrauch_id');
    }

    public function getWasserNasengebrauchAttribute()
    {
        return $this->wasser_nasengebrauch_id ? ['name' => $this->wasser_nasengebrauch_option->name, 'id' => $this->wasser_nasengebrauch_id, 'wert' => $this->wasser_nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_arbeitsruhe_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'wasser_arbeitsruhe_id');
    }

    public function getWasserArbeitsruheAttribute()
    {
        return $this->wasser_arbeitsruhe_id ? ['name' => $this->wasser_arbeitsruhe_option->name, 'id' => $this->wasser_arbeitsruhe_id, 'wert' => $this->wasser_arbeitsruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_fuehrigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_fuehrigkeit_id');
    }

    public function getWasserFuehrigkeitAttribute()
    {
        return $this->wasser_fuehrigkeit_id ? ['name' => $this->wasser_fuehrigkeit_option->name, 'id' => $this->wasser_fuehrigkeit_id, 'wert' => $this->wasser_fuehrigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_koerperliche_haerte_id');
    }

    public function getWasserKoerperlicheHaerteAttribute()
    {
        return $this->wasser_koerperliche_haerte_id ? ['name' => $this->wasser_koerperliche_haerte_option->name, 'id' => $this->wasser_koerperliche_haerte_id, 'wert' => $this->wasser_koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wasser_wasserfreude_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'wasser_wasserfreude_id');
    }

    public function getWasserWasserfreudeAttribute()
    {
        return $this->wasser_wasserfreude_id ? ['name' => $this->wasser_wasserfreude_option->name, 'id' => $this->wasser_wasserfreude_id, 'wert' => $this->wasser_wasserfreude_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_finderwille_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'markierung_finderwille_id');
    }

    public function getMarkierungFinderwilleAttribute()
    {
        return $this->markierung_finderwille_id ? ['name' => $this->markierung_finderwille_option->name, 'id' => $this->markierung_finderwille_id, 'wert' => $this->markierung_finderwille_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_nasengebrauch_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'markierung_nasengebrauch_id');
    }

    public function getMarkierungNasengebrauchAttribute()
    {
        return $this->markierung_nasengebrauch_id ? ['name' => $this->markierung_nasengebrauch_option->name, 'id' => $this->markierung_nasengebrauch_id, 'wert' => $this->markierung_nasengebrauch_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_arbeitsruhe_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'markierung_arbeitsruhe_id');
    }

    public function getMarkierungArbeitsruheAttribute()
    {
        return $this->markierung_arbeitsruhe_id ? ['name' => $this->markierung_arbeitsruhe_option->name, 'id' => $this->markierung_arbeitsruhe_id, 'wert' => $this->markierung_arbeitsruhe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_koerperliche_haerte_option()
    {
        return $this->belongsTo(OptionJAS1Punkte13::class, 'markierung_koerperliche_haerte_id');
    }

    public function getMarkierungKoerperlicheHaerteAttribute()
    {
        return $this->markierung_koerperliche_haerte_id ? ['name' => $this->markierung_koerperliche_haerte_option->name, 'id' => $this->markierung_koerperliche_haerte_id, 'wert' => $this->markierung_koerperliche_haerte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_konzentration_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'markierung_konzentration_id');
    }

    public function getMarkierungKonzentrationAttribute()
    {
        return $this->markierung_konzentration_id ? ['name' => $this->markierung_konzentration_option->name, 'id' => $this->markierung_konzentration_id, 'wert' => $this->markierung_konzentration_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function markierung_einschaetzung_entfernung_option()
    {
        return $this->belongsTo(OptionJAS1Punkte12::class, 'markierung_einschaetzung_entfernung_id');
    }

    public function getMarkierungEinschaetzungEntfernungAttribute()
    {
        return $this->markierung_einschaetzung_entfernung_id ? ['name' => $this->markierung_einschaetzung_entfernung_option->name, 'id' => $this->markierung_einschaetzung_entfernung_id, 'wert' => $this->markierung_einschaetzung_entfernung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function schussfestigkeit_option()
    {
        return $this->belongsTo(OptionJAS1Schussfestigkeit::class, 'schussfestigkeit_id');
    }

    public function getSchussfestigkeitAttribute()
    {
        return $this->schussfestigkeit_id ? ['name' => $this->schussfestigkeit_option->name, 'id' => $this->schussfestigkeit_id, 'wert' => $this->schussfestigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function temperament_option()
    {
        return $this->belongsTo(OptionJAS1Temperament::class, 'temperament_id');
    }

    public function getTemperamentAttribute()
    {
        return $this->temperament_id ? ['name' => $this->temperament_option->name, 'id' => $this->temperament_id, 'wert' => $this->temperament_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function selbstsicherheit_option()
    {
        return $this->belongsTo(OptionJAS1Selbstsicherheit::class, 'selbstsicherheit_id');
    }

    public function getSelbstsicherheitAttribute()
    {
        return $this->selbstsicherheit_id ? ['name' => $this->selbstsicherheit_option->name, 'id' => $this->selbstsicherheit_id, 'wert' => $this->selbstsicherheit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vertraeglichkeit_option()
    {
        return $this->belongsTo(OptionJAS1Vertraeglichkeit::class, 'vertraeglichkeit_id');
    }

    public function getVertraeglichkeitAttribute()
    {
        return $this->vertraeglichkeit_id ? ['name' => $this->vertraeglichkeit_option->name, 'id' => $this->vertraeglichkeit_id, 'wert' => $this->vertraeglichkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function sonstige_wesenverhalten_option()
    {
        return $this->belongsTo(OptionJAS1SonstigesVerhalten::class, 'sonstige_wesenverhalten_id');
    }

    public function getSonstigeWesenverhaltenAttribute()
    {
        return $this->sonstige_wesenverhalten_id ? ['name' => $this->sonstige_wesenverhalten_option->name, 'id' => $this->sonstige_wesenverhalten_id, 'wert' => $this->sonstige_wesenverhalten_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
