@use('App\Http\Controllers\Utils\RandomDBEntries')
@php
    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber4 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $mitinhaber_list = [
        $mitinhaber1,
        $mitinhaber2,
        $mitinhaber3
    ];
@endphp

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Welpe</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-8 inline-block">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Name:</span>[Komplettname
                des Hundes]
            </p>
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Rasse:</span>[Rasse]
            </p>
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Geschlecht:</span>[Geschlecht]</p>
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Farbe:</span>[Farbe]</p>
        </div>
        <div class="space-h"></div>
        <div class="span-4 inline-block">
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>[XXX
                XX000000/00]
            </p>
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Chipnummer:</span>[000000000000000]
            </p>
            <p class="copy line-height-100 "><span
                    class="line-height-100 copy-bold margin-r">Wurfdatum:</span>[dd.mm.yyyy]</p>
            <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">Wurfbuchstabe:</span>[X]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Elterntiere</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-8 inline-block no-wrap">
            <p class="line-height-100 copy-bold margin-r">Art der Zucht:
                <span class="copy line-height-100 ">[Kategorie]</span>
            </p>
        </div>

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

        <div class="span-12">
            <div class="span-12 border-b">
                <p class="copy-bold">Mutter</p>
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
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Zuchtstätte</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
                [Zwingername]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                [Straße und Hausnummer]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                [Adresszusatz]
            </p>
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
                <span class="line-height-100 copy-bold margin-r">FCI-Zwingernummer:</span>
                [FCI-Zwingernummer]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Zwingernummer:</span>
                [DRC-Zwingernummer]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                [Telefonnummer 1]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                [E-Mail-Adresse 1]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Website:</span>
                [Zwinger-Website]
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Züchter</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Firma:</span>
                [Firmenname]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                [Vorname], [Nachname]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                [Straße und Hausnummer]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                [Adresszusatz]
            </p>
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
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                [DRC-Mitgliedsnummer]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitglied seit:</span>
                [dd.mm.yyyy]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                [dd.mm.yyyy]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                [Telefonnummer 1]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                [E-Mail-Adresse 1]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Website:</span>
                [Website]
            </p>
        </div>
    </div>
</div>

