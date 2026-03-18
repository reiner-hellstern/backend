<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kurz',
        'typ',
        'aktiv',
        'order',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    /**
     * Get the notification templates for this section.
     */
    public function notificationTemplates(): HasMany
    {
        return $this->hasMany(NotificationTemplate::class);
    }

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
