<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verstorbene extends Model
{
    use HasFactory;

    protected $table = 'verstorbene';

    protected $fillable = [
        'hund_id',
        'verstorben_am',
        'todesursache',
        'todesursache_id',
        'verstorben',
        'todesursache_text',
        'welpenalter',
        'einschlaeferung',
        'arzt_id',
    ];

    protected $casts = [
        'verstorben' => 'boolean',
        'welpenalter' => 'boolean',
        'einschlaeferung' => 'boolean',
    ];

    public function verstorbenAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function todesursache()
    {
        return $this->belongsTo(OptionTodesursache::class, 'todesursache_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function arzt()
    {
        return $this->belongsTo(Person::class, 'arzt_id', 'id')->withDefault([
            'id' => 0,
            'vorname' => '',
            'nachname' => '',
            'titel' => '',
            'praxisname' => '',
            'adresszusatz' => '',
            'strasse' => '',
            'postleitzahl' => '',
            'ort' => '',
            'land' => '',
            'telefon_1' => '',
            'telefon_2' => '',
            'mobil' => '',
            'email_1' => '',
            'email_2' => '',
            'webseite_1' => '',
            'webseite_2' => '',
        ]);
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id', 'id');
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
