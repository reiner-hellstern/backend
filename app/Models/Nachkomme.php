<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nachkomme extends Model
{
    use HasFactory;

    protected $table = 'hunde';

    protected $with = ['goniountersuchung', 'augenuntersuchungen', 'hdeduntersuchungen', 'geschlecht', 'farbe', 'rasse', 'prerendered'];

    public function prerendered()
    {
        return $this->hasMany(HundPrerendered::class, 'hund_id')->withDefault([
            'id' => 0,
        ]);
    }

    public function goniountersuchung()
    {
        return $this->hasMany(Augenuntersuchung::class, 'hund_id')->where('aktive_gonio', '=', '1');
    }

    public function hdeduntersuchungen()
    {
        return $this->hasMany(HDEDUntersuchung::class, 'hund_id')->where('aktiv', '1');
    }

    public function gelenkuntersuchungen()
    {
        return $this->hasMany(Gelenkuntersuchung::class, 'hund_id')->where('aktiv', '1');
    }

    public function augenuntersuchungen()
    {
        return $this->hasMany(Augenuntersuchung::class, 'hund_id')->where('aktive_au', '=', '1');
    }

    public function geschlecht()
    {
        return $this->belongsTo(OptionGeschlechtHund::class, 'geschlecht_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function rasse()
    {
        return $this->belongsTo(Rasse::class, 'rasse_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
            'name_kurz' => '',
            'buchstabe' => '',
        ]);
    }

    public function chipnummern()
    {
        return $this->hasMany(Chipnummer::class)->orderBy('order', 'asc');
    }

    public function zuchtbuchnummern()
    {
        return $this->hasMany(Zuchtbuchnummer::class)->orderBy('order', 'asc');
    }

    public function farbe()
    {
        return $this->belongsTo(Farbe::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function eigentuemers()
    {
        return $this->hasMany(Eigentuemer::class)->with(['person', 'dokumente'])->orderByRaw('-bis asc')->orderBy('seit', 'desc');
    }
}
