<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAUKataraktForm extends Model
{
    use HasFactory;

    protected $table = 'optionen_au_katerakt_form';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
