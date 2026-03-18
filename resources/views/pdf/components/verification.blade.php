@props(['text'])
<div class="line">
    <div class="span-12 margin-t margin-b position-relative">
        <x-checkbox style="position: absolute; top: 1mm;" checked="{{ $checked }}" />
        <div class="span-11 lime line-height-100" style="margin-left: 4mm;">
            <p class="copy cyan line-height-100 v-align-middle">
                {{ $text }}
            </p>
        </div>
    </div>
</div>