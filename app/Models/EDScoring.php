<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EDScoring extends Model
{
    use HasFactory;

    protected $table = 'ed_scorings';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
