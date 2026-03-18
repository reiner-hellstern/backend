@php
    $arthrosegrad_lookup = [
        1 => 'Keine',
        2 => 'Gering',
        3 => '<2mm',
        4 => '2-5mm',
        5 => '>5mm',
    ];

    $ed_befund_lookup = [
        1 => 'Frei',
        2 => 'Grenzfall',
        3 => 'Grad I',
        4 => 'Grad II',
        5 => 'Grad III',
    ];
@endphp
@use(App\Http\Controllers\Utils\DateFormatter)


<!-- #region Page 1 -->
<div class="span-12 margin-b-x3">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-6 extended inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $edVerifizierung->hund->name }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Geschlecht:</span>{{ $edVerifizierung->hund->geschlecht }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>{{ $edVerifizierung->hund->rasse }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Farbe:</span>{{ $edVerifizierung->hund->farbe }}
            </p>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>{{ $edVerifizierung->hund->zuchtbuchnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Chipnummer:</span>{{ $edVerifizierung->hund->chipnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Wurfdatum:</span>{{ $edVerifizierung->hund->wurfdatum }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Mitglied</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{-- {{ $person->vorname }} {{ $person->nachname }} --}}
                {{ $edVerifizierung->mitglied->vorname }} {{ $edVerifizierung->mitglied->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{-- {{ $person->strasse }} {{ $person->hausnummer }} --}}
                {{ $edVerifizierung->mitglied->strasse }}
            </p>
            {{-- @if ($person->adresszusatz != null && $person->adresszusatz != '')
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                {{ $person->adresszusatz }}
            </p>
            @endif
            --}}
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{-- {{ $person->postleitzahl }} {{ $person->ort }} --}}
                {{ $edVerifizierung->mitglied->postleitzahl }} {{ $edVerifizierung->mitglied->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{-- {{ $person->land }} --}}
                {{ $edVerifizierung->mitglied->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $edVerifizierung->mitglied->mitgliedsnummer }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">CT-Untersuchung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="">
        <div class="span-8 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Datum der
                    CT-Aufnahmen:</span>{{ DateFormatter::formatDMY($edVerifizierung->ct_untersuchung->datum_der_ct_aufnahmen) }}
            </p>
        </div>
    </div>

    <div class="margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Röntgentierarzt</p>
            <div class="span-12 border-b margin-b-x2">
                <div class="span-12 border-b"></div>
            </div>

            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Praxis:</span>{{ $edVerifizierung->ct_untersuchung->roentgentierarzt->praxis }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Name:</span>{{ $edVerifizierung->ct_untersuchung->roentgentierarzt->name }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Straße und
                        Nr.:</span>{{ $edVerifizierung->ct_untersuchung->roentgentierarzt->strasse }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Wohnort:</span>{{ $edVerifizierung->ct_untersuchung->roentgentierarzt->postleitzahl }}
                    {{ $edVerifizierung->ct_untersuchung->roentgentierarzt->ort }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Land:</span>{{ $edVerifizierung->ct_untersuchung->roentgentierarzt->land }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 padding-t-x2 margin-b-x4">
    <span class="mg-headline">Gutachter</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b-x2">
        <div class="span-8 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $edVerifizierung->gutachter->name }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und
                    Nr.:</span>{{ $edVerifizierung->gutachter->strasse }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Wohnort:</span>{{ $edVerifizierung->gutachter->postleitzahl }}
                {{ $edVerifizierung->gutachter->ort }}
            </p>
        </div>
    </div>
</div>

<!-- #endregion Page 1 -->

<div class="span-12 padding-t-x2 margin-b-x4 no-page-break-inside">
    <span class="mg-headline">ED-Verifizierung</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-12 border-b">
            <div class="span-12 margin-b">
                <div class="span-4"></div>
                <div class="space-h"></div>
                <div class="span-4"><span class="line-height-100 copy-bold margin-r">Ellenbogen links:</span></div>
                <div class="span-4"><span class="line-height-100 copy-bold margin-r">Ellenbogen rechts:</span></div>
            </div>
        </div>
        <div class="span-12">
            <div class="span-4 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Arthrosegrad:</span>
                </p>
            </div>

            <div class="span-4">
                <p class="copy line-height-100">
                    {{ $arthrosegrad_lookup[$edVerifizierung->ed_verifizierung->arthrosegrad[0]] }}
                </p>
            </div>

            <div class="span-4 extended">
                <p class="copy line-height-100">
                    {{ $arthrosegrad_lookup[$edVerifizierung->ed_verifizierung->arthrosegrad[1]] }}
                </p>
            </div>
        </div>

        <div class="span-12 border-b padding-b-x2 margin-b-x2">
            <div class="span-12">
                <div class="span-4 extended">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">IPA:</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->ipa[0] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->ipa[1] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>
            </div>

            <div class="span-12">


                <div class="span-4 extended">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">FCP:</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->fcp[0] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->fcp[1] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>
            </div>

            <div class="span-12">


                <div class="span-4 extended">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">OCD:</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->ocd[0] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->ocd[1] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>
            </div>

            <div class="span-12">


                <div class="span-4 extended">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Coronoid-Erkrankung:</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->coronoid_erkrankung[0] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>

                <div class="span-4">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy margin-r">{{ $edVerifizierung->ed_verifizierung->coronoid_erkrankung[1] ? 'ja' : 'nein' }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="span-12">
            <div class="span-4 extended">
                <span class="line-height-100 mg-headline">ED-Befund</span>
            </div>

            <div class="span-4">
                <p class="copy-bold line-height-100">ED links:
                    {{ $ed_befund_lookup[$edVerifizierung->ed_verifizierung->ed_befund[0]] }}
                </p>
            </div>

            <div class="span-4 extended">
                <p class="copy-bold line-height-100">ED rechts:
                    {{ $ed_befund_lookup[$edVerifizierung->ed_verifizierung->ed_befund[1]] }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- #endregion Page 2 -->

<div class="pin-bottom" style="margin-bottom: 20mm;">
    <div class="span-12 padding-t-x3">
        <x-place-date-signature name="{{ $edVerifizierung->gutachter->name }}" nameSubline="Gutachter"
            date="{{ DateFormatter::formatDMY($edVerifizierung->gutachten_datum) }}"
            place="{{ $edVerifizierung->gutachter->ort }}" />

        {{-- <div class="span-6 left">
            <p class="border-b">{{ $edVerifizierung->gutachter->ort }}, den {{ $edVerifizierung->gutachten_datum }}
            </p>
            <br>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">{{ $edVerifizierung->gutachter->name }}
            </p>
        </div> --}}
    </div>
</div>
<!-- #endregion Page 3 -->
