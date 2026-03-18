<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formwert extends Model
{
    use HasFactory;

    protected $table = 'temp_formwerte';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
