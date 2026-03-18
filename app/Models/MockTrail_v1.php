<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockTrail_v1 extends Model
{
    use HasFactory;

    protected $table = 'mocktrail_v1';

    protected $appends = [];

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
    //  public function _option()
    //  {
    //      return $this->belongsTo(OptionMockTrail1Ausschlussgrund::class, '_id');
    //  }

    //  public function getAttribute()
    //  {
    //    return $this->_id ? [ 'name' => $this->_option->name, 'id' => $this->_id ] : [ 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }
}
