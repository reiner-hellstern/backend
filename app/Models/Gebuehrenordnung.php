<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gebuehrenordnung extends Model
{
    use HasFactory;

    protected $table = 'gebuehrenordnungen';

    protected $fillable = [
        'name',
        'gueltig_ab',
        'gueltig_bis',
        'stand',
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
     * Carbon-Caster für Stand Feld (Datum)
     */
    protected function stand(): Attribute
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
     * Gebühren, die zu dieser Gebührenordnung gehören
     */
    public function gebuehren(): HasMany
    {
        return $this->hasMany(Gebuehr::class, 'gebuehrenordnung_id');
    }

    /**
     * Katalog-Einträge, die zu dieser Gebührenordnung gehören (über gebuehren-Tabelle)
     */
    public function gebuehrenkatalog()
    {
        return $this->hasManyThrough(
            Gebuehrenkatalog::class,
            Gebuehr::class,
            'gebuehrenordnung_id', // Foreign key auf gebuehren-Tabelle
            'id', // Foreign key auf gebuehrenkatalog-Tabelle
            'id', // Local key auf gebuehrenordnungen-Tabelle
            'gebuehrenkatalog_id' // Local key auf gebuehren-Tabelle
        );
    }

    /**
     * Scope für aktuell gültige Gebührenordnungen
     */
    public function scopeGueltig($query)
    {
        $today = now()->toDateString();

        return $query->where('gueltig_ab', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', $today);
            });
    }

    /**
     * Prüft, ob diese Gebührenordnung aktuell gültig ist
     */
    public function istGueltig(): bool
    {
        $today = now()->toDateString();

        return $this->gueltig_ab <= $today &&
               (is_null($this->gueltig_bis) || $this->gueltig_bis >= $today);
    }
}
