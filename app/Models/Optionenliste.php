<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optionenliste extends Model
{
    use HasFactory;

    protected $table = 'optionenlisten';

    protected $guarded = [];

    protected $appends = ['eintraege_count'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getEintraegeCountAttribute()
    {
        if (! $this->model) {
            return 0;
        }

        // Dynamisch die Anzahl der Einträge aus der entsprechenden Tabelle holen
        try {
            $modelClass = $this->model;
            if (class_exists($modelClass)) {
                return $modelClass::count();
            }
        } catch (\Exception $e) {
            // Fallback: Direkt über DB-Query
            $tableName = 'optionen_' . strtolower(class_basename($this->model));

            return \DB::table($tableName)->count();
        }

        return 0;
    }
}
