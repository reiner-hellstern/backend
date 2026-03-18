<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDBewertung extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_bewertung';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
