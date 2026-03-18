<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEPA Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SEPA direct debits and credit transfers
    |
    */

    // Gläubiger-Identifikation für SEPA-Lastschriften
    'creditor_id' => env('SEPA_CREDITOR_ID', 'DE98ZZZ09999999999'),

    // IBAN des Gläubigers (für Lastschriften)
    'creditor_iban' => env('SEPA_CREDITOR_IBAN', 'DE89370400440532013000'),

    // BIC des Gläubigers (optional bei deutschen IBANs)
    'creditor_bic' => env('SEPA_CREDITOR_BIC', null),

    // IBAN des Schuldners (für Überweisungen)
    'debtor_iban' => env('SEPA_DEBTOR_IBAN', 'DE89370400440532013000'),

    // BIC des Schuldners (optional bei deutschen IBANs)
    'debtor_bic' => env('SEPA_DEBTOR_BIC', null),

    // Standardwährung
    'currency' => env('SEPA_CURRENCY', 'EUR'),

    // Standard-Ausführungsdatum (Tage in der Zukunft)
    'execution_days_ahead' => env('SEPA_EXECUTION_DAYS_AHEAD', 1),

    // Verwendungszweck-Präfix
    'purpose_prefix' => env('SEPA_PURPOSE_PREFIX', 'DRC'),

    // Standard-Mandatsdatum (falls nicht gesetzt)
    'default_mandate_date' => env('SEPA_DEFAULT_MANDATE_DATE', '2025-01-01'),
];
