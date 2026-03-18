<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZstBesichtigungStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_zst_besichtigung_stati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
