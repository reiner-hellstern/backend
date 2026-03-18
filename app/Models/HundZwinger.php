<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HundZwinger extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'hund_zwinger';

    protected $fillable = [
        'hund_id',
        'zwinger_id',
        'von',
        'bis',
        'typ',
        'leihstellung',
        'leihstellung_id',
        'anmerkung',
    ];

    //  public function getSeitAttribute($value)
    //  {
    //        return ($value !== '0000-00-00' && $value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y') : '';
    //  }

    public function Von(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function Bis(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class);
    }

    public function leihstellung()
    {
        return $this->belongsTo(Leihstellung::class, 'leihstellung_id');
    }

    public function scopeMitLeihstellung($query)
    {
        return $query->whereNotNull('leihstellung_id')
            ->with('leihstellung.dokumente');
    }

    public function scopeAktiveLeihstellung($query)
    {
        return $query->whereNotNull('leihstellung_id')
            ->where('von', '<=', now())
            ->where(function ($q) {
                $q->whereNull('bis')
                    ->orWhere('bis', '>=', now());
            });
    }
}
