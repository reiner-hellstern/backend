@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models\Mitgliedsart')
@use('App\Models\HundPerson')
@use('App\Models\Hund')
@use('App\Models\Person')
@use('App\Models\Zuchtbuchnummer')
@use('App\Models\Zuechter')
@use('App\Models\HundZwinger')
@use('App\Models\Ahnentafel')
@use('App\Models\HDEDUntersuchung')
@use('App\Models\OptionHDBewertung')
@use('App\Models\OptionHDEDCTGrund')
@use('App\Models\HDScoringOFA')
@use('App\Models\OptionHDScoringHS')
@use('App\Models\Dokument')
@php
    //$person1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty']);
    //$person2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty']);

    $hund = RandomDBEntries::RandomHund(['chipnummer' => 'notEmpty']);
    $person1 = $hund->personen->first();

    $person2 = null;
    if (count($hund->personen) > 1) {
        $person2 = $hund->personen[1];
    }

    $zuchtbuchnummern = $hund->zuchtbuchnummern()->orderBy('order')->get();
    $chipnummern = $hund->chipnummern()->orderBy('order', 'desc')->get();

    $zuechter = Zuechter::inRandomOrder()->whereNotNull(['vorname', 'nachname'])->first();
    $zuechter_person = Person::find($zuechter->person_id);
    $zwinger = $hund->zwinger;

    $ahnentafel = Ahnentafel::firstWhere('hund_id', $hund->id);


    //$hund = $person1->hunde()->inRandomOrder()->first();
@endphp

