<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAusbilderausweisStatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_ausbilderausweis_stati';

    protected $fillable = [
        'name',
        'name_kurz',
        'val',
        'typ',
        'aktiv',
        'wert',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
