<?php

namespace App\Traits;

use App\Models\Labor;

trait SaveLabor
{
    public function saveLabor($labor)
    {

        if ($labor['id'] > 0) {
            return $labor['id'];
        } else {
            $db_labor = Labor::where('name', $labor['name'])
                ->where('strasse', $labor['strasse'])
                ->where('postleitzahl', $labor['postleitzahl'])
                ->where('ort', $labor['ort'])
                ->first();
            if ($db_labor == null) {
                $new_labor = new Labor();
                $new_labor->name = $labor['name'];
                $new_labor->strasse = $labor['strasse'];
                $new_labor->postleitzahl = $labor['postleitzahl'];
                $new_labor->ort = $labor['ort'];
                $new_labor->adresszusatz = $labor['adresszusatz'];
                $new_labor->land = $labor['land'];
                $new_labor->telefon_1 = $labor['telefon_1'];
                $new_labor->telefon_2 = $labor['telefon_2'];
                $new_labor->email_1 = $labor['email_1'];
                $new_labor->email_2 = $labor['email_2'];
                $new_labor->website = $labor['website'];
                $new_labor->save();

                return $new_labor->id;
            }

            return $db_labor->id;
        }
    }
}
