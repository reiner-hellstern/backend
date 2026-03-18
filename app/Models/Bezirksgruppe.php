<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bezirksgruppe extends Model
{
    use HasFactory;

    protected $table = 'bezirksgruppen';

    public function mitglied()
    {
        return $this->hasMany(Mitglied::class);
    }

    public function postleitzahlen()
    {
        return $this->hasMany(Postleitzahl::class);
    }

    public function landesgruppe()
    {
        return $this->belongsTo(Landesgruppe::class);
    }

    public function bankverbindungen()
    {
        return $this->morphMany(Bankverbindung::class, 'bankverbindungable')
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Aktuelle gültige Bankverbindung
     */
    public function bankverbindung()
    {
        return $this->morphOne(Bankverbindung::class, 'bankverbindungable')
            ->where('aktiv', 1)
            ->where('gueltig_ab', '<=', now())
            ->where(function ($query) {
                $query->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', now());
            })
            ->orderBy('gueltig_ab', 'desc');
    }
}
