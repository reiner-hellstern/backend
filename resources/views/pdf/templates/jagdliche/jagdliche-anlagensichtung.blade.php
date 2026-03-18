<x-key-info class="margin-b-x2"
    jsonString='[
  [
    [[{ "Prüfungsort": "{{ $jas->pruefungsort }}" }, { "Sichtungsdatum": "{{ $jas->pruefungsdatum }}" }]],
    [[{ "Hundeführer": "{{ $jas->hundefuehrer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $jas->hund->name }}" }, { "Wurfdatum": "{{ $jas->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $jas->hund->rasse }}" }, { "ZB-Nr.": "{{ $jas->hund->zuchtbuchnummer }}" }]],
    [[{ "Geschlecht": "{{ $jas->hund->geschlecht }}" }, { "Chipnummer": "{{ $jas->hund->chipnummer }}" }]]
  ],
  [
    [[{ "Vater": "{{ $jas->hund->vater->name }}" }, { "ZB-Nr.": "{{ $jas->hund->vater->zuchtbuchnummer }}" }]],
    [[{ "Mutter": "{{ $jas->hund->mutter->name }}" }, { "ZB-Nr.": "{{ $jas->hund->mutter->zuchtbuchnummer }}" }]]
  ]
]
' />

<div class="line">
    <div class="span-12 border-b padding-b">
        <div class="wrap-pre-line">
            <p class="inline line-height-100 copy"><span
                    class="inline line-height-100 copy-bold no-wrap">Ausbildungsstand:
                </span>{{ $jas->ausbildungsstand }}</p>
            <p class="inline line-height-100 copy"><span class="inline line-height-100 copy-bold no-wrap">Art des
                    Zutragens: </span>{{ $jas->art_des_zutragens }}</p>
            <p class="inline line-height-100 copy"><span class="inline line-height-100 copy-bold no-wrap">Standruhe:
                </span>{{ $jas->standruhe }}</p>
        </div>
    </div>
</div>

