@use('App\Models\Hund')
@use('App\Models\HundPerson')
@use('App\Models\Person')
@use('App\Models\Richter')

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Prüfung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-6">
            <p class="copy line-height-100"><span class="copy-bold margin-r">Typ:</span>{{ $pruefungstyp }}</p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            @if ($pruefungstyp == "RGP" || $pruefungstyp == "BLP" || $pruefungstyp == "*")
                <div class="span-6">
                    <div class="span-2 extended">
                        <x-checkbox class="inline-block margin-r v-align-middle" />
                        <p class="inline-block copy v-align-baseline">mit lebender Ente</p>
                    </div>
                    @if ($pruefungstyp == "RGP" || $pruefungstyp == "*")
                        <div class="span-2">
                            <x-checkbox class="inline-block margin-r v-align-middle" />
                            <p class="inline-block copy v-align-baseline">mit Fuchs</p>
                        </div>
                    @endif
                </div>
            @endif
            @if ($pruefungstyp == "RGP" || $pruefungstyp == "SwP" || $pruefungstyp == "*")
                <div class="span-6">
                    <div class="span-2 v-align-middle extended">
                        <p class="inline-block copy-bold v-align-top">(Schweiß)-Fährte:</p>
                    </div>
                    <div class="span-2 red v-align-middle">
                        <!-- TODO: Wenn kein Hund auf totverbeller/-verweiser geprüft wurd -> false -->
                        <x-checkbox class="inline-block margin-r v-align-middle" crossed={{ true }} />
                        <p class="inline-block copy v-align-baseline">1.000 m</p>
                    </div>
                    <div class="span-2 v-align-middle">
                        <x-checkbox class="inline-block margin-r v-align-middle" crossed={{ $totverbellerVerweiser }} />
                        <p class="inline-block copy v-align-baseline">1.200 m</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Prüfungsdatum:</span>{{$pruefung->datum}}
            </p>
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Veranstalter:</span>[Veranstalter]
            </p>
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Veranstaltungsort:</span>[Veranstaltungsort]</p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <div class="span-2 extended">
                <p class="inline-block line-height-100 copy wrap-pre-line"><span
                        class="copy-bold line-height-100 margin-r">Reviere:</span>[Text]
                    [Text]
                    [Text]</p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Prüfungsleiter</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-6">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Name:</span>[Vorname],
                [Nachname]</p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">VR-Nummer:</span>[VR-Nummer]</p>
        </div>
    </div>
    <div class="line">
        <div class="span-6">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Straße und
                    Nr.:</span>[Straße und Hausnummer]</p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>[+00
                000 00000000]</p>
        </div>
    </div>
    <div class="line">
        <div class="span-6">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Wohnort:</span>[PLZ],
                [Wohnort]</p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Bedingungen</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12 border-b">
            <p class="sectionheadline">Umgebung</p>
        </div>

        <div class="span-12 red">
            <div class="span-3 extended">
                <p class="copy-bold line-height-100">Wetter an den Prüfungstagen:</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">sonnig</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">bedeckt</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">regnerisch</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">starker Regen</p>
            </div>
            <div class="span-2">
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">[X]°C Temperatur</p>
            </div>
        </div>

        <div class="span-12 red">
            <div class="span-3 extended">
                <p class="copy-bold line-height-100">Bodenzustand:</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">gefroren</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">feucht</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">trocken</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">sehr trocken</p>
            </div>
        </div>

        <div class="span-12 red">
            <div class="span-3 extended">
                <p class="copy-bold line-height-100">Wind:</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">ohne</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">leicht</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">stark</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">Sturm</p>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12 border-b">
            <p class="sectionheadline">Wildvorkommen</p>
        </div>

        <div class="span-12 red">
            <div class="span-2 extended">
                <p class="copy-bold line-height-100">Haarwild:</p>
            </div>
            <div class="span-1 extended">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">sehr gut</p>
            </div>
            <div class="space-h"></div>
            <div class="span-1 extended">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">gut</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">genügend</p>
            </div>
            <div class="span-2">
                <p class="copy-bold line-height-100">Federwild:</p>
            </div>
            <div class="span-1 extended">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">sehr gut</p>
            </div>
            <div class="space-h"></div>
            <div class="span-1 extended">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">gut</p>
            </div>
            <div class="span-2">
                <x-checkbox class="inline-block margin-r v-align-bottom" />
                <p class="inline-block line-height-100 copy-small-bold v-align-bottom">genügend</p>
            </div>
        </div>
    </div>

    @if ($pruefungstyp == "RSwP" || $pruefungstyp == "*")
        <div class="line">
            <div class="span-12 border-b">
                <p class="sectionheadline">Ergänzende Angaben bei Vereinsschweißprüfungen</p>
            </div>

            <div class="span-12 red margin-b">
                <div class="span-3 extended">
                    <p class="copy-bold line-height-100">a) Prüfungsgelände:</p>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Altholz</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Graswuchs</p>
                    </div>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Stangenholz</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Farnkräuter</p>
                    </div>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Dickung</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Beerenkräuter</p>
                    </div>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Laubdecke</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Nadeldecke</p>
                    </div>
                </div>
                <div class="span-2">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block copy-small-bold v-align-bottom">ohne Unterwuchs</p>
                </div>
            </div>

            <div class="span-12 red margin-b">
                <div class="span-5">
                    <p class="copy-bold line-height-100">b) Verwendeter Schweiß (Schalenwildart):</p>
                </div>
                <div class="span-7 border-b">
                    <p class="copy-small">[Verwendeter Schweiß]</p>
                </div>
            </div>

            <div class="span-12 red margin-b">
                <div class="span-3 extended">
                    <p class="copy-bold">c) Fährte:</p>
                </div>
                <div class="span-2">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block copy-small-bold v-align-bottom">getropft</p>
                </div>
                <div class="span-2">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block copy-small-bold v-align-bottom">getupft</p>
                </div>
            </div>

            <div class="span-12 red margin-b">
                <div class="span-5">
                    <p class="copy-bold">d) Im Revier vorkommende Wildarten:</p>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Rotwild</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Rehwild</p>
                    </div>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Sikawild</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Schwarzwild</p>
                    </div>
                </div>
                <div class="span-2">
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Damwild</p>
                    </div>
                    <div class="span-2 inline-block">
                        <x-checkbox class="inline-block margin-r v-align-bottom" />
                        <p class="inline-block copy-small-bold v-align-bottom">Muffelwild</p>
                    </div>
                </div>
            </div>
            <div class="span-12 red">
                <div class="span-2 extended">
                    <p class="copy-bold">e) Sonstiges Wild:</p>
                </div>
                <div class="span-10 border-b">
                    <p class="copy-small">[Wildart], [Wildart]</p>
                </div>
            </div>
        </div>
    @endif

