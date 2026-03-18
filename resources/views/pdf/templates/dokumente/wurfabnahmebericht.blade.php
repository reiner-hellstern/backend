@use('App\Http\Controllers\templates\dokumente')
@use('App\Models')
@use('App\Utilities')
@use('Illuminate\Support\Facades\Log')

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Zwinger</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zwingername:</span>
                {{ $wurfabnahmebericht->zuchtstaette->zwingername }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $wurfabnahmebericht->zuchtstaette->adresse }}
            </p>
            @if (true /* TODO */)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $wurfabnahmebericht->zuchtstaette->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $wurfabnahmebericht->zuchtstaette->wohnort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $wurfabnahmebericht->zuchtstaette->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">FCI-Zwingernummer:</span>
                {{ $wurfabnahmebericht->zuchtstaette->fci_zwingernummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Zwingernummer:</span>
                {{ $wurfabnahmebericht->zuchtstaette->drc_zwingernummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $wurfabnahmebericht->zuchtstaette->telefonnummer_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $wurfabnahmebericht->zuchtstaette->email_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Zwinger-Website:</span>
                {{ $wurfabnahmebericht->zuchtstaette->zwinger_website }}
            </p>
        </div>
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Züchter</span>
    <div class="mg-underline margin-b-x2"></div>
    <div class="line">
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Name:</span>
                {{ $wurfabnahmebericht->zuechter[0]->name }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Straße und Nr.:</span>
                {{ $wurfabnahmebericht->zuechter[0]->adresse }}
            </p>
            @if (true /* TODO */)
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Adresszusatz:</span>
                    {{ $wurfabnahmebericht->zuechter[0]->adresszusatz }}
                </p>
            @endif
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Wohnort:</span>
                {{ $wurfabnahmebericht->zuechter[0]->wohnort }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Land:</span>
                {{ $wurfabnahmebericht->zuechter[0]->land }}
            </p>
        </div>
        <div class="space-h"></div>
        <div class="span-6 inline-block">
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">DRC-Mitgliedsnummer:</span>
                {{ $wurfabnahmebericht->zuechter[0]->drc_mitgliedsnummer }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Telefonnummer:</span>
                {{ $wurfabnahmebericht->zuechter[0]->telefonnummer_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">E-Mail:</span>
                {{ $wurfabnahmebericht->zuechter[0]->email_1 }}
            </p>
            <p class="copy line-height-100 ">
                <span class="line-height-100 copy-bold margin-r">Website:</span>
                {{ $wurfabnahmebericht->zuechter[0]->website_1 }}
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
                <span class="copy line-height-100 ">{{ $wurfabnahmebericht->elterntiere->art_der_zucht }}</span>
            </p>
        </div>

        <div class="span-12">
            <div class="span-12 border-b">
                <p class="copy-bold">Vater</p>
            </div>
            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    {{ $wurfabnahmebericht->elterntiere->vater->name }}
                </p>
            </div>
            <div class="span-4 inline-block">
                <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                    {{ $wurfabnahmebericht->elterntiere->vater->zuchtbuchnummer }}
                </p>
            </div>
        </div>

        <div class="span-12 margin-b-x2">
            <div class="span-12 border-b">
                <p class="copy-bold">Mutter</p>
            </div>
            <div class="span-8 inline-block">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Name:</span>
                    {{ $wurfabnahmebericht->elterntiere->mutter->name }}
                </p>
            </div>
            <div class="span-4 inline-block">
                <p class="copy line-height-100 "><span class="line-height-100 copy-bold margin-r">ZB-Nr.:</span>
                    {{ $wurfabnahmebericht->elterntiere->mutter->zuchtbuchnummer }}
                </p>
            </div>
        </div>

        <div class="span-12">
            <div class="span-12 inline-block">
                <x-checkbox class="inline-block v-align-middle" :crossed="$wurfabnahmebericht->elterntiere->chipnummer_entspricht_ahnentafel" />
                <p class="inline-block copy-bold v-align-baseline">
                    Chipnummer der Hündin entspricht der Angabe in der Ahnentafel.
                </p>
            </div>
            @if ($kaeuferVersion == false)
                <div class="span-12 inline-block">
                    <x-checkbox class="inline-block v-align-middle" :crossed="$wurfabnahmebericht->elterntiere->leihstellung" />
                    <p class="inline-block copy-bold v-align-baseline">
                        Es liegt eine Leihstellung vor.
                    </p>
                </div>
            @endif
        </div>
        @if ($kaeuferVersion == false)
            <div class="span-12">
                <p class="subheadline-bold">Anwesende Hunde bei der Wurfabnahme</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b">
                    </div>
                </div>

                <div class="span-6">
                    <p class="copy-bold line-height-100 ">
                        <span class="line-height-100 margin-r">Anzahl anwesende Hunde:</span>
                        <span class="underlined line-height-100 margin-r copy">
                            {{ $wurfabnahmebericht->elterntiere->anwesende_hunde->anzahl_hunde_inkl_welpen }}
                        </span>
                        inkl. Welpen
                    </p>
                </div>
                <div class="space-h"></div>
                <div class="span-6">
                    <p class="copy-bold line-height-100 ">
                        <span class="line-height-100 margin-r">Davon eigene Hunde:</span>
                        <span class="underlined line-height-100 margin-r copy">
                            {{ $wurfabnahmebericht->elterntiere->anwesende_hunde->davon_eigene_exkl_welpen }}
                        </span>
                        exkl. Welpen
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Wurf</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12">
            <div class="span-2 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wurfbuchstabe:</span>
                    {{ $wurfabnahmebericht->wurf->buchstabe }}
                </p>
            </div>
            <div class="span-7 border-b">
                <p class="copy line-height-100">{{ $wurfabnahmebericht->wurf->rasse }}</p>
            </div>
            <div class="space-h"></div>
            <div class="span-3">
                @if ($kaeuferVersion == false)
                    <p class="copy line-height-100 ">
                        {{ $wurfabnahmebericht->wurf->nth_wurf_der_huendin }}.
                        <span class="line-height-100 copy-bold margin-l">Wurf der Hündin</span>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-5">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Deckdatum:</span>
                    {{ $wurfabnahmebericht->wurf->deckdatum }}
                </p>
            </div>
            <div class="span-4 extended">
                <p class="copy line-height-100 ">
                    <span class="line-height-100 copy-bold margin-r">Wurfdatum:</span>
                    {{ $wurfabnahmebericht->wurf->wurfdatum }}
                </p>
            </div>
            <div class="space-h"></div>
            <div class="span-3">
                <p class="copy line-height-100">
                    <span class="line-height-100 copy-bold margin-r">Tragzeit:</span><span
                        class="underlined margin-r">{{ $wurfabnahmebericht->wurf->tragzeit }}</span> Tage
                </p>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-2 extended">
                <x-checkbox class="inline-block v-align-middle" :crossed="$wurfabnahmebericht->wurf->kaiserschnitt == true" />
                <p class="inline-block copy-bold v-align-baseline">
                    Kaiserschnitt
                </p>
            </div>
            <div class="span-10">
                @if ($kaeuferVersion == false)
                    <div class="span-3 extended">
                        <x-checkbox class="inline-block v-align-middle" :crossed="$wurfabnahmebericht->wurf->sonstige_ta_hilfe != null" />
                        <p class="inline-block copy-bold v-align-baseline">
                            Sonstige tierärztliche Hilfe:
                        </p>
                    </div>
                    <div class="span-7 inline-block border-b">
                        <p class="inline-block copy v-align-top line-height-100">
                            {{ $wurfabnahmebericht->wurf->sonstige_ta_hilfe }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($kaeuferVersion == false)
        <div class="line">
            <div class="span-12">
                <div class="textbox">
                    <span class="copy-bold margin-r">Tierarzt:</span>
                    <span class="copy margin underlined">
                        {{ $wurfabnahmebericht->wurf->tierarzt }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Wurfstärke</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12">
            <div class="span-3 extended inline-block">
                <p class="copy">
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->welpen_gesamt->rueden + $wurfabnahmebericht->wurfstaerke->welpen_gesamt->huendinnen }}</span>
                    <span class="copy-bold margin-r">Welpen gesamt</span>
                </p>
            </div>
            <div class="span-2 extended inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">davon</span>
                    <span class="underlined">{{ $wurfabnahmebericht->wurfstaerke->welpen_gesamt->rueden }}</span>
                    <span class="copy-bold margin-r">Rüden</span>
                </p>
            </div>
            <div class="span-3 inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">und</span>
                    <span class="underlined">{{ $wurfabnahmebericht->wurfstaerke->welpen_gesamt->huendinnen }}</span>
                    <span class="copy-bold margin-r">Hündinnen</span>
                </p>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-3 extended inline-block">
                <p class="copy">
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->totgeburten->rueden + $wurfabnahmebericht->wurfstaerke->totgeburten->huendinnen }}</span>
                    <span class="copy-bold margin-r">Totgeburten</span>
                </p>
            </div>
            <div class="span-2 extended inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">davon</span>
                    <span class="underlined">{{ $wurfabnahmebericht->wurfstaerke->totgeburten->rueden }}</span>
                    <span class="copy-bold margin-r">Rüden</span>
                </p>
            </div>
            <div class="span-3 inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">und</span>
                    <span class="underlined">{{ $wurfabnahmebericht->wurfstaerke->totgeburten->huendinnen }}</span>
                    <span class="copy-bold margin-r">Hündinnen</span>
                </p>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-3 extended inline-block">
                <p class="copy">
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verstorbene_welpen->rueden + $wurfabnahmebericht->wurfstaerke->verstorbene_welpen->huendinnen }}</span>
                    <span class="copy-bold margin-r">verstorbene Welpen</span>
                </p>
            </div>
            <div class="span-2 extended inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">davon</span>
                    <span class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verstorbene_welpen->rueden }}</span>
                    <span class="copy-bold margin-r">Rüden</span>
                </p>
            </div>
            <div class="span-3 inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">und</span>
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verstorbene_welpen->huendinnen }}</span>
                    <span class="copy-bold margin-r">Hündinnen</span>
                </p>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-3 extended inline-block">
                <p class="copy">
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verbleibende_welpen->rueden + $wurfabnahmebericht->wurfstaerke->verbleibende_welpen->huendinnen }}</span>
                    <span class="copy-bold margin-r">Verbleibende Welpen</span>
                </p>
            </div>
            <div class="span-2 extended inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">davon</span>
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verbleibende_welpen->rueden }}</span>
                    <span class="copy-bold margin-r">Rüden</span>
                </p>
            </div>
            <div class="span-3 inline-block">
                <p class="copy">
                    <span class="copy-bold margin-r">und</span>
                    <span
                        class="underlined">{{ $wurfabnahmebericht->wurfstaerke->verbleibende_welpen->huendinnen }}</span>
                    <span class="copy-bold margin-r">Hündinnen</span>
                </p>
            </div>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x2">
    <span class="mg-headline">Welpen-Ausgabe</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line">
        <div class="span-12">
            <div class="span-8 extended">
                <p class="copy-bold line-height-100">Welpen-Ausgabepreis inkl. Ahnentafel, EU-Heimtierausweis und
                    Microchip
                    je Welpe:
                </p>
            </div>

            <div class="span-2 text-align-right inline-block">
                <span
                    class="copy line-height-100 underlined">{{ number_format($wurfabnahmebericht->welpen_ausgabe->ausgabepreis, 2, ',', '.') }}</span>
                <span class="copy line-height-100 margin-l-x2">€</span>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            <div class="span-8 extended">
                <p class="copy-bold line-height-100">Rückerstattung für züchterisch notwendige gesundheitliche
                    Untersuchungen:
                </p>
            </div>

            <div class="span-2 text-align-right inline-block">
                <span
                    class="copy line-height-100 underlined">{{ number_format($wurfabnahmebericht->welpen_ausgabe->rueckerstattung, 2, ',', '.') }}</span>
                <span class="copy line-height-100 margin-l-x2">€</span>
            </div>
        </div>
    </div>
