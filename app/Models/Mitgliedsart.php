<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitgliedsart extends Model
{
    use HasFactory;

    protected $table = 'mitgliedsarten';

    public function mitglied()
    {
        return $this->hasMany(Mitglied::class);
    }
}
