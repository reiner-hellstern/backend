<?php

class calcUtil
{
    public static $wpCache = [];
    public static $sumCache = [];

    public static function getSumOfSums()
    {
        return array_sum(self::$sumCache);
    }

    public static function getCurrentSum()
    {
        Log::debug(self::$wpCache);
        $sum = array_sum(self::$wpCache);
        array_push(self::$sumCache, $sum);
        self::$wpCache = [];
        return $sum;
    }

    public static function calcWP($lz, $fwz)
    {
        $wp = $lz * $fwz;
        array_push(self::$wpCache, $wp);
        return $wp;
    }

    static function calculateCreditPoints(array $credits): array
    {
        $validCredits = array_filter($credits, function ($credit) {
            return $credit > -1;
        });

        $sum = array_sum($validCredits);
        $count = count($validCredits);

        $roundedResult = $count > 0 ? (int) round($sum / $count) : "–";

        $creditStrings = array_map(function ($credit) {
            return $credit === -1 ? '–' : (string) $credit;
        }, $credits);

        $creditString = implode('/', $creditStrings);

        return [$creditString, $sum, $count, $roundedResult];
    }
}
?>

<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$tollerBronze->pruefungsort}}" }, { "Prüfungsdatum": "{{$tollerBronze->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$tollerBronze->hundefuehrer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$tollerBronze->hund->name}}" }, { "Wurfdatum": "{{$tollerBronze->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$tollerBronze->hund->rasse}}" }, { "ZB-Nr.": "{{$tollerBronze->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$tollerBronze->hund->geschlecht}}" }, { "Chipnummer": "{{$tollerBronze->hund->chipnummer}}" }]]
  ],
  [
    [[{ "Vater": "{{$tollerBronze->hund->vater->name}}" }, { "ZB-Nr.": "{{$tollerBronze->hund->vater->zuchtbuchnummer}}" }]],
    [[{ "Mutter": "{{$tollerBronze->hund->mutter->name}}" }, { "ZB-Nr.": "{{$tollerBronze->hund->mutter->zuchtbuchnummer}}" }]]
  ]
]
' class="margin-b-x3" />

