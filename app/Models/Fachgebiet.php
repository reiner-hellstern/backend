<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fachgebiet extends Model
{
    use HasFactory;

    protected $table = 'fachgebiete';

    protected $fillable = [
        'name',
        'beschreibung',
        'aktiv',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    public function aerzte()
    {
        return $this->belongsToMany(Arzt::class, 'arzt_fachgebiet');
    }
}
