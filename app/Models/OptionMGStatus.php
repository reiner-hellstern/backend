<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionMGStatus extends Model
{
    protected $table = 'optionen_mg_stati';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'beschreibung',
    ];
}
