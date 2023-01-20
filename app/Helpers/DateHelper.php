<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getTanggal($param)
    {
        $value = Carbon::parse($param)->translatedFormat('d F Y');
        return $value;
    }

    public static function timeHuman($param)
    {
        $value = Carbon::parse($param)->diffForHumans();
        return $value;
    }

    public static function getMonthYear($param)
    {
        $value = Carbon::parse($param)->translatedFormat('F Y');
        return $value;
    }

    public static function getDayMonth($param)
    {
        $value = Carbon::parse($param)->translatedFormat('d F');
        return $value;
    }

    public static function getDayOnly($param)
    {
        $value = Carbon::parse($param)->translatedFormat('d');
        return $value;
    }

    public static function getMonthOnly($param)
    {
        $value = Carbon::parse($param)->translatedFormat('F');
        return $value;
    }

    public static function getHoursMinute($param)
    {
        $value = Carbon::parse($param)->translatedFormat('d F Y  H:i');
        return $value;
    }

    public static function getDay($param)
    {
        $value = Carbon::parse($param)->translatedFormat('l, d F Y');
        return $value;
    }

    public static function getHariOnly($param)
    {
        $value = Carbon::parse($param)->translatedFormat('l');
        return $value;
    }

    public static function getTanggalLengkap($param)
    {
        $value = Carbon::parse($param)->translatedFormat('l, d F Y  H:i');
        return $value;
    }

    public static function getTime($param)
    {
        $value = Carbon::parse($param)->translatedFormat('H:i:s');
        return $value;
    }
}
