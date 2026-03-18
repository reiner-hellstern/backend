<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahnentafel extends Model
{
    use HasFactory;

    protected $table = 'ahnentafeln';

    protected $fillable = [
        'typ_id',
        'hund_id',
        'antragsteller_id',
        'beantragt_am',
        'ausgestellt_am',
        'standort_id',
        'status_id',
        'gebuehr',
        'kostenpflichtig',
        'anmerkung',
        'grund',
    ];

    protected $with = ['typ', 'status', 'standort', 'dokumente'];

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    //  public function typ()
    //  {
    //     return $this->belongsTo(PruefungTyp::class, 'type_id')->withDefault([
    //        'name' => $this->name,
    //        'name_kurz' => ''
    //    ]);
    //  }

    protected function ausgestelltAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function beantragtAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function typ()
    {
        return $this->belongsTo(OptionATTyp::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function standort()
    {
        return $this->belongsTo(OptionATStandort::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function status()
    {
        return $this->belongsTo(OptionATStatus::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function bezahlart()
    {
        return $this->belongsTo(OptionBezahlart::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function bezahlstatus()
    {
        return $this->belongsTo(OptionBezahlstatus::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
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

    public function kommentare()
    {
        return $this->morphMany(Kommentar::class, 'kommentarable');
    }
}
