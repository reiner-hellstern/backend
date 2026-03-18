<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeranstaltungOption extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungsoptionen';

    public function typ()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }
}
