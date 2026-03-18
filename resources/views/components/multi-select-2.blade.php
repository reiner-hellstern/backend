<div class="textarea" style="position: relative;  clear: both;">
   <div class="text">
      <x-schreiblinie />
   </div>
   <div class="text" style="position: absolute; top: 0; z-index: 1000;">
      <span class="label" style="background-color: #fff; height: 4.5mm;">{{ $label }}:&nbsp;&nbsp;</span>
      @foreach ($items as $item)
         {{ $item->label }}
         @if (!$loop->last),&nbsp;@endif
      @endforeach
   </div>
</div>