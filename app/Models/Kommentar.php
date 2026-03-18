<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kommentar extends Model
{
    use HasFactory;

    protected $table = 'kommentare';

    protected $appends = ['author', 'photo', 'erstellt_am', 'geaendert_am'];

    protected $hidden = ['user'];

    //     protected $dates = [
    //       'created_at',
    //       'updated_at',

    //   ];
    public function kommentarable()
    {
        return $this->morphTo();
    }

    //  protected function datum(): Attribute
    //  {
    //      return new Attribute(
    //        get: fn ($value) =>  ($value !== '0000-00-00' && $value !== '' && !is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
    //        set: fn ($value) =>  ($value !== '' && !is_null($value)) ? Carbon::parse($value)->format('Y-m-d'): '0000-00-00',
    //      );
    //  }

    public function getErstelltAmAttribute()
    {
        return ($this->created_at !== '0000-00-00' && $this->created_at !== '' && ! is_null($this->created_at)) ? ((Carbon::parse($this->created_at)->format('Y') == date('Y')) ? Carbon::parse($this->created_at)->format('d.m. H:i') : Carbon::parse($this->created_at)->format('d.m.y H:i')) : '';
    }

    public function getGeaendertAmAttribute()
    {
        return ($this->updated_at !== '0000-00-00' && $this->updated_at !== '' && ! is_null($this->updated_at)) ? ((Carbon::parse($this->updated_at)->format('Y') == date('Y')) ? Carbon::parse($this->updated_at)->format('d.m. H:i') : Carbon::parse($this->updated_at)->format('d.m.y H:i')) : '';
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     * Zeigt aktuelles Jahr als d.m. H:i, andere Jahre als d.m.y H:i
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ?
                ((Carbon::parse($value)->format('Y') == date('Y')) ?
                    Carbon::parse($value)->format('d.m. H:i') :
                    Carbon::parse($value)->format('d.m.y H:i')) : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     * Zeigt aktuelles Jahr als d.m. H:i, andere Jahre als d.m.y H:i
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ?
                ((Carbon::parse($value)->format('Y') == date('Y')) ?
                    Carbon::parse($value)->format('d.m. H:i') :
                    Carbon::parse($value)->format('d.m.y H:i')) : '',
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAuthorAttribute($date)
    {
        return $this->user->name;
    }

    public function getPhotoAttribute($date)
    {
        return $this->user->profile_photo_path
                      ? Storage::disk('public')->url($this->user->profile_photo_path)
                      : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
