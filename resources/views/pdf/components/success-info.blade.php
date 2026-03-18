<div class="spaced-container padding-b-x2">
    <div class="span-12">
        <div class="line">
            <span class="sectionheadline-bold">
                @if ($didSucceed === true)
                    Prüfung bestanden.
                @else
                    Prüfung nicht bestanden.
                @endif
            </span>
        </div>
        <div class="line">
            @if ($didSucceed === true)
                @if ($sumOfCredits != null)
                    <x-labeled-info labelText="Gesamtpunkte" infoText="{{ $sumOfCredits }}" />
                @endif

                @if ($rating != null || $rating != '')
                    <div class="line">
                        <x-labeled-info labelText="Gesamturteil" infoText="{{ $rating }}" />
                    </div>
                @endif
            @else
                <x-labeled-info underlined={{ false }} labelText="Begründung" infoText="{{ $reasoning }}" />
                @if ($overallGrade != null)
                    <div class="line">
                        <x-labeled-info labelText="Gesamtprädikat" infoText="{{ $overallGrade }}" />
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
