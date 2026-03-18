<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgatreeItem extends Model
{
    use HasFactory;

    protected $table = 'orgatree_items';

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }
}
