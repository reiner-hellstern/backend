<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUCEAForm extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_cea_form';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
