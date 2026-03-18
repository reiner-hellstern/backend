<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeranstaltungenHundefuehrer extends Model
{
    use HasFactory;

    protected $table = 'veranstaltungen_hundefuehrer';

    public function hundefuehrer()
    {
        return $this->morphMany(VeranstaltungenHundefuehrer::class, 'hundefuehrerable');
    }
}
