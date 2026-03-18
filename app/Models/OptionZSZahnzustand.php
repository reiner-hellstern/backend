<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZSZahnzustand extends Model
{
    use HasFactory;

    protected $table = 'optionen_zs_zahnzustand';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
