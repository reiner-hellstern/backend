<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Bestaetigung extends Model
{
    use Uuid;

    protected $table = 'bestaetigungen';

    protected $with = ['dokumente'];

    protected $fillable = ['uuid', 'bestaetigungable_id', 'bestaetigungable_type', 'person_id', 'bestaetigt', 'abgelehnt'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function bestaetigungable()
    {
        return $this->morphTo();
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
