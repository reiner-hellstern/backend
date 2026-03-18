<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtzulassungsantrag extends Model
{
    use HasFactory;

    protected $table = 'zuchtzulassungsantraege';

    protected $appends = [];

    protected $guarded = [];

    protected $with = ['status'];

    protected $casts = [
        'bezahlt' => 'boolean',
        'angenommen' => 'boolean',
        'abgelehnt' => 'boolean',
    ];

    protected function sentAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('j.n.Y') . ' um ' . Carbon::parse($value)->format('H:i') . ' Uhr' : '',
        );
    }

    public function gestelltAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function freigabeAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function abgelehntAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function bestaetigungen()
    {

        return $this->morphMany(Bestaetigung::class, 'bestaetigungable');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')
            ->withPivot('status')
            ->orderBy('updated_at', 'asc');
    }

    public function antragsteller()
    {
        return $this->belongsTo(Person::class, 'antragsteller_id');
    }

    public function eigentuemer()
    {
        return $this->belongsToMany(Person::class, 'bestaetigungen', 'bestaetigungable_id', 'person_id');
    }

    public function personen()
    {
        return $this->belongsToMany(Person::class)->withPivot('seit', 'bis', 'anmerkung', 'freigabe_id')->using(HundPerson::class)->orderByRaw('-bis asc')->orderBy('seit', 'desc');
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id');
    }

    public function status()
    {
        return $this->belongsTo(OptionAntragStatus::class, 'status_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }
}
