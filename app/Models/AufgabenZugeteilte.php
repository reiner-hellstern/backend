<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AufgabenZugeteilte extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'aufgaben_zugeteilte';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'aufgaben_id',
        'user_id',
    ];

    /**
     * Get the task that this assignment belongs to.
     */
    public function aufgabe(): BelongsTo
    {
        return $this->belongsTo(Aufgabe::class, 'aufgaben_id');
    }

    /**
     * Get the user assigned to this task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
