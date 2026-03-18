<x-key-info class="margin-b-x3"
    jsonString='[
  [
    [[{ "Prüfungsort": "{{ $heraeus->pruefungsort }}" }, { "Prüfungsdatum": "{{ $heraeus->pruefungsdatum }}" }]],
    [[{ "Hundeführer": "{{ $heraeus->hundefuehrer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $heraeus->hund->name }}" }, { "Wurfdatum": "{{ $heraeus->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $heraeus->hund->rasse }}" }, { "ZB-Nr.": "{{ $heraeus->hund->zuchtbuchnummer }}" }]],
    [[{ "Geschlecht": "{{ $heraeus->hund->geschlecht }}" }, { "Chipnummer": "{{ $heraeus->hund->chipnummer }}" }]]
  ],
  [
    [[{ "Vater": "{{ $heraeus->hund->vater->name }}" }, { "ZB-Nr.": "{{ $heraeus->hund->vater->zuchtbuchnummer }}" }]],
    [[{ "Mutter": "{{ $heraeus->hund->mutter->name }}" }, { "ZB-Nr.": "{{ $heraeus->hund->mutter->zuchtbuchnummer }}" }]]
  ]
]
' />

<div class="line">
    <table class="span-12 copy-small-bold margin-b-x2">
        <tr class="span-7">
            <th class="border-all copy-bold text-align-l">Anlagefächer</th>
            <th class="border-trb copy-bold text-align-l">Prädikat</th>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">1. Haarwildschleppe</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->haarwildschleppe }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">2. Marking (Merken) auf dem Lande</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->marking_land }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">3. Einweisen auf 2 Stück Federwild</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->einweisen_2_stueck_federwild }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">4. Verlorensuche im deckungsreichen Gewässer</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->verlorensuche }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">5. Marking (Merken) auf dem Wasser</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->marking_wasser }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">6. Einweisen über ein Gewässer auf eine Schleppspur</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->einweisen_wasser }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">7. Standtreiben mit Verlorensuche</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->standtreiben_mit_verlorensuche }}</td>
        </tr>
        <tr class="copy-bold">
            <td class="border-rbl text-align-l">Gesamtprädikat</td>
            <td class="border-rb text-align-l">{{ $heraeus->anlagefaecher->gesamtpraedikat }}</td>
        </tr>
    </table>
</div>

{{-- <div class="span-12 border-b padding-b margin-b">
    <div class="text-box">
        <p class="copy wrap-pre-line"><span class="copy-bold">Bemerkungen:</span> <span class="underlined">[Text]</span>
            <span class="underlined">[Text]</span> <!-- TODO: Remove in production -->
            <span class="underlined">[Text]</span> <!-- TODO: Remove in production -->
        </p>
    </div>
</div> --}}

<div class="spaced-container padding-b margin-b">
    <div class="line">
        <div class="span-12">
            <span class="copy-bold">Körperliche Mängel:</span>
            <span class="copy underlined"> {{ $heraeus->koerperliche_maengel }}</span>
        </div>
    </div>

    <div class="span-12">
        <div class="text-box">
            <p class="line copy"><span class="copy-bold">Bemerkungen:</span>
                <span class="copy underlined"> {{ $heraeus->bemerkungen }}</span>
            </p>
        </div>
    </div>
</div>


<div class="span-12">
    <div class="pin-bottom">
        <x-success-info :didSucceed="$heraeus->bestanden" :rating="$heraeus->gesamturteil" :overallGrade="$heraeus->anlagefaecher->gesamtpraedikat" />
        <x-supervision-list :pruefungsLeiterId="$heraeus->pruefungsleiter_id" :richterObmannId="$heraeus->richterobmann_id" :richterIds="json_encode($heraeus->richter_ids)"></x-supervision-list>
    </div>
</div>
