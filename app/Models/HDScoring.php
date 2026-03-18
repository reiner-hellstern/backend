<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDScoring extends Model
{
    use HasFactory;

    protected $table = 'hd_scorings';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
