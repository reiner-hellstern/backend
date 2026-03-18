<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hundabgabeantrag extends Model
{
    use HasFactory;

    protected $table = 'hundabgabeantraege';

    protected $fillable = [
        'hund_id',
        'status_id',
        'antragsteller_id',
        'bearbeiter_id',
        'bemerkungen_drc',
        'bemerkungen_antragsteller',
        'show_in_profile',
        'aktiv',
        'sent_at',
        'abgabedatum',
        'accessDRC_at',
        'bestaetigt',
    ];

    protected $casts = [
        'show_in_profile' => 'boolean',
        'aktiv' => 'boolean',
        'bestaetigt' => 'boolean',
    ];

    protected function abgabedatum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function sentAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('j.n.Y') . ' um ' . Carbon::parse($value)->format('H:i') . ' Uhr' : '',
        );
    }

    protected function accessDRCAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('j.n.Y') . ' um ' . Carbon::parse($value)->format('H:i') . ' Uhr' : '',
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function antragsteller()
    {
        return $this->belongsTo(Person::class, 'antragsteller_id');
    }

    public function bearbeiter()
    {
        return $this->belongsTo(Person::class, 'bearbeiter_id');
    }

    public function status()
    {
        return $this->belongsTo(OptionAntragstatus::class, 'status_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'desc');
    }
}
