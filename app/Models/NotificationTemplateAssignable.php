<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotificationTemplateAssignable extends Model
{
    use HasFactory;

    protected $table = 'notification_template_assignables';

    protected $fillable = [
        'notification_template_id',
        'assignable_id',
        'assignable_type',
    ];

    /**
     * Get the notification template that owns this assignment.
     */
    public function notificationTemplate(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class);
    }

    /**
     * Get the assignable model (polymorphic relation).
     */
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
