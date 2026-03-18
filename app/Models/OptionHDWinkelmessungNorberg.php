<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionHDWinkelmessungNorberg extends Model
{
    use HasFactory;

    protected $table = 'optionen_hd_winkelmessung_norberg';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
