@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')

@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);

    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber4 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $mitinhaber_list = [
        $mitinhaber1,
        $mitinhaber2,
        $mitinhaber3
    ];
@endphp

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit melde ich meine neuen Kontaktdaten:
    </p>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Mitglied</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <x-person-2-cols :person=$person />
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">{{ $sectionheadlineChangedData }}</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            @if($changedData['newFirstName'] || $changedData['newLastName'])
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    {{ $changedData['newFirstName'] ?? $person->vorname }}
                    {{ $changedData['newLastName'] ?? $person->nachname }}
                </p>
            @endif
            @if ($changedData['newAddress'])
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresse:</span>
                    {{ $changedData['newAddress'] }}
                </p>
            @endif
            @if ($changedData['newPlace'] != null || $changedData['newZipCode'])
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                    {{ $changedData['newZipCode'] }} {{ $changedData['newPlace'] }}
                </p>
            @endif
            @if ($changedData['newAddressSupplement'] != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">c/o:</span>
                    {{ $changedData['newAddressSupplement'] }}
                </p>
            @endif
            @if ($changedData['newCountry'] != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Land:</span>
                    {{ $changedData['newCountry'] }}
                </p>
            @endif
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            @if ($changedData['newPhone'] != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                    {{ $changedData['newPhone'] }}
                </p>
            @endif
            @if ($changedData['newEmail'] != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                    {{ $changedData['newEmail'] }}
                </p>
            @endif
            @if ($changedData['newWebsite'] != null)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Website:</span>
                    {{ $changedData['newWebsite'] }}
                </p>
            @endif
        </div>
    </div>
</div>

@if ($caseId > 1)
    <div class="span-12 margin-t-x4 margin-b-x4">
        <span class="mg-headline">Zwinger</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line padding-b span-12 margin-b">
            @php
                $zwinger = $person->zwinger;
            @endphp
            <x-zwinger-2-cols :zwinger=$zwinger disableTelefonnummer disableEmail disableWebsite enableZwingerschutzSeit />
        </div>
    </div>
@endif

@if ($caseId >= 7)
    <div class="span-12 margin-t-x4 margin-b-x4">
        <span class="mg-headline">Zwinger-Mitinhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @foreach ($mitinhaber_list as $index => $mitinhaber)
            <div
                class="line span-12 padding-b {{ $index + 1 < count($mitinhaber_list) ? "border-b margin-b-x2" : null}} no-page-break-inside">
                <div class="line span-12 margin-b">
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $mitinhaber->vorname }}
                            {{ $mitinhaber->nachname }}
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                            {{ $mitinhaber->mitgliedsnummer }}
                        </p>
                    </div>
                </div>
                @if ($caseId >= 11 && $caseId < 16)
                    <div class="line">
                        <div class="span-12 margin-t margin-b position-relative">
                            <x-checkbox style="position: absolute; top: 1mm;" />
                            <div class="span-11 lime line-height-100" style="margin-left: 4mm;">
                                <p class="copy cyan line-height-100 v-align-middle">
                                    Der Nachweis meines Verwandtschaftsgrades 1 zum/zu den Zwinger-Mitinhaber/n ist am [xx.xx.xxxx]
                                    erfolgt und wurde von der DRC-Geschäftsstelle am [xx.xx.xxxx] bestätigt.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="span-12 margin-t margin-b position-relative">
                            <x-checkbox style="position: absolute; top: 1mm;" />
                            <div class="span-11 lime line-height-100" style="margin-left: 4mm;">
                                <p class="copy cyan line-height-100 v-align-middle">
                                    Der Nachweis meines 2. Wohnsitzes an der Adresse der/s Zwinger-Mitinhaber/s und somit der
                                    Zuchtstätten-Adresse ist am [xx.xx.xxxx] erfolgt und wurde von der DRC-Geschäftsstelle am
                                    [xx.xx.xxxx] bestätigt.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif

<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x2"></div>

    @foreach ($confirmations as $confirmation)
        <x-verification :text=$confirmation />
    @endforeach

    <div class="line span-12" style="margin: 14mm 0;">
        <div class="span-6">
            <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
            </p>
        </div>
        <div class="space-h"></div>

        <div class="span-6">
            <div class="span-6 margin-b-x2">
                <p class="border-b wrap-pre-line copy">{{ $person->vorname }} {{ $person->nachname }}
                </p>
                <p class="amtstitel">Antragsteller</p>
            </div>

            @if ($caseId >= 7)
                @foreach ($mitinhaber_list as $mitinhaber)

                    <div class="span-6 margin-b-x2">
                        <p class="border-b wrap-pre-line copy">
                            {{ $mitinhaber->vorname }}<!----> {{ $mitinhaber->nachname }}
                        </p>
                        <p class="amtstitel">Mitinhaber</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>