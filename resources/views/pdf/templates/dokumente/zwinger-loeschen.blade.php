@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);
    $zwinger = $person->zwinger;

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

<div class="line span-12">
    <p class="copy">
        @if (!$isZwingergemeinschaft)
            Sehr geehrte DRC-Geschäftstelle,<br>
            hiermit will ich meinen Zwinger entgültig und unumkehrbar löschen lassen. Bitte leiten Sie diesen Antrag an den
            VDH weiter,<br> der die Löschung beim FCI unverzüglich veranlasst:
        @else
            Sehr geehrte DRC-Geschäftstelle,<br>
            hiermit wollen wir unseren Zwinger entgültig und unumkehrbar löschen lassen. Bitte leiten Sie diesen Antrag an
            den VDH weiter,<br> der die Zwinger-Löschung beim FCI unverzüglich veranlasst:
        @endif
    </p>
</div>

<div class="span-12 margin-t-x2 margin-b-x2">
    <span class="mg-headline">Zwinger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12">
        <x-zwinger-2-cols :zwinger=$zwinger />
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Zwingerschutzkarte</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12">
        @if (!$isZwingergemeinschaft)
            <x-verification
                text="Meine original Zwingerschutzkarte habe ich an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Ich erhalte im Gegenzug die VDH-Abmeldebestätigung für meinen Zwinger." />
        @else
            <x-verification
                text="Unsere original Zwingerschutzkarte haben wir an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Wir erhalten im Gegenzug die VDH-Abmeldebestätigung für unseren Zwinger." />
        @endif
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">{{!$isZwingergemeinschaft ? "Zwingerinhaber" : "Antragsteller"}}</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12">
        <x-person-2-cols :person=$person />
    </div>
</div>

@if ($isZwingergemeinschaft)
    @if (!empty($mitinhaber_list))
        <div class="span-12 margin-t-x4">
            <span class="mg-headline">Zwinger-Mitinhaber</span>
            <div class="mg-underline margin-b-x2"></div>

            @foreach ($mitinhaber_list as $index => $mitinhaber)
                <div
                    class="line span-12 padding-b {{ $index + 1 < count($mitinhaber_list) ? "border-b margin-b-x2" : null}} no-page-break-inside">
                    <div class="line span-12 margin-b">
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endif

<div class="span-12 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b"></div>
    <div class="line span-12">
        @if (!$isZwingergemeinschaft)
            <x-verification text="Hiermit bestätige ich die Richtigkeit aller oben gemachten Angaben." />
            <x-verification
                text="Mir ist bewusst, dass der von mir geschützte Zwingername an keine andere Person vergeben werden kann. Er bleibt somit nach der Löschung ungenutzt." />
            <x-verification
                text="Mir ist bewusst, dass ich durch die Löschung meines Zwingerschutzes meine Züchtereigenschaft verliere und unter dem bestehenden Zwingernamen zukünftig weder im DRC e.V. noch in einem anderen VDH-Zuchtverein züchten kann. Ich kann frühestens nach Ablauf von 5 Jahren nach Löschung meines Zwingers einen neuen Zwinger beantragen." />
        @else
            <x-verification text="Hiermit bestätigen wir die Richtigkeit aller oben gemachten Angaben." />
            <x-verification
                text="Uns ist bewusst, dass der von uns geschützte Zwingername an keine andere Person vergeben werden kann. Er bleibt somit nach der Löschung ungenutzt." />
            <x-verification
                text="Uns ist bewusst, dass wir durch die Löschung unseres Zwingerschutzes unsere Züchtereigenschaft verlieren und unter dem bestehenden Zwingernamen zukünftig weder im DRC e.V. noch in einem anderen VDH-Zuchtverein züchten können. Wir können frühestens nach Ablauf von 5 Jahren nach Löschung unseres Zwingers einen neuen Zwinger beantragen." />
        @endif
    </div>

    <div class="line span-12" style="margin: 7mm 0;">
        <div class="span-6">
            <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
            </p>
        </div>
        <div class="space-h"></div>

        <div class="span-6">
            <div class="span-6 margin-b">
                <p class="border-b wrap-pre-line copy">{{ $person->vorname }} {{ $person->nachname }}
                </p>
                <p class="amtstitel">Antragsteller</p>
            </div>

            @if ($isZwingergemeinschaft)
                @foreach ($mitinhaber_list as $mitinhaber)
                    <div class="span-6 margin-b">
                        <p class="border-b wrap-pre-line copy">
                            {{ $mitinhaber->vorname }}<!----> {{ $mitinhaber->nachname }}
                        </p>
                        <p class="amtstitel">Mitinhaber</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>