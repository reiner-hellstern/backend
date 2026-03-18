<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoden extends Model
{
    use HasFactory;

    protected $table = 'hoden';

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

    public function quelle()
    {
        return $this->belongsTo(OptionHodenQuelle::class, 'quelle_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen']);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }
}
