<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDScoringSV extends Model
{
    use HasFactory;

    protected $table = 'hd_scorings_sv';

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function hd_score_option()
    {
        return $this->belongsTo(OptionHDScoringSV::class, 'hd_id');
    }

    public function getHDScoreAttribute()
    {
        return $this->hd_id ? ['name' => $this->hd_score_option->name, 'id' => $this->hd_score_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hdl_score_option()
    {
        return $this->belongsTo(OptionHDScoringSV::class, 'hd_l_id');
    }

    public function getHDLScoreAttribute()
    {
        return $this->hd_l_id ? ['name' => $this->hdl_score_option->name, 'id' => $this->hd_l_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }

    public function hdr_score_option()
    {
        return $this->belongsTo(OptionHDScoringSV::class, 'hd_r_id');
    }

    public function getHDRScoreAttribute()
    {
        return $this->hd_r_id ? ['name' => $this->hdr_score_option->name, 'id' => $this->hd_r_id] : ['name' => 'Bitte auswählen', 'id' => 0];
    }
}
