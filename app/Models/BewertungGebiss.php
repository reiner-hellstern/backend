<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BewertungGebiss extends Model
{
    use HasFactory;

    protected $table = 'bewertungen_gebiss';

    protected $fillable = [
        'name',
        'typ',
        'aktiv',
        'wert',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'wert' => 'integer',
        'order' => 'integer',
    ];
}
