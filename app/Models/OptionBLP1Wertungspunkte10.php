<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBLP1Wertungspunkte10 extends Model
{
    use HasFactory;

    protected $table = 'optionen_blp1_wertungspunkte10';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
