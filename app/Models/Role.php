<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public function main_menu_items()
    {
        return $this->belongsToMany(MainMenuItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'assigned_roles', 'role_id', 'entity_id')
            ->where('entity_type', User::class);
    }
}
