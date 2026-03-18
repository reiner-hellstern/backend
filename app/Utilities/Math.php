<?php

namespace App\Utilities;

class Math
{
    public static function isEven($number)
    {
        return $number % 2 === 0;
    }

    public static function isOdd($number)
    {
        return $number % 2 !== 0;
    }
}
