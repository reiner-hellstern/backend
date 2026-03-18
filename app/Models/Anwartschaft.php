<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anwartschaft extends Model
{
    use HasFactory;

    protected $table = 'anwartschaften';

    protected $with = ['dokumente', 'type'];

    //  protected $appends = ['titel_name'];

    //  public function datum(): Attribute
    //  {
    //     return new Attribute(
    //        get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
    //        set: fn ($value) => ($value !== '' && !is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : NULL,
    //     );
    //  }

    public function getDatumAttribute($value)
    {
        return ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y') : '';
    }

    public function setDatumAttribute($value)
    {
        $this->attributes['datum'] = (new Carbon($value))->format('Y-m-d');
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function titel()
    {
        return $this->belongsTo(Titel::class, 'titel_id');
    }

    //  public function getTitelNameAttribute($value)
    //  {
    //    return $this->titel_id ? $this->titel()->typ()->name : '';
    //  }

    public function getAnwartschaftNameAttribute($value)
    {
        return $this->anwartschafttyp_id ? $this->type->name : '';
    }

    public function type()
    {
        return $this->belongsTo(AnwartschaftTyp::class, 'anwartschafttyp_id');
    }

    public function getTypAttribute()
    {
        return $this->anwartschafttyp_id ? ['name' => $this->type->name, 'id' => $this->anwartschafttyp_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }
}
