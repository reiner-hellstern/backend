<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionBugtrack extends Model
{
    use HasFactory;

    protected $table = 'optionen_bugtracks';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
