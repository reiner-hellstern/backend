<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMenuItem extends Model
{
    use HasFactory;

    protected $table = 'main_menu_items';

    public function gruppen()
    {
        return $this->belongsToMany(Gruppe::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function children()
    {
        return $this->hasMany(MainMenuItem::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(MainMenuItem::class, 'parent_id');
    }

    public function scopeAktiv(Builder $query): void
    {
        $query->where('aktiv', 1);
    }
}
