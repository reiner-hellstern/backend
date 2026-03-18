<?php

namespace App\Models;

use App\Traits\CheckActiveOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Welpe extends Model
{
    use CheckActiveOwnership;
    use HasFactory;

    protected $table = 'hunde';

    protected $with = ['goniountersuchung', 'augenuntersuchungen', 'hdeduntersuchungen', 'geschlecht', 'farbe', 'rasse'];

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

    public function farbe()
    {
        return $this->belongsTo(Farbe::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function eigentuemer()
    {
        return $this->getAllOwnersWithDetails($this->id, auth()->user()->person_id);
    }
}
