<!-- #region Page 1 -->
<div class="span-12 margin-b-x4 padding-b-x2 border-b">
    <div class="span-12 margin-b-x2">
        <p class="mg-headline inverted">Hundeeigentümer</p>
    </div>

    <div class="line span-12">
        <div class="span-12 border-b margin-b-x2">
            <p class="sectionheadline-small">IHR WEG ZUM GELENK-GUTACHTEN</p>
        </div>

        <div class="span-12">
            <ol class="span-12 copy-small lime" style="position: relative; left: 3mm;">
                <li>
                    <p class="span-11 inline-block line-height-100 copy-small">
                        Bitte drucken Sie das Formular aus und füllen es unterhalb
                        dieses Hinweistextes komplett aus.
                    </p>
                </li>
                <li>
                    <p class="span-11 inline-block line-height-100 copy-small">
                        Nehmen Sie das Formular zusammen mit der Original-Ahnentafel ihres Hundes mit zum
                        Röntgentermin.
                    </p>
                </li>
                <li>
                    <p class="span-11 inline-block line-height-100 copy-small">
                        Ihr Tierarzt röngt den Hund, füllt das restliche Formular aus und gibt es Ihnen vollständig
                        ausgefüllt wieder mit.
                    </p>
                </li>
                <li>
                    <p class="span-11 inline-block line-height-100 copy-small">
                        Bitte senden Sie das ausgefüllte Formular eingesscannt über das Kontaktformular
                        www.drc.de/lorem-ipsum/dolor/sit-amet mit ausgewähltem Betreff "Gelenk-Gutachten" an die
                        DRC-Geschäftsstelle oder per E-Mail an hd-ed@drc.de oder per Post an DRC-Geschäftsstelle,
                        Ellenberger Str. 12 34302, Guxhagen.
                    </p>
                </li>
            </ol>
            <div class="inline-block padding-t-x2 text-align-l orange v-align-top">
                <span class="padding-0 line-height-100 copy-small-bold">
                    WICHTIG: Mit Versand des vollständig ausgefüllten Dokuments an die
                    DRC-Geschäftsstelle beauftragen Sie
                    automatisch die hier definierten Gelenk-Gutachten.
                </span>
            </div>
        </div>
    </div>
</div>


