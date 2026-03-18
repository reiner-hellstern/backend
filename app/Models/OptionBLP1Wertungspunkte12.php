<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBLP1Wertungspunkte12 extends Model
{
    use HasFactory;

    protected $table = 'optionen_blp1_wertungspunkte12';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
