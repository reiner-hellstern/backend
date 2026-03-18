<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausbildertyp extends Model
{
    use HasFactory;

    protected $table = 'ausbildertypen';

    protected $fillable = [
        'name',
        'name_kurz',
        'val',
        'typ',
        'aktiv',
        'wert',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    // Relationships
    public function ausbilder()
    {
        return $this->belongsToMany(Ausbilder::class, 'ausbilder_ausbildertyp')
            ->withPivot('aktiv');
    }

    // Scopes
    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
