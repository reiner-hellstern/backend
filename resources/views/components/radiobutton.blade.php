<div class="textarea" style="position: relative; overflow: hidden;">
@if ( $checked == true || $checked == 'true' || $checked == 1 )
<div style="display: inline-block; width: 2.25mm; height: 2.25mm; border: 0.25pt solid #4a4a4a; background-color: #4a4a4a; margin-right: 2mm; border-radius: 50%;">
   <div style="width: 1.7mm; height: 1.7mm; background-color: #4a4a4a; border-radius: 50%;"></div>
</div>{{ $label }}<br />
@else 
<div style="display: inline-block; width: 2.25mm; height: 2.25mm; border: 0.25pt solid #4a4a4a; margin-right: 2mm; border-radius: 50%;"></div>{{ $label }}
@endif
</div>