</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Prüfungsbericht</span>
    <div class="mg-underline margin-b"></div>

    <div class="span-12">
        <div class="inline-block span-2">
            <p class="copy-bold">Teilnehmer:</p>
        </div>
        <div class="inline-block span-2">
            <p class="copy-small-bold"><span class="copy-small">[XX]</span> gemeldet</p>
        </div>
        <div class="inline-block span-2">
            <p class="copy-small-bold"><span class="copy-small">[XX]</span> geprüft</p>
        </div>
        <div class="inline-block span-2">
            <p class="copy-small-bold"><span class="copy-small">[XX]</span> bestanden</p>
        </div>
    </div>
    @if ($pruefungstyp == "RGP" || $pruefungstyp == "RSwP" || $pruefungstyp == "Toller" || $pruefungstyp == "*")
        <div class="line">
            <div class="span-12 border-b">
                <p class="sectionheadline">Preis-Vergabe</p>
            </div>
            <div class="inline-block span-2">
                <p class="copy-bold">1. Preis: <span class="copy">[XX]</span></p>
            </div>
            <div class="inline-block span-2">
                <p class="copy-bold">2. Preis: <span class="copy">[XX]</span></p>
            </div>
            <div class="inline-block span-2">
                <p class="copy-bold">3. Preis: <span class="copy">[XX]</span></p>
            </div>
        </div>
    @endif

    @if ($pruefungstyp == "RGP" || $pruefungstyp == "SRP" || $pruefungstyp == "HP/R" || $pruefungstyp == "PnS" || $pruefungstyp == "Field Trail" || $pruefungstyp == "*")
        <div class="line margin-b">
            <div class="span-12 border-b">
                <p class="sectionheadline">CACT-Vergabe</p>
            </div>
            <div class="span-3 extended">
                <div class="span-1 extended">
                    <p class="inline-block copy-bold">CACT:</p>
                </div>
                <div class="inline-block span-1">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block line-height-100 copy-bold v-align-bottom">ja</p>
                </div>
                <div class="inline-block span-1">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block line-height-100 copy-bold v-align-bottom">nein</p>
                </div>
            </div>
            <div class="space-h"></div>
            <div class="span-4">
                <div class="span-2">
                    <p class="inline-block copy-bold">Reserve-CACT:</p>
                </div>
                <div class="inline-block span-1">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block line-height-100 copy-bold v-align-bottom">ja</p>
                </div>
                <div class="inline-block span-1">
                    <x-checkbox class="inline-block margin-r v-align-bottom" />
                    <p class="inline-block line-height-100 copy-bold v-align-bottom">nein</p>
                </div>
            </div>
        </div>
    @endif

    <div class="line no-page-break-inside">
        <div class="span-12 border-b">
            <p class="sectionheadline">Folgende Hunde sind nicht erschienen</p>
        </div>
        @if (count($nichtErschieneneHundeIds) > 0)
            @foreach ($nichtErschieneneHundeIds as $hundId)
                @php
                    $hund = Hund::find($hundId);
                    $name = $hund->name;
                    $geschlecht = $hund->geschlechtId == 1 ? "Rüde" : "Hündin";
                    $rasse = $hund->rasse_name;
                    $zbnr = $hund->zuchtbuchnummer;
                    $gstbnr = $hund->gstb_nr;

                @endphp
                <div class="span-12 border-b margin-b">
                    <p class="copy line-height-100">{{$name}}, {{$geschlecht}}, {{$rasse}}, {{$zbnr}}, {{$gstbnr}}
                        [Angabe des
                        Grundes]</p>
                </div>
            @endforeach
        @else
            <p class="copy">Es sind alle Hunde erschienen.</p>
        @endif
    </div>

    <div class="line no-page-break-inside">
        <div class="span-12 border-b margin-b-x2">
            <p class="sectionheadline">Folgende Hunde haben bestanden</p>
        </div>
        <table class="span-12">
            <tr>
                <th class="border-all span-1 short"></th>
                <th class="border-trb span-4 text-align-l">
                    <p class="copy-bold">Name des Hundes</p>
                </th>
                <th class="border-trb span-1">
                    <p class="copy-small-bold">Geschlecht</p>
                </th>
                <th class="border-trb span-1">
                    <p class="copy-small-bold">Rasse</p>
                </th>
                <th class="border-trb span-1 extended">
                    <p class="copy-small-bold">ZB-Nr./<br>DGStB.-Nr.</p>
                </th>

                @if ($pruefungstyp == "RGP" || $pruefungstyp == "SRP" || $pruefungstyp == "*")
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Punkte Prädikat</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Preis</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">CACT</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Reserve-CACT</p>
                    </th>
                @endif

                @if ($pruefungstyp == "PnS" || $pruefungstyp == "HP/R")
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Punkte Prädikat</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">CACT</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Reserve-CACT</p>
                    </th>
                @endif

                @if ($pruefungstyp == "Toller")
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Punkte Prädikat</p>
                    </th>
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Preis</p>
                    </th>
                @endif

                @if ($pruefungstyp == "SwP")
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Preis</p>
                    </th>
                @endif

                @if ($pruefungstyp == "BLP")
                    <th class="border-trb span-1">
                        <p class="copy-small-bold">Punkte Prädikat</p>
                    </th>
                @endif
            </tr>

            @php
                $numberFormatter = new NumberFormatter("de-DE", NumberFormatter::PATTERN_DECIMAL, "00");
                $i = 0;
            @endphp
            @foreach ($bestandeneHundeIds as $hundId)
                        @php
                            $i++;
                            $hund = Hund::find($hundId);
                            $name = $hund->name;
                            $geschlecht = $hund->geschlechtId == 1 ? "Rüde" : "Hündin";
                            $rasse = $hund->rasse_name;
                            $zbnr = $hund->zuchtbuchnummer;
                            $gstbnr = $hund->gstb_nr;
                        @endphp
                        <tr>
                            <td class="border-rbl">
                                <p class="copy-small-bold">{{$numberFormatter->format($i)}}</p>
                            </td>
                            <td class="border-rb text-align-l">
                                <p class="copy-small">{{$name}}</p>
                            </td>
                            <td class="border-rb">
                                <p class="copy-small">{{$geschlecht}}</p>
                            </td>
                            <td class="border-rb">
                                <p class="copy-small">{{$rasse}}</p>
                            </td>
                            <td class="border-rb">
                                <p class="copy-small">[ZB-Nr.]</p>
                            </td>


                            @if ($pruefungstyp == "RGP" || $pruefungstyp == "SRP" || $pruefungstyp == "*")
                                <td class="border-rb">
                                    <p class="copy-small-bold">XXX</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">XX</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">XXX</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">XXXX</p>
                                </td>
                            @endif

                            @if ($pruefungstyp == "PnS" || $pruefungstyp == "HP/R")
                                <td class="border-rb">
                                    <p class="copy-small-bold">Punkte Prädikat</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">CACT</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">Reserve-CACT</p>
                                </td>
                            @endif

                            @if ($pruefungstyp == "Toller")
                                <td class="border-rb">
                                    <p class="copy-small-bold">Punkte Prädikat</p>
                                </td>
                                <td class="border-rb">
                                    <p class="copy-small-bold">Preis</p>
                                </td>
                            @endif

                            @if ($pruefungstyp == "SwP")
                                <td class="border-rb">
                                    <p class="copy-small-bold">Preis</p>
                                </td>
                            @endif

                            @if ($pruefungstyp == "BLP")
                                <td class="border-rb">
                                    <p class="copy-small-bold">Punkte Prädikat</p>
                                </td>
                            @endif
                        </tr>
            @endforeach
        </table>
    </div>
    <div class="line">
        <div class="span-12 border-b">
            <p class="sectionheadline">Hundeführer ohne Jagdschein</p>
        </div>
        @if (count($hundefuehrerOhneJagdscheinHundeIds) > 0)
            @foreach ($hundefuehrerOhneJagdscheinHundeIds as $hundId)
                @php
                    $hund = Hund::find($hundId);

                    $personId = HundPerson::firstWhere("hund_id", $hundId)->person_id;
                    $person = Person::find($personId);

                    $personVorname = $person->vorname;
                    $personNachname = $person->nachname;

                    $hundName = $hund->name;
                    $hundGeschlecht = $hund->geschlechtId == 1 ? "Rüde" : "Hündin";
                    $hundRasse = $hund->rasse_name;
                    $hundZbnr = $hund->zuchtbuchnummer;

                @endphp
                <div class="span-12 border-b margin-b">
                    <p class="copy line-height-100">{{$personVorname}} {{$personNachname}}, <span class="copy-bold">
                            Hund:
                        </span>
                        {{$rasse}}, {{$zbnr}}, {{$gstbnr}}
                        [Angabe des
                        Grundes]
                    </p>
                </div>
            @endforeach
        @else
            <p class="copy">Alle Hundeführer besitzen einen Jagdschein.</p>
        @endif
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Richter</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b-x2">
        <div class="span-12 border-b">
            <p class="sectionheadline">Eingesetzte Richter</p>
        </div>
        <table class="span-12 red">
            <tr>
                <th class="span-2 text-align-l padding-0 padding-r-x2 red">
                    <p class="copy-bold v-align-top">VR-Nr.</p>
                </th>
                <th class="span-4 text-align-l padding-0 padding-r-x2">
                    <p class="copy-bold v-align-top">Nachname, Vorname</p>
                </th>
                <th class="span-3 text-align-l padding-0 padding-r-x2">
                    <p class="copy-bold v-align-top">PLZ, Ort</p>
                </th>
                <th class="span-3 text-align-l no-wrap padding-0 padding-r-x2">
                    <p class="copy-bold v-align-top">Fachrichtergruppen</p>
                </th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="padding-0 text-align-l">
                    <div class="inline-block span-1">
                        <p class="inline-block copy-small line-height-100">keine</p>
                    </div>
                    <div class="inline-block span-1">
                        <p class="inline-block copy-small line-height-100">Bringen</p>
                    </div>
                    <div class="inline-block span-1">
                        <p class="inline-block copy-small line-height-100">Wald</p>
                    </div>
                    <div class="inline-block span-1">
                        <p class="inline-block copy-small line-height-100">Wasser</p>
                    </div>
                </td>
            </tr>
            @foreach ($richterIds as $richterId)
                        @php
                            $richter = Richter::find($richterId);
                            $fachrichtergruppe = $richter->richterattribute_id;

                            $richter_person = Person::find($richter->person_id);
                            $nachname = $richter_person->nachname;
                            $vorname = $richter_person->vorname;
                            $plz = $richter_person->postleitzahl;
                            $wohnort = $richter_person->ort;
                        @endphp
                        <tr>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">[VR-Nr.]</p>
                            </td>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$nachname}}, {{$vorname}}</p>
                            </td>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$plz}} {{$wohnort}}</p>
                            </td>
                            <td class="text-align-l no-wrap padding-0 padding-r-x2">
                                <div class="span-1 margin-l inline-block red">
                                    <x-checkbox class="inline-block v-align-baseline" :crossed="($fachrichtergruppe == 1 || $fachrichtergruppe == null)"></x-checkbox>
                                </div>
                                <div class="span-1 margin-l inline-block yellow">
                                    <x-checkbox class="inline-block v-align-baseline"
                                        :crossed="($fachrichtergruppe == 2)"></x-checkbox>
                                </div>
                                <div class="span-1 margin-l inline-block lime">
                                    <x-checkbox class="inline-block v-align-baseline"
                                        :crossed="($fachrichtergruppe == 3)"></x-checkbox>
                                </div>
                                <div class="span-1 margin-l inline-block cyan">
                                    <x-checkbox class="inline-block v-align-baseline"
                                        :crossed="($fachrichtergruppe == 4)"></x-checkbox>
                                </div>
                            </td>
                        </tr>
            @endforeach
        </table>
    </div>

    <div class="line red">
        <div class="span-12 border-b margin-b">
            <p class="sectionheadline yellow">Notrichter</p>
        </div>
        @if (count($notrichterPersonIds) > 0)
            <table class="span-12 margin-b">
                <tr class="cyan">
                    <th class="span-6 text-align-l padding-0 padding-r-x2">
                        <p class="copy-bold v-align-top line-height-100">Nachname, Vorname</p>
                    </th>
                    <th class="span-6 text-align-l padding-0 padding-r-x2">
                        <p class="copy-bold v-align-top line-height-100">PLZ, Ort</p>
                    </th>
                </tr>
                @foreach ($notrichterPersonIds as $notrichterPersonId)
                        @php
                            $person = Person::find($notrichterPersonId);

                            $nachname = $person->nachname;
                            $vorname = $person->vorname;
                            $plz = $person->postleitzahl;
                            $wohnort = $person->ort;
                        @endphp
                        <tr>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$nachname}}, {{$vorname}}</p>
                            </td>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$plz}} {{$wohnort}}</p>
                            </td>
                        </tr>
                @endforeach
            </table>
            <div class="span-12">
                <p class="copy line-height-100">Der Einsatz eines nicht anerkannten Richters wird als Notfall wie folgt
                    begründet<br>(s. §5
                    (3) JAS/RO, BLPO, RGPO, PnSO s. §5 (3) RGPO, HP/RO §40 (11), SRPO §11 (4), RSWP §5)
                </p>
            </div>
        @else
            <div class="span-12">
                <p class="copy">Es kam kein Notrichter zum Einsatz.</p>
            </div>
        @endif
    </div>

    <div class="line">
        <div class="span-12 border-b">
            <p class="sectionheadline">Richteranwärter (Anwartschaften)</p>
        </div>

        @if (count($richteranwaerterPersonIds) > 0)
            <table class="span-12">
                <tr>
                    <th class="span-2 text-align-l padding-0 padding-r-x2 red">
                        <p class="copy-bold v-align-top">RA-Nr.</p>
                    </th>
                    <th class="span-4 text-align-l padding-0 padding-r-x2">
                        <p class="copy-bold v-align-top">Nachname, Vorname</p>
                    </th>
                    <th class="span-3 text-align-l padding-0 padding-r-x2">
                        <p class="copy-bold v-align-top">PLZ, Ort</p>
                    </th>
                    <th class="span-3 padding-0 padding-r-x2">
                    </th>
                </tr>
                @foreach ($richteranwaerterPersonIds as $anwaerterPersonId)
                        @php
                            $anwaerterPerson = Person::find($anwaerterPersonId);

                            $nachname = $anwaerterPerson->nachname;
                            $vorname = $anwaerterPerson->vorname;
                            $plz = $anwaerterPerson->postleitzahl;
                            $wohnort = $anwaerterPerson->ort;
                        @endphp
                        <tr>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">[RA-Nr.]</p>
                            </td>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$nachname}}, {{$vorname}}</p>
                            </td>
                            <td class="text-align-l padding-0 padding-r-x2">
                                <p class="copy line-height-100 border-b">{{$plz}} {{$wohnort}}</p>
                            </td>
                        </tr>
                @endforeach
            </table>
        @else
            <div class="span-12">
                <p class="copy">Es war kein Richteranwärter anwesend.</p>
            </div>
        @endif
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Bestätigung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12 inline-block">
            <x-checkbox checked class="inline-block v-align-middle"></x-checkbox>
            <p class="copy inline-block">Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.</p>
        </div>
    </div>

    <!-- <div class="pin-bottom" style="margin-bottom: 20mm;"> -->
    <div class="span-12" style="margin-top: 21mm;">
        <div class="span-6 left">
            <p class="border-b">[Ort], den [dd.mm.yyyy]</p>
            <br>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">
            </p>
            <p class="amtstitel">Prüfungsleiter</p>
        </div>
    </div>
    <!-- </div> -->
</div>