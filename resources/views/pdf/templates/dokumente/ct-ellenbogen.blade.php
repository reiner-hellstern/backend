<!-- #region Page 1 -->
<div class="span-12 margin-b-x4 padding-b-x2 border-b">
    <div class="span-12 margin-b-x2">
        <p class="mg-headline inverted">Hundeeigentümer</p>
    </div>

    <div class="span-12">
        <div class="span-12 border-b margin-b-x2">
            <p class="subheadline">IHR WEG ZUR ED-VERIFIZIERUNG BZW. AUSSCHLUSSDIAGNOSTIK</p>
        </div>

        <div class="span-12">
            <span class="copy-bold line-height-100 margin-r inline-block">1.</span>
            <div class="span-11 inline-block">
                <p class="copy line-height-100">
                    Bitte drucken Sie das Formular aus und füllen es unterhalb
                    dieses Hinweistextes komplett aus.
                </p>
            </div>
        </div>

        <div class="span-12">
            <span class="copy-bold line-height-100 margin-r inline-block">2.</span>
            <div class="span-11 inline-block">
                <p class="copy line-height-100">
                    Nehmen Sie das Formular zusammen mit der Original-Ahnentafel ihres Hundes mit zum CT-Termin.
                </p>
            </div>
        </div>

        <div class="span-12">
            <span class="copy-bold line-height-100 margin-r inline-block v-align-top">3.</span>
            <div class="span-11 inline-block v-align-bottom">
                <p class="copy line-height-100">
                    Ihr Tierarzt erstellt die CT-Aufnahmen für den Hund, füllt das restliche Formular aus und gibt es
                    Ihnen vollständig
                    ausgefüllt
                    wieder
                    mit. (Die CT-/Röntgenaufnahmen werden vom Tierarzt direkt an den DRC übermittelt.)
                </p>
            </div>
        </div>

        <div class="span-12 margin-b-x4">
            <span class="copy-bold line-height-100 margin-r inline-block v-align-top">4.</span>
            <div class="span-11 inline-block v-align-bottom">
                <p class="copy line-height-100">
                    Bitte senden Sie das ausgefüllte Formular eingescannt über das <span
                        class="copy-bold line-height-100">Kontaktformular www.drc.de/XXXXX mit ausgewähltem Betreff
                        "Gelenk-Gutachten"</span> an die DRC-Geschäftsstelle oder per <span
                        class="copy-bold line-height-100">E-Mail
                        an
                        hd-ed@drc.de</span> oder per Post an <br>
                    <span class="copy-bold line-height-100">DRC-Geschäftsstelle, Ellenberger Str. 12 34302,
                        Guxhagen.</span>
                </p>
            </div>
        </div>

        <div class="span-12 margin-b-x2 padding-b-x2 border-b">
            <p class="copy-bold line-height-100">
                WICHTIG: Mit Versand des vollständig ausgefüllten Dokuments an die
                DRC-Geschäftsstelle beauftragen Sie
                automatisch die ED-Verifizierung bzw. die Ausschlussdiagnostik für OCD und Coronoid-Erkrankung.
            </p>
        </div>

        <div class="span-12">
            <p class="copy-bold line-height-100">
                HINWEIS: Die Verifizierung eines ED-Gutachtens ist gem. DRC-Zwingerordnung für alle Retriever-Rassen nur
                mittels CT-Aufnahmen innerhalb eines Zeitraumes von drei Monaten nach der Erstbegutachtung möglich.
                <br>
                Die Ausschlussdiagnostik für eine OCD und eine Coronoid-Erkrankung des Ellenbogengelenks mittels
                CT-Aufnahmen ist vor einer Zuchtverwendung gem. der Zuchtordnung für Labrador-Retriver mit ED-Grad I
                zwingend vorgeschrieben.
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>

    @if ($ctEllenbogen->hund != null)
        <div class="line">
            <div class="span-12">
                <div class="span-6 extended inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $ctEllenbogen->hund->name }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Geschlecht:</span>{{ $ctEllenbogen->hund->geschlecht }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Rasse:</span>{{ $ctEllenbogen->hund->rasse }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Farbe:</span>{{ $ctEllenbogen->hund->farbe }}
                    </p>
                </div>
                <div class="span-6 inline-block">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>{{ $ctEllenbogen->hund->zuchtbuchnummer }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Chipnummer:</span>{{ $ctEllenbogen->hund->chipnummer }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Wurfdatum:</span>{{ $ctEllenbogen->hund->wurfdatum }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="span-12">
            <div class="line">
                <div class="span-12 no-wrap">
                    <x-handwritten-line>Name:</x-handwritten-line>
                    <div class="span-6 no-wrap">
                        <x-handwritten-line>Geschelecht:</x-handwritten-line>
                        <x-handwritten-line>Rasse:</x-handwritten-line>
                        <x-handwritten-line>Farbe:</x-handwritten-line>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6 no-wrap">
                        <x-handwritten-line>ZB-Nr.:</x-handwritten-line>
                        <x-handwritten-line>Chipnummer:</x-handwritten-line>
                        <x-handwritten-line>Wurfdatum:</x-handwritten-line>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Eigentümer</span>
    <div class="mg-underline margin-b-x2"></div>

    @if ($ctEllenbogen->eigentuemer != null)
        <div class="line">
            <div class="span-12">
                <x-person2-cols :person="$ctEllenbogen->eigentuemer" />
            </div>
        </div>
    @else
        <div class="line">
            <div class="span-12 no-wrap">
                <div class="span-7 no-wrap">
                    <x-handwritten-line>Vorname:</x-handwritten-line>
                    <x-handwritten-line>Nachame:</x-handwritten-line>
                    <x-handwritten-line>Straße und Nr.:</x-handwritten-line>
                    <x-handwritten-line>Adresszusatz:</x-handwritten-line>
                    <div class="span-4 no-wrap">
                        <x-handwritten-line>Wohnort:</x-handwritten-line>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-3 no-wrap">
                        <x-handwritten-line>Postleitzahl:</x-handwritten-line>
                    </div>
                    <x-handwritten-line>Land:</x-handwritten-line>
                </div>
                <div class="space-h"></div>
                <div class="span-5 no-wrap">
                    <x-handwritten-line>Telefonnummer:</x-handwritten-line>
                    <x-handwritten-line>E-Mail:</x-handwritten-line>
                </div>
            </div>
        </div>
    @endif
</div>


<div class="span-12 margin-b-x4">
    <span class="mg-headline">Bestätigung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(25%);" :checked="$ctEllenbogen->richtigkeitAllerAngaben" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Hiermit bestätige ich die RIchtigkeit der Angaben in diesem Formular.
            </p>
        </div>
    </div>
</div>


<div class="pin-bottom" style="margin-bottom: 20mm;">
    <div class="span-12" style="margin-top: 21mm;">
        @if ($ctEllenbogen->eigentuemer != null)
            <x-place-date-signature :place="$ctEllenbogen->eigentuemer->ort" :name="$ctEllenbogen->eigentuemer->vorname . ' ' . $ctEllenbogen->eigentuemer->nachname" />
        @else
            <x-place-date-signature />
        @endif
    </div>
</div>
{{--
<div class="pin-bottom" style="margin-bottom: 20mm;">
    <div class="span-12" style="margin-top: 21mm;">
        <div class="span-6 left"> <!-- DO NOT REMOVE COMMENTS!! Needed for layout -->
            <p class="border-b wrap-pre-line"><!--
                -->{{ $ctEllenbogen->eigentuemer != null ? $ctEllenbogen->eigentuemer->ort : '' }}<!--
                -->{{ $ctEllenbogen->eigentuemer != null ? ' den ' . date("d.m.Y") : '' }}
            </p>
            <p class="amtstitel">Ort, Datum</p>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line"><!--
                -->{{ $ctEllenbogen->eigentuemer != null ? $ctEllenbogen->eigentuemer->vorname . ' ' .
                $ctEllenbogen->eigentuemer->nachname : '' }}
            </p>
            <p class="amtstitel">
                {{ $ctEllenbogen->eigentuemer != null ? 'Eigentümer' : 'Unterschrift des Eigentümers' }}
            </p>
        </div>
    </div>
</div>
    --}}


<div class="page-break"></div>
<!-- #endregion Page 1 -->

<!-- #region Page 2 -->

<div class="span-12">
    @if ($ctEllenbogen->hund != null)
        <x-key-info class="margin-b-x3"
            jsonString='[
    [
    [[{ "Name des Hundes": "{{ $ctEllenbogen->hund->name }}" }, { "Wurfdatum": "{{ $ctEllenbogen->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $ctEllenbogen->hund->rasse }}" }, { "ZB-Nr.": "{{ $ctEllenbogen->hund->zuchtbuchnummer }}" }]],
    [[{ "Farbe": "{{ $ctEllenbogen->hund->farbe }}" }, { "Chipnummer": "{{ $ctEllenbogen->hund->chipnummer }}" }]]
    ]
]
' />
    @endif


    <div class="span-12 margin-b padding-b-x2">
        <p class="mg-headline inverted">Tierarzt</p>
    </div>

    <div class="span-12 margin-b-x4">
        <span class="mg-headline">Praxis</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="span-12">
            <div class="line">
                <div class="span-12 no-wrap">
                    <div class="span-6 no-wrap">
                        <x-handwritten-line>Tierarztpraxis:</x-handwritten-line>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6 no-wrap">
                        <x-handwritten-line>Tierarzt:</x-handwritten-line>
                    </div>
                    <x-handwritten-line>Anschrift:</x-handwritten-line>
                </div>
            </div>
        </div>
    </div>

    <div class="span-12 margin-b-x2">
        <span class="mg-headline">Bestätigungen</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="span-12 line margin-b-x2">
            <x-verification
                text="Ich bestätige, dass ich o.g. Hunderasse weder gutachterlich im Auftrag des DRV e.V. auswerte noch in
                einer Praxisgemeinschaft mit einem Gutachter tätig bin der dies tut. Ich bin nicht Züchter,
                Mit-/Besitzer des Hundes oder mit diesem im 1. Grad verwandt, verheiratet oder in einer
                Lebensgemeinschaft (vgl. auch DRC-Zwingerordnung §2, Abs. 1)."
                checked />
        </div>
        <x-verification text="Die Ahnentafel des o.a. Hundes wurde vorgelegt, die Untersuchung wurde darin vermerkt."
            checked />
        <x-verification text="Die Identität des Hundes wurde anhand der Mikrochipnummer bestätigt." checked />
        <x-verification text="Der Hund hatte zum CT-Termin das erste Lebensjahr vollendet." checked />
    </div>

    <div class="span-12">
        <span class="mg-headline">CT-Aufnahmen</span>
        <div class="mg-underline margin-b-x2"></div>
        <div class="span-12">
            <div class="span-12 border-b margin-b-x2">
                <p class="subheadline">HINWEISE</p>
            </div>

            <div class="span-12 margin-b-x4">
                <ul class="padding-l-x3" style="list-style: outside;">
                    <li class="copy line-height-100">
                        Die CT-Aufnahmen verbleiben bei Ihnen. Bitte übermitteln Sie an die DRC-Geschäftsstelle die
                        Daten
                        der CT-Aufnahmen via <span class="copy-bold line-height-100">Filehosting-Dienst</span> bzw.
                        mittels
                        <span class="copy-bold line-height-100">Server-Link per E-Mail an hd-ed@drc.de</span>
                    </li>
                    <li class="copy line-height-100">
                        Bitte geben Sie das völlständig ausgefüllte Formular dem Hundeeigentümer mit.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="span-12">
        <div class="span-12 margin-b-x4">
            <div class="line">
                <div class="span-12">
                    <div class="span-6">
                        <div class="span-6 no-wrap margin-b">
                            <p class="copy-bold inline-block span-4 line-height-100">Die Daten der CT-Aufnahmen werden
                                via
                                Filehosting-Dienst <br>bzw. mittels Server-Link per E-Mail bis hd-ed@drc.de
                            </p>
                            <x-handwritten-line>übermittelt bis zum:</x-handwritten-line>
                        </div>
                    </div>
                    <div class="space-h"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="pin-bottom" style="margin-bottom: 20mm;">
        <div class="span-12" style="margin-top: 21mm;">
            <div class="span-6 left">
                <p class="border-b wrap-pre-line">
                </p>
                <p class="amtstitel">Unterschrift des Tierarztes</p>
            </div>
            <div class="span-6 right">
                <p class="border-b wrap-pre-line">
                </p>
                <p class="amtstitel">Stempel des Tierarztes / der Tierarztpraxis</p>
            </div>
        </div>
    </div>


    <!-- #endregion Page 2 -->
