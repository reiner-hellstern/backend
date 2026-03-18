<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pruefung extends Model
{
    use HasFactory;

    protected $table = 'pruefungen';

    protected $with = ['classement', 'ausrichter', 'wertung', 'zusatz', 'status', 'type'];

    protected $appends = [];

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function resultable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(PruefungTyp::class, 'type_id');
    }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltungen::class, 'veranstaltung_id');
    }

    public function classement()
    {
        return $this->belongsTo(PruefungClassement::class, 'classement_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'name_kurz' => '', 'id' => 0]);
    }

    // public function getClassementAttribute()
    // {
    //    return $this->classement_id ? [ 'name' => $this->classement_option->name, 'id' => $this->classement_id, 'wert' => $this->classement_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    // }

    public function ausrichter()
    {
        return $this->belongsTo(PruefungAusrichter::class, 'ausrichter_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'name_kurz' => '', 'id' => 0]);
    }

    public function wertung()
    {
        return $this->belongsTo(PruefungWertung::class, 'wertung_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'name_kurz' => '',  'id' => 0]);
    }

    // public function getWertungAttribute()
    // {
    //    return $this->wertung_id ? [ 'name' => $this->wertung_option->name, 'id' => $this->wertung_id, 'wert' => $this->wertung_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    // }

    public function zusatz()
    {
        return $this->belongsTo(PruefungZusatz::class, 'zusatz_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'name_kurz' => '', 'id' => 0]);
    }

    // public function getZusatzAttribute()
    // {
    //    return $this->zusatz_id ? [ 'name' => $this->zusatz_option->name, 'id' => $this->zusatz_id, 'wert' => $this->zusatz_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    // }

    public function status()
    {
        return $this->belongsTo(OptionPruefungStatus::class, 'status_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0]);
    }

    // public function getStatusAttribute()
    // {
    //    return $this->status_id ? [ 'name' => $this->status_option->name, 'id' => $this->status_id, 'wert' => $this->status_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
