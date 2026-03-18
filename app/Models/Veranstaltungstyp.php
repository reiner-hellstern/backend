<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veranstaltungstyp extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungstypen';

    public function optionen()
    {
        return $this->hasMany(VeranstaltungOption::class, 'veranstaltungstyp_id');
    }

    public function kategorie()
    {
        return $this->belongsTo(Veranstaltungskategorie::class, 'veranstaltungskategorie_id');
    }

    public function richter()
    {
        return $this->belongsToMany(Richter::class, 'richter_id');
    }
}
