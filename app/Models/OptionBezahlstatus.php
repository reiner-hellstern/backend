<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBezahlstatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_bezahlstati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
