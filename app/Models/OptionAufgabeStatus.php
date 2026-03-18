<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAufgabeStatus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'optionen_aufgabe_stati';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'name_kurz',
        'val',
        'typ',
        'aktiv',
        'wert',
        'order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'aktiv' => 'boolean',
        'wert' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active status options.
     */
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope to order by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
