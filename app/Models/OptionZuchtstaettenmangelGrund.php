<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZuchtstaettenmangelGrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_zuchtstaettenmangel_gruende';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
