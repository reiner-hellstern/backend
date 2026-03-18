@use('App\Http\Controllers\templates\dokumente\AntragAufZwingerUebernahmeTransferType')
@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Utilities\Math')
@use('App\Models\Zuchtstaette')
@use('App\Models\Dokument')

@php
    $antragsteller_person = RandomDBEntries::RandomPerson([
        'eintrittsdatum' => 'notNull',
        'telefon_1' => 'notEmpty',
        'email_1' => 'notEmpty',
        'zwinger_id' => 'notEmpty',
    ]);
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

    //$mitinhaber_list = [
    //    [$mitinhaber1, 'neuzeuchterseminarSystembekannt' => true, 'abweichenderWohnsitz' => true],
    //    [$mitinhaber2, 'neuzeuchterseminarSystembekannt' => false, 'abweichenderWohnsitz' => false],
    //    [$mitinhaber3, 'neuzeuchterseminarSystembekannt' => true, 'abweichenderWohnsitz' => false],
    //    [$mitinhaber4, 'neuzeuchterseminarSystembekannt' => false, 'abweichenderWohnsitz' => true],
    //];

    $mitinhaber_list = [];

    $upload_zwingerschutz = [
        [
            'dateiname' => 'Datei A',
            'hochgeladen_am' => '01.03.2024',
        ],
    ];

    $upload_abmeldebestaetigung = [
        [
            'dateiname' => 'Abmeldebestätigung_0001252.pdf',
            'hochgeladen_am' => '17.12.2024',
        ],
    ];

    $upload_neuzuechterseminar = [
        [
            'dateiname' => 'Zertifikat_NZS.pdf',
            'hochgeladen_am' => '17.02.2025',
        ],
    ];

    $upload_wohnsitz = [
        [
            'dateiname' => 'WOHNSITZBESCHEID.pdf',
            'hochgeladen_am' => '17.02.2025',
        ],
    ];

    //$zuchtstaette = Zuchtstaette::find(1)->first();

@endphp

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit beantrage ich die Übernahme meines Zwingers in den DRC:
    </p>
</div>

<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Zwinger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line border-b span-12 margin-b padding-b">
        @php
            //$zwinger = $antragsteller_person->zwinger;
            $zwinger = (object) [
                'zwingername' => $antragAufZwingerUebernahme->zwinger->zwingername,
                'fcinummer' => $antragAufZwingerUebernahme->zwinger->fci_zwingernummer,
                'telefon_1' => $antragAufZwingerUebernahme->zwinger->telefon_1,
                'email_1' => $antragAufZwingerUebernahme->zwinger->email_1,
                'website_1' => $antragAufZwingerUebernahme->zwinger->website_1,
            ];
        @endphp
        <x-zwinger-2-cols :zwinger=$zwinger disableDRCZwingernummer disableAdresse disableCO disableOrt disablePLZ
            disableLand />
    </div>
    <div class="line span-12 margin-b-x2">
        <div class="line span-12">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Gezüchtete Rassen:</span>
                {{ $antragAufZwingerUebernahme->zwinger->bisher_gezuechtete_rassen }}
            </p>
        </div>
        <div class="line span-12">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land des bisherigen Zuchtvereins:</span>
                {{ $antragAufZwingerUebernahme->zwinger->land_bisheriger_zuchtverein }}
            </p>
        </div>
        @if ($transferType != AntragAufZwingerUebernahmeTransferType::ForeignToDRC)
            <div class="line span-12">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name des bisherigen Zuchtvereins:</span>
                    {{ $antragAufZwingerUebernahme->zwinger->name_bisheriger_zuchtverein }}
                </p>
            </div>
        @endif
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Zwinger-Unterlagen</span>
    <div class="mg-underline margin-b-x2"></div>
    @if ($antragAufZwingerUebernahme->zwinger_unterlagen->zwingerschutz_document_id)
        <div class="line span-12 margin-b-x2">
            <p class="copy-bold line-height-100">Die Kopie der Zwingerschutzbescheinigung liegt dem System bereits vor.
            </p>
        </div>
    @else
        <div class="line span-12 margin-b-x2">
            <x-verification
                text="Die Kopie meiner bisherigen Zwingerschutzbescheinigung habe ich als Nachweis mit dem Antrag hochgeladen."
                checked />
            @php
                $dokument = Dokument::find(
                    $antragAufZwingerUebernahme->zwinger_unterlagen->zwingerschutz_document_id,
                )->first();
                $uploadedDocuments = [
                    [
                        'dateiname' => $dokument->name,
                        'hochgeladen_am' => $dokument->created_at,
                    ],
                ];
            @endphp
            <x-document-upload :uploadedDocuments=$uploadedDocuments />
        </div>
    @endif

    <div class="line span-12 margin-b-x2">
        <x-verification
            text="Die Kopie meiner Zwinger-Abmeldebestätigung des bisherigen FCI-Zuchtvereins habe ich als Nachweis mit dem Antrag hochgeladen."
            checked />
        @php
            $dokument = Dokument::find(
                $antragAufZwingerUebernahme->zwinger_unterlagen->zwingerabmeldebestaetigung_document_id,
            )->first();
            $uploadedDocuments = [
                [
                    'dateiname' => $dokument->name,
                    'hochgeladen_am' => $dokument->created_at,
                ],
            ];
        @endphp
        <x-document-upload :uploadedDocuments=$uploadedDocuments />
    </div>
