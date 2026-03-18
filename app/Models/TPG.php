<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPG extends Model
{
    use HasFactory;

    protected $table = 'temp_titelpruefungen_gesund';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
