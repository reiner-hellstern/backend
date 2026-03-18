<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InfotexteAssignable extends Model
{
    use HasFactory;

    protected $table = 'infotexte_assignables';

    protected $fillable = [
        'infotexte_id',
        'assignable_type',
        'assignable_id',
    ];

    public function infotexte(): BelongsTo
    {
        return $this->belongsTo(Infotexte::class);
    }

    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
