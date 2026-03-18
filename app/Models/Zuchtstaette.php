<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zuchtstaette extends Model
{
    use HasFactory;

    protected $table = 'zuchtstaetten';

    protected $with = ['status'];

    protected $guarded = [];

    protected $casts = [
        'aktiv' => 'boolean',
        'standard' => 'boolean',
        'eignung_parallelwurf' => 'boolean',
    ];

    public function status()
    {
        return $this->belongsTo(OptionZuchtstaetteStatus::class)->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function zuchtstaetteable()
    {
        return $this->morphTo();
    }

    public function zuchtstaettenbesichtigungen()
    {
        return $this->hasMany(Zuchtstaettenbesichtigung::class);
    }

    public function zuchtstaettenmaengel()
    {
        return $this->hasMany(Zuchtstaettenmangel::class);
    }

    public function images()
    {
        //Method(commentable) from AllComment model
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function rassen()
    {
        return $this->belongsToMany(Rasse::class, 'rasse_zuchstaette')->withTimestamps();
    }
}
