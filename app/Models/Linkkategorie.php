<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Linkkategorie extends Model
{
    use HasFactory;

    protected $table = 'linkkategorien';

    protected $fillable = [
        'name',
        'name_kurz',
        'aktiv',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'order' => 'integer',
    ];

    protected $attributes = [
        'aktiv' => true,
        'order' => 0,
    ];

    /**
     * Get the links for the category.
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class, 'linkkategorie_id')->ordered();
    }

    /**
     * Get only active links for the category.
     */
    public function activeLinks(): HasMany
    {
        return $this->links()->where('aktiv', true);
    }

    /**
     * Get the count of links in this category.
     */
    public function getLinksCountAttribute(): int
    {
        return $this->links()->count();
    }

    /**
     * Scope to get only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope to order by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
