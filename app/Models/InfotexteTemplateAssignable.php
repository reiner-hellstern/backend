<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InfotexteTemplateAssignable extends Model
{
    use HasFactory;

    protected $table = 'infotexte_template_assignables';

    protected $fillable = [
        'infotexte_template_id',
        'assignable_type',
        'assignable_id',
    ];

    public function infotexteTemplate(): BelongsTo
    {
        return $this->belongsTo(InfotexteTemplate::class);
    }

    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
