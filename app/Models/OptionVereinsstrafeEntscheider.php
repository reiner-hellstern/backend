<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVereinsstrafeEntscheider extends Model
{
    use HasFactory;

    protected $table = 'optionen_vereinsstrafe_entscheider';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
