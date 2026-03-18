<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAPDR1Ausschlussgrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_apdr1_ausschlussgrund';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
