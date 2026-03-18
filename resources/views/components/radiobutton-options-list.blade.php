<div class="" style="position: relative; clear: both;">
   <div class="label" style="float:left; width: 20%">{{ $label }}:</div>
   <div style="float:left; width: 80%;">
   @foreach ($items as $item)
      <x-radiobutton :checked="false" :label="$item->name" />
   @endforeach
</div>
</div>
<div class="" style="position: relative; clear: both;">
   <div style="float:left; width: 20%"></div>
   <div class="hilfe" style="float:left; width: 80%;">Bitte nur eine Antwort auswählen.</div>
</div>