@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models')
@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);
    $hund = RandomDBEntries::RandomHund(['chipnummer' => 'notEmpty']);


    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber4 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $mitinhaber_list = [
        $mitinhaber1,
        $mitinhaber2,
        $mitinhaber3,
        $mitinhaber4,
        $mitinhaber3,
        $mitinhaber4,
    ];
@endphp

<div class="span-12 margin-b-x4 padding-t padding-b-x2 border-tb">
    <p class="copy line-height-100">
        <span class="copy-bold line-height-100">Hinweis</span>
        <br>
        Aus den Ergebnissen der Formwertbeurteilung liegen bisher zu wenige Daten vor, um statistisch signifikant die
        Erblichkeit von Zahn- und Gebissfehlern untersuchen zu können. Aus diesem Grund möchten die Zuchtkommissionen
        künftig Ergebnisse möglichst vieler im DRC gezüchteter Hunde erhalten. Dazu bitten wir Sie, für Ihren Hund z.B.
        bei der HD-Untersuchung oder bei einem anderen Untersuchungstermin die Angaben zum Zahnstatus vom Tiearzt
        ausfüllen zu lassen.
        <br>
        Der Hund sollte zum Zeitpunkt der Untersuchung älter als ein Jahr sein. Diese Untersuchung ersetzt nicht die
        Beurteilung durch einen Formwertrichter.
    </p>
</div>

