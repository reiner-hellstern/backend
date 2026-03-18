@use('App\Http\Controllers\Utils\DateFormatter')

@props(
    [
        'zwinger',
        'disableZwingername' => false,
        'removeAffix' => true,
        'disableAdresse' => false,
        'disableCO' => false,
        'disablePLZ' => false,
        'disableOrt' => false,
        'disableLand' => false,
        'disableFCIZwingernummer' => false,
        'disableDRCZwingernummer' => false,
        'enableZwingerschutzSeit' => false,
        'disableTelefonnummer' => false,
        'disableEmail' => false,
        'disableWebsite' => false,
        'additionalFields' => [],
    ]
);

    <div class="span-6 inline-block">
    @if(!$disableZwingername)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
        {{ $removeAffix ? str_replace('...', '', $zwinger->zwingername) : $zwinger->zwingername }}
        </p>
    @endif
    
    @if(!$disableAdresse)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Adresse:</span>
        {{ $zwinger->strasse }} {{ $zwinger->hausnummer }}
        </p>
    @endif
    
    @if (!$disableCO && $zwinger->adresszusatz != null && $zwinger->adresszusatz != '')
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">c/o:</span>
        {{ $zwinger->adresszusatz }}
        </p>
    @endif
    
    @if (!$disablePLZ && !$disableOrt)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
        {{ $zwinger->postleitzahl }} {{ $zwinger->ort }}
        </p>
    @elseif (!$disablePLZ)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Postleitzahl:</span>
        {{ $zwinger->postleitzahl }}
        </p>
    @elseif (!$disableOrt)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
        {{ $zwinger->ort }}
        </p>
    @endif
    
    @if (!$disableLand)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Land:</span>
        {{ $zwinger->land }}
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
    @if (!$disableFCIZwingernummer)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">FCI-Zwingernummer:</span>
        {{ $zwinger->fcinummer }}
        </p>
    @endif
    
    @if (!$disableDRCZwingernummer)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">DRC-Zwingernummer:</span>
        {{ $zwinger->zwingernummer }}
        </p>
    @endif
    
    @if ($enableZwingerschutzSeit)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Zwingerschutz seit:</span>
        <i>[dd.mm.yyyy]</i>
        </p>
    @endif
    
    @if (!$disableTelefonnummer)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
        {{ $zwinger->telefon_1 }}
        </p>
    @endif
    
    @if (!$disableEmail)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
        {{ $zwinger->email_1 }}
        </p>
    @endif
    
    @if (!$disableWebsite && $zwinger->website_1 != null && $zwinger->website_1 != '')
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Website:</span>
        {{ $zwinger->website_1 }}
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