<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Richter extends Model
{
    use HasFactory;

    protected $table = 'richter';

    protected $with = ['person', 'richtertypen'];

    protected $fillable = [
        'person_id',
        'richtertyp_id',
        'richterattribute_id',
        'beginn',
        'ende',
        'status_id',
        'ausweis_status_id',
        'ausweisnummer',
        'telefon',
        'mobil',
        'fax',
        'email',
        'drc',
        'fcinummer',
        'verein',
    ];

    protected $casts = [
        'drc' => 'boolean',
    ];

    /**
     * Carbon-Caster
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

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

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function richtertypen()
    {
        return $this->belongsToMany(Richtertyp::class, 'richter_richtertyp', 'richter_id', 'richtertyp_id');
    }

    public function richtertyp()
    {
        return $this->belongsTo(Richtertyp::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionRichterstatus::class, 'status_id');
    }

    public function ausweisStatus()
    {
        return $this->belongsTo(OptionRichterausweisStatus::class, 'ausweis_status_id');
    }

    // Scope für DRC-Richter
    public function scopeDrcRichter($query)
    {
        return $query->where('drc', 1);
    }

    // Scope für externe Richter
    public function scopeExterneRichter($query)
    {
        return $query->where('drc', 0);
    }
}
