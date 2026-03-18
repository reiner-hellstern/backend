<?php

namespace App\Http\Controllers;

use App\Http\Resources\RechnungResource;
use App\Models\Person;
use App\Models\Rechnung;
use App\Models\Rechnungsposten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RechnungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'rechnungsnummer');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $columns = $columns ?? [];
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        // Build base query
        $personen = Rechnung::with('kreditor', 'exports', 'bezahlstatus', 'bezahlart')
            ->select('rechnungen.*', 'personen.*', 'personen.id AS person_id', 'rechnungen.id AS id')
            ->leftjoin('personen', 'personen.id', '=', 'rechnungen.kreditor_id')
            ->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    if ($column['db_field_as']) {
                        $column['db_field'] = $column['db_field_as'];
                    }
                    $table = $column['table'] . '.';
                    if ($column['filterable'] == true && $column['filtertype'] != 0) {
                        switch ($column['filtertype']) {
                            case 2:
                                $query->where($table . $column['db_field'], 'NOT LIKE', '%' . $column['filter'] . '%');
                                break;
                            case 3:
                                $query->where($table . $column['db_field'], 'LIKE', $column['filter'] . '%');
                                break;
                            case 4: //LEER
                                $query->where(function ($q) use ($table, $column) {
                                    $q->whereNull($table . $column['db_field'])->orWhere($table . $column['db_field'], '=', '')->orWhere($table . $column['db_field'], '=', '0000-00-00');
                                });
                                break;
                            case 5:  //NICHT LEER
                                $query->whereNotNull($table . $column['db_field'])->where($table . $column['db_field'], '<>', '')->where($table . $column['db_field'], '<>', '0000-00-00');
                                break;
                            case 6:
                                $query->where($table . $column['db_field'], '=', $column['filter']);
                                break;
                            case 7:
                                $query->where($table . $column['db_field'], '<>', $column['filter']);
                                break;
                            case 8:
                                $query->where($table . $column['db_field'], '>', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                break;
                            case 9:
                                $query->where($table . $column['db_field'], '<', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                break;
                            case 10:
                                $query->where($table . $column['db_field'], '>=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                break;
                            case 11:
                                $query->where($table . $column['db_field'], '<=', $column['filter'])->where($table . $column['db_field'], '<>', '');
                                break;
                            case 12:
                                $sqldate = date('Y-m-d', strtotime($column['filter']));
                                $query->whereDate($table . $column['db_field'], $sqldate);
                                break;
                            case 13:
                                $sqldate = date('Y-m-d', strtotime($column['filter']));

                                $query->where($table . $column['db_field'], '<=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                                break;
                            case 14:
                                $sqldate = date('Y-m-d', strtotime($column['filter']));
                                $query->where($table . $column['db_field'], '>=', $sqldate)->where($table . $column['db_field'], '<>', '0000-00-00');
                                break;
                            case 1:
                            default:
                                $query->where($table . $column['db_field'], 'LIKE', '%' . $column['filter'] . '%');
                                break;
                        }
                    }
                }
            })->when($search != '', function ($query) use ($columns, $search) {
                $first = true;
                foreach ($columns as $column) {
                    if ($column['db_field_as']) {
                        $column['db_field'] = $column['db_field_as'];
                    }
                    $table = $column['table'] . '.';
                    if ($column['searchable'] == true) {
                        if ($first == true) {
                            $query->where($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                            $first = false;
                        } else {
                            $query->orWhere($table . $column['db_field'], 'LIKE', '%' . $search . '%');
                        }
                    }
                }
            })->orderBy($sortField === 'id' ? 'rechnungen.id' : $sortField, $sortDirection)->paginate($pagination);

        return RechnungResource::collection($personen);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:40',
            'kreditor_id' => 'required|exists:personen,id',
            'rechnungsdatum' => 'required|date',
            'faelligkeit' => 'nullable|date',
            'bezahlstatus_id' => 'required|integer',
            'anmerkungen' => 'nullable|string',
        ]);

        $rechnung = Rechnung::create([
            'name' => $request->name,
            'rechnungsnummer' => $this->generateRechnungsnummer(),
            'kreditor_id' => $request->kreditor_id,
            'rechnungsdatum' => $request->rechnungsdatum,
            'faelligkeit' => $request->faelligkeit,
            'bezahlstatus_id' => $request->bezahlstatus_id,
            'rechnungssumme' => 0,
            'anmerkungen' => $request->anmerkungen,
        ]);

        return response()->json($rechnung->load(['kreditor', 'rechnungsposten']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rechnung $rechnung)
    {
        $rechnung->load([
            'bezahlart',
            'bezahlstatus',
            'kreditor',
            'kreditor.mitglied',
            'rechnungssteller',
            'rechnungssteller.bankverbindung',
            'bankverbindung',
            'notizen',
            'dokumente',
            'rechnungsposten.gebuehr',
            'exports',
            'createdBy',
            'updatedBy',
        ]);

        // Erweiterte Kreditor-Daten mit Bankverbindungen
        $kreditorData = null;
        if ($rechnung->kreditor) {
            $kreditor = $rechnung->kreditor;

            // Persönliche Bankverbindung über Relation (für Vereinsleistungen)
            $persoenlicheBankverbindung = $kreditor->bankverbindung;

            // Mitglieds-Bankverbindung über Relation (für Mitgliedsbeiträge)
            $mitgliedsBankverbindung = null;
            if ($kreditor->mitglied) {
                $mitgliedsBankverbindung = $kreditor->mitglied->bankverbindung;
            }

            $kreditorData = $kreditor->toArray();
            $kreditorData['persoenliche_bankverbindung'] = $persoenlicheBankverbindung;
            $kreditorData['mitglieds_bankverbindung'] = $mitgliedsBankverbindung;

            // Bestimme die beste verfügbare Bankverbindung für SEPA-Daten
            $besteBankverbindung = null;

            // Priorität: 1. Mitglieds-Bankverbindung (falls vorhanden), 2. Persönliche Bankverbindung
            if ($mitgliedsBankverbindung) {
                $besteBankverbindung = $mitgliedsBankverbindung;
                $kreditorData['bevorzugte_bankverbindung_typ'] = 'mitglied';
            } elseif ($persoenlicheBankverbindung) {
                $besteBankverbindung = $persoenlicheBankverbindung;
                $kreditorData['bevorzugte_bankverbindung_typ'] = 'person';
            }

            // SEPA-Daten für Frontend-Kompatibilität
            if ($besteBankverbindung) {
                $kreditorData['iban'] = $besteBankverbindung->iban;
                $kreditorData['bic'] = $besteBankverbindung->bic;
                $kreditorData['mandatsreferenz'] = $besteBankverbindung->mandatsreferenz;
                $kreditorData['kontoinhaber'] = $besteBankverbindung->kontoinhaber;
                $kreditorData['bankname'] = $besteBankverbindung->bankname;
            }
        }

        return response()->json([
            'success' => 'Rechnung erfolgreich geladen',
            'error' => null,
            'data' => [
                'rechnung' => $rechnung,
                'kreditor' => $kreditorData,
                'rechnungsposten' => $rechnung->rechnungsposten,
                'notizen' => $rechnung->notizen,
                'dokumente' => $rechnung->dokumente,
                'zahlungen' => [], // TODO: Falls Zahlungen-Tabelle existiert
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rechnung $rechnung)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|nullable|string|max:40',
                'kreditor_id' => 'sometimes|exists:personen,id',
                'rechungssteller_id' => 'sometimes|nullable|exists:gruppen,id',
                'bankverbindung_id' => 'sometimes|nullable|exists:bankverbindungen,id',
                'rechnungsnummer' => 'sometimes|string|max:255',
                'rechnungsdatum' => 'sometimes|date',
                'faelligkeit' => 'nullable|date',
                'rechnungssumme' => 'sometimes|numeric',
                'geldeingang' => 'sometimes|numeric',
                'offen' => 'sometimes|numeric',
                'buchungsdatum' => 'nullable|date',
                'rechnung_name' => 'nullable|string|max:255',
                'rechnung_strasse' => 'nullable|string|max:255',
                'rechnung_postleitzahl' => 'nullable|string|max:255',
                'rechnung_ort' => 'nullable|string|max:255',
                'rechnung_adresszusatz' => 'nullable|string|max:255',
                'bezahlart_id' => 'nullable|integer',
                'bezahlstatus_id' => 'nullable|integer',
                'auftraggeber_iban' => 'nullable|string|max:255',
                'auftraggeber_bic' => 'nullable|string|max:255',
                'auftraggeber_kontoinhaber' => 'nullable|string|max:255',
                'auftraggeber_mandatsreferenz' => 'nullable|string|max:255',
                'auftraggeber_bankname' => 'nullable|string|max:255',
                'sepa_transaktions_id' => 'nullable|string|max:255',
                'sepa_reason_code' => 'nullable|string|max:255',
                'verwendungszweck' => 'nullable|string|max:255',
                'waehrung' => 'nullable|string|max:10',
                'ruecklastschrift_grund' => 'nullable|string|max:255',
                'ruecklastschrift_am' => 'nullable|date',
                'ruecklastschrift_bemerkung' => 'nullable|string',
                'storno_id' => 'nullable|integer',
                'storno_am' => 'nullable|date',
                'erste_mahnung_am' => 'nullable|date',
                'zweite_mahnung_am' => 'nullable|date',
                'dritte_mahnung_am' => 'nullable|date',
                'inkasso_datum' => 'nullable|date',
                'anmerkungen' => 'nullable|string',
                'name' => 'nullable|string|max:40',

                // Rechnungsposten validation
                'rechnungsposten' => 'nullable|array',
                'rechnungsposten.*.id' => 'nullable|numeric', // Allow numeric for temporary IDs
                'rechnungsposten.*.beschreibung' => 'required|string|max:255',
                'rechnungsposten.*.anzahl' => 'required|numeric|min:0',
                'rechnungsposten.*.einzelpreis' => 'required|numeric|min:0',
                'rechnungsposten.*.gebuehr_id' => 'nullable|integer|exists:gebuehren,id',
                'rechnungsposten.*.order' => 'nullable|integer',
                'rechnungsposten.*.aktiv' => 'nullable|boolean',
            ]);

            DB::beginTransaction();

            // Rechnung Grunddaten aktualisieren
            $rechnungData = collect($validated)->except(['rechnungsposten'])->toArray();
            $rechnungData['updated_by'] = Auth::id();
            $rechnung->update($rechnungData);

            // Rechnungsposten aktualisieren/erstellen
            if (isset($validated['rechnungsposten'])) {
                // Lösche alle existierenden Rechnungsposten
                $rechnung->rechnungsposten()->delete();

                // Erstelle neue Rechnungsposten
                foreach ($validated['rechnungsposten'] as $index => $postenData) {
                    if (! empty($postenData['beschreibung'])) {
                        $postenData['rechnung_id'] = $rechnung->id;
                        $postenData['order'] = $postenData['order'] ?? $index + 1;
                        $postenData['aktiv'] = $postenData['aktiv'] ?? true;

                        // Entferne temporäre negative IDs und Frontend-spezifische Felder
                        if (isset($postenData['id']) && $postenData['id'] < 0) {
                            unset($postenData['id']);
                        }

                        Rechnungsposten::create($postenData);
                    }
                }
            }

            DB::commit();

            // Lade aktualisierte Rechnung mit Rechnungsposten
            $rechnung = $rechnung->fresh(['rechnungsposten', 'kreditor']);

            return response()->json([
                'success' => true,
                'message' => 'Rechnung erfolgreich aktualisiert',
                'data' => $rechnung,
                'error' => null,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'Validierungsfehler: ' . implode(', ', collect($e->errors())->flatten()->toArray()),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'Fehler beim Aktualisieren der Rechnung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rechnung $rechnung)
    {
        $rechnung->delete();

        return response()->json(['message' => 'Rechnung erfolgreich gelöscht']);
    }

    /**
     * Add Rechnungsposten to a Rechnung
     */
    public function addPosten(Request $request, Rechnung $rechnung)
    {
        $request->validate([
            'gebuehr_id' => 'required|exists:gebuehren,id',
            'beschreibung' => 'nullable|string',
            'menge' => 'required|numeric|min:0.01',
            'einzelpreis' => 'required|numeric|min:0',
            'notizen' => 'nullable|string',
        ]);

        $posten = $rechnung->rechnungsposten()->create([
            'gebuehr_id' => $request->gebuehr_id,
            'beschreibung' => $request->beschreibung,
            'menge' => $request->menge,
            'einzelpreis' => $request->einzelpreis,
            'notizen' => $request->notizen,
        ]);

        return response()->json($posten->load('gebuehr'), 201);
    }

    /**
     * Remove Rechnungsposten from a Rechnung
     */
    public function removePosten(Rechnung $rechnung, Rechnungsposten $posten)
    {
        if ($posten->rechnung_id !== $rechnung->id) {
            return response()->json(['error' => 'Posten gehört nicht zu dieser Rechnung'], 400);
        }

        $posten->delete();

        return response()->json(['message' => 'Posten erfolgreich entfernt']);
    }

    /**
     * Mark Rechnung as paid
     */
    public function markiereBezahlt(Rechnung $rechnung)
    {
        $rechnung->markiereBezahlt();

        return response()->json($rechnung->load(['person', 'rechnungsposten']));
    }

    /**
     * Get Gebühren for autocomplete
     */
    public function getGebuehren(Request $request)
    {
        $search = $request->input('search', '');

        // Use raw query to join with gebuehrenkatalog
        $query = DB::table('gebuehren as g')
            ->leftJoin('gebuehrenkatalog as gk', 'g.gebuehrenkatalog_id', '=', 'gk.id')
            ->select(
                'g.id',
                'gk.name',
                'gk.beschreibung',
                'g.kosten_mitglied as kosten_mitglied',
                'g.kosten_nichtmitglied as kosten_nichtmitglied',
                'g.kosten_mitglied as kosten', // Default price for display
                'gk.mkonto as mitgliedsbeitrag'
            )
            ->where('g.aktiv', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('gk.name', 'like', "%{$search}%")
                    ->orWhere('gk.beschreibung', 'like', "%{$search}%");
            });
        }

        $gebuehren = $query->orderBy('gk.name')
            ->get();

        return response()->json($gebuehren);
    }

    /**
     * Get Personen for autocomplete
     */
    public function getPersonen(Request $request)
    {
        $search = $request->input('search', '');

        $query = Person::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nachname', 'like', "%{$search}%")
                    ->orWhere('vorname', 'like', "%{$search}%");
            });
        }

        $personen = $query->orderBy('nachname')
            ->orderBy('vorname')
            ->limit(20)
            ->get(['id', 'vorname', 'nachname']);

        return response()->json($personen);
    }

    /**
     * Generate unique Rechnungsnummer
     */
    private function generateRechnungsnummer()
    {
        $year = date('Y');
        $lastRechnung = Rechnung::where('rechnungsnummer', 'like', $year . '%')
            ->orderBy('rechnungsnummer', 'desc')
            ->first();

        if ($lastRechnung) {
            $lastNumber = (int) substr($lastRechnung->rechnungsnummer, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $year . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Export Lastschriften als SEPA XML
     */
    public function exportLastschriften(Request $request)
    {
        $rechnungIds = $request->input('rechnung_ids', []);

        if (empty($rechnungIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Keine Rechnungen ausgewählt',
            ], 400);
        }

        $rechnungen = Rechnung::with('kreditor')
            ->whereIn('id', $rechnungIds)
            ->where('bezahlart_id', 1) // 1 = Lastschrift
            ->where('bezahlstatus_id', 1) // 1 = kein Eingang (offen)
            ->get();

        if ($rechnungen->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keine offenen Lastschriften gefunden',
            ], 400);
        }

        try {
            $sepaXml = $this->generiereSepaLastschriftDatei($rechnungen);

            // Status auf 'eingereicht' setzen
            foreach ($rechnungen as $rechnung) {
                $rechnung->update([
                    'zahlungsstatus' => 'eingereicht',
                    'exportiert' => true,
                    'exportiert_am' => now(),
                ]);
            }

            $filename = 'SEPA_Lastschriften_' . date('Y-m-d_H-i-s') . '.xml';

            return response($sepaXml, 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fehler beim Generieren der SEPA-Datei: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export Überweisungen als SEPA XML
     */
    public function exportUeberweisungen(Request $request)
    {
        $rechnungIds = $request->input('rechnung_ids', []);

        if (empty($rechnungIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Keine Rechnungen ausgewählt',
            ], 400);
        }

        $rechnungen = Rechnung::with('kreditor')
            ->whereIn('id', $rechnungIds)
            ->where('bezahlart_id', 2) // 2 = Überweisung
            ->where('bezahlstatus_id', 1) // 1 = kein Eingang (offen)
            ->get();

        if ($rechnungen->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keine offenen Überweisungen gefunden',
            ], 400);
        }

        try {
            $sepaXml = $this->generiereSepaUeberweisungDatei($rechnungen);

            // Status auf 'eingereicht' setzen
            foreach ($rechnungen as $rechnung) {
                $rechnung->update([
                    'zahlungsstatus' => 'eingereicht',
                    'exportiert' => true,
                    'exportiert_am' => now(),
                ]);
            }

            $filename = 'SEPA_Ueberweisungen_' . date('Y-m-d_H-i-s') . '.xml';

            return response($sepaXml, 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fehler beim Generieren der SEPA-Datei: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generiere SEPA Lastschrift XML
     */
    private function generiereSepaLastschriftDatei($rechnungen)
    {
        $messageId = 'DRC-DD-' . date('YmdHis');
        $batchId = 'BATCH-' . date('YmdHis');
        $gesamtbetrag = $rechnungen->sum('summe');
        $anzahlTransaktionen = $rechnungen->count();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' . "\n";
        $xml .= '  <CstmrDrctDbtInitn>' . "\n";

        // Group Header
        $xml .= '    <GrpHdr>' . "\n";
        $xml .= '      <MsgId>' . $messageId . '</MsgId>' . "\n";
        $xml .= '      <CreDtTm>' . date('c') . '</CreDtTm>' . "\n";
        $xml .= '      <NbOfTxs>' . $anzahlTransaktionen . '</NbOfTxs>' . "\n";
        $xml .= '      <CtrlSum>' . number_format($gesamtbetrag, 2, '.', '') . '</CtrlSum>' . "\n";
        $xml .= '      <InitgPty>' . "\n";
        $xml .= '        <Nm>' . htmlspecialchars(config('app.company_name', 'DRC')) . '</Nm>' . "\n";
        $xml .= '      </InitgPty>' . "\n";
        $xml .= '    </GrpHdr>' . "\n";

        // Payment Information
        $xml .= '    <PmtInf>' . "\n";
        $xml .= '      <PmtInfId>' . $batchId . '</PmtInfId>' . "\n";
        $xml .= '      <PmtMtd>DD</PmtMtd>' . "\n";
        $xml .= '      <NbOfTxs>' . $anzahlTransaktionen . '</NbOfTxs>' . "\n";
        $xml .= '      <CtrlSum>' . number_format($gesamtbetrag, 2, '.', '') . '</CtrlSum>' . "\n";
        $xml .= '      <ReqdColltnDt>' . date('Y-m-d') . '</ReqdColltnDt>' . "\n";

        // Creditor
        $xml .= '      <Cdtr>' . "\n";
        $xml .= '        <Nm>' . htmlspecialchars(config('app.company_name', 'DRC')) . '</Nm>' . "\n";
        $xml .= '      </Cdtr>' . "\n";
        $xml .= '      <CdtrAcct>' . "\n";
        $xml .= '        <Id>' . "\n";
        $xml .= '          <IBAN>' . config('sepa.creditor_iban') . '</IBAN>' . "\n";
        $xml .= '        </Id>' . "\n";
        $xml .= '      </CdtrAcct>' . "\n";

        // Creditor Scheme Identification
        $xml .= '      <CdtrSchmeId>' . "\n";
        $xml .= '        <Id>' . "\n";
        $xml .= '          <PrvtId>' . "\n";
        $xml .= '            <Othr>' . "\n";
        $xml .= '              <Id>' . config('sepa.creditor_id') . '</Id>' . "\n";
        $xml .= '              <SchmeNm>' . "\n";
        $xml .= '                <Prtry>SEPA</Prtry>' . "\n";
        $xml .= '              </SchmeNm>' . "\n";
        $xml .= '            </Othr>' . "\n";
        $xml .= '          </PrvtId>' . "\n";
        $xml .= '        </Id>' . "\n";
        $xml .= '      </CdtrSchmeId>' . "\n";

        // Direct Debit Transaction Information
        foreach ($rechnungen as $rechnung) {
            $xml .= '      <DrctDbtTxInf>' . "\n";
            $xml .= '        <PmtId>' . "\n";
            $xml .= '          <EndToEndId>RECH-' . $rechnung->rechnungsnummer . '</EndToEndId>' . "\n";
            $xml .= '        </PmtId>' . "\n";
            $xml .= '        <InstdAmt Ccy="EUR">' . number_format($rechnung->summe, 2, '.', '') . '</InstdAmt>' . "\n";
            $xml .= '        <DrctDbtTx>' . "\n";
            $xml .= '          <MndtRltdInf>' . "\n";
            $xml .= '            <MndtId>' . ($rechnung->mandatsreferenz ?: 'MANDAT-' . $rechnung->kreditor_id) . '</MndtId>' . "\n";
            $xml .= '            <DtOfSgntr>' . ($rechnung->kreditor->mandat_datum ?? date('Y-m-d')) . '</DtOfSgntr>' . "\n";
            $xml .= '          </MndtRltdInf>' . "\n";
            $xml .= '        </DrctDbtTx>' . "\n";
            $xml .= '        <Dbtr>' . "\n";
            $xml .= '          <Nm>' . htmlspecialchars($rechnung->auftraggeber_name ?: $rechnung->kreditor->vollname) . '</Nm>' . "\n";
            $xml .= '        </Dbtr>' . "\n";
            $xml .= '        <DbtrAcct>' . "\n";
            $xml .= '          <Id>' . "\n";
            $xml .= '            <IBAN>' . $rechnung->auftraggeber_iban . '</IBAN>' . "\n";
            $xml .= '          </Id>' . "\n";
            $xml .= '        </DbtrAcct>' . "\n";
            $xml .= '        <RmtInf>' . "\n";
            $xml .= '          <Ustrd>' . htmlspecialchars($rechnung->verwendungszweck ?: "Rechnung {$rechnung->rechnungsnummer}") . '</Ustrd>' . "\n";
            $xml .= '        </RmtInf>' . "\n";
            $xml .= '      </DrctDbtTxInf>' . "\n";
        }

        $xml .= '    </PmtInf>' . "\n";
        $xml .= '  </CstmrDrctDbtInitn>' . "\n";
        $xml .= '</Document>';

        return $xml;
    }

    /**
     * Generiere SEPA Überweisung XML
     */
    private function generiereSepaUeberweisungDatei($rechnungen)
    {
        $messageId = 'DRC-CT-' . date('YmdHis');
        $batchId = 'BATCH-' . date('YmdHis');
        $gesamtbetrag = $rechnungen->sum('summe');
        $anzahlTransaktionen = $rechnungen->count();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' . "\n";
        $xml .= '  <CstmrCdtTrfInitn>' . "\n";

        // Group Header
        $xml .= '    <GrpHdr>' . "\n";
        $xml .= '      <MsgId>' . $messageId . '</MsgId>' . "\n";
        $xml .= '      <CreDtTm>' . date('c') . '</CreDtTm>' . "\n";
        $xml .= '      <NbOfTxs>' . $anzahlTransaktionen . '</NbOfTxs>' . "\n";
        $xml .= '      <CtrlSum>' . number_format($gesamtbetrag, 2, '.', '') . '</CtrlSum>' . "\n";
        $xml .= '      <InitgPty>' . "\n";
        $xml .= '        <Nm>' . htmlspecialchars(config('app.company_name', 'DRC')) . '</Nm>' . "\n";
        $xml .= '      </InitgPty>' . "\n";
        $xml .= '    </GrpHdr>' . "\n";

        // Payment Information
        $xml .= '    <PmtInf>' . "\n";
        $xml .= '      <PmtInfId>' . $batchId . '</PmtInfId>' . "\n";
        $xml .= '      <PmtMtd>TRF</PmtMtd>' . "\n";
        $xml .= '      <NbOfTxs>' . $anzahlTransaktionen . '</NbOfTxs>' . "\n";
        $xml .= '      <CtrlSum>' . number_format($gesamtbetrag, 2, '.', '') . '</CtrlSum>' . "\n";
        $xml .= '      <ReqdExctnDt>' . date('Y-m-d') . '</ReqdExctnDt>' . "\n";

        // Debtor
        $xml .= '      <Dbtr>' . "\n";
        $xml .= '        <Nm>' . htmlspecialchars(config('app.company_name', 'DRC')) . '</Nm>' . "\n";
        $xml .= '      </Dbtr>' . "\n";
        $xml .= '      <DbtrAcct>' . "\n";
        $xml .= '        <Id>' . "\n";
        $xml .= '          <IBAN>' . config('sepa.debtor_iban') . '</IBAN>' . "\n";
        $xml .= '        </Id>' . "\n";
        $xml .= '      </DbtrAcct>' . "\n";

        // Credit Transfer Transaction Information
        foreach ($rechnungen as $rechnung) {
            $xml .= '      <CdtTrfTxInf>' . "\n";
            $xml .= '        <PmtId>' . "\n";
            $xml .= '          <EndToEndId>RECH-' . $rechnung->rechnungsnummer . '</EndToEndId>' . "\n";
            $xml .= '        </PmtId>' . "\n";
            $xml .= '        <Amt>' . "\n";
            $xml .= '          <InstdAmt Ccy="EUR">' . number_format($rechnung->summe, 2, '.', '') . '</InstdAmt>' . "\n";
            $xml .= '        </Amt>' . "\n";
            $xml .= '        <Cdtr>' . "\n";
            $xml .= '          <Nm>' . htmlspecialchars($rechnung->empfaenger_name ?: $rechnung->person->vollname) . '</Nm>' . "\n";
            $xml .= '        </Cdtr>' . "\n";
            $xml .= '        <CdtrAcct>' . "\n";
            $xml .= '          <Id>' . "\n";
            $xml .= '            <IBAN>' . $rechnung->empfaenger_iban . '</IBAN>' . "\n";
            $xml .= '          </Id>' . "\n";
            $xml .= '        </CdtrAcct>' . "\n";
            $xml .= '        <RmtInf>' . "\n";
            $xml .= '          <Ustrd>' . htmlspecialchars($rechnung->verwendungszweck ?: "Rechnung {$rechnung->rechnungsnummer}") . '</Ustrd>' . "\n";
            $xml .= '        </RmtInf>' . "\n";
            $xml .= '      </CdtTrfTxInf>' . "\n";
        }

        $xml .= '    </PmtInf>' . "\n";
        $xml .= '  </CstmrCdtTrfInitn>' . "\n";
        $xml .= '</Document>';

        return $xml;
    }

    /**
     * Rücklastschrift verbuchen
     */
    public function ruecklastschrift(Request $request, Rechnung $rechnung)
    {
        $request->validate([
            'grund' => 'required|string|max:255',
            'datum' => 'required|date',
        ]);

        if (! $rechnung->istLastschrift()) {
            return response()->json([
                'success' => false,
                'message' => 'Rechnung ist keine Lastschrift',
            ], 400);
        }

        $rechnung->markiereRuecklastschrift($request->grund, $request->datum);

        return response()->json([
            'success' => true,
            'message' => 'Rücklastschrift erfolgreich verbucht',
            'data' => new RechnungResource($rechnung),
        ]);
    }

    /**
     * Get options for dropdowns
     */
    public function options()
    {
        try {
            $bezahlarten = \DB::table('optionen_bezahlarten')->select('id', 'name')->get();
            $bezahlstati = \DB::table('optionen_bezahlstati')->select('id', 'name')->get();

            return response()->json([
                'success' => 'Optionen erfolgreich geladen',
                'error' => null,
                'data' => [
                    'bezahlarten' => $bezahlarten,
                    'bezahlstati' => $bezahlstati,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Optionen: ' . $e->getMessage(),
                'success' => null,
                'data' => null,
            ], 500);
        }
    }
}
