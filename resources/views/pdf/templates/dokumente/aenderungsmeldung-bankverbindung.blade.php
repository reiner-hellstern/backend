@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models\Mitgliedsart')

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit melde ich meine neue Bankverbindung:
    </p>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Mitglied</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->vorname }}
                {{ $aenderungsmeldungBankverbindung->mitglied->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->strasse }}
            </p>
            @if (
                $aenderungsmeldungBankverbindung->mitglied->adresszusatz != null &&
                    $aenderungsmeldungBankverbindung->mitglied->adresszusatz != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $aenderungsmeldungBankverbindung->mitglied->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->postleitzahl }}
                {{ $aenderungsmeldungBankverbindung->mitglied->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->mitgliedsnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->telefon_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $aenderungsmeldungBankverbindung->mitglied->email_1 }}
            </p>
        </div>
    </div>
</div>

@if ($aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung != null)
    <div class="span-12 margin-t-x4 margin-b-x2">
        <span class="mg-headline">Bankverbindung – Mitgliedsbeitrag</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="margin-b-x4">
            <div class="line margin-b-x2">
                <div class="span-12">
                    <p class="subheadline-bold">Bestehende Bankverbindung</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>
            <div class="span-12">
                <p class="copy-bold line-height-100">Name des Kontoinhabers:
                    <span
                        class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->bestehende_verbindung->kontoinhaber }}</span>
                </p>
                <p class="copy-bold line-height-100">Name des Kreditinstituts:
                    <span
                        class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->bestehende_verbindung->bank }}</span>
                </p>
                <p class="copy-bold line-height-100">IBAN:
                    <span
                        class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->bestehende_verbindung->iban }}</span>
                </p>
                <p class="copy-bold line-height-100">BIC:
                    <span
                        class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->bestehende_verbindung->bic }}</span>
                </p>
            </div>
        </div>

        @if ($aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung != null)
            <div class="margin-b-x4">
                <div class="line margin-b-x2">
                    <div class="span-12">
                        <p class="subheadline-bold">Zukünftige Bankverbindung</p>
                        <div class="span-12 border-b">
                            <div class="span-12 border-b"></div>
                        </div>
                    </div>
                </div>
                <div class="span-12">
                    <p class="copy-bold line-height-100">Name des Kontoinhabers:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->kontoinhaber }}</span>
                    </p>
                    <p class="copy-bold line-height-100">Name des Kreditinstituts:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->bank }}</span>
                    </p>
                    <p class="copy-bold line-height-100">IBAN:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->iban }}</span>
                    </p>
                    <p class="copy-bold line-height-100">BIC:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->bic }}</span>
                    </p>
                </div>
            </div>
        @endif

        @if ($aenderungsmeldungBankverbindung->mitglied->mitgliedsart == 0)
            <div class="margin-b-x4">
                <div class="line margin-b-x2">
                    <div class="span-12">
                        <p class="subheadline-bold">Konto-Belastungen</p>
                        <div class="span-12 border-b">
                            <div class="span-12 border-b"></div>
                        </div>
                    </div>
                </div>

                <div class="span-12 margin-b-x2">
                    <p class="inline-block copy-bold line-height-100">Das Konto ist aktuell für folgende
                        DRC-Belastung/en
                        eingetragen:</p>
                </div>
                <div class="span-12">
                    <div class="space-h"></div>
                    <div class="inline-block span-11">
                        <ul>
                            @foreach ($aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->kontobelastungen as $kontobelastung)
                                <li>
                                    <p class="copy line-height-100">{{ $kontobelastung->vorname }}
                                        {{ $kontobelastung->nachname }},
                                        {{ $kontobelastung->mitgliedsart }},
                                        Mitgliedsbeitrag: {{ $kontobelastung->beitrag }} / Jahr
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if ($aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung != null)
            <div class="margin-b-x4">
                <div class="line margin-b-x2">
                    <div class="span-12">
                        <p class="subheadline-bold">SEPA-Lastschriftmandat</p>
                        <div class="span-12 border-b">
                            <div class="span-12 border-b"></div>
                        </div>
                    </div>
                </div>

                <div class="line">
                    <div class="span-12">
                        <p class="copy-bold line-height-100">Gläubiger-Identifikationsnummer: DE97ZZZ00000734841</p>
                    </div>
                    <div class="span-11 extended">
                        <p class="copy line-height-100">
                            Ich ermächtige den Deutscher Retriever Club e.V. Zahlungen von meinem Konto mittels
                            Lastschrift
                            einzuziehen. Zugleich weise ich mein Kreditinstitut an, die vom Zahlungsempfänger Deutscher
                            Retriever
                            Club e.V. auf mein Konto gezogenen Lastschriften einzulösen.
                        </p>
                    </div>
                    <div class="span-11 extended margin-t-x2">
                        <p class="copy line-height-100">
                            Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des
                            belasteten
                            Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
                        </p>
                    </div>
                    <div class="span-11 extended margin-t-x2">
                        <p class="copy line-height-100">
                            Zahlungsart: Wiederkehrende Zahlung – Mandatsreferenz: (wird separat mitgeteilt)
                        </p>
                    </div>
                </div>
                <div class="span-12 margin-t-x2">
                    <p class="copy-bold line-height-100">Name des Kontoinhabers:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->kontoinhaber }}</span>
                    </p>
                    <p class="copy-bold line-height-100">Name des Kreditinstituts:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->bank }}</span>
                    </p>
                    <p class="copy-bold line-height-100">IBAN:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->iban }}</span>
                    </p>
                    <p class="copy-bold line-height-100">BIC:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->bic }}</span>
                    </p>
                </div>

                <div class="pin-bottom">
                    <div class="span-12" style="margin: 1mm 0;">
                        <x-place-date-signature :date="null" :signatureSubline="'Unterschrift, ' .
                            $aenderungsmeldungBankverbindung->bv_mitgliedsbeitraege->neue_verbindung->kontoinhaber .
                            ' (Kontoinhaber)'" />
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="page-break"></div>
@endif
<!-- PAGE 2 -->

