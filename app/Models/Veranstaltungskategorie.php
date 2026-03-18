<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veranstaltungskategorie extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungskategorien';

    public function typen()
    {
        return $this->hasMany(Veranstaltungstyp::class, 'veranstaltungskategorie_id');
    }
}
