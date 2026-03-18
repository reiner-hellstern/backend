<page size="A4">
   <div style="position: absolute; top: 102.5mm; left: 10mm; width: 5mm; height: 5mm; border: 0.25mm solid #ccc; border-radius: 50%;"></div>
   <div style="position: absolute; top: 182.5mm; left: 10mm; width: 5mm; height: 5mm; border: 0.25mm solid #ccc; border-radius: 50%;"></div>
   <div style="position: relative; background: #eee; width: 178mm; height: 22mm; padding: 0cm 10mm 0cm 22mm;">
   </div>
   <div style="padding: 0cm 10mm 0cm 22mm; height: 260mm; z-index: 1000;">
      {{ $slot }}
   </div>
   
   <div style="background: #eee; height: 15mm; padding: 0cm 10mm 0cm 22mm; width: 178mm; position: fixed;">
      <span style="float:left; font-size: 9pt;"><?php echo date('d.m.Y', time()); ?></span>
      <span style="float:right; font-size: 9pt;">Seite <span class="pagenum"></span>/ {{ $seiten }}</span>
   </div>
</page>