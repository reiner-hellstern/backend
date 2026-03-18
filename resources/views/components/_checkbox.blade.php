<div class="checkbox" style="position: relative; overflow: hidden;">
   @if ( $checked == true || $checked == 'true' || $checked == 1 )
   <div style="display: inline-block; width: 2.25mm; height: 2.25mm; border: 0.25pt solid #4a4a4a; background-color: #4a4a4a;  margin-right: 2mm;">
   </div>{{ $label }}<br />
   @else
   <div style="display: inline-block; width: 2.25mm; height: 2.25mm; border: 0.25pt solid #4a4a4a; margin-right: 2mm;"></div>{{ $label }}
   @endif
</div>