<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HundPerson extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'hund_person';

    //  protected $fillable = [
    //      'hund_id',
    //      'person_id',
    //      'seit',
    //      'bis',
    //      'status',
    //      'bemerkung',
    //  ];

    //  protected $dates = [
    //      'seit',
    //      'bis',
    //  ];

    //  protected $casts = [
    //      'seit' => 'date:Y-m-d',
    //      'bis' => 'date:Y-m-d',
    //  ];
    //  public function getSeitAttribute($value)
    //  {
    //        return ($value !== '0000-00-00' && $value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y') : '';
    //  }

    public function Seit(): Attribute
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
}