<div class="span-12 margin-b-x4">
    <p class="copy line-height-100">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit beantrage ich die DRC-Zuchtbuchübernahme für meinen Retriever:
    </p>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-8">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $hund->name }}
            </p>

            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                {{ $hund->rasse["name_lang"] }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                {{ $hund->geschlecht["name"] }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                {{ $hund->farbe["name"] }}
            </p>

            <div class="space-h"></div>
        </div>
        <div class="span-4 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                {{ DateFormatter::formatDMY($hund->wurfdatum) }}
            </p>
        </div>
    </div>

    <div class="span-12 line margin-b-x4">
        <span class="mg-headline">ID-Nummern</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line margin-b">
            <div class="span-12 margin-b">
                <p class="subheadline-bold">Zuchtbuchnummer</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b"></div>
                </div>
            </div>

            @foreach ($zuchtbuchnummern as $index => $zuchtbuchnummer)
                <p class="copy line-height-100 ">
                    @if ($index == 0)
                        <span class="line-height-100 copy-bold margin-r">Zuchtbuchnummer (bei Geburt):</span>
                        {{ $zuchtbuchnummer["zuchtbuchnummer"] }}
                    @else
                        <span class="line-height-100 copy-bold margin-r">Zuchtbuchnummer:</span>
                        {{ $zuchtbuchnummer["zuchtbuchnummer"] }}
                    @endif
                </p>
            @endforeach
        </div>

        <div class="line margin-b">
            <div class="span-12 margin-b">
                <p class="subheadline-bold">Chipnummer</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b"></div>
                </div>
            </div>

            @foreach ($chipnummern as $index => $chipnummer)

                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Chipnummer
                        {{(count($chipnummern) > 1) == true ? ('#' . (count($chipnummern) - $index)) : ''}}:</span>
                    {{ $chipnummer["chipnummer"] }}
                </p>
            @endforeach
        </div>

        @if ($hund->taetowierung != null)

            <div class="line margin-b">
                <div class="span-12 margin-b">
                    <p class="subheadline-bold">Tätowierung</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>

                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Tätowierungsnummer:</span>
                    {{ $hund->taetowierung }}
                </p>
            </div>
        @endif

        <!-- TODO -->
        <div style="opacity: 0.25;">
            <div class="line margin-b">
                <div class="span-12 margin-b">
                    <p class="subheadline-bold">Stammbuchnummern</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>

                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">DRC-Gebrauchshunde-Stammbuchnummer:</span>
                    [DRC-GStB-Nummer 20XX-X/000]
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">JGHV-Gebrauchshunde-Stammbuchnummer:</span>
                    [DGStB-Nummer X000(oFu)]
                </p>
            </div>
        </div>
        <!-- END TODO -->
    </div>

    <div class="span-12 line margin-b-x4">
        <span class="mg-headline">Zuchtzulassung</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line span-12 margin-b">

            @if (true /* TODO */)
                <p class="copy-bold line-height-100">
                    Es besteht eine Zuchtzulassung außerhalb des DRC.
                </p>
                <p class="copy-bold line-height-100">
                    Land in dem die Zuchtzulassung erfolgt ist:
                    <span class="line-height-100 copy margin-l margin-r">[Land der Zuchtzulassung]</span>
                    Tag der Zuchtzulassung:
                    <span class="line-height-100 copy margin-l">[dd.mm.yyyy]</span>
                </p>

            @else
                <p class="copy-bold line-height-100">
                    Es besteht keine Zuchtzulassung außerhalb des DRC.
                </p>
            @endif
        </div>

    </div>

    <div class="span-12 line margin-b-x4">
        <span class="mg-headline">Elterntiere</span>
        <div class="mg-underline margin-b-x2"></div>


        <div class="line margin-b">
            <div class="span-12">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Art der Zucht:</span>
                    {{ $hund->zuchtart["name"] }}
                </p>
            </div>
        </div>

        <div class="line margin-b">
            <div class="span-12">
                <p class="copy-bold line-height-100 ">Vater</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $hund->vater_name }}
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                            {{ $hund->vater_zuchtbuchnummer }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="line margin-b">
            <div class="span-12">
                <p class="copy-bold line-height-100 ">Mutter</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="span-12">
                    <div class="span-8">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $hund->mutter_name }}
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                            {{ $hund->mutter_zuchtbuchnummer }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Züchter</span>
        <div class="mg-underline margin-b-x2"></div>
        @if($zuechter_person)
            <div class="line">
                <div class="span-6 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Name:</span>
                        {{ $zuechter_person->vorname }} {{ $zuechter_person->nachname }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                        {{ $zuechter_person->strasse }} {{ $zuechter_person->hausnummer }}
                    </p>
                    @if (strlen($zuechter_person->adresszusatz) != 0)
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                            {{ $zuechter_person->adresszusatz }}
                        </p>
                    @endif
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                        {{ $zuechter_person->postleitzahl }} {{ $zuechter_person->ort }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Land:</span>
                        {{ $zuechter_person->land }}
                    </p>
                </div>
                <div class="space-h"></div>
                <div class="span-6 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                        {{ $zuechter_person->mitgliedsnummer }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                        {{ $zuechter_person->telefon_1 }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                        {{ $zuechter_person->email_1 }}
                    </p>
                    @if (strlen($zuechter_person->website_1) != 0)
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Website:</span>
                            {{ $zuechter_person->website_1 }}
                        </p>
                    @endif
                </div>
            </div>
        @else
            [Züchter nicht gefunden]
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Page 2 -->


    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Zuchtstätte</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line">
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
                    {{ $zwinger->zwingername }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                    {{ $zwinger->strasse }}
                </p>
                @if (strlen($zwinger->adresszusatz) != 0)
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                        {{ $zwinger->adresszusatz }}
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
                @if (strlen($zwinger->website_1) != 0)
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Zwinger-Website:</span>
                        {{ $zwinger->website_1 }}
                    </p>
                @endif
            </div>
        </div>
    </div>


    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Antragsteller</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line">
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    {{ $person1->vorname }} {{ $person1->nachname }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                    {{ $person1->strasse }} {{ $person1->hausnummer }}
                </p>
                @if (strlen($person1->adresszusatz) != 0)
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                        {{ $person1->adresszusatz }}
                    </p>
                @endif
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                    {{ $person1->postleitzahl }} {{ $person1->ort }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Land:</span>
                    {{ $person1->land }}
                </p>
            </div>
            <div class="space-h"></div>
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                    {{ $person1->mitgliedsnummer }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                    {{ $person1->telefon_1 }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                    {{ $person1->email_1 }}
                </p>
                @if (strlen($person1->website_1) != 0)
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Website:</span>
                        {{ $person1->website_1 }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- TODO: multipe persons / miteigentuemer[] (as array) -> loop over -->
    @if ($person2 != null)
        <div class="span-12 margin-b-x4">
            <span class="mg-headline">Miteigentümer</span>
            <div class="mg-underline margin-b-x2"></div>
            <div class="line margin-b-x4">
                <div class="span-6 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Name:</span>
                        {{ $person2->vorname }} {{ $person2->nachname }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                        {{ $person2->strasse }} {{ $person2->hausnummer }}
                    </p>
                    @if (strlen($person2->adresszusatz) != 0)
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                            {{ $person2->adresszusatz }}
                        </p>
                    @endif
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                        {{ $person2->postleitzahl }} {{ $person2->ort }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Land:</span>
                        {{ $person2->land }}
                    </p>
                </div>
                <div class="space-h"></div>
                <div class="span-6 inline-block">
                    @if (strlen($person2->mitgliedsnummer) != 0)
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                            {{ $person2->mitgliedsnummer }}
                        </p>
                    @endif
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                        {{ $person2->telefon_1 }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                        {{ $person2->email_1 }}
                    </p>
                </div>
            </div>
        </div>
    @endif


    <div class="span-12 margin-b-x4">
        <p class="mg-headline inverted">Übernahmeunterlagen</p>
    </div>

    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Original Ahnentafel</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="line span-12">
            <div class="inline-block span-12 red">
                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY();" checked />
                    <p class="inline-block copy-bold cyan line-height-100 v-align-middle">Hiermit bestätige ich, dass
                        ich
                        die
                        Original FCI-Ahnentafel meines Hundes per Post an die Geschäftsstelle verschickt habe.</p>
                </div>
            </div>
        </div>
        <div class="line span-12">
            <div class="span-12 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Versendet am:</span>
                    {{ DateFormatter::formatDMY($ahnentafel->versendet_am) }}
                </p>
            </div>
        </div>
    </div>

    @php
        $hdedUntersuchung = $hund->hdeduntersuchungen()->first();
    @endphp
    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Gesundheit</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line">
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Hüfte</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>

            <>
                <p class="mg-small" style="font-size: 9pt; text-transform: uppercase;">HD Gutachten</p>

                @php
                    $hdlScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdl_score_option()->first() : null;
                    $resultL = $hdlScoreOption ? $hdlScoreOption["name"] : null;

                    $hdrScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdr_score_option()->first() : null;
                    $resultR = $hdrScoreOption ? $hdrScoreOption["name"] : null;

                    $dokumente = $hdedUntersuchung ? Dokument::findMany($hdedUntersuchung->dokument_id) : collect();
                @endphp
                @if ($resultL != null && $resultR != null)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">HD links:</span>
                                {{--[ABC/OFA/HIPSCORE]--}}
                                {{ $resultL }}
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">HD rechts:</span>
                                {{--[ABC/OFA/HIPSCORE]--}}
                                {{ $resultR }}
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        @foreach ($dokumente as $dokument)
                            <div class="inline-block lime line-height-100">
                                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                                <div class="span-10 border-b margin-r">
                                    <p class="inline-block copy cyan line-height-100 v-align-middle">{{ $dokument->name }}</p>
                                </div>
                                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom:
                                    {{ DateFormatter::formatDMY($dokument->datum) }}
                                </p>
                            </div>
                        @endforeach

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Kein Gutachten vorhanden.</p>
                @endif
            </>
            <>
                <p class="mg-small" style="font-size: 9pt; text-transform: uppercase;">HD Oberutachten</p>

                @php
                    $hdlScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdl_score_option()->first() : null;
                    $resultL = $hdlScoreOption ? $hdlScoreOption["name"] : null;

                    $hdrScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdr_score_option()->first() : null;
                    $resultR = $hdrScoreOption ? $hdrScoreOption["name"] : null;

                    $dokumente = $hdedUntersuchung ? Dokument::findMany($hdedUntersuchung->dokument_id) : collect();
                @endphp
                @if ($resultL != null && $resultR != null)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">HD links:</span>
                                {{--[ABC/OFA/HIPSCORE]--}}
                                {{ $resultL }}
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">HD rechts:</span>
                                {{--[ABC/OFA/HIPSCORE]--}}
                                {{ $resultR }}
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        @foreach ($dokumente as $dokument)
                            <div class="inline-block lime line-height-100">
                                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                                <div class="span-10 border-b margin-r">
                                    <p class="inline-block copy cyan line-height-100 v-align-middle">{{ $dokument->name }}</p>
                                </div>
                                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom:
                                    {{ DateFormatter::formatDMY($dokument->datum) }}
                                </p>
                            </div>
                        @endforeach

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Kein Gutachten vorhanden.</p>
                @endif
            </>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- page 3 -->

    <div class="span-12 margin-b-x4">
        <div class="line">
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Ellenbogen</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>

            <>
                <p class="mg-small" style="font-size: 9pt; text-transform: uppercase;">ED Gutachten</p>

                @php
                    $edlScoreOption = $hdedUntersuchung ? $hdedUntersuchung->ed_score_option()->first() : null;
                    $resultL = $edlScoreOption ? $edlScoreOption["wert"] . "/" . $edlScoreOption["name"] : null;

                    //$hdlScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdl_score_option()->first() : null;
                    //$resultL = $hdlScoreOption ? $hdlScoreOption["name"] : null;

                    //$hdrScoreOption = $hdedUntersuchung ? $hdedUntersuchung->hdr_score_option()->first() : null;
                    //$resultR = $hdrScoreOption ? $hdrScoreOption["name"] : null;
                @endphp
                @if (true /* TODO */)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">ED links:</span>
                                [XXX° / OFEL]

                                {{-- $resultL --}}
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">ED rechts:</span>
                                [XXX°/OFEL]
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Kein Gutachten vorhanden.</p>
                @endif
            </>

            <>
                <p class="mg-small" style="font-size: 9pt; text-transform: uppercase;">CT Ellenbogen</p>

                @if ($hdedUntersuchung)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Grund der Untersuchung:</span>
                                @php
                                    $grund = $hdedUntersuchung->ct_grund_id;
                                @endphp
                                {{ OptionHDEDCTGrund::find($grund)->name }}
                            </p>
                        </div>
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Coronoid Ellenbogen links:</span>
                                ["Frei" / "Nicht frei"]
                            </p>
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">OCD Ellenbogen links:</span>
                                ["Frei" / "Nicht frei"]
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-6">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Coronoid Ellenbogen rechts:</span>
                                ["Frei" / "Nicht frei"]
                            </p>
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">OCD Ellenbogen rechts:</span>
                                ["Frei" / "Nicht frei"]
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Kein Gutachten vorhanden.</p>
                @endif
            </>

            <p class="mg-small" style="font-size: 9pt; text-transform: uppercase;">ED Obergutachten</p>

            @if (true /* TODO */)
                <div class="span-12 inline-block margin-b-x4">
                    <div class="span-6">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">ED links:</span>
                            [XXX°/OFEL]
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">ED rechts:</span>
                            [XXX°/OFEL]
                        </p>
                    </div>
                </div>

                <div class="span-12 inline-block margin-b-x4">
                    <div class="span-12 margin-b-x2">
                        <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                    </div>

                    <div class="inline-block lime line-height-100">
                        <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                        <div class="span-10 border-b margin-r">
                            <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                        </div>
                        <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                    </div>

                    <div class="inline-block lime line-height-100">
                        <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                        <div class="span-10 border-b margin-r">
                            <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                        </div>
                        <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                    </div>

                    <div class="span-12 inline-block margin-t-x2">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                            [Anmerkung des Eigentümers zum Thema]
                        </p>
                    </div>
                </div>
            @else
                <p class="copy-bold line-height-100">Kein Gutachten vorhanden.</p>
            @endif

        </div>

        <div class="line">
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Augen-Untersuchung (klinisch)</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>
            <>
                @if (true /* TODO */)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Letzte Augen-Untersuchung (PRA + HC + RD +
                                    [Gonio]) am:</span>
                                [dd.mm.yyyy]
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Keine Augen-Untersuchung vorhanden.</p>
                @endif
            </>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- page 4 -->

    <div class="span-12 margin-b-x4">
        <div class="line">
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Gebiss und Zähne</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>
            <>
                @if (true /* TODO */)
                    <div class="span-12 inline-block margin-b-x2">
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Gebiss-Verhältnis:</span>
                                [Gebiss-Verhältnis]
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Fehlende Zähne:</span>
                                [XX L/R.O/U], [XX L/R.O/U], [XX L/R.O/U] / Alle Zähne vorhanden
                            </p>
                        </div>
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Überzählige Zähne:</span>
                                [XX L/R.O/U], [XX L/R.O/U], [XX L/R.O/U] / Keine überzähligen Zähne
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Keine Gebiss-Untersuchung vorhanden.</p>
                @endif
            </>
        </div>

        <div class="line">
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Gentest</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>
            <>
                @if (true /* TODO */)
                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">PRA-Test:</span>
                                [Frei, über Erbgang frei, Träger, betroffen, ohne Test]
                            </p>
                        </div>
                        <div class="span-12">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">RD-OSD-Test:</span>
                                [Frei, zweifelhaft, vorläufig nicht frei, nicht frei]
                            </p>
                        </div>
                    </div>

                    <div class="span-12 inline-block margin-b-x4">
                        <div class="span-12 margin-b-x2">
                            <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="inline-block lime line-height-100">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                            <div class="span-10 border-b margin-r">
                                <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                            </div>
                            <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                        </div>

                        <div class="span-12 inline-block margin-t-x2">
                            <p class="copy line-height-100 ">
                                <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                                [Anmerkung des Eigentümers zum Thema]
                            </p>
                        </div>
                    </div>
                @else
                    <p class="copy-bold line-height-100">Keine Gentest Ergebnisse vorhanden.</p>
                @endif
            </>
        </div>
    </div>

    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Prüfungen</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line span-12 margin-b-x4">
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wesenstest am:</span>
                    [dd.mm.yy / nicht vorhanden]
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">DRC-Prüfung:</span>
                    [Name der Prüfung / nicht vorhanden]
                </p>
            </div>
            <div class="space-h"></div>
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Formwert:</span>
                    [vorzüglich / sehr gut / gut / nicht vorhanden]
                </p>
            </div>
        </div>

        <div class="line span-12 inline-block margin-b-x4">
            <div class="span-12 margin-b-x2">
                <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
            </div>

            <div class="inline-block lime line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                <div class="span-10 border-b margin-r">
                    <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                </div>
                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
            </div>

            <div class="inline-block lime line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                <div class="span-10 border-b margin-r">
                    <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                </div>
                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
            </div>

            <div class="span-12 inline-block margin-t-x2">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                    [Anmerkung des Eigentümers zum Thema]
                </p>
            </div>
        </div>

        <div class="span-12 margin-b-x4">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Externe Prüfung/en:</span>
                [Name der Prüfung / Keine Prüfung vorhanden]
            </p>
        </div>

        <div class="line span-12 inline-block margin-b-x4">
            <div class="span-12 margin-b-x2">
                <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
            </div>

            <div class="inline-block lime line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                <div class="span-10 border-b margin-r">
                    <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                </div>
                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
            </div>

            <div class="inline-block lime line-height-100">
                <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                <div class="span-10 border-b margin-r">
                    <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                </div>
                <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
            </div>

            <div class="span-12 inline-block margin-t-x2">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                    [Anmerkung des Eigentümers zum Thema]
                </p>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- page 5 -->


    <div class="span-12 margin-b-x4">
        <p class="mg-headline">Titel</p>
        <div class="mg-underline margin-b-x2"></div>

        <div>
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">DRC-Titel</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>

            <div class="line span-12 margin-b-x4">
                <div class="span-12 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">DRC CH-Titel:</span>
                        [Name des DRC-CH-Titels], [Name des DRC-CH-Titels], [Name des DRC-CH-Titels] / [Kein
                        DRC-CH-Titel
                        vorhanden]
                    </p>
                </div>
            </div>

            <div class="line span-12 inline-block margin-b-x4">
                <div class="span-12 margin-b-x2">
                    <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="span-12 inline-block margin-t-x2">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                        [Anmerkung des Eigentümers zum Thema]
                    </p>
                </div>
            </div>

            <div class="line span-12 margin-b-x4">
                <div class="span-12 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Weitere DRC-Titel:</span>
                        [Name des DRC-Titels], [Name des DRC-Titels], [Name des DRC-Titels] / [Kein DRC-Titel
                        vorhanden]
                    </p>
                </div>
            </div>

            <div class="line span-12 inline-block margin-b-x4">
                <div class="span-12 margin-b-x2">
                    <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="span-12 inline-block margin-t-x2">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                        [Anmerkung des Eigentümers zum Thema]
                    </p>
                </div>
            </div>
        </div>

        <div>
            <div class="line margin-b">
                <div class="span-12">
                    <p class="subheadline-bold">Externe Titel</p>
                    <div class="span-12 border-b">
                        <div class="span-12 border-b"></div>
                    </div>
                </div>
            </div>

            <div class="line span-12 margin-b-x4">
                <div class="span-12 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Externe CH-Titel:</span>
                        [Name des externen CH-Titels], [Name des externen CH-Titels] / [Kein
                        externer CH-Titel
                        vorhanden]
                    </p>
                </div>
            </div>

            <div class="line span-12 inline-block margin-b-x4">
                <div class="span-12 margin-b-x2">
                    <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="span-12 inline-block margin-t-x2">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                        [Anmerkung des Eigentümers zum Thema]
                    </p>
                </div>
            </div>

            <div class="line span-12 margin-b-x4">
                <div class="span-12 inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Weitere externe Titel:</span>
                        [Name des externen Titels], [Name des externen Titels] / [Kein externer Titel vorhanden]
                    </p>
                </div>
            </div>

            <div class="line span-12 inline-block">
                <div class="span-12 margin-b-x2">
                    <p class="copy-bold line-height-100">Folgende/s Dokument/e wurde/n hochgeladen:</p>
                </div>

                <div class="inline-block lime line-height-100">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 1]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="inline-block lime line-height-100 margin-b-x2">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                    <div class="span-10 border-b margin-r">
                        <p class="inline-block copy cyan line-height-100 v-align-middle">[Dateiname 2]</p>
                    </div>
                    <p class="inline-block copy cyan line-height-100 v-align-bottom">vom: [dd.mm.yyyy]</p>
                </div>

                <div class="span-12">
                    <p class="copy line-height-100">
                        <span class="line-height-100 copy-bold margin-r">Bemerkung:</span>
                        [Anmerkung des Eigentümers zum Thema]
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="line span-12 margin-b-x4">
        <p class="mg-headline">Weitere Anmerkungen</p>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line margin-b">
            <div class="span-12">
                <p class="copy line-height-100">
                    <span class="line-height-100 copy-bold margin-r">Anmerkung:</span>
                    [Anmerkungen an die Geschäftsstelle, z.B. über die Nachlieferung von Unterlagen]
                </p>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- page 6 -->

    <div class="line span-12 margin-b-x4">
        <p class="mg-headline">Bestätigung des Antragstellers</p>
        <div class="mg-underline margin-b-x2"></div>


        <div class="line">
            <div class="inline-block span-12 red v-align-top">
                <div class="inline-block lime line-height-100 v-align-baseline">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                </div>
                <div class="span-11 inline-block line-height-100">
                    <p class="inline copy-bold cyan line-height-100 v-align-baseline">Hiermit bestätige ich die
                        Richtigkeit
                        der oben
                        gemachten Angaben.</p>
                </div>
                <div class="inline-block span-12 red v-align-top">
                    <div class="inline-block lime line-height-100 v-align-top">
                        <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                    </div>
                    <div class="span-11 inline-block line-height-100">
                        <p class="inline copy-bold cyan line-height-100 v-align-baseline">
                            Hiermit beantrage ich
                            kostenpflichtig
                            die DRC-Zuchtbuch-Übernahme für den oben genannten Retriever.<br>
                            Der Betrag <span class="inline copy cyan line-height-100 v-align-baseline">[XXX,XX
                                €]</span> wird von meinem Konto für Vereinstätigkeit abgebucht.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="line span-12" style="margin-top: 14mm;">
            <div class="span-6">
                <p class="border-b wrap-pre-line copy">[Ort des Antrags], den [dd.mm.yyyy]
                </p>
            </div>
            <div class="space-h"></div>
            <div class="span-6">
                <p class="border-b wrap-pre-line copy">[Vorname des Antragsstellers] [Nachname des Antragsstellers]
                </p>
                <p class="amtstitel">Antragssteller</p>
            </div>
        </div>
    </div>


    <!-- TODO: Loop over multiple co-owner -> add loop (miteigentuemer[]) -->
    <div class="line span-12" style="margin-top: 21mm;">
        <p class="mg-headline">Bestätigung des Miteigentümers</p>
        <div class="mg-underline margin-b-x2"></div>

        @if (false /* TODO -> check if miteigentümer is drc-mitglied */)
            <div class="line">
                <div class="inline-block span-12 red v-align-top">
                    <div class="inline-block lime line-height-100 v-align-baseline">
                        <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                    </div>
                    <div class="span-11 inline-block line-height-100">
                        <p class="inline copy-bold cyan line-height-100 v-align-baseline">Hiermit bestätige ich die
                            Richtigkeit
                            der oben
                            gemachten Angaben.</p>
                    </div>
                </div>

                <div class="inline-block span-12 red v-align-top">
                    <div class="inline-block lime line-height-100 v-align-baseline">
                        <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                    </div>
                    <div class="span-11 inline-block line-height-100">
                        <p class="inline copy-bold cyan line-height-100 v-align-baseline">
                            Hiermit beantrage ich kostenpflichtig die DRC-Zuchtbuch-Übernahme für den oben genannten
                            Retriever.
                        </p>
                    </div>
                </div>
            </div>

            <div class="line span-12" style="margin-top: 14mm;">
                <div class="span-6">
                    <p class="border-b wrap-pre-line copy">[Ort des Antrags], den [dd.mm.yyyy]
                    </p>
                </div>
                <div class="space-h"></div>
                <div class="span-6">
                    <p class="border-b wrap-pre-line copy">[Vorname des Miteigentümers] [Nachname des Miteigentümers]
                    </p>
                    <p class="amtstitel">Miteigentümer</p>
                </div>
            </div>
        @else
            @if (true /* Miteigentümer is in db / Person ist bekannt */)
                <div class="line">
                    <div class="inline-block span-12 red v-align-top">
                        <div class="inline-block lime line-height-100 v-align-baseline">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                        </div>
                        <div class="span-11 inline-block line-height-100">
                            <p class="inline copy-bold cyan line-height-100 v-align-baseline">Hiermit bestätige ich die
                                Richtigkeit
                                der oben
                                gemachten Angaben.</p>
                        </div>
                    </div>

                    <div class="inline-block span-12 red v-align-top">
                        <div class="inline-block lime line-height-100 v-align-baseline">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" checked />
                        </div>
                        <div class="span-11 inline-block line-height-100">
                            <p class="inline copy-bold cyan line-height-100 v-align-baseline">
                                Hiermit bestätige ich die Beantragung der DRC-Zuchtbuch-Übernahme für den oben genannten
                                Retriever.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="line span-12" style="margin-top: 14mm;">
                    <div class="span-6">
                        <p class="border-b wrap-pre-line copy">
                        </p>
                        <p class="amtstitel">Ort, Datum</p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="border-b wrap-pre-line copy">[Vorname des Miteigentümers] [Nachname des Miteigentümers]
                        </p>
                        <p class="amtstitel">Miteigentümer</p>
                    </div>
                </div>


                <div class="line span-12" style="margin-top: 21mm;">
                    <x-rounded-container class="span-12">
                        <p class="copy">
                            Bitte laden Sie das vollständig ausgefüllte und von allen unterschreibene Formular im Portal
                            hoch.
                        </p>
                    </x-rounded-container>
                </div>
            @else
                <div class="line">
                    <div class="inline-block span-12 red v-align-top">
                        <div class="inline-block lime line-height-100 v-align-baseline">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                        </div>
                        <div class="span-11 inline-block line-height-100">
                            <p class="inline copy-bold cyan line-height-100 v-align-baseline">Hiermit bestätige ich die
                                Richtigkeit
                                der oben
                                gemachten Angaben.</p>
                        </div>
                    </div>

                    <div class="inline-block span-12 red v-align-top">
                        <div class="inline-block lime line-height-100 v-align-baseline">
                            <x-checkbox class="inline-block" style="transform: translateY(25%);" />
                        </div>
                        <div class="span-11 inline-block line-height-100">
                            <p class="inline copy-bold cyan line-height-100 v-align-baseline">
                                Hiermit bestätige ich die Beantragung der DRC-Zuchtbuch-Übernahme für den oben genannten
                                Retriever.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="line span-12" style="margin-top: 14mm;">
                    <div class="span-6">
                        <p class="border-b wrap-pre-line copy">
                        </p>
                        <p class="amtstitel">Ort, Datum</p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="border-b wrap-pre-line copy">[Vorname des Miteigentümers] [Nachname des Miteigentümers]
                        </p>
                        <p class="amtstitel">Miteigentümer</p>
                    </div>
                </div>


                <div class="line span-12" style="margin-top: 21mm;">
                    <x-rounded-container class="span-12">
                        <p class="copy">
                            Bitte laden Sie das vollständig ausgefüllte und von allen unterschreibene Formular im Portal
                            hoch.
                        </p>
                    </x-rounded-container>
                </div>
            @endif
        @endif
    </div>