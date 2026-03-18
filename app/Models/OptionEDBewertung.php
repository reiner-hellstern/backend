<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionEDBewertung extends Model
{
    use HasFactory;

    protected $table = 'optionen_ed_bewertung';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
