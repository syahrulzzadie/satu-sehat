<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

class StrHelper
{
    public static function getIhsNumber($reference)
    {
        $reference = explode('/',$reference);
        return $reference[1];
    }

    public static function cleanNoRawat($noRawat)
    {
        return str_replace('/','',$noRawat);
    }

    public static function dateTimeId($dateTime)
    {
        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $bulan = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        $months = [
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ];
        $date = date('D, Y M d',strtotime($dateTime));
        $date = str_replace($months,$bulan,$date);
        return str_replace($days,$hari,$date);
    }
}