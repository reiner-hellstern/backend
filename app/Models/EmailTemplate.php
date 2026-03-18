<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'thema',
        'position',
        'vue_component',
        'slug',
        'file',
        'subject',
        'body',
        'aktiv',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    /**
     * Get the section that owns the email template.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the assignables for the email template.
     */
    public function assignables(): HasMany
    {
        return $this->hasMany(EmailTemplateAssignable::class, 'email_template_id');
    }

    /**
     * Generate slug before saving
     */
    protected static function booted()
    {
        static::saving(function ($emailTemplate) {
            if ($emailTemplate->section && $emailTemplate->thema) {
                $sectionName = $emailTemplate->section->name_kurz ?? 'unknown';
                $thema = strtolower($emailTemplate->thema);
                $thema = preg_replace('/[^a-z0-9]+/', '-', $thema);
                $thema = trim($thema, '-');

                $slugParts = [$sectionName, $thema];

                if (! empty($emailTemplate->position)) {
                    $position = strtolower($emailTemplate->position);
                    $position = preg_replace('/[^a-z0-9]+/', '-', $position);
                    $position = trim($position, '-');
                    $slugParts[] = $position;
                }

                $emailTemplate->slug = implode('-', $slugParts);
            }
        });
    }
}
