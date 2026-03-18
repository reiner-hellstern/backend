<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBezahlart extends Model
{
    use HasFactory;

    protected $table = 'optionen_bezahlarten';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
