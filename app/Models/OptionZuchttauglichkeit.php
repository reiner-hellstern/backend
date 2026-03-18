<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZuchttauglichkeit extends Model
{
    use HasFactory;

    protected $table = 'optionen_zuchttauglichkeit';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
