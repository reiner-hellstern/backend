<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUErbZweifel extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_erb_zweifel';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
