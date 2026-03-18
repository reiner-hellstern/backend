<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Silber\Bouncer\Database\Role;

class Dokumentenkategorie extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'dokumentenkategorien';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'beschreibung',
        'reihenfolge',
        'aktiv',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'aktiv' => 'boolean',
        'reihenfolge' => 'integer',
    ];

    /**
     * Default values for attributes.
     */
    protected $attributes = [
        'aktiv' => true,
        'reihenfolge' => 0,
    ];

    protected $with = ['dokumente'];

    /**
     * Get the roles that have access to this document group.
     */
    public function assignedRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'dokumentenkategorie_roles', 'dokumentenkategorie_id', 'role_id');
    }

    /**
     * Get the documents in this group.
     */
    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable'); // ->orderBy('order', 'desc');
    }

    /**
     * Get the count of documents in this group.
     */
    public function getDokumenteCountAttribute(): int
    {
        return $this->dokumente()->count();
    }

    /**
     * Scope to get only active document groups.
     */
    public function scopeActive($query)
    {
        return $query->where('aktiv', true);
    }

    /**
     * Scope to order by reihenfolge.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('reihenfolge');
    }
}
