@use('App\Http\Controllers\Utils\RandomDBEntries')
@use('App\Http\Controllers\Utils\DateFormatter')
@use('App\Utilities\Math')

@php
    $person = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty', 'zwinger_id' => 'notEmpty']);
    $mitinhaber1 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber2 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber3 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);
    $mitinhaber4 = RandomDBEntries::RandomPerson(['eintrittsdatum' => 'notNull', 'telefon_1' => 'notEmpty', 'email_1' => 'notEmpty',]);

    $inhaber_list = [
        $person,
        //        $mitinhaber1,
        //        $mitinhaber2,
        //        $mitinhaber3
    ];

@endphp



<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Zwinger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line padding-b span-12 margin-b">
        @php
            $zwinger = $person->zwinger;
        @endphp
        <x-zwinger-2-cols :zwinger=$zwinger />
    </div>
</div>

<div class="span-12 margin-t-x4 margin-b-x4">
    <span class="mg-headline">Aktuelle Kontaktdaten</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line padding-b span-12 margin-b">
        @php
            $zwinger = $person->zwinger;

            // Update the zwinger data with the new values
            $disableEmail = empty($zwingerNeu->email_1);
            $disableTelefon = empty($zwingerNeu->telefon_1);
            $disableWebsite = empty($zwingerNeu->website_1);

            if (!$disableEmail) {
                $zwinger->email_1 = $zwingerNeu->email_1;
            }
            if (!$disableTelefon) {
                $zwinger->telefon_1 = $zwingerNeu->telefon_1;
            }
            if (!$disableWebsite) {
                $zwinger->website_1 = $zwingerNeu->website_1;
            }
        @endphp
        <x-zwinger-2-cols :zwinger=$zwinger disableTelefonnummer={{$disableTelefon}} disableWebsite={{$disableWebsite}}
            disableEmail={{$disableEmail}} disableZwingername disableAdresse disableOrt disablePLZ disableCO disableLand
            disableFCIZwingernummer disableDRCZwingernummer />
    </div>
</div>

@if (count($inhaber_list) > 1)
    <div class="span-12 margin-t-x4 margin-b-x4">
        <span class="mg-headline">Zwinger-Inhaber</span>
        <div class="mg-underline margin-b-x2"></div>

        @foreach ($inhaber_list as $index => $mitinhaber)
            <div
                class="line span-12 padding-b {{ $index + 1 < count($inhaber_list) ? "border-b margin-b-x2" : null}} no-page-break-inside">
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

<div class="span-12 padding-t-x2 margin-b-x2 no-page-break-inside">
    <span class="mg-headline">Bestätigungen</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line span-12">
        @if(count($inhaber_list) > 1)
            <x-verification text="Hiermit bestätigen wir, die Richtigkeit aller oben gemachten Angaben." />
        @else
            <x-verification text="Hiermit bestätige ich, die Richtigkeit aller oben gemachten Angaben." />
        @endif
    </div>

    <div class="line span-12" style="margin-top: 7mm;">
        <div class="span-6">
            <p class="border-b wrap-pre-line copy">{{ $person->ort }}, den {{ DateFormatter::formatDMY(now()) }}
            </p>
        </div>
        <div class="space-h"></div>

        <div class="span-6">
            @foreach ($inhaber_list as $index => $mitinhaber)
                <div class="span-6 {{ $index + 1 < count($inhaber_list) ? "margin-b" : "green"}}">
                    <p class="border-b copy">
                        {{ $mitinhaber->vorname }}<!----> {{ $mitinhaber->nachname }}
                    </p>
                    <p class="amtstitel">Inhaber</p>
                </div>
            @endforeach
        </div>
    </div>

</div>