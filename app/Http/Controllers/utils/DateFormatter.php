<?php

namespace App\Http\Controllers\Utils;

use DateTime;

class DateFormatter
{
    /**
     * Format a given date string to a specified format.
     *
     * @param  string  $date
     * @param  string  $format
     * @return string
     */
    public static function formatDMY($date, $format = 'd.m.Y')
    {
        $dateTime = new DateTime($date);

        return $dateTime->format($format);
    }
}
