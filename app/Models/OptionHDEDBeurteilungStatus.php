<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDEDBeurteilungStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_hded_beurteilung_status';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
