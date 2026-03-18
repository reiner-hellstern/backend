@section("Page 1")
<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$formwertbeurteilung->pruefungsort}}" }, { "Prüfungsdatum": "{{$formwertbeurteilung->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$formwertbeurteilung->hundefuehrer}}" }, { "Startnummer": "{{$formwertbeurteilung->startnummer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$formwertbeurteilung->hund->name}}" }, { "Wurfdatum": "{{$formwertbeurteilung->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$formwertbeurteilung->hund->rasse}}, Farbe: {{$formwertbeurteilung->hund->farbe}}" }, { "ZB-Nr.": "{{$formwertbeurteilung->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$formwertbeurteilung->hund->geschlecht}}" }, { "Chipnummer": "{{$formwertbeurteilung->hund->chipnummer}}" }]]
  ]
]
' class="margin-b-x3" />

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Beurteilung</span>
    <div class="mg-underline"></div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Schulterhöhe:</p>
        </div>
        <div class="span-2 inline-block extended v-align-middle">
            <p class="inline-block copy v-align-bottom line-height-100">
                {{ $formwertbeurteilung->beurteilung->schulterhoehe }} cm
            </p>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Gebiss:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gebiss->komplett" />
                <p class="inline-block copy-small-bold v-align-bottom">komplett</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gebiss->schere" />
                <p class="inline-block copy-small-bold v-align-bottom">Schere</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gebiss->zange" />
                <p class="inline-block copy-small-bold v-align-bottom">Zange</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gebiss->vorbiss" />
                <p class="inline-block copy-small-bold v-align-bottom">Vorbiss</p>
            </div>
            <div class="span-2 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gebiss->rueckbiss" />
                <p class="inline-block copy-small-bold v-align-bottom">Rückbiss</p>
            </div>
        </div>
    </div>
    <div class="span-12 inline-block no-wrap">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Zähne:</p>
        </div>
        <div class="span-9 red">
            <div class="span-3 extended inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$formwertbeurteilung->beurteilung->zaehne->fehlende != null" />
                <p class="inline-block copy-small-bold v-align-bottom line-height-100">fehlende: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->zaehne->fehlende ?? "–" }}</span></p>
            </div>
            <div class="space-h"></div>
            <div class="span-4 extended inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom" :crossed="$formwertbeurteilung->beurteilung->zaehne->ueberzaehlige != null" />
                <p class="inline-block copy-small-bold v-align-bottom line-height-100">überzählige: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->zaehne->ueberzaehlige ?? "–" }}</span></p>
            </div>
        </div>
    </div>
</div>
<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Kopf insgesamt:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kopf_insgesamt->typisch" />
                <p class="inline-block copy-small-bold v-align-bottom">typisch</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kopf_insgesamt->zu_leicht" />
                <p class="inline-block copy-small-bold v-align-bottom">zu leicht</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kopf_insgesamt->leicht" />
                <p class="inline-block copy-small-bold v-align-bottom">leicht</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kopf_insgesamt->kraeftig" />
                <p class="inline-block copy-small-bold v-align-bottom">kräftig</p>
            </div>
            <div class="span-2 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kopf_insgesamt->nicht_typisch" />
                <p class="inline-block copy-small-bold v-align-bottom">nicht typisch</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Oberkopf:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->breit" />
                <p class="inline-block copy-small-bold v-align-bottom">breit</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->mittel" />
                <p class="inline-block copy-small-bold v-align-bottom">mittel</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->schmal" />
                <p class="inline-block copy-small-bold v-align-bottom">schmal</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->flach" />
                <p class="inline-block copy-small-bold v-align-bottom">flach</p>
            </div>
            <div class="span-2 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->gewoelbt" />
                <p class="inline-block copy-small-bold v-align-bottom">gewölbt</p>
            </div>
            <div class="span-2 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->stark_gewoelbt" />
                <p class="inline-block copy-small-bold v-align-bottom">stark gewölbt</p>
            </div>
            <div class="span-3 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberkopf->starkes_hinterhauptbein" />
                <p class="inline-block copy-small-bold v-align-bottom">starkes Hinterhauptbein</p>
            </div>
        </div>
    </div>
