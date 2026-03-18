<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionEDScoringFCI extends Model
{
    use HasFactory;

    protected $table = 'optionen_ed_scoring_fci';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
