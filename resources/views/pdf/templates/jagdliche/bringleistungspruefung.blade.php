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

        $roundedResult = $count > 0 ? (int) round($sum / $count) : '–';

        $creditStrings = array_map(function ($credit) {
            return $credit === -1 ? '–' : (string) $credit;
        }, $credits);

        $creditString = implode('/', $creditStrings) . ' (' . $sum . '/' . $count . ')';

        return [$creditString, $sum, $count, $roundedResult];
    }
}
?>


<x-key-info class="margin-b-x2"
    jsonString='[
  [
    [[{ "Prüfungsort": "{{ $bringleistungspruefung->pruefungsort }}" }, { "Prüfungsdatum": "{{ $bringleistungspruefung->pruefungsdatum }}" }]],
    [[{ "Hundeführer": "{{ $bringleistungspruefung->hundefuehrer }}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{ $bringleistungspruefung->hund->name }}" }, { "Wurfdatum": "{{ $bringleistungspruefung->hund->wurfdatum }}" }]],
    [[{ "Rasse": "{{ $bringleistungspruefung->hund->rasse }}" }, { "ZB-Nr.": "{{ $bringleistungspruefung->hund->zuchtbuchnummer }}" }]],
    [[{ "Geschlecht": "{{ $bringleistungspruefung->hund->geschlecht }}" }, { "Chipnummer": "{{ $bringleistungspruefung->hund->chipnummer }}" }]]
  ],
  [
    [[{ "Vater": "{{ $bringleistungspruefung->hund->vater->name }}" }, { "ZB-Nr.": "{{ $bringleistungspruefung->hund->vater->zuchtbuchnummer }}" }]],
    [[{ "Mutter": "{{ $bringleistungspruefung->hund->mutter->name }}" }, { "ZB-Nr.": "{{ $bringleistungspruefung->hund->mutter->zuchtbuchnummer }}" }]]
  ]
]
' />

