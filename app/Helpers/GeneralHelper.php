<?php

namespace App\Helpers;

class GeneralHelper
{
    public static function getInital($param)
    {
        $firstLetter = substr($param, 0, 1);
        $middleLetter = substr($param, strlen($param) / 2, 1);
        $lastLetter = substr($param, -1);
        return strtoupper($firstLetter . $middleLetter . $lastLetter);
    }

    public static function codeInitial($param)
    {
        $code = substr($param, 0, 1);
        return strtoupper($code);
    }
}
