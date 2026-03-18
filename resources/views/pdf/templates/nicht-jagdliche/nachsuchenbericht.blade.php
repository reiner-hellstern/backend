<div class="span-12 margin-b-x3">
    <span class="mg-headline">Prüfung</span>
    <div class="mg-underline margin-b"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Prüfungstyp:</span>
                [Prüfungstyp]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Prüfungsort:</span>
                [Prüfungsort]
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Prüfungsdatum:</span>
                [dd.mm.yyyy]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x3">
    <span class="mg-headline">Hundeführer</span>
    <div class="mg-underline"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                [Vorname] [Nachname]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                [Straße und Hausnummer]
            </p>
            @if (true/* TODO */)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    [Adresszusatz]
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                [PLZ] [Wohnort]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                [Land]
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                [+00 000 00000000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                [E-Mail-Adresse 1]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Hund</span>
    <div class="mg-underline"></div>
    <div class="line">
        <div class="span-12">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                [Name des Hundes]
            </p>
        </div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geschelcht:</span>
                [Geschlecht]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                [Rasse]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                [Farbe]
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                [XXX XX000000/00]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Chipnummer:</span>
                [000000000000000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-GStB-Nummer:</span>
                [20XX-X/000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">JGHV-Gebrauchshunde-Stammbuchnummer:</span>
                [X000(oFu)]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                [dd.mm.yyyy]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x3">
    <span class="mg-headline">Schweissfährte</span>
    <div class="mg-underline"></div>
    <div class="line">
        <div class="span-12">
            <p class="copy">Die Nachsuche wurde durchgeführt am [dd.mm.yyyy], um [hh:mm] Uhr.</p>
            <p class="copy">Das Stück wurde ausgelegt am [dd.mm.yyyy], um [hh:mm] Uhr – im Rahmen einer nachgestellten
                Jagdsituation bei einer DRC-Prüfung.</p>
            <p class="copy"><span class="copy-bold">Stehzeit der Fährte:</span> <span class="margin-l margin-r"
                    class="underlined">[XX]</span> Stunden
            </p>
            <p class="copy line-height-100">
                <span class="copy-bold margin-r line-height-100">Boden-/Geländebschaffenheit:</span>[Text]<br>
                [Text]
            </p>
            <p class="copy line-height-100">
                <span class="copy-bold margin-r line-height-100">Wetter:</span>[Text]
            </p>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x3">
    <span class="mg-headline">Riemenarbeit</span>
    <div class="mg-underline"></div>
    <div class="line">
        <div class="inline-block span-12">
            <div class="span-6 inline-block">
                <p class="inline-block copy-bold v-align-top margin-r line-height-100">Nach Fehlsuche von anderem Hund?
                </p>
                <x-checkbox class="inline-block v-align-text-bottom margin-r" />
                <p class="inline-block copy v-align-top margin-r line-height-100">ja</p>
                <x-checkbox class="inline-block v-align-text-bottom margin-l" />
                <p class="inline-block copy v-align-top margin-r line-height-100">nein</p>
            </div>
            <div class="space-h"></div>
            <div class="span-6 inline-block">
                <p class="copy margin-r"><span class="copy-bold">Rasse:</span> [Rasse]</p>
            </div>
        </div>
        <div class="span-12 inline-block">
            <p class="inline-block copy-bold v-align-top margin-r">Länge der Riemenarbeit:</p>
            <p class="inline-block copy v-align-top margin-r underlined">[X.XXX]</p>
            <p class="inline-block copy v-align-top">m</p>
        </div>
        <div class="span-12 inline-block">
            <p class="inline-block copy-bold v-align-top margin-r line-height-100">Kam es zu einer Hetze?</p>
            <x-checkbox class="inline-block v-align-text-bottom margin-r" />
            <p class="inline-block copy v-align-top margin-r line-height-100">ja</p>
            <x-checkbox class="inline-block v-align-text-bottom margin-l" />
            <p class="inline-block copy v-align-top margin-r line-height-100">nein</p>
        </div>
        <p class="copy">
            <span class="copy-bold margin-r line-height-100">Schussverletzung/Verkehrsunfall:</span>[Text]
        </p>
        <p class="copy">
            <span class="copy-bold margin-r line-height-100">Wildart:</span>[Text]
        </p>
        <p class="copy">
            <span class="copy-bold margin-r line-height-100">Wildbretgewicht:</span>[Text]
        </p>
        <p class="copy">
            <span class="copy-bold margin-r">Verkaufspreis:</span>[Text]
        </p>
        <p class="copy wrap-pre-line line-height-100"><span class="copy-bold margin-r 
        line-height-100">Beschreibung der Nachsuche:</span>[Text]
            [Text]
            [Text]
        </p>
    </div>
</div>



<div class="pin-bottom">
    <div class="span-12 margin-b-x2">
        <span class="mg-headline">Prüfer</span>
        <div class="mg-underline"></div>
    </div>
    <x-supervision-list pruefungsLeiterId="410" richterObmannId="212" richterIds="[123]"></x-supervision-list>
    <div class="span-12 padding-t-x3">
        <div class="span-6 left">
            <p class="border-b">[Ort], den [Datum]</p>
            <br>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">
            </p>
            <p class="amtstitel">Unterschrift [Vorname des Hundeführers] [Nachname des Hundeführers]</p>
        </div>
    </div>
</div>