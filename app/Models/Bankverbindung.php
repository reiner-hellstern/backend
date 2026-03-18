<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankverbindung extends Model
{
    use HasFactory;

    protected $table = 'bankverbindungen';

    protected $with = ['dokumente'];

    protected $fillable = [
        'bankverbindungable_id',
        'bankverbindungable_type',
        'blz',
        'bankname',
        'ort',
        'land',
        'ausland',
        'kontonummer',
        'bic',
        'iban',
        'kontoinhaber',
        'mandatsreferenz',
        'anmerkungen',
        'gueltig_ab',
        'gueltig_bis',
        'aktiv',
        'order',
    ];

    protected $casts = [
        'gueltig_ab' => 'date',
        'gueltig_bis' => 'date',
        'aktiv' => 'boolean',
        'ausland' => 'boolean',
    ];

    /**
     * Polymorphe Relation - kann zu Person oder Mitglied gehören
     */
    public function bankverbindungable()
    {
        return $this->morphTo();
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    /**
     * Scope für aktive Bankverbindungen
     */
    public function scopeAktiv($query)
    {
        return $query->where('aktiv', 1);
    }

    /**
     * Scope für aktuell gültige Bankverbindungen
     */
    public function scopeGueltig($query, $datum = null)
    {
        $datum = $datum ?: now()->format('Y-m-d');

        return $query->where(function ($q) use ($datum) {
            $q->where('gueltig_ab', '<=', $datum)
                ->orWhere('gueltig_ab', '=', '0000-00-00')
                ->orWhereNull('gueltig_ab');
        })->where(function ($q) use ($datum) {
            $q->whereNull('gueltig_bis')
                ->orWhere('gueltig_bis', '>=', $datum)
                ->orWhere('gueltig_bis', '=', '0000-00-00');
        });
    }

    /**
     * Prüft ob die Bankverbindung zum aktuellen Datum gültig ist
     */
    public function istGueltig($datum = null)
    {
        $datum = $datum ?: now()->format('Y-m-d');

        $gueltigAb = $this->gueltig_ab;
        $gueltigBis = $this->gueltig_bis;

        // Ungültige Datumswerte als unbegrenzt behandeln
        $abGueltig = is_null($gueltigAb) || $gueltigAb === '0000-00-00' || $gueltigAb <= $datum;
        $bisGueltig = is_null($gueltigBis) || $gueltigBis === '0000-00-00' || $gueltigBis >= $datum;

        return $this->aktiv && $abGueltig && $bisGueltig;
    }
}
