<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infotexte extends Model
{
    use HasFactory;

    protected $table = 'infotexte';

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
        return $this->hasMany(InfotexteAssignable::class, 'infotexte_id');
    }

    protected static function booted()
    {
        static::saving(function ($infotexte) {
            if ($infotexte->section && $infotexte->thema) {
                $sectionName = $infotexte->section->name_kurz ?? 'unknown';
                $thema = strtolower($infotexte->thema);
                $thema = preg_replace('/[^a-z0-9]+/', '-', $thema);
                $thema = trim($thema, '-');
                $slugParts = [$sectionName, $thema];
                if (! empty($infotexte->position)) {
                    $position = strtolower($infotexte->position);
                    $position = preg_replace('/[^a-z0-9]+/', '-', $position);
                    $position = trim($position, '-');
                    $slugParts[] = $position;
                }
                $infotexte->slug = implode('-', $slugParts);
            }
        });
    }
}
