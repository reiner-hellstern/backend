<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionATTyp extends Model
{
    use HasFactory;

    protected $table = 'optionen_at_typen';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
