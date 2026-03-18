<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeranstaltungTeam extends Model
{
    use HasFactory;

    protected $table = 'veranstaltung_teams';

    // protected $with = ['mitglieder', 'resultable'];
    // protected $with = ['resultable'];

    public function resultable()
    {
        return $this->morphTo();
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class, 'veranstaltung_id');
    }

    public function mitglieder()
    {
        return $this->hasMany(VeranstaltungMeldung::class, 'team_id')->orderBy('startpos');
    }

    // public function hund()
    // {
    //    return $this->belongsTo(Hund::class);
    // }

    // public function hundefuehrer()
    // {
    //    return $this->belongsTo(Person::class, 'hundefuehrer_id');
    // }
}
