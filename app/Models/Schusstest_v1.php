<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schusstest_v1 extends Model
{
    use HasFactory;

    protected $table = 'schussteste_v1';

    protected $appends = ['schussfestigkeit'];

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

    public function schussfestigkeit_option()
    {
        return $this->belongsTo(OptionSchusstest1Schussfestigkeit::class, 'schussfestigkeit_id');
    }

    public function getSchussfestigkeitAttribute()
    {
        return $this->schussfestigkeit_id ? ['name' => $this->schussfestigkeit_option->name, 'id' => $this->schussfestigkeit_id, 'wert' => $this->schussfestigkeit_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
