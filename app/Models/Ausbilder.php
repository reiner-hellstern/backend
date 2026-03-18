<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausbilder extends Model
{
    use HasFactory;

    protected $table = 'ausbilder';

    protected $fillable = [
        'person_id',
        'beginn',
        'ende',
        'ausweis_status_id',
        'ausweisdatum',
        'ausweisnummer',
        'nummer',
        'status_id',
        'fortbildung_gueltig',
        'fortbildung_bestaetigt_am',
    ];

    protected $casts = [

        'fortbildung_gueltig' => 'boolean',
    ];

    protected function beginn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function ende(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function ausweisdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function fortbildungBestaetigtAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    // Relationships
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionAusbilderStatus::class, 'status_id');
    }

    public function ausweisStatus()
    {
        return $this->belongsTo(OptionAusbilderausweisStatus::class, 'ausweis_status_id');
    }

    public function ausbildertypen()
    {
        return $this->belongsToMany(Ausbildertyp::class, 'ausbilder_ausbildertyp')
            ->withPivot('aktiv')
            ->wherePivot('aktiv', true);
    }

    public function allAusbildertypen()
    {
        return $this->belongsToMany(Ausbildertyp::class, 'ausbilder_ausbildertyp')
            ->withPivot('aktiv');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    // Scopes
    public function scopeAktiv($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('aktiv', true);
        });
    }

    public function scopeAmtierend($query)
    {
        $heute = Carbon::today();

        return $query->where('beginn', '<=', $heute)
            ->where(function ($q) use ($heute) {
                $q->whereNull('ende')
                    ->orWhere('ende', '>=', $heute);
            });
    }
}
