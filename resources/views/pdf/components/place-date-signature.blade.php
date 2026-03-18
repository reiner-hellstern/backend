@props(['place' => null, 'date' => date('d.m.Y'), 'name' => null, 'nameSubline' => 'Eigentümer', 'signatureSubline' => 'Unterschrift des Eigentümers'])
<div class="span-12">
    <div class="span-6 left"> <!-- DO NOT REMOVE COMMENTS!! Needed for layout -->
        <p class="border-b wrap-pre-line"><!--
                -->{{ $place ?? '' }}<!--
                -->{{ $place != null ? ', den ' . $date : '' }}
        </p>
        <p class="amtstitel">Ort, Datum</p>
    </div>
    <div class="span-6 right">
        <p class="border-b wrap-pre-line"><!--
                -->{{ $name ?? '' }}
        </p>
        <p class="amtstitel">
            {{ $name != null ? $nameSubline : $signatureSubline }}
        </p>
    </div>
</div>