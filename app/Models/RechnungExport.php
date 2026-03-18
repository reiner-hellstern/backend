<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechnungExport extends Model
{
    use HasFactory;

    protected $table = 'rechnungexports';

    protected $fillable = [
        'titel',
        'format',
        'anzahl_rechnungen',
        'gesamtbetrag',
        'status',
        'von_rechnungsnummer',
        'bis_rechnungsnummer',
        'dta_datei_pfad',
        'csv_datei_pfad',
        'bank_uebertragen_am',
        'bank_uebertragen_von',
        'erstellt_von',
    ];

    protected $casts = [
        'gesamtbetrag' => 'decimal:2',
        'bank_uebertragen_am' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'status_text',
        'erstellt_am_deutsch',
        'bank_uebertragen_am_deutsch',
    ];

    /**
     * Beziehung zu dem Benutzer, der den Export erstellt hat
     */
    public function ersteller()
    {
        return $this->belongsTo(User::class, 'erstellt_von');
    }

    /**
     * Beziehung zu dem Benutzer, der den Export übertragen hat
     */
    public function uebertragender()
    {
        return $this->belongsTo(User::class, 'uebertragen_von');
    }

    /**
     * Beziehung zu den exportierten Rechnungen über Pivot-Tabelle
     */
    public function rechnungen()
    {
        return $this->belongsToMany(Rechnung::class, 'rechnungexport_rechnung', 'rechnungexport_id', 'rechnung_id')
            ->withPivot(['export_betrag', 'export_typ'])
            ->withTimestamps();
    }

    /**
     * Status als deutsches Wort
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'erstellt' => 'Erstellt',
            'uebertragen' => 'Übertragen',
            'storniert' => 'Storniert',
            default => 'Unbekannt'
        };
    }

    /**
     * Erstellt-Datum in deutschem Format
     */
    public function getErstelltAmDeutschAttribute()
    {
        return $this->created_at ? $this->created_at->format('d.m.Y H:i') : null;
    }

    /**
     * Bank-Übertragen-Datum in deutschem Format
     */
    public function getBankUebertragenAmDeutschAttribute()
    {
        return $this->bank_uebertragen_am ? $this->bank_uebertragen_am->format('d.m.Y') : null;
    }

    /**
     * Prüfen ob Export bereits übertragen wurde
     */
    public function isUebertragen()
    {
        return $this->status === 'uebertragen';
    }

    /**
     * Prüfen ob DTA-Datei vorhanden ist
     */
    public function hasDtaFile()
    {
        return ! empty($this->dta_datei_pfad);
    }

    /**
     * Prüfen ob CSV-Datei vorhanden ist
     */
    public function hasCsvFile()
    {
        return ! empty($this->csv_datei_pfad);
    }
}
