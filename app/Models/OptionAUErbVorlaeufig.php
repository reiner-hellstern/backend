<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUErbVorlaeufig extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_erb_vorlaeufig';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
