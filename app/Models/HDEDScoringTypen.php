<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDEDScoringTypen extends Model
{
    use HasFactory;

    protected $table = 'hded_scoring_typen';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
