<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WurfClean extends Model
{
    use HasFactory;

    protected $table = 'wuerfe';
    //  protected $with = ['zuchthuendin', 'deckruede', 'deckrueden', 'zwinger', 'zuechter', 'rasse', 'welpen', 'zuchtwart', 'images'];

    //     protected $casts = [
    //       'wurfdatum' => 'datetime:d.m.Y',
    //   ];

    /**
     * Carbon-Caster für wurfdatum Feld (Datum)
     */
    protected function wurfdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für deckdatum Feld (Datum)
     */
    protected function deckdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für vermitteln_bis Feld (Datum)
     */
    protected function vermittelnBis(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für wurfabnahme_am Feld (Datum)
     */
    protected function wurfabnahmeAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    public function zwinger()
    {
        return $this->belongsTo(Zwinger::class);
    }

    public function zuchthuendin()
    {
        return $this->belongsTo(Hund::class, 'mutter_id');
    }

    public function deckruede()
    {
        return $this->belongsTo(Hund::class, 'vater_id');
    }

    public function deckrueden()
    {
        return $this->belongsToMany(Deckruede::class);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function welpen()
    {
        return $this->hasMany(Welpe::class);
    }

    public function vater()
    {
        return $this->belongsTo(Hund::class);
    }

    public function mutter()
    {
        return $this->belongsTo(Hund::class);
    }

    public function zuechter()
    {
        return $this->belongsTo(Person::class);
    }

    public function hunde()
    {
        return $this->hasMany(Hund::class);
    }

    public function rasse()
    {
        return $this->belongsTo(Rasse::class);
    }

    public function zuchtwart()
    {
        return $this->belongsTo(Zuchtwart::class);
    }

    public function images()
    {
        //Method(commentable) from AllComment model
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    //  public function mutter()
    //  {
    //      $id = $this->mutter_id;
    //      $hund = Hund::find($id);
    //      return $hund;
    //  }

    //  public function vater()
    //  {
    //      $id = $this->vater_id;
    //      $hund = Hund::find($id);
    //      return $hund;
    //  }
}
