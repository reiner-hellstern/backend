<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funktion extends Model
{
    use HasFactory;

    protected $table = 'funktionen';

    public function personen()
    {
        return $this->belongsToMany(Person::class);
    }
}
