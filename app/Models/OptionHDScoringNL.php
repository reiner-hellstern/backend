<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDScoringNL extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_scoring_nl';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
