<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZwingerStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_zwinger_stati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
