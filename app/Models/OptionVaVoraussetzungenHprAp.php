<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVaVoraussetzungenHprAp extends Model
{
    use HasFactory;

    protected $table = 'optionen_va_voraussetzungen_hpr_ap';

    protected $with = ['veranstaltungstyp'];

    public function veranstaltungstyp()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }
}
