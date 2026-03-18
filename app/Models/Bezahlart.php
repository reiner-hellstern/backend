<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bezahlart extends Model
{
    use HasFactory;

    protected $table = 'bezahlarten';

    public function mitglied()
    {
        return $this->hasMany(Mitglied::class);
    }
}
