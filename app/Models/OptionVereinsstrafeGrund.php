<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVereinsstrafeGrund extends Model
{
    use HasFactory;

    protected $table = 'optionen_vereinsstrafe_gruende';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
