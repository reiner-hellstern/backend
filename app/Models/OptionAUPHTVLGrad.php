<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUPHTVLGrad extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_phtvl_grad';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
