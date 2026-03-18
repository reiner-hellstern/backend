<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeranstaltungAnmeldung extends Model
{
    use HasFactory;

    protected $table = 'veranstaltung_meldungen';

    protected $with = ['anmelder', 'hundefuehrer', 'veranstaltung'];

    public function anmelder()
    {
        return $this->belongsTo(Person::class, 'anmelder_id');
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    public function hundefuehrer()
    {
        return $this->belongsTo(Person::class, 'hundefuehrer_id');
    }
}
