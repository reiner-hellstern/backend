<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionOCDUntersuchungsgrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_ocd_untersuchungsgrund';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
