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

    public static function getName($name)
    {
        if (strlen($name) >= 4) {
            return ucwords(strtolower($name));
        }
        return strtoupper($name);
    }

    public static function getTtv($name,$value)
    {
        $name = strtolower($name);
        if ($name == 'body_temperature') {
            return [
                'code_ttv' => '8310-5',
                'name_ttv' => 'Body temperature',
                'value' => intval($value),
                'unit' => 'celcius',
                'code' => 'C'
            ];
        } else if($name == 'heart_rate') {
            return [
                'code_ttv' => '8867-4',
                'name_ttv' => 'Heart rate',
                'value' => intval($value),
                'unit' => 'beats/minute',
                'code' => '/min'
            ];
        } else if($name == 'systolic_blood_pressure') {
            return [
                'code_ttv' => '8480-6',
                'name_ttv' => 'Systolic blood pressure',
                'value' => intval($value),
                'unit' => 'mmHg',
                'code' => 'mmHg'
            ];
        } else if($name == 'diastolic_blood_pressure') {
            return [
                'code_ttv' => '8462-4',
                'name_ttv' => 'Diastolic blood pressure',
                'value' => intval($value),
                'unit' => 'mmHg',
                'code' => 'mmHg'
            ];
        } else if($name == 'respiratory_rate') {
            return [
                'code_ttv' => '9279-1',
                'name_ttv' => 'Respiratory rate',
                'value' => intval($value),
                'unit' => 'breaths/minute',
                'code' => '/min'
            ];
        } else if($name == 'oxygen_saturation') {
            return [
                'code_ttv' => '59408-5',
                'name_ttv' => 'Oxygen saturation',
                'value' => intval($value),
                'unit' => '%',
                'code' => '%'
            ];
        } else if($name == 'body_height') {
            return [
                'code_ttv' => '8302-2',
                'name_ttv' => 'Body height',
                'value' => intval($value),
                'unit' => 'cm',
                'code' => 'cm'
            ];
        } else if($name == 'body_weight') {
            return [
                'code_ttv' => '29463-7',
                'name_ttv' => 'Body weight',
                'value' => intval($value),
                'unit' => 'kg',
                'code' => 'kg'
            ];
        } else {
            return [
                'code_ttv' => 'null',
                'name_ttv' => 'null',
                'value' => 0,
                'unit' => 'null',
                'code' => 'null'
            ];
        }
    }
}