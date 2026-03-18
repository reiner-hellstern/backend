<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Neuzuechterseminar extends Model
{
    use HasFactory;

    protected $table = 'neuzuechterseminare';

    protected $fillable = [
        'person_id',
        'datum',
        'ort',
        'bemerkungen',
        'event_id',
        'aktiv',
        'status',
        'bestaetigt_am',
        'bestaetigt_von',
    ];

    protected $casts = [
        'datum' => 'date',
        'bestaetigt_am' => 'datetime',
        'status' => 'boolean',
        'aktiv' => 'boolean',
    ];

    /**
     * Carbon-Caster für datum Feld (Datum)
     */
    protected function datum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für bestaetigt_am Feld (Timestamp)
     */
    protected function bestaetigtAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00 00:00:00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00 00:00:00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00 00:00:00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Person die das Neuzüchterseminar absolviert hat
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Person die das Seminar bestätigt hat
     */
    public function bestaetigtVon(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'bestaetigt_von');
    }

    /**
     * Veranstaltung/Event bei dem das Seminar stattgefunden hat
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Veranstaltung::class, 'event_id');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
