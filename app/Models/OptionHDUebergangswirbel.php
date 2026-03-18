<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDUebergangswirbel extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_uebergangswirbel';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
