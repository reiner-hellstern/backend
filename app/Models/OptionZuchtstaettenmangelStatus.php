<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZuchtstaettenmangelStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_zuchtstaettenmangel_stati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
