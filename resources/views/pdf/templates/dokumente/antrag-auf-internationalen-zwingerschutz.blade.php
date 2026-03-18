@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Utilities\Math')

@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);
    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $mitinhaber_list = [$mitinhaber1, $mitinhaber2, $mitinhaber3];
@endphp

<div class="line span-12">
    <p class="copy">
        @if (empty($mitinhaber_list))
            Sehr geehrte DRC-Geschäftsstelle, <br>
            hiermit beantrage ich den internationalen Zwingerschutz:
        @else
            Sehr geehrte DRC-Geschäftsstelle, <br>
            hiermit beantragen wir den internationalen Zwingerschutz:
        @endif
    </p>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Antragsteller</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $person->vorname }} {{ $person->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                {{ DateFormatter::formatDMY($person->geboren) }}
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
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $person->mitgliedsnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
                {{ DateFormatter::formatDMY($person->eintrittsdatum) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $person->telefon_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $person->email_1 }}
            </p>
            @if ($person->website_1 != null && $person->website_1 != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Website:</span>
                    {{ $person->website_1 }}
                </p>
            @endif
        </div>
    </div>
</div>

@if (!empty($mitinhaber_list))
    <div class="span-12 margin-t-x4 margin-b-x2">
        <span class="mg-headline">Mitinhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @foreach ($mitinhaber_list as $index => $mitinhaber)
            <table class="span-12">
                <tr>
                    <td
                        class="padding-0 padding-b margin-b {{ $index + 1 == count($mitinhaber_list) ? null : 'border-b'}} span-4 extended text-align-l lime">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $mitinhaber->vorname }}
                            {{ $mitinhaber->nachname }}
                        </p>

                        <div class="span-4 inline-block">
                            <p class="copy line-height-100 inline-block">
                                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                                {{ DateFormatter::formatDMY($mitinhaber->geboren) }}
                            </p>
                        </div>

                        <div class="span-4 inline-block">
                            <p class="line-height-100 copy inline-block">
                                <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
                                {{ DateFormatter::formatDMY($mitinhaber->eintrittsdatum) }}
                            </p>
                        </div>

                        @if ($index == 1)
                            <div class="span-4 inline-block">
                                <p class="line-height-100 copy inline-block">
                                    <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                                    {{ $mitinhaber->ort }}
                                </p>
                            </div>
                        @endif
                    </td>
                    <td
                        class="padding-0 padding-t padding-b margin-b {{ $index + 1 == count($mitinhaber_list) ? null : 'border-b'}} span-8 text-align-l orange">
                        @if ($index == 0)
                            <div class="line span-8 red">
                                <x-checkbox class="inline-block" style="transform: translateY(-450%);" />
                                <div class="span-7 extended padding-l">
                                    <div class="span-7 extended inline-block line-height-100 margin-b">
                                        <p class="inline copy line-height-100 v-align-middle">
                                            Hiermit bestätige ich, dass ich an einem DRC-Neuzüchterseminar teilgenommen habe bzw. an
                                            einem
                                            inhaltlich entsprechenden eines VDH-Vereins.
                                        </p>
                                    </div>

                                    <div class="span-7 extended inline-block margin-b-x2">
                                        <div class="span-7 extended">
                                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                                        </div>
                                        <div class="inline-block lime line-height-100">
                                            <div class="span-5 border-b margin-r">
                                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                                            </div>
                                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($index == 1)
                            <div class="line span-8 red">
                                <x-checkbox class="inline-block" style="transform: translateY(-837.5%);" />
                                <div class="span-7 extended padding-l">
                                    <div class="span-7 extended inline-block line-height-100 margin-b">
                                        <p class="inline copy line-height-100 v-align-middle">
                                            Mir ist bewusst, dass der abweichende Wohnsitz der Genehmigung durch den DRC-Vorstand
                                            bedarf und
                                            ich
                                            hierfür im Verwandtschaftsgrad 1 zu meinem / den anderen Zwinger-Mitinhaber/n stehe und
                                            meinen
                                            2.
                                            Wohnsitz an der Zuchtstätten-Adresse und Wohnsitz der/des anderen Mitinhaber/s gemeldet
                                            habe.
                                            Die
                                            Nachweise hierfür habe ich entsprechend hochgeladen.
                                        </p>
                                    </div>

                                    <div class="span-7 extended inline-block margin-b-x2">
                                        <div class="span-7 extended">
                                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                                        </div>
                                        <div class="inline-block lime line-height-100">
                                            <div class="span-5 border-b margin-r">
                                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                                            </div>
                                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="line span-6 line-height-100 inline-block">
                                <x-checkbox class="inline-block" style="transform: translateY(-100%);" />
                                <div class="span-5 extended inline-block line-height-100 padding-l">
                                    <p class="inline copy line-height-100 v-align-middle">
                                        Der Antragsteller hat am DRC-Neuzüchterseminar am [dd.mm.yyyy] teilgenommen.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        @endforeach
    </div>
@endif

<div class="line span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Zuchtstätte</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12 margin-b padding-b">
        @php
            $zwinger = $person->zwinger;
        @endphp
        <x-zwinger-2-cols :zwinger=$zwinger disableDRCZwingernummer disableFCIZwingernummer disableZwingername />
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Retriever-Rasse/n</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            @if (empty($mitinhaber_list))
                <p class="copy line-height-100">
                    Den Zwingerschutz möchte ich für folgende Retriever-Rasse/n beantragen:
                </p>
            @else
                <p class="copy line-height-100">
                    Den Zwingerschutz möchten wir für folgende Retriever-Rasse/n beantragen:
                </p>
            @endif
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <div class="span-6 border-b margin-r">
                <p class="inline-block copy cyan line-height-100 v-align-middle">[Retriever-Rasse 1]</p>
            </div>
            <div class="span-6 border-b margin-r">
                <p class="inline-block copy cyan line-height-100 v-align-middle">[Retriever-Rasse 2]</p>
            </div>
            <div class="span-6 border-b margin-r">
                <p class="inline-block copy cyan line-height-100 v-align-middle">[Retriever-Rasse 3]</p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Zwinger Namensvorschläge</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-8 inline-block v-align-bottom">
            <p class="copy line-height-100">
                <br>
                @if (empty($mitinhaber_list))
                    Folgende Zwingernamen schlage ich, nach meiner Priorität geordnet vor:
                @else
                    Folgende Zwingernamen schlagen wir, nach unserer Priorität geordnet vor:
                @endif
            </p>

            <div class="span-8 margin-r no-wrap padding-t">
                <span class="inline-block copy-bold cyan line-height-100 v-align-middle">1.
                    <div class="span-8 border-b margin-l">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Zwingername]</p>
                    </div>
                </span>
            </div>

            <div class="span-8 margin-r no-wrap padding-t">
                <span class="inline-block copy-bold cyan line-height-100 v-align-middle">2.
                    <div class="span-8 border-b margin-l">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Zwingername]</p>
                    </div>
                </span>
            </div>

            <div class="span-8 margin-r no-wrap padding-t">
                <span class="inline-block copy-bold cyan line-height-100 v-align-middle">3.
                    <div class="span-8 border-b margin-l">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Zwingername]</p>
                    </div>
                </span>
            </div>

            <div class="span-8 margin-r no-wrap padding-t">
                <span class="inline-block copy-bold cyan line-height-100 v-align-middle">4.
                    <div class="span-8 border-b margin-l">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Zwingername]</p>
                    </div>
                </span>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-4 inline-block">
            <div class="span-2 text-align-c">
                <p class="span-2 copy line-height-100">
                    Zwingername dem <br> vorangestellt
                </p>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
            </div>
            <div class="span-2 text-align-c">
                <p class="span-2 copy line-height-100">
                    Hundenamen <br> nachgesetzt
                </p>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
                <div class="span-2 margin-t-x3">
                    <x-checkbox class="inline-block" style="transform: translateY();" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x3"></div>
    <div class="line">
        @if (empty($mitinhaber_list))
            <div class="span-12 margin-b-x2">
                <x-verification
                    text="Hiermit bestätige ich, dass für mich noch kein Zwingername geschützt wurde und ich nicht außerhalb der FCI züchte." />
            </div>
            <div class="span-12 margin-b-x2">
                <x-verification text="Hiermit bestätige ich, die Richtigkeit aller oben gemachten Angaben." />
            </div>
            <div class="span-12">
                <x-verification
                    text="Hiermit beantrage ich kostenpflichtig den Zwingerschutz. Der Betrag von [XXX,XX€] wird von meinem Konto abgebucht." />
            </div>

        @else
            <div class="span-12 margin-b-x2">
                <x-verification
                    text="Hiermit bestätigen wir, dass für uns noch kein Zwingername geschützt wurde und wir nicht außerhalb der FCI züchten." />
            </div>
            <div class="span-12 margin-b-x2">
                <x-verification text="Hiermit bestätigen wir, die Richtigkeit aller oben gemachten Angaben." />
            </div>
            <div class="span-12">
                <x-verification
                    text="Hiermit beantragen wir kostenpflichtig den Zwingerschutz. Der Betrag von [XXX,XX€] wird vom Konto des Antragstellers abgebucht." />
            </div>
        @endif


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

                @foreach ($mitinhaber_list as $mitinhaber)
                    <div class="span-6 margin-b-x2">
                        <p class="border-b wrap-pre-line copy">{{ $mitinhaber->vorname }} {{ $mitinhaber->nachname }}
                        </p>
                        <p class="amtstitel">Mitinhaber</p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>