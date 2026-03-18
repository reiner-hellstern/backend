<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahnentafelantrag extends Model
{
    use HasFactory;

    protected $table = 'ahnentafelantraege';

    public function kommentare()
    {
        return $this->morphMany(Kommentar::class, 'kommentarable');
    }
}
