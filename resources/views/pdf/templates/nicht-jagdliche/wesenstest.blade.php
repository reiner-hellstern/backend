<!-- #region Page 1 -->

<x-key-info class="margin-b-x3"
    jsonString='[
  [
    [[{ "Beurteilungsort": "{{ $wesenstest->beurteilungsort }}" }, { "Beurteilungsdatum": "{{ $wesenstest->beurteilungsdatum }}" }]],
    [[{ "Hundeeigentümer": "{{ $wesenstest->hundeeigentuemer }}" }, { "Startnummer": "{{ $wesenstest->startnummer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $wesenstest->hund->name }}" }, { "Wurfdatum": "{{ $wesenstest->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $wesenstest->hund->rasse }}" }, { "ZB-Nr.": "{{ $wesenstest->hund->zuchtbuchnummer }}" }]],
    [[{ "Farbe": "{{ $wesenstest->hund->farbe }}" }, { "Chipnummer": "{{ $wesenstest->hund->chipnummer }}" }]]
  ]
]
' />

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Angaben des Hundeführeres</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line span-12">
        <div class="span-4 inline-block">
            <div class="span-4 inline-block border-b">
                <p class="line-height-100 copy-bold">Haltung des Hundes</p>
            </div>

            <div class="span-4">
                <div class="text-align-r">
                    <div class="span-1 extended red text-align-c">
                        <span class="copy-small">Ja</span>
                        <div class="space-h"></div>
                        <span class="copy-small">Nein</span>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span
                            class="copy-small-bold line-height-100 v-align-text-top">{{ 'Hauptbezugsperson für den Hund' }}</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[0] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[0] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Besitzerwechsel</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[1] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[1] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Haltung Zwinger</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[2] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[2] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Haltung Haus</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[3] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->haltung_des_hundes[3] == 1 }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-h"></div>

        <div class="span-8 inline-block">
            <div class="span-8 inline-block border-b">
                <p class="line-height-100 copy-bold">Körperliche Verfassung des Hundes</p>
            </div>

            <div class="span-4">
                <div class="text-align-r">
                    <div class="span-1 extended red text-align-c">
                        <span class="copy-small">Ja</span>
                        <div class="space-h"></div>
                        <span class="copy-small">Nein</span>
                    </div>
                </div>


                <div class="line span-8">
                    <div class="span-4 yellow">
                        <div class="span-3">
                            <span class="copy-small-bold line-height-100 v-align-text-top">Chronische
                                Erkrankungen</span>
                        </div>
                        <div class="span-1 extended cyan text-align-c">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[0] == 0 }}" />
                            <div class="space-h"></div>
                            <div class="inline-block">
                                <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                    crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[0] == 1 }}" />
                            </div>
                        </div>
                    </div>

                    <div class="span-4">
                        <span
                            class="copy-small line-height-100 v-align-text-top">{{ $wesenstest->angaben_des_hundefuehrers->chronische_erkrankungen_text ?? '' }}</span>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Unfälle</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[1] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[1] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="line span-8">
                    <div class="span-4 yellow">
                        <div class="span-3">
                            <span class="copy-small-bold line-height-100 v-align-text-top">Einsatz von
                                Medikamenten</span>
                        </div>
                        <div class="span-1 extended cyan text-align-c">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[2] == 0 }}" />
                            <div class="space-h"></div>
                            <div class="inline-block">
                                <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                    crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[2] == 1 }}" />
                            </div>
                        </div>
                    </div>

                    <div class="span-4">
                        <span
                            class="copy-small line-height-100 v-align-text-top">{{ $wesenstest->angaben_des_hundefuehrers->einsatz_von_medikamenten_text ?? '' }}</span>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Kastration chemisch</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[3] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[3] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Kastration chirurgisch</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[4] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[4] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Futtermittelallergie</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[5] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->koerperliche_verfassung_des_hundes[5] == 1 }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="line span-12">
        <div class="span-4 inline-block">
            <div class="span-4 inline-block border-b">
                <p class="line-height-100 copy-bold">Ausbildung</p>
            </div>

            <div class="span-4">
                <div class="text-align-r">
                    <div class="span-1 extended red text-align-c">
                        <span class="copy-small">Ja</span>
                        <div class="space-h"></div>
                        <span class="copy-small">Nein</span>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Welpengruppe</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->ausbildung[0] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->ausbildung[0] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <div class="span-3">
                        <span class="copy-small-bold line-height-100 v-align-text-top">Prüfungen</span>
                    </div>
                    <div class="span-1 extended cyan text-align-c">
                        <x-checkbox class="inline-block margin-t-x2 text-align-l"
                            crossed="{{ $wesenstest->angaben_des_hundefuehrers->ausbildung[1] == 0 }}" />
                        <div class="space-h"></div>
                        <div class="inline-block">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->ausbildung[1] == 1 }}" />
                        </div>
                    </div>
                </div>

                <div class="span-4 lime">
                    <span class="copy-small line-height-100 v-align-text-top">
                        {{ $wesenstest->angaben_des_hundefuehrers->ausbildung[2] ?? '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="space-h"></div>

        <div class="span-4 inline-block">
            <div class="span-4 inline-block border-b">
                <p class="line-height-100 copy-bold">Einsatz zur Arbeit / Sport</p>
            </div>

            <div class="span-4">
                <div class="text-align-r">
                    <div class="span-1 extended red text-align-c">
                        <span class="copy-small">Ja</span>
                        <div class="space-h"></div>
                        <span class="copy-small">Nein</span>
                    </div>
                </div>

                <div class="span-4">
                    <div class="text-align-r">
                        <div class="span-1 extended cyan text-align-c">
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[0] == 0 }}" />
                            <div class="space-h"></div>
                            <div class="inline-block">
                                <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                    crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[0] == 1 }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="span-4 yellow">
                    <x-checkbox class="inline-block margin-t-x2"
                        crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[1] == 0 }}" />
                    <span class="copy-small-bold line-height-100 v-align-text-top">Breitensport</span>
                </div>

                <div class="span-4 yellow">
                    <x-checkbox class="inline-block margin-t-x2"
                        crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[2] == 0 }}" />
                    <span class="copy-small-bold line-height-100 v-align-text-top">Dummyarbeit</span>
                </div>

                <div class="span-4 yellow">
                    <x-checkbox class="inline-block margin-t-x2"
                        crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[3] == 0 }}" />
                    <span class="copy-small-bold line-height-100 v-align-text-top">Jagd</span>
                </div>

                <div class="span-4 yellow">
                    <x-checkbox class="inline-block margin-t-x2"
                        crossed="{{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[4] == 0 }}" />
                    <span class="copy-small-bold line-height-100 v-align-text-top">Rettungshund</span>
                </div>

                <div class="span-4 yellow">
                    <span class="copy-small line-height-100 v-align-text-top">
                        {{ $wesenstest->angaben_des_hundefuehrers->einsatz_zur_arbeit_sport[5] ?? '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="space-h"></div>

        <div class="span-4 inline-block">
            <div class="span-4 inline-block border-b">
                <p class="line-height-100 copy-bold">Umwelterfahrungen</p>
            </div>

            <div class="span-4 lime">
                <div class="text-align-r">
                    <div class="span-1 red text-align-c">
                        <div class="inline-block span-1 blue">
                            <p class="copy-small">Wenig</p>
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->umwelterfahrungen[0] == 0 }}" />
                        </div>
                    </div>
                    <div class="span-1 red text-align-c">
                        <div class="inline-block span-1 blue">
                            <p class="copy-small">Viel</p>
                            <x-checkbox class="inline-block margin-t-x2 text-align-l"
                                crossed="{{ $wesenstest->angaben_des_hundefuehrers->umwelterfahrungen[0] == 1 }}" />
                        </div>
                    </div>
                </div>
            </div>

            @if ($wesenstest->angaben_des_hundefuehrers->umwelterfahrungen[1] != null)
                <div class="span-4 yellow">
                    <p class="copy-small-bold line-height-100 v-align-text-top">
                        Besondere tiefgreifende Erlebnisse,
                        die den Hund nachhaltig beeindruckt haben:
                    </p>
                    <div class="span-4">
                        <p class="copy-small line-height-100 v-align-text-top">
                            {{ $wesenstest->angaben_des_hundefuehrers->umwelterfahrungen[1] }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


<div class="span-12 margin-b-x2">
    <span class="mg-headline">Verhaltensbeurteilung</span>
    <div class="mg-underline margin-b-x4"></div>

    <div class="line padding-b-x2">
        <div class="span-12">
            <table class="span-12 margin-b-x3">
                <tr>
                    <th class="span-4 copy-bold border-all text-align-l line-height-100">I. Kontakt mit
                        Personen
                    </th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Sozialverhalten</th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">
                        Beschwichtigungs-<br>verhalten
                    </th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Aggressionsverhalten
                    </th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Aktivität</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">1a. Befragung & Kontakt
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->befragung_kontakt[3] }}</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">1b. Identifizierung
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->identifizierung[0] }}</td>
                    <td class="copy-small-bold border-rb line-height-10">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->identifizierung[1] }}</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->identifizierung[3] }}</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        <div class="v-align-top line-height-100">
                            2.
                            <p class="inline-block v-align-top line-height-100">
                                Verhalten beim Spaziergang<br>
                                mit dem Hundeführer
                            </p>
                        </div>
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_beim_spaziergang[0] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_beim_spaziergang[1] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_beim_spaziergang[2] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        <div class="v-align-top line-height-100">
                            3.
                            <p class="inline-block v-align-top line-height-100">
                                Verhalten in einer Menschengruppe<br>
                                von 6 Personen
                            </p>
                        </div>
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_in_menschengruppe[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">4. Verhalten bei Berührung
                        durch Fremde
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung[0] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung[1] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung[2] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        <p class="padding-l-x2 line-height-100">
                            4a. Frauen
                        </p>
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung_frauen[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        <p class="padding-l-x2 line-height-100">
                            4b. Männer
                        </p>
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->kontakt_mit_personen->verhalten_bei_beruehrung_maenner[3] }}
                    </td>
                </tr>
            </table>

            <table class="span-12">
                <tr>
                    <th class="span-4 copy-bold border-all text-align-l line-height-100 lime">II. Spiel mit
                        Vorführer
                    </th>

                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">Spielverhalten</th>
                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">Beuteverhalten</th>
                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">Tragen/<br>Zutragen
                    </th>
                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">Suchverhalten</th>
                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">
                        Beschwichti-<br>gungs-<br>verhalten</th>
                    </th>
                    <th class="copy-small-bold border-trb line-height-100" style="width: 100%;">
                        Aggressions-<br>verhalten</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        1. ohne Gegenstand
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->ohne_gegenstand[1] }}</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->ohne_gegenstand[2] }}</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->ohne_gegenstand[3] }}</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        2. mit Gegenstand
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->mit_gegenstand[2] }}</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->mit_gegenstand[3] }}</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->mit_gegenstand[4] }}</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        3a. Gegenstand werfen in geringe Deckung
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_geringe_deckung[0] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_geringe_deckung[3] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_geringe_deckung[4] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_geringe_deckung[5] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">
                        3b. Gegenstand werfen in hohe Deckung
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_hohe_deckung[0] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_hohe_deckung[4] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->spiel_mit_vorfuehrer->gegenstand_werfen_in_hohe_deckung[5] }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="page-break"></div>