</div>

<div class="page-break"></div>

@php
    $table_data = Models\WurfabnahmeWelpe::with(['welpe', 'farbe', 'augen', 'gebiss', 'hoden'])
        ->where('wurfabnahme_id', 1)
        ->get()
        ->map(function ($item) use ($kaeuferVersion, $wurfabnahmebericht) {
            $include = $kaeuferVersion == true ? $wurfabnahmebericht->gekaufter_hund_id == $item->welpe->id : true;
            Log::info('INCLUE IS: ' . $include . ' and id is: ' . $item->welpe->id);
            return [
                'id' => $item->id,
                'geschlecht' => $item->welpe->geschlecht->name ?? '',
                'name' => $item->welpe->name ?? '',
                'zuchtbuchnummer' => $item->welpe->zuchtbuchnummer ?? '',
                'chipnummer' => $item->welpe->chipnummer ?? '',
                'farbe' => $item->farbe->name ?? '',
                'wurfgewicht' => $item->welpe->wurfgewicht ?? '',
                'zuchtausschliessende_fehler' => $item->zuchtausschliessende_fehler ?? '',

                'wurfabnahmegewicht' => $include == true ? $item->wurfabnahmegewicht ?? '' : '[////////////]',
                'augen' => $include == true ? $item->augen->name ?? '' : '[////////////]',
                'gebiss' => $include == true ? $item->gebiss->name ?? '' : '[////////////]',
                'zaehne' => $include == true ? $item->zaehne ?? '' : '[////////////]',
                'hoden' => $include == true ? $item->hoden->name ?? '' : '[////////////]',
                'bemerkung' => $include == true ? $item->bemerkung ?? '' : '[////////////]',
            ];
        })
        ->sortByDesc(function ($item) {
            return $item['geschlecht'] === 'Rüde' ? 1 : 0;
        })
        ->values()
        ->all();

    Log::info(print_r($table_data, true));

    $fields = [
        ['Geschlecht', 'geschlecht'],
        ['Name des Hundes', 'name'],
        ['ZB-Nummer', 'zuchtbuchnummer'],
        ['Farbe', 'farbe'],
        ['Wurfgewicht', 'wurfgewicht'],
        ['Zuchtaus-schließende Fehler', 'zuchtausschliessende_fehler'],
        ['Wurfabnahme-gewicht', 'wurfabnahmegewicht'],
        ['Augen', 'augen'],
        ['Gebiss', 'gebiss'],
        ['Zähne', 'zaehne'],
        ['Hoden', 'hoden'],
        ['Bemerkung', 'bemerkung'],
    ];

    // Überprüfen, ob eines der Welpen einen Eintrag bei Chipnummer hat.
    $hasChipnummer = collect($table_data)->contains(function ($item) {
        return is_array($item) && array_key_exists('chipnummer', $item) && !empty($item['chipnummer']);
    });

    if ($hasChipnummer) {
        Log::info('Chipnummer exists');
        array_splice($fields, 3, 0, [['Chipnummer', 'chipnummer']]);
    } else {
        Log::info('Chipnummer does not exist');

        //... Barcode-Liste generieren
    }

    // calculate cell height -> depending on 'chipnummer'
    $tableCellHeight = 178 / (count($fields) + 1) . 'mm;';

    // calculates how many tables are needed to display the data
    function calcSegmentSize($data)
    {
        $items = count($data);
        $maxSegmentSize = 9;
        $minSegmentSize = 4;

        if ($items <= $maxSegmentSize) {
            return $items;
        }

        $segments = ceil($items / $maxSegmentSize);
        $segmentSize = ceil($items / $segments);

        if ($segmentSize < $minSegmentSize) {
            $segmentSize = $minSegmentSize;
        }

        Log::info($segmentSize);
        return $segmentSize;
    }

    // calculate the segment size
    $segmentSize = calcSegmentSize($table_data);
    // $segmentSize = calcSegmentSize($dummyData);

    // split the data into arrays of the calculated length
    $tables = array_chunk($table_data, $segmentSize);
    Log::info($tables);
    // $tables = array_chunk($dummyData, $segmentSize);

    // loop over $tables and do the $pWidth-Calculation for every table and save it in there
    foreach ($tables as $key => $table) {
        $tables[$key]['pWidth'] = 209 / count($table);
    }
