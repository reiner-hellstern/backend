<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zweiwohnsitznachweis extends Model
{
    use HasFactory;

    protected $table = 'zweitwohnsitznachweise';

    protected $fillable = [
        'person_id',
        'zuchtstaette_id',
        'bemerkungen',
        'aktiv',
        'status',
        'bestaetigt_am',
        'bestaetigt_von',
    ];

    protected $casts = [
        'bestaetigt_am' => 'datetime',
        'status' => 'boolean',
        'aktiv' => 'boolean',
    ];

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
     * Person für die der Zweitwohnsitznachweis erstellt wurde
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Zuchtstätte für die der Zweitwohnsitznachweis erstellt wurde
     */
    public function zuchtstaette()
    {
        return $this->belongsTo(Zuchtstaette::class, 'zuchtstaette_id');
    }

    /**
     * Person die den Nachweis bestätigt hat
     */
    public function bestaetigtVon()
    {
        return $this->belongsTo(Person::class, 'bestaetigt_von');
    }

    /**
     * Dokumente die zu diesem Zweitwohnsitznachweis gehören
     */
    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