<div class="line spaced-container padding-t-x2 margin-b">
    <div class="span-12">
        <div class="span-2 extended">
            <p class="copy-bold v-align-top">Aufnahme von Wild:</p>
        </div>
        <div class="span-5 extended">
            <x-checkbox class="inline-block" :crossed="$jas->aufnahme_von_wild->haarnutzwild[0] === 1" />
            <p class="inline-block copy-small-bold margin-r">Haarnutzwild</p>
            <p class="inline-block copy-small">
                {{ implode(', ', array_slice($jas->aufnahme_von_wild->haarnutzwild, 1)) }}</p>
            <div class="block">
                <x-checkbox class="inline-block" :crossed="$jas->aufnahme_von_wild->federwild[0] === 1" />
                <p class="inline-block copy-small-bold margin-r">Federwild</p>
                <p class="inline-block copy-small">
                    {{ implode(', ', array_slice($jas->aufnahme_von_wild->federwild, 1)) }}</p>
            </div>
        </div>
        <div class="span-5">
            <x-checkbox class="inline-block" :crossed="$jas->aufnahme_von_wild->sonstiges_wild[0] === 1" />
            <p class="inline-block copy-small-bold margin-r">Sonstiges Wild</p>
            <p class="inline-block copy-small">
                {{ implode(', ', array_slice($jas->aufnahme_von_wild->sonstiges_wild, 1)) }}</p>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 orange">
        <div class="display-table margin-b-x2">
            <div class="display-table-cell span-7 extended lime">
                <div class="span-7 yellow">
                    <table class="span-7 copy-small-bold">
                        <tr>
                            <th class="border-all copy-bold text-align-l" colspan="2">
                                <p class="line-height-100 v-align-text-top">Prüfungsfach</p>
                            </th>
                        </tr>
                        <tr>
                            <td class="span-2 extended border-rbl text-align-l">Findewille</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->findewille }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Selbstständigkeit</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->selbststaendigkeit }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Nasengebrauch</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->nasengebrauch }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Arbeitsruhe</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->arbeitsruhe }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Führigkeit</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->fuehrigkeit }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Körperliche Härte</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->koerperliche_haerte }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Spurwille</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->spurwille }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Wasserfreude
                            </td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->wasserfreude }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Konzentration</td>
                            <td class="border-rb text-align-l">{{ $jas->pruefungsfaecher->konzentration }}</td>
                        </tr>
                        <tr>
                            <td class="border-rbl text-align-l">Einschätzung d. Entfernung</td>
                            <td class="border-rb text-align-l">
                                {{ $jas->pruefungsfaecher->einschaetzung_der_entfernung }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="display-table-cell v-align-bottom">
                <div class="span-5 green">
                    <p class="copy v-align-bottom line-height-100 wrap-pre-line"><span class="copy-bold">Kommentar:
                        </span>{{ $jas->kommentar }}</p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-2 extended">
            <p class="copy-bold v-align-top">Schussfestigkeit</p>
        </div>
        <div class="right">
            <div class="inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$jas->schussfestigkeit == 0" />
                <p class="inline-block copy-small-bold v-align-bottom">Schußfest</p>
            </div>
            <div class="space-h"></div>
            <div class="inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$jas->schussfestigkeit == 1" />
                <p class="inline-block copy-small-bold v-align-bottom">Leicht Schußempfindlich</p>
            </div>
            <div class="space-h"></div>
            <div class="inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$jas->schussfestigkeit == 2" />
                <p class="inline-block copy-small-bold v-align-bottom">Schußempfindlich</p>
            </div>
            <div class="space-h"></div>
            <div class="inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$jas->schussfestigkeit == 3" />
                <p class="inline-block copy-small-bold v-align-bottom">Stark schußempfindlich</p>
            </div>
            <div class="space-h"></div>
            <div class="inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$jas->schussfestigkeit == 4" />
                <p class="inline-block copy-small-bold v-align-bottom">Schußscheu</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <p class="copy-bold v-align-top">Wesens- und Verhaltensfeststellungen</p>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <p class="sectionheadline-small v-align-top">Temperament:</p>
        </div>
        <div class="span-3 extended cyan">
            <p class="sectionheadline-small v-align-top">Selbstsicherheit:</p>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <p class="sectionheadline-small v-align-top">Verträglichkeit:</p>
        </div>
        <div class="span-2 cyan">
            <p class="sectionheadline-small v-align-top">Sonstiges:</p>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->temperament[0]" />
                <p class="inline-block copy-small-bold">Teilnahms./phlegmat./o. jagdl. Motivation</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle no-wrap">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->selbstsicherheit[0]" />
                <p class="inline-block copy-small-bold">Selbstsicher/deutl. präs./selbstbewußt</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->vertraeglichkeit[0]" />
                <p class="inline-block copy-small-bold">Schußfest</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->sonstiges[0]" />
                <p class="inline-block copy-small-bold">Handscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->temperament[1]" />
                <p class="inline-block copy-small-bold">Ruhig/ausgeglichen</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->selbstsicherheit[1]" />
                <p class="inline-block copy-small-bold">Stabil/sicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->vertraeglichkeit[1]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Menschen</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->sonstiges[1]" />
                <p class="inline-block copy-small-bold">Wildscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->temperament[2]" />
                <p class="inline-block copy-small-bold">Lebhaft/temperamentvoll</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->selbstsicherheit[2]" />
                <p class="inline-block copy-small-bold">Schreckhaft/unsicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->vertraeglichkeit[2]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Artgenossen</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->temperament[3]" />
                <p class="inline-block copy-small-bold">Unruhig/überregt</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$jas->wesens_und_verhaltensfeststellungen->selbstsicherheit[3]" />
                <p class="inline-block copy-small-bold">Ängstlich/stark unsicher</p>
            </div>
        </div>
    </div>
    <div class="span-3 extended cyan">
        <div class="inline-block">
            <x-checkbox class="inline-block v-align-middle" :crossed="$jas->wesens_und_verhaltensfeststellungen->empfehlung_wesenstest" />
            <p class="inline-block copy-bold v-align-baseline">Empfehlung Wesenstest</p>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <p class="block copy line-height-100">
            <span class="copy-bold line-height-100">Körperliche Mängel: </span>{{ $jas->koerperliche_maengel }}
        </p>
        <p class="inline-block copy line-height-100">
            <span class="copy-bold line-height-100">Bemerkungen: </span>{{ $jas->bemerkungen }}
        </p>
    </div>
</div>

<div class="span-12">
    <div class="pin-bottom">
        <x-supervision-list :pruefungsLeiterId="$jas->pruefungsleiter_id" :richterObmannId="$jas->richterobmann_id" :richterIds="json_encode($jas->richter_ids)" />
    </div>
</div>




@if ($jas->abbruch_der_sichtung[0] == true)
    <div class="padding-t-x3 padding-b-x3 border-b">
        <div class="sectionheadline-bold">
            <span>Abbruch der Sichtung.</span>
            <div class="text-box">
                <p class="copy"><span class="copy-bold">Bemerkungen:</span>
                    <span class="underlined">{{ $jas->abbruch_der_sichtung[1] }}</span>
                </p>
            </div>
        </div>
    </div>
@endif
