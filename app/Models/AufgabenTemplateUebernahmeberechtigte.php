<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AufgabenTemplateUebernahmeberechtigte extends Model
{
    use HasFactory;

    protected $table = 'aufgaben_template_uebernahmeberechtigte';

    protected $fillable = [
        'aufgaben_template_id',
        'assignable_type',
        'assignable_id',
    ];

    public function aufgabenTemplate(): BelongsTo
    {
        return $this->belongsTo(AufgabenTemplate::class);
    }

    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
