@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Grund der Zuchtstättenbesichtigung</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12 border-b">
            <p class="inline-block copy cyan line-height-100 v-align-middle">[Kategorie]</p>
        </div>
    </div>
</div>

@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);
    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $mitinhaber_list = [$mitinhaber1, $mitinhaber2, $mitinhaber3];

    $zwinger = $person->zwinger;
@endphp

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Zuchtstätte</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
                {{ trim(preg_replace('/\.\.\./', '', $zwinger->zwingername)) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $zwinger->strasse }} {{ $zwinger->hausnummer }}
            </p>
            @if ($zwinger->adresszusatz != null && $zwinger->adresszusatz != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $person->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $zwinger->postleitzahl }} {{ $zwinger->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $zwinger->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">FCI-Zwingernummer:</span>
                {{ $zwinger->fcinummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Zwingernummer:</span>
                {{ $zwinger->zwingernummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $zwinger->telefon_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $zwinger->email_1 }}
            </p>
            @if ($person->website_1 != null && $person->website_1 != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Zwinger-Website:</span>
                    {{ $zwinger->website_1 }}
                </p>
            @endif
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Antragsteller</span>
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
        </div>
    </div>
</div>

@if (!empty($mitinhaber_list))
    <div class="span-12 margin-t-x2 margin-b-x2">
        <span class="mg-headline">Zwinger-Mitinhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @foreach ($mitinhaber_list as $index => $mitinhaber)
            <div class="line span-12 {{ $index + 1 < count($mitinhaber_list) ? "border-b padding-b-x2 margin-b" : null }}">
                <div class="span-12">
                    <p class="line-height-100 copy">
                        <span class="line-height-100 copy-bold margin-r">Name:</span>
                        {{ $mitinhaber->vorname }}
                        {{ $mitinhaber->nachname }}
                    </p>
                    <p class="line-height-100 copy">
                        <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                        {{ $mitinhaber->mitgliedsnummer }}
                    </p>
                    <p class="line-height-100 copy">
                        <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                        {{ $mitinhaber->telefon_1 }}
                    </p>

                    @if ($index == 1)
                        <div class="line span-12 red margin-b">
                            <p class="line-height-100 copy">
                                <span class="line-height-100 copy-bold margin-r">Adresse:</span>
                                {{ $mitinhaber->strasse }}
                                {{ $mitinhaber->hausnummer }},
                                {{ $mitinhaber->postleitzahl }}
                                {{ $mitinhaber->ort }}
                            </p>
                        </div>
                        <div class="padding-l">
                            <div class="line span-12 red">
                                <x-checkbox class="inline-block" style="transform: translateY();" />
                                <div class="span-11 extended padding-l">
                                    <div class="span-11 extended inline-block line-height-100 margin-b">
                                        <p class="inline copy line-height-100 v-align-middle">
                                            Verwandtschaftsgrad 1 zu anderen Zwinger-Mitinhabern wurde am [dd.mm.yyyy] nachgewiesen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="line span-12 red">
                                <x-checkbox class="inline-block" style="transform: translateY();" />
                                <div class="span-11 extended padding-l">
                                    <div class="span-11 extended inline-block line-height-100 margin-b">
                                        <p class="inline copy line-height-100 v-align-middle">
                                            2. Wohnsitz für Zuchtstätte wurde am [dd.mm.yyyy] nachgewiesen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="line span-12 red">
                                <x-checkbox class="inline-block" style="transform: translateY();" />
                                <div class="span-11 extended padding-l">
                                    <div class="span-11 extended inline-block line-height-100 margin-b">
                                        <p class="inline copy line-height-100 v-align-middle">
                                            Die Genehmigung für den Wohnsitz wurde am [dd.mm.yyyy] durch den DRC-Vorstand erteilt
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Retriever-Rasse/n</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100">
                Gezüchtete Retriever-Rasse/n:
            </p>
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

<div class="span-12 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Gewünschte Parallel-Würfe</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        @php
            $countParallelWuerfe = 2; // TODO
        @endphp
        <div class="span-12 inline-block">
            @if ($countParallelWuerfe == 1)
                <p class="copy line-height-100">
                    Durch den Züchter ist maximal {{ $countParallelWuerfe }} Parallelwurf gewünscht.
                </p>
            @else
                <p class="copy line-height-100">
                    Durch den Züchter sind maximal {{ $countParallelWuerfe }} Parallelwürfe gewünscht.
                </p>
            @endif
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Welpen-Abgabe</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12 inline-block v-align-bottom">
            <p class="span-8 extended inline-block copy-bold line-height-100">
                Welpen-Abgabepreis inkl. Ahnentafel, EU-Heimtierausweis und Microchip je Welpe:
            </p>
            <p class="span-2 inline-block copy line-height-100">[0.000,00] €</p>
        </div>
        <div class="span-12 inline-block v-align-bottom">
            <p class="span-8 extended inline-block copy-bold line-height-100">
                Rückerstattung für züchterisch notwendige gesundheitliche Untersuchungen:
            </p>
            <p class="span-2 inline-block copy line-height-100">[0.000,00] €</p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Hunde</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold smaller">Zuchthündinnen</p>
            <div class="span-12 margin-b-x2 border-b">
                <div class="span-12 border-b"></div>
            </div>

            @for ($i = 0; $i < 5; $i++)
                <div class="span-12">
                    <div class="inline-block span-8 extended">
                        <p class="copy line-height-100">
                            <span class="copy-bold line-height-100 margin-r">Name:</span>
                            [Komplettname der Hündin]
                        </p>
                    </div>
                    <div class="inline-block span-4">
                        <p class="copy line-height-100">
                            <span class="copy-bold line-height-100 margin-r">ZB-Nr.:</span>
                            [XXX XX000000/00]
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold smaller">Weitere vorhandene Hunde in der Zuchtstätte</p>
            <div class="span-12 margin-b-x2 border-b">
                <div class="span-12 border-b"></div>
            </div>

            @php
                $otherDogsCount = 3;
            @endphp
            @if ($otherDogsCount == 0)
                <div class="span-12">
                    <div class="inline-block span-8 extended">
                        <p class="copy-bold line-height-100">Es sind keine weiteren Hunde vorhanden.</p>
                    </div>
                </div>
            @else
                @for ($j = 0; $j < $otherDogsCount; $j++)
                    <div class="span-12 margin-b-x2">
                        <div class="span-12">
                            <div class="inline-block span-8 extended">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">Name:</span>
                                    [Komplettname der Hündin]
                                </p>
                            </div>
                            <div class="inline-block span-4">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">ZB-Nr.:</span>
                                    [XXX XX000000/00]
                                </p>
                            </div>
                        </div>
                        <div class="span-12">
                            <div class="inline-block span-8 extended">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">Rasse:</span>
                                    [Komplettname der Hündin]
                                </p>
                            </div>
                            <div class="inline-block span-4">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">Chipnummer:</span>
                                    [000000000000000]
                                </p>
                            </div>
                        </div>
                        <div class="span-12">
                            <div class="inline-block span-8 extended">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">Geschlecht:</span>
                                    [Komplettname der Hündin]
                                </p>
                            </div>
                            <div class="inline-block span-4">
                                <p class="copy line-height-100">
                                    <span class="copy-bold line-height-100 margin-r">Wurfdatum:</span>
                                    [dd.mm.yyyy]
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>


<div class="span-12 margin-b-x4">
    <span class="mg-headline">Züchterisches Wissen</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12 margin-b-x4">
            <p class="copy-bold line-height-100 span-12">Bisherige kynologische Erfahrungen im Hinblick auf
                Haltung,
                Erziehung, Zucht:</p>

            <div class="text-box">
                <p class="copy span-12 border-b">[Text]</p>
                <p class="copy span-12 border-b">[Text]</p>
            </div>
        </div>

        <div class="span-12">
            <div class="span-12 line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(-12.5%);" />
                <div class=" span-11 inline-block lime line-height-100">
                    <p class="inline copy cyan line-height-100 v-align-middle">Die neueste
                        DRC/VDH-Zuchtbestimmungen und
                        DRC-Ordnungen sind dem/den Züchter/n bekannt.
                    </p>
                </div>
            </div>
            <div class="span-12 padding-t padding-b line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(-12.5%);" />
                <div class=" span-11 inline-block lime line-height-100">
                    <p class="inline copy cyan line-height-100 v-align-middle">Der Rassezuchtwart hat die
                        Buchempfehlungen gemäß Literaturliste an den Antragsteller gegeben.
                    </p>
                </div>
            </div>
            <div class="span-12 line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(-12.5%);" />
                <div class=" span-11 inline-block lime line-height-100">
                    <p class="inline copy cyan line-height-100 v-align-middle">Der/die Züchter wurde/n auf die
                        Einhaltung der Zwingerordnung des DRC e.V. hingewiesen.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x4">
    <span class="mg-headline">Persönliche Aufzuchtverhältnisse</span>
    <div class="mg-underline margin-b-x2"></div>

    <p class="copy-bold line-height-100 span-12">Wieviel Zeit steht dem/n Züchter/n während der Aufzuchtzeit am
        Tag
        für die Wurfbetreuung zur Verfügung?: <span class="copy line-height-100">[XX,XX] Stunden</span></p>

    <div class="span-12">
        <p class="subheadline-bold smaller">Wer steht zur Betreuung der Welpen bei Abwesenheit des Züchters zur
            Verfügung?</p>
        <div class="span-12 margin-b-x2 border-b">
            <div class="span-12 border-b"></div>
        </div>

        <div class="span-12 line">
            <div class="span-12">
                <span class="line-height-100 copy-bold">
                    Partner: <p class="inline line-height-100 copy">[Vorname] [Nachname]</p>
                </span>
            </div>
            @for ($i = 0; $i < 3; $i++)
                <div class="span-8 inline-block yellow">
                    <span class="line-height-100 copy-bold">
                        Kind: <p class="inline line-height-100 copy">[Vorname] [Nachname]</p>
                    </span>
                </div>
                <div class="space-h"></div>

                <div class="span-4 inline-block text-align-r orange">
                    <div class="span-3 inline-block">
                        <span class="line-height-100 copy-bold">
                            Geburtsdatum: <p class="inline line-height-100 copy">[dd.mm.yyyy]</p>
                        </span>
                    </div>
                    <div class="span-1 extended inline-block">
                        <span class="line-height-100 copy-bold">
                            Alter: <p class="inline line-height-100 copy">[XX]</p>
                        </span>
                    </div>
                </div>
            @endfor
            <div class="span-12">
                <span class="line-height-100 copy-bold">
                    Weitere mögliche Betreuungsperson: <p class="inline line-height-100 copy">[Vorname]
                        [Nachname]</p>
                </span>
            </div>
        </div>
    </div>

    <div class="span-12">
        <p class="subheadline-bold smaller">Die persönlichen Verhältnisse sind für die Aufzucht von wievielen
            Würfen
            gleichzeitig geeignet?</p>
        <div class="span-12 margin-b-x2 border-b">
            <div class="span-12 border-b"></div>
        </div>

        <div class="span-12 line">
            <div class="span-12">
                <p class="line-height-100 copy">[X] Würfe gleichzeitig</p>
            </div>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x4">
    <span class="mg-headline">Aufzuchtbereich</span>
    <div class="mg-underline margin-b-x2"></div>


    <div class="line span-12">
        <p class="copy-bold line-height-100 span-4 inline-block">Örtliche Gegebenheiten der Zucht:</p>

        <div class="span-8 extended inline-block cyan text-align-r">
            <div class="span-2 extended inline-block v-align-middle text-align-c">
                <x-checkbox class="inline-block" />
                <p class="inline-block copy-small-bold">Haus</p>
            </div>
            <div class="span-2 extended inline-block v-align-middle text-align-c lime">
                <x-checkbox class="inline-block" />
                <p class="inline-block copy-small-bold">Wohnung</p>
            </div>
            <div class="span-2 inline-block v-align-middle text-align-c blue">
                <x-checkbox class="inline-block" />
                <p class="inline-block copy-small-bold">Garten</p>
            </div>
            <div class="span-2 extended inline-block v-align-middle text-align-r">
                <x-checkbox class="inline-block" />
                <p class="inline-block copy-small-bold">Zwinger(-auslauf)</p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4 no-page-break-inside">
    <span class="mg-headline">Räumliche Aufzuchtverhältnisse</span>
    <div class="mg-underline"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold smaller">Innenauslauf</p>
            <div class="span-12 border-b margin-b">
                <div class="span-12 border-b"></div>
            </div>
            <div class="span-12 margin-b">
                <span class="line-height-100 copy-bold">Größe/Fläche pro Wurf: </span>
                <span class="line-height-100 copy">[XXX,XX] m²</span>
                <span class="line-height-100 copy-bold"> (mindestens 12 m²)</span>
            </div>

            <div class="span-12 margin-b-x2">
                <div class="text-box">
                    <span class="line-height-100 copy-bold">Geplanter Aufzuchtsraum/Lage: </span>
                    <span class="copy line-height-100">[Text]</span>
                    <p class="copy span-12 line-height-100">[Text]</p>
                    <p class="copy span-12 line-height-100">[Text]</p>
                </div>
            </div>

            <div class="span-12 margin-b-x2">
                <div class="text-box">
                    <span class="line-height-100 copy-bold">Abgrenzung/Sicherung des Auslaufs: </span>
                    <span class="copy line-height-100">[Text]</span>
                    <p class="copy span-12 line-height-100">[Text]</p>
                    <p class="copy span-12 line-height-100">[Text]</p>
                </div>
            </div>

            <div class="span-12 margin-b-x2">
                <div class="text-box">
                    <span class="line-height-100 copy-bold">Bodenbeschaffenheit: </span>
                    <span class="copy line-height-100">[Text]</span>
                    <p class="copy span-12 line-height-100">[Text]</p>
                    <p class="copy span-12 line-height-100">[Text]</p>
                </div>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold smaller">Außenauslauf</p>
            <div class="span-12 border-b margin-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="span-12 margin-b">
                <span class="line-height-100 copy-bold">Größe/Fläche pro Wurf: </span>
                <span class="line-height-100 copy">[XXX,XX] m²</span>
                <span class="line-height-100 copy-bold"> (mindestens 50 m²)</span>
            </div>

            <div class="span-12 margin-b-x2">
                <div class="text-box">
                    <span class="line-height-100 copy-bold">Lage: </span>
                    <span class="copy line-height-100">[Text]</span>
                    <p class="copy span-12 line-height-100">[Text]</p>
                    <p class="copy span-12 line-height-100">[Text]</p>
                </div>
            </div>

            <div class="span-12 margin-b-x2">
                <div class="text-box">
                    <span class="line-height-100 copy-bold">Abgrenzung/Sicherung des Auslaufs: </span>
                    <span class="copy line-height-100">[Text]</span>
                    <p class="copy span-12 line-height-100">[Text]</p>
                    <p class="copy span-12 line-height-100">[Text]</p>
                </div>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold smaller">Beschaffenheit</p>
            <div class="span-12 border-b margin-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="span-12 margin-b-x2">
                <ul style="list-style: square inside">
                    <li class="copy">
                        <span class="line-height-100 copy-bold">Boden: </span>
                        <span class="copy line-height-100">[Text]</span>
                        <p class="copy span-12 line-height-100">[Text]</p>
                        <p class="copy span-12 line-height-100">[Text]</p>
                    </li>
                    <li class="copy">
                        <span class="line-height-100 copy-bold">Bewuchs: </span>
                        <span class="copy line-height-100">[Text]</span>
                        <p class="copy span-12 line-height-100">[Text]</p>
                        <p class="copy span-12 line-height-100">[Text]</p>
                    </li>
                    <li class="copy">
                        <span class="line-height-100 copy-bold">Schutzmöglichkeiten: </span>
                        <span class="copy line-height-100">[Text]</span>
                        <p class="copy span-12 line-height-100">[Text]</p>
                        <p class="copy span-12 line-height-100">[Text]</p>
                    </li>
                    <li class="copy">
                        <span class="line-height-100 copy-bold">Gestaltung: </span>
                        <span class="copy line-height-100">[Text]</span>
                        <p class="copy span-12 line-height-100">[Text]</p>
                        <p class="copy span-12 line-height-100">[Text]</p>
                    </li>
                    <li class="copy">
                        <span class="line-height-100 copy-bold">Sonstiges: </span>
                        <span class="copy line-height-100">[Text]</span>
                        <p class="copy span-12 line-height-100">[Text]</p>
                        <p class="copy span-12 line-height-100">[Text]</p>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="span-12">
        <p class="subheadline-bold smaller">Die räumlichen Verhältnisse sind für die Aufzucht von wievielen
            Würfen
            gleichzeitig geeignet?</p>
        <div class="span-12 margin-b-x2 border-b">
            <div class="span-12 border-b"></div>
        </div>

        <div class="span-12 line">
            <div class="span-12">
                <p class="line-height-100 copy">[X] Würfe gleichzeitig</p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4 no-page-break-inside">
    <span class="mg-headline">Vorzunehmende Veränderungen</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Neu festgestellte Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Festgestellt am:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[dd.mm.yyyy]</p>
                <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[Vorname Zuchtwart]
                    [Nachname
                    Zuchtwart],</p>
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">zu beheben bis:</p>
                <p class="inline-block copy v-align-top line-height-100">[Text]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Offene Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Festgestellt am:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[dd.mm.yyyy]</p>
                <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[Vorname Zuchtwart]
                    [Nachname
                    Zuchtwart],</p>
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">zu beheben bis:</p>
                <p class="inline-block copy v-align-top line-height-100">[Text]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>

        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Festgestellt am:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[dd.mm.yyyy]</p>
                <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[Vorname Zuchtwart]
                    [Nachname
                    Zuchtwart],</p>
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">zu beheben bis:</p>
                <p class="inline-block copy v-align-top line-height-100">[Text]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Behobene Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Kontrolliert am:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[dd.mm.yyyy]</p>
                <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[Vorname Zuchtwart]
                    [Nachname
                    Zuchtwart]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>

        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Kontrolliert am:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[dd.mm.yyyy]</p>
                <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                <p class="inline-block copy margin-r-x2 v-align-top line-height-100">[Vorname Zuchtwart]
                    [Nachname
                    Zuchtwart]</p>
            </div>
        </div>
        <div class="span-12">
            <div class="inline-block span-12">
                <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                <p class="inline-block span-11 copy v-align-top line-height-100 border-b">[Text]</p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 padding-t-x4 margin-b-x4 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x2"></div>
    <p class="copy-bold line-height-100 margin-b-x2">
        Der Antragsteller wurde durch den Zuchtwart auf folgende Punkte hingewiesen:
    </p>
    <div class="line-height-100 span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY();" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Alle Mitglieder der jeweiligen Zuchtkommissionen stehen Züchtern für eine Zuchtberatung zur
                Verfügung.
            </p>
        </div>
    </div>
    <div class="line-height-100 span-12 line margin-b">
        <x-checkbox class="inline-block" style="transform: translateY(-175%);" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Die Vorschriften in der Zwinger- und Zuchtordnungen in der jeweils gültigen Fassung sind
                einzuhalten.<br>
                Grundlage sind die jeweiligen VDH- und DRC-Bestimmungen und das Tierschutzgesetz.
            </p>
        </div>
    </div>
    <div class="line-height-100 span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY();" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Dieser Bericht muss bei der Wurfabnahme vorgelegt werden. Die darin gemachten Angaben werden
                überprüft.
            </p>
        </div>
    </div>
    <div class="line-height-100 span-12 line">
        <x-checkbox class="inline-block" style="transform: translateY(-175%);" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Im Falle eines Umzugs ist der Züchter verpflichtet, eine erneute Zuchtstättenbesichtigung
                durch
                einen DRC-Zuchtwart
                durchführen zu lassen – spätestens vier Wochen vor dem nächsten geplanten Deckakt.
            </p>
        </div>
    </div>
    <div class="line-height-100 span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY();" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Kilometer- und Tagesgeld für die Zuchtstättenbesichtigung wurden vom Antragsteller direkt an
                den
                Zuchtwart gezahlt.
            </p>
        </div>
    </div>
    <div class="line-height-100 span-12 line">
        <x-checkbox class="inline-block" style="transform: translateY();" />
        <div class=" span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.
            </p>
        </div>
    </div>
</div>


<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Zuchtstätten-Freigabe</span>
    <div class="mg-underline margin-b-x3"></div>
    <div class="line">
        @php
            //TODO
            $zuchtstaetteFreigegeben = true;
        @endphp
        @if ($zuchtstaetteFreigegeben)
            <p class="subheadline-bold smaller line-height-100">
                Die Zuchtstätte ist hiermit freigegeben, eventuelle ausstehende kleine Mängel sind noch zu beheben.
            </p>
        @else
            <p class="subheadline-bold smaller line-height-100">
                Die Zuchtstätte ist nicht freigegeben. Die Mängel sind zu beheben und eine erneute
                Zuchtstättenbesichtigung
                ist zu beantragen.
            </p>
        @endif
    </div>

    <div class="line span-12" style="margin-top: 14mm;">

        <div class="span-12">
            <div class="span-6">
                <p class="copy-small wrap-pre-line">Bei dieser Zuchtstättenbesichtigung
                    war als Zuchtwart-Anwärter anwesend:</p>
            </div>
            <div class="space-h"></div>
            <div class="span-6">
                <div class="span-6 margin-b-x2">
                    <p class="border-b wrap-pre-line copy">[Vorname Zuchtwartanwärter] [Nachname Zuchtwartanwärter]
                    </p>
                    <p class="amtstitel">Zuchtwart-Anwärter</p>
                </div>
            </div>
        </div>

        <div class="span-12" style="margin: 14mm 0;">
            <div class="span-6">
                <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
                </p>
            </div>
            <div class="space-h"></div>
        </div>

        <div class="span-12">
            <div class="span-6 margin-b-x2">
                <p class="border-b wrap-pre-line copy">[Vorname Zuchtwart] [Nachname Zuchtwart]
                </p>
                <p class="amtstitel">Zuchtwart</p>
            </div>
            <div class="space-h"></div>

            <div class="span-6">
                <div class="span-6 margin-b-x2">
                    <p class="border-b wrap-pre-line copy">{{ $person->vorname }} {{ $person->nachname }}
                    </p>
                    <p class="amtstitel">Antragsteller</p>
                </div>

                @foreach ($mitinhaber_list as $index => $mitinhaber)
                    <div class="span-6 margin-b-x2">
                        <p class="border-b wrap-pre-line copy">{{ $mitinhaber->vorname }} {{ $mitinhaber->nachname }}
                        </p>
                        <p class="amtstitel">{{$index + 1}}. Zwinger-Mitinhaber</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- @foreach ($mitinhaber_list as $mitinhaber)
        <div class="span-6 margin-b-x2">
            <p class="border-b wrap-pre-line copy">{{ $mitinhaber->vorname }} {{ $mitinhaber->nachname }}
            </p>
            <p class="amtstitel">Mitinhaber</p>
        </div>
        @endforeach --}}

    </div>
</div>