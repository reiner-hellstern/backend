<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionOCDScoring extends Model
{
    use HasFactory;

    protected $table = 'optionen_ocd_scoring';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
