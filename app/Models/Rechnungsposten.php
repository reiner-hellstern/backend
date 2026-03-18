<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rechnungsposten extends Model
{
    use HasFactory;

    protected $table = 'rechnungsposten';

    protected $fillable = [
        'rechnung_id',
        'gebuehr_id',
        'beschreibung',
        'anzahl',
        'einzelpreis',
        'order',
        'aktiv',
    ];

    protected $casts = [
        'einzelpreis' => 'decimal:2',
        'anzahl' => 'integer',
        'order' => 'integer',
        'aktiv' => 'boolean',
    ];

    // Relationships
    public function rechnung()
    {
        return $this->belongsTo(Rechnung::class);
    }

    public function gebuehr()
    {
        return $this->belongsTo(Gebuehr::class);
    }

    public function getEinzelpreisFormattiertAttribute()
    {
        return number_format($this->einzelpreis, 2, ',', '.') . ' €';
    }

    // Events
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saved(function ($posten) {
    //         if ($posten->rechnung) {
    //             $posten->rechnung->berechneGesamtbetrag();
    //         }
    //     });

    //     static::deleted(function ($posten) {
    //         if ($posten->rechnung) {
    //             $posten->rechnung->berechneGesamtbetrag();
    //         }
    //     });
    // }
}
