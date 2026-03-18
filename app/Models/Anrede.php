<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anrede extends Model
{
    protected $table = 'optionen_anreden';

    protected $fillable = ['name', 'name_kurz', 'name_lang', 'titel', 'wert', 'typ', 'aktiv'];

    use HasFactory;
}
