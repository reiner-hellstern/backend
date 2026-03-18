<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAURDForm extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_rd_form';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
