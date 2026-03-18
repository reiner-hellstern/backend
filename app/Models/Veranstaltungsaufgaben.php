<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veranstaltungsaufgaben extends Model
{
    use HasFactory;

    protected $table = 'veranstaltung_aufgaben';

    // protected $appends = ['r1','r2','r3','r4','r5','r6','r7','r8','r9','r10','r11','r12'];

    //   public function r1_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r1_id');
    //   }
    //   public function getR1Attribute()
    //   {
    //     return $this->r1_id ? [ 'name' => $this->r1_option->nachname.', '.$this->r1_option->vorname, 'id' => $this->r1_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r2_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r2_id');
    //   }
    //   public function getR2Attribute()
    //   {
    //     return $this->r2_id ? [ 'name' => $this->r2_option->nachname.', '.$this->r2_option->vorname, 'id' => $this->r2_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r3_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r3_id');
    //   }
    //   public function getR3Attribute()
    //   {
    //     return $this->r3_id ? [ 'name' => $this->r3_option->nachname.', '.$this->r3_option->vorname, 'id' => $this->r3_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r4_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r4_id');
    //   }
    //   public function getR4Attribute()
    //   {
    //     return $this->r4_id ? [ 'name' => $this->r4_option->nachname.', '.$this->r4_option->vorname, 'id' => $this->r4_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r5_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r5_id');
    //   }
    //   public function getR5Attribute()
    //   {
    //     return $this->r5_id ? [ 'name' => $this->r5_option->nachname.', '.$this->r5_option->vorname, 'id' => $this->r5_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r6_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r6_id');
    //   }
    //   public function getR6Attribute()
    //   {
    //     return $this->r6_id ? [ 'name' => $this->r6_option->nachname.', '.$this->r6_option->vorname, 'id' => $this->r6_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r7_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r7_id');
    //   }
    //   public function getR7Attribute()
    //   {
    //     return $this->r7_id ? [ 'name' => $this->r7_option->nachname.', '.$this->r7_option->vorname, 'id' => $this->r7_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r8_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r8_id');
    //   }
    //   public function getR8Attribute()
    //   {
    //     return $this->r8_id ? [ 'name' => $this->r8_option->nachname.', '.$this->r8_option->vorname, 'id' => $this->r8_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r9_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r9_id');
    //   }
    //   public function getR9Attribute()
    //   {
    //     return $this->r9_id ? [ 'name' => $this->r9_option->nachname.', '.$this->r9_option->vorname, 'id' => $this->r9_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r10_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r10_id');
    //   }
    //   public function getR10Attribute()
    //   {
    //     return $this->r10_id ? [ 'name' => $this->r10_option->nachname.', '.$this->r10_option->vorname, 'id' => $this->r10_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r11_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r11_id');
    //   }
    //   public function getR11Attribute()
    //   {
    //     return $this->r11_id ? [ 'name' => $this->r11_option->nachname.', '.$this->r11_option->vorname, 'id' => $this->r11_id] : [  'name' =>'---', 'id' => 0 ];
    //   }
    //   public function r12_option()
    //   {
    //       return $this->belongsTo(Person::class, 'r12_id');
    //   }
    //   public function getR12Attribute()
    //   {
    //     return $this->r12_id ? [ 'name' => $this->r12_option->nachname.', '.$this->r12_option->vorname, 'id' => $this->r12_id] : [  'name' =>'---', 'id' => 0 ];
    //   }

}
