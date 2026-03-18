<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teilnehmer extends Model
{
    use HasFactory;

    protected $table = 'teilnehmer';

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
