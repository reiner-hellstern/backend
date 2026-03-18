@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Models\Mitgliedsart')
@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
@endphp

<div class="line span-12">
    <p class="copy">
        Sehr geehrte DRC-Geschäftsstelle, <br>
        hiermit beantrage ich die Aufnahme in den Deutscher Retriever Club e.V. als [Mitgliedschaftstyp]<br>
    </p>
    <div class="span-12">
        <p class="copy text-align-l">
            <span class="copy-bold">
                zum Vollmitglied:
            </span>
            [Vorname Vollmitglied] [Nachname Vollmitglied], [DRC-Mitgliedsnummer]
        </p>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Antragsteller</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $person->vorname }} {{ $person->nachname }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $person->strasse }} {{ $person->hausnummer }}
            </p>
            @if ($person->adresszusatz != null && $person->adresszusatz != '')
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $person->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $person->postleitzahl }} {{ $person->ort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $person->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geburtsdatum:</span>
                {{ DateFormatter::formatDMY($person->geboren) }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $person->telefon_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $person->email_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Website:</span>
                {{ $person->website_1 }}
            </p>
        </div>
    </div>
</div>


<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Jäger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6">
            <x-checkbox class="inline-block" crossed />
            <p class="inline-block copy-bold" style="transform: translateY(12.5%);">Jagdscheininhaber</p>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <x-checkbox class="inline-block" crossed />
            <p class="inline-block copy-bold" style="transform: translateY(12.5%);">Mitglied des JGHV</p>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">Mitgliedsbeitrag</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12">
            <p class="copy-bold line-height-100">Meine einmalige Aufnahmegebühr: <span
                    class="copy line-height-100">[XXX,XX] €</span></p>
        </div>
        <div class="span-12">
            <p class="copy-bold line-height-100">Mein Mitgliedsbeitrag für das laufende Jahr: <span
                    class="copy line-height-100">[XXX,XX] €</span></p>
        </div>
        <div class="span-12">
            <p class="copy-bold line-height-100">Mein jährlicher Mitgliedsbeitrag ab [Antragsjahr + 1]: <span
                    class="copy line-height-100">[XXX,XX] €</span></p>
        </div>
        <div class="span-12 margin-t-x4">
            <p class="copy-bold line-height-100">HINWEIS:<span class="copy line-height-100">
                    Satzungsgemäß erfolgt die Beitragserhebung ausschließlich mittels Einzugsermächtigung.<br>
                    Der Aufnahmeantrag wird daher nur bei Erteilung einer Einzugsermächtigung wirksam.<br>
                    Bei vergeblichem Bankeinzug erhebt der DRC eine Bearbeitungsgebühr von: [XXX,XX] €.
                </span>
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x2">
    <span class="mg-headline">SEPA-Lastschriftmandat</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-12">
            <p class="copy-bold line-height-100">Gläubiger-Identifikationsnummer: DE97ZZZ00000734841</p>
        </div>
        <div class="span-11 extended">
            <p class="copy line-height-100">
                Ich ermächtige den Deutscher Retriever Club e.V. Zahlungen von meinem Konto mittels Lastschrift
                einzuziehen. Zugleich weise ich mein Kreditinstitut an, die vom Zahlungsempfänger Deutscher Retriever
                Club e.V. auf mein Konto gezogenen Lastschriften einzulösen.
            </p>
        </div>
        <div class="span-11 extended margin-t-x2">
            <p class="copy line-height-100">
                Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten
                Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
            </p>
        </div>
        <div class="span-11 extended margin-t-x2">
            <p class="copy line-height-100">
                Zahlungsart: Wiederkehrende Zahlung – Mandatsreferenz: (wird separat mitgeteilt)
            </p>
        </div>
    </div>
    <div class="span-12 margin-t-x4">
        <p class="copy-bold line-height-100">Name des Kontoinhabers:
            <span class="copy line-height-100">[Vorname Kontoinhaber] [Nachname Kontoinhaber]</span>
        </p>
        <p class="copy-bold line-height-100">Name des Kreditinstituts:
            <span class="copy line-height-100">[Kreditinstitut]</span>
        </p>
        <p class="copy-bold line-height-100">IBAN:
            <span class="copy line-height-100">[DE0000000000000000000000]</span>
        </p>
        <p class="copy-bold line-height-100">BIC:
            <span class="copy line-height-100">[BBBBCCLLbbb]</span>
        </p>
    </div>
</div>


<div class="line span-12" style="margin-top: 21mm;">
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">[Ort], den {{ DateFormatter::formatDMY(now()) }}
        </p>
    </div>
    <div class="space-h"></div>
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">
        </p>
        <p class="amtstitel">Unterschrift, [Vorname Kontoinhaber] [Nachname Kontoinhaber]</p>
    </div>
</div>

<div class="page-break"></div>

<div class="span-12 margin-b-x3">
    <span class="mg-headline">Daten meines Hundes</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line margin-b-x2">
        <div class="span-8">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                [Name des Hundes]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Geschlecht:</span>
                [Geschlecht des Hundes]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Rasse:</span>
                [Rasse des Hundes]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Farbe:</span>
                [Farbe des Hundes]
            </p>

            <div class="space-h"></div>
        </div>
        <div class="span-4 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                [ABC 0000000000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Chipnummer:</span>
                [0000000000000]
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                [dd.mm.yyyy]
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(-100%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Ich habe die DRC-Satzung, die Zuchtordnung
                für die von mir gehaltene Retrieverrasse sowie die
                Schaurichtlinien heruntergeladen und gelesen.
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(-100%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Mir ist bekannt, dass Hunde ohne vom VDH oder der
                FCI anerkannten Ahnentafeln nicht an Veranstaltungen des Deutscher Retriever Club e.V. teilnehmen
                können, auch dann nicht, wenn der Besitzer Mitglied des Deutscher Retriever Club e.V. ist.
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x2">
        <x-checkbox class="inline-block" style="transform: translateY(-100%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Wenn ich meinen Aufnahmeantrag nicht binnen 2
                Wochen nach Erhalt der oben genannten Unterlagen widerrufe, erkenne ich die Bestimmungen des DRC als für
                mich verbindlich an.
            </p>
        </div>
    </div>
    <div class="span-12 line margin-b-x4">
        <x-checkbox class="inline-block" style="transform: translateY(-237.5%);" />
        <div class="span-11 inline-block lime line-height-100">
            <p class="inline copy cyan line-height-100 v-align-middle">Ich habe die auf Seite 3 und 4 abgedruckte
                datenschutzrechtliche Einwilligungserklärung zur Kenntnis genommen. Diese ist gesondert zu
                unterzeichnen. Die Bearbeitung dieses Aufnahmeantrags ist ohne die Unterschriften auf Seite 1 und 2
                nicht möglich.
            </p>
        </div>
    </div>

    <!-- TODO: Remove br's in production -->
    <div class="span-12 line margin-t-x4">
        <p class="inline copy cyan line-height-100 v-align-middle">
            <span class="copy-bold line-height-100">Bemerkung: </span> [Text]
        </p>
    </div>
</div>


<div class="line span-12" style="margin-top: 21mm;">
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
        </p>
    </div>
    <div class="space-h"></div>
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">
        </p>
        <p class="amtstitel">Unterschrift des Antragstellers, {{ $person->vorname }} {{ $person->nachname }}</p>
    </div>
</div>


<div class="page-break"></div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">DSGVO</span>
    <div class="mg-underline margin-b-x2"></div>
    <p class="copy-bold">Datenschutzrechtliche Einwilligungserklärung/Kenntnisnahmeerklärung:</p>
    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">Ich erkläre hiermit die Einwilligung,
        dass der Deutscher Retriever Club
        e.V. meine nachstehenden persönlichen Daten im Sinne des BDSG unter Beachtung der DSGVO erfassen, speichern und
        verwenden darf ("persönliche Daten"):
    </p>
    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est dolore iste, corrupti nostrum quo sequi fuga
        excepturi voluptates dolores odit inventore aspernatur, error harum aliquid commodi quaerat iure. Vitae fugit
        voluptatibus incidunt nihil facilis quos sequi rerum harum id consequuntur veritatis deleniti, qui voluptate
        consectetur eius nostrum quia labore voluptas inventore dicta, similique doloremque assumenda ea! Aspernatur
        illum corrupti aut maxime natus harum fugiat. Illum debitis incidunt ipsum nam.
    </p>

    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est dolore iste, corrupti nostrum quo sequi fuga
        excepturi voluptates dolores odit inventore aspernatur, error harum aliquid commodi quaerat iure. Vitae fugit
        voluptatibus incidunt nihil facilis quos sequi rerum harum id consequuntur veritatis deleniti, qui voluptate
        consectetur eius nostrum quia labore voluptas inventore dicta, similique doloremque assumenda ea! Aspernatur
        illum corrupti aut maxime natus harum fugiat. Illum debitis incidunt ipsum nam.
    </p>

    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est dolore iste, corrupti nostrum quo sequi fuga
        excepturi voluptates dolores odit inventore aspernatur, error harum aliquid commodi quaerat iure. Vitae fugit
        voluptatibus incidunt nihil facilis quos sequi rerum harum id consequuntur veritatis deleniti, qui voluptate
        consectetur eius nostrum quia labore voluptas inventore dicta, similique doloremque assumenda ea! Aspernatur
        illum corrupti aut maxime natus harum fugiat. Illum debitis incidunt ipsum nam.
    </p>

    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio corporis harum, quae expedita saepe suscipit
        voluptates qui eligendi voluptate provident?
    </p>

    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim temporibus quo nisi maiores expedita possimus id
        ullam eius veritatis laboriosam itaque blanditiis nihil, corrupti odio commodi accusamus. Enim, dolorem vitae?
        Ratione, earum dolorum vel atque at doloremque voluptatibus quibusdam doloribus alias suscipit laudantium,
        temporibus cumque architecto mollitia minus voluptatem explicabo.
    </p>

    <p class="copy line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Ich bin über mein Recht informiert worden, diese Einwilligung, insbesondere die Einwilligung zur Erfassung,
        Speicherung und Verwendung meiner persönlichen Daten zu verweigern und für die Zukunft zu widerrufen. Meine
        Widerrufserklärung werde ich richten an:
    </p>

    <p class="copy-bold line-height-100 margin-b-x2" style="color: red; opacity: 0.5;">
        Deutscher Retriever Club e.V.<br>
        Ellenberger Str. 12<br>
        34302 Guxhagen
    </p>

    <p class="copy line-height-100 margin-b-x3">
        Ich bin ausdrücklich darauf hingewiesen worden, dass ein Widerruf der Veröffentlichung und Speicherung und eine
        Löschung der Hundedaten nicht möglich ist, da sonst die Durchsetzung des Vereinszwecks des DRC e.V. nicht
        gewährleistet werden kann. Es besteht lediglich ein Widerspruchsrecht nach Art. 21 Abs.1 Satz 1 DSGVO.
    </p>



</div>

<div class="line span-12" style="margin-top: 21mm;">
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">[Ort des Antrags], den [dd.mm.yyyy]
        </p>
    </div>
    <div class="space-h"></div>
    <div class="span-6">
        <p class="border-b wrap-pre-line copy">
        </p>
        <p class="amtstitel">Unterschrift des Antragsstellers: [Vorname AS] [Nachname AS]</p>
    </div>
</div>

<div class="line span-12" style="margin-top: 21mm;">
    <x-rounded-container class="span-12">
        <p class="copy">
            Bitte laden Sie das vollständig ausgefüllte und unterschriebene Formular im Portal
            hoch.
        </p>
    </x-rounded-container>
</div>