<!-- #endregion Page 1 -->

<!-- #region Page 2 -->

<x-key-info class="margin-b-x3"
    jsonString='[
  [
    [[{ "Beurteilungsort": "{{ $wesenstest->beurteilungsort }}" }, { "Beurteilungsdatum": "{{ $wesenstest->beurteilungsdatum }}" }]],
    [[{ "Hundeeigentümer": "{{ $wesenstest->hundeeigentuemer }}" }, { "Startnummer": "{{ $wesenstest->startnummer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $wesenstest->hund->name }}" }, { "Wurfdatum": "{{ $wesenstest->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $wesenstest->hund->rasse }}" }, { "ZB-Nr.": "{{ $wesenstest->hund->zuchtbuchnummer }}" }]],
    [[{ "Farbe": "{{ $wesenstest->hund->farbe }}" }, { "Chipnummer": "{{ $wesenstest->hund->chipnummer }}" }]]
  ]
]
' />

<div class="span-12 margin-b-x2">
    <div class="line padding-b-x2">
        <div class="span-12">
            <table class="span-12 margin-b-x3">
                <tr>
                    <th class="span-4 copy-bold border-all text-align-l line-height-100">III. Parcour
                    </th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Schreckhaftigkeit</th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">
                        Beschwichtigungs-<br>verhalten</th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Neugierverhalten
                    </th>
                    <th class="span-2 copy-small-bold border-trb text-align-c line-height-100">Aktivität</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Allgemein
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->allgemein[0] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->allgemein[1] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->allgemein[2] }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Haptisch 1</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->haptisch_1[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Akustisch 1</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->akustisch_1[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Optisch 1</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->optisch_1[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Haptisch 2</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->haptisch_2[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Akustisch 2</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->akustisch_2[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Optisch 2</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->optisch_2[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Haptisch 3</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->haptisch_3[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Akustisch 3</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->akustisch_3[3] }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Optisch 3</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $wesenstest->verhaltensbeurteilung->parcour->optisch_3[3] }}
                    </td>
                </tr>
            </table>

            <table class="span-12 margin-b-x3">
                <tr>
                    <th class="span-4 copy-bold border-all text-align-l line-height-100">IV. Schuss
                    </th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">Schreckhaftigkeit beim Schuss
                    </th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">100m
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">50m
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">20m
                    </td>
                    <td class="copy-small-bold border-rb line-height-100 wt-grey">0</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Netzdiagramm</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="span-12 text-align-c">
        <img class="inline-block" src="{{ public_path('/assets/Netzdiagramm.png') }}" style="height: 11cm;" />
    </div>
</div>

<div class="page-break"></div>

<!-- #endregion Page 2 -->

<!-- #region Page 3 -->

<x-key-info class="margin-b-x3"
    jsonString='[
  [
    [[{ "Beurteilungsort": "{{ $wesenstest->beurteilungsort }}" }, { "Beurteilungsdatum": "{{ $wesenstest->beurteilungsdatum }}" }]],
    [[{ "Hundeeigentümer": "{{ $wesenstest->hundeeigentuemer }}" }, { "Startnummer": "{{ $wesenstest->startnummer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $wesenstest->hund->name }}" }, { "Wurfdatum": "{{ $wesenstest->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $wesenstest->hund->rasse }}" }, { "ZB-Nr.": "{{ $wesenstest->hund->zuchtbuchnummer }}" }]],
    [[{ "Farbe": "{{ $wesenstest->hund->farbe }}" }, { "Chipnummer": "{{ $wesenstest->hund->chipnummer }}" }]]
  ]
]
' />

<div class="span-12 margin-b-x2" style="margin-top: 42mm;">
    <span class="mg-headline">Allgemein</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line span-12 margin-b-x2">
        <p class="inline-block copy-bold line-height-100">Weitere Bemerkungen:</p>
        <p class="border-b copy line-height-100">{{ $wesenstest->allgemein->weitere_bemerkungen }}</p>
    </div>

    <div class="line span-12 margin-b-x2">
        <p class="inline-block copy-bold line-height-100">Zusammenfassende kurze Beschreibung des Hundes und der
            Motivation:</p>
        <p class="border-b copy line-height-100">
            {{ $wesenstest->allgemein->zusammenfassende_kurze_beschreibung_des_hundes_und_der_motivation }}</p>
    </div>
</div>


<div class="pin-bottom border-t">
    <div class="span-12 spaced-container margin-b-x4">
        @if ($wesenstest->richter->bestanden === 0)
            <p class="sectionheadline-bold">Prüfung bestanden.</p>
        @elseif ($wesenstest->richter->bestanden === 1)
            <p class="sectionheadline-bold">Prüfung nicht bestanden.</p>
            <x-labeled-info labelText="Begründung" infoText="{{ $wesenstest->richter->infoText }}" />
        @else
            <p class="sectionheadline-bold">Zurückgestellt.</p>
            <x-labeled-info labelText="Begründung" infoText="{{ $wesenstest->richter->infoText }}" />
        @endif
    </div>

    <div class="span-12 padding-t-x4 padding-b-x4">
        <div class="span-6 left">
            <p class="border-b">{{ $wesenstest->beurteilungsort }}, den {{ $wesenstest->beurteilungsdatum }}</p>
            <br>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">
            </p>
            <p class="amtstitel">Unterschrift {{ $wesenstest->richter->vorname }}
                {{ $wesenstest->richter->nachname }}</p>
        </div>
    </div>
</div>

<div class="page-break"></div>

<!-- #endregion Page 3 -->

<!-- #region Page 4 -->
<div class="span-12 margin-b-x2">

    <div class="line padding-b-x2">
        <div class="span-12 wt-table">
            <div class="span-6">
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Aggressionsverhalten – Code für Test I.1a, I.1b, I.3, I.4, II.1, II.2</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">keine Signale des
                            Aggressionsverhalten</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Optisches
                            Drohverhalten und/oder akustisches Drohverhalten mit Rückzugstendenzen</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Wie 2 ohne
                            Rückzugstendenzen</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Wie 3 mit
                            Intentionsbewegung in Richtung Gegner</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Beißbewegungen
                            mit
                            unvollständiger oder vollständiger Annäherung
                        </td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Beschwichtigungsverhalten – Code für Test I.1a, I.3, I.4, II.1, III.</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Keine Signale der
                            Beschwichtigung</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Leichte
                            Ausprägung
                            von Signalen der Beschwichtigung,
                            kein Meiden des/der Menschen </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Stärkere
                            Ausprägung von Signalen der Beschwichtigung,
                            Meiden des/der Menschen oder des Objektes oder weicht zurück
                            und nähert sich vorsichtig an, erholt sich von alleine</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Keine Annäherung,
                            benötigt für Bewältigung des Reizes
                            deutliche Hilfe des Hundeführers</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Erstarrt, presst
                            sich auf Boden oder flüchtet, kehrt nicht
                            aus eigenem Antrieb zurück, auch deutliche Hilfen führen
                            nicht zur Erfüllung des Codes 4</td>
                    </tr>
                </table>
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Neugierverhalten – Code für Test III.</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">
                            Neutral/neugierig/kurz aufmerksam/sucht</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Geringe
                            Ausprägung
                            einer Schreckreaktion (z. B. Wegspringen,
                            Zusammenzucken, Ausweichen), erholt sich sofort wieder</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Deutliche
                            Ausprägung einer Schreckreaktion, erholt sich von allein</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Wie 3, braucht
                            zum
                            Erholen deutliche Hilfe des Hundeführers</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Hund flieht,
                            stellt dabei eine größere Distanz her, kehrt nicht
                            aus eigenem Antrieb zurück oder Hund erstarrt, auch deutliche Hilfen des
                            Hundeführers führen nicht zur Erfüllung von Code 4</td>
                    </tr>
                </table>
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Schreckhaftigkeit – Code für Test III.</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">
                            Neutral/neugierig/kurz aufmerksam/sucht</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Geringe
                            Ausprägung
                            einer Schreckreaktion (z. B. Wegspringen,
                            Zusammenzucken, Ausweichen), erholt sich sofort wieder</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Deutliche
                            Ausprägung einer Schreckreaktion, erholt sich von allein</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Wie 3, braucht
                            zum
                            Erholen deutliche Hilfe des Hundeführers</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Hund flieht,
                            stellt dabei eine größere Distanz her, kehrt nicht
                            aus eigenem Antrieb zurück oder Hund erstarrt, auch deutliche Hilfen des
                            Hundeführers führen nicht zur Erfüllung von Code 4</td>
                    </tr>
                </table>
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Spielverhalten – Code für Test II.1, II.2</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht Nähe zum
                            Hundeführer</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Neutral / kein
                            Kontakt</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Nähert sich unter
                            leichtem Zögern </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Nähert sich ohne
                            Zögern, stellt Körperkontakt her</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Rennt mit hoher
                            Geschwindigkeit auf den Menschen zu, springt oder rempelt diesen an</td>
                    </tr>
                </table>
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Tragen/Zutragen – Code für Test II.3a, II.3b</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Kein Tragen des
                            Objektes</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Kurzes Tragen des
                            Objektes, kein Zutragen</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Längeres Tragen,
                            kein Zutragen, oder kein direktes Zutragen</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Direktes Zutragen
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Direktes Zutragen
                            mit hoher Intensität</td>
                    </tr>
                </table>

            </div>

            <div class="space-h"></div>

            <div class="span-6">
                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Aktivität
                            – Code für Test I.2, III.</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Geht im langsamen
                            Tempo nah beim Hundeführer </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Geht langsam,
                            löst
                            sich hin und wieder vom Hundeführer</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Trabt viel, löst
                            sich vom Hundeführer auf kurze Distanz (ca. 20 Meter) </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Tempowechsel
                            inklusive Galopp, Distanz über 20 Meter </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Überwiegend
                            Galopp
                            in großen Teilen des Geländes und/oder hohe
                            Bewegungsintensität in der Nähe des Hundeführers</td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Beuteverhalten – Code für Test II.2, II.3a, II.3b</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Läuft der Beute
                            nicht oder nur einige Schritte hinterher</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Läuft der Beute
                            hinterher, stoppt vor Erreichen der Beute ab</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Läuft der Beute
                            hinterher, nimmt die Beute kurzfristig auf</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Läuft der Beute
                            schnell hinterher, nimmt gezielt auf und behält die Beute</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Läuft der Beute
                            schnell mit hoher Intensität hinterher,
                            nimmt gezielt auf und behält die Beute5</td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Sozialverhalten – Code für Test I.1a, I.3, I.4</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Spielt nicht</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Spielt kurz (< 5
                                Sekunden)</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Spielt längere
                            Zeit mit erkennbarem Bewegungsluxus</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Spielt längere
                            Zeit mit deutlich erkennbarem Bewegungsluxus
                            und hoher Intensität </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Spielt
                            ausgesprochen körperbetont</td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Schreckhaftigkeit beim Schuss - Code für Test IV.</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">
                            Neutral/neugierig/kurz aufmerksam/sucht</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Geringe
                            Ausprägung
                            einer Schreckreaktion (z. B. Wegspringen,
                            Zusammenzucken, Ausweichen) erholt sich sofort wieder</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Deutliche
                            Ausprägung einer Schreckreaktion, erholt sich innerhalb einer Minute von alleine</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Wie 3, braucht
                            zum
                            Erholen mehr als eine Minute und deutliche Hilfe des HF</td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="span-6 copy-small-bold border-trb text-align-l line-height-100" colspan="2">
                            Suchverhalten – Code für Test II.3a, II.3b</th>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">1</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht nicht</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">2</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht kurz</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht, nimmt
                            dabei
                            immer wieder Sichtkontakt zum Hundeführer auf
                            und/oder lässt sich durch Umweltreize immer wieder kurz ablenken</td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">4</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht konstant,
                            wenig ablenkbar, keine hohe Körperspannung </td>
                    </tr>
                    <tr>
                        <td class="copy-small-bold border-rb line-height-100">5</td>
                        <td class="span-5 extended copy-small border-rb line-height-100 text-align-l">Sucht konstant,
                            nicht ablenkbar, hohe Geschwindigkeit und/oder
                            hohe Intensität (hohe Körperspannung und/oder hohe Aktivität der Rute)</td>
                    </tr>
                </table>

                <table class="span-6 margin-b-x3 border-l">
                    <tr>
                        <th class="copy-bold border-tr text-align-l line-height-100">
                            Das Auftreten folgender Codes führt zum Nichtbestehen
                            für alle Retriever-Rassen:
                        </th>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">Aggressionsverhalten:</p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 5: 1-maliges Auftreten,
                            </p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 4: 2-maliges Auftreten, Code 3: 3-maliges Auftreten
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">Schreckhaftigkeit beim Schuss:</p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 5: 1-maliges Auftreten, Code 4: 1-maliges Auftreten
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">
                                Beschwichtungsverhalten gegenüber Menschen:
                            </p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 5: 1-maliges Auftreten, Code 4: 3-maliges Auftreten
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">
                                Beschwichtigungsverhalten gegenüber der unbelebten Umwelt:
                            </p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 5: 1-maliges Auftreten, Code 4: 3-maliges Auftreten
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">
                                Schreckhaftigkeit gegenüber der unbelebten Umwelt:
                            </p>
                            <p class="copy-small line-height-100 text-align-l">
                                Code 5: 1-maliges Auftreten, Code 4: 3-maliges Auftreten
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-r line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">
                                Tragen/Zutragen: <span class="copy-small line-height-100 text-align-l">
                                    Code 1: 2-maliges Auftreten
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="copy-small border-rb line-height-100 text-align-l">
                            <p class="copy-small-bold line-height-100 text-align-l">
                                Richter oder Hundeführer hat Wesenstest abgebrochen.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- #endregion Page 4 -->