@if ($aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung != null)
    <div class="span-12 margin-t-x4 margin-b-x2">
        <span class="mg-headline">Bankverbindung – Vereinsleistungen</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="margin-b-x4">
            <div class="line margin-b-x2">
                <div class="span-12">
                    <p class="subheadline-bold">Bestehende Bankverbindung</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>
            <div class="span-12">
                @if ($aenderungsmeldungBankverbindung->bv_vereinsleistungen->bestehende_verbindung != null)
                    <p class="copy-bold line-height-100">Name des Kontoinhabers:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->bestehende_verbindung->kontoinhaber }}</span>
                    </p>
                    <p class="copy-bold line-height-100">Name des Kreditinstituts:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->bestehende_verbindung->bank }}</span>
                    </p>
                    <p class="copy-bold line-height-100">IBAN:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->bestehende_verbindung->iban }}</span>
                    </p>
                    <p class="copy-bold line-height-100">BIC:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->bestehende_verbindung->bic }}</span>
                    </p>
                @else
                    <p class="copy-bold line-height-100">Kein bestehendes Konto für Vereinsleistungen.</p>
                @endif
            </div>
        </div>
        @if ($aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung != null)
            <div class="margin-b-x4">
                <div class="line margin-b-x2">
                    <div class="span-12">
                        <p class="subheadline-bold">Zukünftige Bankverbindung</p>
                        <div class="span-12 border-b">
                            <div class="span-12 border-b"></div>
                        </div>
                    </div>
                </div>
                <div class="span-12">
                    <p class="copy-bold line-height-100">Name des Kontoinhabers:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->kontoinhaber }}
                        </span>
                    </p>
                    <p class="copy-bold line-height-100">Name des Kreditinstituts:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->bank }}</span>
                    </p>
                    <p class="copy-bold line-height-100">IBAN:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->iban }}</span>
                    </p>
                    <p class="copy-bold line-height-100">BIC:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->bic }}</span>
                    </p>
                </div>
            </div>

            <div class="margin-b-x4">
                <div class="line margin-b-x2">
                    <div class="span-12">
                        <p class="subheadline-bold">SEPA-Lastschriftmandat</p>
                        <div class="span-12 border-b">
                            <div class="span-12 border-b"></div>
                        </div>
                    </div>
                </div>

                <div class="line">
                    <div class="span-12">
                        <p class="copy-bold line-height-100">Gläubiger-Identifikationsnummer: DE97ZZZ00000734841</p>
                    </div>
                    <div class="span-11 extended">
                        <p class="copy line-height-100">
                            Ich ermächtige den Deutscher Retriever Club e.V. Zahlungen von meinem Konto mittels
                            Lastschrift
                            einzuziehen. Zugleich weise ich mein Kreditinstitut an, die vom Zahlungsempfänger Deutscher
                            Retriever
                            Club e.V. auf mein Konto gezogenen Lastschriften einzulösen.
                        </p>
                    </div>
                    <div class="span-11 extended margin-t-x2">
                        <p class="copy line-height-100">
                            Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des
                            belasteten
                            Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
                        </p>
                    </div>
                    <div class="span-11 extended margin-t-x2">
                        <p class="copy line-height-100">
                            Zahlungsart: Wiederkehrende Zahlung – Mandatsreferenz: (wird separat mitgeteilt)
                        </p>
                    </div>
                </div>
                <div class="span-12 margin-t-x2">
                    <p class="copy-bold line-height-100">Name des Kontoinhabers:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->kontoinhaber }}</span>
                    </p>
                    <p class="copy-bold line-height-100">Name des Kreditinstituts:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->bank }}</span>
                    </p>
                    <p class="copy-bold line-height-100">IBAN:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->iban }}</span>
                    </p>
                    <p class="copy-bold line-height-100">BIC:
                        <span
                            class="copy line-height-100">{{ $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->bic }}</span>
                    </p>
                </div>

                <div class="span-12" style="margin: 12mm 0;">
                    <x-place-date-signature :date="null" :signatureSubline="'Unterschrift, ' .
                        $aenderungsmeldungBankverbindung->bv_vereinsleistungen->neue_verbindung->kontoinhaber .
                        ' (Kontoinhaber)'" />
                </div>
            </div>
        @endif
    </div>
