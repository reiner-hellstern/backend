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
}
?>

<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$tollerSilber->pruefungsort}}" }, { "Prüfungsdatum": "{{$tollerSilber->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$tollerSilber->hundefuehrer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$tollerSilber->hund->name}}" }, { "Wurfdatum": "{{$tollerSilber->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$tollerSilber->hund->rasse}}" }, { "ZB-Nr.": "{{$tollerSilber->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$tollerSilber->hund->geschlecht}}" }, { "Chipnummer": "{{$tollerSilber->hund->chipnummer}}" }]]
  ],
  [
    [[{ "Vater": "{{$tollerSilber->hund->vater->name}}" }, { "ZB-Nr.": "{{$tollerSilber->hund->vater->zuchtbuchnummer}}" }]],
    [[{ "Mutter": "{{$tollerSilber->hund->mutter->name}}" }, { "ZB-Nr.": "{{$tollerSilber->hund->mutter->zuchtbuchnummer}}" }]]
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
                    :crossed="$tollerSilber->werte->schussfestigkeit->an_land == 0" />
                <p class="inline-block copy-small v-align-bottom">Schußfest</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->an_land == 1" />
                <p class="inline-block copy-small v-align-bottom">Leicht schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->an_land == 2" />
                <p class="inline-block copy-small v-align-bottom">Schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->an_land == 3" />
                <p class="inline-block copy-small v-align-bottom">Stark schußempfindlich</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->an_land == 4" />
                <p class="inline-block copy-small v-align-bottom">Schußscheu</p>
            </div>

            <p class="inline-block sectionheadline-small left yellow span-2 extended">Am Wasser:</p>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->am_wasser == 0" />
                <p class="inline-block copy-small v-align-bottom">Schußfest</p>
            </div>
            <div class="block v-align-middle span-3">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$tollerSilber->werte->schussfestigkeit->am_wasser == 1" />
                <p class="inline-block copy-small v-align-bottom">Nicht schußfest</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-9 green">
            <table class="span-9 copy-small-bold yellow">
                <tr>
                    <th class="border-all copy-bold text-align-l">I. Tolling</th>
                    <th class="border-trb">Arbeits-<br>punkte</th>
                    <th class="border-trb">Fachwert-<br>ziffer</th>
                    <th class="border-trb">Wertungs-<br>punkte</th>
                    <th></th>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Anschleichen</td>
                    <td class="border-rb">{{$tollerSilber->werte->anschleichen}}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->anschleichen, 3) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Tolling</td>
                    <td class="border-rb">{{ $tollerSilber->werte->tolling }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->tolling, 3) }}</td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Passivität</td>
                    <td class="border-rb">{{ $tollerSilber->werte->passivitaet }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->passivitaet, 1) }}</td>
                    <td class="border-rb position-relative">
                        <div class="cell-label no-wrap">Summe<br>Fach-<br>gruppe I.</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl copy-bold text-align-l">II. Wasserarbeit</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Merken</td>
                    <td class="border-rb">{{ $tollerSilber->werte->merken }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->merken, 2) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Einweisen über Wasserfläche</td>
                    <td class="border-rb">{{ $tollerSilber->werte->einweisen_ueber_wasserflaeche }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->einweisen_ueber_wasserflaeche, 2) }}
                    </td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Bringen der Ente</td>
                    <td class="border-rb">{{ $tollerSilber->werte->bringen_der_ente }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->bringen_der_ente, 2) }}</td>
                    <td class="border-rb position-relative">
                        <div class="cell-label no-wrap">Summe<br>Fach-<br>gruppe II.</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl copy-bold text-align-l">III. Verlorenbringen/Einweisen an Land</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Suche auf 6 Stück ausgeworfenes Nutzwild</td>
                    <td class="border-rb">{{ $tollerSilber->werte->suche_auf_6_stueck_ausgeworfenes_nutzwild }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($tollerSilber->werte->suche_auf_6_stueck_ausgeworfenes_nutzwild, 3) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Einweisen auf 1 Stück Federnutzwild</td>
                    <td class="border-rb">{{ $tollerSilber->werte->einweisen_auf_1_stueck_federnutzwild }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">
                        {{ calcUtil::calcWP($tollerSilber->werte->einweisen_auf_1_stueck_federnutzwild, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Bringen von Federwild</td>
                    <td class="border-rb">{{ $tollerSilber->werte->bringen_von_federwild }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->bringen_von_federwild, 2) }}</td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Bringen von Haarwild</td>
                    <td class="border-rb">{{ $tollerSilber->werte->bringen_von_haarwild }}</td>
                    <td class="border-rb">2</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->bringen_von_haarwild, 2) }}</td>
                    <td class="border-rb position-relative">
                        <div class="cell-label no-wrap">Summe<br>Fach-<br>gruppe III.</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <td class="border-rbl copy-bold text-align-l">IV. Verlorenbringen/Einweisen an Land</td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                    <td class="border-rb"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Allgemeiner Gehorsam</td>
                    <td class="border-rb">{{ $tollerSilber->werte->allgemeiner_gehorsam }}</td>
                    <td class="border-rb">1</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->allgemeiner_gehorsam, 1) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Arbeitsfreude</td>
                    <td class="border-rb">{{ $tollerSilber->werte->arbeitsfreude }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->arbeitsfreude, 3) }}</td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Führigkeit/Zusammanarbeit</td>
                    <td class="border-rb">{{ $tollerSilber->werte->fuehrigkeit_zusammenarbeit }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->fuehrigkeit_zusammenarbeit, 3) }}
                    </td>
                    <td class="border-b"></td>
                </tr>
                <tr>
                    <td class="border-rbl text-align-l">Nasengebrauch</td>
                    <td class="border-rb">{{ $tollerSilber->werte->nasengebrauch }}</td>
                    <td class="border-rb">3</td>
                    <td class="border-rb">{{ calcUtil::calcWP($tollerSilber->werte->nasengebrauch, 3) }}</td>
                    <td class="border-rb position-relative">
                        <div class="cell-label no-wrap">Summe<br>Fach-<br>gruppe IV.</div>
                        {{ calcUtil::getCurrentSum() }}
                    </td>
                </tr>
                <tr>
                    <td class="border-r"></td>
                    <td class="border-b text-align-l" colspan=2>Gesamtpunktzahl:</td>
                    <td class="border-rb">{{ calcUtil::getSumOfSums() }}</td>
                </tr>
                <tr>
                    <td class="border-r"></td>
                    <td class="border-b text-align-l" colspan=2>Gesamturteil:</td>
                    <td class="border-rb">{{ $tollerSilber->werte->rating }}</td>
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
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->temperament[0]" />
                <p class="inline-block copy-small-bold">Teilnahms./phlegmat./o. jagdl. Motivation</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle no-wrap">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[0]" />
                <p class="inline-block copy-small-bold">Selbstsicher/deutl. präs./selbstbewußt</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[0]" />
                <p class="inline-block copy-small-bold">Schußfest</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->sonstiges[0]" />
                <p class="inline-block copy-small-bold">Handscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->temperament[1]" />
                <p class="inline-block copy-small-bold">Ruhig/ausgeglichen</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[1]" />
                <p class="inline-block copy-small-bold">Stabil/sicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[1]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Menschen</p>
            </div>
        </div>
        <div class="span-2 cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->sonstiges[1]" />
                <p class="inline-block copy-small-bold">Wildscheu</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->temperament[2]" />
                <p class="inline-block copy-small-bold">Lebhaft/temperamentvoll</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[2]" />
                <p class="inline-block copy-small-bold">Schreckhaft/unsicher</p>
            </div>
        </div>
        <div class="space-h"></div>
        <div class="span-3 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->vertraeglichkeit[2]" />
                <p class="inline-block copy-small-bold">Aggressiv gegen Artgenossen</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block">
        <div class="span-4 blue">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->temperament[3]" />
                <p class="inline-block copy-small-bold">Unruhig/überregt</p>
            </div>
        </div>
        <div class="span-3 extended cyan">
            <div class="inline-block v-align-middle">
                <x-checkbox class="inline-block"
                    :crossed="$tollerSilber->werte->wesens_und_verhaltensfeststellungen->selbstsicherheit[3]" />
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
                </span>{{ $tollerSilber->werte->koerperliche_maengel }}
            </p>
            <p class="block copy line-height-100">
                <span class="copy-bold line-height-100">Bemerkungen: </span>{{ $tollerSilber->werte->bemerkungen }}
            </p>
        </div>
    </div>
</div>


<div class="span-12">
    <div class="pin-bottom">
        <div class="line">
            <x-success-info :didSucceed="$tollerSilber->werte->pruefung_bestanden"
                sumOfCredits={{calcUtil::getSumOfSums()}}
                :rating="$tollerSilber->werte->rating ?? false"></x-success-info>
            <x-supervision-list :pruefungsLeiterId="$tollerSilber->werte->pruefungsleiter_id"
                :richterObmannId="$tollerSilber->werte->richterobmann_id"
                :richterIds='$tollerSilber->werte->richter_ids'></x-supervision-list>
        </div>
    </div>
</div>