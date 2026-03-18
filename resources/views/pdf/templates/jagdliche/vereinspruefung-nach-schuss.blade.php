<?php

class calcUtil
{
    public static int $sum = 0;
    public static function calcUZ($value, $fz)
    {
        $uz = $value * $fz;
        self::$sum += $uz;
        return $uz;
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
    [[{ "Prüfungsort": "{{ $pns->pruefungsort }}" }, { "Prüfungsdatum": "{{ $pns->pruefungsdatum }}" }]],
    [[{ "Hundeführer": "{{ $pns->hundefuehrer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $pns->hund->name }}" }, { "Wurfdatum": "{{ $pns->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $pns->hund->rasse }}" }, { "ZB-Nr.": "{{ $pns->hund->zuchtbuchnummer }}" }]],
    [[{ "Geschlecht": "{{ $pns->hund->geschlecht }}" }, { "Chipnummer": "{{ $pns->hund->chipnummer }}" }]]
  ],
  [
    [[{ "Vater": "{{ $pns->hund->vater->name }}" }, { "ZB-Nr.": "{{ $pns->hund->vater->zuchtbuchnummer }}" }]],
    [[{ "Mutter": "{{ $pns->hund->mutter->name }}" }, { "ZB-Nr.": "{{ $pns->hund->mutter->zuchtbuchnummer }}" }]]
  ]
]
' />

<div class="line">
    <table class="span-12 copy-small-bold margin-b-x2">
        <tr class="span-7">
            <th class="border-all copy-bold text-align-l">Prüfungsfach</th>
            <th class="border-trb copy-small-bold">Fachwertziffer</th>
            <th class="border-trb copy-small-bold">Leistungsziffer</th>
            <th class="border-trb copy-small-bold">Urteilsziffer</th>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">1. Schweißarbeit</td>
            <td class="border-rb">6</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->schweissarbeit }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->schweissarbeit, 6) }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">2. Verlorensuche – Wald</td>
            <td class="border-rb">4</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->verlorensuche_wald }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->verlorensuche_wald, 4) }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">3. Haarwildschleppe</td>
            <td class="border-rb">3</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->haarwildschleppe }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->haarwildschleppe, 3) }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">4. Einweisen im Feld – Markieren – Standruhe</td>
            <td class="border-rb">5</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->einweisen_feld_markieren_standruhe }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->einweisen_feld_markieren_standruhe, 5) }}
            </td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">5. Verlorensuche im Wasser</td>
            <td class="border-rb">4</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->verlorensuche_wasser }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->verlorensuche_wasser, 4) }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">6. Einweisen auf eine Schleppspur – Apport unter Ablenkung</td>
            <td class="border-rb">3</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->einweisen_schleppspur }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->einweisen_schleppspur, 3) }}</td>
        </tr>
        <tr>
            <td class="border-rbl text-align-l">7. Allgemeines Verhalten – Gehorsam</td>
            <td class="border-rb">3</td>
            <td class="border-rb">{{ $pns->pruefungsfaecher->allgemeines_verhalten_gehorsam }}</td>
            <td class="border-rb">{{ calcUtil::calcUZ($pns->pruefungsfaecher->allgemeines_verhalten_gehorsam, 3) }}
            </td>
        </tr>
        <tr class="copy-bold">
            <td class="border-bl padding-t-x2 padding-b-x2 text-align-l" colspan="3">
                Gesamtpunktzahl (Urteilsziffern)
            </td>
            <td class="border-rb">
                {{ calcUtil::getSum() }}
            </td>
        </tr>
    </table>
</div>
<div class="span-12 border-b padding-b margin-b">
    <div class="text-box">
        <p class="copy wrap-pre-line"><span class="copy-bold">Bemerkungen:</span> <span
                class="copy underlined">{{ $pns->bemerkungen }}</span>
        </p>
    </div>
</div>

<div class="pin-bottom">
    <x-success-info :didSucceed="$pns->bestanden" :sumOfCredits="calcUtil::getSum()" />
    <x-supervision-list :pruefungsLeiterId="$pns->pruefungsleiter_id" :richterObmannId="$pns->richterobmann_id" :richterIds="json_encode($pns->richter_ids)"></x-supervision-list>
</div>
