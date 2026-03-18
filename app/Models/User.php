<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasFactory, HasRolesAndAbilities, Notifiable;

    protected $with = ['cache_versions_user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'person_id',
        'aktiv',
        'lastlogin_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'aktiv' => 'boolean',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function lastloginAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    public function emailVerifiedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    public function deactivatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
                    ? Storage::disk('public')->url($this->profile_photo_path)
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

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function cache_versions_user()
    {
        return $this->hasOne(CacheVersionsUser::class);
    }

    public function aufgaben()
    {
        return $this->belongsToMany(Aufgabe::class, 'aufgaben_zugeteilte', 'user_id', 'aufgaben_id');
    }

    public function offeneAufgaben()
    {
        return $this->belongsToMany(Aufgabe::class, 'aufgaben_zugeteilte', 'user_id', 'aufgaben_id')
            ->whereNull('completed_at');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id')->orderBy('created_at', 'desc');
    }

    public function ungeleseneNotifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id')->where('read_at', null)->orderBy('created_at', 'desc');
    }
}
