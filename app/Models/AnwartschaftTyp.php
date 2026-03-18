<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnwartschaftTyp extends Model
{
    use HasFactory;

    protected $table = 'anwartschaft_typen';

    protected $fillable = [
        'name',
        'name_kurz',
        'master',
        'gruppe',
        'jagdlich',
        'anwartschaft',
        'verband_verein',
        'land',
        'state',
        'order',
    ];
}