<div class="line span-12 cyan">
    <div class="inline-block">
        <div class="span-3 lime">
            <p class="inline-block copy-bold left yellow span-2 extended">Schussfestigkeit</p>

            <p class="inline-block sectionheadline-small left yellow span-2 extended line-height-100">An Land:</p>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->an_land == 0" />
                <p class="inline-block copy-small v-align-bottom">Schußfest</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->an_land == 1" />
                <p class="inline-block copy-small v-align-bottom">Leicht schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->an_land == 2" />
                <p class="inline-block copy-small v-align-bottom">Schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->an_land == 3" />
                <p class="inline-block copy-small v-align-bottom">Stark schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->an_land == 4" />
                <p class="inline-block copy-small v-align-bottom">Schußscheu</p>
            </div>

            <p class="inline-block sectionheadline-small left yellow span-2 extended">Am Wasser:</p>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->am_wasser == 0" />
                <p class="inline-block copy-small v-align-bottom">Schußfest</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerBronze->werte->schussfestigkeit->am_wasser == 1" />
                <p class="inline-block copy-small v-align-bottom">Nicht schußfest</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-8 green">
            <table class="span-8 copy-small-bold yellow">
                <tr>
                    <th class="border-all copy-bold text-align-l">I. Tolling</th>
                    <th class="border-trb">Arbeits-<br>punkte</th>
                    <th class="border-trb">Fachwert-<br>ziffer</th>
                    <th class="border-trb">Wertungs-<br>punkte</th>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Anschleichen</td>
                    <td class="border-rb">{{ $tollerBronze->werte->anschleichen }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->anschleichen, 2) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Tolling</td>
                    <td class="border-rb">{{ $tollerBronze->werte->tolling }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->tolling, 3) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl copy-bold text-align-l">II. Wasserarbeit und Verlorensuche</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Merken</td>
                    <td class="border-rb">{{ $tollerBronze->werte->merken }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->merken, 1) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Verlorensuche auf 3 Enten</td>
                    <td class="border-rb">{{ $tollerBronze->werte->verlorensuche_auf_3_enten }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->verlorensuche_auf_3_enten, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl copy-bold text-align-l">Allgemein</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                </tr>
                <tr>
                    @php
                        $creditPoints = calcUtil::calculateCreditPoints($tollerBronze->werte->bringen_der_ente)
                    @endphp
                    <td class="border-rbl text-align-r">
                        <span class="left">Bringen der Ente</span>
                        <span class="v-align-middle">{{ $creditPoints[0] }}
                            <span style="letter-spacing: 0;">
                                (
                                <span
                                    style="vertical-align: super; font-size: 1.5mm; line-height: 1mm; letter-spacing: -0.6mm;">{{ $creditPoints[1] }}</span>
                                <span class="copy v-align-middle"
                                    style="line-height: 100% !important; font-size: 3mm !important; letter-spacing: -0.6mm;">/</span>
                                <span
                                    style="vertical-align: bottom; font-size: 1.5mm; line-height: 1mm;">{{ $creditPoints[2] }}</span>
                                )
                            </span>
                        </span>
                    </td>
                    <td class="border-rb">
                        {{ $creditPoints[3] }}
                    </td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">
                        {{ $creditPoints[3] == "–" ? $creditPoints[3] : calcUtil::calcWP($creditPoints[3], 1) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Wasserfreude bzw. Wasserannahme</td>
                    <td class="border-rb">{{ $tollerBronze->werte->wasserfreude_bzw_wasserannahme }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($tollerBronze->werte->wasserfreude_bzw_wasserannahme, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Nasengebrauch</td>
                    <td class="border-rb">{{ $tollerBronze->werte->nasengebrauch }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->nasengebrauch, 2) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Arbeitsfreude</td>
                    <td class="border-rb">{{ $tollerBronze->werte->arbeitsfreude }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->arbeitsfreude, 2) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Selbstständigkeit</td>
                    <td class="border-rb">{{ $tollerBronze->werte->selbststaendigkeit }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->selbststaendigkeit, 2) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Zusammenarbeit/Führigkeit</td>
                    <td class="border-rb">{{ $tollerBronze->werte->zusammenarbeit_fuehrigkeit }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerBronze->werte->zusammenarbeit_fuehrigkeit, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-r"></td>
                    <td class="border-b text-align-l" colspan=2>Gesamtpunktzahl:</td>
                    <td class="border-rb">{{ calcUtil::getCurrentSum() }}</td>
                </tr>
                <tr>
                    <td class="border-r"></td>
                    <td class="border-b text-align-l" colspan=2>Gesamturteil:</td>
                    <td class="border-rb">{{ $tollerBronze->werte->rating }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <p class="copy-bold v-align-top line-height-100">Wesens- und Verhaltensfeststellungen</p>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <p class="sectionheadline-small v-align-top">Temperament:</p>
        </div>
        <div class="span-3 extended cyan">
            <p class="sectionheadline-small v-align-top">Selbstsicherheit:</p>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <p class="sectionheadline-small v-align-top">Verträglichkeit:</p>
        </div>
        <div class="span-2 cyan">
            <p class="sectionheadline-small v-align-top">Sonstiges:</p>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->temperament[0]" />
                <p class="inline-block copy-small-bold">Teilnahms./phlegmat./o. jagdl. Motivation</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle no-wrap">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[0]" />
                <p class="inline-block copy-small-bold">Selbstsicher/deutl. präs./selbstbewußt</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[0]" />
                <p class="inline-block copy-small-bold">Schußfest</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->sonstiges[0]" />
                <p class="inline-block copy-small-bold">Handscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->temperament[1]" />
                <p class="inline-block copy-small-bold">Ruhig/ausgeglichen</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[1]" />
                <p class="inline-block copy-small-bold">Stabil/sicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[1]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Menschen</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->sonstiges[1]" />
                <p class="inline-block copy-small-bold">Wildscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->temperament[2]" />
                <p class="inline-block copy-small-bold">Lebhaft/temperamentvoll</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[2]" />
                <p class="inline-block copy-small-bold">Schreckhaft/unsicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[2]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Artgenossen</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->temperament[3]" />
                <p class="inline-block copy-small-bold">Unruhig/überregt</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerBronze->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[3]" />
                <p class="inline-block copy-small-bold">Ängstlich/stark unsicher</p>
            </div>
        </div>
    </div>
</div>

<div class="spaced-container">
    <div class="line">
        <div class="span-12">
            <p class="inline-block copy line-height-100">
                <span class="copy-bold line-height-100">Körperliche Mängel:
                </span>{{ $tollerBronze->werte->koerperliche_maengel }}
            </p>
            <p class="block copy line-height-100">
                <span class="copy-bold line-height-100">Bemerkungen: </span>{{ $tollerBronze->werte->bemerkungen }}
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <div class="pin-bottom">
        <div class="line">
            <x-success-info :didSucceed="$tollerBronze->werte->pruefung_bestanden"
                sumOfCredits={{calcUtil::getSumOfSums()}}
                :rating="$tollerBronze->werte->rating ?? false"></x-success-info>
            <x-supervision-list :pruefungsLeiterId="$tollerBronze->werte->pruefungsleiter_id"
                :richterObmannId="$tollerBronze->werte->richterobmann_id"
                :richterIds='$tollerBronze->werte->richter_ids'></x-supervision-list>
        </div>
    </div>
</div>