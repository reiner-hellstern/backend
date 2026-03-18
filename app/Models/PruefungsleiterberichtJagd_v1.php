<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruefungsleiterberichtJagd_v1 extends Model
{
    use HasFactory;

    protected $table = 'pruefungsleiterberichte_jagd_v1';

    protected $appends = ['wetter', 'bodenzustand', 'wind', 'wildvorkommen_haarwild', 'wildvorkommen_federwild', 'pruefungsgelaende', 'faehrte', 'wildarten'];

    public function veranstaltung()
    {
        return $this->belongsTo(Veranstaltung::class);
    }

    public function wetter_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Wetter::class, 'wetter_id');
    }

    public function getWetterAttribute()
    {
        return $this->wetter_id ? ['name' => $this->wetter_option->name, 'id' => $this->wetter_id, 'wert' => $this->wetter_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function bodenzustand_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Bodenzustand::class, 'bodenzustand_id');
    }

    public function getBodenzustandAttribute()
    {
        return $this->bodenzustand_id ? ['name' => $this->bodenzustand_option->name, 'id' => $this->bodenzustand_id, 'wert' => $this->bodenzustand_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wind_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Wind::class, 'wind_id');
    }

    public function getWindAttribute()
    {
        return $this->wind_id ? ['name' => $this->wind_option->name, 'id' => $this->wind_id, 'wert' => $this->wind_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wildvorkommen_haarwild_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Haarwild::class, 'wildvorkommen_haarwild_id');
    }

    public function getWildvorkommenHaarwildAttribute()
    {
        return $this->wildvorkommen_haarwild_id ? ['name' => $this->wildvorkommen_haarwild_option->name, 'id' => $this->wildvorkommen_haarwild_id, 'wert' => $this->wildvorkommen_haarwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wildvorkommen_federwild_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Federwild::class, 'wildvorkommen_federwild_id');
    }

    public function getWildvorkommenFederwildAttribute()
    {
        return $this->wildvorkommen_federwild_id ? ['name' => $this->wildvorkommen_federwild_option->name, 'id' => $this->wildvorkommen_federwild_id, 'wert' => $this->wildvorkommen_federwild_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function pruefungsgelaende_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Pruefungsgelaende::class, 'pruefungsgelaende_id');
    }

    public function getPruefungsgelaendeAttribute()
    {
        return $this->pruefungsgelaende_id ? ['name' => $this->pruefungsgelaende_option->name, 'id' => $this->pruefungsgelaende_id, 'wert' => $this->pruefungsgelaende_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function faehrte_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Faehrte::class, 'faehrte_id');
    }

    public function getFaehrteAttribute()
    {
        return $this->faehrte_id ? ['name' => $this->faehrte_option->name, 'id' => $this->faehrte_id, 'wert' => $this->faehrte_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }

    public function wildarten_option()
    {
        return $this->belongsTo(OptionPruefungsleiterberichtJagdlich1Wildarten::class, 'wildarten_id');
    }

    public function getWildartenAttribute()
    {
        return $this->wildarten_id ? ['name' => $this->wildarten_option->name, 'id' => $this->wildarten_id, 'wert' => $this->wildarten_option->wert] : ['wert' => 0, 'name' => 'Bitte auswählen', 'id' => 0];
    }
}
