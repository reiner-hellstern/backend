<?php

namespace App\Http\Controllers\Utils;

use App\Models\Hund;
use App\Models\Person;

class RandomDBEntries
{
    public function __construct()
    {
        // Constructor code here
    }

    // function RandomPerson
    /* Use this for orientation
    function generateDummyData()
    {

        do {
            $randomZwinger = rand(1, 3836);
            $randomHunde = Models\Hund::where('zwinger_id', $randomZwinger)->get();
            $wurfId = $randomHunde->first()->wurf_id ?? null;
        } while (is_null($wurfId));

        $randomHunde = $randomHunde->filter(function ($hund) use ($wurfId) {
            return $hund->wurf_id == $wurfId;
        });

        $welpen = [];
        for ($i = 1; $i <= count($randomHunde); $i++) {
            $welpen[] = new dokumente\WurfabnahmeWelpe(
                (rand(0, 1) ? 'Rüde' : 'Hündin'),
                $randomHunde[$i - 1]->name,
                $randomHunde[$i - 1]->zuchtbuchnummer,
                $randomHunde[$i - 1]->chipnummer,
                $randomHunde[$i - 1]->farbe_name_access,
                '[X.XXX] g',
                '[X.XXX] g',
                'Augen ' . $i,
                'Gebiss ' . $i,
                'Zähne ' . $i,
                '++',
                'ZAF ' . $i,
                'Bemerkung ' . $i
            );
        }
        return $welpen;
    }

    $dummyData = generateDummyData();
    */

    /**
     * This function returns a random Person.
     *
     * @param  array  $cols  Optional columns to select
     * @return Person A random person from the database
     */
    public static function RandomPerson(array $cols = [])
    {

        $cols = array_filter($cols, function ($value) {
            return $value !== null;
        });

        $query = Person::query();

        foreach ($cols as $column => $value) {
            if ($value === 'notNull') {
                $query->whereNotNull($column);
            } elseif ($value === 'notEmpty') {
                $query->where($column, '!=', '')->where($column, '!=', ' ');
            } else {
                $query->where($column, $value);
            }
        }

        return $query->inRandomOrder()->first();
    }

    public static function RandomHund(array $cols = [])
    {

        $cols = array_filter($cols, function ($value) {
            return $value !== null;
        });

        $query = Hund::query();

        foreach ($cols as $column => $value) {
            if ($value === 'notNull') {
                $query->whereNotNull($column);
            } elseif ($value === 'notEmpty') {
                $query->where($column, '!=', '')->where($column, '!=', ' ');
            } else {
                $query->where($column, $value);
            }
        }

        return $query->inRandomOrder()->first();
    }
}
