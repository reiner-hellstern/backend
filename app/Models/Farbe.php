<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farbe extends Model
{
    use HasFactory;

    protected $table = 'farben';

    public function rassen()
    {
        return $this->belongsToMany(Rasse::class);
    }
}
