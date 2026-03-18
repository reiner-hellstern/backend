<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BewertungAugen extends Model
{
    use HasFactory;

    protected $table = 'bewertungen_augen';

    protected $fillable = [
        'name',
        'aktiv',
        'order',
    ];
}