@endif


<div class="span-12 no-page-break-inside">
    <span class="mg-headline">Bestätigung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12 margin-t margin-b">
            <x-checkbox class="inline-block" style="transform: translateY();"
                checked="$aenderungsmeldungBankverbindung->richtigkeitAllerAngaben" />
            <div class=" span-11 inline-block lime line-height-100">
                <p class="inline copy cyan line-height-100 v-align-middle">Hiermit bestätige ich die Richtigkeit aller
                    oben
                    gemachten Angaben
                </p>
            </div>
        </div>
        @if ($aenderungsmeldungBankverbindung->bemerkung != null)
            <div class="span-12 margin-t-x2 margin-b-x2">
                <p class="copy line-height-100">
                    <span class="copy-bold line-height-100">Bemerkung:
                    </span>{{ $aenderungsmeldungBankverbindung->bemerkung }}
                </p>
            </div>
        @endif
    </div>

    <div class="span-12" style="margin: 12mm 0;">
        <x-place-date-signature nameSubline="DRC-Mitglied" :place="$aenderungsmeldungBankverbindung->mitglied->ort" :name="$aenderungsmeldungBankverbindung->mitglied->vorname .
            ' ' .
            $aenderungsmeldungBankverbindung->mitglied->nachname" />
    </div>

    <div class="line span-12 margin-t-x2">
        <x-rounded-container class="span-12">
            <p class="copy">
                Bitte laden Sie das vollständig ausgefüllte und unterschriebene Formular im Portal
                hoch.
            </p>
        </x-rounded-container>
    </div>
</div>
