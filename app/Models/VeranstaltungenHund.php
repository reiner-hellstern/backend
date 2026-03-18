<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeranstaltungenHund extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungen_hunde';

    //   protected $with = ['person', 'hund', 'hf','hundefuehrer'];
    public function hund()
    {
        return $this->morphMany(VeranstaltungenHund::class, 'hundeable');
    }
}
