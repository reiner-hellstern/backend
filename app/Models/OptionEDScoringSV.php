<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionEDScoringSV extends Model
{
    use HasFactory;

    protected $table = 'optionen_ed_scoring_sv';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
