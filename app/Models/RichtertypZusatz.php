<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RichtertypZusatz extends Model
{
    use HasFactory;

    protected $table = 'richtertypenzusaetze';

    protected $fillable = [
        'name',
        'name_kurz',
        'typ',
        'state',
        'order',
    ];

    // Scope für aktive Richtertypen
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
}
