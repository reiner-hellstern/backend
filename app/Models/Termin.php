<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termin extends Model
{
    use HasFactory;

    protected $table = 'termine';

    protected $appends = ['datum'];

    public function veranstaltung()
    {
        return $this->hasOne(Veranstaltung::class);
    }

    protected function Datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function getBeginnAttribute($value)
    {
        if ($value !== '00:00:00' && $value !== '' && ! is_null($value)) {
            $s = explode(':', $value);

            return ['hours' => $s[0], 'minutes' => $s[1]];
        } else {
            return null;
        }
    }

    public function setBeginnAttribute($value)
    {
        if (! is_null($value)) {
            $minutes = intval($value['hours']) * 60 + intval($value['minutes']);
            $this->attributes['beginn'] = intdiv($minutes, 60) . ':' . ($minutes % 60);
        } else {
            $this->attributes['beginn'] = null;
        }
    }

    public function getEndeAttribute($value)
    {
        if ($value !== '00:00:00' && $value !== '' && ! is_null($value)) {
            $s = explode(':', $value);

            return ['hours' => $s[0], 'minutes' => $s[1]];
        } else {
            return null;
        }
    }

    public function setEndeAttribute($value)
    {
        if (! is_null($value)) {
            $minutes = intval($value['hours']) * 60 + intval($value['minutes']);
            $this->attributes['ende'] = intdiv($minutes, 60) . ':' . ($minutes % 60);
        } else {
            $this->attributes['ende'] = null;
        }
    }

    //  protected function Beginn(): Attribute
    //  {
    //     return new Attribute(
    //        function ($value) {
    //           if ($value !== '00:00:00' && $value !== '' && !is_null($value)) {
    //              $s = explode(':', $value);
    //              return ['hours' => $s[0], 'minutes' => $s[1]];
    //           } else {
    //              return null;
    //           }
    //        },
    //        function ($value) {
    //           if (!is_null($value)) {
    //              $minutes = intval($value['hours']) * 60 + intval($value['minutes']);
    //              $this->attributes['beginn'] = intdiv($minutes, 60) . ':' . ($minutes % 60);
    //           } else {
    //              $this->attributes['beginn'] = null;
    //           }
    //        }
    //     );
    //  }

    //  protected function Ende(): Attribute
    //  {
    //     return new Attribute(
    //        function ($value) {
    //           if ($value !== '00:00:00' && $value !== '' && !is_null($value)) {
    //              $s = explode(':', $value);
    //              return ['hours' => $s[0], 'minutes' => $s[1]];
    //           } else {
    //              return null;
    //           }
    //        },
    //        function ($value) {
    //           if (!is_null($value)) {
    //              $minutes = intval($value['hours']) * 60 + intval($value['minutes']);
    //              $this->attributes['beginn'] = intdiv($minutes, 60) . ':' . ($minutes % 60);
    //           } else {
    //              $this->attributes['beginn'] = null;
    //           }
    //        }
    //     );
    //  }

}
