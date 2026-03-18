<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDEDRoentgenbilderArt extends Model
{
    use HasFactory;

    protected $table = 'optionen_hded_roentgenbilder_art';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
