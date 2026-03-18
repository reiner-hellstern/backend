<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dokument extends Model
{
    use HasFactory;

    protected $table = 'dokumente';

    protected $appends = ['stored_at', 'date'];

    protected $with = ['tags'];

    // protected $hidden = ['pivot'];

    protected $guarded = ['stored_at', 'created_at', 'updated_at'];

    public function tags()
    {

        return $this->belongsToMany(Tag::class, 'dokument_tag', 'dokument_id', 'tag_id')
            ->using(DokumentTag::class)
            ->withPivot('fixed')
            ->select('tags.name', 'tags.id')
            ->orderBy('tags.ebene');

        // return $this->belongsToMany(Tag::class, 'dokument_tag', 'dokument_id', 'tag_id');
    }

    protected function datum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function getDateAttribute()
    {
        return $this->createdAt;
    }

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? ((Carbon::parse($value)->format('Y') == date('Y')) ? Carbon::parse($value)->format('d.m. H:i') : Carbon::parse($value)->format('d.m.y H:i')) : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null
        );
    }

    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? ((Carbon::parse($value)->format('Y') == date('Y')) ? Carbon::parse($value)->format('d.m. H:i') : Carbon::parse($value)->format('d.m.y H:i')) : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStoredAtAttribute()
    {
        return Storage::disk('public')->url($this->path);
    }
}
