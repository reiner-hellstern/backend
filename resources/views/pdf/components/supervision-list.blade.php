<div class="line padding-t">
    @if (count($persons) === 1)
        <div class="span-6">
            <div class="line border-b">
                <span class="copy padding-r">{{ $persons[0]['vorname'] }}</span>
                <span class="copy">{{ $persons[0]['nachname'] }}</span>
            </div>
            <div class="line margin-b-x2 margin-t">
                <span class="amtstitel">{{ $persons[0]['amtstitel'] }}</span>
            </div>
            <div class="line">
                <span class="copy-small-bold padding-r">VR-Nr.:</span>
                <span class="copy-small underlined">{{ $persons[0]['vrnr'] }}</span>
            </div>
        </div>
    @else
        @for ($i = 0; $i < count($persons); $i++)
            @php
                $spanWidth = ("span-" . 12 / count($persons));
                $right = $i + 1 == count($persons) ? true : false;
            @endphp
            <div @class([
                    $spanWidth,
                    'right' => $right,
                    "inline-block"
                ])>
                <div class="line border-b">
                    <span class="copy padding-r">{{ $persons[$i]['vorname'] }}</span>
                    <span class="copy">{{ $persons[$i]['nachname'] }}</span>
                </div>
                <div class="line margin-b-x2 margin-t">
                    <span class="amtstitel">{{ $persons[$i]['amtstitel'] }}</span>
                </div>
                <div class="line">
                    <span class="copy-small-bold padding-r">VR-Nr.:</span>
                    <span class="copy-small underlined">{{ $persons[$i]['vrnr'] }}</span>
                </div>
            </div>
            @if ($i + 1 !== count($persons))
                <div class="space-h inline-block"></div>
            @endif
        @endfor
    @endif
</div>