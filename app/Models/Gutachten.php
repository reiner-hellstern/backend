<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gutachten extends Model
{
    use HasFactory;

    protected $table = 'gutachten';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
