<?php

namespace App\Traits;

use App\Models\Zwinger;

trait SaveZwinger
{
    public function saveZwinger($zwinger)
    {

        if ($zwinger['id'] > 0) {
            return $zwinger['id'];
        } else {
            $db_zwinger = Zwinger::where('name', $zwinger['name'])
                ->where('strasse', $zwinger['strasse'])
                ->where('postleitzahl', $zwinger['postleitzahl'])
                ->where('ort', $zwinger['ort'])
                ->where('fcinummer', $zwinger['fcinummer'])
                ->first();
            if ($db_zwinger == null) {
                $new_zwinger = new Zwinger();
                $new_zwinger->name = $zwinger['name'];
                $new_zwinger->fcinummer = $zwinger['fcinummer'];
                $new_zwinger->strasse = $zwinger['strasse'];
                $new_zwinger->postleitzahl = $zwinger['postleitzahl'];
                $new_zwinger->ort = $zwinger['ort'];
                $new_zwinger->adresszusatz = $zwinger['adresszusatz'];
                $new_zwinger->land = $zwinger['land'];
                $new_zwinger->telefon_1 = $zwinger['telefon_1'];
                $new_zwinger->telefon_2 = $zwinger['telefon_2'];
                $new_zwinger->email_1 = $zwinger['email_1'];
                $new_zwinger->email_2 = $zwinger['email_2'];
                $new_zwinger->website_1 = $zwinger['website_1'];
                $new_zwinger->website_2 = $zwinger['website_2'];
                $new_zwinger->save();

                return $new_zwinger->id;
            }

            return $db_zwinger->id;
        }
    }
}
