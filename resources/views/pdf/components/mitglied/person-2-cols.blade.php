@use('App\Http\Controllers\Utils\DateFormatter');
@props([
    'person',
    'disableName' => false,
    'disableAdresse' => false,
    'disableCO' => false,
    'disablePLZ' => false,
    'disableOrt' => false,
    'disableLand' => false,
    'disableDRCMitgliedsnummer' => false,
    'enableMitgliedSeit' => false,
    'enableGeburtsdatum' => false,
    'disableTelefonnummer' => false,
    'disableEmail' => false,
    'disableWebsite' => false,
    'additionalFields' => [],
]);
{{--'additionalFields' => [["Label 1:" => "Data 1", "Label 2:" => "Data 2"], ["Label 3:" => "Data 3"]]--}}

<div class="span-6 inline-block">
    @if (!$disableName)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Name:</span>
            {{ $person->vorname }} {{ $person->nachname }}
        </p>
    @endif

    @if (!$disableAdresse)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Adresse:</span>
            {{-- 
            {{ $person->strasse }} {{ $person->hausnummer }}
            {{ $person->adresse }}
            --}}
            {{ $person->strasse }}
        </p>
    @endif

    @if (!$disableCO && $person->adresszusatz != null && $person->adresszusatz != '')
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">c/o:</span>
            {{ $person->adresszusatz }}
        </p>
    @endif

    @if (!$disablePLZ && !$disableOrt)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
            {{ $person->postleitzahl }} {{ $person->ort }}
        </p>
    @elseif (!$disablePLZ)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Postleitzahl:</span>
            {{ $person->postleitzahl }}
        </p>
    @elseif (!$disableOrt)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
            {{ $person->ort }}
        </p>
    @endif

    @if (!$disableLand)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Land:</span>
            {{ $person->land }}
        </p>
    @endif

    @if (!empty($additionalFields[0]))   
        @foreach ($additionalFields[0] as $label => $data)
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">{{ $label }}</span>
                {{ $data }}
            </p>
        @endforeach
    @endif
</div>
<div class="space-h"></div>
<div class="span-6 inline-block">
    @if (!$disableDRCMitgliedsnummer)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
            {{ $person->mitgliedsnummer }}
        </p>
    @endif

    @if ($enableMitgliedSeit)
        <p class="copy line-height-100 ">
            <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
            {{ DateFormatter::formatDMY($person->eintrittsdatum) }}
        </p>
    @endif

    @if ($enableGeburtsdatum)
        <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
            {{ DateFormatter::formatDMY($person->geboren) }}
        </p>
    @endif

    @if (!$disableTelefonnummer)
        <p class="copy line-height-100 ">
            <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
            {{ $person->telefon_1 }}
        </p>
    @endif

    @if(!$disableEmail)
        <p class="copy line-height-100 ">
            <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
            {{ $person->email_1 }}
        </p>
    @endif

    @if (!$disableWebsite && $person->website_1 != null && $person->website_1 != '')
        <p class="copy line-height-100 ">
            <span class="line-height-100 copy-bold margin-r">Website:</span>
            {{ $person->website_1 }}
        </p>
    @endif

    @if (!empty($additionalFields[1]))   
        @foreach ($additionalFields[1] as $label => $data)
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">{{ $label }}</span>
                {{ $data }}
            </p>
        @endforeach
    @endif
</div>