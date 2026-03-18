<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APDR_v1 extends Model
{
    use HasFactory;

    protected $table = 'apdr_v1';

    protected $appends = ['test1_ausfuehrung', 'test2_ausfuehrung', 'test3_ausfuehrung', 'test4_ausfuehrung', 'ausschlussgrund'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    public function test1_ausfuehrung_option()
    {
        return $this->belongsTo(OptionAPDR1Test1Ausfuehrung::class, 'test1_ausfuehrung_id');
    }

    public function getTest1AusfuehrungAttribute()
    {
        return $this->test1_ausfuehrung_id ? ['name' => $this->test1_ausfuehrung_option->name, 'id' => $this->test1_ausfuehrung_id, 'wert' => $this->test1_ausfuehrung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function test2_ausfuehrung_option()
    {
        return $this->belongsTo(OptionAPDR1Test2Ausfuehrung::class, 'test2_ausfuehrung_id');
    }

    public function getTest2AusfuehrungAttribute()
    {
        return $this->test2_ausfuehrung_id ? ['name' => $this->test2_ausfuehrung_option->name, 'id' => $this->test2_ausfuehrung_id, 'wert' => $this->test2_ausfuehrung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function test3_ausfuehrung_option()
    {
        return $this->belongsTo(OptionAPDR1Test3Ausfuehrung::class, 'test3_ausfuehrung_id');
    }

    public function getTest3AusfuehrungAttribute()
    {
        return $this->test3_ausfuehrung_id ? ['name' => $this->test3_ausfuehrung_option->name, 'id' => $this->test3_ausfuehrung_id, 'wert' => $this->test3_ausfuehrung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function test4_ausfuehrung_option()
    {
        return $this->belongsTo(OptionAPDR1Test4Ausfuehrung::class, 'test4_ausfuehrung_id');
    }

    public function getTest4AusfuehrungAttribute()
    {
        return $this->test4_ausfuehrung_id ? ['name' => $this->test4_ausfuehrung_option->name, 'id' => $this->test4_ausfuehrung_id, 'wert' => $this->test4_ausfuehrung_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function ausschlussgrund_option()
    {
        return $this->belongsTo(OptionAPDR1Ausschlussgrund::class, 'ausschlussgrund_id');
    }

    public function getAusschlussgrundAttribute()
    {
        return $this->ausschlussgrund_id ? ['name' => $this->ausschlussgrund_option->name, 'id' => $this->ausschlussgrund_id, 'wert' => $this->ausschlussgrund_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
