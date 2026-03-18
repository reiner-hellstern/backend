<?php

namespace App\Traits;

use App\Models\Arzt;

trait SaveArzt
{
    public function saveArzt($arzt)
    {

        if ($arzt['id'] > 0) {
            return $arzt['id'];
        } else {
            $db_arzt = Arzt::where('nachname', $arzt['nachname'])
                ->where('vorname', $arzt['vorname'])
                ->where('strasse', $arzt['strasse'])
                ->where('postleitzahl', $arzt['postleitzahl'])
                ->where('ort', $arzt['ort'])
                ->where('praxisname', $arzt['praxisname'])
                ->first();
            if ($db_arzt == null) {
                $new_arzt = new Arzt();
                $new_arzt->praxisname = $arzt['praxisname'];
                $new_arzt->nachname = $arzt['nachname'];
                $new_arzt->vorname = $arzt['vorname'];
                $new_arzt->strasse = $arzt['strasse'];
                $new_arzt->postleitzahl = $arzt['postleitzahl'];
                $new_arzt->ort = $arzt['ort'];
                $new_arzt->adresszusatz = $arzt['adresszusatz'];
                $new_arzt->land = $arzt['land'];
                $new_arzt->telefon_1 = $arzt['telefon_1'];
                $new_arzt->telefon_2 = $arzt['telefon_2'];
                $new_arzt->email_1 = $arzt['email_1'];
                $new_arzt->email_2 = $arzt['email_2'];
                $new_arzt->website_1 = $arzt['website_1'];
                $new_arzt->website_2 = $arzt['website_2'];
                $new_arzt->save();

                return $new_arzt->id;
            }

            return $db_arzt->id;
        }
    }
}
