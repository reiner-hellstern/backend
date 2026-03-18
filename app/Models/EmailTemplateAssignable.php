<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailTemplateAssignable extends Model
{
    use HasFactory;

    protected $table = 'email_template_assignables';

    protected $fillable = [
        'email_template_id',
        'assignable_type',
        'assignable_id',
    ];

    /**
     * Get the email template that owns the assignable.
     */
    public function emailTemplate(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    /**
     * Get the assignable model (Role or Person).
     */
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