</div>
<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Fang:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->fang->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->fang->spitz" />
                <p class="inline-block copy-small-bold v-align-bottom">spitz</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->fang->kurz" />
                <p class="inline-block copy-small-bold v-align-bottom">kurz</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->fang->zu_lang" />
                <p class="inline-block copy-small-bold v-align-bottom">zu lang</p>
            </div>
            <div class="span-9 inline-block v-align-middle yellow">
                <p class="inline-block copy-small-bold v-align-bottom">Sonstiges: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->fang->sonstiges != null || $formwertbeurteilung->beurteilung->fang->sonstiges != '' ? $formwertbeurteilung->beurteilung->fang->sonstiges : '–' }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Stop:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->stop->gering" />
                <p class="inline-block copy-small-bold v-align-bottom">gering</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->stop->maessig" />
                <p class="inline-block copy-small-bold v-align-bottom">mäßig</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->stop->gut" />
                <p class="inline-block copy-small-bold v-align-bottom">gut</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->stop->stark" />
                <p class="inline-block copy-small-bold v-align-bottom">stark</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->stop->zu_stark" />
                <p class="inline-block copy-small-bold v-align-bottom">zu stark</p>
            </div>
        </div>
    </div>
</div>
<div class="line spaced-container">
    <div class="span-12 inline-block margin-b">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Pigment:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pigment->stark" />
                <p class="inline-block copy-small-bold v-align-bottom">stark</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pigment->rassetypisch" />
                <p class="inline-block copy-small-bold v-align-bottom">rassetypisch</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pigment->schwach" />
                <p class="inline-block copy-small-bold v-align-bottom">schwach</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Auge:</p>
            <div class="span-1">
                <p class="copy-small-bold v-align-top line-height-100">Form:</p>
                <p class="copy-small-bold v-align-top line-height-100">Farbe:</p>
            </div>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->auge->form->gross" />
                <p class="inline-block copy-small-bold v-align-bottom">groß</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->auge->form->mittelgross" />
                <p class="inline-block copy-small-bold v-align-bottom">mittelgroß</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->auge->form->klein" />
                <p class="inline-block copy-small-bold v-align-bottom">klein</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->auge->form->rund" />
                <p class="inline-block copy-small-bold v-align-bottom">rund</p>
            </div>
            <div class="span-9">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->auge->farbe->hell" />
                    <p class="inline-block copy-small-bold v-align-bottom">hell</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->auge->farbe->mittel" />
                    <p class="inline-block copy-small-bold v-align-bottom">mittel</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->auge->farbe->dunkel" />
                    <p class="inline-block copy-small-bold v-align-bottom">dunkel</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Ausdruck:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ausdruck->sanft" />
                <p class="inline-block copy-small-bold v-align-bottom">sanft</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ausdruck->hart" />
                <p class="inline-block copy-small-bold v-align-bottom">hart</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ausdruck->typisch" />
                <p class="inline-block copy-small-bold v-align-bottom">typisch</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Oberlefzen:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberlefzen->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberlefzen->knapp" />
                <p class="inline-block copy-small-bold v-align-bottom">knapp</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->oberlefzen->reichlich" />
                <p class="inline-block copy-small-bold v-align-bottom">reichlich</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Unterlefzen:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->unterlefzen->trocken" />
                <p class="inline-block copy-small-bold v-align-bottom">trocken</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->unterlefzen->offene_taschen" />
                <p class="inline-block copy-small-bold v-align-bottom">offene Taschen</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Behänge:</p>
        </div>
        <div class="span-9 red">
            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->zu_tief" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu tief</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->zu_hoch_angesetzt" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu hoch angesetzt</p>
                </div>
            </div>

            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->zu_gross" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu groß</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->normal" />
                    <p class="inline-block copy-small-bold v-align-bottom">normal</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->behaenge->klein" />
                    <p class="inline-block copy-small-bold v-align-bottom">klein</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Hals:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hals->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hals->trocken" />
                <p class="inline-block copy-small-bold v-align-bottom">trocken</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hals->zu_lang" />
                <p class="inline-block copy-small-bold v-align-bottom">zu lang</p>
            </div>
            <div class="span-2 inline-block v-align-middle lime">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hals->zu_kurz" />
                <p class="inline-block copy-small-bold v-align-bottom">zu kurz</p>
            </div>
            <div class="span-2 inline-block v-align-middle yellow">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hals->lose_kehlhaut" />
                <p class="inline-block copy-small-bold v-align-bottom">lose Kehlhaut</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Brust:</p>
            <div class="span-1">
                <p class="copy-small-bold v-align-top wrap-pre-line">
                    Tiefe:</p>
            </div>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->brust->zu_breit" />
                <p class="inline-block copy-small-bold v-align-bottom">zu breit</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->brust->breit" />
                <p class="inline-block copy-small-bold v-align-bottom">breit</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->brust->schmal" />
                <p class="inline-block copy-small-bold v-align-bottom">schmal</p>
            </div>
            <div class="span-9">
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->brust->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->brust->zu_tief" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu tief</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->brust->zu_wenig" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu wenig</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Vorbrust:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorbrust->wenig" />
                <p class="inline-block copy-small-bold v-align-bottom">wenig</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorbrust->gut" />
                <p class="inline-block copy-small-bold v-align-bottom">gut</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorbrust->ausgepraegt" />
                <p class="inline-block copy-small-bold v-align-bottom">ausgeprägt</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Lenden:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->lenden->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->lenden->kurz" />
                <p class="inline-block copy-small-bold v-align-bottom">kurz</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->lenden->lang" />
                <p class="inline-block copy-small-bold v-align-bottom">lang</p>
            </div>
            <div class="span-3 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->lenden->leicht_stark_aufgezogen" />
                <p class="inline-block copy-small-bold v-align-bottom">leicht – stark aufgezogen</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Rücken:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ruecken->gerade" />
                <p class="inline-block copy-small-bold v-align-bottom">gerade</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ruecken->senkruecken" />
                <p class="inline-block copy-small-bold v-align-bottom">Senkrücken</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ruecken->karpfenruecken" />
                <p class="inline-block copy-small-bold v-align-bottom">Karpfenrücken</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->ruecken->leicht_ueberbaut" />
                <p class="inline-block copy-small-bold v-align-bottom">leicht überbaut</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Kruppe:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kruppe->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->kruppe->abfallend" />
                <p class="inline-block copy-small-bold v-align-bottom">abfallend</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Rute:</p>
        </div>
        <div class="span-9 red">
            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->ansatz_gut" />
                    <p class="inline-block copy-small-bold v-align-bottom">Ansatz gut</p>
                </div>
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->zu_hoch" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu hoch</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->zu_tief" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu tief</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->zu_duenn" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu dünn</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->zu_lang" />
                    <p class="inline-block copy-small-bold v-align-bottom">zu lang</p>
                </div>
            </div>

            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->korrekt_getragen" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt getragen</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->leicht_gebogen" />
                    <p class="inline-block copy-small-bold v-align-bottom">leicht gebogen</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->knickrute" />
                    <p class="inline-block copy-small-bold v-align-bottom">Knickrute</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->rute->oberrute" />
                    <p class="inline-block copy-small-bold v-align-bottom">Oberrute</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top line-height-100">Knochestärke:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->knochenstaerke->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->knochenstaerke->zu_wenig" />
                <p class="inline-block copy-small-bold v-align-bottom">zu wenig</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->knochenstaerke->zu_stark" />
                <p class="inline-block copy-small-bold v-align-bottom">zu stark</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Vorderhand:</p>
            <div class="span-1">
                <p class="copy-small-bold v-align-top  wrap-pre-line">Läufe:

                    Schulter
                    Oberarm
                    Ellenbogen
                </p>
            </div>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorderhand->laeufe->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorderhand->laeufe->ungerade" />
                <p class="inline-block copy-small-bold v-align-bottom">ungerade</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorderhand->laeufe->zu_lang" />
                <p class="inline-block copy-small-bold v-align-bottom">zu lang</p>
            </div>
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->vorderhand->laeufe->zu_kurz" />
                <p class="inline-block copy-small-bold v-align-bottom">zu kurz</p>
            </div>
            <div class="span-9 inline-block v-align-middle yellow">
                <p class="inline-block copy-small-bold v-align-bottom">Sonstiges: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->vorderhand->laeufe->sonstiges != null || $formwertbeurteilung->beurteilung->vorderhand->laeufe->sonstiges != '' ? $formwertbeurteilung->beurteilung->vorderhand->laeufe->sonstiges : '–' }}</span>
                </p>
            </div>
            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->schulter->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->schulter->etwas_steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">etwas steil</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->schulter->steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">steil</p>
                </div>
            </div>
            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->oberarm->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->oberarm->etwas_steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">etwas steil</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->oberarm->steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">steil</p>
                </div>
            </div>
            <div class="span-9 red">
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->ellenbogen->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->ellenbogen->etwas_steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">etwas steil</p>
                </div>
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->vorderhand->ellenbogen->steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">steil</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Hinterhand:</p>
            <div class="span-1">
                <p class="copy-small-bold v-align-top wrap-pre-line">Läufe:
                    Winkelung:</p>
            </div>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hinterhand->laeufe->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-7 inline-block v-align-middle cyan">
                <p class="inline-block copy-small-bold v-align-bottom">Sonstiges: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->hinterhand->laeufe->sonstiges != null || $formwertbeurteilung->beurteilung->hinterhand->laeufe->sonstiges != '' ? $formwertbeurteilung->beurteilung->hinterhand->laeufe->sonstiges : '–' }}</span>
                </p>
            </div>
            <div class="span-9">
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->hinterhand->winkelung->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->hinterhand->winkelung->steil" />
                    <p class="inline-block copy-small-bold v-align-bottom">steil</p>
                </div>
                <div class="span-2 inline-block v-align-middle cyan">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->hinterhand->winkelung->ueberwinkelt" />
                    <p class="inline-block copy-small-bold v-align-bottom">überwinkelt</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-3 extended copy-bold v-align-top line-height-100">Pfoten:</p>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle green">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pfoten->rassetypisch" />
                <p class="inline-block copy-small-bold v-align-bottom">rassetypisch</p>
            </div>
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pfoten->gespreizt" />
                <p class="inline-block copy-small-bold v-align-bottom">gespreizt</p>
            </div>
            <div class="span-2 inline-block v-align-middle cyan">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->pfoten->maessig_geschlossen" />
                <p class="inline-block copy-small-bold v-align-bottom">mäßig geschlossen</p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="span-2 extended copy-bold v-align-top line-height-100">Gangwerk:</p>
            <div class="span-1">
                <p class="copy-small-bold v-align-top wrap-pre-line">Vorderhand:
                    Hinterhand:</p>
            </div>
        </div>
        <div class="span-9 red">
            <div class="span-2 inline-block v-align-middle blue">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->gangwerk->vorderhand->korrekt" />
                <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
            </div>
            <div class="span-7 inline-block v-align-middle cyan">
                <p class="inline-block copy-small-bold v-align-bottom">Sonstiges: <span
                        class="copy-small">{{ $formwertbeurteilung->beurteilung->gangwerk->vorderhand->sonstiges != null || $formwertbeurteilung->beurteilung->gangwerk->vorderhand->sonstiges != '' ? $formwertbeurteilung->beurteilung->gangwerk->vorderhand->sonstiges : '–' }}</span>
                </p>
            </div>
            <div class="span-9">
                <div class="span-2 inline-block v-align-middle green">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->gangwerk->hinterhand->korrekt" />
                    <p class="inline-block copy-small-bold v-align-bottom">korrekt</p>
                </div>
                <div class="span-2 inline-block v-align-middle blue">
                    <x-checkbox class="inline-block v-align-bottom"
                        :crossed="$formwertbeurteilung->beurteilung->gangwerk->hinterhand->kuhhessig" />
                    <p class="inline-block copy-small-bold v-align-bottom">kuhhessig</p>
                </div>
                <div class="span-5 inline-block v-align-middle cyan">
                    <p class="inline-block copy-small-bold v-align-bottom">Sonstiges: <span
                            class="copy-small">{{ $formwertbeurteilung->beurteilung->gangwerk->hinterhand->sonstiges != null || $formwertbeurteilung->beurteilung->gangwerk->hinterhand->sonstiges != '' ? $formwertbeurteilung->beurteilung->gangwerk->hinterhand->sonstiges : '–' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-break"></div>
@show

@section("Page 2")
<x-key-info jsonString='[
  [
    [[{ "Prüfungsort": "{{$formwertbeurteilung->pruefungsort}}" }, { "Prüfungsdatum": "{{$formwertbeurteilung->pruefungsdatum}}" }]],
    [[{ "Hundeführer": "{{$formwertbeurteilung->hundefuehrer}}" }, { "Startnummer": "{{$formwertbeurteilung->startnummer}}" }]]
  ],
  [
    [[{ "Name des Hundes": "{{$formwertbeurteilung->hund->name}}" }, { "Wurfdatum": "{{$formwertbeurteilung->hund->wurfdatum}}" }]],
    [[{ "Rasse": "{{$formwertbeurteilung->hund->rasse}}, Farbe: {{$formwertbeurteilung->hund->farbe}}" }, { "ZB-Nr.": "{{$formwertbeurteilung->hund->zuchtbuchnummer}}" }]],
    [[{ "Geschlecht": "{{$formwertbeurteilung->hund->geschlecht}}" }, { "Chipnummer": "{{$formwertbeurteilung->hund->chipnummer}}" }]]
  ]
]
' class="margin-b-x3" />

<div class="span-12 margin-b-x2">
    <span class="mg-headline">Beurteilung</span>
    <div class="mg-underline"></div>
</div>

<div class="line span-12 spaced-container">
    <div class="span-2 extended">
        <span class="copy-bold v-align-top">Behaarung:</span>
    </div>
    <div class="span-9">
        <div class="span-9">
            <div class="span-4 inline-block">
                <p class="inline-block copy-small v-align-bottom">
                    <span
                        class="copy-small-bold margin-r">Deckhaar:</span>{{ $formwertbeurteilung->beurteilung->behaarung->deckhaar[0] }}
                </p>
            </div>
            <div class="span-5 inline-block">
                <p class="inline-block copy-small v-align-bottom">
                    <span
                        class="copy-small-bold margin-r">Sonstiges:</span>{{ $formwertbeurteilung->beurteilung->behaarung->deckhaar[1] != null || $formwertbeurteilung->beurteilung->behaarung->deckhaar[1] != '' ? $formwertbeurteilung->beurteilung->behaarung->deckhaar[1] : '–' }}
                </p>
            </div>
        </div>
        <div class="span-9">
            <div class="span-4 inline-block">
                <p class="inline-block copy-small v-align-bottom">
                    <span
                        class="copy-small-bold margin-r">Unterwolle:</span>{{ $formwertbeurteilung->beurteilung->behaarung->unterwolle[0] }}
                </p>
            </div>
            <div class="span-5 inline-block">
                <p class="inline-block copy-small v-align-bottom">
                    <span
                        class="copy-small-bold margin-r">Sonstiges:</span>{{ $formwertbeurteilung->beurteilung->behaarung->unterwolle[1] != null || $formwertbeurteilung->beurteilung->behaarung->unterwolle[1] != '' ? $formwertbeurteilung->beurteilung->behaarung->unterwolle[1] : '–' }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="line spaced-container">
    <div class="span-12 inline-block">
        <div class="span-3 extended">
            <p class="copy-bold v-align-top">Geschlechtsgepräge:</p>
        </div>
        <div class="span-2 inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$formwertbeurteilung->beurteilung->geschlechtsgepraege->ruedenhaft" />
            <p class="inline-block copy-small-bold v-align-bottom">rüdenhaft</p>
        </div>
        <div class="space-h"></div>
        <div class="span-2 inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$formwertbeurteilung->beurteilung->geschlechtsgepraege->huendinnenhaft" />
            <p class="inline-block copy-small-bold v-align-bottom">hündinnenhaft</p>
        </div>
    </div>
</div>

@if ($formwertbeurteilung->hund->geschlecht == 'Rüde')
    <div class="line spaced-container">
        <div class="span-12 inline-block">
            <div class="span-3 extended">
                <p class="copy-bold v-align-top">Hoden:</p>
            </div>
            <div class="span-2 inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hoden->beide_tastbar" />
                <p class="inline-block copy-small-bold v-align-bottom">beide tastbar</p>
            </div>
            <div class="space-h"></div>
            <div class="span-2 inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hoden->einer_tastbar" />
                <p class="inline-block copy-small-bold v-align-bottom">einer tastbar</p>
            </div>
            <div class="space-h"></div>
            <div class="span-2 inline-block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->beurteilung->hoden->keiner_tastbar" />
                <p class="inline-block copy-small-bold v-align-bottom">keiner tastbar</p>
            </div>
        </div>
    </div>
@endif

<div class="line">
    <div class="span-3 extended red">
        <p class="copy-bold v-align-top">Kondition:</p>
    </div>
    <div class="span-9 inline-block green">
        <div class="span-2 inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$formwertbeurteilung->beurteilung->kondition->muskuloes" />
            <p class="inline-block copy-small-bold v-align-bottom">muskulös</p>
        </div>
        <div class="space-h"></div>
        <div class="span-2 inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$formwertbeurteilung->beurteilung->kondition->mager" />
            <p class="inline-block copy-small-bold v-align-bottom">mager</p>
        </div>
        <div class="space-h"></div>
        <div class="span-2 inline-block extended v-align-middle">
            <x-checkbox class="inline-block v-align-bottom"
                :crossed="$formwertbeurteilung->beurteilung->kondition->ueberfuettert" />
            <p class="inline-block copy-small-bold v-align-bottom">überfüttert</p>
        </div>
        <div class="span-9 block v-align-middle cyan">
            <p class="inline-block copy-small v-align-bottom"><span class="copy-small-bold">Sonstiges:
                </span>{{ $formwertbeurteilung->beurteilung->kondition->sonstiges != null || $formwertbeurteilung->beurteilung->kondition->sonstiges != '' ? $formwertbeurteilung->beurteilung->kondition->sonstiges : '–' }}
            </p>
        </div>
    </div>
</div>


<div class="span-12 margin-b-x2">
    <span class="mg-headline">Verhalten während der Formwertbeurteilung</span>
    <div class="mg-underline"></div>
</div>

<div class="line">
    <div class="span-12">
        <div class="span-4">
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->aufdringlich" />
                <p class="inline-block copy-small-bold v-align-bottom">Aufdringlich</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->freundlich" />
                <p class="inline-block copy-small-bold v-align-bottom">Freundlich</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->zutraulich" />
                <p class="inline-block copy-small-bold v-align-bottom">Zutraulich</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->spielfreudig" />
                <p class="inline-block copy-small-bold v-align-bottom">Spielfreudig</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->neutral" />
                <p class="inline-block copy-small-bold v-align-bottom">Neutral</p>
            </div>
        </div>
        <div class="span-4">
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->gelassen" />
                <p class="inline-block copy-small-bold v-align-bottom">Gelassen</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->zurueckhaltend" />
                <p class="inline-block copy-small-bold v-align-bottom">Zurückhaltend</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->ausweichend" />
                <p class="inline-block copy-small-bold v-align-bottom">Ausweichend</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->unterwuerfig" />
                <p class="inline-block copy-small-bold v-align-bottom">Unterwürfig</p>
            </div>
        </div>
        <div class="span-4">
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->aengstlich" />
                <p class="inline-block copy-small-bold v-align-bottom">Ängstlich</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->scheu" />
                <p class="inline-block copy-small-bold v-align-bottom">Scheu</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->unsicher" />
                <p class="inline-block copy-small-bold v-align-bottom">Unsicher</p>
            </div>
            <div class="block extended v-align-middle">
                <x-checkbox class="inline-block v-align-bottom"
                    :crossed="$formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->aggressiv" />
                <p class="inline-block copy-small-bold v-align-bottom">Aggressiv</p>
            </div>
        </div>
    </div>
    <div class="span-12 spaced-container">
        <p class="copy wrap-pre-line line-height-100">
            <span
                class="copy-bold margin-r line-height-100">{{'Weitere Anmerkungen zum Verhalten:'}}</span><!--
                 -->{{ $formwertbeurteilung->verhalten_waehrend_der_formwertbeurteilung->weitere_anmerkungen_zum_verhalten }}
        </p>
    </div>
</div>


<div class="span-12 margin-t-x3 margin-b-x2">
    <span class="mg-headline">Gesamtbeurteilung</span>
    <div class="mg-underline"></div>
</div>

<div class="span-12">
    <p class="copy wrap-pre-line line-height-100">{{ $formwertbeurteilung->gesamtbeurteilung }}
    </p>
</div>

<div class="pin-bottom border-t" style="margin-bottom: 20mm;">
    <div class="span-12 spaced-container margin-b-x4">
        @if ($formwertbeurteilung->breeding_allowed[0] == true)
            <p class="sectionheadline-bold">Der oben genannte Hund ist zur Zucht zugelassen,<br> wenn die übrigen
                Zuchtzulassungs-Voraussetzungen erfüllt sind.</p>
            <x-labeled-info labelText="Gesamterscheinung" :infoText="$formwertbeurteilung->breeding_allowed[1]" />
        @else
            <p class="sectionheadline-bold">Der oben genannte Hund ist zur Zucht nicht geeignet.</p>
            <x-labeled-info labelText="Begründung" :infoText="$formwertbeurteilung->breeding_allowed[1]" />
        @endif
    </div>

    <div class="span-12 margin-t-x4 padding-t-x4">
        <x-place-date-signature :date="$formwertbeurteilung->pruefungsdatum" :place="$formwertbeurteilung->pruefungsort" :signatureSubline="'Unterschrift ' . $formwertbeurteilung->richter . ' (Formwertrichter)'" />
    </div>
</div>
@show