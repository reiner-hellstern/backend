@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Utilities\Math')

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
    @if (!empty($mitinhaber_list))
        <p class="copy">
            Sehr geehrte DRC-Geschäftsstelle, <br>
            hiermit beantragen wir den Wechsel vom DRC in einen anderen Zuchtverein:
        </p>
    @else
        <p class="copy">
            Sehr geehrte DRC-Geschäftsstelle, <br>
            hiermit beantrage ich den Wechsel vom DRC in einen anderen Zuchtverein:
        </p>
    @endif
</div>

<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Zwinger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line border-b padding-b span-12 margin-b">
        @php
            $zwinger = $person->zwinger;
        @endphp
        <x-zwinger-2-cols :zwinger=$zwinger disableTelefonnummer disableEmail disableWebsite enableZwingerschutzSeit />
    </div>
    <div class="line span-12 margin-b-x2">
        <p class="copy line-height-100 ">
            <span class="line-height-100 copy-bold margin-r">Gezüchtete Rassen:</span>
            [Retriever-Rasse 1], [Retriever-Rasse 2], [Retriever-Rasse 3]
        </p>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Zwingerschutz-Karte</span>
    <div class="mg-underline margin-b-x2"></div>

    @if (!$transferToGermanClub)
        @if (!empty($mitinhaber_list))
            <div class="line span-12 margin-b-x2">
                <x-verification
                    text="Unsere original Zwingerschutzkarte haben wir an
                                                                                                                    die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Wir erhalten eine Abmeldebestätigung mit
                                                                                                                    der wir uns beim unserem zukünftigen FCI-Zuchtverein anmelden können. Von diesem erhalten wir dann auch
                                                                                                                    unsere neue Zwingerschutzbescheinigung." />
            </div>
        @else
            <div class="line span-12 margin-b-x2">
                <x-verification
                    text="Meine original Zwingerschutzkarte habe ich an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Ich erhalte eine Abmeldebstätigung mit der ich mich beim meinem zukünftigen FCI-Zuchtverein anmelden kann. Von diesem erhalte ich dann auch meine neue Zwingerschutzbescheinigung." />
            </div>
        @endif
    @endif

    @if ($zwingerschutzKarteDocumentId)
        <div class="line span-12 margin-b-x2">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Die Kopie der Zwingerschutz-Karte ist bereits im System
                    hinterlegt.</span>
            </p>
        </div>
    @else
        <div class="line">
            <div class="span-12 inline-block margin-b-x2">
                <div class="span-12">
                    <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                </div>
                <div class="inline-block lime line-height-100">
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Zukünftige Zucht</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="margin-b-x2 no-page-break-inside">
        <div class="span-12 inline-block">
            <div class="span-12 margin-r">
                <p class="copy line-height-100">
                <p class="copy line-height-100">
                    <span class="line-height-100 copy-bold margin-r">Land des zukünftigen Zuchtvereins:</span>
                    {{ $transferringToCountry }}
                </p>
                @if ($transferToGermanClub)
                    <p class="copy line-height-100">
                        <span class="line-height-100 copy-bold margin-r">Name des zukünftigen Zuchtvereins:</span>
                        {{ $transferringToClubName }}
                    </p>
                @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Antragsteller</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x3">
        <x-person-2-cols :person=$person disableTelefonnummer disableEmail disableWebsite />
    </div>

    @if (!empty($mitinhaber_list))
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
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x3"></div>
    <div class="line span-12">
        @if(!empty($mitinhaber_list))
            <div class="span-12 margin-b-x3">
                <x-checkbox class="inline-block" style="transform: translateY();" />
                <div class=" span-11 inline-block lime line-height-100">
                    <p class="inline copy cyan line-height-100 v-align-middle">Hiermit bestätigen wir, die Richtigkeit
                        aller
                        oben gemachten Angaben.
                    </p>
                </div>
            </div>

            @if ($transferringToClubName == "LCD" || $transferringToClubName == "GRC")
                <div class="span-12 margin-b-x2">
                    <x-checkbox class="inline-block" style="transform: translateY(-175%);" />
                    <div class=" span-11 inline-block lime line-height-100">
                        <p class="inline copy cyan line-height-100 v-align-middle">Uns ist bewusst, dass uns der Wechsel in
                            einen anderen deutschen Retriever-Zuchtverein nur einmal möglich ist und wir lt. DRC-Zwingerordnung
                            als Züchter nicht mehr in den DRC zurückkehren können.
                        </p>
                    </div>
                </div>
            @endif
        @else
            <div class="span-12 margin-b-x3">
                <x-checkbox class="inline-block" style="transform: translateY();" />
                <div class=" span-11 inline-block lime line-height-100">
                    <p class="inline copy cyan line-height-100 v-align-middle">Hiermit bestätige ich, die Richtigkeit
                        aller
                        oben gemachten Angaben.
                    </p>
                </div>
            </div>

            @if ($transferringToClubName == "LCD" || $transferringToClubName == "GRC")
                <div class="span-12 margin-b-x2">
                    <x-checkbox class="inline-block" style="transform: translateY(-175%);" />
                    <div class=" span-11 inline-block lime line-height-100">
                        <p class="inline copy cyan line-height-100 v-align-middle">Mir ist bewusst, dass mir der Wechsel in
                            einen anderen deutschen Retriever-Zuchtverein nur einmal möglich ist und ich lt. DRC-Zwingerordnung
                            als Züchter nicht mehr in den DRC zurückkehren kann.
                        </p>
                    </div>
                </div>
            @endif
        @endif

        <div class="line span-12" style="margin-top: 4.5mm;">
            <div class="span-6">
                <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
                </p>
            </div>
            <div class="space-h"></div>

            <div class="span-6">
                <div class="span-6 {{ empty($mitinhaber_list) ? null : "margin-b"  }}">
                    <p class="border-b wrap-pre-line copy">{{ $person->vorname }} {{ $person->nachname }}
                    </p>
                    <p class="amtstitel">Antragsteller</p>
                </div>

                @foreach ($mitinhaber_list as $index => $mitinhaber)
                    <div class="span-6 {{ $index + 1 < count($mitinhaber_list) ? "margin-b" : "green"}}">
                        <p class="border-b copy">
                            {{ $mitinhaber->vorname }}<!----> {{ $mitinhaber->nachname }}
                        </p>
                        <p class="amtstitel">Mitinhaber</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>