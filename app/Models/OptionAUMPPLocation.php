<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUMPPLocation extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_mpp_loc';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
