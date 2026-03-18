<div class="" style="position: relative; clear: both;">
   <div class="label" style="float:left; width: 20%">{{ $label }}:</div>
   <div class="options" style="float:left; width: 80%;">
      @foreach ($items as $item)
      <?php $checked = false;
      foreach ($selected as $select) {
       if ($select->val == $item->id) $checked = true;
         } 
      ?>
         <x-checkbox :checked="$checked" :label="$item->name" />
      @endforeach
   </div>
</div>
<div class="" style="position: relative; clear: both;">
   <div style="float:left; width: 20%">&nbsp;</div>
   <div class="hilfe" style="float:left; width: 80%;">Mehrfachauswahl möglich.</div>
</div>