<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAnrede extends Model
{
    use HasFactory;

    protected $table = 'optionen_anreden';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
