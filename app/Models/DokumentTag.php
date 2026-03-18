<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DokumentTag extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $casts = [
        'fixed' => 'boolean',
    ];

    protected $hidden = [
        'dokument_id',
        'tag_id',
    ];
}
