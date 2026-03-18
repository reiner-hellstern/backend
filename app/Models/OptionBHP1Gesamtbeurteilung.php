<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBHP1Gesamtbeurteilung extends Model
{
    use HasFactory;

    protected $table = 'optionen_bhp1_gesamtbeurteilungen';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
