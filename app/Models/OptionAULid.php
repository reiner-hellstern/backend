<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAULid extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_lid';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
