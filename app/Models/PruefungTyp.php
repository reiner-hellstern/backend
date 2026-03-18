<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruefungTyp extends Model
{
    use HasFactory;

    // protected $table = 'PruefungTypn';
    protected $table = 'pruefungen_typen_konverter';

    // protected $with = [ 'classements', 'wertungen', 'ausrichters', 'zusaetze' ];

    public function classements()
    {
        return $this->belongsToMany(PruefungClassement::class, 'pruefungen_typ_classement', 'pruefungtyp_id', 'classement_id');
    }

    public function wertungen()
    {
        return $this->belongsToMany(PruefungWertung::class, 'pruefungen_typ_wertung', 'pruefungtyp_id', 'wertung_id');
    }

    public function ausrichters()
    {
        return $this->belongsToMany(PruefungAusrichter::class, 'pruefungen_typ_ausrichter', 'pruefungtyp_id', 'ausrichter_id');
    }

    public function zusaetze()
    {
        return $this->belongsToMany(PruefungZusatz::class, 'pruefungen_typ_zusatz', 'pruefungtyp_id', 'zusatz_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'pruefungen_typ_tag', 'pruefungtyp_id', 'tag_id');
    }
}
