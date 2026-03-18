<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HundStatus extends Model
{
    use HasFactory;

    protected $table = 'hund_stati';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