</div>


<div class="span-12 margin-b-x4 no-page-break-inside">
    <span class="mg-headline">Zukünftige Zuchtstätte</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        @php
            $zuchtstaette = (object) [
                'adresse' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->adresse,
                //'strasse' => 'test',
                //'hausnummer' => 'test',
                'adresszusatz' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->adresszusatz,
                'postleitzahl' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->postleitzahl,
                'ort' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->ort,
                'telefon' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->telefon_1,
                'email' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->email_1,
                'website' => $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->website_1,
            ];
        @endphp
        @if (
            $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->zsb_datum != null &&
                $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->zsb_zuchtwart != null)
            <x-zuchtstaette-2-cols :zuchtstaette=$zuchtstaette disableTelefonnummer disableEmail disableWebsite />
            <x-verification
                text="Die Zuchtstätte ist freigegeben. Die Zuchtstättenbesichtigung ist am {{ DateFormatter::formatDMY($antragAufZwingerUebernahme->zukuenftige_zuchtstaette->zsb_datum) }} durch den Zuchtwart {{ $antragAufZwingerUebernahme->zukuenftige_zuchtstaette->zsb_zuchtwart }} erfolgt."
                checked />
        @endif

        {{--
        <!-- @if ($zuchtstaette->strasse != $antragsteller_person->strasse || $zuchtstaette->hausnummer != $antragsteller_person->hausnummer || $zuchtstaette->postleitzahl != $antragsteller_person->postleitzahl)
            <x-zuchtstaette-2-cols :zuchtstaette=$zuchtstaette disableTelefonnummer disableEmail disableWebsite />
            <x-verification
                text="Die Zuchtstätte ist freigegeben. Die Zuchtstättenbesichtigung ist am [xx.xx.xxxx] durch den Zuchtwart [Vorname ZW] [Nachname ZW] erfolgt." />
        @else
            <x-zuchtstaette-2-cols :zuchtstaette=$zuchtstaette disableAdresse disableCO disableOrt disablePLZ
                disableTelefonnummer disableEmail disableWebsite />
            <x-verification text="Die zukünftige Zuchtstätte entspricht meinem Wohnsitz." />
        @endif -->
        --}}
    </div>
</div>


<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Antragsteller</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        @php
            $geburtsdatumAsDateTime = DateTime::createFromFormat(
                'd.m.Y',
                $antragAufZwingerUebernahme->antragsteller->person->geboren,
            );
            $additional = [['Alter in Jahren:' => date_diff(now(), $geburtsdatumAsDateTime)->y], []];
        @endphp
        <x-person-2-cols :person="$antragAufZwingerUebernahme->antragsteller->person" enableMitgliedSeit enableGeburtsdatum :additionalFields=$additional />
    </div>

    <div class="line span-12">
        @if ($antragAufZwingerUebernahme->antragsteller->nzs_datum != null)
            <x-verification text="Der Antragsteller hat an einem Neuzüchterseminar teilgenommen." checked />
        @else
            <x-verification
                text="Hiermit bestätige ich, dass ich an einem DRC-Neuzüchterseminar teilgenommen habe bzw. an einem inhaltlich entsprechenden eines VDH-Vereins."
                checked />
            @php
                $dokument = Dokument::find($antragAufZwingerUebernahme->antragsteller->nzs_document_id)->first();
                $uploadedDocuments = [
                    [
                        'dateiname' => $dokument->name,
                        'hochgeladen_am' => $dokument->created_at,
                    ],
                ];
            @endphp
            <x-document-upload :uploadedDocuments=$uploadedDocuments />
        @endif

        @if ($antragAufZwingerUebernahme->antragsteller->zweitwohnsitznachweis_document_id != null)
            <div class="span-12">
                <x-verification
                    text="Die Meldebestätigung  meines  2. Wohnsitzes an der Zuchtstätte habe ich hochgeladen." />
                @php
                    $dokument = Dokument::find(
                        $antragAufZwingerUebernahme->antragsteller->zweitwohnsitznachweis_document_id,
                    )->first();
                    $uploadedDocuments = [
                        [
                            'dateiname' => $dokument->name,
                            'hochgeladen_am' => $dokument->created_at,
                        ],
                    ];
                @endphp
                <x-document-upload :uploadedDocuments=$uploadedDocuments />
            </div>
        @endif
    </div>
</div>

