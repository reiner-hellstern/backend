<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formwert_v1 extends Model
{
    use HasFactory;

    protected $table = 'formwerte_v1';

    protected $appends = ['zahnstatus_gebiss', 'kopf', 'oberkopf', 'fang', 'stop', 'pigment', 'augen_form', 'augen_farbe', 'ausdruck', 'oberlefzen', 'unterlefzen', 'behaenge', 'hals', 'brust', 'brust_tiefe', 'vorbrust', 'lenden', 'ruecken', 'kruppe', 'rute', 'knochenstaerke', 'vorderhand_laeufe', 'vorderhand_schulter', 'vorderhand_oberarm', 'vorderhand_ellenbogen', 'hinterhand_laeufe', 'hinterhand_winkelung', 'pfoten', 'geschlaechterpraege', 'hoden', 'kondition', 'gesamterscheinung'];

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

    public function zahnstatus_gebiss_option()
    {
        return $this->belongsTo(OptionFormwert1Gebiss::class, 'zahnstatus_gebiss_id');
    }

    public function getZahnstatusGebissAttribute()
    {
        return $this->zahnstatus_gebiss_id ? ['name' => $this->zahnstatus_gebiss_option->name, 'id' => $this->zahnstatus_gebiss_id, 'wert' => $this->zahnstatus_gebiss_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function kopf_option()
    {
        return $this->belongsTo(OptionFormwert1Kopf::class, 'kopf_id');
    }

    public function getKopfAttribute()
    {
        return $this->kopf_id ? ['name' => $this->kopf_option->name, 'id' => $this->kopf_id, 'wert' => $this->kopf_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function oberkopf_option()
    {
        return $this->belongsTo(OptionFormwert1Oberkopf::class, 'oberkopf_id');
    }

    public function getOberkopfAttribute()
    {
        return $this->oberkopf_id ? ['name' => $this->oberkopf_option->name, 'id' => $this->oberkopf_id, 'wert' => $this->oberkopf_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function fang_option()
    {
        return $this->belongsTo(OptionFormwert1Fang::class, 'fang_id');
    }

    public function getFangAttribute()
    {
        return $this->fang_id ? ['name' => $this->fang_option->name, 'id' => $this->fang_id, 'wert' => $this->fang_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function stop_option()
    {
        return $this->belongsTo(OptionFormwert1Stop::class, 'stop_id');
    }

    public function getStopAttribute()
    {
        return $this->stop_id ? ['name' => $this->stop_option->name, 'id' => $this->stop_id, 'wert' => $this->stop_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function pigment_option()
    {
        return $this->belongsTo(OptionFormwert1Pigmentierung::class, 'pigment_id');
    }

    public function getPigmentAttribute()
    {
        return $this->pigment_id ? ['name' => $this->pigment_option->name, 'id' => $this->pigment_id, 'wert' => $this->pigment_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function augen_form_option()
    {
        return $this->belongsTo(OptionFormwert1Augenform::class, 'augen_form_id');
    }

    public function getAugenFormAttribute()
    {
        return $this->augen_form_id ? ['name' => $this->augen_form_option->name, 'id' => $this->augen_form_id, 'wert' => $this->augen_form_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function augen_farbe_option()
    {
        return $this->belongsTo(OptionFormwert1Augenfarbe::class, 'augen_farbe_id');
    }

    public function getAugenFarbeAttribute()
    {
        return $this->augen_farbe_id ? ['name' => $this->augen_farbe_option->name, 'id' => $this->augen_farbe_id, 'wert' => $this->augen_farbe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function ausdruck_option()
    {
        return $this->belongsTo(OptionFormwert1Ausdruck::class, 'ausdruck_id');
    }

    public function getAusdruckAttribute()
    {
        return $this->ausdruck_id ? ['name' => $this->ausdruck_option->name, 'id' => $this->ausdruck_id, 'wert' => $this->ausdruck_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function oberlefzen_option()
    {
        return $this->belongsTo(OptionFormwert1Oberlefzen::class, 'oberlefzen_id');
    }

    public function getOberlefzenAttribute()
    {
        return $this->oberlefzen_id ? ['name' => $this->oberlefzen_option->name, 'id' => $this->oberlefzen_id, 'wert' => $this->oberlefzen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function unterlefzen_option()
    {
        return $this->belongsTo(OptionFormwert1Unterlefzen::class, 'unterlefzen_id');
    }

    public function getUnterlefzenAttribute()
    {
        return $this->unterlefzen_id ? ['name' => $this->unterlefzen_option->name, 'id' => $this->unterlefzen_id, 'wert' => $this->unterlefzen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function behaenge_option()
    {
        return $this->belongsTo(OptionFormwert1Behaenge::class, 'behaenge_id');
    }

    public function getBehaengeAttribute()
    {
        return $this->behaenge_id ? ['name' => $this->behaenge_option->name, 'id' => $this->behaenge_id, 'wert' => $this->behaenge_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hals_option()
    {
        return $this->belongsTo(OptionFormwert1Hals::class, 'hals_id');
    }

    public function getHalsAttribute()
    {
        return $this->hals_id ? ['name' => $this->hals_option->name, 'id' => $this->hals_id, 'wert' => $this->hals_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function brust_option()
    {
        return $this->belongsTo(OptionFormwert1Brust::class, 'brust_id');
    }

    public function getBrustAttribute()
    {
        return $this->brust_id ? ['name' => $this->brust_option->name, 'id' => $this->brust_id, 'wert' => $this->brust_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function brust_tiefe_option()
    {
        return $this->belongsTo(OptionFormwert1Brusttiefe::class, 'brust_tiefe_id');
    }

    public function getBrustTiefeAttribute()
    {
        return $this->brust_tiefe_id ? ['name' => $this->brust_tiefe_option->name, 'id' => $this->brust_tiefe_id, 'wert' => $this->brust_tiefe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vorbrust_option()
    {
        return $this->belongsTo(OptionFormwert1Vorbrust::class, 'vorbrust_id');
    }

    public function getVorbrustAttribute()
    {
        return $this->vorbrust_id ? ['name' => $this->vorbrust_option->name, 'id' => $this->vorbrust_id, 'wert' => $this->vorbrust_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function lenden_option()
    {
        return $this->belongsTo(OptionFormwert1Lenden::class, 'lenden_id');
    }

    public function getLendenAttribute()
    {
        return $this->lenden_id ? ['name' => $this->lenden_option->name, 'id' => $this->lenden_id, 'wert' => $this->lenden_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function ruecken_option()
    {
        return $this->belongsTo(OptionFormwert1Ruecken::class, 'ruecken_id');
    }

    public function getRueckenAttribute()
    {
        return $this->ruecken_id ? ['name' => $this->ruecken_option->name, 'id' => $this->ruecken_id, 'wert' => $this->ruecken_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function kruppe_option()
    {
        return $this->belongsTo(OptionFormwert1Kruppe::class, 'kruppe_id');
    }

    public function getKruppeAttribute()
    {
        return $this->kruppe_id ? ['name' => $this->kruppe_option->name, 'id' => $this->kruppe_id, 'wert' => $this->kruppe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function rute_option()
    {
        return $this->belongsTo(OptionFormwert1Rute::class, 'rute_id');
    }

    public function getRuteAttribute()
    {
        return $this->rute_id ? ['name' => $this->rute_option->name, 'id' => $this->rute_id, 'wert' => $this->rute_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function knochenstaerke_option()
    {
        return $this->belongsTo(OptionFormwert1Knochenstaerke::class, 'knochenstaerke_id');
    }

    public function getKnochenstaerkeAttribute()
    {
        return $this->knochenstaerke_id ? ['name' => $this->knochenstaerke_option->name, 'id' => $this->knochenstaerke_id, 'wert' => $this->knochenstaerke_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vorderhand_laeufe_option()
    {
        return $this->belongsTo(OptionFormwert1Vorderlaeufe::class, 'vorderhand_laeufe_id');
    }

    public function getVorderhandLaeufeAttribute()
    {
        return $this->vorderhand_laeufe_id ? ['name' => $this->vorderhand_laeufe_option->name, 'id' => $this->vorderhand_laeufe_id, 'wert' => $this->vorderhand_laeufe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vorderhand_schulter_option()
    {
        return $this->belongsTo(OptionFormwert1Schultern::class, 'vorderhand_schulter_id');
    }

    public function getVorderhandSchulterAttribute()
    {
        return $this->vorderhand_schulter_id ? ['name' => $this->vorderhand_schulter_option->name, 'id' => $this->vorderhand_schulter_id, 'wert' => $this->vorderhand_schulter_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vorderhand_oberarm_option()
    {
        return $this->belongsTo(OptionFormwert1Oberarme::class, 'vorderhand_oberarm_id');
    }

    public function getVorderhandOberarmAttribute()
    {
        return $this->vorderhand_oberarm_id ? ['name' => $this->vorderhand_oberarm_option->name, 'id' => $this->vorderhand_oberarm_id, 'wert' => $this->vorderhand_oberarm_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function vorderhand_ellenbogen_option()
    {
        return $this->belongsTo(OptionFormwert1Ellenbogen::class, 'vorderhand_ellenbogen_id');
    }

    public function getVorderhandEllenbogenAttribute()
    {
        return $this->vorderhand_ellenbogen_id ? ['name' => $this->vorderhand_ellenbogen_option->name, 'id' => $this->vorderhand_ellenbogen_id, 'wert' => $this->vorderhand_ellenbogen_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hinterhand_laeufe_option()
    {
        return $this->belongsTo(OptionFormwert1Hinterlaeufe::class, 'hinterhand_laeufe_id');
    }

    public function getHinterhandLaeufeAttribute()
    {
        return $this->hinterhand_laeufe_id ? ['name' => $this->hinterhand_laeufe_option->name, 'id' => $this->hinterhand_laeufe_id, 'wert' => $this->hinterhand_laeufe_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hinterhand_winkelung_option()
    {
        return $this->belongsTo(OptionFormwert1Winkelung::class, 'hinterhand_winkelung_id');
    }

    public function getHinterhandWinkelungAttribute()
    {
        return $this->hinterhand_winkelung_id ? ['name' => $this->hinterhand_winkelung_option->name, 'id' => $this->hinterhand_winkelung_id, 'wert' => $this->hinterhand_winkelung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function pfoten_option()
    {
        return $this->belongsTo(OptionFormwert1Pfoten::class, 'pfoten_id');
    }

    public function getPfotenAttribute()
    {
        return $this->pfoten_id ? ['name' => $this->pfoten_option->name, 'id' => $this->pfoten_id, 'wert' => $this->pfoten_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function geschlaechterpraege_option()
    {
        return $this->belongsTo(OptionFormwert1Geschlechterpraege::class, 'geschlaechterpraege_id');
    }

    public function getGeschlaechterpraegeAttribute()
    {
        return $this->geschlaechterpraege_id ? ['name' => $this->geschlaechterpraege_option->name, 'id' => $this->geschlaechterpraege_id, 'wert' => $this->geschlaechterpraege_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hoden_option()
    {
        return $this->belongsTo(OptionFormwert1Hoden::class, 'hoden_id');
    }

    public function getHodenAttribute()
    {
        return $this->hoden_id ? ['name' => $this->hoden_option->name, 'id' => $this->hoden_id, 'wert' => $this->hoden_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function kondition_option()
    {
        return $this->belongsTo(OptionFormwert1Kondition::class, 'kondition_id');
    }

    public function getKonditionAttribute()
    {
        return $this->kondition_id ? ['name' => $this->kondition_option->name, 'id' => $this->kondition_id, 'wert' => $this->kondition_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function gesamterscheinung_option()
    {
        return $this->belongsTo(OptionFormwert1Gesamterscheinung::class, 'gesamterscheinung_id');
    }

    public function getGesamterscheinungAttribute()
    {
        return $this->gesamterscheinung_id ? ['name' => $this->gesamterscheinung_option->name, 'id' => $this->gesamterscheinung_id, 'wert' => $this->gesamterscheinung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
