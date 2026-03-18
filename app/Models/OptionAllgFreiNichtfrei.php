<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAllgFreiNichtfrei extends Model
{
    use HasFactory;

    protected $table = 'optionen_allg_frei_nichtfrei';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
