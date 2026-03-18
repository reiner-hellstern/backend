<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AufgabenTemplate extends Model
{
    use HasFactory;

    protected $table = 'aufgaben_templates';

    protected $fillable = [
        'thema',
        'name',
        'beschreibung',
        'slug',
        'path',
        'section_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($aufgabenTemplate) {
            $aufgabenTemplate->slug = Str::slug($aufgabenTemplate->thema . ' ' . $aufgabenTemplate->name);
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function zugeteilte(): HasMany
    {
        return $this->hasMany(AufgabenTemplateZugeteilte::class);
    }

    public function uebernahmeberechtigte(): HasMany
    {
        return $this->hasMany(AufgabenTemplateUebernahmeberechtigte::class);
    }

    public function aufgaben(): HasMany
    {
        return $this->hasMany(Aufgabe::class, 'aufgaben_template_id');
    }
}
