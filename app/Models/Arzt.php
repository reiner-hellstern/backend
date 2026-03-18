<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arzt extends Model
{
    use HasFactory;

    protected $table = 'aerzte';

    protected $fillable = [
        'person_id',
        'anmerkungen',
        'aktiv',
        'autocomplete',
        'praxisname',
        'titel',
        'vorname',
        'nachname',
        'strasse',
        'adresszusatz',
        'postleitzahl',
        'ort',
        'land',
        'land_kuerzel',
        'email_1',
        'email_2',
        'website_1',
        'website_2',
        'telefon_1',
        'telefon_2',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'autocomplete' => 'boolean',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function fachgebiete()
    {
        return $this->belongsToMany(Fachgebiet::class, 'arzt_fachgebiet')
            ->withPivot(['gutachter', 'obergutachter'])
            ->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        $name = trim($this->titel . ' ' . $this->vorname . ' ' . $this->nachname);

        return $name ?: 'Unbenannt';
    }

    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->strasse) {
            $address[] = $this->strasse;
        }
        if ($this->adresszusatz) {
            $address[] = $this->adresszusatz;
        }
        if ($this->postleitzahl || $this->ort) {
            $cityLine = trim($this->postleitzahl . ' ' . $this->ort);
            if ($cityLine) {
                $address[] = $cityLine;
            }
        }
        if ($this->land) {
            $address[] = $this->land;
        }

        return implode(', ', $address);
    }
}
