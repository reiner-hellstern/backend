<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtwart extends Model
{
    use HasFactory;

    protected $table = 'zuchtwarte';

    protected $with = ['person'];

    public function rassen()
    {
        return $this->belongsToMany(Rasse::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function wuerfe()
    {
        return $this->hasMany(Wurf::class, 'zuchtwart_id', 'id')->orderByDesc('wurfdatum');
    }
}
