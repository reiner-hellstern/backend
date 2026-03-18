@use('App\Http\Controllers\Utils\DateFormatter')

@props(
    [
        'zuchtstaette',
        'disableAdresse' => false,
        'disableCO' => false,
        'disablePLZ' => false,
        'disableOrt' => false,
        'disableTelefonnummer' => false,
        'disableEmail' => false,
        'disableWebsite' => false,
        'additionalFields' => [],
    ]
);
    <div class="span-6 inline-block">
    @if(!$disableAdresse)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Adresse:</span>
                    {{--<!-- {{ $zuchtstaette->strasse }} {{ $zuchtstaette->hausnummer }} -->--}}

            @if(property_exists($zuchtstaette, 'adresse')) 
            {{ $zuchtstaette->adresse }}
            @else 
            {{ $zuchtstaette->strasse }} {{ $zuchtstaette->hausnummer }}
            @endif
        </p>
    @endif
    
    @if (!$disableCO && $zuchtstaette->adresszusatz != null && $zuchtstaette->adresszusatz != '')
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">c/o:</span>
        {{ $zuchtstaette->adresszusatz }}
        </p>
    @endif
    
    @if (!$disablePLZ && !$disableOrt)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
        {{ $zuchtstaette->postleitzahl }} {{ $zuchtstaette->ort }}
        </p>
    @elseif (!$disablePLZ)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Postleitzahl:</span>
        {{ $zuchtstaette->postleitzahl }}
        </p>
    @elseif (!$disableOrt)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
        {{ $zuchtstaette->ort }}
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
    @if (!$disableTelefonnummer)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
        {{ $zuchtstaette->telefon }}
        </p>
    @endif
    
    @if (!$disableEmail)
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
        {{ $zuchtstaette->email }}
        </p>
    @endif
    
    @if (!$disableWebsite && $zuchtstaette->website != null && $zuchtstaette->website != '')
            <p class="copy line-height-100">
            <span class="line-height-100 copy-bold margin-r">Website:</span>
        {{ $zuchtstaette->website }}
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
