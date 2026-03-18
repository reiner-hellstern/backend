<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gebuehrengruppe extends Model
{
    use HasFactory;

    protected $table = 'gebuehrengruppen';

    protected $fillable = [
        'name',
        'beschreibung',
        'order',
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
     * Katalog-Einträge, die zu dieser Gruppe gehören
     */
    public function gebuehrenkatalog(): HasMany
    {
        return $this->hasMany(Gebuehrenkatalog::class, 'gebuehrengruppe_id')->orderBy('name');
    }

    /**
     * Scope für Sortierung nach der Order-Spalte
     */
    public function scopeGeordnet($query)
    {
        return $query->orderBy('order');
    }
}
