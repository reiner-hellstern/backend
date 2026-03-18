<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAdelstitel extends Model
{
    use HasFactory;

    protected $table = 'optionen_adelstitel';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
