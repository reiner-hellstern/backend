<?php

class calcUtil
{
    public static int $sum = 0;
    public static function add($value)
    {
        self::$sum = self::$sum + $value;
        return $value;
    }
    public static function getSum()
    {
        return self::$sum;
    }
}
?>

<x-key-info class="margin-b-x3"
    jsonString='[
  [
    [[{ "Prüfungsort": "{{ $arbeitspruefungMitDummies->pruefungsort }}" }, { "Prüfungsdatum": "{{ $arbeitspruefungMitDummies->pruefungsdatum }}" }]],
    [[{ "Hundeführer": "{{ $arbeitspruefungMitDummies->hundefuehrer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $arbeitspruefungMitDummies->hund->name }}" }, { "Wurfdatum": "{{ $arbeitspruefungMitDummies->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $arbeitspruefungMitDummies->hund->rasse }}" }, { "ZB-Nr.": "{{ $arbeitspruefungMitDummies->hund->zuchtbuchnummer }}" }]],
    [[{ "Geschlecht": "{{ $arbeitspruefungMitDummies->hund->geschlecht }}" }, { "Chipnummer": "{{ $arbeitspruefungMitDummies->hund->chipnummer }}" }]]
  ]
]
' />

<div class="span-12 margin-b-x2" style="margin-top: 21mm;">
    <div class="line span-12">
        <table>
            <tr>
                <th class="copy-bold text-align-l border-all line-height-100 span-6">Prüfungsfach</th>
                <th class="copy-bold border-trb line-height-100 span-3">Punkte</th>
                <th class="copy-bold border-trb line-height-100 span-3">Prädikat</th>
            </tr>
            <tr>
                <th class="copy-small-bold text-align-l line-height-100 border-rbl">1. Einzelmarkierung Land</th>
                <td class="copy-small-bold line-height-100 border-rb">
                    {{ calcUtil::add($arbeitspruefungMitDummies->beurteilung->einzelmarkierung_land) }}</td>
                <td class="copy-small-bold line-height-100 border-r"></td>
            </tr>
            <tr>
                <th class="copy-small-bold text-align-l line-height-100 border-rbl">2. Einzelmarkierung Wasser</th>
                <td class="copy-small-bold line-height-100 border-rb">
                    {{ calcUtil::add($arbeitspruefungMitDummies->beurteilung->einzelmarkierung_wasser) }}</td>
                <td class="copy-small-bold line-height-100 border-r"></td>
            </tr>
            <tr>
                <th class="copy-small-bold text-align-l line-height-100 border-rbl">3. Verlorensuche</th>
                <td class="copy-small-bold line-height-100 border-rb">
                    {{ calcUtil::add($arbeitspruefungMitDummies->beurteilung->verlorensuche) }}</td>
                <td class="copy-small-bold line-height-100 border-r"></td>
            </tr>
            <tr>
                <th class="copy-small-bold text-align-l line-height-100 border-rbl">4. Apell und Memory</th>
                <td class="copy-small-bold line-height-100 border-rb">
                    {{ calcUtil::add($arbeitspruefungMitDummies->beurteilung->apell_und_memory) }}</td>
                <td class="copy-small-bold line-height-100 border-rb"></td>
            </tr>
            <tr>
                <td class="copy-bold text-align-l border-rbl line-height-100 span-6">Gesamtergebnis</td>
                <td class="copy-bold border-rb line-height-100 span-3">{{ calcUtil::getSum() }}</td>
                <td class="copy-bold border-rb line-height-100 span-3">
                    {{ $arbeitspruefungMitDummies->beurteilung->praedikat }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="pin-bottom">
    <x-success-info :didSucceed="$arbeitspruefungMitDummies->beurteilung->bestanden" :sumOfCredits="calcUtil::getSum()" :reasoning="$arbeitspruefungMitDummies->beurteilung->begruendung" :overallGrade="$arbeitspruefungMitDummies->beurteilung->praedikat" />
    <x-supervision-list richterIds='[203, 206]'></x-supervision-list>
</div>
