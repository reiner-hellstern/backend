<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDED extends Model
{
    use HasFactory;

    protected $table = 'hdeds';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
