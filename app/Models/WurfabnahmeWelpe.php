<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WurfabnahmeWelpe extends Model
{
    use HasFactory;

    protected $table = 'wurfabnahme_welpen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wurfabnahme_id',
        'welpen_id',
        'farbe_id',
        'augen_id',
        'gebiss_id',
        'hoden_id',
        'zaehne',
        'zuchtausschliessende_fehler',
        'bemerkung',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'geschlecht',
        'rasse',
    ];

    /**
     * Get the Wurfabnahme that owns the WurfabnahmeWelpe
     */
    public function wurfabnahme()
    {
        return $this->belongsTo(Wurfabnahme::class);
    }

    /**
     * Get the Welpe (puppy) that owns the WurfabnahmeWelpe
     */
    public function welpe()
    {
        return $this->belongsTo(Hund::class, 'hund_id');
    }

    /**
     * Get the color of the puppy
     */
    public function farbe()
    {
        return $this->belongsTo(Farbe::class, 'farbe_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    /**
     * Get the eyes evaluation
     */
    public function augen()
    {
        return $this->belongsTo(BewertungAugen::class, 'augen_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    /**
     * Get the teeth/dentition evaluation
     */
    public function gebiss()
    {
        return $this->belongsTo(BewertungGebiss::class, 'gebiss_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    /**
     * Get the testicles evaluation
     */
    public function hoden()
    {
        return $this->belongsTo(BewertungHoden::class, 'hoden_id')->withDefault([
            'id' => 0,
            'name' => 'n/a (Hündin)',
        ]);
    }
}
