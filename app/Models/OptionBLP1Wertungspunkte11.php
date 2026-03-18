<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBLP1Wertungspunkte11 extends Model
{
    use HasFactory;

    protected $table = 'optionen_blp1_wertungspunkte11';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
