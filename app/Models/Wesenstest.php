<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wesenstest extends Model
{
    use HasFactory;

    protected $table = 'wesensteste';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