@if (!empty($mitinhaber_list))
    <div class="span-12 margin-t-x4 margin-b-x4">
        <span class="mg-headline">Zwinger-Mitinhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @foreach ($mitinhaber_list as $index => $mitinhaber)
            <div
                class="line span-12 padding-b-x2 {{ $index + 1 < count($mitinhaber_list) ? "border-b margin-b-x2" : null}} no-page-break-inside">
                <div class="line span-12 margin-b-x2">
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Name:</span>
                            {{ $mitinhaber->vorname }}
                            {{ $mitinhaber->nachname }}
                        </p>
                    </div>
                    <div class="space-h"></div>
                    <div class="span-6">
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                            {{ $mitinhaber->mitgliedsnummer }}
                        </p>
                        <p class="line-height-100 copy">
                            <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                            {{ $mitinhaber->telefon_1 }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Käufer</span>
    <div class="mg-underline margin-b-x2"></div>

    @foreach ($welpenkaeufer as $index => $welpenkaeufer_person)
        <div
            class="line margin-b-x2 no-page-break-inside {{ count($welpenkaeufer) > 1 && ($index + 1) != count($welpenkaeufer) ? "padding-b-x2 border-b" : "" }}">
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Firma:</span>
                    {{ $welpenkaeufer_person->firma }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    {{ $welpenkaeufer_person->vorname }}, {{ $welpenkaeufer_person->nachname }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                    {{ $welpenkaeufer_person->adresse }}
                </p>
                @if($welpenkaeufer_person->adresszusatz != null)
                    <p class="copy line-height-100 ">
                        <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                        {{ $welpenkaeufer_person->adresszusatz }}
                    </p>
                @endif
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                    {{ $welpenkaeufer_person->postleitzahl }}, {{ $welpenkaeufer_person->wohnort }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Land:</span>
                    {{ $welpenkaeufer_person->land }}
                </p>
            </div>
            <div class="space-h"></div>
            <div class="span-6 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                    {{ $welpenkaeufer_person->drc_mitgliedsnummer }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">DRC-Mitglied seit:</span>
                    {{ $welpenkaeufer_person->mitglied_seit }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                    {{ $welpenkaeufer_person->geburtsdatum }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                    {{ $welpenkaeufer_person->telefon_1 }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                    {{ $welpenkaeufer_person->email_1 }}
                </p>
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Website:</span>
                    {{ $welpenkaeufer_person->website }}
                </p>
            </div>
        </div>
    @endforeach
</div>

<div class="page-break"></div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">DSGVO</span>
    <div class="mg-underline margin-b-x2"></div>
    <p class="copy-bold">Datenschutzrechtliche Einwilligungserklärung/Kenntnisnahmeerklärung:</p>
    <p class="copy line-height-100 margin-b-x2">zur Veröffentlichung meiner persönlichen Daten im Datensatz meiner Hunde
        in der
        Datenbank des
        Deutschen Retriever Club e.V. und in der öffentlich zugänglichen Hundedatenbank des Deutschen Retriever Club
        e.V.
    </p>
    <p class="copy line-height-100 margin-b-x2">
        Ich erkläre durch meine Unterschrift auf Seite 1 dieses Formulars die Einwilligung, dass der Deutsche Retriever
        Club e.V. meine nachstehenden persönlichen Daten (Name, ggfs. (akademische) Titel, Vornamen, Anschrift,
        Festnetz- und Mobil- Telefonnummern, Telefax-Nummer, E-Mail-Adresse, Internetadresse einer eigenen Homepage) im
        Datensatz meines Hundes in seiner Datenbank im Sinne des BDSG unter Beachtung der DSGVO erfassen, speichern und
        verwenden und in der öffentlich zugänglichen Hundedatenbank des Deutschen Retriever Club e.V. veröffentlichen
        darf.
    </p>

    <p class="copy line-height-100 margin-b-x2">
        Des Weiteren erkläre ich, dass ichzur Kenntnis genommen habe, dass der Deutsche Retriever Club e.V. gemäß Art. 6
        Abs. 1 lit f) DSGVO folgende Hundedaten auch ohne ausdrückliche Einwilligung verwenden und speichern darf
        („Hundedaten“): Zuchtbuchnummer des Hundes, Name des Hundes, Chip-/Tätowiernummer, Wurfdatum/Geburtsdatum,
        Geschlecht, Retriever Rasse, Farbe, Vater, Zuchtbuchnummer des Vaters, Mutter, Zuchtbuchnummer der Mutter, Tot
        (Kennzeichnung, wenn der Hund vor Vollendung des ersten Lebensjahres verstirbt), Ahnen bis mindestens zu den
        Ur-Großeltern, L-Heft-Nummer (Nummer eines Leistungsheftes), L-Heft-Datum (Ausstellungsdatum eines
        Leistungsheftes), Ergebnisse abgelegter Prüfungen und Ausstellungen (z.B. Prüfungsdatum und -ort, Richter,
        Ergebnis der Prüfung), Daten zu Gesundheitsergebnissen und Untersuchungen (z.B. Augenuntersuchungen, Zahnstatus,
        HD- und ED-Untersuchungen, Gentest-Ergebnisse, Kryptorchismus, Herzuntersuchungen, Patellauntersuchungen),
        Zuchtwerte, Daten zur Zuchtverwendung der Hunde (Datum der Zuchtzulassung, Deckdatum, Wurfdatum, Anzahl der
        Nachkommen, ggf. Geburt per Kaiserschnitt), Bilder.
    </p>

    <p class="copy line-height-100 margin-b-x2">
        Die Hundedaten werden für alle im DRC. e.V. gezüchteten Hunde sowie für deren Vorfahren erhoben, gespeichert und
        verwendet. Aus den Hundedaten werden Ahnentafeln und Listen der Nachkommen für die Veröffentlichung auf der DRC-
        Homepage

        (www.drc.de) und der DRC-App generiert. Außerdem werden zu jedem in der Datenbank des DRC e.V. erfassten Hund in
        einer Detailanzeige die vorhandenen Stammdaten des Hundes veröffentlicht.
    </p>

    <p class="copy line-height-100 margin-b-x2">
        Zugang zu den Hundedaten im Rahmen der satzungsgemäßen Zwecke hat jedermann aufgrund der Veröffentlichung des
        Zuchtbuches, der Ahnentafeln und der Hunde-Detailanzeigen.
    </p>

    <p class="copy line-height-100 margin-b-x2">
        Mir ist bewusst, dass die Daten nach einem Widerruf dieser Einwilligung gesperrt und nach Ablauf der
        gesetzlichen Aufbewahrungsfrist für Geschäftsunterlagen gelöscht werden. Dies gilt allerdings nicht für die
        Hundedaten. Eine Löschung der Hundedaten kann nicht verlangt werden, da sonst der Vereinszweck nicht erfüllt
        werden kann. Es besteht lediglich ein Widerspruchsrecht nach Art. 21 Abs.1 Satz 1 DSGVO.
    </p>

    <p class="copy line-height-100 margin-b-x2">
        Ich bin über mein Recht informiert worden, diese Einwilligung, insbesondere die Einwilligung zur Erfassung,
        Speicherung und Verwendung meiner persönlichen Daten zu verweigern und für die Zukunft zu widerrufen. Meine
        Widerrufserklärung werde ich richten an:
    </p>

    <p class="copy-bold line-height-100 margin-b-x2">
        Deutscher Retriever Club e.V.<br>
        Ellenberger Str. 12<br>
        34302 Guxhagen
    </p>

    <p class="copy line-height-100 margin-b-x3">
        Ich bin ausdrücklich darauf hingewiesen worden, dass ein Widerruf der Veröffentlichung und Speicherung und eine
        Löschung der Hundedaten nicht möglich ist, da sonst die Durchsetzung des Vereinszwecks des DRC e.V. nicht
        gewährleistet werden kann. Es besteht lediglich ein Widerspruchsrecht nach Art. 21 Abs.1 Satz 1 DSGVO.
    </p>


    @foreach ($welpenkaeufer as $index => $welpenkaeufer_person)
        <div class="line span-12 inline-block margin-b-x4 border-all no-page-break-inside">
            <div class="span-7 extended">
                <x-checkbox checked class="inline-block v-align-middle margin-l-x2" />
                <p class="inline-block copy v-align-middle">Hiermit bestätige ich die DSGVO gelesen zu haben und stimme ihr
                    zu</p>
            </div>
            <div class="span-5" style="padding-top: 10mm;">
                <p class="border-b copy wrap-pre-line margin-r-x2">
                </p>
                <p class="amtstitel">Unterschrift des Käufers: {{ $welpenkaeufer_person->vorname }},
                    {{ $welpenkaeufer_person->nachname }}
                </p>
            </div>
        </div>
    @endforeach

    <div class="span-12" style="margin-top: 21mm;">
        <div class="span-6 left">
            <p class="border-b">[Ort], den [dd.mm.yyyy]</p>
            <br>
        </div>
    </div>
</div>