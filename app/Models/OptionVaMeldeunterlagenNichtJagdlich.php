<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionVaMeldeunterlagenNichtJagdlich extends Model
{
    use HasFactory;

    protected $table = 'optionen_va_meldeunterlagen_nicht_jagdlich';

    public function veranstaltungen()
    {
        return $this->hasMany(Veranstaltungen::class);
    }
}
