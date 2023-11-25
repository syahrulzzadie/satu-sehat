<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class DateTimeFormat
{
    public static function now()
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        return $date.'T'.$time.'+07:00';
    }

    public static function dateNow()
    {
        return date('Y-m-d');
    }

    public static function parse($dateTime)
    {
        $date = date('Y-m-d',strtotime($dateTime));
        $time = date('H:i:s',strtotime($dateTime));
        return $date.'T'.$time.'+07:00';
    }

    public static function dateParse($dateTime)
    {
        return date('Y-m-d');
    }

    public static function parseDateAndTime($date,$time)
    {
        $date = date('Y-m-d',strtotime($date));
        $time = date('H:i:s',strtotime($time));
        return $date.'T'.$time.'+07:00';
    }
}