<div class="line span-12 lime">
    <div class="span-3 extended red">
        <p class="copy-bold">Zusatzfächer (fakulativ)</p>
        <div class="block">
            <p class="inline-block copy-bold left yellow span-2 extended">
                {{ $bringleistungspruefung->zusatzfaecher->schleppentyp }}-Wildschleppe:</p>
            <div class="inline-block cyan span-1">
                <p class="inline-block copy-small left">Ja</p>
                <p class="copy-small right">Nein</p>
            </div>
        </div>
        <div class="inline-block v-align-middle span-1">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->zusatzfaecher->wald == 1" />
            <p class="inline-block copy-small v-align-bottom">Wald</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-middle span-2 extended">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->zusatzfaecher->feld == 1" />
            <p class="inline-block copy-small v-align-bottom">Feld</p>
        </div>
        <div class="inline-block v-align-middle">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->zusatzfaecher->m_200 == 1" />
            <p class="inline-block copy-small v-align-bottom">200m</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block v-align-middle span-2 extended margin-b">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->zusatzfaecher->m_300 == 1" />
            <p class="inline-block copy-small v-align-bottom">300m</p>
        </div>

        <div class="inline-block v-align-middle span-2 extended orange">
            <p class="inline-block copy-small v-align-bottom">Verhalten auf dem Stand</p>
        </div>
        <div class="inline-block cyan span-1">
            <x-checkbox class="inline-block copy-small text-align-l left" :crossed="$bringleistungspruefung->zusatzfaecher->verhalten_auf_dem_stand == 1" />
            <x-checkbox class="copy-small text-align-l right" :crossed="$bringleistungspruefung->zusatzfaecher->verhalten_auf_dem_stand == 0" />
        </div>

        <div class="inline-block v-align-middle span-2 extended orange">
            <p class="inline-block copy-small v-align-bottom">Leinenführigkeit</p>
        </div>
        <div class="inline-block cyan span-1">
            <x-checkbox class="inline-block copy-small text-align-l left" :crossed="$bringleistungspruefung->zusatzfaecher->leinenfuehrigkeit == 1" />
            <x-checkbox class="copy-small text-align-l right" :crossed="$bringleistungspruefung->zusatzfaecher->leinenfuehrigkeit == 0" />
        </div>

        <div class="inline-block v-align-middle span-2 extended orange">
            <p class="inline-block copy-small v-align-bottom">Folgen frei bei Fuß</p>
        </div>
        <div class="inline-block cyan span-1">
            <x-checkbox class="inline-block copy-small text-align-l left" :crossed="$bringleistungspruefung->zusatzfaecher->folgen_frei_bei_fuss == 1" />
            <x-checkbox class="copy-small text-align-l right" :crossed="$bringleistungspruefung->zusatzfaecher->folgen_frei_bei_fuss == 0" />
        </div>

        <div class="inline-block v-align-middle span-2 extended orange">
            <p class="inline-block copy-small v-align-bottom">Ablegen</p>
        </div>
        <div class="inline-block cyan span-1">
            <x-checkbox class="inline-block copy-small text-align-l left" :crossed="$bringleistungspruefung->zusatzfaecher->ablegen == 1" />
            <x-checkbox class="copy-small text-align-l right" :crossed="$bringleistungspruefung->zusatzfaecher->ablegen == 0" />
        </div>

        <p class="inline-block copy-bold left yellow span-2 extended">Schussfestigkeit</p>

        <p class="inline-block sectionheadline-small left yellow span-2 extended line-height-100">An Land:</p>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->an_land == 0" />
            <p class="inline-block copy-small v-align-bottom">Schußfest</p>
        </div>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->an_land == 1" />
            <p class="inline-block copy-small v-align-bottom">Leicht schußempfindlich</p>
        </div>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->an_land == 2" />
            <p class="inline-block copy-small v-align-bottom">Schußempfindlich</p>
        </div>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->an_land == 3" />
            <p class="inline-block copy-small v-align-bottom">Stark schußempfindlich</p>
        </div>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->an_land == 4" />
            <p class="inline-block copy-small v-align-bottom">Schußscheu</p>
        </div>

        <p class="inline-block sectionheadline-small left yellow span-2 extended">Am Wasser:</p>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->am_wasser == 0" />
            <p class="inline-block copy-small v-align-bottom">Schußfest</p>
        </div>
        <div class="block v-align-middle span-3">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$bringleistungspruefung->schussfestigkeit->am_wasser == 1" />
            <p class="inline-block copy-small v-align-bottom">Nicht schußfest</p>
        </div>
    </div>

    <div class="span-9 margin-b orange">
        <div class="">
            <table class="copy-small-bold">
                <tr>
                    <th class="border-all copy-bold text-align-l">Anlagefächer</th>
                    <th class="border-trb">Arbeits-<br>punkte</th>
                    <th class="border-trb">Fachwert-<br>ziffer</th>
                    <th class="border-trb">Wertungs-<br>punkte</th>
                    <th></th>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">1. Arbeitsfreude</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->arbeitsfreude }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->arbeitsfreude, 3) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">2. Nasengebrauch</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->nasengebrauch }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->nasengebrauch, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">3. Führigkeit</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->fuehrigkeit }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->fuehrigkeit, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">4. Wasserfreude</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->wasserfreude }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->wasserfreude, 3) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">5. Körperliche Härte</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->koerperliche_haerte }}</td>
                    <td class="border-rb">0</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->koerperliche_haerte, 0) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">6. Freie Verlorensuche</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->freie_verlorensuche }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->freie_verlorensuche, 3) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">7. Standruhe</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->standruhe }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->standruhe, 2) }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">8. Merken</td>
                    <td class="border-rb">{{ $bringleistungspruefung->anlagefaecher->merken }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->merken, 2) }}
                    </td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">
                        <p>9. Wasserarbeit</p>
                        <p class="inline-block copy-small margin-r v-align-top">b)</p>
                        <div class="inline-block copy-small text-align-l v-align-top">
                            <span>1. Stöbern mit Ente im deckungsreichen Gewässer</span>
                            <span class="block">
                                2.<x-checkbox class="margin-l inline-block" :crossed="$bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom != null" /> oder Stöbern mit
                                Ente lt. beil. Zeugnis vom
                                {{ $bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom ?? '–' }}
                            </span>
                        </div>
                    </td>
                    <td class="border-rb">
                        {{ $bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom != null ? $bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom[1] : $bringleistungspruefung->anlagefaecher->wasserarbeit->ente }}
                    </td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom != null ? $bringleistungspruefung->anlagefaecher->wasserarbeit->zeugnis_vom[1] : $bringleistungspruefung->anlagefaecher->wasserarbeit->ente, 3) }}
                    </td>
                    <td class="border-rb position-relative">
                        <div class="cell-label yellow">Summe Anlage-<br>fächer</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <th class="border-rbl copy-bold text-align-l">Abrichtefächer</th>
                    <th class="border-rb"></th>
                    <th class="border-rb"></th>
                    <th class="border-rb"></th>
                    <th></th>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">
                        <p>9. Wasserarbeit</p>
                        <p class="inline-block copy-small margin-r v-align-top">a)</p>
                        <div class="inline-block copy-small text-align-l v-align-top">
                            <span>1. Verlorensuche im deckungsreichen Gewässer</span>
                        </div>
                    </td>
                    <td class="border-rb">{{ $bringleistungspruefung->abrichtefaecher->wasserarbeit }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->abrichtefaecher->wasserarbeit, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">10. Einweisen auf 2 St. Federwild</td>
                    <td class="border-rb">
                        {{ $bringleistungspruefung->abrichtefaecher->einweisen_auf_2_stueck_federwild }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->abrichtefaecher->einweisen_auf_2_stueck_federwild, 2) }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">11.
                        {{ $bringleistungspruefung->zusatzfaecher->schleppentyp }}-Wildschleppe
                        {{ $bringleistungspruefung->zusatzfaecher->m_200 == 1 ? '200' : '300' }}m</td>
                    <td class="border-rb"></td>
                    <td class="border-rb">2</td>
                    <td class="border-rb"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">12. Art des Bringens</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td></td>
                </tr>
                <tr>
                    @php
                        $creditPoints = calcUtil::calculateCreditPoints(
                            $bringleistungspruefung->abrichtefaecher->art_des_bringens->hase_oder_kanin,
                        );
                    @endphp
                    <td class="border-rl copy-small text-align-l">
                        <span class="text-align-l">a) Hase oder Kanin</span>
                        <span class="copy-small-bold right">{{ $creditPoints[0] }}</span>
                    </td>
                    <td class="border-rb">{{ $creditPoints[3] }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($creditPoints[3], 1) }}</td>
                    <td></td>
                </tr>
                <tr>
                    @php
                        $creditPoints = calcUtil::calculateCreditPoints(
                            $bringleistungspruefung->abrichtefaecher->art_des_bringens->ente,
                        );
                    @endphp
                    <td class="border-rl copy-small text-align-l">
                        <span>a) Ente (Wasserarbeit)</span>
                        <span class="copy-small-bold right">{{ $creditPoints[0] }}</span>
                    </td>
                    <td class="border-rb">{{ $creditPoints[3] }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($creditPoints[3], 1) }}</td>
                    <td></td>
                </tr>
                <tr>
                    @php
                        $creditPoints = calcUtil::calculateCreditPoints(
                            $bringleistungspruefung->abrichtefaecher->art_des_bringens->federwild,
                        );
                    @endphp
                    <td class="border-rbl copy-small text-align-l"><span>a) Federwild</span>
                        <span class="copy-small-bold right">{{ $creditPoints[0] }}</span>
                    </td>
                    <td class="border-rb">{{ $creditPoints[3] }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($creditPoints[3], 1) }}</td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">13. Gehorsam</td>
                    <td class="border-rb">{{ $bringleistungspruefung->abrichtefaecher->gehorsam }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($bringleistungspruefung->abrichtefaecher->gehorsam, 1) }}</td>
                    <td class="border-rb position-relative">
                        <div class="cell-label">Summe Abrichte-<br>fächer</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <td class="border-r"></td>
                    <td class="border-b text-align-l" colspan=2>Gesamtpunktzahl:</td>
                    <td class="border-rb">{{ calcUtil::getSumOfSums() }}</td>
                    <td></td>
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
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->temperament[0]" />
                <p class="inline-block copy-small-bold">Teilnahms./phlegmat./o. jagdl. Motivation</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle no-wrap">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->selbstsicherheit[0]" />
                <p class="inline-block copy-small-bold">Selbstsicher/deutl. präs./selbstbewußt</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->vertraeglichkeit[0]" />
                <p class="inline-block copy-small-bold">Schußfest</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->sonstiges[0]" />
                <p class="inline-block copy-small-bold">Handscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->temperament[1]" />
                <p class="inline-block copy-small-bold">Ruhig/ausgeglichen</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->selbstsicherheit[1]" />
                <p class="inline-block copy-small-bold">Stabil/sicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->vertraeglichkeit[1]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Menschen</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->sonstiges[1]" />
                <p class="inline-block copy-small-bold">Wildscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->temperament[2]" />
                <p class="inline-block copy-small-bold">Lebhaft/temperamentvoll</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->selbstsicherheit[2]" />
                <p class="inline-block copy-small-bold">Schreckhaft/unsicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->vertraeglichkeit[2]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Artgenossen</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->temperament[3]" />
                <p class="inline-block copy-small-bold">Unruhig/überregt</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$bringleistungspruefung->wesens_und_verhaltensfeststellungen->selbstsicherheit[3]" />
                <p class="inline-block copy-small-bold">Ängstlich/stark unsicher</p>
            </div>
        </div>
    </div>
</div>

<div class="spaced-container">
    <div class="line">
        <div class="span-12">
            @if ($bringleistungspruefung->koerperliche_maengel)
                <p class="inline-block copy line-height-100">
                    <span class="copy-bold line-height-100">Körperliche Mängel:
                    </span>{{ $bringleistungspruefung->koerperliche_maengel }}
                </p>
            @endif
            @if ($bringleistungspruefung->bemerkungen)
                <p class="block copy line-height-100">
                    <span class="copy-bold line-height-100">Bemerkungen:
                    </span>{{ $bringleistungspruefung->bemerkungen }}
                </p>
            @endif
        </div>
    </div>
</div>

<div class="span-12">
    <div class="pin-bottom">
        <x-success-info :didSucceed="$bringleistungspruefung->bestanden" :reasoning="$bringleistungspruefung->begruendung" />
        <x-supervision-list :pruefungsLeiterId="$bringleistungspruefung->pruefungsleiter_id" :richterObmannId="$bringleistungspruefung->richterobmann_id" :richterIds="json_encode($bringleistungspruefung->richter_ids)"></x-supervision-list>
    </div>
</div>
