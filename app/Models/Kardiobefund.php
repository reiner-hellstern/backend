<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardiobefund extends Model
{
    use HasFactory;

    protected $table = 'kardiobefunde';

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function arzt()
    {
        return $this->belongsTo(Arzt::class, 'arzt_id');
    }

    public function diagnose()
    {
        return $this->belongsTo(OptionKardioBefund::class, 'diagnose_id');
    }

    public function untersuchungsmethode()
    {
        return $this->belongsTo(OptionKardioUntersuchungsart::class, 'labor_id');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
