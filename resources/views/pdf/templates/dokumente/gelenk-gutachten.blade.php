<!-- #region Page 1 -->
@use('App\Http\Controllers\Utils\DateFormatter')

@php
    $qualitaet_lookup = [
        1 => 'sehr gut',
        2 => 'gut',
        3 => 'ausreichend',
    ];

    $becken_lookup = [
        1 => 'symmetrisch',
        2 => 'geringgradig asymmetrisch',
        3 => 'asymmetrisch',
    ];

    $gliedmassen_lookup_0 = [
        1 => 'gut gestreckt',
        2 => 'mäßig gestreckt',
        3 => 'ungenügend gestreckt',
    ];
    $gliedmassen_lookup_1 = [
        1 => 'gut eingedreht',
        2 => 'mäßig eingedreht',
        3 => 'ungenügend eingedreht',
        4 => 'stark eingedreht',
        5 => 'übermäßig eingedreht',
    ];
    $gliedmassen_lookup_2 = [
        1 => 'parallel',
        2 => 'nicht ausreichend parallel',
        3 => 'nicht parallel',
    ];

    $gesamteindruck_lookup = [
        1 => 'tief',
        2 => 'geringgradig flach',
        3 => 'flach',
    ];

    $pfannenkontur_lookup = [
        1 => 'strichförmig',
        2 => 'geringgradige subchondrale Sklerose',
        3 => 'subchondrale Sklerose',
    ];

    $kraniolateraler_pfannenkontur_lookup = [
        1 => 'rund auslaufend',
        2 => 'geringgradig horizontal',
        3 => 'horizontal geringgradig nach vorn abgeflacht',
        4 => 'nach vorn abgeflacht',
    ];

    $oberschenkelkopf_gesamteindruck_lookup = [
        1 => 'kugelförmig',
        2 => 'geringgradig abgeflacht',
        3 => 'abgeflacht geringgradige Deformation',
        4 => 'Deformation geringgradige Kragenbildung',
        5 => 'Kragenbildung',
    ];

    $oberschenkelkopf_sitz_in_der_pfanne_lookup = [
        1 => 'tief',
        2 => 'geringgradig lose',
        3 => 'lose',
    ];

    $uebergang_lookup = [
        1 => 'schlank',
        2 => 'mäßig abgesetzt',
        3 => 'schlecht abgesetzt',
        4 => 'geringgradig unscharf',
        5 => 'unscharf',
        6 => 'scharf konturiert',
        7 => 'geringgradige Auflagerungen',
        8 => 'Auflagerungen',
        9 => 'geringgradige Linie nach Morgan',
        10 => 'Linie nach Morgan',
    ];

    $gelenkspalt_lookup = [
        1 => 'kongruent',
        2 => 'geringgradig divergent',
        3 => 'divergent',
    ];

    $femurkopfzentrum_lookup = [
        1 => 'medial',
        2 => 'medial auf lateral',
        3 => 'lateral',
    ];

    $winkelmessung_nach_norberg_lookup = [
        1 => '105° oder größer',
        2 => '< als 105°',
        3 => '< als 100°',
        4 => '< als 90°',
    ];

    $hd_befund_lookup = [
        1 => 'A1',
        2 => 'A2',
        3 => 'B1',
        4 => 'B2',
        5 => 'C1',
        6 => 'C2',
        7 => 'D1',
        8 => 'D2',
        9 => 'E1',
        10 => 'E2',
    ];

    $uebergangswirbel_lookup = [
        0 => 'ÜW0',
        1 => 'ÜW1',
        2 => 'ÜW2',
        3 => 'ÜW3',
    ];

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

