<body>
    <div class="left">
        <?php $date = date("d.m.Y") ?>
        <x-labeled-info labelText="Wurfdatum" infoText="{{ $date }}" />
    </div>
    <div class="right">
        <x-labeled-info labelText="Geschlecht" infoText="Rüde" />
    </div>
</body>