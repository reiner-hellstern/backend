@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models\Mitgliedsart')
@php
    //Log::debug(($person));
    //$person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
@endphp

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit kündige ich meine Mitgliedschaft im Deutscher Retriever Club e.V. fristgerecht zum nächstmöglichen
        Termin. <br>
        Ferner widerrufe ich auf diesem Weg die Ihnen erteilte Einzugsermächtigung für das bei Ihnen hinterlegte Konto.
        <br>
        Bitte senden Sie mir eine schriftliche Bestätigung über den Eingang der Kündigung und der Termin für das
        Vertragsende zu. <br>
    </p>
</div>

<div class="span-12 margin-b-x2" style="margin-top: 21mm;">
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
                {{ $person->strasse }}
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
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $person->mitgliedsnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
                {{ DateFormatter::formatDMY($person->eintrittsdatum) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Mitgliedstyp:</span>
                {{ Mitgliedsart::where('nummer', $person->mitgliedsart)->value('name') }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                {{ DateFormatter::formatDMY($person->geboren) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $person->telefon_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $person->email_1 }}
            </p>
        </div>
    </div>
</div>

<div class="line span-12" style="margin-top: 21mm;">
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
        </p>
    </div>
    <div class="space-h"></div>
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">
        </p>
        <p class="amtstitel">Unterschrift, {{ $person->vorname }} {{ $person->nachname }}</p>
    </div>
</div>


<div class="line span-12" style="margin-top: 21mm;">
    <x-rounded-container class="span-12">
        <p class="copy">
            Bitte laden Sie das unterschriebene Formular im Portal
            hoch.
        </p>
    </x-rounded-container>
</div>