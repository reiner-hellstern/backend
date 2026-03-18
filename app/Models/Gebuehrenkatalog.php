<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gebuehrenkatalog extends Model
{
    use HasFactory;

    protected $table = 'gebuehrenkatalog';

    protected $fillable = [
        'name',
        'beschreibung',
        'gebuehrengruppe_id',
        'mkonto',
    ];

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
     * Gruppe zu der dieser Katalog-Eintrag gehört
     */
    public function gruppe(): BelongsTo
    {
        return $this->belongsTo(Gebuehrengruppe::class, 'gebuehrengruppe_id');
    }

    /**
     * Alias für gruppe - für einfachere Frontend-Verwendung
     */
    public function gebuehrengruppe(): BelongsTo
    {
        return $this->belongsTo(Gebuehrengruppe::class, 'gebuehrengruppe_id');
    }

    /**
     * Gebühren für diesen Katalog-Eintrag
     */
    public function gebuehren(): HasMany
    {
        return $this->hasMany(Gebuehr::class, 'gebuehrenkatalog_id');
    }

    /**
     * Scope für Sortierung nach Name
     */
    public function scopeNachName($query)
    {
        return $query->orderBy('name');
    }

    /**
     * Vollständige Bezeichnung (Name + Beschreibung)
     */
    public function getVollstBezeichnungAttribute(): string
    {
        return $this->name . ($this->beschreibung ? ' - ' . $this->beschreibung : '');
    }
}
