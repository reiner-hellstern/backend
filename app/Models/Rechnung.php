<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rechnung extends Model
{
    use HasFactory;

    protected $table = 'rechnungen';

    protected $fillable = [
        'name',
        'rechnungsnummer',
        'kreditor_id',
        'empfaenger_id',
        'sourceable_id',
        'sourceable_type',
        'edit_to',
        'export_id',
        'dta_id',
        'bezahlart_id',
        'bezahlstatus_id',
        'rechungssteller_id',
        'bankverbindung_id',

        // Rechnungsadresse (statisch)
        'rechnung_name',
        'rechnung_adresszusatz',
        'rechnung_strasse',
        'rechnung_postleitzahl',
        'rechnung_ort',

        // Datum- und Betragsfelder
        'rechnungsdatum',
        'rechnungssumme',
        'faelligkeit',
        'buchungsdatum',
        'geldeingang',
        'offen',

        // Mahnungen
        'erste_mahnung_am',
        'zweite_mahnung_am',
        'dritte_mahnung_am',

        // Storno
        'storno_am',
        'storno_id',

        // Anmerkungen
        'anmerkungen',

        // SEPA/Zahlungsverkehr
        'auftraggeber_bankname',
        'auftraggeber_iban',
        'auftraggeber_bic',
        'verwendungszweck',
        'auftraggeber_mandatsreferenz',
        'sepa_transaktions_id',
        'sepa_reason_code',
        'ruecklastschrift',
        'waehrung',
    ];

    protected $casts = [
        'rechnungsdatum' => 'date',
        'faelligkeit' => 'date',
        'buchungsdatum' => 'date',
        'erste_mahnung_am' => 'date',
        'zweite_mahnung_am' => 'date',
        'dritte_mahnung_am' => 'date',
        'storno_am' => 'date',
        'ruecklastschrift' => 'boolean',
        'rechnungssumme' => 'decimal:2',
        'geldeingang' => 'decimal:2',
        'offen' => 'decimal:2',
    ];

    /**
     * Carbon-Caster für rechnungsdatum Feld (Datum)
     */
    protected function rechnungsdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für faelligkeit Feld (Datum)
     */
    protected function faelligkeit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für buchungsdatum Feld (Datum)
     */
    protected function buchungsdatum(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für erste_mahnung_am Feld (Datum)
     */
    protected function ersteMahnungAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für zweite_mahnung_am Feld (Datum)
     */
    protected function zweiteMahnungAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für dritte_mahnung_am Feld (Datum)
     */
    protected function dritteMahnungAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für erste_mahnung_am Feld (Datum)
     */
    protected function ruecklastschriftAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für storniert_am Feld (Datum)
     */
    protected function storniertAm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Carbon-Caster für created_at Feld (Timestamp)
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    /**
     * Carbon-Caster für updated_at Feld (Timestamp)
     */
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y H:i') : '',
        );
    }

    // Relationships
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function kreditor()
    {
        return $this->belongsTo(Person::class, 'kreditor_id', 'id');
    }

    public function rechnungsposten()
    {
        return $this->hasMany(Rechnungsposten::class, 'rechnung_id', 'id');
    }

    public function empfaenger()
    {
        return $this->belongsTo(Person::class, 'empfaenger_id', 'id');
    }

    public function rechnungssteller()
    {
        return $this->belongsTo(Gruppe::class, 'rechungssteller_id', 'id');
    }

    public function bankverbindung()
    {
        return $this->belongsTo(Bankverbindung::class, 'bankverbindung_id', 'id');
    }

    public function bezahlart()
    {
        return $this->belongsTo(OptionBezahlart::class, 'bezahlart_id', 'id')->withDefault([
            'id' => 0,
            'name' => '-',
        ]);
    }

    public function bezahlstatus()
    {
        return $this->belongsTo(OptionBezahlstatus::class, 'bezahlstatus_id', 'id')->withDefault([
            'id' => 0,
            'name' => '-',
        ]);
    }

    public function export()
    {
        return $this->belongsTo(RechnungExport::class, 'rechnungsexport_id');
    }

    public function exports()
    {
        return $this->belongsToMany(RechnungExport::class, 'rechnungexport_rechnung', 'rechnung_id', 'rechnungexport_id')
            ->withPivot(['export_betrag', 'export_typ'])
            ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(Person::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Person::class, 'updated_by');
    }

    // Scopes
    public function scopeBezahlt($query)
    {
        return $query->where('bezahlt', true);
    }

    public function scopeUnbezahlt($query)
    {
        return $query->where('bezahlt', false);
    }

    public function scopeStorniert($query)
    {
        return $query->where('storniert', true);
    }

    public function scopeAktiv($query)
    {
        return $query->where('storniert', false)->orWhereNull('storniert');
    }

    // Accessors
    public function getStatusAttribute()
    {
        if ($this->storniert) {
            return 'storniert';
        }

        if ($this->bezahlt) {
            return 'bezahlt';
        }

        return 'offen';
    }

    public function getGesamtbetragAttribute()
    {
        return $this->rechnungssumme;
    }

    // Business Logic
    public function berechneGesamtbetrag()
    {
        $gesamtbetrag = $this->rechnungsposten()->sum('betrag');
        $this->update(['rechnungssumme' => $gesamtbetrag]);

        return $gesamtbetrag;
    }

    public function markiereBezahlt($datum = null)
    {
        $this->update([
            'bezahlt' => true,
            'bezahlt_am' => $datum ?: now()->format('Y-m-d'),
        ]);
    }

    public function storniere($grund = null, $user_id = null)
    {
        $this->update([
            'storniert' => true,
            'storniert_am' => now()->format('Y-m-d'),
            'stornierer_id' => $user_id,
            'anmerkungen' => $this->anmerkungen . "\n\nStorniert: " . $grund,
        ]);
    }

    public function generiereRechnungsnummer()
    {
        if (! $this->rechnungsnummer) {
            $jahr = $this->erstellt_am ? $this->erstellt_am->format('Y') : date('Y');
            $letzte_nummer = static::whereYear('erstellt_am', $jahr)
                ->whereNotNull('rechnungsnummer')
                ->max('rechnungsnummer');

            if ($letzte_nummer) {
                $nummer = intval(substr($letzte_nummer, -4)) + 1;
            } else {
                $nummer = 1;
            }

            $this->rechnungsnummer = $jahr . sprintf('%04d', $nummer);
            $this->save();
        }

        return $this->rechnungsnummer;
    }

    // Zahlungsverkehr-Methoden (angepasst für vorhandene Felder)
    public function istLastschrift()
    {
        return $this->bezahlart_id === 1; // ID 1 = Lastschrift
    }

    public function istUeberweisung()
    {
        return $this->bezahlart_id === 2; // ID 2 = Überweisung
    }

    public function hatRuecklastschrift()
    {
        return $this->bezahlstatus_id === 4 || $this->ruecklastschrift === 1; // ID 4 = "Lastschrift geplatzt"
    }

    public function setzeLastschriftDaten($iban, $bic = null, $mandatsreferenz = null, $verwendungszweck = null)
    {
        $this->update([
            'bezahlart_id' => 1, // Lastschrift
            'bezahlstatus_id' => 1, // kein Eingang
            'iban' => $iban,
            'auftraggeber_bic' => $bic,
            'mandatsreferenz' => $mandatsreferenz,
            'anmerkungen' => $verwendungszweck ?: "Rechnung {$this->rechnungsnummer}",
            'waehrung' => 'EUR',
            'kontoinhaber' => $this->person->vollname ?? null,
        ]);
    }

    public function setzeUeberweisungsDaten($empfaenger_iban, $empfaenger_bic = null, $verwendungszweck = null)
    {
        $this->update([
            'bezahlart_id' => 2, // Überweisung
            'bezahlstatus_id' => 1, // kein Eingang
            'empfaenger_iban' => $empfaenger_iban,
            'empfaenger_bic' => $empfaenger_bic,
            'anmerkungen' => $verwendungszweck ?: "Rechnung {$this->rechnungsnummer}",
            'waehrung' => 'EUR',
        ]);
    }

    public function markiereRuecklastschrift($grund, $datum = null)
    {
        $this->update([
            'bezahlstatus_id' => 4, // Lastschrift geplatzt
            'ruecklastschrift' => 1,
            'ruecklastschrift_grund' => $grund,
            'ruecklastschrift_am' => $datum ?: now()->format('Y-m-d'),
            'sepa_reason_code' => $grund,
            'bezahlt' => false,
            'bezahlt_am' => null,
        ]);
    }

    public function markiereEingereicht()
    {
        $this->update([
            'bezahlstatus_id' => 2, // Bankeinzug erfolgt
            'exportiert' => true,
            'exportiert_am' => now()->format('Y-m-d'),
        ]);
    }

    public function markiereUeberweisungEingegangen($datum = null)
    {
        $this->update([
            'bezahlstatus_id' => 3, // Überweisung eingegangen
            'bezahlt' => true,
            'bezahlt_am' => $datum ?: now()->format('Y-m-d'),
        ]);
    }

    public function generiereSepaXml()
    {
        if (! $this->istLastschrift() && ! $this->istUeberweisung()) {
            throw new \Exception('Rechnung ist weder Lastschrift noch Überweisung');
        }

        $xml = '';

        if ($this->istLastschrift()) {
            $xml = $this->generiereSepaLastschriftXml();
        } else {
            $xml = $this->generiereSepaUeberweisungXml();
        }

        return $xml;
    }

    private function generiereSepaLastschriftXml()
    {
        $endToEndId = "RECH-{$this->rechnungsnummer}";
        $mandatId = $this->mandatsreferenz ?: "MANDAT-{$this->person_id}";

        return [
            'PmtInfId' => 'BATCH-' . date('YmdHis'),
            'PmtMtd' => 'DD',
            'ReqdColltnDt' => $this->buchungsdatum ? $this->buchungsdatum->format('Y-m-d') : date('Y-m-d'),
            'Cdtr' => [
                'Nm' => config('app.company_name', 'DRC'),
                'PstlAdr' => [
                    'Ctry' => 'DE',
                ],
            ],
            'CdtrAcct' => [
                'Id' => [
                    'IBAN' => $this->empfaenger_iban ?: config('sepa.creditor_iban'),
                ],
            ],
            'CdtrSchmeId' => [
                'Id' => [
                    'PrvtId' => [
                        'Othr' => [
                            'Id' => $this->glaeubiger_id ?: config('sepa.creditor_id'),
                            'SchmeNm' => [
                                'Prtry' => 'SEPA',
                            ],
                        ],
                    ],
                ],
            ],
            'DrctDbtTxInf' => [
                'PmtId' => [
                    'EndToEndId' => $endToEndId,
                ],
                'InstdAmt' => [
                    '_attributes' => ['Ccy' => $this->waehrung ?: 'EUR'],
                    '_value' => number_format($this->rechnungssumme, 2, '.', ''),
                ],
                'DrctDbtTx' => [
                    'MndtRltdInf' => [
                        'MndtId' => $mandatId,
                        'DtOfSgntr' => $this->person->mandat_datum ?? date('Y-m-d'),
                    ],
                ],
                'Dbtr' => [
                    'Nm' => $this->kontoinhaber ?: $this->person->vollname,
                ],
                'DbtrAcct' => [
                    'Id' => [
                        'IBAN' => $this->iban,
                    ],
                ],
                'RmtInf' => [
                    'Ustrd' => $this->anmerkungen ?: "Rechnung {$this->rechnungsnummer}",
                ],
            ],
        ];
    }

    private function generiereSepaUeberweisungXml()
    {
        $endToEndId = "RECH-{$this->rechnungsnummer}";

        return [
            'PmtInfId' => 'BATCH-' . date('YmdHis'),
            'PmtMtd' => 'TRF',
            'ReqdExctnDt' => $this->buchungsdatum ? $this->buchungsdatum->format('Y-m-d') : date('Y-m-d'),
            'Dbtr' => [
                'Nm' => config('app.company_name', 'DRC'),
            ],
            'DbtrAcct' => [
                'Id' => [
                    'IBAN' => config('sepa.debtor_iban'),
                ],
            ],
            'CdtTrfTxInf' => [
                'PmtId' => [
                    'EndToEndId' => $endToEndId,
                ],
                'Amt' => [
                    'InstdAmt' => [
                        '_attributes' => ['Ccy' => $this->waehrung ?: 'EUR'],
                        '_value' => number_format($this->rechnungssumme, 2, '.', ''),
                    ],
                ],
                'Cdtr' => [
                    'Nm' => $this->person->vollname,
                ],
                'CdtrAcct' => [
                    'Id' => [
                        'IBAN' => $this->empfaenger_iban,
                    ],
                ],
                'RmtInf' => [
                    'Ustrd' => $this->anmerkungen ?: "Rechnung {$this->rechnungsnummer}",
                ],
            ],
        ];
    }

    public function notizen()
    {
        return $this->morphMany(Notiz::class, 'notizable')->orderBy('updated_at', 'asc');
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('datum', 'desc');
    }

    /**
     * Get the parent rechnungable model (Group, Person, etc.)
     */
    public function rechnungable()
    {
        return $this->morphTo('sourceable', 'sourceable_type', 'sourceable_id');
    }
}
