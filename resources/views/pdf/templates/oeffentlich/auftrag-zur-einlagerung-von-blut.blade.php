@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models')
@php
    $person = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
    ]);
    $hund = RandomDBEntries::RandomHund(['chipnummer' => 'notEmpty']);

    $mitinhaber1 = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
    ]);
    $mitinhaber2 = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
    ]);
    $mitinhaber3 = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
    ]);
    $mitinhaber4 = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
    ]);

    $mitinhaber_list = [$mitinhaber1, $mitinhaber2, $mitinhaber3, $mitinhaber4, $mitinhaber3, $mitinhaber4];
@endphp
<p class="copy text-align-c border-all v-align-middle"
    style="position: absolute; top: 42.5mm; width: 178mm; border-radius: 1mm;">Bitte
    beachten
    Sie die
    Hinweise
    auf Seite 2.</p>

<div class="span-12">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-6 extended">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $auftragZurEinlagerungVonBlut->hund->name }}
            </p>

            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                {{ $auftragZurEinlagerungVonBlut->hund->rasse }}
            </p>
            <div class="span-2 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                    {{ $auftragZurEinlagerungVonBlut->hund->geschlecht }}
                </p>
            </div>
            <div class="span-3">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                    {{ $auftragZurEinlagerungVonBlut->hund->farbe }}
                </p>
            </div>
            <div class="space-h"></div>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                {{ DateFormatter::formatDMY($auftragZurEinlagerungVonBlut->hund->wurfdatum) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                {{ $auftragZurEinlagerungVonBlut->hund->zuchtbuchnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Chipnummer:</span>
                {{ $auftragZurEinlagerungVonBlut->hund->chipnummer }}
            </p>
        </div>
    </div>
</div>


<div class="span-12 margin-t-x2">
    <span class="mg-headline">Anamnese</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-12 line margin-b-x2 border-b-thick padding-b">
            <div class="span-7 line">
                <div class="span-7 nowrap">
                    <p class="inline-block copy-bold line-height-100 margin-r-x4">
                        Sind bei Ihrem Hund selbst Krampfanfälle aufgetreten?
                    </p>

                    <x-checkbox class="inline-block line-height-100 v-align-middle margin-t" :crossed="$auftragZurEinlagerungVonBlut->anamnese->sind_krampfanfaelle_aufgetreten" />
                    <p class=" inline-block copy line-height-100 margin-t margin-r-x2">ja</p>

                    <x-checkbox class="inline-block line-height-100 v-align-middle margin-t" :crossed="!$auftragZurEinlagerungVonBlut->anamnese->sind_krampfanfaelle_aufgetreten" />
                    <p class="inline-block copy line-height-100 margin-t">nein</p>
                </div>
            </div>
            @if ($auftragZurEinlagerungVonBlut->anamnese->sind_krampfanfaelle_aufgetreten)
                <div class="space-h"></div>
                <div class="span-5">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Alter des ersten Krampfanfalls:</span>
                        {{ $auftragZurEinlagerungVonBlut->anamnese->alter_des_ersten_krampfanfalls }} Monate
                    </p>
                </div>
                <div class="span-12">
                    <div class="span-7">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Ausschlussdiagnostik am:</span>
                            {{ $auftragZurEinlagerungVonBlut->anamnese->die_ausschluss_diagnostik_wurde_durchgefuehrt_am }}
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-5">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Bisher beobachtete Krampfanfälle:</span>
                            {{ $auftragZurEinlagerungVonBlut->anamnese->bisher_beobachtete_krampfanfaelle }}
                        </p>
                    </div>
                </div>
                <div class="span-12">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Tierarzt:</span>
                        {{ $auftragZurEinlagerungVonBlut->anamnese->von_tierarzt }}
                    </p>
                </div>
            @endif
        </div>

        @if (count($auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte) > 0)
            <div class="span-12 line margin-b">
                <p class="copy-bold line-height-100">Folgende/r Verwandte/r sind/ist an Epilepie erkrankt:</p>
            </div>
            @foreach ($auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte as $index => $relativeId)
                <div
                    class="span-12 {{ count($auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte) == 2 && $index == 0 ? 'border-b padding-b margin-b' : '' }}">
                    <div class="span-8">
                        <p class="copy-bold line-height-100">
                            {{ Models\Hund::where('id', '=', $auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte[$index][0])->first()->name }},
                            <span class="copy line-height-100">
                                ZB-Nr.:
                                {{ Models\Hund::where('id', '=', $auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte[$index][0])->first()->zuchtbuchnummer }}
                            </span>
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-4">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Ausschlussdiagnostik am:</span>
                            {{ $auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte[$index][1] }}
                        </p>
                    </div>
                    <div class="span-12">
                        <p class="copy line-height-100 ">
                            <span class="line-height-100 copy-bold margin-r">Tierarzt:</span>
                            {{-- Prof. Dr. Maximilian
                            Mustermann,
                            Musterpraxis im Mustertal
                            Musterstraße 21B, 12345 Mustertal --}}
                            {{ $auftragZurEinlagerungVonBlut->anamnese->erkrankte_verwandte[$index][2] }}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Eigentümer</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line padding-b span-12 margin-b">
        <x-person-2-cols :person="$auftragZurEinlagerungVonBlut->eigentuemer" disableWebsite disableLand />
    </div>
    <div class="span-12 line">
        <div class="span-7">
            <p class="copy-small line-height-100 margin-b-x2">
                Der Eigentümer des Hundes erklärt sich mit seiner Unterschrift einverstanden, dass das eingelagerte
                Blut auf Veranlassung durch den zuständigen DRC-Rassezuchtwart ohne weitere Rücksprache
                ausschließlich
                zu Forschungszwecken verwendet werden darf.
            </p>
        </div>
        <div class="span-5">
            <div class="line">
                <div class="span-5 border-b" style="height: 10mm; right:10mm; position: absolute;">
                </div>
                <div class="span-5" style="right:10mm; position: absolute; transform: translateY(10mm);">
                    <p class="amtstitel text-align-c line-height-100">
                        Unterschrift, {{ $auftragZurEinlagerungVonBlut->eigentuemer->vorname }}
                        {{ $auftragZurEinlagerungVonBlut->eigentuemer->nachname }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


@if (!empty($auftragZurEinlagerungVonBlut->miteigentuemer))
    <div class="span-12 margin-t">
        <span class="mg-headline">Miteigentümer</span>
        <div class="mg-underline margin-b-x2"></div>

        @php
            $mitinhaber_list_chunked = array_chunk($auftragZurEinlagerungVonBlut->miteigentuemer, 2);
        @endphp

        @foreach ($mitinhaber_list_chunked as $row_idx => $row)
            <div class="line no-wrap">
                @foreach ($row as $index => $mitinhaber)
                    <div
                        class="span-6 padding-b {{ $row_idx + 1 < count($mitinhaber_list_chunked) ? 'border-b margin-b' : null }} no-page-break-inside no-wrap">
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

<div class="span-12 margin-t">
    <span class="mg-headline">Tierarzt</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="span-12 line margin-b-x4">
        <div class="span-12">
            <p class="copy-small line-height-100">
                Der Probennehmer muss approbierter Tierarzt sein. Als Probenmaterial werden eine Blutprobe (mind. 1
                ml EDTA-stabilisiertes Vollblut) oder ein Schleimhautabstrich akzeptiert. Die Identität des Tieres
                und die Zugehörigkeit der Probe müssen durch den die Probe nehmenden Tierarzt bestätigt werden.
            </p>
        </div>
        <div class="span-12 line">
            <div class="span-12">
                <x-handwritten-line>Name des Tierarztes:</x-handwritten-line>
                <x-handwritten-line>Praxisanschrift:</x-handwritten-line>
            </div>
        </div>
        <div class="span-12 green">
            <div class="span-9 line blue margin-t-x2">
                <div class="span-2">
                    <p class="copy-bold line-height-100 cyan">
                        Art der Probe:
                    </p>
                </div>
                <div class="span-4 red">
                    <x-checkbox class="inline-block line-height-100" />
                    <p class="inline-block copy line-height-100 v-align-middle">Blutprobe (mind. 1 ml EDTA-Vollblut)
                    </p>
                </div>
                <div class="span-3 lime">
                    <x-checkbox class="inline-block line-height-100 v-align-middle margin-t" />
                    <p class="inline-block copy line-height-100 v-align-middle">Schleimhautabstrich</p>
                </div>
            </div>
            <div class="span-7 orange line">
                <div class="span-5">
                    <div class="padding-r-x2">
                        <x-handwritten-line>Probenbeschriftung:</x-handwritten-line>
                    </div>
                </div>
                <div class="span-2 extended">
                    <x-handwritten-line>Datum:</x-handwritten-line>
                </div>
            </div>
            <p class="copy line-height-100 margin-b">
                <span class="line-height-100 copy-bold margin-r">Bestätigung des Tierarztes:</span>
            </p>
            <div class="span-7">
                <x-checkbox class="inline-block v-align-middle" />
                <p class="inline-block copy">Die Chip-/Täto-Nr. des Hundes wurde anhand der Ahnentafel überprüft</p>
            </div>
            <div class="span-7">
                <x-checkbox class="inline-block v-align-middle" />
                <p class="inline-block copy">Die Identität des Tieres und die Zugehörigkeit der Probe werden
                    bestätigt
                </p>
            </div>
            <div class="span-5">
                <div class="line">
                    <div class="span-5 border-b" style="height: 3.5mm; right:10mm; position: absolute;">
                    </div>
                    <div class="span-5" style="right:10mm; position: absolute; transform: translateY(3.5mm);">
                        <p class="amtstitel text-align-c line-height-100">
                            Unterschrift / Stempel des Tierarztes
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pin-bottom" style="margin-bottom: 13mm; height: 45mm; width: 85mm; padding-left: 10mm; left: 20mm;">
        <p class="copy-small" style="padding-top: 2mm;">Bitte übersenden Sie das vollständig ausgefüllte Formular
            zusammen mit der gekennzeichneten Probe an:</p>
        <div style="position: relative; top: 25%;">
            <p class="line-height-100 sectionheadline-bold">Certagen GmbH</p>
            <p class="line-height-100 ">Marie-Curie-Str. 1</p>
            <p class="line-height-100 ">53359 Rheinbach</p>
            <div class="pin-bottom padding-b-x4">
                <p class="line-height-100 amtstitel">Telefon: 02226-871600 | E-Mail: labor@certagen.de</p>
            </div>
        </div>
    </div>

    <div class="pin-bottom"
        style="margin-bottom: 11.5mm; height: 40mm; width: 72mm; padding-right: 10mm; right: 10mm;">
        <div style="position: relative; top: 0;">
            <p class="line-height-100 copy-small-bold">Wichtige Hinweise</p>
            <p class="line-height-100 copy-small">Bitte geben Sie eine Kopie des vollständig ausgefüllten Formulars dem
                Hundeeigentümer mit.</p>
            <p class="line-height-100 copy-small">Bitte beachten Sie, dass die Bearbeitung der Probe durch CERTAGEN nur
                möglich ist, wenn folgende Kriterien erfüllt sind:</p>
            <div style="list-style: none; padding-left: 2mm;">
                <div class="block copy-small line-height-100" style="text-indent: -1.625mm;">
                    <span class="copy-small line-height-100" style="width: 1.5mm;">&ndash;</span>
                    <span class="copy-small line-height-100" style="width: 69mm;">Bestätigung des Tierartzes über die
                        Übereinstimmung der Chipnummer mit den Angaben auf der Ahnentafel des Hundes</span>
                </div>
                <div class="block copy-small line-height-100" style="text-indent: -1.625mm;">
                    <span class="copy-small line-height-100" style="width: 1.5mm;">&ndash;</span>
                    <span class="copy-small line-height-100" style="width: 69mm;">Bestätigung des Tierarztes über
                        korrekte Verbindung von Hund und Probe</span>
                </div>
                <div class="block copy-small line-height-100" style="text-indent: -1.625mm;">
                    <span class="copy-small line-height-100" style="width: 1.5mm;">&ndash;</span>
                    <span class="copy-small line-height-100" style="width: 69mm;">Eindeutige Kennzeichnung der Probe
                    </span>
                </div>
                <div class="block copy-small line-height-100" style="text-indent: -1.625mm;">
                    <span class="copy-small line-height-100" style="width: 1.5mm;">&ndash;</span>
                    <span class="copy-small line-height-100" style="width: 69mm;">Unterschriften des Probennehmers und
                        des Hundeeigentümers auf diesem Formular sind vorhanden</span>
                </div>
            </div>
        </div>
    </div>
</div>


<hr style="position: absolute; bottom: 105mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 105mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">


<div class="page-break"></div>

<div class="span-12">
    <div class="line">
        <p class="copy-bold">
            1. Hinweis
        </p>
        <p class="copy line-height-100">
            Für die Bezuschussung der Untersuchungskosten zur Ausschlussdiagnostik für Epilepsie ist die Einlagerung
            einer Blutprobe (mind. 1ml EDTA-stabilisiertes Vollblut) oder eines Schleimhautabstriches Ihres Hundes bei
            der
            CERTAGEN GmbH, Marie-Curie-Str. 1, 53359 Rheinbach
            erforderlich. Bitte veranlassen Sie dafür eine entsprechende Probenentnahme durch einen Tierarzt.
            <br>
            <br>
            Für den Fall, dass Sie einen Schleimhautabstrich bevorzugen, können Sie für den Tierarztbesuch ein Set für
            diese Probenentnahme per E-Mail unter info@certagen.de angefordern (für DRC-Mitglieder unter Angabe der
            DRC-Mitgliedsnummer kostenlos).
        </p>
    </div>

    <div class="line margin-t-x3">
        <p class="copy-bold">
            2. Wichtge Hinweise zum Vorgehen
        </p>
        <p class="copy line-height-100">
        <div style="position: relative; top: 0;">
            <div style="padding-left: 7mm;">
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 1.5mm;">1.</span>
                    <span class="copy line-height-100" style="width: 69mm;">SPEICHERN Sie die Maske bitte nach Eingabe
                        aller Informationen.</span>
                </div>
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 1.5mm;">2.</span>
                    <span class="copy line-height-100" style="width: 69mm;">Bitte laden Sie über den Button "DOWNLOAD"
                        das Formular herunter, drucken Sie es aus und unterschreiben Sie die Einverständniserklärung.
                    </span>
                </div>
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 1.5mm;">3.</span>
                    <span class="copy line-height-100" style="width: 69mm;">Nehmen Sie das Formular zusammen mit der
                        Original-Ahnentafel Ihres Hundes mit zum Tierarzt.
                    </span>
                </div>
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 1.5mm;">4.</span>
                    <span class="copy line-height-100" style="width: 69mm;">Ihr Tierarzt entnimmt die Probe, füllt das
                        restliche Formular aus und gibt Ihnen eine Kopie des vollständig ausgefüllten Formulars wieder
                        mit.</span>
                </div>
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 1.5mm;">5.</span>
                    <span class="copy line-height-100" style="width: 69mm;">Bitte scannen Sie diese Kopie ein und
                        laden
                        Sie diese im Rahmen der Antragsstellung auf Bezuschussung der Untersuchungskosten in Ihrem
                        Profil/Meine Hunde bei dem entsprechenden Hund unter "Gesundheit" hoch.</span>
                </div>
                <div class="block copy line-height-100" style="text-indent: -3.375mm;">
                    <span class="copy line-height-100" style="width: 5mm;">6.</span>
                    <span class="copy line-height-100" style="width: 100mm;">Der Tierarzt versendet die
                        entnommene Probe
                        zusammen mit dem vollständig ausgefüllten Formular an die CERTAGEN GmbH, Marie-Curie-Str. 1,
                        53359 Rheinbach.</span>
                </div>
            </div>
        </div>
        </p>
    </div>
</div>
