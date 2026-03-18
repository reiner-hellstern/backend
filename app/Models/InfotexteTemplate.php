<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfotexteTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'thema',
        'position',
        'vue_component',
        'slug',
        'titel',
        'text',
        'aktiv',
    ];

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function assignables(): HasMany
    {
        return $this->hasMany(InfotexteTemplateAssignable::class, 'infotexte_template_id');
    }

    protected static function booted()
    {
        static::saving(function ($infotexteTemplate) {
            if ($infotexteTemplate->section && $infotexteTemplate->thema) {
                $sectionName = $infotexteTemplate->section->name_kurz ?? 'unknown';
                $thema = strtolower($infotexteTemplate->thema);
                $thema = preg_replace('/[^a-z0-9]+/', '-', $thema);
                $thema = trim($thema, '-');
                $slugParts = [$sectionName, $thema];
                if (! empty($infotexteTemplate->position)) {
                    $position = strtolower($infotexteTemplate->position);
                    $position = preg_replace('/[^a-z0-9]+/', '-', $position);
                    $position = trim($position, '-');
                    $slugParts[] = $position;
                }
                $infotexteTemplate->slug = implode('-', $slugParts);
            }
        });
    }
}
