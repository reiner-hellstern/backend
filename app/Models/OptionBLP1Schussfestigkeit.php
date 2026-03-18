<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBLP1Schussfestigkeit extends Model
{
    use HasFactory;

    protected $table = 'optionen_blp1_schussfestigkeit';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
