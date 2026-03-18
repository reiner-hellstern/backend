<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DsgvoErklaerung extends Model
{
    use HasFactory;

    protected $table = 'dsgvo_erklaerungen';

    protected $fillable = [
        'person_id',
        'stufe',
        'zugestimmt_am',
        'widerrufen_am',
        'bemerkungen',
        'ist_aktiv',
    ];

    protected $casts = [
        'stufe' => 'integer',
        'ist_aktiv' => 'boolean',
    ];

    /**
     * Casts für Datum-Felder:
     * - get: Von MySQL-Format (YYYY-MM-DD) zu deutschem Format (DD.MM.YYYY)
     * - set: Von deutschem Format (DD.MM.YYYY) zu MySQL-Format (YYYY-MM-DD)
     */
    protected function casts(): array
    {
        return [
            'zugestimmt_am' => 'date:d.m.Y',
            'widerrufen_am' => 'date:d.m.Y',
        ];
    }

    /**
     * Relation zur Person
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Scope: Nur aktive DSGVO-Erklärungen
     */
    public function scopeAktiv($query)
    {
        return $query->where('ist_aktiv', true)->whereNull('widerrufen_am');
    }

    /**
     * Scope: Nur widerrufene DSGVO-Erklärungen
     */
    public function scopeWiderrufen($query)
    {
        return $query->where('ist_aktiv', false)->whereNotNull('widerrufen_am');
    }

    /**
     * Scope: Nach Stufe filtern
     */
    public function scopeStufe($query, int $stufe)
    {
        return $query->where('stufe', $stufe);
    }

    /**
     * Prüft, ob die DSGVO-Erklärung noch gültig ist
     */
    public function istGueltig(): bool
    {
        return $this->ist_aktiv && is_null($this->widerrufen_am);
    }

    /**
     * Widerrufe die DSGVO-Erklärung
     */
    public function widerrufen(?string $datum = null): void
    {
        $this->widerrufen_am = $datum ?? now()->format('d.m.Y');
        $this->ist_aktiv = false;
        $this->save();
    }
}
