<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZstBesichtigungGrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_zst_besichtigung_gruende';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
