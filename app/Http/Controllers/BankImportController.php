<?php

namespace App\Http\Controllers;

use App\Models\Rechnung;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankImportController extends Controller
{
    /**
     * Debug the bank import functionality
     */
    public function debug(): JsonResponse
    {
        try {
            // Test invoice query
            $invoices = Rechnung::whereNull('buchungsdatum')
                ->where('rechnungssumme', '>', 0)
                ->limit(3)
                ->select('id', 'rechnungsnummer', 'rechnungsdatum', 'rechnungssumme', 'buchungsdatum')
                ->get()
                ->map(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'rechnungsnummer' => $invoice->rechnungsnummer,
                        'rechnungsdatum' => $invoice->getRawOriginal('rechnungsdatum'),
                        'rechnungssumme' => $invoice->rechnungssumme,
                        'buchungsdatum' => $invoice->buchungsdatum,
                    ];
                });

            // Test transaction parsing
            $testTransaction = [
                'datum' => '2025-08-30',
                'verwendungszweck' => 'rechnung 2025-00001 mitgliedsbeitrag',
                'betrag' => 180.00,
                'sender' => 'Hans-Peter Tiggemann',
            ];

            // Test matching
            $match = $this->findMatchingInvoice($testTransaction);

            return response()->json([
                'success' => 'Debug successful',
                'error' => null,
                'data' => [
                    'available_invoices' => $invoices,
                    'test_transaction' => $testTransaction,
                    'match_found' => $match ? $match->toArray() : null,
                    'database_connection' => DB::connection()->getDatabaseName(),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Debug error: ' . $e->getMessage(),
                'success' => false,
                'data' => null,
            ], 500);
        }
    }

    /**
     * Import bank data and match transactions to invoices
     */
    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xml,xls,xlsx',
            'format' => 'required|string|in:auto,csv-sparkasse,csv-volksbank,csv-commerzbank,mt940,camt053',
            'matching_mode' => 'required|string|in:auto,manual,preview',
        ]);

        try {
            $file = $request->file('file');
            $format = $request->input('format');
            $matchingMode = $request->input('matching_mode');

            // Auto-detect format if needed
            if ($format === 'auto') {
                $format = $this->detectFormat($file);
            }

            // Parse the bank file
            $transactions = $this->parseFile($file, $format);

            if (empty($transactions)) {
                return response()->json([
                    'error' => 'Keine Transaktionen in der Datei gefunden.',
                    'success' => false,
                    'data' => null,
                ], 400);
            }

            // Match transactions to invoices
            $matches = $this->matchTransactionsToInvoices($transactions, $matchingMode);

            if ($matchingMode === 'preview') {
                return response()->json([
                    'success' => 'Vorschau erstellt',
                    'error' => null,
                    'data' => [
                        'transactions' => $transactions,
                        'matches' => $matches,
                        'preview' => true,
                    ],
                ]);
            }

            // Process matches and update invoices
            $processedCount = $this->processMatches($matches);

            return response()->json([
                'success' => "Bank-Import erfolgreich. {$processedCount} Zahlungen zugeordnet.",
                'error' => null,
                'data' => [
                    'processed_count' => $processedCount,
                    'total_transactions' => count($transactions),
                    'matches' => $matches,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Bank import error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'format' => $format ?? 'unknown',
                'exception' => $e,
            ]);

            return response()->json([
                'error' => 'Fehler beim Importieren der Bankdaten: ' . $e->getMessage(),
                'success' => false,
                'data' => null,
            ], 500);
        }
    }

    /**
     * Detect file format based on file extension and content
     */
    private function detectFormat($file): string
    {
        $filename = strtolower($file->getClientOriginalName());
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Check by file extension first
        if (in_array($extension, ['csv', 'txt'])) {
            return 'csv-sparkasse'; // Default to Sparkasse format for CSV
        }

        if ($extension === 'xml') {
            // Check content to determine XML type
            $content = file_get_contents($file->getRealPath());
            if (strpos($content, 'camt.053') !== false || strpos($content, 'BkToCstmrStmt') !== false) {
                return 'camt053';
            }

            return 'camt053'; // Default for XML
        }

        if (in_array($extension, ['xls', 'xlsx'])) {
            return 'csv-sparkasse'; // Will need to be converted to CSV first
        }

        // Check for MT940 by filename or content
        if (strpos($filename, 'mt940') !== false || $extension === 'mt940' || $extension === 'swi') {
            return 'mt940';
        }

        return 'csv-sparkasse'; // Default fallback
    }

    /**
     * Parse bank file based on format
     */
    private function parseFile($file, string $format): array
    {
        $content = file_get_contents($file->getRealPath());

        switch ($format) {
            case 'csv-sparkasse':
                return $this->parseCsvSparkasse($content);
            case 'csv-volksbank':
                return $this->parseCsvVolksbank($content);
            case 'csv-commerzbank':
                return $this->parseCsvCommerzbank($content);
            case 'mt940':
                return $this->parseMt940($content);
            case 'camt053':
                return $this->parseCamt053($content);
            default:
                throw new \Exception("Unbekanntes Format: {$format}");
        }
    }

    /**
     * Parse Sparkasse CSV format
     */
    private function parseCsvSparkasse(string $content): array
    {
        $transactions = [];
        $lines = explode("\n", $content);

        // Skip header line if exists
        $startLine = 0;
        if (count($lines) > 0 && strpos(strtolower($lines[0]), 'datum') !== false) {
            $startLine = 1;
        }

        for ($i = $startLine; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) {
                continue;
            }

            $data = str_getcsv($line, ';');

            if (count($data) >= 8) {
                try {
                    $amount = str_replace(',', '.', str_replace('.', '', $data[7]));
                    $amount = floatval($amount);

                    $transactions[] = [
                        'datum' => Carbon::createFromFormat('d.m.Y', $data[0])->format('Y-m-d'),
                        'verwendungszweck' => $data[4] ?? '',
                        'betrag' => $amount,
                        'waehrung' => 'EUR',
                        'sender' => $data[3] ?? '',
                        'empfaenger' => $data[2] ?? '',
                        'raw_data' => $data,
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error parsing CSV line: ' . $line, ['error' => $e->getMessage()]);
                    continue;
                }
            }
        }

        return $transactions;
    }

    /**
     * Parse Volksbank CSV format (placeholder)
     */
    private function parseCsvVolksbank(string $content): array
    {
        // TODO: Implement Volksbank specific parsing
        return $this->parseCsvSparkasse($content); // Use Sparkasse as fallback for now
    }

    /**
     * Parse Commerzbank CSV format (placeholder)
     */
    private function parseCsvCommerzbank(string $content): array
    {
        // TODO: Implement Commerzbank specific parsing
        return $this->parseCsvSparkasse($content); // Use Sparkasse as fallback for now
    }

    /**
     * Parse MT940 format
     */
    private function parseMt940(string $content): array
    {
        $transactions = [];
        $lines = explode("\n", $content);

        $currentTransaction = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            try {
                // :61: Value Date / Entry Date / Funds Code / Amount / Transaction Type / Reference
                if (preg_match('/^:61:(\d{6})(\d{4})?([CD])(\d+,\d{2})(.*)/', $line, $matches)) {
                    // Save previous transaction if exists
                    if ($currentTransaction) {
                        $transactions[] = $currentTransaction;
                    }

                    $valueDate = $matches[1]; // YYMMDD
                    $creditDebit = $matches[3]; // C = Credit, D = Debit
                    $amount = str_replace(',', '.', $matches[4]);

                    // Convert date format
                    $year = '20' . substr($valueDate, 0, 2);
                    $month = substr($valueDate, 2, 2);
                    $day = substr($valueDate, 4, 2);
                    $date = Carbon::createFromFormat('Y-m-d', "$year-$month-$day")->format('Y-m-d');

                    // Only process credit entries (incoming payments)
                    if ($creditDebit === 'C') {
                        $currentTransaction = [
                            'datum' => $date,
                            'verwendungszweck' => '',
                            'betrag' => (float) $amount,
                            'waehrung' => 'EUR',
                            'sender' => '',
                            'empfaenger' => '',
                            'raw_data' => [$line],
                        ];
                    }
                }

                // :86: Additional information (Verwendungszweck)
                if (preg_match('/^:86:(.*)/', $line, $matches) && $currentTransaction) {
                    $info = $matches[1];

                    // Parse structured info
                    if (preg_match('/\?20(.+?)(\?2[1-9]|$)/', $info, $infoMatches)) {
                        $currentTransaction['verwendungszweck'] = trim($infoMatches[1]);
                    }

                    // Extract sender name
                    if (preg_match('/\?32(.+?)(\?3[2-9]|$)/', $info, $senderMatches)) {
                        $currentTransaction['sender'] = trim($senderMatches[1]);
                    }

                    // If no structured info, use the whole line
                    if (empty($currentTransaction['verwendungszweck'])) {
                        $currentTransaction['verwendungszweck'] = $info;
                    }
                }

            } catch (\Exception $e) {
                Log::warning('Error parsing MT940 line: ' . $line, ['error' => $e->getMessage()]);
                continue;
            }
        }

        // Add last transaction
        if ($currentTransaction) {
            $transactions[] = $currentTransaction;
        }

        return $transactions;
    }

    /**
     * Parse CAMT.053 XML format
     */
    private function parseCamt053(string $content): array
    {
        $transactions = [];

        try {
            $xml = simplexml_load_string($content);

            // Register namespace if needed
            $namespaces = $xml->getNamespaces(true);
            if (isset($namespaces[''])) {
                $xml->registerXPathNamespace('camt', $namespaces['']);
            }

            // Try different XPath patterns for CAMT.053
            $entries = $xml->xpath('//Ntry') ?: $xml->xpath('//Entry') ?: [];

            foreach ($entries as $entry) {
                try {
                    // Get amount
                    $amount = (float) $entry->Amt ?? 0;

                    // Get date
                    $dateNode = $entry->BookgDt->Dt ?? $entry->ValDt->Dt ?? $entry->Dt ?? null;
                    $date = $dateNode ? Carbon::parse((string) $dateNode)->format('Y-m-d') : null;

                    // Get reference/purpose
                    $reference = '';
                    if (isset($entry->NtryDtls->TxDtls->RmtInf->Ustrd)) {
                        $reference = (string) $entry->NtryDtls->TxDtls->RmtInf->Ustrd;
                    } elseif (isset($entry->AddtlNtryInf)) {
                        $reference = (string) $entry->AddtlNtryInf;
                    }

                    // Get creditor/debtor information
                    $party = '';
                    if (isset($entry->NtryDtls->TxDtls->RltdPties->Cdtr->Nm)) {
                        $party = (string) $entry->NtryDtls->TxDtls->RltdPties->Cdtr->Nm;
                    } elseif (isset($entry->NtryDtls->TxDtls->RltdPties->Dbtr->Nm)) {
                        $party = (string) $entry->NtryDtls->TxDtls->RltdPties->Dbtr->Nm;
                    }

                    // Only process credit entries (incoming payments)
                    $creditDebitIndicator = (string) ($entry->CdtDbtInd ?? '');
                    if ($creditDebitIndicator === 'CRDT' || $amount > 0) {
                        $transactions[] = [
                            'datum' => $date ?: Carbon::now()->format('Y-m-d'),
                            'verwendungszweck' => $reference,
                            'betrag' => abs($amount),
                            'waehrung' => 'EUR',
                            'sender' => $party,
                            'empfaenger' => '',
                            'raw_data' => $entry,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing CAMT.053 entry', ['error' => $e->getMessage()]);
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('Error parsing CAMT.053 XML', ['error' => $e->getMessage()]);
            throw new \Exception('Fehler beim Parsen der CAMT.053 XML-Datei: ' . $e->getMessage());
        }

        return $transactions;
    }

    /**
     * Match transactions to existing invoices
     */
    private function matchTransactionsToInvoices(array $transactions, string $matchingMode): array
    {
        $matches = [];

        foreach ($transactions as $transaction) {
            $match = $this->findMatchingInvoice($transaction);

            $matches[] = [
                'transaction' => $transaction,
                'invoice' => $match,
                'confidence' => $match ? $this->calculateMatchConfidence($transaction, $match) : 0,
                'status' => $match ? 'matched' : 'unmatched',
            ];
        }

        return $matches;
    }

    /**
     * Find matching invoice for a transaction
     */
    private function findMatchingInvoice(array $transaction): ?Rechnung
    {
        $verwendungszweck = strtolower($transaction['verwendungszweck']);
        $betrag = abs($transaction['betrag']);

        // Try to find invoice by amount and date range
        $datum = Carbon::parse($transaction['datum']);
        $fromDate = $datum->copy()->subDays(30)->format('Y-m-d');
        $toDate = $datum->copy()->addDays(60)->format('Y-m-d');

        $invoices = Rechnung::whereBetween('rechnungsdatum', [$fromDate, $toDate])
            ->whereNull('buchungsdatum') // Not yet paid
            ->get();

        foreach ($invoices as $invoice) {
            $invoiceTotal = $invoice->rechnungssumme ?? 0;

            // Check if amount matches (within 1 cent tolerance)
            if (abs($invoiceTotal - $betrag) <= 0.01) {
                return $invoice;
            }

            // Check if invoice number is mentioned in Verwendungszweck
            $invoiceNumber = $invoice->rechnungsnummer ?? $invoice->id;
            if (strpos($verwendungszweck, (string) $invoiceNumber) !== false) {
                return $invoice;
            }
        }

        return null;
    }

    /**
     * Calculate match confidence (0-100)
     */
    private function calculateMatchConfidence(array $transaction, Rechnung $invoice): int
    {
        $confidence = 0;
        $betrag = abs($transaction['betrag']);
        $invoiceTotal = $invoice->rechnungssumme ?? 0;

        // Amount match (40 points)
        if (abs($invoiceTotal - $betrag) <= 0.01) {
            $confidence += 40;
        } elseif (abs($invoiceTotal - $betrag) <= 1.00) {
            $confidence += 20;
        }

        // Date proximity (30 points)
        $transactionDate = Carbon::parse($transaction['datum']);
        $invoiceDate = Carbon::parse($invoice->rechnungsdatum);
        $daysDiff = abs($transactionDate->diffInDays($invoiceDate));

        if ($daysDiff <= 7) {
            $confidence += 30;
        } elseif ($daysDiff <= 30) {
            $confidence += 20;
        } elseif ($daysDiff <= 60) {
            $confidence += 10;
        }

        // Invoice number in Verwendungszweck (30 points)
        $verwendungszweck = strtolower($transaction['verwendungszweck']);
        $invoiceNumber = $invoice->rechnungsnummer ?? $invoice->id;
        if (strpos($verwendungszweck, (string) $invoiceNumber) !== false) {
            $confidence += 30;
        }

        return min(100, $confidence);
    }

    /**
     * Process matches and update invoices
     */
    private function processMatches(array $matches): int
    {
        $processedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($matches as $match) {
                if ($match['status'] === 'matched' && $match['confidence'] >= 70) {
                    $invoice = $match['invoice'];
                    $transaction = $match['transaction'];

                    // Update invoice with payment information
                    $invoice->update([
                        'buchungsdatum' => $transaction['datum'],
                        'geldeingang' => abs($transaction['betrag']),
                        'sepa_transaktions_id' => $transaction['raw_data'][0] ?? null, // Store reference
                        'anmerkungen' => ($invoice->anmerkungen ?? '') . "\nAutomatisch zugeordnet: " . $transaction['verwendungszweck'],
                    ]);

                    $processedCount++;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $processedCount;
    }

    public function testImport()
    {
        try {
            // Test CSV-Data
            $csvData = [
                '30.12.2024;Gutschrift;2025-00001;180.00;EUR;SEPA-Gutschrift;Rechnungsbegleichung',
                '29.12.2024;Gutschrift;2025-00002;10000.00;EUR;SEPA-Gutschrift;Vollzahlung',
            ];

            $transactions = [];
            foreach ($csvData as $line) {
                $parts = explode(';', $line);
                $transactions[] = [
                    'datum' => Carbon::createFromFormat('d.m.Y', $parts[0])->format('Y-m-d'),
                    'betrag' => (float) $parts[3],
                    'verwendungszweck' => $parts[2] . ' ' . $parts[6],
                    'transaktions_id' => 'TEST_' . uniqid(),
                ];
            }

            // Test the matching
            $matchedCount = 0;
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
                            'eingangsbetrag' => $transaction['betrag'],
                            'transaktions_id' => $transaction['transaktions_id'],
                        ]);
                        $matchedCount++;
                    }
                }
            }

            return response()->json([
                'success' => "Test erfolgreich. {$matchedCount} Zahlungen zugeordnet.",
                'data' => [
                    'transactions_found' => count($transactions),
                    'transactions_matched' => $matchedCount,
                    'transactions' => $transactions,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Test-Fehler: ' . $e->getMessage(),
            ], 500);
        }
    }
}
