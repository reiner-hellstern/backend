<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVereinsstrafeStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_vereinsstrafe_stati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
