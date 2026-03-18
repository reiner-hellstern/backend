<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionZuchtverbotGrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_zuchtverbot_gruende';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
