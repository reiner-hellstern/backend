<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titel extends Model
{
    use HasFactory;

    protected $table = 'titels';

    protected $appends = ['titel_name'];

    protected $with = ['ausrichter', 'status', 'anwartschaften'];

    public function getDatumAttribute($value)
    {
        return ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y') : '';
    }

    public function setDatumAttribute($value)
    {
        $this->attributes['datum'] = (new Carbon($value))->format('Y-m-d');
    }

    public function getTitelNameAttribute($value)
    {
        return $this->type_id ? $this->type->name : '';
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function anwartschaften()
    {
        return $this->hasMany(Anwartschaft::class)->orderBy('updated_at', 'asc');
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function type()
    {
        return $this->belongsTo(TitelTyp::class, 'type_id')->withDefault([
            'name' => $this->name,
            'name_kurz' => '',
        ]);
    }

    public function status()
    {
        return $this->belongsTo(OptionTitelStatus::class, 'status_id')->withDefault(
            ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0]
        );
    }

    // public function getStatusAttribute()
    // {
    //    return $this->status_id ? [ 'name' => $this->status_option->name, 'id' => $this->status_id, 'wert' => $this->status_option->wert ] : [  'wert' => 0, 'name' =>'Bitte auswählen', 'id' => 0 ];
    //  }

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltungen::class, 'veranstaltung_id');
    }

    public function ausrichter()
    {
        return $this->belongsTo(TitelAusrichter::class, 'ausrichter_id')->withDefault(['wert' => 0, 'name' => 'Bitte auswählen', 'name_kurz' => '', 'id' => 0]);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }
}
