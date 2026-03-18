<?php

class calcUtil
{
    public static $uzCache = [];
    public static $sumCache = [];

    public static function getSumOfSums()
    {
        return array_sum(self::$sumCache);
    }

    public static function getCurrentSum()
    {
        Log::debug(self::$uzCache);
        $sum = array_sum(self::$uzCache);
        array_push(self::$sumCache, $sum);
        self::$uzCache = [];
        return $sum;
    }

    public static function calcUZ($lz, $fwz)
    {
        $uz = $lz * $fwz;
        array_push(self::$uzCache, $uz);
        return $uz;
    }
}
?>

<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$rgp->pruefungsort}}" }, { "Prüfungsdatum": "{{$rgp->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$rgp->hundefuehrer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$rgp->hund->name}}" }, { "Wurfdatum": "{{$rgp->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$rgp->hund->rasse}}" }, { "ZB-Nr.": "{{$rgp->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$rgp->hund->geschlecht}}" }, { "Chipnummer": "{{$rgp->hund->chipnummer}}" }]]
  ],
  [
    [[{ "Vater": "{{$rgp->hund->vater->name}}" }, { "ZB-Nr.": "{{$rgp->hund->vater->zuchtbuchnummer}}" }]],
    [[{ "Mutter": "{{$rgp->hund->mutter->name}}" }, { "ZB-Nr.": "{{$rgp->hund->mutter->zuchtbuchnummer}}" }]]
  ]
]
' class="margin-b-x3" />

