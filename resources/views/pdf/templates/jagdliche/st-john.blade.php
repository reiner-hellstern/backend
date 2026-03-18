<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$srp->pruefungsort}}" }, { "Prüfungsdatum": "{{$srp->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$srp->hundefuehrer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$srp->hund->name}}" }, { "Wurfdatum": "{{$srp->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$srp->hund->rasse}}" }, { "ZB-Nr.": "{{$srp->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$srp->hund->geschlecht}}" }, { "Chipnummer": "{{$srp->hund->chipnummer}}" }]]
  ],
  [
    [[{ "Vater": "{{$srp->hund->vater->name}}" }, { "ZB-Nr.": "{{$srp->hund->vater->zuchtbuchnummer}}" }]],
    [[{ "Mutter": "{{$srp->hund->mutter->name}}" }, { "ZB-Nr.": "{{$srp->hund->mutter->zuchtbuchnummer}}" }]]
  ]
]
' class="margin-b-x3" />

<div class="line">
    <table class="span-12 copy-small-bold margin-b-x2">
        <tr>
            <th class="span-1 short border-tbl copy-bold"></th>
            <th class="span-7 extended border-trb copy-bold text-align-l">Prüfungsfach</th>
            <th class="span-4 border-trb copy-bold">Prädikat</th>
            <!-- <th class="span-3 border-trb copy-bold">Punkte</th> -->
        </tr>

        @php
            $lookup = [
                10 => "vorzüglich",
                9 => "vorzüglich",
                8 => "sehr gut",
                7 => "sehr gut",
                6 => "gut",
                5 => "gut",
                4 => "nicht ausreichend",
                3 => "nicht ausreichend",
                2 => "nicht ausreichend",
                1 => "nicht ausreichend",
                0 => "nicht ausreichend"
            ];
            $sum = 0;
        @endphp

        @foreach ($srp->werte->pruefungsfaecher as $index => $pruefungsfaecher)
            <tr>
                <td class="border-bl">{{ $index + 1 }}.</td>
                <td class="border-rb text-align-l">{{ $pruefungsfaecher[0] }}</td>
                <td class="border-rb">{{ $lookup[$pruefungsfaecher[1]] }}</td>
                {{--
                <td class="border-rb">{{ $pruefungsfaecher[1] }}</td>
                --}}
            </tr>
            {{-- @php
            $sum += $pruefungsfaecher[1];
            @endphp --}}
        @endforeach


        <tr class="copy-bold">
            <td colspan="2" class="border-bl padding-t-x2 padding-b-x2 text-align-r">
                Gesamtprädikat:
            </td>
            <td class="border-b">
                {{ $srp->werte->gesamtpraedikat }}
            </td>
            {{-- <td class="border-rb">
                {{ $sum}}
            </td> --}}
        </tr>
    </table>
</div>
<div class="span-12 border-b padding-b margin-b">
    <div class="text-box">
        <p class="copy"><span class="copy-bold">Bemerkungen:</span> {{ $srp->bemerkungen }}
        </p>
    </div>
</div>

<div class="pin-bottom">
    <x-success-info :didSucceed="$srp->pruefung_bestanden" :sumOfCredits="$sum"
        :overallGrade="$srp->werte->gesamtpraedikat" />
    <x-supervision-list :pruefungsLeiterId="$srp->pruefungsleiter_id" :richterObmannId="$srp->richterobmann_id"
        :richterIds="$srp->richter_ids"></x-supervision-list>
</div>