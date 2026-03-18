<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links';

    protected $fillable = [
        'linkkategorie_id',
        'name',
        'url',
        'beschreibung',
        'aktiv',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
        'fassung_vom' => 'date',
    ];

    protected $attributes = [
        'aktiv' => true,
    ];

    /**
     * Get the category that owns the link.
     */
    public function kategorie(): BelongsTo
    {
        return $this->belongsTo(Linkkategorie::class, 'linkkategorie_id');
    }

    /**
     * Scope to get only active links.
     */
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope to get links ordered by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
