<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVaVoraussetzungenBlp extends Model
{
    use HasFactory;

    protected $table = 'optionen_va_voraussetzungen_blp';

    protected $with = ['veranstaltungstyp'];

    public function veranstaltungstyp()
    {
        return $this->belongsTo(Veranstaltungstyp::class);
    }
}
