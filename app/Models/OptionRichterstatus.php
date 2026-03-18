<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionRichterstatus extends Model
{
    use HasFactory;

    protected $table = 'optionen_richterstatus';

    protected $fillable = [
        'name',
        'name_kurz',
        'aktiv',
        'order',
    ];

    public function richter()
    {
        return $this->hasMany(Richter::class, 'state');
    }

    // Scope für aktive Status
    public function scopeActive($query)
    {
        return $query->where('aktiv', 1);
    }
}
