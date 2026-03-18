<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hundefuehrer extends Model
{
    use HasFactory;

    protected $table = 'personen';

    public function anmeldungen()
    {
        return $this->morphMany(VeranstaltungMeldung::class, 'hundefuehrerable');
    }

    public function meldungen()
    {

        return $this->belongsToMany(VeranstaltungMeldung::class, 'veranstaltung_meldungen', 'hundefuehrer_id');
    }
}
