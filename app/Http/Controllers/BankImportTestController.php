<?php

namespace App\Http\Controllers;

use App\Models\Rechnung;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BankImportTestController extends Controller
{
    public function testImport(Request $request)
    {
        try {
            $matchedCount = 0;
            $details = [];
            $transactions = [];

            // Wenn eine Datei hochgeladen wurde, verarbeite sie
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $content = file_get_contents($file->getPathname());

                // Debug: Erste Zeilen der Datei loggen
                $preview = substr($content, 0, 500);
                \Log::info('Bank Import - Dateiinhalt Preview:', ['preview' => $preview]);

                // Bestimme das Format und parse die Transaktionen
                if ($this->isSparkasseCSV($content)) {
                    $transactions = $this->parseSparkasseCSV($content);
                    $details[] = '📁 Sparkasse CSV-Datei erkannt und verarbeitet';
                } elseif ($this->isMT940($content)) {
                    $transactions = $this->parseMT940($content);
                    $details[] = '📁 MT940-Datei erkannt und verarbeitet';
                } elseif ($this->isCAMT053($content)) {
                    $transactions = $this->parseCAMT053($content);
                    $details[] = '📁 CAMT.053 XML-Datei erkannt und verarbeitet';
                } else {
                    // Debug Info hinzufügen
                    $fileInfo = [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'preview' => substr($content, 0, 200),
                        'contains_semicolon' => strpos($content, ';') !== false,
                        'contains_comma' => strpos($content, ',') !== false,
                        'line_count' => substr_count($content, "\n"),
                    ];

                    return response()->json([
                        'error' => 'Unbekanntes Dateiformat. Unterstützt: Sparkasse CSV, MT940, CAMT.053 XML',
                        'debug' => $fileInfo,
                    ], 400);
                }
            } else {
                // Fallback: Test-Daten verwenden
                $csvData = [
                    '30.12.2024;Gutschrift;2025-00001;180.00;EUR;SEPA-Gutschrift;Rechnungsbegleichung',
                    '29.12.2024;Gutschrift;2025-00002;10000.00;EUR;SEPA-Gutschrift;Vollzahlung',
                ];

                foreach ($csvData as $line) {
                    $parts = explode(';', $line);
                    $transactions[] = [
                        'datum' => Carbon::createFromFormat('d.m.Y', $parts[0])->format('Y-m-d'),
                        'betrag' => (float) $parts[3],
                        'verwendungszweck' => $parts[2] . ' ' . $parts[6],
                        'transaktions_id' => 'TEST_' . uniqid(),
                    ];
                }
                $details[] = '🧪 Test-Daten verwendet (keine Datei hochgeladen)';
            }

            // Reset der Testdaten falls gewünscht
            if ($request->get('reset')) {
                Rechnung::whereIn('rechnungsnummer', ['2025-00001', '2025-00002'])
                    ->update([
                        'buchungsdatum' => null,
                        'geldeingang' => null,
                        'sepa_transaktions_id' => null,
                    ]);
                $details[] = '🔄 Test-Rechnungen zurückgesetzt';
            }

            $details[] = '📊 ' . count($transactions) . ' Transaktionen gefunden';

            // Verarbeite die Transaktionen
            foreach ($transactions as $transaction) {
                $rechnungsnummer = null;
                if (preg_match('/(\d{4}-\d{5})/', $transaction['verwendungszweck'], $matches)) {
                    $rechnungsnummer = $matches[1];
                }

                if ($rechnungsnummer) {
                    $rechnung = Rechnung::where('rechnungsnummer', $rechnungsnummer)->first();
                    if ($rechnung && ! $rechnung->buchungsdatum) {
                        $rechnung->update([
                            'buchungsdatum' => $transaction['datum'],
                            'geldeingang' => $transaction['betrag'],
                            'sepa_transaktions_id' => $transaction['transaktions_id'],
                        ]);
                        $matchedCount++;
                        $details[] = "✅ Rechnung {$rechnungsnummer} erfolgreich aktualisiert ({$transaction['betrag']}€)";
                    } elseif ($rechnung && $rechnung->buchungsdatum) {
                        $details[] = "⚠️ Rechnung {$rechnungsnummer} bereits bezahlt (Buchungsdatum: {$rechnung->buchungsdatum})";
                    } else {
                        $details[] = "❌ Rechnung {$rechnungsnummer} nicht gefunden";
                    }
                } else {
                    $details[] = '⏭️ Keine Rechnungsnummer in: ' . substr($transaction['verwendungszweck'], 0, 50) . '...';
                }
            }

            return response()->json([
                'success' => "Bank-Import erfolgreich. {$matchedCount} von " . count($transactions) . ' Zahlungen zugeordnet.',
                'data' => [
                    'transactions_found' => count($transactions),
                    'transactions_matched' => $matchedCount,
                    'details' => $details,
                    'transactions' => $transactions,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Bank-Import-Fehler: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function isSparkasseCSV($content)
    {
        // Prüfe auf typische CSV-Strukturen
        $lines = explode("\n", $content);
        $hasHeader = false;
        $hasSemicolons = false;
        $hasDatePattern = false;

        foreach (array_slice($lines, 0, 5) as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Prüfe auf Semikolons (typisch für deutsche CSV)
            if (strpos($line, ';') !== false) {
                $hasSemicolons = true;
            }

            // Prüfe auf Datum im Format dd.mm.yyyy
            if (preg_match('/\d{2}\.\d{2}\.\d{4}/', $line)) {
                $hasDatePattern = true;
            }

            // Prüfe auf typische Sparkasse-Header
            if (strpos($line, 'Auftragskonto') !== false ||
                strpos($line, 'Buchungstag') !== false ||
                strpos($line, 'Valutadatum') !== false) {
                $hasHeader = true;
            }
        }

        // Akzeptiere als CSV wenn mindestens 2 Kriterien erfüllt sind
        $criteria = (int) $hasSemicolons + (int) $hasDatePattern + (int) $hasHeader;

        return $criteria >= 1; // Weniger strikt
    }

    private function isMT940($content)
    {
        return strpos($content, ':20:') !== false && strpos($content, ':25:') !== false;
    }

    private function isCAMT053($content)
    {
        return strpos($content, '<Document') !== false && strpos($content, 'camt.053') !== false;
    }

    private function parseSparkasseCSV($content)
    {
        $transactions = [];
        $lines = explode("\n", $content);
        $headerFound = false;
        $dateColumn = -1;
        $amountColumn = -1;
        $purposeColumn = -1;

        foreach ($lines as $lineNum => $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $parts = str_getcsv($line, ';');

            // Erste Zeile: Versuche Header zu erkennen
            if (! $headerFound && $lineNum < 3) {
                for ($i = 0; $i < count($parts); $i++) {
                    $part = strtolower($parts[$i]);
                    if (strpos($part, 'buchungstag') !== false || strpos($part, 'datum') !== false) {
                        $dateColumn = $i;
                    }
                    if (strpos($part, 'betrag') !== false || strpos($part, 'umsatz') !== false) {
                        $amountColumn = $i;
                    }
                    if (strpos($part, 'verwendung') !== false || strpos($part, 'zweck') !== false) {
                        $purposeColumn = $i;
                    }
                }

                // Wenn Header-Spalten erkannt wurden, markiere als Header
                if ($dateColumn >= 0 || $amountColumn >= 0) {
                    $headerFound = true;
                    continue;
                }
            }

            // Fallback: Automatische Spaltenerkennung
            if ($dateColumn < 0 || $amountColumn < 0) {
                for ($i = 0; $i < count($parts); $i++) {
                    // Suche Datumsspalte
                    if (preg_match('/\d{2}\.\d{2}\.\d{4}/', $parts[$i])) {
                        $dateColumn = $i;
                    }
                    // Suche Betragsspalte (Zahlen mit Komma/Punkt)
                    if (preg_match('/[-]?[\d.,]+/', $parts[$i]) && strpos($parts[$i], '.') !== false || strpos($parts[$i], ',') !== false) {
                        $amountColumn = $i;
                    }
                }

                // Verwendungszweck ist meist die längste Spalte oder eine der mittleren
                if ($purposeColumn < 0 && count($parts) > 3) {
                    $purposeColumn = min(3, count($parts) - 2);
                }
            }

            // Versuche Transaktion zu parsen
            if (count($parts) >= 3) {
                try {
                    $datum = null;
                    $betrag = 0;
                    $verwendung = '';

                    // Datum extrahieren
                    if ($dateColumn >= 0 && isset($parts[$dateColumn])) {
                        $datum = Carbon::createFromFormat('d.m.Y', trim($parts[$dateColumn]))->format('Y-m-d');
                    } else {
                        // Suche Datum in allen Spalten
                        foreach ($parts as $part) {
                            if (preg_match('/\d{2}\.\d{2}\.\d{4}/', $part)) {
                                $datum = Carbon::createFromFormat('d.m.Y', trim($part))->format('Y-m-d');
                                break;
                            }
                        }
                    }

                    // Betrag extrahieren
                    if ($amountColumn >= 0 && isset($parts[$amountColumn])) {
                        $betragStr = $parts[$amountColumn];
                    } else {
                        // Suche Betrag in allen Spalten
                        foreach ($parts as $part) {
                            if (preg_match('/[-]?[\d.,]+/', $part) && (strpos($part, '.') !== false || strpos($part, ',') !== false)) {
                                $betragStr = $part;
                                break;
                            }
                        }
                    }

                    if (isset($betragStr)) {
                        $betrag = (float) str_replace(',', '.', str_replace('.', '', $betragStr));
                    }

                    // Verwendungszweck extrahieren
                    if ($purposeColumn >= 0 && isset($parts[$purposeColumn])) {
                        $verwendung = $parts[$purposeColumn];
                    } else {
                        // Nimm alle Text-Spalten zusammen
                        $verwendung = implode(' ', array_slice($parts, 2, 3));
                    }

                    if ($datum && $betrag != 0) {
                        $transactions[] = [
                            'datum' => $datum,
                            'betrag' => abs($betrag),
                            'verwendungszweck' => $verwendung,
                            'transaktions_id' => 'CSV_' . uniqid(),
                        ];
                    }
                } catch (\Exception $e) {
                    \Log::warning('CSV Parse Error for line: ' . $line . ' - ' . $e->getMessage());
                    // Zeile überspringen bei Parsing-Fehlern
                }
            }
        }

        return $transactions;
    }

    private function parseMT940($content)
    {
        // Vereinfachte MT940-Parsing-Logik
        $transactions = [];

        // TODO: Implementiere vollständige MT940-Parsing-Logik
        return $transactions;
    }

    private function parseCAMT053($content)
    {
        // Vereinfachte CAMT.053-Parsing-Logik
        $transactions = [];

        // TODO: Implementiere vollständige CAMT.053-Parsing-Logik
        return $transactions;
    }
}
