<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BHP_v1 extends Model
{
    use HasFactory;

    protected $table = 'bhp_v1';

    // protected $appends = ['test_verhalten_unbefangenheit', 'test_geamtbeurteilung'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    //  protected function datum(): Attribute
    //  {
    //      return new Attribute(
    //        get: fn ($value) =>  ($value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
    //        set: fn ($value) =>  ($value !== '' && !is_null($value)) ? Carbon::parse($value)->format('Y-m-d'): '0000-00-00',
    //      );
    //  }

    //  public function getTestVerhaltenUnbefangenheitAttribute()
    //  {
    //    $optionen = $this->belongsTo(OptionBHP1::class, 'test_verhalten_unbefangenheit_id');
    //    return $this->test_verhalten_unbefangenheit_id ? [ 'name' => $optionen->name, 'id' => $this->test_verhalten_unbefangenheit_id, 'wert' => $this->test_verhalten_unbefangenheit_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    //  public function getTestGesamtbeurteilungAttribute()
    //  {
    //    $optionen = $this->belongsTo(OptionBHP1::class, 'test_gesamtbeurteilung_id');
    //    return $this->test_gesamtbeurteilung_id ? [ 'name' => $optionen->name, 'id' => $this->test_gesamtbeurteilung_id, 'wert' => $this->test_gesamtbeurteilung_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    //  public function _option()
    //  {
    //      return $this->belongsTo(OptionBHP1::class, '_id');
    //  }

    //  public function getAttribute()
    //  {
    //    return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id ] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

}
