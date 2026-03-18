@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models')
@php
    $mitinhaber_list = $formData->miteigentuemer;
@endphp

<div class="span-12 margin-b-x2">
    <div class="mg-headline inverted" style="border-radius: 5pt;">Auftrag (wird vom Labor ausgefüllt)
        <div class="span-12 line">
            <div class="span-5 extended padding-l-x2" style="background: white; color: black; border-radius: 2pt;">
                <x-handwritten-line>Eingang:</x-handwritten-line>
            </div>
            <div class="space-h"></div>
            <div class="span-5 extended padding-l-x2 margin-b"
                style="background: white; color: black; border-radius: 2pt;">
                <x-handwritten-line>Auftragsnummer:</x-handwritten-line>
            </div>
        </div>
    </div>
</div>


<hr style="position: absolute; bottom: 105mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 105mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">



{{--<div class="span-12">
    <p class="copy-small line-height-100">
        <span class="copy-small-bold line-height-100">Hinweis</span>
        Für die Erteilung einer Zuchtzulassung und die Erstellung einer Ahnentafel ist ein ISAG 2020 (SNP)-Profil und
        die Einlagerung einer Blutprobe (mind. 1 ml EDTA-stabilisiertes Vollblut) oder eines Schleimhautabstriches Ihres
        Hundes bei der
        CERTAGEN GmbH, Marie-Curie-Str. 1, 53359 Rheinbach
        erforderlich.
        <br>
        Bitte veranlassen Sie dafür eine entsprechende Probenentnahme durch einen Tierarzt. Die Entnahme eines
        Schleimhautabstriches kann auch durch einen DRC-Zuchtwart erfolgen.
        <br>
        Für den Fall, dass Sie einen Schleimhautabstrich bevorzugen, können Sie für die Probenentnahme ein Set per
        E-Mail unter info@certagen.de angefordern (für DRC-Mitglieder unter Angabe der DRC-Mitgliedsnummer kostenlos).
    </p>
    <p class="copy-small line-height-100">
        Rasseabhängig können für die Erteilung einer Zuchtzulassung weitere DNA-Untersuchungen vorgeschrieben sein.
        Informationen über die Gentests, die bei den einzelnen Rassen verpflichtend sind, erhalten Sie in der
        Zuchtordnung für Ihre Rasse.
    </p>
</div>--}}

