@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models\Mitgliedsart')
@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty']);
@endphp

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit beantrage ich die Änderung meines DRC-Mitgliedschaftstyps:
    </p>
</div>

<div class="span-12 margin-t-x3 margin-b-x2">
    <span class="mg-headline">Mitglied</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $person->vorname }} {{ $person->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $person->strasse }} {{ $person->hausnummer }}
            </p>
            @if ($person->adresszusatz != null && $person->adresszusatz != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $person->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $person->postleitzahl }} {{ $person->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $person->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                {{ $person->geboren }}
            </p>
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $person->telefon_1 }}
            </p>
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $person->email_1 }}
            </p>
            @if ($person->website_1 != null && $person->website_1 != '')
                <p class="copy line-height-100">
                    <span class="line-height-100 copy-bold margin-r">Website:</span>
                    {{ $person->website_1 }}
                </p>
            @endif
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4">
    <span class="mg-headline">Aktuelle DRC-Mitgliedschaft</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedschaftstyp:</span>
                {{ Mitgliedsart::where('nummer', $person->mitgliedsart)->value('name') }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $person->mitgliedsnummer }}
            </p>
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
                {{ $person->mitglied->datum_eintritt }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Künftiger DRC-Mitgliedschaftstyp</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedschaftstyp:</span>
                [gewünschter DRC-Mitgliedstyp]
            </p>
        </div>

        <div class="span-12 inline-block" style="opacity: 0.3;">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">zum DRC-Vollmitglied:</span>
                [Vorname Vollmitglied] [Nachname Vollmitglied], [DRC-Mitgliedsnummer]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Mitgliedsbeitrag</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12">
            <div class="span-6">
                <p class="copy-bold line-height-100">Mein Mitgliedsbeitrag für das laufende Jahr: <span
                        class="copy line-height-100">[XXX,XX] €</span></p>
            </div>
            <div class="span-6 extended">
                <p class="copy-bold line-height-100">Mein jährlicher Mitgliedsbeitrag ab [Antragsjahr + 1]:
                    <span class="copy line-height-100">[XXX,XX] €</span>
                </p>
            </div>
        </div>
        <div class="span-12 margin-t-x3">
            <p class="copy-bold line-height-100">HINWEIS:<span class="copy line-height-100">
                    Satzungsgemäß erfolgt die Beitragserhebung ausschließlich mittels Einzugsermächtigung.<br>
                    Der Aufnahmeantrag wird daher nur bei Erteilung einer Einzugsermächtigung wirksam.<br>
                    Bei vergeblichem Bankeinzug erhebt der DRC eine Bearbeitungsgebühr von: [XXX,XX] €.
                </span>
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">SEPA-Lastschriftmandat</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12">
            <p class="copy-bold line-height-100">Gläubiger-Identifikationsnummer: DE97ZZZ00000734841</p>
        </div>
        <div class="span-11 extended">
            <p class="copy line-height-100">
                Ich ermächtige den Deutscher Retriever Club e.V. Zahlungen von meinem Konto mittels Lastschrift
                einzuziehen. Zugleich weise ich mein Kreditinstitut an, die vom Zahlungsempfänger Deutscher Retriever
                Club e.V. auf mein Konto gezogenen Lastschriften einzulösen.
            </p>
        </div>
        <div class="span-11 extended margin-t">
            <p class="copy line-height-100">
                Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten
                Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
            </p>
        </div>
        <div class="span-11 extended margin-t">
            <p class="copy line-height-100">
                Zahlungsart: Wiederkehrende Zahlung – Mandatsreferenz: (wird separat mitgeteilt)
            </p>
        </div>
    </div>
    <div class="span-12 margin-t-x2">
        <p class="copy-bold line-height-100">Name des Kontoinhabers:
            <span class="copy line-height-100">[Vorname Kontoinhaber] [Nachname Kontoinhaber]</span>
        </p>
        <p class="copy-bold line-height-100">Name des Kreditinstituts:
            <span class="copy line-height-100">[Kreditinstitut]</span>
        </p>
        <p class="copy-bold line-height-100">IBAN:
            <span class="copy line-height-100">[DE0000000000000000000000]</span>
        </p>
        <p class="copy-bold line-height-100">BIC:
            <span class="copy line-height-100">[BBBBCCLLbbb]</span>
        </p>
    </div>
</div>

<div class="line span-12" style="margin-top: 0mm;">
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">[Ort], den [dd.mm.yyyy]
        </p>
        <p class="amtstitel"></p>
    </div>
    <div class="space-h"></div>
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">
        </p>
        <p class="amtstitel">Unterschrift, [Vorname Kontoinhaber] [Nachname Kontoinhaber]</p>
    </div>
</div>


<div class="pin-bottom span-12 margin-t-x3">
    <span class="mg-headline">Bestätigung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-t-x3">
        <div class="span-12">
            <x-checkbox class="inline-block" style="transform: translateY(-12.5%);" />
            <div class=" span-11 inline-block lime line-height-100">
                <p class="inline copy cyan line-height-100 v-align-middle">Hiermit bestätige ich die RIchtigkeit aller
                    oben
                    gemachten Angaben
                </p>
            </div>
        </div>
        <div class="span-12 margin-b-x2">
            <x-checkbox class="inline-block" style="transform: translateY(-112.5%);" />
            <div class="span-11 extended inline-block lime line-height-100">
                <p class="inline copy cyan line-height-100 v-align-middle">
                    Die Änderung meines DRC-Mitgliedschaftstyps bedingt eine neue DRC-Mitgliedsnummer. Nach Rückgabe
                    meiner bisherigen Mitgliedskarte an die DRC-Geschäftsstelle erhalte ich meine neue
                    DRC-Mitgliedskarte.
                </p>
            </div>
        </div>
    </div>

    <div class="line span-12" style="margin: 2mm 0;">
        <div class="span-6">
            <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <p class="border-b wrap-pre-line copy">{{ $person->vorname }} {{ $person->nachname }}
            </p>
            <p class="amtstitel">DRC-Mitglied</p>
        </div>

    </div>

    <div class="line span-12">
        <x-rounded-container class="span-12">
            <p class="copy">
                Bitte laden Sie das vollständig ausgefüllte und unterschriebene Formular im Portal
                hoch.
            </p>
        </x-rounded-container>
    </div>
</div>