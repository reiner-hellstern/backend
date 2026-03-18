<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veranstaltungen extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungen';

    protected $with = ['unterlagen_jagdlich', 'unterlagen_nichtjagdlich'];

    //  protected $appends = ['veranstaltungskategorie','veranstaltungstyp','veranstalter_landesgruppe','veranstalter_bezirksgruppe','ausrichter_landesgruppe',
    //  'ausrichter_bezirksgruppe','zahlung_optionen','meldung_notwendig','meldung_adresse_opt', 'select_unterlagen_jagdlich', 'select_unterlagen_nichtjagdlich'];

    protected $hidden = ['veranstaltungskategorie_id', 'veranstaltungstyp_id', 'veranstalter_landesgruppe_id', 'veranstalter_bezirksgruppe_id',
        'ausrichter_landesgruppe_id', 'ausrichter_bezirksgruppe_id', 'zahlung_optionen_id', 'meldung_notwendig_id', 'meldung_adresse_opt_id'];

    public function termine()
    {
        return $this->hasMany(Termin::class, 'veranstaltung_id');
    }

    public function erstertermin()
    {
        return $this->termine->min();
    }

    public function letztertermin()
    {
        return $this->termine->max();
    }

    public function meldungen()
    {
        return $this->hasMany(VeranstaltungMeldung::class);
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
        return $this->belongsToMany(Richter::class, 'richter_veranstaltung', 'veranstaltung_id', 'richter_id');
    }

    public function meldeadresse()
    {
        return $this->belongsTo(Person::class);
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

    public function veranstaltungstyp()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }

    public function unterlagen_jagdlich()
    {
        return $this->belongsToMany(OptionVaMeldeunterlagenJagdlich::class, 'veranstaltung_jagdmeldeunterlagen', 'veranstaltung_id', 'optionen_va_meldeunterlagen_jagdlich_id');
    }

    public function unterlagen_nichtjagdlich()
    {
        return $this->belongsToMany(OptionVaMeldeunterlagenNichtJagdlich::class, 'veranstaltung_nichtjagdmeldeunterlagen', 'veranstaltung_id', 'optionen_va_meldeunterlagen_nicht_jagdlich_id');
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
}
