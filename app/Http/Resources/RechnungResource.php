<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RechnungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // Primary Key
            'id' => $this->id,

            // Foreign Keys
            'bezahlart_id' => $this->bezahlart_id,
            'bezahlstatus_id' => $this->bezahlstatus_id,
            'kreditor_id' => $this->kreditor_id,
            'sourceable_id' => $this->sourceable_id,
            'sourceable_type' => $this->sourceable_type,
            'edit_to' => $this->edit_to,
            'rechnungsexport_id' => $this->rechnungsexport_id,
            'dta_id' => $this->dta_id,

            // Rechnungsidentifikation
            'name' => $this->name,
            'rechnungsnummer' => $this->rechnungsnummer,

            // Rechnungsadresse (statisch)
            'rechnung_name' => $this->rechnung_name,
            'rechnung_adresszusatz' => $this->rechnung_adresszusatz,
            'rechnung_strasse' => $this->rechnung_strasse,
            'rechnung_postleitzahl' => $this->rechnung_postleitzahl,
            'rechnung_ort' => $this->rechnung_ort,

            // Datum- und Betragsfelder
            'rechnungsdatum' => $this->rechnungsdatum,
            'rechnungssumme' => $this->rechnungssumme,
            'faelligkeit' => $this->faelligkeit,
            'buchungsdatum' => $this->buchungsdatum,
            'geldeingang' => $this->geldeingang,
            'offen' => $this->offen,

            // Mahnungen
            'erste_mahnung_am' => $this->erste_mahnung_am,
            'zweite_mahnung_am' => $this->zweite_mahnung_am,
            'dritte_mahnung_am' => $this->dritte_mahnung_am,

            // Storno
            'storno_am' => $this->storno_am,
            'storno_id' => $this->storno_id,

            // Anmerkungen
            'anmerkungen' => $this->anmerkungen,

            // SEPA/Zahlungsverkehr
            'auftraggeber_kontoinhaber' => $this->auftraggeber_kontoinhaber,
            'auftraggeber_iban' => $this->auftraggeber_iban,
            'auftraggeber_bic' => $this->auftraggeber_bic,
            'auftraggeber_bankname' => $this->auftraggeber_bankname,
            'verwendungszweck' => $this->verwendungszweck,
            'auftraggeber_mandatsreferenz' => $this->auftraggeber_mandatsreferenz,
            'sepa_transaktions_id' => $this->sepa_transaktions_id,
            'sepa_reason_code' => $this->sepa_reason_code,
            'waehrung' => $this->waehrung,

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationen
            'kreditor' => new PersonResource($this->whenLoaded('kreditor')),
            'mitgliedsnummer' => $this->whenLoaded('kreditor', function () {
                return $this->kreditor->mitgliedsnummer ?? null;
            }),
            'bezahlart' => $this->whenLoaded('bezahlart', function () {
                return [
                    'id' => $this->bezahlart->id,
                    'name' => $this->bezahlart->name,
                    'beschreibung' => $this->bezahlart->beschreibung ?? null,
                ];
            }),
            'bezahlstatus' => $this->whenLoaded('bezahlstatus', function () {
                return [
                    'id' => $this->bezahlstatus->id,
                    'name' => $this->bezahlstatus->name,
                    'beschreibung' => $this->bezahlstatus->beschreibung ?? null,
                ];
            }),
            'exports' => $this->whenLoaded('exports', function () {
                return $this->exports->map(function ($export) {
                    return [
                        'id' => $export->id,
                        'titel' => $export->titel,
                        'status' => $export->status,
                        'status_text' => $export->status_text,
                        'anzahl_rechnungen' => $export->anzahl_rechnungen,
                        'gesamtbetrag' => $export->gesamtbetrag,
                        'erstellt_am_deutsch' => $export->erstellt_am_deutsch,
                        'export_betrag' => $export->pivot->export_betrag,
                        'export_typ' => $export->pivot->export_typ,
                        'export_datum' => $export->pivot->created_at->format('d.m.Y H:i'),
                    ];
                });
            }),
            'export_status' => $this->whenLoaded('exports', function () {
                if ($this->exports->isEmpty()) {
                    return 'Nicht exportiert';
                }

                $exportCount = $this->exports->count();
                $lastExport = $this->exports->sortByDesc('pivot.created_at')->first();

                if ($exportCount === 1) {
                    return "Export #{$lastExport->id} ({$lastExport->status_text})";
                } else {
                    return "{$exportCount}x exportiert (letzter: #{$lastExport->id})";
                }
            }) ?? 'Nicht exportiert',
            'rechnungsposten' => RechnungspostenResource::collection($this->whenLoaded('rechnungsposten')),

            // Computed Properties (nur wenn Relationen geladen sind)
            'vollname_kreditor' => $this->when($this->relationLoaded('kreditor'), function () {
                return $this->kreditor ?
                    trim(($this->kreditor->vorname ?? '') . ' ' . ($this->kreditor->nachname ?? '')) : null;
            }),
            'vollname_empfaenger' => $this->when($this->relationLoaded('empfaenger'), function () {
                return $this->empfaenger ?
                    trim(($this->empfaenger->vorname ?? '') . ' ' . ($this->empfaenger->nachname ?? '')) : null;
            }),

            // Berechnete Felder
            'ist_bezahlt' => $this->bezahlstatus_id == 2,
            'ist_offen' => $this->bezahlstatus_id == 1,
            'ist_ueberbezahlt' => $this->bezahlstatus_id == 3,
            'ist_unterbezahlt' => $this->bezahlstatus_id == 4,
            'hat_ruecklastschrift' => $this->bezahlstatus_id == 5 || ! empty($this->sepa_reason_code),
            'ist_storniert' => ! empty($this->storno_am),
            'offener_betrag' => ($this->rechnungssumme ?? 0) - ($this->geldeingang ?? 0),
        ];
    }
}
