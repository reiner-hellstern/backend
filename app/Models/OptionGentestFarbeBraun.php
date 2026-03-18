<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionGentestFarbeBraun extends Model
{
    use HasFactory;

    protected $table = 'optionen_gentest_farbe_braun';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
