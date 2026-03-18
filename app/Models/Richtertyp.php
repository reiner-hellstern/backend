<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Richtertyp extends Model
{
    use HasFactory;

    protected $table = 'richtertypen';

    protected $fillable = [
        'name',
        'name_kurz',
        'typ',
        'state',
        'order',
    ];

    public function richter()
    {
        return $this->belongsToMany(Richter::class, 'richter_veranstaltungstyp', 'veranstaltungstyp_id', 'richter_id');
    }

    public function veranstaltungstypen()
    {
        return $this->belongsToMany(Veranstaltungstyp::class, 'richtertyp_veranstaltungstyp');
    }

    // Scope für aktive Richtertypen
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
}
