<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtbuchnummer extends Model
{
    use HasFactory;

    protected $table = 'zuchtbuchnummern';

    protected $fillable = ['zuchtbuchnummer'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }
}
