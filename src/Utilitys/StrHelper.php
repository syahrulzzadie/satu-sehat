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
        $date = date('D, d M Y',strtotime($dateTime));
        $date = str_replace($months,$bulan,$date);
        return str_replace($days,$hari,$date);
    }

    /**
     * Kelas kunjungan Encounter: AMB (rawat jalan), EMER (IGD), IMP (rawat inap).
     */
    public static function encounterClass($classCode = 'AMB')
    {
        $classes = [
            'AMB' => 'ambulatory',
            'EMER' => 'emergency',
            'IMP' => 'inpatient encounter'
        ];
        $classCode = strtoupper($classCode ?? 'AMB');
        if (!isset($classes[$classCode])) {
            $classCode = 'AMB';
        }
        return [
            "system"=> "http://terminology.hl7.org/CodeSystem/v3-ActCode",
            "code"=> $classCode,
            "display"=> $classes[$classCode]
        ];
    }

    /**
     * Tebak jenis spesimen (SNOMED CT) dari nama LOINC pemeriksaan lab.
     * Default: Blood specimen.
     */
    public static function getSpecimenType($loincName)
    {
        $name = strtolower($loincName ?? '');
        $types = [
            'urine' => ['122575003', 'Urine specimen'],
            'stool' => ['119339001', 'Stool specimen'],
            'feces' => ['119339001', 'Stool specimen'],
            'sputum' => ['119334006', 'Sputum specimen'],
            'cerebral spinal fluid' => ['258450006', 'Cerebrospinal fluid sample'],
            'synovial fluid' => ['119332005', 'Synovial fluid specimen'],
            'pleural fluid' => ['418564007', 'Pleural fluid specimen'],
            'peritoneal fluid' => ['168139001', 'Peritoneal fluid sample'],
            'semen' => ['119347001', 'Seminal fluid specimen'],
            'serum' => ['119364003', 'Serum specimen'],
            'plasma' => ['119361006', 'Plasma specimen']
        ];
        foreach ($types as $keyword => $type) {
            if (str_contains($name, $keyword)) {
                // "Serum or Plasma" pada LOINC berarti darah vena
                if (str_contains($name, 'serum or plasma')) {
                    break;
                }
                return ['code' => $type[0], 'name' => $type[1]];
            }
        }
        return ['code' => '119297000', 'name' => 'Blood specimen'];
    }

    public static function getName($name)
    {
        if (strlen($name) >= 4) {
            return ucwords(strtolower($name));
        }
        return strtoupper($name);
    }

    private static function doubleVal($str)
    {
        $str = strtolower($str);
        $str = str_replace(',','.',$str);
        return doubleval($str);
    }

    public static function getTtv($name,$value)
    {
        $name = strtolower($name);
        if ($name == 'body_temperature') {
            return [
                'code_ttv' => '8310-5',
                'name_ttv' => 'Body temperature',
                'value' => self::doubleVal($value),
                'unit' => 'celcius',
                'code' => 'Cel',
                'order' => 1
            ];
        } else if($name == 'heart_rate') {
            return [
                'code_ttv' => '8867-4',
                'name_ttv' => 'Heart rate',
                'value' => self::doubleVal($value),
                'unit' => 'beats/minute',
                'code' => '/min',
                'order' => 2
            ];
        } else if($name == 'systolic_blood_pressure') {
            return [
                'code_ttv' => '8480-6',
                'name_ttv' => 'Systolic blood pressure',
                'value' => self::doubleVal($value),
                'unit' => 'mmHg',
                'code' => 'mm[Hg]',
                'order' => 3
            ];
        } else if($name == 'diastolic_blood_pressure') {
            return [
                'code_ttv' => '8462-4',
                'name_ttv' => 'Diastolic blood pressure',
                'value' => self::doubleVal($value),
                'unit' => 'mmHg',
                'code' => 'mm[Hg]',
                'order' => 4
            ];
        } else if($name == 'respiratory_rate') {
            return [
                'code_ttv' => '9279-1',
                'name_ttv' => 'Respiratory rate',
                'value' => self::doubleVal($value),
                'unit' => 'breaths/minute',
                'code' => '/min',
                'order' => 5
            ];
        } else if($name == 'oxygen_saturation') {
            return [
                'code_ttv' => '59408-5',
                'name_ttv' => 'Oxygen saturation',
                'value' => self::doubleVal($value),
                'unit' => '%',
                'code' => '%',
                'order' => 6
            ];
        } else if($name == 'body_height') {
            return [
                'code_ttv' => '8302-2',
                'name_ttv' => 'Body height',
                'value' => self::doubleVal($value),
                'unit' => 'cm',
                'code' => 'cm',
                'order' => 7
            ];
        } else if($name == 'body_weight') {
            return [
                'code_ttv' => '29463-7',
                'name_ttv' => 'Body weight',
                'value' => self::doubleVal($value),
                'unit' => 'kg',
                'code' => 'kg',
                'order' => 8
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