<div class="span-12 padding-t-x4 margin-b-x2">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-6 extended">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $hund->name }}
            </p>

            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                {{ $hund->rasse["name_lang"] }}
            </p>
            <div class="span-2 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                    {{ $hund->geschlecht["name"] }}
                </p>
            </div>
            <div class="span-3">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                    {{ $hund->farbe["name"] }}
                </p>
            </div>
            <div class="space-h"></div>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                {{ DateFormatter::formatDMY($hund->wurfdatum) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                {{ $hund->zuchtbuchnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Chipnummer:</span>
                {{ $hund->chipnummer }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Elterntiere</span>
    <div class="mg-underline margin-b"></div>
    <div class="line">
        <div class="span-12">
            <div class="span-12 border-b">
                <p class="copy-bold">Vater</p>
            </div>
            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    [Komplettname des Hundes]
                </p>
            </div>
            <div class="span-4 inline-block">
                <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>[XXX
                    XX000000/00]
                </p>
            </div>
        </div>

        <div class="span-12 margin-b-x2">
            <div class="span-12 border-b">
                <p class="copy-bold">Mutter</p>
            </div>
            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    [Komplettname der Hündin]
                </p>
            </div>
            <div class="span-4 inline-block">
                <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>[XXX
                    XX000000/00]
                </p>
            </div>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x2">
    <span class="mg-headline">Eigentümer</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line padding-b span-12">
        <x-person-2-cols :person=$person disableWebsite disableLand />
    </div>
</div>


@if (!empty($mitinhaber_list))
    <div class="span-12 margin-b-x2">
        <span class="mg-headline">Miteigentümer</span>
        <div class="mg-underline margin-b-x2"></div>

        @php
            $mitinhaber_list_chunked = array_chunk($mitinhaber_list, 2);
        @endphp

        @foreach ($mitinhaber_list_chunked as $row_idx => $row)
            <div class="line no-wrap">
                @foreach ($row as $index => $mitinhaber)
                    <div
                        class="span-6 padding-b {{ $row_idx + 1 < count($mitinhaber_list_chunked) ? "border-b margin-b" : null}} no-page-break-inside no-wrap">
                        <div class="line span-6 no-wrap">
                            <p class="line-height-100 copy no-wrap">
                                {{ $mitinhaber->vorname }}
                                {{ $mitinhaber->nachname }},
                                <span>DRC-MgNr.: </span>{{ $mitinhaber->mitgliedsnummer }}
                            </p>
                        </div>
                    </div>
                    <div class="space-h"></div>
                @endforeach
            </div>
        @endforeach
    </div>
@endif

<div class="span-12 no-page-break-inside">
    <span class="mg-headline">BESTÄTIGUNG</span>
    <div class="mg-underline"></div>
    <div class="line padding-b span-12 margin-b">
        <div class="margin-b-x3">
            <x-verification text="Hiermit bestätige ich die Richtigkeit der Angaben in diesem Formular." />
        </div>

        <div class="line span-12">
            <div class="span-12 border-t margin-b padding-t-x3">
                <p class="copy-bold line-height-100">WICHTIGER HINWEIS</p>
            </div>
            <p class="sectionheadline-small line-height-100">Bitte gehen Sie folgendermaßen vor</p>

            <div class="span-12">
                <ol class="span-12 copy lime" style="position: relative; left: 4mm;">
                    <li>
                        Nehmen Sie das Formular zusammen mit der
                        Original-Ahnentafel Ihres Hundes mit zum Tierarzt.
                    </li>
                    <li>
                        Ihr Tierarzt füllt das restliche Formular
                        aus und gibt es Ihnen vollständig ausgefüllt wieder mit.
                    </li>
                    <li>
                        Bitte laden Sie das vollständig ausgefüllte
                        Formular in Ihrem Profil/Meine Hunde bei dem entsprechenden Hund unter "Gesundheit" hoch.
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="page-break"></div>

<div class="span-12">
    <span class="mg-headline">Gebissverhältnisse</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="inline-block v-align-top">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy no-wrap">Kreuzbiss</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-top">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Rückbiss (UK-Verkürzung)</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-top">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Vorbiss (OK-Verkürzung)</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-top">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Scherenbiss</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-top">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Zangenbiss (alle Incivisi)</p>
        </div>
    </div>
</div>

<div class="span-12">
    <div class="mg-headline">Zähne</div>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12 margin-b-x2">
        {{--
        <img src="{{ public_path('assets/Xmark.svg') }}" alt="">
        --}}
        <table class="span-12">
            <tbody>
                <tr>
                    <td class="copy line-height-100 border-r margin-0 padding-0"></td>
                    <td class="copy line-height-100 border-tr margin-0 padding-0" colspan="8">RECHTS</td>
                    <td class="copy line-height-100 border-tr margin-0 padding-0" colspan="6">OBERKIEFER</td>
                    <td class="copy line-height-100 border-tr margin-0 padding-0" colspan="8">LINKS</td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-trbl margin-0 padding-0">doppelt</td>
                    <td class="copy line-height-100 border-trb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 6mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 3mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 12mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1.5mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 0.5mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 0.5mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1.5mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 12mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 3mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 6mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-trb" style="width: 1.75mm;"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">fehlt</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">entfernt</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">frakturiert</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">schräg</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0"></td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0"></td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">M2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">M1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P4</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P3</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">C</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I3</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">I3</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">C</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P3</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">P4</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">M1</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0">M2</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="margin-0 padding-0" colspan="22">
                        <img style="width: 99%;" src="{{ public_path('assets/gebiss.svg') }}" alt="">
                    </td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-trbl margin-0 padding-0"></td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M3</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P4</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P3</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">C</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I3</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">I3</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">C</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P3</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">P4</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M1</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M2</td>
                    <td class="copy line-height-100 border-trb margin-0 padding-0">M3</td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">doppelt</td>
                    <td class="copy line-height-100 border-rb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 6mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 3mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 12mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1.5mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 0.5mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 0.5mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1.5mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 12mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 3mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 6mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 2mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1.75mm;"></td>
                    <td class="copy line-height-100 border-rb" style="width: 1.75mm;"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">fehlt</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">entfernt</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">frakturiert</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-rbl margin-0 padding-0">schräg</td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                    <td class="copy line-height-100 border-rb"></td>
                </tr>
                <tr>
                    <td class="copy line-height-100 border-r margin-0 padding-0"></td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0" colspan="8">RECHTS</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0" colspan="6">UNTERKIEFER</td>
                    <td class="copy line-height-100 border-rb margin-0 padding-0" colspan="8">LINKS</td>
                </tr>
            </tbody>
        </table>

        <div class="span-12 margin-b-x3">
            <x-handwritten-line>Bemerkung:</x-handwritten-line>
            <x-handwritten-line></x-handwritten-line>
        </div>

    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Tierarzt</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line padding-b span-12 margin-b-x4">
        <div class="span-7 orange line">
            <div class="span-5">
                <div class="padding-r-x2">
                </div>
            </div>
            <div class="span-2 extended">
            </div>
        </div>
        <p class="copy line-height-100 margin-b">
            <span class="line-height-100 copy-bold margin-r">Erklärungen des Proben-Nehmers:</span>
        </p>
        <div class="span-12">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Die Chip-/Täto-Nr. des Hundes wurde anhand der Ahnentafel überprüft
            </p>
        </div>
        <div class="span-12">
            <x-checkbox class="inline-block v-align-middle" />
            <p class="inline-block copy">Die Identität des Hundes wurde überprüft. Die Angaben in diesem Formular
                stimmen mit denen in der Ahnentafel überein.
            </p>
        </div>
        <div class="span-12 line">
            <div class="span-12 margin-t-x2 margin-b-x3">
                <x-handwritten-line>Name des Tierarztes:</x-handwritten-line>
            </div>
            <div class="span-12">
                <x-handwritten-line>Praxisanschrift:</x-handwritten-line>
            </div>
        </div>

        <div class="position-relative" style="height: 40mm;">
            <div class="span-4">
                <div class="span-4" style="position: absolute; transform: translateY(28.75mm);">
                    <x-handwritten-line>Datum:</x-handwritten-line>
                </div>
            </div>
            <div class="space-h"></div>
            <div class="span-4">
                <div class="line">
                    <div class="span-4 border-b" style="height: 35mm; position: absolute;">
                    </div>
                    <div class="span-4" style="position: absolute; transform: translateY(35mm);">
                        <p class="amtstitel text-align-c line-height-100">
                            Unterschrift des Tierartzes
                        </p>
                    </div>
                </div>
            </div>
            <div class="space-h"></div>
            <div class="span-4">
                <div class="line">
                    <div class="span-4 border-b" style="height: 35mm; position: absolute;">
                    </div>
                    <div class="span-4" style="position: absolute; transform: translateY(35mm);">
                        <p class="amtstitel text-align-c line-height-100">
                            Praxis-Stempel
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line margin-t-x4">
        <x-rounded-container>
            <p class="copy-bold">
                Wichtiger Hinweis:
            </p>
            <span class="copy line-height-100" style="width: 69mm;">Bitte geben Sie das vollständig ausgefüllte
                Formular dem Hundeeigentümer mit.
            </span>
        </x-rounded-container>
    </div>
</div>