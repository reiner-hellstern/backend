<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitelTyp extends Model
{
    use HasFactory;

    protected $table = 'titel_typen_konverter';

    public function ausrichters()
    {
        return $this->hasMany(TitelAusrichter::class, 'titeltyp_parent_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'titels_typ_tag', 'titeltyp_id', 'tag_id');
    }
}
