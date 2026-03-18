<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gruppe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gruppenable_id',
        'gruppenable_type',
        'vorstand1_id',
        'vorstand1_email',
        'vorstand2_id',
        'vorstand2_email',
        'kassenwart_id',
        'kassenwart_email',
        'schriftfuehrer_id',
        'schriftfuehrer_email',
        'pressewart_id',
        'pressewart_email',
        'strasse',
        'postleitzahl',
        'ort',
        'website',
        'email',
        'telefon',
        'parent_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'gruppen';

    public function gruppenable()
    {
        return $this->morphTo();
    }

    public function vorstand1()
    {
        return $this->belongsTo(Person::class, 'vorstand1_id');
    }

    public function vorstand2()
    {
        return $this->belongsTo(Person::class, 'vorstand2_id');
    }

    public function kassenwart()
    {
        return $this->belongsTo(Person::class, 'kassenwart_id');
    }

    public function schriftfuehrer()
    {
        return $this->belongsTo(Person::class, 'schriftfuehrer_id');
    }

    public function pressewart()
    {
        return $this->belongsTo(Person::class, 'pressewart_id');
    }

    public function mitglieder()
    {
        // Direkte Relationship zu Mitgliedern über eine Pivot-Tabelle
        // oder Mitglieder basierend auf dem Typ der Gruppe
        return $this->hasMany(Mitglied::class, $this->getMitgliederForeignKey());
    }

    /**
     * Get the foreign key for mitglieder based on group type
     */
    private function getMitgliederForeignKey()
    {
        switch (class_basename($this->gruppenable_type)) {
            case 'Bund':
                // Für Bund nehmen wir alle Mitglieder (keine direkte FK)
                return 'id'; // Fallback

            case 'Landesgruppe':
                return 'landesgruppe_id';

            case 'Bezirksgruppe':
                return 'bezirksgruppe_id';

            default:
                return 'id'; // Fallback
        }
    }

    public function rechnungen()
    {
        return $this->hasMany(Rechnung::class, 'rechnungssteller_id');
    }

    public function bankverbindungen()
    {
        return $this->morphMany(Bankverbindung::class, 'bankverbindungable')
            ->orderBy('gueltig_ab', 'desc');
    }

    /**
     * Aktuelle gültige Bankverbindung
     */
    public function bankverbindung()
    {
        return $this->morphOne(Bankverbindung::class, 'bankverbindungable')
            ->where('gueltig_ab', '<=', now())
            ->where(function ($query) {
                $query->whereNull('gueltig_bis')
                    ->orWhere('gueltig_bis', '>=', now());
            })
            ->orderBy('gueltig_ab', 'desc');
    }

    // Anzahl Mitglieder
    public function getMitgliederCountAttribute()
    {
        if (! $this->gruppenable_id || ! $this->gruppenable_type) {
            return 0;
        }

        // Je nach Gruppe-Typ verschiedene Zählungen
        switch (class_basename($this->gruppenable_type)) {
            case 'Bund':
                // Alle aktiven Mitglieder
                return \DB::table('mitglieder')
                    ->where(function ($query) {
                        $query->whereNull('datum_austritt')
                            ->orWhere('datum_austritt', '0000-00-00');
                    })
                    ->count();

            case 'Landesgruppe':
                // Mitglieder dieser Landesgruppe
                return \DB::table('mitglieder')
                    ->where('landesgruppe_id', $this->gruppenable_id)
                    ->where(function ($query) {
                        $query->whereNull('datum_austritt')
                            ->orWhere('datum_austritt', '0000-00-00');
                    })
                    ->count();

            case 'Bezirksgruppe':
                // Mitglieder dieser Bezirksgruppe
                return \DB::table('mitglieder')
                    ->where('bezirksgruppe_id', $this->gruppenable_id)
                    ->where(function ($query) {
                        $query->whereNull('datum_austritt')
                            ->orWhere('datum_austritt', '0000-00-00');
                    })
                    ->count();

            default:
                return 0;
        }
    }

    // Anzahl Bezirksgruppen (nur für Landesgruppen)
    public function getBezirksgruppenCountAttribute()
    {
        if (class_basename($this->gruppenable_type) === 'Landesgruppe') {
            return \DB::table('bezirksgruppen')
                ->where('landesgruppe_id', $this->gruppenable_id)
                ->count();
        }

        return 0;
    }

    // Zugehörige Landesgruppe (nur für Bezirksgruppen)
    public function getZugehoerigelandesgruppeAttribute()
    {
        if (class_basename($this->gruppenable_type) === 'Bezirksgruppe') {
            $bezirksgruppe = \DB::table('bezirksgruppen')
                ->where('id', $this->gruppenable_id)
                ->first();

            if ($bezirksgruppe && $bezirksgruppe->landesgruppe_id) {
                $landesgruppe = \DB::table('landesgruppen')
                    ->where('id', $bezirksgruppe->landesgruppe_id)
                    ->first();

                return $landesgruppe ? $landesgruppe->name : 'N/A';
            }
        }

        return null;
    }
}