<div class="line span-12 margin-b-x2">
    <span class="mg-headline">Röntgenaufnahmen</span>
    <div class="mg-underline margin-b-x2"></div>

    @if ($gelenkRoentgen->eigentuemer == null)
        <p class="line-height-100 copy-bold margin-b" style="font-size: 8pt; line-height: 7pt;">
            Für die Beauftragung eines Gutachtens auf HD, ED oder OCD ist die Anfertigung von Röntgenaufnahmen der
            Hüften,
            der Ellenbogen bzw. der Schultern oder der Sprunggelenke Ihres Hundes erforderlich. Bitte wählen Sie daher
            hier
            zunächst aus, für welche Gelenke Sie ein Gutachten beauftragen möchten.
        </p>
    @endif

    <div class="line span-12">
        <div class="span-6 cyan inline-block">
            <div class="span-6">
                <p class="inline-block line-height-100 copy-bold wrap-pre-line margin-b-x2" style="line-height: 80%;">
                    Röntgenaufnahmen für:
                </p>
            </div>
            <div class="span-3 inline-block v-align-middle">
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->fuer->hd
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Hüftgelenke (HD)</p>
                </div>
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->fuer->ed
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Ellenbogengelenke (ED)</p>
                </div>
            </div>
            <div class="span-3 inline-block v-align-middle">
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->fuer->schultern
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Schultern (OCD)</p>
                </div>
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->fuer->sprunggelenke
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Sprunggelenke (OCD)</p>
                </div>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-6 lime inline-block">
            <div class="span-6">
                <p class="inline-block line-height-100 copy-bold margin-b-x2" style="line-height: 80%;">
                    Mein Hund wurde bis zum Röntgentermin operiert am:
                </p>
            </div>

            <div class="span-3 inline-block v-align-middle">
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->vorherige_operationen->hueftgelenk
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Hüftgelenk</p>
                </div>
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->vorherige_operationen->ellenbogengelenk
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Ellenbogengelenk</p>
                </div>
            </div>
            <div class="span-3 inline-block v-align-middle">
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->vorherige_operationen->schulter
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Schultergelenk</p>
                </div>
                <div class="span-3 inline-block">
                    <x-checkbox class="inline-block margin-r v-align-middle" style="transform: translateY(25%);"
                        :crossed="$gelenkRoentgen->roentgenaufnahmen != null
                            ? $gelenkRoentgen->roentgenaufnahmen->vorherige_operationen->sprunggelenk
                            : false" />
                    <p class="inline-block line-height-100 copy-bold v-align-middle">Sprunggelenk</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline margin-b-x2"></div>

    @if ($gelenkRoentgen->hund != null)
        <div class="line">
            <div class="span-12">
                <div class="span-6 extended inline-block">
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Name:</span>{{ $gelenkRoentgen->hund->name }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Geschlecht:</span>{{ $gelenkRoentgen->hund->geschlecht }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Rasse:</span>{{ $gelenkRoentgen->hund->rasse }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Farbe:</span>{{ $gelenkRoentgen->hund->farbe }}
                    </p>
                </div>
                <div class="span-6 inline-block">
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>{{ $gelenkRoentgen->hund->zuchtbuchnummer }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Chipnummer:</span>{{ $gelenkRoentgen->hund->chipnummer }}
                    </p>
                    <p class="copy line-height-100 ">
                        <span
                            class="line-height-100 copy-bold margin-r">Wurfdatum:</span>{{ $gelenkRoentgen->hund->wurfdatum }}
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

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Eigentümer</span>
    <div class="mg-underline margin-b-x2"></div>

    @if ($gelenkRoentgen->eigentuemer != null)
        <div class="line">
            <div class="span-12">
                <x-person2-cols :person="$gelenkRoentgen->eigentuemer" />
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

<!-- #endregion Page 1 -->

<!-- #region Page 2 -->
<div class="span-12 margin-b-x2">
    @if ($gelenkRoentgen->eigentuemer == null)
        <span class="mg-headline">DSGVO</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="span-12 line margin-b-x2">
            <x-checkbox class="inline-block" style="transform: translateY(-275%);" />
            <div class="span-11 inline-block lime line-height-100">
                <p class="inline copy-small cyan line-height-100 v-align-middle">
                    Ich willige ein, dass meine personenbezogenen Daten zwecks Befundung der Röntgenaufnahmen
                    verarbeitet
                    werden. Meine Einwilligung kann ich jederzeit mit der Wirkung für die Zukunft per E-Mail an
                    <span class="copy-small-bold line-height-100">office@drc.de</span> oder per Post an die
                    DRC-Geschäftsstelle
                    schriftlich widerrufen. Dies gilt nicht für die Hundedaten. Eine Löschung der Hundedaten oder ein
                    Widerspruch zur Veröffentlichung des Ergebnisses der Begutachtung auf HD, ED oder OCD kann nicht
                    verlangt werden, da sonst der Vereinszweck nicht erfüllt werden kann. Es besteht lediglich ein
                    Widerspruchsrecht nach Art. 21 Abs. 1 Satz 1 DSGVO.
                </p>
            </div>
        </div>
    @endif
</div>

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Bestätigung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(25%);" :checked="$gelenkRoentgen->richtigkeitAllerAngaben" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy-small cyan line-height-100 v-align-middle">
                Hiermit bestätige ich die Richtigkeit der Angaben in diesem Formular.
            </p>
        </div>
    </div>
</div>

@if ($gelenkRoentgen->roentgenaufnahmen->fuer->hd || $gelenkRoentgen->roentgenaufnahmen->fuer->ed)
    <div class="span-12 margin-b-x4">
        <p class="sectionheadline-small line-height-100 margin-b">HINWEIS</p>

        <div class="span-12 margin-b-x2">
            <p class="copy-small-bold line-height-100">
                Gelenk-Gutachten für HD bzw. ED sind kostenpflichtig!
            </p>
            <p class="copy-small line-height-100">
                Für Hunde, die zum Zeitpunkt der Erstellung des Gutachtens nicht in das DRC-Zuchtbuch eingetragen sind,
                wird eine Auswertungsgebühr in Höhe von
                @if ($gelenkRoentgen->roentgenaufnahmen->fuer->hd)
                    {{ $gelenkRoentgen->gebuehren->hd }} für die HD-Begutachtung
                @endif
                @if ($gelenkRoentgen->roentgenaufnahmen->fuer->hd && $gelenkRoentgen->roentgenaufnahmen->fuer->ed)
                    und
                @endif
                @if ($gelenkRoentgen->roentgenaufnahmen->fuer->ed)
                    {{ $gelenkRoentgen->gebuehren->ed }} für die ED-Begutachtung
                @endif
                fällig.
                <span class="line-height-100 copy-small-bold">Nicht-DRC-Mitglieder</span> erhalten von uns vor der
                Ergebnisübermittlung eine entsprechende Rechung.
                Bei <span class="line-height-100 copy-small-bold">DRC-Mitgliedern</span> werden die Gebühren per
                Lastschrift
                eingezogen.
                Für im DRC-Zuchtbuch eingetragene Hunde wird diese Auswertungsgebühr vom DRC getragen.
            </p>
        </div>
    </div>
@endif

{{--

Für Hunde, die zum Zeitpunkt der Erstellung des Gutachtens nicht in das DRC-Zuchtbuch eingetragen sind,
wird eine Auswertungsgebühr in Höhe von

%GEBÜHR% für die %TYP%-Begutachtung
und %GEBÜHR% für die %TYP%-Begutachtung

fällig

--}}

<div class="pin-bottom" style="margin-bottom: 20mm;">
    <div class="span-12" style="margin-top: 21mm;">
        @if ($gelenkRoentgen->eigentuemer->ort != null)
            <x-place-date-signature nameSubline="Eigentümer" :place="$gelenkRoentgen->eigentuemer->ort" :name="$gelenkRoentgen->eigentuemer->vorname . ' ' . $gelenkRoentgen->eigentuemer->nachname" />
        @else
            <x-place-date-signature signatureSubline="Unterschrift des Eigentümers" />
        @endif
    </div>
</div>

<div class="page-break"></div>
<!-- #endregion Page 2 -->


<!-- #region Page 3 -->
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

<div class="span-12">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(-225%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">
                Ich bestätige, dass ich o.g. Hunderasse weder gutachterlich im Auftrag des DRC e.V. auswerte noch in
                einer Praxisgemeinschaft mit einem Gutachter tätig bin der dies tut. Ich bin nicht Züchter,
                Mit-/Besitzer des Hundes oder mit diesem im 1. Grad verwandt, verheiratet oder in einer
                Lebensgemeinschaft (vgl. auch DRC-Zwingerordnung §2, Abs. 1).
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(25%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Die Ahnentafel des o.a. Hundes wurde
                vorgelegt,
                die Untersuchung wurde darin vermerkt.
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(25%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Die Identität des Hundes wurde anhand der
                Mikrochipnummer bestätigt.
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x4">
        <x-checkbox class="inline-block" style="transform: translateY(25%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Der Hund hatte zum Röntgentermin das erste
                Lebensjahr vollendet.
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Röntgenuntersuchung</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="span-12 margin-b-x4">
        <div class="line">
            <div class="span-12 no-wrap">
                <div class="span-6 no-wrap">
                    <p class="copy-bold line-height-100 span-6">Der untersuchte Hund wurde wie folgt sediert:</p>
                </div>
                <div class="space-h"></div>
                <div class="span-6 no-wrap">
                    <x-handwritten-line>Präparat:</x-handwritten-line>
                    <x-handwritten-line>Menge:</x-handwritten-line>
                </div>
            </div>
        </div>
        <div class="line">
            <div class="span-12 no-wrap">
                <div class="span-6 no-wrap">
                    <x-handwritten-line>Datum der Röntgenaufnahmen:</x-handwritten-line>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Röntgenaufnahmen</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="span-12">
        <div class="span-12 border-b margin-b-x2">
            <p class="sectionheadline-bold">ZUM VORGEHEN</p>
        </div>

        <div class="span-12 margin-b-x4">
            <ul class="padding-l-x3" style="list-style: outside;">
                <li class="copy line-height-100">
                    Bitte geben Sie das völlständig ausgefüllte Formular dem Hundeeigentümer mit.
                </li>
                <li class="copy line-height-100">
                    Die Röntgenbilder verbleiben bei Ihnen, laden Sie diese bitte direkt in das VetsXL-Portal hoch.
                </li>
                <li class="copy line-height-100">
                    Bitte beachten Sie, dass eine Begutachtung nur möglich ist, wenn die
                    Bilder in das VetsXL-Portal hochgeladen wurden. Analoge oder digitale, per CD/USB-Stick
                    eingesandte
                    Aufnahmen können nicht mehr bearbeitet werden.
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="span-12">
    <div class="span-12 margin-b-x4">
        <div class="line">
            <div class="span-12">
                <div class="span-12 no-wrap">
                    <x-handwritten-line>Die Röntgenaufnahmen werden im VetsXL-Portal hochgeladen bis
                        zum:</x-handwritten-line>
                </div>
                <div class="span-12 margin-b-x2">
                    <div class="span-2"></div>
                    <div class="space-h"></div>
                    <div class="span-10">
                        <x-verification
                            text="Dem richtigen Zuchtverein
                                (Deutscher Retriever Club e.V.)
                                zugeordnet." />
                        <x-verification
                            text="Dem richtigen Gutachter
                                (Golden Retriever: Dr. Camp; übrige Retrieverrassen: Dr. Tellhelm) zugeordnet." />
                    </div>
                </div>
                <div class="span-12">
                    <div class="span-2"></div>
                    <div class="space-h"></div>
                    <div class="span-8 no-wrap line">
                        <div class="inline-block margin-r-x2">
                            <p class="copy-bold">
                                Die VetsXL-Portalnummer lautet:
                            </p>
                            <p class="amtstitel line-height-100" style="transform: translateY(-0.5mm);">[Sofern die
                                Aufnahmen bereits hochgeladen wurden]</p>
                        </div>
                        <div class="span-4">
                            <x-handwritten-line></x-handwritten-line>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pin-bottom">
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
</div>

<div class="page-break"></div>

<!-- #endregion Page 3 -->

<div class="span-12">
    <div class="span-12 margin-b-x4">
        <x-rounded-container>
            <p class="copy-bold">Hinweise für den Röntgentierarzt</p>
            <p class="copy">
                Anforderungen an Röntgenaufnahmen für offizielle Gutachten des Deutschen Retriever Club (DRC) e.V.
            </p>
        </x-rounded-container>
    </div>

    <div class="line span-12 red">
        <div class="span-12">
            <div class="span-6 yellow border-r" style="padding-right: 2.4mm; margin-right: 2.4mm; height: 91%;">
                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">1. Identität des Hundes</p>
                    <p class="copy-small line-height-100">
                        Der Tierarzt bestätigt durch seine Unterschrift, dass er die Identität des Hundes anhand der
                        Ahnentafel überprüft hat und dass die Chipnummer des Hundes mit den Angaben in der
                        Ahnentafel
                        übereinstimmt.
                    </p>
                </div>

                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">2. Mindestalter</p>
                    <p class="copy-small line-height-100">
                        Die Röntgenaufnahmen für die Begutachtung dürfen frühenstens am Tag nach der Vollendung des
                        ersten
                        Lebensjahres angefertigt werden!
                    </p>
                </div>

                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">3. Röntgenausschluss</p>
                    <p class="copy-small line-height-100">
                        Röntgenaufnahmen können lt. § 11 der DRC-Zwingerordnung nicht verwendet werden, wenn der
                        Hundeeigentümer gleichzeitig der Röntgentierarzt ist. Gleiches gilt für in
                        Praxisgemeinschaft tätige
                        oder angestellte Tierärzte und dem im § 8 (3) der Zwingerordnung benannten Personenkreis
                        (Züchter,
                        Verwandte, Ehepartner, etc.)
                    </p>
                </div>

                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">4. Einreichung der Röntgenunterlagen</p>
                    <p class="copy-small line-height-100">
                        Das ausgefüllte Formular ist eingescannt per E-Mail an: hd-ed@drc.de oder per Post an:
                        DRC-Geschäftsstekke,Ellenberger Str. 12, 34302 Guxhagen einzusenden. Digitale Aufnahmen
                        müssen
                        online über das Portal der GRSK (myvetsXL.com) eingereicht werden.
                    </p>
                </div>

                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">5. Ahnentafel des Hundes</p>
                    <p class="copy-small line-height-100">
                        Das Röntgendatum muss auf der Original-Ahnentafel des Hundes eingetragen werden. Eine
                        Einsendung der
                        Ahnentafel an den Verein ist nicht erforderlich.
                    </p>
                </div>

                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">6. Kennzeichnung der Röntgenaufnahmen</p>
                    <p class="copy-small line-height-100">
                        Die Kennzeichnung der Röntgenaufnahmen erfolgt mit folgenden
                        Angaben:
                    </p>
                    <p class="copy-small line-height-100">a) Rasse</p>
                    <p class="copy-small line-height-100">b) Wurftag</p>
                    <p class="copy-small line-height-100">c) Geschlecht</p>
                    <p class="copy-small line-height-100">d) Zuchtbuchnummer</p>
                    <p class="copy-small line-height-100">e) Name des Hundes</p>
                    <p class="copy-small line-height-100">f) Chipnummer</p>
                    <p class="copy-small line-height-100">g) Datum der Röntgenaufnahme</p>
                    <p class="copy-small line-height-100">h) Seitenmarkierungen!!!</p>
                    <p class="copy-small-bold line-height-100">
                        Bitte keine weiteren Beschriftungen der Röntgenaufnahmen
                        vornehmen.
                    </p>
                    <p class="copy-small line-height-100">Nicht korrekt gekennzeichnete Röntgenaufnahmen bzw. nicht
                        korrekt
                        ausgefüllte Formulare werden vom DRC nicht zur Begutachtung angenommen.</p>
                </div>
                <div class="margin-b-x4">
                    <p class="copy-bold line-height-100">7. Weitere Anforderungen an HD-Aufnahmen</p>
                    <p class="copy-small line-height-100">Für die Beurteilung ist eine Aufnahme in korrekter
                        Lagerung
                        anzufertigen:</p>
                    <p class="copy-small line-height-100">a) symmetrische Lagerung</p>
                    <p class="copy-small line-height-100">b) Hintergliedmaßen parallel zueinander und zur
                        Tischoberfläche
                    </p>
                    <p class="copy-small line-height-100">c) Gut eindrehen! Kniescheiben müssen in die Mitte der
                        Kniegelenke
                        projiziert erscheinen!</p>
                    <p class="copy-small line-height-100">d) Aufnahmeformat 30 x 40 cm</p>
                </div>
            </div>

            <div class="span-6 orange">
                <div class="margin-b-x3">
                    <p class="copy-bold line-height-100">8. Weitere Anforderungen an ED-Aufnahmen</p>
                    <p class="copy-small line-height-100 margin-b">Es müssen Röntgenbilder beider Ellenbogen
                        angefertigt
                        werden. Das
                        Ellenbogengelenk sollte jeweils im Zentralstrahl liegen. Die seitlichen Aufnahmen müssen
                        orthograd
                        gelagert werden.</p>
                    <p class="copy-small line-height-100 margin-b">
                        a) Idealerweise werden zur besseren Beurteilung je drei
                        Röntgenaufnahmen (ca. 40°, 120-130°, kraniokaudal) von beiden Ellenbogen angefertigt
                    </p>

                    <div class="span-6 margin-b-x2">
                        <div class="span-3">
                            <div class="span-2 margin-b">
                                <img class="border-all" src="{{ public_path('/assets/gelenk_roentgen_1a.png') }}"
                                    style="height: 3cm;">
                            </div>
                            <p class="copy-small line-height-100">
                                (1a) Seitliche Position (mediolateral) mit abgewinkeltem Ellenbogengelenk (ca.40°;
                                siehe
                                Skizze
                                1a).
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-3">
                            <div class="span-2 margin-b">
                                <img class="border-all" src="{{ public_path('/assets/gelenk_roentgen_1b.png') }}"
                                    style="height: 3cm;">
                            </div>
                            <p class="copy-small line-height-100">
                                (1b) Seitliche Position (mediolateral) mit gestrecktem Ellenbogengelek (ca.
                                120-130°; siehe
                                Skizze 1b)
                            </p>
                        </div>
                    </div>
                    <div class="span-6 padding-b-x3 margin-b-x3 border-b" style="border-style: dotted;">
                        <div class="span-2 margin-b">
                            <img class="border-all" src="{{ public_path('/assets/gelenk_roentgen_2.jpg') }}"
                                style="height: 3cm;">
                        </div>
                        <div class="space-h"></div>
                        <p class="copy-small line-height-100">
                            (2) Auf der Brust liegend mit nach vorn gestrecktem Bein (kraniokaudal), welches leicht
                            nach
                            medial eingedreht wird (15° Pronation; siehe Skizze 2). Der proximolaterale Rand des
                            Olecranons
                            sollte in etwa auf dem lateralen Rand des Condylus humeri projiziert sein.
                        </p>
                    </div>

                    <div class="span-6 padding-b-x3 margin-b-x3 border-b" style="border-style: dotted;">
                        <p class="copy-small line-height-100 margin-b">
                            b) Alternativ können jeweils zwei Röntgenaufnahmen (90°, kraniokaudal) angefertigt
                            werden.
                        </p>
                        <div class="span-3">
                            <div class="span-2 margin-b">
                                <img class="border-all" src="{{ public_path('/assets/gelenk_roentgen_1.jpg') }}"
                                    style="height: 3cm;">
                            </div>
                            <p class="copy-small line-height-100">
                                (1) Seitliche Position (mediolateral) mit gebeugtem Ellenbogengelenk (ca. 90°; siehe
                                Skizze
                                1). Der Processus anconeus muss durch den Epicondylus medialis deutlich erkennbar
                                sein.
                            </p>
                        </div>
                        <div class="space-h"></div>
                        <div class="span-3">
                            <div class="span-2 margin-b">
                                <img class="border-all" src="{{ public_path('/assets/gelenk_roentgen_2.jpg') }}"
                                    style="height: 3cm;">
                            </div>
                            <p class="copy-small line-height-100">
                                (2) Kraniokaudal (siehe Skizze 2)
                            </p>
                        </div>
                    </div>

                    <p class="copy-small line-height-100">
                        c) Die Röntgenaufnahmen müssen von hoher technischer Qualität sein, damit auch Ansätze von
                        Osteopythen und Sklerosierungen erkennbar sind. Dazu sollen die Gelenke direkt auf die
                        Röntgenplatte
                        oder den Einzelpackfilm gelagert werden – ohne Raster (digitale Aufnahme siehe 4.)
                    </p>
                </div>

                <div class="margin-b">
                    <p class="copy-bold line-height-100">9. Ausschluss der Beurteilung</p>
                    <p class="copy-small line-height-100">
                        Mangelhafte Lagerung oder mangelhafte technische Qualität schließen eine Beurteilung aus!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #region Page 4 -->
