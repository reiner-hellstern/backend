<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitglied extends Model
{
    use HasFactory;

    protected $table = 'mitglieder';

    protected $with = [
        'status',
    ];

    //  protected $casts = [
    //    'datum_eintritt' => 'datetime:d.m.Y',
    //    'datum_austritt' => 'datetime:d.m.Y',
    //    'datum_gekuendigt_am' => 'datetime:d.m.Y',
    //    'datum_gekuendigt_ab' => 'datetime:d.m.Y',
    // ];
    protected $fillable = [
        'mitglied_nr',
        'person_id',
        'landesgruppe_id',
        'bezirksgruppe_id',
        'mitgliedsart_id',
        'bezahlart_id',
        'status_id',
        'datum_eintritt',
        'datum_austritt',
        'datum_gekuendigt_am',
        'datum_gekuendigt_ab',
        'bemerkung_intern',
        'bemerkung_fuer_mitglied',
        'aktiv',
    ];

    protected function DatumEintritt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function DatumAustritt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function DatumGekuendigtAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    protected function DatumGekuendigtAb(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function landesgruppe()
    {
        return $this->belongsTo(Landesgruppe::class);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function status()
    {
        return $this->belongsTo(OptionMGStatus::class, 'status_id');
    }

    // geht nur, wenn landesgruppe gejoint ist. sonst landesgruppe()
    public function getOptionLandesgruppe()
    {
        return $this->landesgruppe_id ? ['name' => $this->landesgruppe, 'id' => $this->landesgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bezirksgruppe()
    {
        return $this->belongsTo(Bezirksgruppe::class);
    }

    // geht nur, wenn bezirksgruppe gejoint ist. sonst bezriksgruppe()
    public function getOptionBezirksgruppe()
    {
        return $this->bezirksgruppe_id ? ['name' => $this->bezirksgruppe, 'id' => $this->bezirksgruppe_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function mitgliedsart()
    {
        return $this->belongsTo(Mitgliedsart::class);
    }

    public function bezahlart()
    {
        return $this->belongsTo(Mitgliedsart::class);
    }

    public function bankverbindungen()
    {
        return $this->morphMany(Bankverbindung::class, 'bankverbindungable')
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Aktuelle gültige Bankverbindung für Mitgliedsbeiträge
     */
    public function bankverbindung()
    {
        return $this->morphOne(Bankverbindung::class, 'bankverbindungable')
            ->where('aktiv', 1)
            ->where('gueltig_ab', '<=', now())
            ->where(function ($query) {
                $query->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', now());
            })
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Accessor for mitgliedsnummer (mapping mitglied_nr to mitgliedsnummer)
     */
    public function getMitgliedsnummerAttribute()
    {
        return $this->mitglied_nr;
    }

    public function scopeAktiv($query)
    {
        $heute = Carbon::today();

        return $query->where(function ($q) use ($heute) {
            $q->whereNull('datum_eintritt')
                ->orWhere('datum_eintritt', '=', '0000-00-00')
                ->orWhere('datum_eintritt', '<=', $heute);
        })
            ->where(function ($q) use ($heute) {
                $q->whereNull('datum_austritt')
                    ->orWhere('datum_austritt', '=', '0000-00-00')
                    ->orWhere('datum_austritt', '>=', $heute);
            });
    }
}
