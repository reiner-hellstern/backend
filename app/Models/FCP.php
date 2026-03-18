<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCP extends Model
{
    use HasFactory;

    protected $table = 'fcp';

    protected function datum(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value !== '0000-00-00' && $value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('d.m.Y') : '',
            set: fn ($value) => ($value !== '' && ! is_null($value)) ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    public function arzt()
    {
        return $this->belongsTo(Arzt::class, 'arzt_id');
    }

    public function operationsgrund()
    {
        return $this->belongsTo(OptionFcpGrund::class, 'grund_operation_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }
}