<div class="line padding-b-x2">
    <div class="span-12">
        <div class="span-6">
            <table class="span-6">
                <tr>
                    <th class="span-4 copy-bold border-all text-align-l line-height-100">I. Waldarbeit</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">LZ</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">FWZ</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">UZ</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Riemen als Übernachtfährte</td>
                    <td class="copy-small-bold border-rb line-height-100">{{$rgp->werte->waldarbeit->riemen}}</td>
                    <td class="copy-small-bold border-rb line-height-100">8</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->riemen, 8) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Totverbellen (zusätzlich,
                        Mindestl. – LZ 2)</td>
                    <td class="copy-small-bold border-rb line-height-100">{{$rgp->werte->waldarbeit->totverbellen}}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">1</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{calcUtil::calcUZ($rgp->werte->waldarbeit->totverbellen, 1)}}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Totverweiser (zusätzlich,
                        Mindestl. – LZ 2)</td>
                    <td class="copy-small-bold border-rb line-height-100">{{$rgp->werte->waldarbeit->totverweiser}}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{calcUtil::calcUZ($rgp->werte->waldarbeit->totverweiser, 2)}}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Hase- oder Kaninchenschleppe
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{$rgp->werte->waldarbeit->hase_oder_kaninchen}}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{calcUtil::calcUZ($rgp->werte->waldarbeit->hase_oder_kaninchen, 2)}}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Freie Verlorensuche von Nutzwild
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $rgp->werte->waldarbeit->freie_verlorensuche }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">4</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->freie_verlorensuche, 4) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Bringen</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->waldarbeit->bringen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->bringen, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Buschieren</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->waldarbeit->buschieren }}</td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->buschieren, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Fuchsschleppe (Wahlfach)</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->waldarbeit->fuchsschleppe }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->fuchsschleppe, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Bringen auf der Fuchsschleppe
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $rgp->werte->waldarbeit->bringen_auf_fuchsschleppe }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->waldarbeit->bringen_auf_fuchsschleppe, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan=3 class="copy-bold border-rbl text-align-r line-height-100">Summe Waldarbeit
                    </td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getCurrentSum() }}</td>
                </tr>

                <tr>
                    <th class="copy-bold border-all text-align-l line-height-100" colspan="4">II. Wasserarbeit</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Stöbern ohne Ente im
                        deckungsreichen Gewässer
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $rgp->werte->wasserarbeit->stoebern_ohne_ente }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->wasserarbeit->stoebern_ohne_ente, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Verlorensuche im deckungsreichen
                        Gewässer</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->wasserarbeit->verlorensuche }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->wasserarbeit->verlorensuche, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Stöbern mit Ente</td>
                    @if (!$rgp->werte->wasserarbeit->beiliegendes_zeugnis_vom)
                        <td class="copy-small-bold border-rb line-height-100">
                            {{ $rgp->werte->wasserarbeit->stoebern_mit_ente }}
                        </td>
                    @else
                        <td class="copy-small-bold border-rb line-height-100">/</td>
                    @endif
                    <td class="copy-small-bold border-rb line-height-100">4</td>
                    @if (!$rgp->werte->wasserarbeit->beiliegendes_zeugnis_vom)
                        <td class="copy-small-bold border-rb line-height-100">
                            {{  calcUtil::calcUZ($rgp->werte->wasserarbeit->stoebern_mit_ente, 4) }}
                        </td>
                    @else
                        <td class="copy-small-bold border-rb line-height-100">/</td>
                    @endif
                </tr>
                @if ($rgp->werte->wasserarbeit->beiliegendes_zeugnis_vom)
                    <tr>
                        <td class="copy-small-bold border-rbl text-align-l line-height-100">oder lt. beiliegendem Zeugnis
                            vom {{ $rgp->werte->wasserarbeit->beiliegendes_zeugnis_vom }}</td>
                        <td class="copy-small-bold border-rb line-height-100">
                            {{ $rgp->werte->wasserarbeit->stoebern_mit_ente }}
                        </td>
                        <td class="copy-small-bold border-rb line-height-100">3</td>
                        <td class="copy-small-bold border-rb line-height-100">
                            {{  calcUtil::calcUZ($rgp->werte->wasserarbeit->stoebern_mit_ente, 3) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Einweisen über ein Gewässer</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->wasserarbeit->einweisen }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">4</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->wasserarbeit->einweisen, 4) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Bringen von Ente</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->wasserarbeit->bringen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->wasserarbeit->bringen, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan=3 class="copy-bold border-rbl text-align-r line-height-100">Summe Wasserarbeit
                    </td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getCurrentSum() }}</td>
                </tr>
            </table>
        </div>
        <div class="space-h"></div>
        <div class="span-6">
            <table class="span-6">
                <tr class="span-6">
                    <th class="copy-bold border-all text-align-l line-height-100">III. Feldarbeit</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">LZ</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">FWZ</th>
                    <th class="copy-small-bold border-trb text-align-c line-height-100">UZ</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Federwildschleppe mit Einweisen
                        auf diese</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ $rgp->werte->feldarbeit->federwildschleppe }}
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->feldarbeit->federwildschleppe, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Einweisen</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->feldarbeit->einweisen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">4</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->feldarbeit->einweisen, 4) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Merken</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->feldarbeit->merken }}</td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->feldarbeit->merken, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Standruhe</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->feldarbeit->standruhe }}</td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->feldarbeit->standruhe, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Bringen von Federwild</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->feldarbeit->bringen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->feldarbeit->bringen, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan=3 class="copy-bold border-rbl text-align-r line-height-100">Summe Feldarbeit
                    </td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getCurrentSum() }}</td>
                </tr>

                <tr>
                    <th class="copy-bold border-all text-align-l line-height-100" colspan="4">IV. Gehorsam</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Allgemeines Verhalten – Gehorsam
                    </td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->gehorsam->allgemein }}</td>
                    <td class="copy-small-bold border-rb line-height-100">3</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->gehorsam->allgemein, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Verhalten auf dem Stand</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->gehorsam->verhalten }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->gehorsam->verhalten, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Leinenführigkeit</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->gehorsam->leine }}</td>
                    <td class="copy-small-bold border-rb line-height-100">1</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->gehorsam->leine, 1) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Folgen frei bei Fuß</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->gehorsam->folgen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->gehorsam->folgen, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Ablegen</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->gehorsam->ablegen }}</td>
                    <td class="copy-small-bold border-rb line-height-100">2</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->gehorsam->ablegen, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan=3 class="copy-bold border-rbl text-align-r line-height-100">Summe Gehorsam
                    </td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getCurrentSum() }}</td>
                </tr>
                <tr>
                    <th class="copy-bold border-all text-align-l line-height-100" colspan="4">V. Arbeitsfreude</th>
                </tr>
                <tr>
                    <td class="copy-small-bold border-rbl text-align-l line-height-100">Arbeitsfreude</td>
                    <td class="copy-small-bold border-rb line-height-100">{{ $rgp->werte->arbeitsfreude }}</td>
                    <td class="copy-small-bold border-rb line-height-100">4</td>
                    <td class="copy-small-bold border-rb line-height-100">
                        {{ calcUtil::calcUZ($rgp->werte->arbeitsfreude, 4) }}
                    </td>
                </tr>
                <tr class="unset">
                    <td colspan=3 class="copy-bold border-rbl text-align-r line-height-100">Summe Arbeitsfreude
                    </td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getCurrentSum() }}</td>
                </tr>
                <tr class="unset">
                    <td colspan=3 class="copy-bold border-bl text-align-l line-height-100">Gesamtpunktzahl:</td>
                    <td class="copy-bold border-rb line-height-100">{{ calcUtil::getSumOfSums() }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="line spaced-container border-t">
    <div class="span-12 inline-block">
        <div class="span-2 extended">
            <p class="copy-bold v-align-top line-height-100">Schussfestigkeit</p>
        </div>
    </div>
    <div class="span-12 red">
        <div class="span-3">
            <p class="sectionheadline-small v-align-top no-wrap line-height-100">Feld- oder Waldarbeit:</p>
        </div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$rgp->schussfestigkeit->feld_oder_waldarbeit == 0" />
            <p class="inline-block copy-small-bold v-align-bottom">Schußfest</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$rgp->schussfestigkeit->feld_oder_waldarbeit == 1" />
            <p class="inline-block copy-small-bold v-align-bottom">Leicht Schußempfindlich</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$rgp->schussfestigkeit->feld_oder_waldarbeit == 2" />
            <p class="inline-block copy-small-bold v-align-bottom">Schußempfindlich</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$rgp->schussfestigkeit->feld_oder_waldarbeit == 3" />
            <p class="inline-block copy-small-bold v-align-bottom">Stark schußempfindlich</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$rgp->schussfestigkeit->feld_oder_waldarbeit == 4" />
            <p class="inline-block copy-small-bold v-align-bottom">Schußscheu</p>
        </div>
    </div>
    <div class="span-12">
        <div class="span-3">
            <p class="sectionheadline-small v-align-top no-wrap">Wasserarbeit:</p>
        </div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$rgp->schussfestigkeit->wasserarbeit == 0" />
            <p class="inline-block copy-small-bold v-align-bottom">Schußfest</p>
        </div>
        <div class="space-h"></div>
        <div class="inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom" :crossed="$rgp->schussfestigkeit->wasserarbeit == 1" />
            <p class="inline-block copy-small-bold v-align-bottom">Nicht schußfest</p>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <p class="copy-bold v-align-top">Wesens- und Verhaltensfeststellungen</p>
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
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->temperament[0]" />
                <p class="inline-block copy-small-bold">Teilnahms./phlegmat./o. jagdl. Motivation</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle no-wrap">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->selbstsicherheit[0]" />
                <p class="inline-block copy-small-bold">Selbstsicher/deutl. präs./selbstbewußt</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->vertraeglichkeit[0]" />
                <p class="inline-block copy-small-bold">Schußfest</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->sonstiges[0]" />
                <p class="inline-block copy-small-bold">Handscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->temperament[1]" />
                <p class="inline-block copy-small-bold">Ruhig/ausgeglichen</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->selbstsicherheit[1]" />
                <p class="inline-block copy-small-bold">Stabil/sicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->vertraeglichkeit[1]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Menschen</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->sonstiges[1]" />
                <p class="inline-block copy-small-bold">Wildscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->temperament[2]" />
                <p class="inline-block copy-small-bold">Lebhaft/temperamentvoll</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->selbstsicherheit[2]" />
                <p class="inline-block copy-small-bold">Schreckhaft/unsicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->vertraeglichkeit[2]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Artgenossen</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block" :crossed="$rgp->wesens_und_verhaltensfeststellungen->temperament[3]" />
                <p class="inline-block copy-small-bold">Unruhig/überregt</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$rgp->wesens_und_verhaltensfeststellungen->selbstsicherheit[3]" />
                <p class="inline-block copy-small-bold">Ängstlich/stark unsicher</p>
            </div>
        </div>
    </div>
</div>

<div class="spaced-container">
    <div class="line">
        <div class="span-12">
            <p class="inline-block copy line-height-100">
                <span class="copy-bold line-height-100">Körperliche Mängel: </span>{{ $rgp->koerperliche_maengel }}
            </p>
            <p class="block copy line-height-100">
                <span class="copy-bold line-height-100">Bemerkungen: </span>{{ $rgp->bemerkungen }}
            </p>
        </div>
    </div>
</div>

<div class="span-12">
    <div class="pin-bottom" style="bottom: -8mm;">
        <x-success-info :didSucceed="$rgp->pruefung_bestanden" sumOfCredits={{calcUtil::getSumOfSums()}}
            :rating="$rgp->rating ?? false"></x-success-info>
        <div class="span-2" style="position: relative; top: -15mm; left: 56mm; height: 0; overflow: visible;">
            <div class="inline-block v-align-middle" style="position: relative;">
                <x-checkbox class="inline-block" :crossed="$rgp->werte->waldarbeit->fuchsschleppe > 0" />
                <p class="inline-block copy-small-bold">mit Fuchs</p>
            </div>
            <div class="inline-block v-align-middle" style="position: relative; top: -2mm">
                <x-checkbox class="inline-block" :crossed="$rgp->werte->waldarbeit->totverbellen >= 2" />
                <p class="inline-block copy-small-bold">Totverbeller</p>
            </div>
            <div class="inline-block v-align-middle" style="position: relative; top: -4mm">
                <x-checkbox class="inline-block" :crossed="$rgp->werte->waldarbeit->totverweiser >= 2" />
                <p class="inline-block copy-small-bold">Totverweiser</p>
            </div>
        </div>
        <x-supervision-list :pruefungsLeiterId="$rgp->pruefungsleiter_id" :richterObmannId="$rgp->richterobmann_id"
            :richterIds='$rgp->richter_ids'></x-supervision-list>
    </div>
</div>