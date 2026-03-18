<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aufgabe extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'aufgaben';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'aufgaben_template_id',
        'beschreibung',
        'status_id',
        'log',
        'faelligkeit',
        'completed_id',
        'editor_id',
        'path',
        'sourceable_type',
        'sourceable_id',
        'completed_at',
    ];

    protected $with = ['status'];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        // 'faelligkeit' => 'date',
        // 'completed_at' => 'datetime',
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function completedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    protected function faelligkeit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Get the template that this task is based on.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(AufgabenTemplate::class, 'aufgaben_template_id');
    }

    /**
     * Get the status of this task.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OptionAufgabeStatus::class, 'status_id');
    }

    /**
     * Get the user who completed this task.
     */
    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_id');
    }

    /**
     * Get the user who is currently editing this task.
     */
    public function editedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Get all assigned users for this task.
     */
    public function zugeteilte(): HasMany
    {
        return $this->hasMany(AufgabenZugeteilte::class, 'aufgaben_id');
    }

    /**
     * Get the sourceable model (polymorphic relationship).
     */
    public function sourceable()
    {
        return $this->morphTo();
    }

    /**
     * Get users who are allowed to take over this task.
     * This comes from the template's uebernahmeberechtigte.
     */
    public function getUebernahmeberechtigteUsersAttribute()
    {
        if (! $this->template) {
            return collect();
        }

        $users = collect();

        // Get users directly assigned as uebernahmeberechtigte
        $directUsers = $this->template->uebernahmeberechtigte()
            ->where('assignable_type', User::class)
            ->with('assignable')
            ->get()
            ->pluck('assignable');

        // Get users from uebernahmeberechtigte roles via Bouncer
        $roleUsers = collect();

        // PERFORMANCE: Optimized - load all roles at once and use relationship
        // No Bouncer methods here to avoid performance issues
        $roleBerechtigungen = $this->template->uebernahmeberechtigte()
            ->where('assignable_type', Role::class)
            ->with('assignable.users') // Eager load roles with their users
            ->get()
            ->pluck('assignable');

        foreach ($roleBerechtigungen as $berechtigung) {
            if ($berechtigung->assignable) {
                // Use the custom users relationship from Role model
                $roleUsers = $roleUsers->merge($berechtigung->assignable->users);
            }
        }

        return $users->merge($directUsers)->merge($roleUsers)->unique('id');
    }

    /**
     * Check if a user can take over this task.
     */
    public function canUserTakeOver(User $user): bool
    {
        return $this->getUebernahmeberechtigteUsersAttribute()->contains('id', $user->id);
    }

    /**
     * Get the authorized groups/roles that can take over this task.
     * Returns the actual roles/groups, not individual users.
     */
    public function getUebernahmeberechtigteAttribute()
    {
        if (! $this->template) {
            return collect();
        }

        return $this->template->uebernahmeberechtigte->map(function ($berechtigung) {
            if ($berechtigung->assignable_type === 'App\\Models\\Role') {
                return [
                    'type' => 'rolle',
                    'id' => $berechtigung->assignable_id,
                    'name' => $berechtigung->assignable->title ?? 'Unbekannte Rolle',
                ];
            } elseif ($berechtigung->assignable_type === 'App\\Models\\PersonRole') {
                return [
                    'type' => 'person_role',
                    'id' => $berechtigung->assignable_id,
                    'name' => $berechtigung->assignable->name ?? 'Unbekannte PersonRole',
                ];
            } elseif ($berechtigung->assignable_type === 'App\\Models\\User') {
                return [
                    'type' => 'user',
                    'id' => $berechtigung->assignable_id,
                    'name' => $berechtigung->assignable->name ?? 'Unbekannter User',
                ];
            }

            return null;
        })->filter()->values();
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    /**
     * Scope for filtering by template.
     */
    public function scopeByTemplate($query, $templateId)
    {
        return $query->where('aufgaben_template_id', $templateId);
    }

    /**
     * Scope for overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('faelligkeit', '<', now())
            ->whereNotIn('status_id', [3]); // Assuming 3 is "abgeschlossen"
    }

    /**
     * Assign users from template when creating task from template.
     */
    public function assignUsersFromTemplate(): void
    {
        if (! $this->template) {
            return;
        }

        // Get all users that should be assigned from template
        $usersToAssign = collect();

        foreach ($this->template->zugeteilte as $zuteilung) {
            if ($zuteilung->assignable_type === 'App\\Models\\Role') {
                // Add users from role via Bouncer
                $role = $zuteilung->assignable;
                if ($role) {
                    $usersWithRole = User::whereIs($role->name)->get();
                    $usersToAssign = $usersToAssign->merge($usersWithRole);
                }
            } elseif ($zuteilung->assignable_type === 'App\\Models\\User') {
                // Add user directly
                $user = $zuteilung->assignable;
                if ($user) {
                    $usersToAssign->push($user);
                }
            }
            // Note: PersonRoles don't have direct users, they are organizational units
        }

        // Assign unique users using the simplified structure
        $userIds = $usersToAssign->pluck('id')->unique();
        foreach ($userIds as $userId) {
            AufgabenZugeteilte::firstOrCreate([
                'aufgaben_id' => $this->id,
                'user_id' => $userId,
            ]);
        }
    }
}
