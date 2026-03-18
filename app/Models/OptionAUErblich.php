<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUErblich extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_erblich';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
