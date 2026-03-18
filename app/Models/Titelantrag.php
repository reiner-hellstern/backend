<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titelantrag extends Model
{
    use HasFactory;

    protected $table = 'titelantraege';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function typ_option()
    {
        return $this->belongsTo(TitelTyp::class, 'type_id');
    }

    public function getTypAttribute()
    {
        return $this->typ_id ? ['name' => $this->typ_option->name, 'id' => $this->typ_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }
}
