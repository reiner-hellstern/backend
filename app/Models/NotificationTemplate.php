<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'thema',
        'position',
        'vue_komponente',
        'slug',
        'text',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the section that owns the notification template.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get all assigned roles for this notification template.
     */
    public function roles(): MorphToMany
    {
        return $this->morphedByMany(Role::class, 'assignable', 'notification_template_assignables');
    }

    /**
     * Get all assigned users for this notification template.
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'assignable', 'notification_template_assignables');
    }

    /**
     * Get all assignable objects (polymorphic relation)
     */
    public function assignables(): HasMany
    {
        return $this->hasMany(NotificationTemplateAssignable::class, 'notification_template_id');
    }

    /**
     * Assign a model to this notification template
     */
    public function assignTo(Model $model): void
    {
        $this->assignables()->firstOrCreate([
            'assignable_id' => $model->getKey(),
            'assignable_type' => get_class($model),
        ]);
    }

    /**
     * Remove assignment from this notification template
     */
    public function removeAssignment(Model $model): void
    {
        $this->assignables()
            ->where('assignable_id', $model->getKey())
            ->where('assignable_type', get_class($model))
            ->delete();
    }

    /**
     * Get all assigned objects by type
     */
    public function getAssignedByType(string $type): \Illuminate\Database\Eloquent\Collection
    {
        return $this->assignables()
            ->where('assignable_type', $type)
            ->with('assignable')
            ->get()
            ->pluck('assignable');
    }

    /**
     * Generate slug from section, thema and position
     */
    public function generateSlug(): string
    {
        $sectionName = $this->section->name_kurz ?? 'unknown';
        $thema = Str::slug($this->thema);
        $position = $this->position;

        return "{$sectionName}-{$thema}-{$position}";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = $template->generateSlug();
            }
        });

        static::updating(function ($template) {
            if ($template->isDirty(['section_id', 'thema', 'position'])) {
                $template->slug = $template->generateSlug();
            }
        });
    }

    /**
     * Get available data object types (Model names)
     */
    public static function getAvailableDataObjectTypes(): array
    {
        return [
            'User' => 'App\\Models\\User',
            'Person' => 'App\\Models\\Person',
            'Hund' => 'App\\Models\\Hund',
            'Mitglied' => 'App\\Models\\Mitglied',
            'Pruefung' => 'App\\Models\\Pruefung',
            'Veranstaltung' => 'App\\Models\\Veranstaltung',
            'Rechnung' => 'App\\Models\\Rechnung',
            'Wurf' => 'App\\Models\\Wurf',
            'Titel' => 'App\\Models\\Titel',
            'Zuchtstaette' => 'App\\Models\\Zuchtstaette',
        ];
    }

    /**
     * Get data object types stored in data field
     */
    public function getDataObjectTypesAttribute(): array
    {
        return $this->data['datenobjekt_types'] ?? [];
    }

    /**
     * Set data object types in data field
     */
    public function setDataObjectTypesAttribute(array $types): void
    {
        $data = $this->data ?? [];
        $data['datenobjekt_types'] = $types;
        $this->data = $data;
    }

    /**
     * Get user IDs stored in data field
     */
    public function getUserIdsAttribute(): array
    {
        return $this->data['user_ids'] ?? [];
    }

    /**
     * Set user IDs in data field
     */
    public function setUserIdsAttribute(array $userIds): void
    {
        $data = $this->data ?? [];
        $data['user_ids'] = $userIds;
        $this->data = $data;
    }
}
