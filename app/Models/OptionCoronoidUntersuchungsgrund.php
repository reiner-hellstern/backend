<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionCoronoidUntersuchungsgrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_coronoid_untersuchungsgrund';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
