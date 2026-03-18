<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sonderleiter extends Model
{
    use HasFactory;

    protected $table = 'sonderleiter';

    protected $fillable = [
        'person_id',
        'beginn',
        'ende',
        'status_id',
        'aktiv',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
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

    // Relationships
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionAusbilderStatus::class, 'status_id'); // Temporär, bis Sonderleiter-Status-Tabelle existiert
    }

    // Scopes
    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
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
