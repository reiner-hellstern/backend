<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionLHTyp extends Model
{
    use HasFactory;

    protected $table = 'optionen_lh_typen';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
