<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPruefung extends Model
{
    use HasFactory;

    protected $table = 'temp_pruefungen';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
