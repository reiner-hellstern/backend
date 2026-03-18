@use('App\Utilities\Math')

<div {{ $attributes }}>
    @foreach ($blocks as $block)
        <div class="border-b padding-b">
            @foreach ($block as $lines)
                <div class="line">
                    @foreach ($lines as $sides)
                        @foreach ($sides as $side => $entries)
                            <div class="span-{{$side === 0 ? "7" : "5"}}">
                                <x-labeled-info labelText={{key($entries)}} infoText={{current($entries)}} />
                            </div>
                            @if ($side === 0)
                                <div class="space-h"></div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>

{{--<div {{ $attributes }}>
    @foreach ($blocks as $block)
    <div class="spaced-container">
        @foreach ($block as $lines)
        <div class="row">
            @foreach ($lines as $sides)
            @foreach ($sides as $side => $entries)
            <div class="span-{{$side === 0 ? " 7" : "5" }}">
                <x-labeled-info labelText={{key($entries)}} infoText={{current($entries)}}></x-labeled-info>
            </div>
            @if ($side === 0)
            <div class="space-h"></div>
            @endif
            @endforeach
            @endforeach
        </div>
        @endforeach
    </div>
    @endforeach
</div>--}}