<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rasse extends Model
{
    use HasFactory;

    protected $table = 'rassen';

    public function farben()
    {
        return $this->belongsToMany(Farbe::class);
    }

    public function anerkannte_farben()
    {
        return $this->belongsToMany(Farbe::class, 'anerkannte_farbe_rasse', 'rasse_id', 'farbe_id');
    }

    public function zwinger()
    {
        return $this->belongsToMany(Zwinger::class);
    }

    public function wuerfe()
    {
        return $this->hasMany(Wurf::class);
    }
}
