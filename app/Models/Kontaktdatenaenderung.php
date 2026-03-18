<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Kontaktdatenaenderung extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'vorname',
        'nachname',
        'nachname_ehemals',
        'geboren',
        'telefon_1',
        'telefon_2',
        'telefon_3',
        'email_1',
        'email_2',
        'website_1',
        'website_2',
        'strasse',
        'adresszusatz',
        'postleitzahl',
        'ort',
        'land',
        'laenderkuerzel',
        'bemerkungen',
        'aktiv',
        'bestaetigt_am',
        'bestaetigt_von',
    ];

    protected $casts = [
        'geboren' => 'date',
        'bestaetigt_am' => 'datetime',
        'aktiv' => 'boolean',
    ];

    /**
     * Relationship zu Person
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Relationship zu Person die bestätigt hat
     */
    public function bestaetigtVon(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'bestaetigt_von');
    }

    /**
     * Polymorphe Beziehung zu Dokumenten
     */
    public function dokumente(): MorphToMany
    {
        return $this->morphToMany(Dokument::class, 'dokumentable');
    }

    /**
     * Mutator für Geburtsdatum: deutsches Format zu MySQL Format
     */
    public function setGeborenAttribute($value)
    {
        if ($value && is_string($value)) {
            if (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $value)) {
                $this->attributes['geboren'] = Carbon::createFromFormat('d.m.Y', $value);
            } else {
                $this->attributes['geboren'] = $value;
            }
        } else {
            $this->attributes['geboren'] = $value;
        }
    }

    /**
     * Accessor für Geburtsdatum: MySQL Format zu deutsches Format
     */
    public function getGeborenAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('d.m.Y');
        }

        return $value;
    }
}
