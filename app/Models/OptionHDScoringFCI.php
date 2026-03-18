<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDScoringFCI extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_scoring_fci';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
