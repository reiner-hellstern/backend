<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Zwinger extends Model
{
    use HasFactory;

    protected $table = 'zwinger';

    public $timestamps = false;

    protected $with = ['adresse'];

    protected $appends = [
        'profile_photo_url',
    ];

    public function zuchtstaetten()
    {
        return $this->hasMany(Zuchtstaette::class);
    }

    public function zuchtstaette()
    {
        return $this->hasMany(Zuchtstaette::class)->where('zuchtstaetten.aktiv', 1);
    }

    public function adresse()
    {
        return $this->hasMany(Zuchtstaette::class)->where('zuchtstaetten.aktiv', 1);
    }

    public function hunde()
    {
        return $this->belongsToMany(Hund::class, 'hund_zwinger')
            ->withPivot('von', 'bis', 'anmerkung', 'leihstellung_id', 'leihstellung')
            ->using(HundZwinger::class);
    }

    public function hundeInLeihstellung()
    {
        return $this->belongsToMany(Hund::class, 'hund_zwinger')
            ->withPivot('von', 'bis', 'anmerkung', 'leihstellung_id', 'leihstellung')
            ->using(HundZwinger::class)
            ->wherePivotNotNull('leihstellung_id')
            ->with(['pivot.leihstellung.dokumente']);
    }

    public function hundeMitLeihstellung()
    {
        return $this->belongsToMany(Hund::class, 'hund_zwinger')
            ->withPivot('von', 'bis', 'anmerkung', 'leihstellung_id', 'leihstellung')
            ->using(HundZwinger::class)
            ->with(['pivot.leihstellung.dokumente']);
    }

    public function getLeihstellungDokumenteAttribute()
    {
        return $this->leihstellung ? $this->leihstellung->dokumente : collect();
    }

    public function images()
    {
        //Method(commentable) from AllComment model
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    public function rassen()
    {
        return $this->belongsToMany(Rasse::class)->withPivot('wurfbuchstabe', 'aktiv');
    }

    /**
     * Alle Personen die diesem Zwinger zugeordnet sind (Many-to-Many)
     */
    public function personen()
    {
        return $this->belongsToMany(Person::class, 'person_zwinger')
            ->withPivot('von', 'bis', 'zwingername', 'leihstellung', 'anmerkung')
            ->withTimestamps()
            ->orderBy('von', 'desc');
    }

    /**
     * Aktuell verantwortliche Person für diesen Zwinger
     */
    public function aktuellePersonen()
    {
        return $this->belongsToMany(Person::class, 'person_zwinger')
            ->withPivot('von', 'bis', 'zwingername', 'leihstellung', 'anmerkung')
            ->withTimestamps()
            ->where('von', '<=', now())
            ->where(function ($query) {
                $query->whereNull('bis')
                    ->orWhere('bis', '>=', now());
            })
            ->orderBy('von', 'desc');
    }

    public function wuerfe()
    {
        return $this->hasMany(Wurf::class)->orderByDesc('wurfdatum')->orderByDesc('wurfbuchstabe');
    }

    public function wurfplaene()
    {
        return $this->hasMany(Wurfplan::class)->orderByDesc('geplant_von');
    }

    public function wurfabnahmen()
    {
        return $this->hasMany(Wurfabnahme::class);
    }

    public function vereinsstrafen()
    {
        return $this->morphToMany(Vereinsstrafe::class, 'vereinsstrafable')->orderBy('updated_at', 'asc');
    }

    public function zuchtverbote()
    {
        return $this->morphToMany(Zuchtverbot::class, 'zuchtverbotable')->orderBy('updated_at', 'asc');
    }

    public function zuechter()
    {
        return $this->hasMany(Zuechter::class);
    }

    // Alte hasMany-Relation entfernt - jetzt Many-to-Many über person_zwinger Pivot-Tabelle

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
           ? Storage::disk('public')->url($this->profile_photo)
           : '';
    }

    public function getGemeinschaftAttribute()
    {
        return $this->zuechter->count();
    }
}