<div class="span-12">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-6 extended inline-block">
            q <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $gelenkGutachten->hund->name }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Geschlecht:</span>{{ $gelenkGutachten->hund->geschlecht }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>{{ $gelenkGutachten->hund->rasse }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Farbe:</span>{{ $gelenkGutachten->hund->farbe }}
            </p>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>{{ $gelenkGutachten->hund->zuchtbuchnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Chipnummer:</span>{{ $gelenkGutachten->hund->chipnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Gebrachshunde-Stammbuchnummer:</span>[20XX-X/000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">JGHV-Gebrauchshunde-Stammbuchnummer:</span>[X000(oFu)]
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Wurfdatum:</span>{{ $gelenkGutachten->hund->wurfdatum }}
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
                {{--{{ $person->vorname }} {{ $person->nachname }}--}}
                {{ $gelenkGutachten->mitglied->vorname }} {{ $gelenkGutachten->mitglied->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{-- {{ $person->strasse }} {{ $person->hausnummer }}--}}
                {{ $gelenkGutachten->mitglied->strasse }}
            </p>
            {{--@if ($person->adresszusatz != null && $person->adresszusatz != '')
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                {{ $person->adresszusatz }}
            </p>
            @endif
            --}}
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{-- {{ $person->postleitzahl }} {{ $person->ort }} --}}
                {{ $gelenkGutachten->mitglied->postleitzahl }} {{ $gelenkGutachten->mitglied->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{-- {{ $person->land }} --}}
                {{ $gelenkGutachten->mitglied->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $gelenkGutachten->mitglied->mitgliedsnummer }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Röntgenuntersuchung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b-x2">
        <div class="span-8 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Datum der
                    Röntgenaufnahme:</span>{{ DateFormatter::formatDMY($gelenkGutachten->roentgenuntersuchung->datum_der_roentgenaufnahme) }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Sedier-Präparat:</span>{{ $gelenkGutachten->roentgenuntersuchung->sedier_praeparat }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Dosierung
                    Sedier-Präparat:</span>{{ $gelenkGutachten->roentgenuntersuchung->dosierung_sedier_praeparat }}ml
            </p>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Röntgentierarzt</p>
            <div class="span-12 border-b margin-b-x2">
                <div class="span-12 border-b"></div>
            </div>

            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Praxis:</span>{{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->praxis }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Name:</span>{{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->name }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Straße und
                        Nr.:</span>{{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->strasse }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Wohnort:</span>{{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->postleitzahl }}
                    {{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->ort }}
                </p>
                <p class="copy line-height-100 ">
                    <span
                        class="line-height-100 copy-bold margin-r">Land:</span>{{ $gelenkGutachten->roentgenuntersuchung->roentgentierarzt->land }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Gutachter</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b-x2">
        <div class="span-8 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $gelenkGutachten->gutachter->name }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und
                    Nr.:</span>{{ $gelenkGutachten->gutachter->strasse }}
            </p>
            <p class="copy line-height-100 ">
                <span
                    class="line-height-100 copy-bold margin-r">Wohnort:</span>{{ $gelenkGutachten->gutachter->postleitzahl }}
                {{ $gelenkGutachten->gutachter->ort }}
            </p>
        </div>
    </div>
</div>

<div class="page-break"></div>
<!-- #endregion Page 1 -->

<!-- #region Page 2 -->

@if ($gelenkGutachten->hueftgelenkdysplasie !== null)
    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Hüftgelenkdysplasie (HD)</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Röntgenaufnahme</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Qualität Lagerung:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->hueftgelenkdysplasie->qualitaet_lagerung] }}
                        </p>
                    </div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Technische Qualität:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100">
                            {{ $qualitaet_lookup[$gelenkGutachten->hueftgelenkdysplasie->technische_qualitaet] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Hüften</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4"></div>
                    <div class="space-h"></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Hüfte links:</span></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Hüfte rechts:</span></div>
                </div>

                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Beurteilung der Lagerung:</span>
                        </p>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Becken:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $becken_lookup[$gelenkGutachten->hueftgelenkdysplasie->becken[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $becken_lookup[$gelenkGutachten->hueftgelenkdysplasie->becken[1]] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Gliedmaßen:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_0[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[0][0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_0[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[0][1]] }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_1[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[1][0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_1[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[1][1]] }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_2[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[2][0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gliedmassen_lookup_2[$gelenkGutachten->hueftgelenkdysplasie->gliedmassen[2][1]] }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Beurteilung der Pfanne:</span>
                        </p>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Gesamteindruck:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gesamteindruck_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_gesamteindruck[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gesamteindruck_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_gesamteindruck[1]] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Vordere Pfannenkontur:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_vordere_kontur[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_vordere_kontur[1]] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Kraniolateraler Pfannenrand:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $kraniolateraler_pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_kraniolateraler_rand[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $kraniolateraler_pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_kraniolateraler_rand[1]] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Hintere Pfannenkontur:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_hintere_kontur[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $pfannenkontur_lookup[$gelenkGutachten->hueftgelenkdysplasie->pfanne_hintere_kontur[1]] }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Beurteilung des Oberschenkelkopfes:</span>
                        </p>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Gesamteindruck:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $oberschenkelkopf_gesamteindruck_lookup[$gelenkGutachten->hueftgelenkdysplasie->oberschenkelkopf_gesamteindruck[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $oberschenkelkopf_gesamteindruck_lookup[$gelenkGutachten->hueftgelenkdysplasie->oberschenkelkopf_gesamteindruck[1]] }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Sitz des Kopfes in der Pfanne:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $oberschenkelkopf_sitz_in_der_pfanne_lookup[$gelenkGutachten->hueftgelenkdysplasie->oberschenkelkopf_sitz_in_der_pfanne[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $oberschenkelkopf_sitz_in_der_pfanne_lookup[$gelenkGutachten->hueftgelenkdysplasie->oberschenkelkopf_sitz_in_der_pfanne[1]] }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Beurteilung des Überganges</span>
                        </p>
                    </div>

                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Oberschenkelkopf/-hals:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $uebergang_lookup[$gelenkGutachten->hueftgelenkdysplasie->uebergang[0]] }}</span>
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $uebergang_lookup[$gelenkGutachten->hueftgelenkdysplasie->uebergang[1]] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Beurteilung des Gelenkspaltes:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100">
                                {{ $gelenkspalt_lookup[$gelenkGutachten->hueftgelenkdysplasie->gelenkspalt[0]] }}
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy line-height-100">
                                {{ $gelenkspalt_lookup[$gelenkGutachten->hueftgelenkdysplasie->gelenkspalt[1]] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Femurkopfzentrum:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100">
                                {{ $femurkopfzentrum_lookup[$gelenkGutachten->hueftgelenkdysplasie->femurkopfzentrum[0]] }}
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy line-height-100">
                                {{ $femurkopfzentrum_lookup[$gelenkGutachten->hueftgelenkdysplasie->femurkopfzentrum[1]] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Winkelmessung nach Norberg:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100">
                                {{ $winkelmessung_nach_norberg_lookup[$gelenkGutachten->hueftgelenkdysplasie->winkelmessung_nach_norberg[0]] }}
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy line-height-100">
                                {{ $winkelmessung_nach_norberg_lookup[$gelenkGutachten->hueftgelenkdysplasie->winkelmessung_nach_norberg[1]] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span-12 margin-b-x4">
                <div class="span-4 extended">
                    <span class="line-height-100 mg-headline">HD-Befund</span>
                </div>

                <div class="span-4">
                    <p class="copy-bold line-height-100">
                        {{ $hd_befund_lookup[$gelenkGutachten->hueftgelenkdysplasie->hd_befund[0]] }}
                    </p>
                </div>

                <div class="span-4 extended">
                    <p class="copy-bold line-height-100">
                        {{ $hd_befund_lookup[$gelenkGutachten->hueftgelenkdysplasie->hd_befund[1]] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Übergangswirbel (ÜGW)</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line margin-b-x2">
            <div class="span-12">+

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold">Beurteilung:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $gelenkGutachten->uebergangswirbel->beurteilung_erfolgt ? 'Beurteilung erfolgt' : 'nicht durchgeführt' }}
                        </p>
                    </div>
                </div>

                @if ($gelenkGutachten->uebergangswirbel->beurteilung_erfolgt)
                    <div class="span-12">
                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold">Befund Übergangswirbel:</span>
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-8">
                            <p class="copy line-height-100 ">
                                {{ $uebergangswirbel_lookup[$gelenkGutachten->uebergangswirbel->befund_uebergangswirbel] }}
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endif

@if ($gelenkGutachten->ellenbogendysplasie !== null)
    <div class="span-12 margin-b-x4 no-page-break-inside">
        <span class="mg-headline">Ellenbogendysplasie (ED)</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Röntgenaufnahme</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Qualität Lagerung:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->ellenbogendysplasie->qualitaet_lagerung] }}
                        </p>
                    </div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Technische Qualität:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100">
                            {{ $qualitaet_lookup[$gelenkGutachten->ellenbogendysplasie->technische_qualitaet] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Ellenbogen</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12 margin-b-x3">
                    <div class="span-4"></div>
                    <div class="space-h"></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Ellenbogen links:</span></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Ellenbogen rechts:</span></div>
                </div>

                <div class="span-12">
                    <div class="span-4 extended">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Arthrosegrad:</span>
                        </p>
                    </div>

                    <div class="span-4">
                        <p class="copy line-height-100">
                            {{ $arthrosegrad_lookup[$gelenkGutachten->ellenbogendysplasie->arthrosegrad[0]] }}
                        </p>
                    </div>

                    <div class="span-4 extended">
                        <p class="copy line-height-100">
                            {{ $arthrosegrad_lookup[$gelenkGutachten->ellenbogendysplasie->arthrosegrad[1]] }}
                        </p>
                    </div>
                </div>

                <div class="span-12 border-b padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Verdacht auf:</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">IPA:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_ipa[0] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_ipa[1] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">FCP:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_fcp[0] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_fcp[1] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">OCD:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_ocd[0] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_ocd[1] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="span-12">
                        <div class="span-1 short"></div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Coronoid-Erkrankung:</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_coronoid_erkrankung[0] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy line-height-100 ">
                                <span
                                    class="line-height-100 copy margin-r">{{ $gelenkGutachten->ellenbogendysplasie->verdacht_coronoid_erkrankung[1] ? 'ja' : 'nein' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span-12">
                <div class="span-4 extended">
                    <span class="line-height-100 mg-headline">ED-Befund</span>
                </div>

                <div class="span-4">
                    <p class="copy-bold line-height-100">
                        {{ $ed_befund_lookup[$gelenkGutachten->ellenbogendysplasie->ed_befund[0]] }}
                    </p>
                </div>

                <div class="span-4 extended">
                    <p class="copy-bold line-height-100">
                        {{ $ed_befund_lookup[$gelenkGutachten->ellenbogendysplasie->ed_befund[1]] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- #endregion Page 2 -->


<!-- #region Page 3 -->
@if ($gelenkGutachten->ocd_schultern !== null)
    <div class="span-12 padding-t-x4 margin-b-x4">
        <span class="mg-headline">OCD Schultern</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Röntgenaufnahme</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Qualität Lagerung:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->ocd_schultern->qualitaet_lagerung] }}
                        </p>
                    </div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Technische Qualität:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->ocd_schultern->technische_qualitaet] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Schultern</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4"></div>
                    <div class="space-h"></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Schulter links:</span></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Schulter rechts:</span></div>
                </div>

                <div class="span-12 padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100">
                                <span class="line-height-100 mg-headline">Befund OCD-Schultern</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy-bold line-height-100">
                                {{ $gelenkGutachten->ocd_schultern->ocd_schultern_befund[0] ? 'frei' : 'nicht frei' }}
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy-bold line-height-100">
                                {{ $gelenkGutachten->ocd_schultern->ocd_schultern_befund[1] ? 'frei' : 'nicht frei' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($gelenkGutachten->ocd_sprunggelenke !== null)
    <div class="span-12 margin-b-x4">
        <span class="mg-headline">OCD Sprunggelenke</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Röntgenaufnahme</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Qualität Lagerung:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->ocd_sprunggelenke->qualitaet_lagerung] }}
                        </p>
                    </div>
                </div>

                <div class="span-12">
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Technische Qualität:</span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            {{ $qualitaet_lookup[$gelenkGutachten->ocd_sprunggelenke->technische_qualitaet] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="span-12">
                <p class="subheadline-bold smaller">Beurteilung der Sprunggelenke</p>
                <div class="span-12 border-b margin-b-x2">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-4"></div>
                    <div class="space-h"></div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Sprunggelenk links:</span>
                    </div>
                    <div class="span-4"><span class="line-height-100 copy-bold margin-r">Sprunggelenk rechts:</span>
                    </div>
                </div>

                <div class="span-12 padding-b-x2 margin-b-x2">
                    <div class="span-12">
                        <div class="span-4 extended">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 mg-headline">Befund OCD-Sprunggelenke</span>
                            </p>
                        </div>

                        <div class="span-4">
                            <p class="copy-bold line-height-100">
                                {{ $gelenkGutachten->ocd_sprunggelenke->ocd_sprunggelenke_befund[0] ? 'frei' : 'nicht frei' }}
                            </p>
                        </div>

                        <div class="span-4 extended">
                            <p class="copy-bold line-height-100">
                                {{ $gelenkGutachten->ocd_sprunggelenke->ocd_sprunggelenke_befund[1] ? 'frei' : 'nicht frei' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="pin-bottom" style="margin-bottom: 20mm;">
    <x-place-date-signature :place="$gelenkGutachten->gutachter->ort" :name="$gelenkGutachten->gutachter->name"
        nameSubline="Gutachter" />
</div>
<!-- #endregion Page 3 -->