<div class="span-12">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b"></div>
    <div class="line margin-b">
        <div class="span-6 extended">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $formData->hund->name }}
            </p>

            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                {{ $formData->hund->rasse }}
            </p>
            <div class="span-2 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                    {{ $formData->hund->geschlecht }}
                </p>
            </div>
            <div class="span-3">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                    {{ $formData->hund->farbe }}
                </p>
            </div>
            <div class="space-h"></div>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                {{ DateFormatter::formatDMY($formData->hund->wurfdatum) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                {{ $formData->hund->zuchtbuchnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Chipnummer:</span>
                {{ $formData->hund->chipnummer }}
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Gewünschte Analysen</span>
    <div class="mg-underline margin-b"></div>
    <div class="line margin-b">
        <div class="span-3">
            <x-checkbox class="inline-block v-align-middle"
                :crossed="$formData->gewuenschteAnalysen->isag_2020_snp_profil" />
            <p class="inline-block copy">ISAG 2020 (SNP) Profil</p>
        </div>
        <div class="space-h"></div>

        @if ($formData->hund->rasse_id === 4)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->prcd_pra_gr_pra1_gr_pra2" />
                <p class="inline-block copy">prcd-PRA, GR_PRA1, GR_PRA 2</p>
            </div>
            <div class="span-4">
                <x-checkbox class="inline-block v-align-middle" :crossed="$formData->gewuenschteAnalysen->ncl_5" />
                <p class="inline-block copy">plus*: NCL 5</p>
            </div>
        @elseif ($formData->hund->rasse_id === 5)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->prcd_pra_cnm_eic_hnkp_sd2_stgd" />
                <p class="inline-block copy">prcd-PRA, CNM, EIC, HNKP, SD2, STGD</p>
            </div>
            <div class="span-4">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->haarlaenge_b_e_d_lokus" />
                <p class="inline-block copy">plus*: Haarlänge, B-, E- und D-Lokus</p>
            </div>
        @elseif ($formData->hund->rasse_id === 1)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->prcd_pra_dm2_eic" />
                <p class="inline-block copy">prcd-PRA, DM2, EIC</p>
            </div>
            <div class="span-4">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->haarlaenge_ed_sfs" />
                <p class="inline-block copy">plus*: Haarlänge, ED-SFS</p>
            </div>
        @elseif ($formData->hund->rasse_id === 6)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->prcd_pra_jadd_den_den" />
                <p class="inline-block copy">prcd-PRA, JADD, DEN B-, E- und D-Lokus</p>
            </div>
            <div class="span-4">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->cddy_cp1_clps_dm2_cea_d_lokus" />
                <p class="inline-block copy">plus*: CDDY, CP1, CLPS, DM2, CEA, D-Lokus</p>
            </div>
        @elseif ($formData->hund->rasse_id === 3)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle" :crossed="$formData->gewuenschteAnalysen->b_e_d_lokus" />
                <p class="inline-block copy">Haarlänge, B-, E- und D-Lokus</p>
            </div>
        @elseif ($formData->hund->rasse_id === 2)
            <div class="span-5">
                <x-checkbox class="inline-block v-align-middle"
                    :crossed="$formData->gewuenschteAnalysen->crd4_pra_eic_gsd_3a" />
                <p class="inline-block copy">crd4-PRA (cord1), EIC, GSD IIIa</p>
            </div>
        @endif


        <p class="copy-small">
            * Die Ergebnisse dieser Tests sind laut DRC-Zuchtordnung nicht verpflichtend und werden nicht an den DRC
            e.V. übermittelt.
        </p>
        <div class="span-12">
            <p class="block copy line-height-100">
                <span class="copy-bold line-height-100">Bemerkungen: </span>{{ $formData->bemerkungen }}
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Eigentümer</span>
    <div class="mg-underline margin-b"></div>
    <div class="line padding-b span-12 margin-b">
        <x-person-2-cols :person="$formData->eigentuemer" disableWebsite disableLand />
    </div>
</div>


@if (!empty($mitinhaber_list))
    <div class="span-12">
        <span class="mg-headline">Miteigentümer</span>
        <div class="mg-underline margin-b"></div>

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

<div class="span-12">
    <span class="mg-headline">Erklärung & Bestätigung des Hundeeigentümers</span>
    <div class="mg-underline margin-b"></div>
    <div class="line padding-b span-12">
        <x-verification :checked="$formData->agreements->rabatte"
            text="Um von den Rabatten für den DRC e.V. profitieren zu können, erkläre ich mich mit der Übermittlung der Auftragsdaten und Befundergebnisse an den DRC e.V. mit der Auftragserteilung einverstanden. Es werden nur die Ergebnisse übermittelt, die laut DRC-Zuchtordnung vorgeschrieben sind." />
        <x-verification :checked="$formData->agreements->agb"
            text="Ich erkenne die AGB in der aktuellen Fassung an. Ich bin damit einverstanden, dass CERTAGEN unverzüglich nach Auftragseingang mit der Analyse beginnt und verstehe die Auswirkungen auf einen späteren Widerruf (siehe auch: www.certagen.de/AGB)." />
        <x-verification :checked="$formData->agreements->forschungszwecke"
            text="Mit der Einsendung des Auftrages an CERTAGEN erkläre ich mich einverstanden, dass Proben und Ergebnisse zu Forschungszwecken in anonymisierter Form verwendet werden dürfen. Zudem erkläre ich ich mich einverstanden, dass die erstellten DNA-Genotypen zur Abstammungsüberprüfung genutzt werden dürfen und dass die Ergebnisse, wie oben angegeben, an den DRC e.V. übermittelt werden." />
        <x-verification :checked="$formData->richtigkeitAllerAngaben"
            text="Hiermit bestätige ich die Richtigkeit der Angaben in diesem Formular." />
    </div>
    <div class="span-12" style="padding-top: 1mm;">
        <x-place-date-signature :place="$formData->eigentuemer->ort" :signatureSubline="'Unterschrift, ' . $formData->eigentuemer->vorname . ' ' . $formData->eigentuemer->nachname" />
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Proben-entnahme</span>
    <div class="mg-underline margin-b"></div>
    <div class="line padding-b span-12">
        <div class="span-12 line">
            <p class="copy-bold line-height-100">Wichtiger Hinweis: Bitte geben Sie das vollständig ausgefüllte Formular
                dem
                Hundeeigentümer mit.
            </p>
            <p class="copy line-height-100 margin-b">
                Beachten Sie weitere Hinweise auf Seite 2 unter "Hinweise für Probennehmer".
            </p>
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
    </div>
    <div class="span-12 line">
        <div class="span-4">
            <p class="copy-bold line-height-100 cyan">
                Probe wurde entnommen durch:
            </p>
        </div>
        <div class="span-2 red">
            <x-checkbox class="inline-block line-height-100" />
            <p class="inline-block copy line-height-100 v-align-middle">Tierarzt
            </p>
        </div>
        <div class="span-6 lime">
            <div class="span-3">
                <x-checkbox class="inline-block line-height-100 v-align-middle" />
                <p class="inline-block copy line-height-100 v-align-middle">DRC-Zuchtwart</p>
            </div>
        </div>

        <div class="span-12">
            <div class="span-9">
                <x-handwritten-line>Probenbeschriftung:</x-handwritten-line>
            </div>
            <div class="space-h"></div>
            <div class="span-3">
                <x-handwritten-line>Datum:</x-handwritten-line>
            </div>
        </div>
    </div>
    <p class="copy line-height-100 margin-b">
        <span class="line-height-100 copy-bold margin-r">Erklärungen des Proben-Nehmers:</span>
    </p>
    <div class="span-12">
        <x-checkbox class="inline-block v-align-middle" />
        <p class="inline-block copy">Die Chip-/Täto-Nr. des Hundes wurde anhand der Ahnentafel überprüft</p>
    </div>
    <div class="span-12">
        <x-checkbox class="inline-block v-align-middle" />
        <p class="inline-block copy">Die Identität des Hundes und die Zugehörigkeit der Probe zum o.a. Hund werden
            bestätigt.
        </p>
    </div>
    <div class="span-12 line">
        <div class="span-8">
            <x-handwritten-line>Vor-, Nachname:</x-handwritten-line>
            <x-handwritten-line>Straße, PLZ, Ort:</x-handwritten-line>
        </div>
        <div class="span-4">
            <div class="span-4 border-b" style="height: 13mm; right:10mm; position: absolute;">
            </div>
            <div class="span-4" style="right:10mm; position: absolute; transform: translateY(13mm);">
                <p class="amtstitel text-align-l line-height-100">
                    Unterschrift, Stempel des Proben-Nehmers
                </p>
            </div>
        </div>
    </div>
</div>

<div class="page-break"></div>

<hr style="position: absolute; bottom: 105mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 105mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; left: 0; border: none; border-top: 1px solid #000; width: 8mm;">
<hr style="position: absolute; bottom: 210mm; right: 0; border: none; border-top: 1px solid #000; width: 8mm;">


<div class="span-12">
    <span class="mg-headline">HINWEISE FÜR DEN PROBEN-NEHMER</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="margin-b">
        <ul class="copy line-height-100 padding-l-x3">
            <li>Für die Entnahme einer Blutprobe muss der Probennehmer approbierter Tierarzt sein.</li>
            <li>Die Entnahme eines Schleimhautabstriches kann durch einen Tierarzt oder durch einen DRC-Zuchtwart
                erfolgen.
            </li>
            <li>Dasselbe Probenmaterial darf nicht für mehrere Tiere benutzt werden.</li>
            <li>Die Probenannahme bei CERTAGEN ist Montag bis Freitag besetzt; am Wochende ist sie geschlossen. Die
                Untersuchungsdauer wird ab den Zeitpunkt berechnet, ab dem die Proben und Auftragsunterlagen vollständig
                bei
                CERTAGEN vorliegen.</li>
        </ul>
        <p class="copy-bold">Anforderungen an die Probe</p>
        <ul class="copy line-height-100 padding-l-x3">
            <li>Als Probenmaterial werden eine Blutprobe (mind. 1ml EDTA-stabilisiertes Vollblut) oder ein
                Schleimhautabstrich akzeptiert.</li>
            <li>Die Identität des Tieres und die Zugehörigkeit der Probe müssen durch den Probennehmer bestätigt werden
            </li>
            <li>Alle Proben müssen eindeutig mit der Tier-Identifikation (z.B. Chipnummer) beschriftet sein</li>
        </ul>
        <p class="copy-bold">Schleimhautabstriche</p>
        <div class="span-12 line margin-b-x3">
            <div class="span-4 copy-small text-align-l line-height-100">
                <p class="copy-small-bold line-height-100">
                    Zuvor
                </p>
                <ul class="margin-0 padding-l-x2">
                    <li>Für Schleimhautabstriche stellt CERTAGEN spezielle Tupfer zur Verfügung. Diese müssen durch
                        den
                        Hundebesitzer per E-Mail unter info@certagen.de angefordert werden.</li>
                    <li>Diese Tupfer sind mit speziellen Chemikalien versetzt, die die Probe haltbar machen, so dass
                        die
                        DNA-haltigen Zellen im Labor unbeschadet ankommen.</li>
                    <li>Normale Wattestäbchen (Q-Tips) sind für die Analysen nicht geeignet.</li>
                </ul>
            </div>
            <div class="space-h"></div>
            <div class="span-4 copy-small text-align-l line-height-100">
                <p class="copy-small-bold line-height-100">
                    Abstrich
                </p>
                <ul class="margin-0 padding-l-x2">
                    <li>Dem Tupfer liegt eine Gebrauchsanweisung bei, die zu beachten ist.</li>
                    <li>Es muss mit dem Stäbchen mehrmals am der Innenseite der Wange entlang gestrichen werden, so
                        dass
                        Schleimhautzellen auf den Tupfer gelangen.</li>
                    <li>Eine reine Speichelprobe reicht für die Analysen nicht aus.</li>
                </ul>
            </div>
            <div class="space-h"></div>
            <div class="span-4 copy-small text-align-l line-height-100">
                <p class="copy-small-bold line-height-100">
                    Versand
                </p>
                <ul class="margin-0 padding-l-x2">
                    <li>Achten Sie darauf, dass die Röhrchen richtig und fest verschlossen sind, um ein Auslaufen
                        der Probe zu
                        verhindern.</li>
                    <li>Die Tupfer können dann ungekühlt verschickt werden.</li>
                    <li>Benutzen Sie unbedingt einen gepolsterten Umschlag für den Versand.</li>
                </ul>
            </div>
        </div>
        <!-- <table class="table-full-width">
            <tr>
                <th class="text-align-l border-r line-height-100 margin-0 padding-l-x3">Zuvor</th>
                <th class="text-align-l border-r line-height-100 margin-0 padding-l-x3">Abstrich</th>
                <th class="text-align-l line-height-100 margin-0 padding-l-x3">Versand</th>
            </tr>
            <tr>
                <td class="copy-small text-align-l line-height-100 border-r padding-l-x2">
                    <ul class="margin-0 v-align-top padding-l-x2">
                        <li>Für Schleimhautabstriche stellt CERTAGEN spezielle Tupfer zur Verfügung. Diese müssen durch
                            den
                            Hundebesitzer per E-Mail unter info@certagen.de angefordert werden.</li>
                        <li>Diese Tupfer sind mit speziellen Chemikalien versetzt, die die Probe haltbar machen, so dass
                            die
                            DNA-haltigen Zellen im Labor unbeschadet ankommen.</li>
                        <li>Normale Wattestäbchen (Q-Tips) sind für die Analysen nicht geeignet.</li>
                    </ul>
                </td>
                <td class="copy-small text-align-l line-height-100 border-r padding-l-x2">
                    <ul class="margin-0 v-align-top padding-l-x2">
                        <li>Dem Tupfer liegt eine Gebrauchsanweisung bei, die zu beachten ist.</li>
                        <li>Es muss mit dem Stäbchen mehrmals am der Innenseite der Wange entlang gestrichen werden, so
                            dass
                            Schleimhautzellen auf den Tupfer gelangen.</li>
                        <li>Eine reine Speichelprobe reicht für die Analysen nicht aus.</li>
                    </ul>
                </td>
                <td class="copy-small text-align-l line-height-100 padding-l-x2">
                    <ul class="margin-0 v-align-top padding-l-x2">
                        <li>Achten Sie darauf, dass die Röhrchen richtig und fest verschlossen sind, um ein Auslaufen
                            der Probe zu
                            verhindern.</li>
                        <li>Die Tupfer können dann ungekühlt verschickt werden.</li>
                        <li>Benutzen Sie unbedingt einen gepolsterten Umschlag für den Versand.</li>
                    </ul>
                </td>
            </tr>
        </table> -->
    </div>

    <span class="mg-headline">HINWEISE FÜR DEN HUNDEEIGENTÜMER</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="margin-b-x3 line">
        <div class="span-6">
            <p class="copy-small line-height-100" style="text-align: justify;">
                Für die Erteilung einer Zuchtzulassung und die Erstellung einer Ahnentafel ist ein ISAG 2020
                (SNP)-Profil
                und die Einlagerung einer Blutprobe (mind. 1 ml EDTA stabilisiertes Vollblut) oder eines
                Schleimhautabstriches Ihres Hundes bei der CERTAGEN GmbH, Marie-Curie-Str. 1, 53359 Rheinbach
                erforderlich.
                Bitte veranlassen Sie dafür eine entsprechende Probenentnahme durch einen Tierarzt. Die Entnahme eines
                Schleimhautabstriches kann auch durch einen DRC-Zuchtwart
                erfolgen.
                Für den Fall, dass Sie einen Schleimhautabstrich bevorzugen, können Sie für die Probenentnahme ein Set
                per
                E-Mail unter info@certagen.de angefordern (für DRC-Mitglieder
                unter Angabe der DRC-Mitgliedsnummer kostenlos).
                Hinweis
                Rasseabhängig können für die Erteilung einer Zuchtzulassung weitere DNA-Untersuchungen vorgeschrieben
                sein.
                Informationen über die Gentests, die bei den einzelnen
                Rassen verpflichtend sind, erhalten Sie in der Zuchtordnung für Ihre Rasse.
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <div class="line span-6">
                <div class="span-6 margin-b">
                    <p class="copy-bold line-height-100">WICHTIGER HINWEIS</p>
                </div>
                <p class="sectionheadline-small line-height-100">Bitte gehen Sie folgendermaßen vor</p>

                <div class="span-6">
                    <ol class="span-6 copy-small line-height-100" style="position: relative; left: 4mm;">
                        <li>
                            Nehmen Sie das von Ihnen unterschriebene Formular zusammen mit der Original-Ahnentafel Ihres
                            Hundes mit zum Tierarzt bzw. legen Sie diese zur Probenentnahme dem DRC-Zuchtwart vor (nur
                            Schleimhautabschrich).
                        </li>
                        <li>
                            Ihr Tierarzt bzw. der DRC-Zuchtwart entnimmt die Probe und füllt das restliche Formular aus.
                        </li>
                        <li>
                            Versenden Sie die entnommene Probe zusammen mit dem vollständig ausgefüllten Formular an die
                            CERTAGEN GmbH, Marie Curie-Str. 1, 53359 Rheinbach.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <x-rounded-container>
        <p class="copy line-height-100">
            Mit der Versendung dieses Dokuments an CERTAGEN beauftragen Sie automatisch die hier definierten Gentests.
            Sie erhalten von CERTAGEN eine Vorkassenrechnung und die Ergbnisse der beauftragten Analysen.
            Die Rechnung können Sie per Überweisung oder per Lastschrift begleichen. Das notwendige Formular für die
            Erteilung eines SEPA-Lastschriftmandates an CERTAGEN finden Sie auf der Certagen-Website unter
            www.certagen.com/sepa.pdf
        </p>
    </x-rounded-container>

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
</div>