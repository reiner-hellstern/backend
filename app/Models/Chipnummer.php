<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chipnummer extends Model
{
    use HasFactory;

    protected $table = 'chipnummern';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
