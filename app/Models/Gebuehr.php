<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gebuehr extends Model
{
    use HasFactory;

    protected $table = 'gebuehren';

    protected $fillable = [
        'gebuehrenkatalog_id',
        'gebuehrenordnung_id',
        'kosten_mitglied',
        'kosten_nichtmitglied',
        'gueltig_ab',
        'gueltig_bis',
        'aktiv',
    ];

    protected $casts = [
        'kosten_mitglied' => 'decimal:2',
        'kosten_nichtmitglied' => 'decimal:2',
        'aktiv' => 'boolean',
    ];

    /**
     * Carbon-Caster für gueltig_ab Feld (Datum)
     */
    protected function gueltigAb(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für gueltig_bis Feld (Datum)
     */
    protected function gueltigBis(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Katalog-Eintrag zu dem diese Gebühr gehört
     */
    public function gebuehrenkatalog(): BelongsTo
    {
        return $this->belongsTo(Gebuehrenkatalog::class, 'gebuehrenkatalog_id');
    }

    /**
     * Alias für gebuehrenkatalog - für einfachere Frontend-Verwendung
     */
    public function katalog(): BelongsTo
    {
        return $this->belongsTo(Gebuehrenkatalog::class, 'gebuehrenkatalog_id');
    }

    /**
     * Gebührenordnung zu der diese Gebühr gehört
     */
    public function gebuehrenordnung(): BelongsTo
    {
        return $this->belongsTo(Gebuehrenordnung::class, 'gebuehrenordnung_id');
    }

    /**
     * Gibt den Betrag für einen bestimmten Mitgliedschaftstyp zurück
     */
    public function getKostenFuer(bool $istMitglied): float
    {
        return $istMitglied ? $this->kosten_mitglied : $this->kosten_nichtmitglied;
    }

    /**
     * Scope für aktive Gebühren
     */
    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope für gültige Gebühren zum aktuellen Datum
     */
    public function scopeGueltig($query, $datum = null)
    {
        $datum = $datum ?: now()->toDateString();

        return $query->where('gueltig_ab', '<=', $datum)
            ->where(function ($q) use ($datum) {
                $q->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', $datum);
            });
    }
}
