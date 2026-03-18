<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDEDCTGrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_hded_ct_grund';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
