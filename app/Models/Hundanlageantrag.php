<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hundanlageantrag extends Model
{
    use HasFactory;

    protected $table = 'hundanlageantraege';

    protected $with = ['status', 'typ', 'dokumente', 'kommentare'];

    //   protected $fillable = [
    //      'hund_id',
    //      'antragsteller_id',
    //      'status_id',
    //      'eigentuemer_ids',
    //      'senden',
    //      'gesendet_am',
    //      'bezahlt',
    //      'angenommen',
    //      'abgelehnt',
    //      'bemerkung',
    //      'created_at',
    //      'updated_at',
    //     ];

    protected $casts = [
        'bezahlt' => 'boolean',
        'angenommen' => 'boolean',
        'abgelehnt' => 'boolean',
        'accessDRC_at' => 'datetime',
        'accessAntragsteller_at' => 'datetime',
    ];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('j.n.Y') . ' um ' . Carbon::parse($value)->format('H:i') . ' Uhr' : '',
        );
    }

    protected function sentAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('j.n.Y') . ' um ' . Carbon::parse($value)->format('H:i') . ' Uhr' : '',
        );
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

    public function bearbeiter()
    {
        return $this->belongsTo(User::class, 'bearbeiter_id');
    }

    public function personen()
    {
        return $this->belongsToMany(Person::class)->withPivot('seit', 'bis', 'anmerkung', 'freigabe_id')->using(HundPerson::class)->orderByRaw('-bis asc')->orderBy('seit', 'desc');
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class, 'hund_id');
    }

    public function typ()
    {
        return $this->belongsTo(HundanlageantragTyp::class, 'typ_id');
    }

    public function status()
    {
        return $this->belongsTo(OptionAntragStatus::class, 'status_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function kommentare()
    {
        return $this->morphMany(Kommentar::class, 'kommentarable');
    }
}
