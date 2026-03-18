<?php

namespace App\Http\Controllers;

use App\Models\Rechnung;
use App\Models\RechnungExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RechnungExportController extends Controller
{
    /**
     * Statistiken für Export-Modal laden
     */
    public function getExportStatistiken()
    {
        try {
            $stats = [
                'nicht_exportiert' => Rechnung::whereNull('rechnungsexport_id')->count(),
                'ruecklastschriften' => Rechnung::where('bezahlstatus_id', 5)->count(),
                'offene' => Rechnung::where('bezahlstatus_id', 1)->count(),
                'restbetraege' => Rechnung::whereRaw('(rechnungssumme - geldeingang) > 0')->count(),
                'alle' => Rechnung::count(),
                'gesamt_summe' => Rechnung::sum('rechnungssumme'),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Statistiken: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Alle Exporte mit verfügbaren Dateien abrufen
     */
    public function getExports()
    {
        try {
            $exports = RechnungExport::orderBy('created_at', 'desc')->get();

            // Für jeden Export die verfügbaren Dateien hinzufügen
            $exports->each(function ($export) {
                $files = [];
                $exportPath = 'exports/';

                // Nach Dateien mit der Export-ID suchen
                $allFiles = Storage::disk('local')->files($exportPath);
                foreach ($allFiles as $file) {
                    if (strpos($file, "export_{$export->id}_") !== false || strpos($file, "sepa_export_{$export->id}_") !== false) {
                        $filename = basename($file);
                        $files[] = [
                            'filename' => $filename,
                            'size' => Storage::disk('local')->size($file),
                            'type' => pathinfo($filename, PATHINFO_EXTENSION),
                        ];
                    }
                }

                $export->available_files = $files;
            });

            return response()->json([
                'success' => true,
                'data' => $exports,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Exporte: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export-Vorschau für verschiedene Filter
     */
    public function getExportVorschau(Request $request)
    {
        try {
            $query = Rechnung::query();

            // Bereich-Filter
            switch ($request->bereich) {
                case 'nummernbereich':
                    if ($request->filled('von_rechnungsnummer')) {
                        $query->where('rechnungsnummer', '>=', $request->von_rechnungsnummer);
                    }
                    if ($request->filled('bis_rechnungsnummer')) {
                        $query->where('rechnungsnummer', '<=', $request->bis_rechnungsnummer);
                    }
                    break;

                case 'datumsbereich':
                    if ($request->filled('von_datum')) {
                        $query->whereDate('rechnungsdatum', '>=', $request->von_datum);
                    }
                    if ($request->filled('bis_datum')) {
                        $query->whereDate('rechnungsdatum', '<=', $request->bis_datum);
                    }
                    break;

                case 'markierte':
                    // TODO: Implementierung für markierte Rechnungen
                    // Annahme: Es gibt ein Feld 'markiert' oder eine Session mit markierten IDs
                    if ($request->filled('markierte_ids')) {
                        $query->whereIn('id', $request->markierte_ids);
                    }
                    break;

                case 'alle':
                default:
                    // Keine zusätzlichen Filter
                    break;
            }

            // Status-Filter
            switch ($request->status_filter) {
                case 'offen':
                    $query->where('bezahlstatus_id', 1); // Annahme: 1 = offen
                    break;

                case 'ruecklastschriften':
                    $query->where('bezahlart_id', 3); // Annahme: 3 = Rücklastschrift
                    break;

                case 'ueberweisungen':
                    $query->where('bezahlart_id', 2); // Annahme: 2 = Überweisung
                    break;

                case 'lastschriften':
                    $query->where('bezahlart_id', 1); // Annahme: 1 = Lastschrift
                    break;

                case 'nicht_exportiert':
                    $query->whereNull('rechnungexport_id');
                    break;

                case 'alle':
                default:
                    // Keine Status-Filter
                    break;
            }

            // Zusätzliche Filter (deprecated, aber für Kompatibilität)
            if ($request->filled('nur_nicht_exportiert') && $request->nur_nicht_exportiert) {
                $query->whereNull('rechnungexport_id');
            }

            if ($request->filled('nur_offene') && $request->nur_offene) {
                $query->where('bezahlstatus_id', 1);
            }

            $rechnungen = $query->with(['kreditor', 'bezahlart', 'bezahlstatus'])->get();

            $vorschau = [
                'anzahl' => $rechnungen->count(),
                'gesamtbetrag' => $rechnungen->sum(function ($r) {
                    return (float) $r->rechnungssumme;
                }),
                'rechnungen' => $rechnungen->take(10)->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'rechnungsnummer' => $r->rechnungsnummer,
                        'summe' => $r->rechnungssumme,
                        'kreditor' => $r->kreditor ? $r->kreditor->name : 'Unbekannt',
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'data' => $vorschau,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Vorschau: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export erstellen mit erweiterten Filtern
     */
    public function createExport(Request $request)
    {
        $request->validate([
            'titel' => 'required|string|max:255',
            'format' => 'required|string|in:sepa,csv,beide',
            'bereich' => 'required|string|in:alle,nummernbereich,datumsbereich,markierte',
            'status_filter' => 'required|string|in:alle,offen,ruecklastschriften,ueberweisungen,lastschriften,nicht_exportiert',
            'von_rechnungsnummer' => 'nullable|string',
            'bis_rechnungsnummer' => 'nullable|string',
            'von_datum' => 'nullable|date',
            'bis_datum' => 'nullable|date',
            'markierte_ids' => 'nullable|array',
        ]);

        try {
            $query = Rechnung::query();

            // Bereich-Filter anwenden
            switch ($request->bereich) {
                case 'nummernbereich':
                    if ($request->filled('von_rechnungsnummer')) {
                        $query->where('rechnungsnummer', '>=', $request->von_rechnungsnummer);
                    }
                    if ($request->filled('bis_rechnungsnummer')) {
                        $query->where('rechnungsnummer', '<=', $request->bis_rechnungsnummer);
                    }
                    break;

                case 'datumsbereich':
                    if ($request->filled('von_datum')) {
                        $query->whereDate('rechnungsdatum', '>=', $request->von_datum);
                    }
                    if ($request->filled('bis_datum')) {
                        $query->whereDate('rechnungsdatum', '<=', $request->bis_datum);
                    }
                    break;

                case 'markierte':
                    if ($request->filled('markierte_ids')) {
                        $query->whereIn('id', $request->markierte_ids);
                    }
                    break;

                case 'alle':
                default:
                    // Keine zusätzlichen Filter
                    break;
            }

            // Status-Filter anwenden
            switch ($request->status_filter) {
                case 'offen':
                    $query->where('bezahlstatus_id', 1);
                    break;

                case 'ruecklastschriften':
                    $query->where('bezahlart_id', 3);
                    break;

                case 'ueberweisungen':
                    $query->where('bezahlart_id', 2);
                    break;

                case 'lastschriften':
                    $query->where('bezahlart_id', 1);
                    break;

                case 'nicht_exportiert':
                    $query->whereNull('rechnungexport_id');
                    break;

                case 'alle':
                default:
                    // Keine Status-Filter
                    break;
            }

            // Rechnungen laden mit angewendeten Filtern
            $rechnungen = $query->with(['kreditor', 'bezahlart', 'bezahlstatus', 'person'])->get();

            // Export-Record erstellen
            $export = RechnungExport::create([
                'titel' => $request->titel,
                'format' => $request->format,
                'von_rechnungsnummer' => $request->von_rechnungsnummer,
                'bis_rechnungsnummer' => $request->bis_rechnungsnummer,
                'erstellt_von' => Auth::id(),
                'anzahl_rechnungen' => $rechnungen->count(),
                'gesamtbetrag' => $rechnungen->sum(function ($r) {
                    return (float) $r->rechnungssumme;
                }),
                'status' => 'erstellt',
                'created_at' => now(),
            ]);

            // Rechnungen mit Export verknüpfen über Pivot-Tabelle
            foreach ($rechnungen as $rechnung) {
                $export->rechnungen()->attach($rechnung->id, [
                    'export_betrag' => $rechnung->rechnungssumme,
                    'export_typ' => $request->format,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Dateien generieren
            $dateien = [];

            if (in_array($request->format, ['sepa', 'beide'])) {
                $sepaDatei = $this->generateSepaFile($rechnungen, $export);
                if ($sepaDatei) {
                    $dateien[] = $sepaDatei;
                }
            }

            if (in_array($request->format, ['csv', 'beide'])) {
                $csvDatei = $this->generateCsvFile($rechnungen, $export);
                if ($csvDatei) {
                    $dateien[] = $csvDatei;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $export->id,
                    'export_id' => $export->id,
                    'titel' => $export->titel,
                    'anzahl_rechnungen' => $export->anzahl_rechnungen,
                    'gesamtbetrag' => $export->gesamtbetrag,
                    'files' => $dateien,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Erstellen des Exports: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * CSV-Datei generieren
     */
    private function generateCsvFile($rechnungen, $export)
    {
        try {
            $filename = "export_{$export->id}_" . now()->format('Y-m-d_H-i-s') . '.csv';

            // Erweiterte CSV-Header basierend auf rechnungen/index.vue columns
            $content = "Rechnungsnummer;Rechnungsdatum;Fälligkeit;Mitgliedsnummer;Empfänger;Straße;PLZ;Ort;Buchungsdatum;Rechnungssumme;Geldeingang;Offen;Kontoinhaber;Bankname;BIC;IBAN;Export ID;Bezahlstatus;Bezahlart\n";

            foreach ($rechnungen as $rechnung) {
                $content .= sprintf(
                    "%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;\n",
                    $rechnung->rechnungsnummer ?: '',
                    $rechnung->rechnungsdatum && $rechnung->rechnungsdatum instanceof \Carbon\Carbon ? $rechnung->rechnungsdatum->format('d.m.Y') : ($rechnung->rechnungsdatum ?: ''),
                    $rechnung->faelligkeit && $rechnung->faelligkeit instanceof \Carbon\Carbon ? $rechnung->faelligkeit->format('d.m.Y') : ($rechnung->faelligkeit ?: ''),
                    $rechnung->mitgliedsnummer ?: '',
                    $rechnung->rechnung_name ?: '',
                    $rechnung->rechnung_strasse ?: '',
                    $rechnung->rechnung_postleitzahl ?: '',
                    $rechnung->rechnung_ort ?: '',
                    $rechnung->buchungsdatum && $rechnung->buchungsdatum instanceof \Carbon\Carbon ? $rechnung->buchungsdatum->format('d.m.Y') : ($rechnung->buchungsdatum ?: ''),
                    number_format($rechnung->rechnungssumme ?: 0, 2, ',', '.'),
                    number_format($rechnung->geldeingang ?: 0, 2, ',', '.'),
                    number_format($rechnung->offen ?: 0, 2, ',', '.'),
                    $rechnung->auftraggeber_kontoinhaber ?: '',
                    $rechnung->auftraggeber_bankname ?: '',
                    $rechnung->auftraggeber_bic ?: '',
                    $rechnung->auftraggeber_iban ?: '',
                    $rechnung->rechnungexport_id ?: '',
                    $rechnung->bezahlstatus ? $rechnung->bezahlstatus->name : '',
                    $rechnung->bezahlart ? $rechnung->bezahlart->name : ''
                );
            }

            Storage::disk('local')->put("exports/{$filename}", $content);

            return [
                'type' => 'csv',
                'filename' => $filename,
                'path' => "exports/{$filename}",
                'size' => strlen($content),
            ];

        } catch (\Exception $e) {
            \Log::error('Fehler beim CSV-Export: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * SEPA-Datei generieren (vereinfacht)
     */
    private function generateSepaFile($rechnungen, $export)
    {
        try {
            $filename = "sepa_export_{$export->id}_" . now()->format('Y-m-d_H-i-s') . '.xml';

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02">' . "\n";
            $xml .= '  <CstmrDrctDbtInitn>' . "\n";
            $xml .= '    <GrpHdr>' . "\n";
            $xml .= '      <MsgId>Export-' . $export->id . '</MsgId>' . "\n";
            $xml .= '      <CreDtTm>' . now()->toIso8601String() . '</CreDtTm>' . "\n";
            $xml .= '      <NbOfTxs>' . $rechnungen->count() . '</NbOfTxs>' . "\n";
            $xml .= '      <CtrlSum>' . $rechnungen->sum('rechnungssumme') . '</CtrlSum>' . "\n";
            $xml .= '    </GrpHdr>' . "\n";
            $xml .= '  </CstmrDrctDbtInitn>' . "\n";
            $xml .= '</Document>';

            Storage::disk('local')->put("exports/{$filename}", $xml);

            return [
                'type' => 'sepa',
                'filename' => $filename,
                'path' => "exports/{$filename}",
                'size' => strlen($xml),
            ];

        } catch (\Exception $e) {
            \Log::error('Fehler beim SEPA-Export: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Export-Details abrufen
     */
    public function getExportDetails($id)
    {
        try {
            $export = RechnungExport::with([
                'rechnungen' => function ($query) {
                    $query->select(
                        'rechnungen.id',
                        'rechnungsnummer',
                        'rechnungsdatum',
                        'rechnung_name as empfaenger_name',
                        'bezahlart_id',
                        'rechnungssumme as betrag',
                        'offen as offen_betrag'
                    )->with(['bezahlart:id,name']);
                },
                'uebertragender:id,name', // User der übertragen hat
            ])->findOrFail($id);

            // Bezahlart-Namen direkt auf die Rechnungen mappen für Frontend-Kompatibilität
            foreach ($export->rechnungen as $rechnung) {
                $rechnung->bezahlart = $rechnung->bezahlart->name ?? $this->getBezahlartName($rechnung->bezahlart_id);
                // Bezahlart-Relation entfernen um doppelte Daten zu vermeiden
                unset($rechnung->bezahlart_relation);
            }

            // Username für Übertragung hinzufügen
            $exportArray = $export->toArray();
            $exportArray['uebertragen_von_name'] = $export->uebertragender->name ?? null;

            // Verfügbare Download-Dateien finden
            $files = [];
            $exportPath = 'exports/';

            // Nach Dateien mit der Export-ID suchen
            $allFiles = Storage::disk('local')->files($exportPath);
            foreach ($allFiles as $file) {
                if (strpos($file, "export_{$id}_") !== false || strpos($file, "sepa_export_{$id}_") !== false) {
                    $filename = basename($file);
                    $size = Storage::disk('local')->size($file);
                    $files[] = [
                        'filename' => $filename,
                        'size' => $size,
                        'type' => pathinfo($filename, PATHINFO_EXTENSION),
                        'created_at' => Storage::disk('local')->lastModified($file),
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => array_merge($exportArray, ['available_files' => $files]),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Export nicht gefunden: ' . $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Bezahlart-Name anhand ID ermitteln (Fallback)
     */
    private function getBezahlartName($bezahlartId)
    {
        $bezahlarten = [
            1 => 'Lastschrift',
            2 => 'Überweisung',
            3 => 'Barzahlung',
        ];

        return $bezahlarten[$bezahlartId] ?? 'Unbekannt';
    }

    /**
     * Rechnungen eines Exports abrufen
     */
    public function getExportRechnungen($id)
    {
        try {
            $export = RechnungExport::findOrFail($id);

            $rechnungen = $export->rechnungen()
                ->with(['kreditor', 'bezahlart', 'bezahlstatus'])
                ->withPivot(['export_betrag', 'export_typ', 'created_at'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'export' => $export,
                    'rechnungen' => $rechnungen,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Export nicht gefunden: ' . $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Export-Liste abrufen
     */
    public function index()
    {
        try {
            $exports = RechnungExport::with('ersteller')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $exports,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Exports: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export-Datei herunterladen mit Rechte-Kontrolle
     */
    public function downloadFile($id, $filename)
    {
        try {
            // 1. Authentifizierung prüfen
            if (! Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentifizierung erforderlich',
                ], 401);
            }

            // 2. Export-Berechtigung prüfen
            $user = Auth::user();
            if (! $user->can('export', \App\Models\Rechnung::class)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Berechtigung für Export-Downloads',
                ], 403);
            }

            // 3. Export existiert und gehört zum User oder User hat Admin-Rechte
            $export = RechnungExport::findOrFail($id);

            if ($export->erstellt_von !== $user->id && ! $user->can('manage', \App\Models\Rechnung::class)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Berechtigung für diesen Export',
                ], 403);
            }

            // 4. Datei existiert und ist sicher (nur aus exports-Ordner)
            $path = "exports/{$filename}";

            // Sicherheitscheck: Filename darf keine Pfad-Traversal enthalten
            if (strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
                \Log::warning('Suspicious download attempt', [
                    'user_id' => $user->id,
                    'filename' => $filename,
                    'export_id' => $id,
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Ungültiger Dateiname',
                ], 400);
            }

            if (! Storage::disk('local')->exists($path)) {
                \Log::error('Export file not found', [
                    'path' => $path,
                    'export_id' => $id,
                    'user_id' => $user->id,
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Export-Datei nicht gefunden',
                ], 404);
            }

            // 5. Download-Aktivität protokollieren
            \Log::info('Export file downloaded', [
                'export_id' => $id,
                'filename' => $filename,
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            // 6. Datei sicher herunterladen
            return Storage::disk('local')->download($path, $filename, [
                'Content-Type' => $this->getMimeType($filename),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);

        } catch (\Exception $e) {
            \Log::error('Download Error', [
                'export_id' => $id,
                'filename' => $filename,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Download: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * MIME-Type für Datei bestimmen
     */
    private function getMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'csv':
                return 'text/csv';
            case 'xml':
                return 'application/xml';
            case 'pdf':
                return 'application/pdf';
            default:
                return 'application/octet-stream';
        }
    }

    /**
     * Export als übertragen markieren
     */
    public function markAsTransferred(Request $request, $id)
    {
        try {
            $export = RechnungExport::findOrFail($id);

            // Berechtigung prüfen
            if (! Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentifizierung erforderlich',
                ], 401);
            }

            $user = Auth::user();
            if ($export->erstellt_von !== $user->id && ! $user->can('manage', \App\Models\Rechnung::class)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Berechtigung für diesen Export',
                ], 403);
            }

            // Datum aus Request nehmen oder aktuelles Datum verwenden
            $transferredAt = $request->datum ? Carbon::parse($request->datum) : now();

            $export->update([
                'status' => 'uebertragen',
                'bank_uebertragen_am' => $transferredAt,
                'bank_uebertragen_von' => $user->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export wurde erfolgreich als übertragen markiert',
                'data' => $export->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Markieren: ' . $e->getMessage(),
            ], 500);
        }
    }
}
