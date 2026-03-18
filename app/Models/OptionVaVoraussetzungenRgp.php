<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVaVoraussetzungenRgp extends Model
{
    use HasFactory;

    protected $table = 'optionen_va_voraussetzungen_rgp';

    protected $with = ['veranstaltungstyp'];

    public function veranstaltungstyp()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }
}