@endphp

@for ($tableIndex = 0; $tableIndex < count($tables); $tableIndex++)
    <!-- Add page break after every table -->
    <div class="page-break">
        <!-- Table to display dummy data in a vertical format -->
        <table class="vertical-table border-r-thick">
            <tr>
                <!-- Empty header cell for row labels -->
                <th class="border-r-thick"></th>
                <!-- Loop through dummy data to create header cells with index numbers -->
                @foreach ($tables[$tableIndex] as $rowIndex => $table_data)
                    @if ($rowIndex < count($tables[$tableIndex]) - 1)
                        <th class="table-cell border-t-thick border-r" style="height: {{ $tableCellHeight }}">
                            <p style="width: {{ $tables[$tableIndex]['pWidth'] }}mm">
                                {{ $tableIndex * (int) $segmentSize + (int) $rowIndex + 1 }}
                        </th>
                    @endif
                @endforeach
            </tr>

            <!-- Loop through each field to create rows -->
            @foreach ($fields as $fieldIndex => $field)
                <tr>
                    <!-- Row label cell -->
                    <td class="table-cell border-rl-thick border-b {{ $fieldIndex === 0 ? 'border-t-thick' : '' }} {{ $fieldIndex === count($fields) - 1 ? 'border-b-thick' : '' }}"
                        style="height: {{ $tableCellHeight }} width: 29mm; padding-left: 3mm;">
                        <p class="mg-small text-align-l" style="width: 24mm; word-wrap: break-word;">
                            {{ $field[0] }}
                        </p>
                    </td>
                    <!-- Loop through dummy data to create cells for each field -->
                    @foreach ($tables[$tableIndex] as $rowIndex => $table_data)
                        @if ($rowIndex < count($tables[$tableIndex]) - 1)
                            <td class="border-rb table-cell {{ $fieldIndex === count($fields) - 1 ? 'border-b-thick' : '' }} {{ $fieldIndex === 0 ? 'border-t-thick' : '' }}"
                                style="height: {{ $tableCellHeight }}">
                                <p class="copy-small"
                                    style="width: {{ $tables[$tableIndex]['pWidth'] }}mm; word-wrap: break-word;">
                                    {{ $tables[$tableIndex][$rowIndex][$field[1]] != null && $tables[$tableIndex][$rowIndex][$field[1]] != '' ? $tables[$tableIndex][$rowIndex][$field[1]] : '–' }}
                                </p>
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>

    </div>
