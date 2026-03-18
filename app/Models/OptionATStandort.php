<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionATStandort extends Model
{
    use HasFactory;

    protected $table = 'optionen_at_standorte';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
