<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDScoringDRC extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_scoring_drc';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
