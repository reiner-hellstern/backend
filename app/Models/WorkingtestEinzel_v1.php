<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingtestEinzel_v1 extends Model
{
    use HasFactory;

    protected $table = 'workingteste_einzel_v1';

    // protected $appends = ['aufgaben','a1t','a2t','a3t','a4t','a5t','a6t','a7t','a8t','a9t','a10t','a11t','a12t'];
    protected $appends = ['aufgaben'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class, 'veranstaltung_id');
    }

    public function veranstaltung_raw()
    {
        return $this->belongsTo(VeranstaltungRaw::class, 'veranstaltung_id');
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function getAufgabenAttribute()
    {

        $aufgaben = [];
        $va = Veranstaltung::find($this->veranstaltung_id);

        for ($i = 1; $i < ($va->aufgaben_anzahl) + 1; $i++) {
            // $this->{'a'.$i} ? [ 'punkte' => $this->{'a'.$i}, 'richter' => $this->$this->{'r'.$i.'_id'}] : [  'punkte' => null, 'richter' => null ];
            array_push($aufgaben, ['punkte' => $this->{'a' . $i}, 'richter' => $this->{'r' . $i . '_id'}]);
        }

        return $aufgaben;

    }

    public function getA1tAttribute()
    {
        return $this->a1 ? ['punkte' => $this->a1, 'richter' => $this->r1_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA2tAttribute()
    {
        return $this->a2 ? ['punkte' => $this->a2, 'richter' => $this->r2_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA3tAttribute()
    {
        return $this->a3 ? ['punkte' => $this->a3, 'richter' => $this->r3_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA4tAttribute()
    {
        return $this->a4 ? ['punkte' => $this->a4, 'richter' => $this->r4_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA5tAttribute()
    {
        return $this->a5 ? ['punkte' => $this->a5, 'richter' => $this->r5_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA6tAttribute()
    {
        return $this->a6 ? ['punkte' => $this->a6, 'richter' => $this->r6_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA7tAttribute()
    {
        return $this->a7 ? ['punkte' => $this->a7, 'richter' => $this->r7_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA8tAttribute()
    {
        return $this->a8 ? ['punkte' => $this->a8, 'richter' => $this->r8_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA9tAttribute()
    {
        return $this->a9 ? ['punkte' => $this->a9, 'richter' => $this->r9_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA10tAttribute()
    {
        return $this->a10 ? ['punkte' => $this->a10, 'richter' => $this->r10_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA11tAttribute()
    {
        return $this->a11 ? ['punkte' => $this->a11, 'richter' => $this->r11_id] : ['punkte' => null, 'richter' => null];
    }

    public function getA12tAttribute()
    {
        return $this->a12 ? ['punkte' => $this->a12, 'richter' => $this->r12_id] : ['punkte' => null, 'richter' => null];
    }
}
