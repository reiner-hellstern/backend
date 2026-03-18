@use('App\Models\Hund')
@use('App\Models\Rasse')
@use('App\Models\Zuchtstaette')
@use('App\Models\Zwinger')
@use('App\Models\Zuechter')

<div class="span-12 margin-b-x2">
    <x-rounded-container>
        <p class="copy">
            Bitte scannen Sie die Chipnummern der Welpen der Reihe nach und kleben Sie die entsprechenden
            Barcode-Streifen bei den Welpen ein. Unterschreiben Sie bitte die Gesamtliste und laden dieses Dokument im
            Portal zum Wurfabnahmebericht hoch.
        </p>
    </x-rounded-container>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Zuchtstätte</span>
    <div class="mg-underline margin-b-x2"></div>
    @php
        $zwinger = Zwinger::find($wurf->zwinger_id);
        $zuechter = Zuechter::firstWhere("zwinger_id", $wurf->zwinger_id);
    @endphp

    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
                {{$zwinger->zwingername_praefix}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{$zwinger->strasse}}
            </p>
            @if ($zwinger->adresszusatz != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{$zwinger->adresszusatz}}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{$zwinger->postleitzahl}} {{$zwinger->ort}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{$zwinger->laenderkuerzel}}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">FCI-Zwingernummer:</span>
                {{$zwinger->fcinummer}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Zwingernummer:</span>
                {{$zwinger->zwingernummer}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{$zwinger->telefon_1}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{$zwinger->email_1}}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Website:</span>
                {{$zwinger->website_1}}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Wurf</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                @php
                    $rasse = Rasse::find($wurf->rasse_id)->name_lang;
                @endphp
                {{ $rasse }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zuchthündin:</span>
                @php
                    $mutterName = Hund::find($wurf->mutter_id)->name;
                @endphp
                {{ $mutterName }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfbuchstabe:</span>
                {{ $wurf->wurfbuchstabe }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                {{ $wurf->wurfdatum }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Welpen</span>
    <div class="mg-underline margin-b-x4"></div>

    @foreach ($hunde as $hund)
        @php
            //$hund = Hund::find($hundId);
            $name = $hund->name;
            $geschlecht = $hund->geschlecht_id === 1 ? "Hündin" : "Rüde";
            $zbnr = $hund->zuchtbuchnummer;
            $chipnummer = $hund->chipnummer;
        @endphp
        <table class="span-12">
            <tr>
                <td class="padding-0 padding-b margin-b border-b span-6 extended text-align-l">
                    <p class="copy">
                        <span class="copy-bold margin-r">Name:</span>
                        {{ $name }}
                    </p>

                    <div class="span-3 inline-block">
                        <p class="copy line-height-100 inline-block">
                            <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                            {{ $geschlecht }}
                        </p>
                    </div>

                    <div class="span-3 inline-block">
                        <p class="copy inline-block">
                            <span class="copy-bold margin-r">ZB-Nr.:</span>
                            {{ $zbnr }}
                        </p>
                    </div>
                </td>
                <td class="padding-0 padding-t padding-b margin-b border-b span-6">
                    <x-barcode class="v-align-middle">{{$chipnummer}}</x-barcode>
                </td>
            </tr>
        </table>
    @endforeach

    <div class="span-12" style="margin-top: 21mm;">
        <div class="span-6 left">
            <p class="border-b">{{$zwinger->ort}}, den {{$wurf->wurfabnahme_am}}</p>
            <br>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">
            </p>
            <p class="amtstitel">Unterschrift: {{$person_zuchtwart->vorname}}, {{$person_zuchtwart->nachname}}</p>
        </div>
    </div>

</div>