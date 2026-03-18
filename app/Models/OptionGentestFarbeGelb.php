<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionGentestFarbeGelb extends Model
{
    use HasFactory;

    protected $table = 'optionen_gentest_farbe_gelb';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
