<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veranstaltung extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungen';
    // protected $with = ['termine', 'sonderleiter1', 'sonderleiter2', 'pruefungsleiter', 'meldungen', 'plberichtable', 'slberichtable', 'teams', 'richter', 'aufgaben'];

    protected $appends = ['erstertermin', 'letztertermin', 'kategorie', 'typ'];
    // ,'veranstalter_landesgruppe','veranstalter_bezirksgruppe','ausrichter_landesgruppe',
    //  'ausrichter_bezirksgruppe','zahlung_optionen','meldung_notwendig','meldung_adresse_opt', 'select_unterlagen_jagdlich', 'select_unterlagen_nichtjagdlich'];

    protected $hidden = [
        'veranstaltungskategorie_id', 'veranstaltungstyp_id', 'veranstalter_landesgruppe_id', 'veranstalter_bezirksgruppe_id',
        'ausrichter_landesgruppe_id', 'ausrichter_bezirksgruppe_id', 'zahlung_optionen_id', 'meldung_notwendig_id', 'meldung_adresse_opt_id',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->with(['termine', 'sonderleiter1', 'sonderleiter2', 'pruefungsleiter', 'meldungen', 'plberichtable', 'slberichtable', 'teams', 'richter', 'aufgaben'])->where('id', $value)->firstOrFail();
    }

    //  public function hundefuehrer()
    //  {
    //      return $this->belongsTo(Mitglied::class, 'mitglied_id' );
    //  }

    //  public function teilnehmer()
    //  {
    //      return $this->hasOne(User::class);
    //  }
    // protected function meldung_meldegeld_zahlungsfrist(): Attribute
    // {
    //     return new Attribute(
    //       get: fn ($value) =>  ($value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
    //       set: fn ($value) =>  ($value !== '' && !is_null($value)) ? Carbon::parse($value)->format('Y-m-d'): '0000-00-00',
    //     );
    // }

    public function getMeldungMeldegeldZahlungsfristAttribute($value)
    {
        return ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y') : '';
    }

    public function setMeldungMeldegeldZahlungsfristAttribute($value)
    {
        $this->attributes['meldung_meldegeld_zahlungsfrist'] = (new Carbon($value))->format('Y-m-d');
    }

    public function termine()
    {
        return $this->hasMany(Termin::class);
    }

    public function teams()
    {
        return $this->hasMany(VeranstaltungTeam::class)->orderBy('startpos');
    }

    public function erstertermin()
    {
        return $this->termine->min();
    }

    public function getErsterterminAttribute()
    {
        return $this->termine->min();
    }

    public function letztertermin()
    {
        return $this->termine->max();
    }

    public function getLetzterterminAttribute()
    {
        return $this->termine->max();
    }

    public function plberichtable()
    {
        return $this->morphTo();
    }

    public function slberichtable()
    {
        return $this->morphTo();
    }

    public function meldungen()
    {
        return $this->hasMany(VeranstaltungMeldung::class)->with(['anmelder', 'hund', 'hundefuehrer', 'resultable'])->orderBy('startpos');
    }

    public function aufgaben()
    {
        return $this->belongsTo(Veranstaltungsaufgaben::class, 'aufgaben_id');
    }

    public function sonderleiter1()
    {
        return $this->belongsTo(Person::class);
    }

    public function sonderleiter2()
    {
        return $this->belongsTo(Person::class);
    }

    public function pruefungsleiter()
    {
        return $this->belongsTo(Person::class);
    }

    public function richter()
    {
        return $this->belongsToMany(Richter::class);
    }

    public function ausrichter_landesgruppe()
    {
        return $this->belongsTo(Landesgruppe::class, 'ausrichter_landesgruppe_id');
    }

    public function ausrichter_bezirksgruppe()
    {
        return $this->belongsTo(Bezirksgruppe::class, 'ausrichter_bezirksgruppe_id');
    }

    public function veranstalter_landesgruppe()
    {
        return $this->belongsTo(Landesgruppe::class, 'veranstalter_landesgruppe_id');
    }

    public function veranstalter_bezirksgruppe()
    {
        return $this->belongsTo(Bezirksgruppe::class, 'veranstalter_bezirksgruppe_id');
    }

    public function veranstaltungskategorie()
    {
        return $this->belongsTo(Veranstaltungskategorie::class);
    }

    public function getKategorieAttribute()
    {
        return $this->veranstaltungskategorie->name;
    }

    public function veranstaltungstyp()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }

    public function getTypAttribute()
    {
        return $this->veranstaltungstyp->name;
    }

    public function unterlagen_jagdlich()
    {
        return $this->belongsToMany(OptionVaMeldeunterlagenJagdlich::class);
    }

    public function unterlagen_nichtjagdlich()
    {
        return $this->belongsToMany(OptionVaMeldeunterlagenNichtJagdlich::class);
    }

    public function meldung_adresse_option()
    {
        return $this->belongsTo(OptionVaMeldeoption::class, 'meldung_adresse_opt_id');
    }

    public function meldung_notwendig_option()
    {
        return $this->belongsTo(OptionVaAnmeldeoption::class, 'meldung_notwendig_id');
    }

    public function zahlung_option()
    {
        return $this->belongsTo(OptionVaZahlungsoption::class, 'zahlung_optionen_id');
    }

    public function getOptionVeranstaltungskategorie()
    {
        return $this->veranstaltungskategorie_id ? ['name' => $this->veranstaltungskategorie->name, 'id' => $this->veranstaltungskategorie_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionVeranstaltungstyp()
    {
        return $this->veranstaltungstyp_id ? ['name' => $this->veranstaltungstyp->name, 'id' => $this->veranstaltungstyp_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionVeranstalterLandesgruppe()
    {
        return $this->veranstalter_landesgruppe_id ? ['name' => $this->veranstalter_landesgruppe->name, 'id' => $this->veranstalter_landesgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionVeranstalterBezirksgruppe()
    {
        return $this->veranstalter_bezirksgruppe_id ? ['name' => $this->veranstalter_bezirksgruppe->name, 'id' => $this->veranstalter_bezirksgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionAusrichterLandesgruppe()
    {
        return $this->ausrichter_landesgruppe_id ? ['name' => $this->ausrichter_landesgruppe->name, 'id' => $this->ausrichter_landesgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionAusrichterBezirksgruppe()
    {
        return $this->ausrichter_bezirksgruppe_id ? ['name' => $this->ausrichter_bezirksgruppe->name, 'id' => $this->ausrichter_bezirksgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionZahlung()
    {
        return $this->zahlung_optionen_id ? ['name' => $this->zahlung_option->name, 'id' => $this->zahlung_optionen_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionMeldungNotwendig()
    {
        return $this->meldung_notwendig_id ? ['name' => $this->meldung_notwendig_option->name, 'id' => $this->meldung_notwendig_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getOptionMeldungAdresseOpt()
    {
        return $this->meldung_adresse_opt_id ? ['name' => $this->meldung_adresse_option->name, 'id' => $this->meldung_adresse_opt_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function getSelectUnterlagenJagdlich()
    {
        $ids = $this->unterlagen_jagdlich->toArray();
        if ($ids) {
            return array_map(function ($val) {
                return ['name' => $val['name'], 'id' => $val['id']];
            }, $ids);
        } else {
            return [['name' => 'Bitte auswählen', 'id' => 0]];
        }
    }

    public function getSelectUnterlagenNichtJagdlich()
    {
        $ids = $this->unterlagen_nichtjagdlich->toArray();
        if ($ids) {
            return array_map(function ($val) {
                return ['name' => $val['name'], 'id' => $val['id']];
            }, $ids);
        } else {
            return [['name' => 'Bitte auswählen', 'id' => 0]];
        }
    }

    public function getMeldungUnterlagenJagdlich()
    {
        $ids = $this->attributes['meldung_unterlagen_jagdlich'];
        if ($ids) {
            $a_ids = explode(',', $ids);

            return array_map(function ($val) {
                $label = OptionVaMeldeunterlagenJagdlich::find($val)->name;

                return ['name' => $label, 'id' => $val];
            }, $a_ids);
        } else {
            return [['name' => 'Bitte auswählen', 'id' => 0]];
        }
    }

    public function getMeldungUnterlagenNichtJagdlich()
    {
        $ids = $this->attributes['meldung_unterlagen_nichtjagdlich'];
        if ($ids) {
            $a_ids = explode(',', $ids);

            return array_map(function ($val) {
                $label = OptionVaMeldeunterlagenNichtJagdlich::find($val)->name;

                return ['name' => $label, 'id' => $val];
            }, $a_ids);
        } else {
            return [['name' => 'Bitte auswählen', 'id' => 0]];
        }
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
