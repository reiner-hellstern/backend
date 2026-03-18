<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Notiz extends Model
{
    use HasFactory;

    protected $table = 'notizen';

    protected $appends = ['author', 'photo'];

    protected $hidden = ['user'];

    //     protected $dates = [
    //       'created_at',
    //       'updated_at',

    //   ];
    public function notizable()
    {
        return $this->morphTo();
    }

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : '0000-00-00',
        );
    }

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? ((Carbon::parse($value)->format('Y') == date('Y')) ? Carbon::parse($value)->format('d.m. H:i') : Carbon::parse($value)->format('d.m.y H:i')) : '',
        );

    }

    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? ((Carbon::parse($value)->format('Y') == date('Y')) ? Carbon::parse($value)->format('d.m. H:i') : Carbon::parse($value)->format('d.m.y H:i')) : '',
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
