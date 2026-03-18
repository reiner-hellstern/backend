<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuechter extends Model
{
    use HasFactory;

    protected $table = 'zuechter';

    protected $with = ['person'];

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function zuchtverbote()
    {
        return $this->morphToMany(Zuchtverbot::class, 'zuchtverbotable')->orderBy('updated_at', 'asc');
    }
}
