<x-key-info jsonString='[
  [
    [[{ "Ausrichter": "[Ausrichter]" }, { "Prüfungsdatum": "[dd.mm.yyyy]" }]],
    [[{ "Prüfungsort": "[Prüfungsort]" }]],
    [[{ "Hundeführer": "[Vorname des Hundeführers] [Nachname des Hundeführers]" }]]
  ],
  [
    [[{ "Name des Hundes": "[Komplettname des Hundes]" }, { "Wurfdatum": "[dd.mm.yyyy]" }]],
    [[{ "Rasse": "[Rasse]" }, { "ZB-Nr.": "[XXX XX000000/00]" }]],
    [[{ "Geschlecht": "[Geschlecht]" }, { "Chipnummer": "[000000000000000]" }]]
  ],
  [
    [[{ "Vater": "[Komplettname des Vaters]" }, { "ZB-Nr.": "[XXX XX000000/00]" }]],
    [[{ "Mutter": "[Komplettname der Mutter]" }, { "ZB-Nr.": "[XXX XX000000/00]" }]]
  ]
]
' class="margin-b-x3" />


<div class="line">
    <div class="inline-block">
        <div class="custom-spacer" style="height: 3.5cm"></div>
        <span class="subheadline">
            Die Arbeit des Hundes wurde auf einer mit <span class="underlined">[Wildtyp]</span>-Wildschweiß gelegten
            <span class="underlined">[XX]</span> Stunden-Übernachtfährte mit der Nummer <span
                class="underlined">[XX]</span>
            gezeigt.
        </span>
        @if ($richterbegleitung)
            <div class="line margin-t-x3 margin-b-x3 line-height-normal padding-t-x3">
                <div class="span-4 no-wrap line-height-normalr subheadline">
                    Der Hund wurde geprüft auf:
                </div>
                <div class="space-h"></div>
                <div class="span-2 extended line-height-normal subheadline">
                    <x-checkbox class="inline-block v-align-middle"></x-checkbox>
                    <span class="inline-block line-height-normal v-align-middle">Totverbeller</span>
                </div>
                <div class="span-2 extended line-height-normal subheadline">
                    <x-checkbox class="inline-block v-align-middle"></x-checkbox>
                    <span class="inline-block line-height-normal">Totverweiser</span>
                </div>
            </div>

        @endif

    </div>

</div>


<div class="pin-bottom">
    <x-success-info didSucceed={{true}} rating="[I. II. III] Preis"
        reasoning="Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis cupiditate omnis eum, quasi mollitia neque voluptas! Magni velit vel cupiditate." />
    <x-supervision-list pruefungsLeiterId="410" richterObmannId="212"></x-supervision-list>
</div>