<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BlutprobeneinlagerungHund extends Pivot
{
    protected $table = 'blutprobeneinlagerung_hund';

    protected $fillable = [
        'blutprobeneinlagerung_id',
        'hund_id',
        'arzt_id',
        'ausschlussdiagnostik_am',
    ];

    /**
     * Cast ausschlussdiagnostik_am from ISO (Y-m-d) to German (d.m.Y) on get
     * and from German (d.m.Y) to ISO (Y-m-d) on set
     */
    protected function ausschlussdiagnostikAm(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value))
                ? Carbon::parse($value)->format('d.m.Y')
                : '',
            set: function ($value) {
                if ($value === '' || is_null($value)) {
                    return null;
                }

                // Versuche beide Formate zu parsen
                try {
                    // Prüfe ob es bereits ISO-Format ist (Y-m-d)
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                        return $value;
                    }

                    // Sonst versuche deutsches Format (d.m.Y)
                    return Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Fallback: Carbon versucht automatisch zu parsen
                    return Carbon::parse($value)->format('Y-m-d');
                }
            },
        );
    }

    /**
     * Beziehung zum Arzt
     */
    public function arzt()
    {
        return $this->belongsTo(Arzt::class, 'arzt_id');
    }

    /**
     * Beziehung zur Blutprobeneinlagerung
     */
    public function blutprobeneinlagerung()
    {
        return $this->belongsTo(Blutprobeneinlagerung::class, 'blutprobeneinlagerung_id');
    }

    /**
     * Beziehung zum Hund
     */
    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id');
    }
}