@endfor



<!-- PAGE 3 -->

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Welpen-versorgung</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Entwurmung (nach Angabe des Züchters)</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    @if (isset($wurfabnahmebericht->welpen_versorgung->entwurmungen) &&
            count($wurfabnahmebericht->welpen_versorgung->entwurmungen) > 0)
        <table class="span-12">
            @foreach ($wurfabnahmebericht->welpen_versorgung->entwurmungen as $index => $ent)
                <tr>
                    <td class="text-align-l copy-bold line-height-100">{{ $index + 1 }}. Entwurmung am:
                    </td>
                    <td class="text-align-l copy line-height-100">{{ $ent[0] ?? '' }}</td>
                    <td class="text-align-l copy-bold line-height-100">am:</td>
                    <td class="text-align-l copy line-height-100">{{ $ent[1] ?? '' }}</td>
                    <td class="text-align-l copy-bold line-height-100">Tag, mit:</td>
                    <td class="text-align-l copy line-height-100">{{ $ent[2] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <div class="line margin-t margib-b">
        <div class="span-12">
            <p class="subheadline-bold">Impfung (nach Angabe des Züchters)</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>
    <div class="line">
        <div class="span-4 red">
            <p class="inline-block copy-bold v-align-top line-height-100">Geimpft am
                {{ $wurfabnahmebericht->welpen_versorgung->impfungen->geimpft ?? '' }} gegen:</p>
        </div>
        <div class="span-8 extended inline-block green">

            <div class="span-2 inline-block v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->staupe == true" />
                <p class="inline-block copy-small-bold v-align-bottom">Staupe</p>
            </div>
            <div class="space-h"></div>
            <div class="span-3 inline-block v-align-middle">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->parvovirose == true" />
                <p class="inline-block copy-small-bold v-align-bottom">Parvovirose</p>
            </div>

            <div class="space-h"></div>

            <div class="span-3 inline-block v-align-middle yellow">
                <p class="inline-block copy-small-bold v-align-bottom">Die Impfpässe der Welpen lagen vor:</p>
            </div>

            <div class="span-8 extended block v-align-middle cyan">
                <div class="span-2 inline-block v-align-middle">
                    <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->hepatitis_cc == true" />
                    <p class="inline-block copy-small-bold v-align-bottom">Hepatitis c.c</p>
                </div>
                <div class="space-h"></div>

                <div class="span-3 inline-block v-align-middle">
                    <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->zwingerhusten == true" />
                    <p class="inline-block copy-small-bold v-align-bottom">Zwingerhusten</p>
                </div>

                <div class="space-h"></div>

                <div class="span-1 inline-block v-align-middle">
                    <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->impfpaesse == true" />
                    <p class="inline-block copy-small-bold v-align-bottom">ja</p>
                </div>
                <div class="space-h"></div>
                <div class="span-2 inline-block v-align-middle">
                    <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->impfpaesse == false" />
                    <p class="inline-block copy-small-bold v-align-bottom">nein</p>
                </div>
            </div>

            <div class="span-8 extended block v-align-middle cyan">
                <div class="span-2 inline-block v-align-middle">
                    <x-checkbox class="inline-block v-align-bottom" :crossed="$wurfabnahmebericht->welpen_versorgung->impfungen->leptospirose == true" />
                    <p class="inline-block copy-small-bold v-align-bottom">Leptospirose</p>
                </div>
            </div>
        </div>
    </div>

    <div class="line margin-t margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Art der Welpenfütterung</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="text-box">
                <p class="copy span-12 border-b">{{ $wurfabnahmebericht->welpen_versorgung->welpen_fuetterung ?? '' }}
                </p>
            </div>
        </div>
    </div>
    @if ($kaeuferVersion == false)
        <div class="line margin-t margin-b">
            <div class="span-12">
                <p class="subheadline-bold">Anmerkung</p>
                <div class="span-12 border-b">
                    <div class="span-12 border-b"></div>
                </div>

                <div class="text-box">
                    <p class="copy span-12 border-b">{{ $wurfabnahmebericht->welpen_versorgung->anmerkung ?? '' }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Allgemeiner Eindruck</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Mutterhündin</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="text-box">
                <p class="copy span-12 border-b">{{ $wurfabnahmebericht->allgemeiner_eindruck->mutterhuendin ?? '' }}
                </p>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Welpen</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="text-box">
                <p class="copy span-12 border-b">{{ $wurfabnahmebericht->allgemeiner_eindruck->welpen ?? '' }}</p>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Bemerkung zur Aufzucht</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="text-box">
                <p class="copy span-12 border-b">
                    {{ $wurfabnahmebericht->allgemeiner_eindruck->bemerkung_zur_aufzucht ?? '' }}</p>
            </div>
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Zuchtstätte und Welpenaufzucht</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>

            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-2 copy-bold v-align-top line-height-100">Unterbringung:</p>
                    <p class="inline-block span-10 extended copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->zuchtstaette_und_welpenaufzucht->unterbringung ?? '' }}
                    </p>
                </div>
            </div>
            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-3 extended copy-bold v-align-top line-height-100">
                        Beschäftigungsmöglichkeiten:</p>
                    <p class="inline-block span-9 copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->zuchtstaette_und_welpenaufzucht->beschaeftigungsmoeglichkeiten ?? '' }}
                    </p>
                </div>
            </div>
            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-4 copy-bold v-align-top line-height-100">Welpenprägung durch den
                        Züchter:</p>
                    <p class="inline-block span-8 extended copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->zuchtstaette_und_welpenaufzucht->welpenpraegung ?? '' }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Sauberkeit</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Unterkunft:</p>
                    <div class="space-h"></div>
                    <p class="inline-block span-10 copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->sauberkeit->unterkunft ?? '' }}
                    </p>
                </div>
            </div>
            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Auslauf:</p>
                    <p class="inline-block span-11 copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->sauberkeit->auslauf ?? '' }}
                    </p>
                </div>
            </div>
            <div class="span-12 padding-t-x2 padding-b margin-b border-b">
                <div class="inline-block span-12">
                    <p class="inline-block span-2 copy-bold v-align-top line-height-100">Futtergeschirre:</p>
                    <p class="inline-block span-10 extended copy v-align-top line-height-100">
                        {{ $wurfabnahmebericht->allgemeiner_eindruck->sauberkeit->futtergeschirre ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="line span-12">
        <x-verification
            text="Die Verhältnisse der Zuchtstätte sind für die Aufzucht von zwei Würfen gleichzeitig geeignet."
            :checked="$wurfabnahmebericht->allgemeiner_eindruck->fuer_zwei_gleichzeitige_wuerfe_geeignet" />
        @if ($kaeuferVersion == false)
            <div class="span-12">
                <p class="copy-small">Info: "Gleichzeitig" bezieht sich in diesem Zusammenhang auf den Zeitraum
                    zwischen
                    Wurfdatum und Wurfabnahme.</p>
            </div>
        @endif
    </div>

</div>

<div class="page-break"></div>

<!-- PAGE 4 -->

<div class="span-12 margin-b-x4">
    <span class="mg-headline">Vorzunehmende Veränderungen</span>
    <div class="mg-underline margin-b-x2"></div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Neu festgestellte Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        <div class="span-12">
            @foreach ($wurfabnahmebericht->vorzunehmende_veraenderungen->neue_maengel as $mangel)
                @if ($loop->first)
                    <div class="inline-block span-12">
                        <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Festgestellt am:
                        </p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->festgestellt_am }}</p>
                        <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:
                        </p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->zuchtwart }}
                        </p>
                        <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">zu beheben bis:
                        </p>
                        <p class="inline-block copy v-align-top line-height-100">{{ $mangel->zu_beheben_bis }}</p>
                    </div>
                @endif
                <div class="span-12 margin-b" @class(['border-b' => $loop->last == false])>
                    <div class="inline-block span-12 padding-b-x2">
                        <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                        <p class="inline-block span-11 copy v-align-top line-height-100">
                            {{ $mangel->begruendung }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Offene Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        @foreach ($wurfabnahmebericht->vorzunehmende_veraenderungen->offene_maengel as $mangel)
            <div class="span-12 padding-b margin-b" @class(['border-b' => $loop->last == false])>
                <div class="span-12">
                    <div class="inline-block span-12">
                        <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Festgestellt am:</p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->festgestellt_am }}</p>
                        <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->zuchtwart }}
                        </p>
                        <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">zu beheben bis:</p>
                        <p class="inline-block copy v-align-top line-height-100">{{ $mangel->zu_beheben_bis }}</p>
                    </div>
                </div>
                <div class="span-12 padding-b-x2">
                    <div class="inline-block span-12">
                        <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                        <p class="inline-block span-11 copy v-align-top line-height-100">
                            {{ $mangel->begruendung }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="line margin-b">
        <div class="span-12">
            <p class="subheadline-bold">Behobene Zuchtstätten-Mängel</p>
            <div class="span-12 border-b">
                <div class="span-12 border-b"></div>
            </div>
        </div>
    </div>

    <div class="line">
        @foreach ($wurfabnahmebericht->vorzunehmende_veraenderungen->behobene_maengel as $mangel)
            <div class="span-12 padding-b margin-b" @class(['border-b' => $loop->last == false])>
                <div class="span-12">
                    <div class="inline-block span-12">
                        <p class="inline-block copy-bold margin-r-x2 v-align-top line-height-100">Kontrolliert am:</p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->freigabe_am }}
                        </p>
                        <p class="inline-block copy-bold margin-r-x2  v-align-top line-height-100">durch Zuchtwart:</p>
                        <p class="inline-block copy margin-r-x2 v-align-top line-height-100">
                            {{ $mangel->zuchtwart }}
                        </p>
                    </div>
                </div>
                <div class="span-12 padding-b-x2">
                    <div class="inline-block span-12">
                        <p class="inline-block span-1 extended copy-bold v-align-top line-height-100">Mangel:</p>
                        <p class="inline-block span-11 copy v-align-top line-height-100">
                            {{ $mangel->begruendung }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="span-12 margin-b-x2">
    @if ($kaeuferVersion == false)
        <span class="mg-headline">Bestätigungen</span>
        <div class="mg-underline margin-b-x2"></div>

        <div class="line margin-b-x2">
            <div class="inline-block span-12 red v-align-top">
                <div class="inline-block lime line-height-100 v-align-baseline">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" :checked="$wurfabnahmebericht->bestaetigungen->bericht_lag_vor" />
                </div>
                <div class="span-11 inline-block line-height-100">
                    <p class="inline copy-bold cyan line-height-100 v-align-baseline">Der Bericht über die
                        Zuchtstättenbesichtigung
                        lag vor.</p>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="inline-block span-12 red v-align-top">
                <div class="inline-block lime line-height-100 v-align-baseline">
                    <x-checkbox class="inline-block" style="transform: translateY(-100%);" :checked="$wurfabnahmebericht->bestaetigungen->haltung_entspricht_mindestanforderungen" />
                </div>
                <div class="span-11 inline-block line-height-100">
                    <p class="inline copy-bold cyan line-height-100 v-align-top">Die Haltung
                        aller in der
                        Zuchtstätte
                        gehaltenen
                        Hunde sowie die Aufzucht der Welpen entspricht mindestens
                        den bei der letzten Zuchtstättenbesichtigung vereinbarten Bedingungen.</p>
                </div>
            </div>
        </div>

        <div class="line margin-b-x2">
            <div class="inline-block span-12 red v-align-top">
                <div class="inline-block lime line-height-100 v-align-baseline">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" :checked="$wurfabnahmebericht->bestaetigungen->gelder_wurden_gezahlt" />
                </div>
                <div class="span-11 inline-block line-height-100">
                    <p class="inline copy-bold cyan line-height-100 v-align-baseline">Kilometer- und Tagesgeld für
                        die
                        Wurfabnahme
                        wurde vom Antragsteller an den Zuchtwart gezahlt.</p>
                </div>
            </div>
        </div>

        <div class="line margin-b-x4">
            <div class="inline-block span-12 red v-align-top">
                <div class="inline-block lime line-height-100 v-align-baseline">
                    <x-checkbox class="inline-block" style="transform: translateY(25%);" :checked="$wurfabnahmebericht->bestaetigungen->richtigkeit_aller_angaben" />
                </div>
                <div class="span-11 inline-block line-height-100">
                    <p class="inline copy-bold cyan line-height-100 v-align-baseline">Hiermit bestätige ich die
                        Richtigkeit
                        der oben
                        gemachten Angaben.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="line">
        <p class="mg-small" style="font-size: 9pt;">Die Wurfabnahme ist am
            {{ $wurfabnahmebericht->nth_lebenstag_der_wurfabnahme }}. Lebenstag erfolgt.
        </p>
    </div>
</div>

<div class="span-12" style="margin-top: 21mm;">
    <div class="span-6 left">
        <p class="border-b">{{ $wurfabnahmebericht->zuchtstaette->wohnort }}, den<!--
        --> {{ $wurfabnahmebericht->datum_der_wurfabnahme }}</p>
        <br>
    </div>
</div>

@if ($wurfabnahmebericht->zuchtwart_anwaerter != null)
    <div class="span-12" style="margin-top: 14mm;">
        <div class="span-6 left">
            <p class="amtstitel">Bei dieser Zuchtstättenbesichtigung war als Zuchtanwärter anwesend:</p>
        </div>
        <div class="span-6 right">
            <p class="border-b wrap-pre-line">{{ $wurfabnahmebericht->zuchtwart_anwaerter }}
            </p>
            <p class="amtstitel">Zuchtanwärter</p>
        </div>
    </div>
@endif

<div class="span-12" style="margin-top: 21mm;">
    <div class="span-6 left">
        <p class="border-b wrap-pre-line">{{ $wurfabnahmebericht->zuchtwart }}
        </p>
        <p class="amtstitel">Zuchtwart, {{ $wurfabnahmebericht->zuchtwart_vdh_verein }}</p>
    </div>
    <div class="span-6 right">
        @foreach ($wurfabnahmebericht->zuechter as $zuechter)
            <p class="border-b wrap-pre-line">{{ $zuechter->name }}
            </p>
            <p class="amtstitel">Züchter</p>
        @endforeach
    </div>
</div>
