<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtzulassung extends Model
{
    use HasFactory;

    protected $table = 'zuchtzulassungen';

    protected $with = ['zuchttauglichkeit'];

    protected $appends = ['aktiv'];

    protected $guarded = [];

    public function beginn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function ende(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function zuchttauglichkeit()
    {
        return $this->belongsTo(OptionZuchttauglichkeit::class)->withDefault([
            'id' => 0,
            'name' => 'unbekannt',
        ]);
    }

    public function freigabe()
    {
        return $this->belongsTo(Person::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionZuchtzulassungStatus::class)->withDefault([
            'id' => 0,
            'name' => 'unbekannt',
        ]);
    }

    public function getAktivAttribute()
    {
        return $this->beginn < date('Y-m-d') && date('Y-m-d') < $this->ende ? true : false;
    }

    public function zuechter()
    {
        return $this->hasMany(Zuechter::class);
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
