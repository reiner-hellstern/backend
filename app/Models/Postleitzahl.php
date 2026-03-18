<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postleitzahl extends Model
{
    use HasFactory;

    protected $table = 'postleitzahlen';

    protected $casts = [
        'geojson' => 'array',
    ];

    public function bezirksgruppe()
    {
        return $this->belongsTo(Bezirksgruppe::class);
    }
}
