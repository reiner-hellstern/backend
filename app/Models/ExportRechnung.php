<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExportRechnung extends Pivot
{
    protected $table = 'rechnungsexport_rechnung';

    protected $fillable = [
        'rechnungsexport_id',
        'rechnung_id',
        'export_betrag',
        'export_typ',
    ];

    protected $casts = [
        'export_betrag' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Beziehung zum Export
     */
    public function export()
    {
        return $this->belongsTo(RechnungExport::class, 'rechnungsexport_id');
    }

    /**
     * Beziehung zur Rechnung
     */
    public function rechnung()
    {
        return $this->belongsTo(Rechnung::class, 'rechnung_id');
    }
}
