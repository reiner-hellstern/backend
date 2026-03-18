<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $appends = ['fixed'];

    // protected $hidden = ['pivot'];
    public function dokumente()
    {
        return $this->belongsToMany(Dokument::class, 'dokument_tag', 'tag_id', 'dokument_id')->withPivot('fixed');
    }

    public function getFixedAttribute()
    {
        return isset($this->pivot) ? ($this->pivot->fixed ? true : false) : false;
    }
}
