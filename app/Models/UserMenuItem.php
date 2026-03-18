<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuItem extends Model
{
    use HasFactory;

    protected $table = 'user_menu_items';

    public function gruppen()
    {
        return $this->belongsToMany(Gruppe::class);
    }

    public function scopeAktiv(Builder $query): void
    {
        $query->where('aktiv', true);
    }
}
