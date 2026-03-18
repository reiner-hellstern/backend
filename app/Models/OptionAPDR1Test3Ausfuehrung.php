<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAPDR1Test3Ausfuehrung extends Model
{
    use HasFactory;

    protected $table = 'optionen_apdr1_test3_ausfuehrung';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