@if (!empty($antragAufZwingerUebernahme->mitinhaber))
    <div class="span-12 margin-t-x4 margin-b-x4 no-page-break-inside">
        <span class="mg-headline">Zwinger-Mitinhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @for ($i = 0; $i < count($antragAufZwingerUebernahme->mitinhaber); $i++)
            <div
                class="line span-12 padding-b-x2 {{ $i + 1 < count($antragAufZwingerUebernahme->mitinhaber) ? 'border-b margin-b-x2' : null }} no-page-break-inside">
                <div class="line span-12 margin-b-x2">
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->vorname }}
                            {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->nachname }}
                        </p>
                        @if ($antragAufZwingerUebernahme->mitinhaber[$i]->zweitwohnsitznachweis_document_id != null)
                            <p class="line-height-100 copy">
                                <span class="line-height-100 copy-bold margin-r">Adresse:</span>
                                {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->strasse }}
                                {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->postleitzahl }}
                                {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->ort }}
                            </p>
                        @endif
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                            {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->mitgliedsnummer }}
                        </p>
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Mitglied seit:</span>
                            {{ DateFormatter::formatDMY($antragAufZwingerUebernahme->mitinhaber[$i]->person->eintrittsdatum) }}
                        </p>
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                            {{ DateFormatter::formatDMY($antragAufZwingerUebernahme->mitinhaber[$i]->person->geboren) }}
                        </p>

                    </div>
                </div>
                <div class="line span-12">
                    <x-verification text="Der Mitinhaber hat an einem Neuzüchterseminar teilgenommen." checked />

                    @if ($antragAufZwingerUebernahme->mitinhaber[$i]->zweitwohnsitznachweis_document_id != null)
                        <x-verification
                            text="Der Mitinhaber hat den Nachweis über seinen Zweitwohnsitz an der Zuchtstätte erbracht."
                            checked />
                        @php
                            $document = Dokument::find(
                                $antragAufZwingerUebernahme->mitinhaber[$i]->zweitwohnsitznachweis_document_id,
                            )->first();
                            $uploadedDocuments = [
                                [
                                    'dateiname' => $document->name,
                                    'hochgeladen_am' => $document->created_at,
                                ],
                            ];
                        @endphp
                        <x-document-upload :uploadedDocuments=$uploadedDocuments />
                    @endif
                </div>
            </div>
        @endfor
    </div>
@endif


<div class="span-12 margin-t-x4 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x3"></div>
    <div class="line">
        @if (!empty(count($antragAufZwingerUebernahme->mitinhaber)))
            <div class="span-12">
                <x-verification text="Hiermit bestätigen wir, die Richtigkeit aller oben gemachten Angaben."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->richtigkeit_aller_angaben" />
            </div>
            <div class="span-12">
                <x-verification text="Hiermit bestätigen wir, dass wir nicht außerhalb der FCI züchten."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->keine_zucht_ausserhalb_fci" />
            </div>
            <div class="span-12">
                <x-verification
                    text="Hiermit beantragen wir die Zwinger-Übernahme in den Deutschen Retriever Club e.V. (DRC). Der Betrag in Höhe [GEBÜHR] €, wird vom Konto des Antragstellers abgebucht."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->keine_zucht_ausserhalb_fci" />
            </div>
        @else
            <div class="span-12">
                <x-verification text="Hiermit bestätige ich, die Richtigkeit aller oben gemachten Angaben."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->richtigkeit_aller_angaben" />
            </div>
            <div class="span-12">
                <x-verification text="Hiermit bestätige ich, dass ich nicht außerhalb der FCI züchte."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->keine_zucht_ausserhalb_fci" />
            </div>
            <div class="span-12">
                <x-verification
                    text="Hiermit beantrage ich die Zwinger-Übernahme in den Deutschen Retriever Club e.V. (DRC). Der Betrag in Höhe [GEBÜHR] €, wird von meinem Konto abgebucht."
                    :checked="$antragAufZwingerUebernahme->bestaetigungen->keine_zucht_ausserhalb_fci" />
            </div>
        @endif
    </div>
</div>


<div class="line span-12 yellow" style="margin: 14mm 0;">
    <div class="span-6">
        @php
            $time_location =
                "{$antragAufZwingerUebernahme->antragsteller->person->ort}, den " . DateFormatter::formatDMY(now());
        @endphp
        <p class="border-b wrap-pre-line copy">{{ $time_location }}
        </p>
    </div>
    <div class="space-h"></div>
    <div class="span-6 inline-block">
        <div class="span-6 margin-b-x2">
            <p class="border-b copy">
                {{ $antragAufZwingerUebernahme->antragsteller->person->vorname }}<!--
                --> {{ $antragAufZwingerUebernahme->antragsteller->person->nachname }}
            </p>
            <p class="amtstitel">Antragsteller</p>
        </div>
    </div>
    <div class="line span-12 text-align-r">
        <div class="span-6 text-align-l">
            @for ($i = 0; $i < count($antragAufZwingerUebernahme->mitinhaber); $i++)
                <div class="span-6 margin-b-x2">
                    <p class="border-b wrap-pre-line copy">
                        {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->vorname }}<!--
                            --> {{ $antragAufZwingerUebernahme->mitinhaber[$i]->person->nachname }}
                    </p>
                    <p class="amtstitel">Mitinhaber</p>
                </div>
            @endfor
        </div>
    </div>
</div>
